<?php
/**
*
* National Flags extension for the phpBB Forum Software package.
*
* @copyright (c) 2015 Rich McGirr (RMcGirr83)
* @license GNU General Public License, version 2 (GPL-2.0)
*
*/

namespace rmcgirr83\nationalflags\controller;

use Symfony\Component\DependencyInjection\ContainerInterface;

/**
* Admin controller
*/
class admin_controller
{
	/** @var \phpbb\cache\service */
	protected $cache;

	/** @var \phpbb\config\config */
	protected $config;

	/** @var \phpbb\db\driver\driver_interface */
	protected $db;

	/** @var \phpbb\request\request */
	protected $request;

	/** @var \phpbb\template\template */
	protected $template;

	/** @var \phpbb\user */
	protected $user;

	/** @var ContainerInterface */
	protected $container;

	/**
	* The database table the flags are stored in
	*
	* @var string
	*/
	protected $flags_table;

	/**
	* the path to the flags directory
	*
	*@var string
	*/
	protected $flags_path;

	/* @var \rmcgirr83\nationalflags\core\functions_nationalflags */
	protected $nf_functions;

	/** @var string phpBB root path */
	protected $root_path;

	/** @var string phpEx */
	protected $php_ext;

	/** @var string Custom form action */
	protected $u_action;

	/**
	* Constructor
	*
	* @param \phpbb\cache\service					$cache					Cache object
	* @param \phpbb\config\config					$config					Config object
	* @param \phpbb\db\driver\driver_interface		$db						Database object
	* @param \phpbb\request\request					$request				Request object
	* @param \phpbb\template\template				$template				Template object
	* @param \phpbb\user							$user					User object
	* @param ContainerInterface						$container				Service container interface
	* @param string									$nationalflags_table	Name of the table used to store flag data
	* @param string									$flags_path				The path to the flags directory where the images are stored
	* @param string									$root_path				phpBB root path
	* @param string									$php_ext				phpEx
	* @return \rmcgirr83\nationalflags\controller\admin_controller
	* @access public
	*/
	public function __construct(
			\phpbb\cache\service $cache,
			\phpbb\config\config $config,
			\phpbb\db\driver\driver_interface $db,
			\phpbb\request\request $request,
			\phpbb\template\template $template,
			\phpbb\user $user,
			ContainerInterface $container,
			$flags_table,
			$flags_path,
			\rmcgirr83\nationalflags\core\functions_nationalflags $functions,
			$root_path,
			$php_ext)
	{
		$this->cache = $cache;
		$this->config = $config;
		$this->db = $db;
		$this->request = $request;
		$this->template = $template;
		$this->user = $user;
		$this->container = $container;
		$this->flags_table = $flags_table;
		$this->flags_path = $flags_path;
		$this->nf_functions = $functions;
		$this->root_path = $root_path;
		$this->php_ext = $php_ext;
	}

	/**
	* Display the options a user can configure for this extension
	*
	* @return null
	* @access public
	*/
	public function display_options()
	{
		// Create a form key for preventing CSRF attacks
		add_form_key('nationalflags_settings');

		// Is the form being submitted to us?
		if ($this->request->is_set_post('submit'))
		{
			// Test if the submitted form is valid
			if (!check_form_key('nationalflags_settings'))
			{
				trigger_error($this->user->lang['FORM_INVALID'] . adm_back_link($this->u_action));
			}

			// If no errors, process the form data
			if (empty($error))
			{
				// Set the options the user configured
				$this->set_options();

				// Add option settings change action to the admin log
				$log = $this->container->get('log');
				$log->add('admin', $this->user->data['user_id'], $this->user->ip, 'FLAG_CONFIG_SAVED');

				// Option settings have been updated and logged
				// Confirm this to the user and provide link back to previous page
				trigger_error($this->user->lang('FLAG_SETTINGS_CHANGED') . adm_back_link($this->u_action));
			}
		}

		// Set output vars for display in the template
		$this->template->assign_vars(array(
			'FLAGS_VERSION' 	=> $this->config['nationalflags_version'],
			'ALLOW_FLAGS'		=> $this->config['allow_flags'] ? true : false,
			'FLAGS_REQUIRED'	=> $this->config['flags_required'] ? true : false,
			'FLAGS_DISPLAY_MSG'	=> $this->config['flags_display_msg'] ? true : false,
			'ERROR_MSG'			=> (!empty($error)) ? implode('<br />', $error) : '',

			'S_ERROR'			=> (!empty($error)) ? true : false,
			'U_ACTION'			=> $this->u_action,
		));
	}

	/**
	* Set the options a user can configure
	*
	* @return null
	* @access protected
	*/
	protected function set_options()
	{
		$this->config->set('allow_flags', $this->request->variable('allow_flags', 0));
		$this->config->set('flags_required', $this->request->variable('flags_required', 0));
		$this->config->set('flags_display_msg', $this->request->variable('flags_display_msg', 0));
	}

