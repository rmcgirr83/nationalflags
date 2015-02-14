<?php
/**
*
* @package National Flags
* @copyright (c) 2015 Rich McGirr (RMcGirr83)
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace rmcgirr83\nationalflags\acp;

class nationalflags_module
{

	public	$u_action;

	public function main($id, $mode)
	{
		global $user;

		$this->tpl_name = 'acp_flags';
		$this->page_title = 'ACP_FLAGS';
		$form_key = 'acp_flags';
		add_form_key($form_key);

		switch ($mode)
		{
			case 'flags':
				$title = 'ACP_FLAGS';
				$this->page_title = $user->lang[$title];

				$this->flags();
			break;

			case 'config':
			default:
				$title = 'ACP_FLAG_SETTINGS';
				$this->page_title = $user->lang[$title];

				$this->config();
			break;
		}
	}

	function flags()
	{
		global $cache, $db, $request, $user, $phpbb_container, $table_prefix;
		global $template, $phpbb_root_path, $phpEx;

		$flags_table = $table_prefix . 'flags';
		$flags_dir = '../ext/rmcgirr83/nationalflags/flags/';

		$submit = $request->is_set_post('submit');
		$action = $request->variable('action', '');
		$flag_id = $request->variable('id', 0);

		if ($request->is_set_post('add'))
		{
			$action = 'add';
		}
		switch ($action)
		{
			case 'delete':
				$mode = 'flags';

				if (confirm_box(true))
				{
					// Grab the flag name for the log...
					$sql = 'SELECT flag_name
						FROM ' . $flags_table . '
						WHERE flag_id = ' .(int) $flag_id;
					$result = $db->sql_query($sql);
					$flag_name = $db->sql_fetchfield('flag_name');
					$db->sql_freeresult($result);

					// Delete the flag...
					$sql = 'DELETE FROM ' . $flags_table . '
						WHERE flag_id = ' . (int) $flag_id;
					$db->sql_query($sql);

					// Reset the flag for users
					$sql = 'UPDATE ' . USERS_TABLE . '
						SET user_flag = 0
						WHERE user_flag = ' . (int) $flag_id;
					$db->sql_query($sql);

					$log = $phpbb_container->get('log');
					$log->add('admin', $user->data['user_id'], $user->ip, 'LOG_FLAGS_DELETED', time(), array($flag_name));

					$cache->destroy('_user_flags');

					trigger_error($user->lang['MSG_FLAGS_DELETED'] . adm_back_link($this->u_action));
				}
				else
				{
					// display a count of users who have this flag
					$sql = 'SELECT COUNT(user_flag) AS flag_count
						FROM ' . USERS_TABLE . '
						WHERE user_flag = ' . (int) $flag_id;
					$result = $db->sql_query($sql);
					$row = $db->sql_fetchrow($result);
					$db->sql_freeresult($result);

					$message = $user->lang['MSG_CONFIRM'];
					if (!empty($row['flag_count']))
					{
						$message .= $row['flag_count'] <> 1 ? sprintf($user->lang['MSG_FLAGS_CONFIRM_DELETE'], $row['flag_count']) : sprintf($user->lang['MSG_FLAG_CONFIRM_DELETE'], $row['flag_count']);
					}
					confirm_box(false, $message, build_hidden_fields(array(
						'id'		=> (int) $flag_id,
						'mode'		=> $mode,
						'action'	=> $action))
					);
				}
			break;

			case 'edit':
				$error = array();
				if ($submit)
				{
					if (!check_form_key('acp_flags'))
					{
						$error[] = 'FORM_INVALID';
					}
					$flag_row = array(
						'flag_name'			=> utf8_normalize_nfc($request->variable('flag_name', '', true)),
						'flag_image'		=> $request->variable('flag_img', ''),
					);

					if (empty($flag_row['flag_name']))
					{
						$error[] = $user->lang['FLAG_ERROR_NO_FLAG_NAME'];
					}

					if (!sizeof($error))
					{
						$sql = 'UPDATE ' . $flags_table . '
							SET ' . $db->sql_build_array('UPDATE', $flag_row) . '
							WHERE flag_id = ' . (int) $flag_id;
						$db->sql_query($sql);

						$log = $phpbb_container->get('log');
						$log->add('admin', $user->data['user_id'], $user->ip, 'LOG_FLAG_EDIT', time(), array($flag_row['flag_name']));

						$cache->destroy('_user_flags');

						trigger_error($user->lang['MSG_FLAG_EDITED'] . adm_back_link($this->u_action));
					}
				}

				$sql = 'SELECT flag_id, flag_name, flag_image
					FROM ' . $flags_table . '
					WHERE flag_id =' . (int) $flag_id;
				$result = $db->sql_query($sql);
				$flag_row = $db->sql_fetchrow($result);
				$db->sql_freeresult($result);

				if (!$flag_row)
				{
					trigger_error($user->lang['FLAG_ERROR_NOT_EXIST'] . adm_back_link($this->u_action . "&amp;id=$flag_id&amp;action=$action"), E_USER_WARNING);
				}

				$template->assign_vars(array(
					'L_TITLE'		=> $user->lang['FLAG_EDIT'],
					'U_ACTION'		=> $this->u_action . "&amp;id=$flag_id&amp;action=$action",

					'ERROR_MSG'		=> (sizeof($error)) ? implode('<br />', $error) : '',

					'FLAG_NAME'		=> $flag_row['flag_name'],
					'FLAG_IMG'		=> $flag_row['flag_image'],
					'FLAG_ID'		=> $flag_row['flag_id'],

					'S_ADD_FLAG'	=> true,
					'S_ERROR'		=> (sizeof($error)) ? true : false,
					)
				);

			break;

			case 'add':

				//we don't want two flags with the same name...right?
				$sql = 'SELECT *
					FROM ' . $flags_table;
				$result = $db->sql_query($sql);

				$flag_name_arry = array();

				while($row = $db->sql_fetchrow($result))
				{
					$flag_name_arry[] = $row['flag_name'];
				}
				$db->sql_freeresult($result);

				// convert the array to string
				$flag_name_arry = implode(',', $flag_name_arry);
				$flag_name_arry = strtoupper($flag_name_arry);

				// convert the string back into an array
				$flag_name_arry = explode(',', $flag_name_arry);
				$error = array();
				if ($submit)
				{
					if (!check_form_key('acp_flags'))
					{
						$error[] = $user->lang['FORM_INVALID'];
					}
					$flag_row = array(
						'flag_name'			=> utf8_normalize_nfc($request->variable('flag_name', '', true)),
						'flag_image'		=> $request->variable('flag_img', ''),
					);
					if (empty($flag_row['flag_name']))
					{
						$error[] = $user->lang['FLAG_ERROR_NO_FLAG_NAME'];
					}
					//check to make sure the flag name is different
					if (in_array(strtoupper($flag_row['flag_name']), $flag_name_arry))
					{
						$error[] = $user->lang['FLAG_NAME_EXISTS'];
					}
					if (!sizeof($error))
					{
						$sql = 'INSERT INTO ' . $flags_table . ' ' . $db->sql_build_array('INSERT', $flag_row);
						$db->sql_query($sql);

						$log = $phpbb_container->get('log');
						$log->add('admin', $user->data['user_id'], $user->ip, 'LOG_FLAG_ADD', time(), array($flag_row['flag_name']));

						$cache->destroy('_user_flags');

						trigger_error($user->lang['MSG_FLAG_ADDED'] . adm_back_link($this->u_action . "&amp;action=$action"));
					}
				}

				$template->assign_vars(array(
					'L_TITLE'		=> $user->lang['FLAG_ADD'],
					'U_ACTION'		=> $this->u_action . "&amp;action=$action",

					'ERROR_MSG'		=> (sizeof($error)) ? implode('<br />', $error) : '',

					'S_ADD_FLAG'	=> true,
					'S_ERROR'		=> (sizeof($error)) ? true : false,
				));
			break;
		}

		$sql = 'SELECT *
			FROM ' . $flags_table . '
			ORDER BY flag_name ASC';
		$result = $db->sql_query($sql);

		while ($row = $db->sql_fetchrow($result))
		{
			$template->assign_block_vars('flags', array(
				'FLAG_NAME'		=> $row['flag_name'],
				'FLAG_IMG'		=> "$flags_dir" . strtolower($row['flag_image']),
				'FLAG_ID'		=> $row['flag_id'],

				'U_EDIT'		=> $this->u_action . "&amp;id={$row['flag_id']}&amp;action=edit",
				'U_DELETE'		=> $this->u_action . "&amp;id={$row['flag_id']}&amp;action=delete",)
			);
		}
		$db->sql_freeresult($result);

		$template->assign_vars(array(
			'S_FLAGS'	=> true,
		));
	}

	function config()
	{
		global $config, $template, $user, $request;

		$submit	= $request->is_set_post('submit');

		$allow_flags = $request->variable('allow_flags', (int) $config['allow_flags']);
		$flag_on_reg = $request->variable('flags_on_reg', 0);
		$flag_msg = $request->variable('flags_display_msg', 0);

		$error = array();
		if ($submit)
		{
			if (!check_form_key('acp_flags'))
			{
				$error[] = 'FORM_INVALID';
			}

			if (!sizeof($error))
			{
				set_config('allow_flags', $allow_flags);
				set_config('flags_display_msg', $flag_msg);
				set_config('flags_on_reg', $flag_on_reg);

				trigger_error($user->lang['FLAG_CONFIG_SAVED'] . adm_back_link($this->u_action));
			}
		}

		$template->assign_vars(array(
			'FLAGS_VERSION' => $config['nationalflags_version'],
			'ALLOW_FLAGS'	=> $allow_flags,
			'FLAGS_ON_REG'	=> $config['flags_on_reg'],
			'FLAGS_DISPLAY_MSG'	=> $config['flags_display_msg'],
			'ERROR_MSG'		=> (sizeof($error)) ? implode('<br />', $error) : '',

			'S_ERROR'		=> (sizeof($error)) ? true : false,
		));
	}
}