	/**
	* Display the flags
	*
	* @return null
	* @access public
	*/
	public function display_flags()
	{
		$sql = 'SELECT *
			FROM ' . $this->flags_table . '
			ORDER BY flag_name ASC';
		$result = $this->db->sql_query($sql);

		while ($row = $this->db->sql_fetchrow($result))
		{
			$this->template->assign_block_vars('flags', array(
				'FLAG_NAME'		=> $row['flag_name'],
				'FLAG_IMG'		=> $this->root_path . $this->flags_path . strtolower($row['flag_image']),
				'FLAG_ID'		=> $row['flag_id'],

				'U_EDIT'		=> $this->u_action . "&amp;flag_id={$row['flag_id']}&amp;action=edit",
				'U_DELETE'		=> $this->u_action . "&amp;flag_id={$row['flag_id']}&amp;action=delete",)
			);
		}
		$this->db->sql_freeresult($result);

		$this->template->assign_vars(array(
			'S_FLAGS'	=> true,
		));
	}

	/**
	* Add a flag
	*
	* @return null
	* @access public
	*/
	public function add_flag()
	{
		// Add form key
		add_form_key('add_flag');

		$errors = array();

		$flag_row = array(
			'flag_name'			=> utf8_normalize_nfc($this->request->variable('flag_name', '', true)),
			'flag_image'		=> $this->request->variable('flag_image', ''),
		);

		if ($this->request->is_set_post('submit'))
		{
			$errors = $this->check_flag($flag_row['flag_image'], $flag_row['flag_name'], $errors, 'add_flag');

			if (!sizeof($errors))
			{
				$sql = 'INSERT INTO ' . $this->flags_table . ' ' . $this->db->sql_build_array('INSERT', $flag_row);
				$this->db->sql_query($sql);

				$log = $this->container->get('log');
				$log->add('admin', $this->user->data['user_id'], $this->user->ip, 'LOG_FLAG_ADD', time(), array($flag_row['flag_name']));

				$this->cache->destroy('_user_flags');
				// cache this data for ever, can only change in ACP
				$this->nf_functions->cache_flags();

				trigger_error($this->user->lang['MSG_FLAG_ADDED'] . adm_back_link($this->u_action));
			}
		}

		$this->template->assign_vars(array(
			'U_ACTION'		=> $this->u_action . '&amp;action=add',
			'U_BACK'		=> $this->u_action,
			'FLAG_NAME'		=> $flag_row['flag_name'],
			'FLAG_IMAGE'	=> $flag_row['flag_image'],
			'ERROR_MSG'		=> (sizeof($errors)) ? implode('<br />', $errors) : '',

			'S_ADD_FLAG'	=> true,
			'S_ERROR'		=> (sizeof($errors)) ? true : false,
		));
	}

	/**
	* Edit a flag
	*
	* @param int $flag_id The flag identifier to edit
	* @return null
	* @access public
	*/
	public function edit_flag($flag_id)
	{
		// Add form key
		add_form_key('edit_flag');

		$errors = array();

		$flag_row = array(
			'flag_name'			=> utf8_normalize_nfc($this->request->variable('flag_name', '', true)),
			'flag_image'		=> $this->request->variable('flag_image', ''),
		);

		if ($this->request->is_set_post('submit'))
		{
			$errors = $this->check_flag($flag_row['flag_image'], $flag_row['flag_name'], $errors, 'edit_flag');

			if (!sizeof($errors))
			{
				$sql = 'UPDATE ' . $this->flags_table . '
					SET ' . $this->db->sql_build_array('UPDATE', $flag_row) . '
					WHERE flag_id = ' . (int) $flag_id;
				$this->db->sql_query($sql);

				$log = $this->container->get('log');
				$log->add('admin', $this->user->data['user_id'], $this->user->ip, 'LOG_FLAG_EDIT', time(), array($flag_row['flag_name']));

				$this->cache->destroy('_user_flags');
				$this->nf_functions->cache_flags();

				trigger_error($this->user->lang['MSG_FLAG_EDITED'] . adm_back_link($this->u_action));
			}
		}

		$sql = 'SELECT flag_id, flag_name, flag_image
			FROM ' . $this->flags_table . '
			WHERE flag_id =' . (int) $flag_id;
		$result = $this->db->sql_query($sql);
		$flag_row = $this->db->sql_fetchrow($result);
		$this->db->sql_freeresult($result);

		if (!$flag_row)
		{
			trigger_error($this->user->lang['FLAG_ERROR_NOT_EXIST'] . adm_back_link($this->u_action . '&amp;mode=manage'), E_USER_WARNING);
		}

		$this->template->assign_vars(array(
			'L_TITLE'		=> $this->user->lang['FLAG_EDIT'],
			'U_ACTION'		=> $this->u_action . "&amp;flag_id=$flag_id&amp;action=edit",
			'U_BACK'		=> $this->u_action . '&amp;mode=manage',
			'ERROR_MSG'		=> (sizeof($errors)) ? implode('<br />', $errors) : '',

			'FLAG_NAME'		=> $flag_row['flag_name'],
			'FLAG_IMAGE'	=> $flag_row['flag_image'],
			'FLAG_ID'		=> $flag_row['flag_id'],

			'S_ADD_FLAG'	=> true,
			'S_ERROR'		=> (sizeof($errors)) ? true : false,
			)
		);
	}

	/**
	* Delete a flag
	*
	* @param int $flag_id The flag identifier to delete
	* @return null
	* @access public
	*/
	public function delete_flag($flag_id)
	{
		if (confirm_box(true))
		{
			// Grab the flag name for the log...
			$sql = 'SELECT flag_name, flag_image
				FROM ' . $this->flags_table . '
				WHERE flag_id = ' .(int) $flag_id;
			$result = $this->db->sql_query($sql);
			$flag_row = $this->db->sql_fetchrow($result);
			$this->db->sql_freeresult($result);

			// Delete the flag...
			$sql = 'DELETE FROM ' . $this->flags_table . '
				WHERE flag_id = ' . (int) $flag_id;
			$this->db->sql_query($sql);

			// Reset the flag for users
			$sql = 'UPDATE ' . USERS_TABLE . '
				SET user_flag = 0
				WHERE user_flag = ' . (int) $flag_id;
			$this->db->sql_query($sql);

			$log = $this->container->get('log');
			$log->add('admin', $this->user->data['user_id'], $this->user->ip, 'LOG_FLAGS_DELETED', time(), array($flag_row['flag_name']));

			$this->cache->destroy('_user_flags');
			$this->nf_functions->cache_flags();

			trigger_error($this->user->lang['MSG_FLAGS_DELETED'] . adm_back_link($this->u_action . "&amp;mode=manage"));
		}
		else
		{
			// display a count of users who have this flag
			$sql = 'SELECT COUNT(user_flag) AS flag_count
				FROM ' . USERS_TABLE . '
				WHERE user_flag = ' . (int) $flag_id;
			$result = $this->db->sql_query($sql);
			$row = $this->db->sql_fetchrow($result);
			$this->db->sql_freeresult($result);

			$message = $this->user->lang['MSG_CONFIRM'];
			if (!empty($row['flag_count']))
			{
				$message .= $row['flag_count'] <> 1 ? sprintf($this->user->lang['MSG_FLAGS_CONFIRM_DELETE'], $row['flag_count']) : sprintf($this->user->lang['MSG_FLAG_CONFIRM_DELETE'], $row['flag_count']);
			}
			confirm_box(false, $message, build_hidden_fields(array(
				'id'		=> (int) $flag_id,
				'mode'		=> 'manage',
				'action'	=> 'delete'))
			);
			// Use a redirect to take the user back to the previous page
			// if the user chose not delete the flag from the confirmation page.
			redirect("{$this->u_action}");
		}
	}

	/* check flag
	*
	* a function to run flag validation on
	* @param string	$form_key	The forum key add_flag/edit_flag
	* @param string	$flag_image	The flag image
	* @param string	$flag_name	The flag name
	* @param array	$errors		The possible generated errors
	* @return array
	* @access private
	*/
	private function check_flag($flag_image, $flag_name, $errors, $form_key = '')
	{
		if (!check_form_key($form_key))
		{
			$errors[] = $this->user->lang['FORM_INVALID'];
		}

		if (empty($flag_name))
		{
			$errors[] = $this->user->lang['FLAG_ERROR_NO_FLAG_NAME'];
		}

		if (empty($flag_image))
		{
			$errors[] = $this->user->lang['FLAG_ERROR_NO_FLAG_IMG'];
		}

		if ($form_key == 'add_flag')
		{
			//we don't want two flags with the same name...right?
			$sql = 'SELECT flag_name
				FROM ' . $this->flags_table . "
				WHERE upper(flag_name) = '" . $this->db->sql_escape(strtoupper($flag_name)) . "'";
			$result = $this->db->sql_query($sql);

			if ($this->db->sql_fetchrow($result))
			{
				$errors[] = $this->user->lang['FLAG_NAME_EXISTS'];
			}
			$this->db->sql_freeresult($result);
		}

		return $errors;
	}

	/**
	* Set page url
	*
	* @param string $u_action Custom form action
	* @return null
	* @access public
	*/
	public function set_page_url($u_action)
	{
		$this->u_action = $u_action;
	}
}
