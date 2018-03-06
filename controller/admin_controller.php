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

use rmcgirr83\nationalflags\core\flag_position_constants;

/**
* Admin controller
*/
class admin_controller
{

	/**
	* define our constants
	**/
	const MAX_WIDTH = 32;
	const MAX_HEIGHT = 32;

	/** @var \phpbb\cache\service */
	protected $cache;

	/** @var \phpbb\config\config */
	protected $config;

	/** @var \phpbb\db\driver\driver_interface */
	protected $db;

	/** @var \phpbb\pagination */
	protected $pagination;

	/** @var \phpbb\controller\helper */
	protected $helper;

	/** @var \phpbb\request\request */
	protected $request;

	/** @var \phpbb\template\template */
	protected $template;

	/** @var \phpbb\user */
	protected $user;

	/** @var \phpbb\log\log */
	protected $log;

	/** @var \phpbb\extension\manager "Extension Manager" */
	protected $ext_manager;

	/** @var \phpbb\path_helper */
	protected $path_helper;

	/** @var string phpBB root path */
	protected $root_path;

	/** @var string phpEx */
	protected $php_ext;

	/**
	 * The database table the flags are stored in
	 *
	 * @var string
	 */
	protected $flags_table;

	/* @var \rmcgirr83\nationalflags\core\nationalflags */
	protected $nationalflags;

	/** @var \phpbb\files\factory */
	protected $files_factory;

	/** @var string Custom form action */
	protected $u_action;

	/**
	* Constructor
	*
	* @param \phpbb\cache\service					$cache				Cache object
	* @param \phpbb\config\config					$config				Config object
	* @param \phpbb\db\driver\driver_interface		$db					Database object
	* @param \phpbb\pagination						$pagination			Pagination object
	* @param \phpbb\controller\helper           	$helper     	    Controller helper object
	* @param \phpbb\request\request					$request			Request object
	* @param \phpbb\template\template				$template			Template object
	* @param \phpbb\user							$user				User object
	* @param \phpbb\log								$log				Log object
	* @param \phpbb\extension\manager				$ext_manager		Extension manager object
	* @param \phpbb\path_helper						$path_helper		Path helper object
	* @param string                             	$root_path      	phpBB root path
	* @param string                             	$php_ext        	phpEx
	* @param string									$flags_table		Name of the table used to store flag data
	* @param \rmcgirr83\nationalflags\core\nationalflags	$nationalflags	methods for the extension
	* @param \phpbb\files\factory					$files_factory		File classes factory
	* @return \rmcgirr83\nationalflags\controller\admin_controller
	* @access public
	*/
	public function __construct(
			\phpbb\cache\service $cache,
			\phpbb\config\config $config,
			\phpbb\db\driver\driver_interface $db,
			\phpbb\pagination $pagination,
			\phpbb\controller\helper $helper,
			\phpbb\request\request $request,
			\phpbb\template\template $template,
			\phpbb\user $user,
			\phpbb\log\log $log,
			\phpbb\extension\manager $ext_manager,
			\phpbb\path_helper $path_helper,
			$root_path,
			$php_ext,
			$flags_table,
			\rmcgirr83\nationalflags\core\nationalflags $nationalflags,
			\phpbb\files\factory $files_factory = null)
	{
		$this->cache = $cache;
		$this->config = $config;
		$this->db = $db;
		$this->pagination = $pagination;
		$this->helper = $helper;
		$this->request = $request;
		$this->template = $template;
		$this->user = $user;
		$this->log = $log;
		$this->ext_manager	 = $ext_manager;
		$this->path_helper	 = $path_helper;
		$this->root_path = $root_path;
		$this->php_ext = $php_ext;
		$this->flags_table = $flags_table;
		$this->nationalflags = $nationalflags;
		$this->files_factory = $files_factory;

		$this->ext_path = $this->ext_manager->get_extension_path('rmcgirr83/nationalflags', true);
		$this->ext_path_web = $this->path_helper->update_web_root_path($this->ext_path);
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

			if (!function_exists('validate_data'))
			{
				include($this->root_path . 'includes/functions_user.' . $this->php_ext);
			}

			$check_row = array('flags_num_display' => $this->request->variable('flags_num_display', 0));
			$validate_row = array('flags_num_display' => array('num', false, 1, 1000));
			$error = validate_data($check_row, $validate_row);
			// Replace "error" strings with their real, localised form
			$error = array_map(array($this->user, 'lang'), $error);

			if (!sizeof($error))
			{
				// Set the options the user configured
				$this->set_options();

				// Add option settings change action to the admin log
				$this->log->add('admin', $this->user->data['user_id'], $this->user->ip, 'FLAG_CONFIG_SAVED');

				// Option settings have been updated and logged
				// Confirm this to the user and provide link back to previous page
				trigger_error($this->user->lang('FLAG_SETTINGS_CHANGED') . adm_back_link($this->u_action));
			}
		}

		// Set output vars for display in the template
		$this->template->assign_vars(array(
			'ERROR'				=> isset($error) ? ((sizeof($error)) ? implode('<br>', $error) : '') : '',
			'FLAGS_NUM_DISPLAY'	=> $this->config['flags_num_display'],
			'FLAGS_DISPLAY_INDEX'	=> $this->config['flags_display_index'] ? true : false,
			'ALLOW_FLAGS'		=> $this->config['allow_flags'] ? true : false,
			'FLAGS_REQUIRED'	=> $this->config['flags_required'] ? true : false,
			'FLAGS_DISPLAY_MSG'	=> $this->config['flags_display_msg'] ? true : false,
			'FLAGS_DISPLAY_TO_GUESTS'	=> $this->config['flags_display_to_guests'] ? true : false,
			'FLAG_POSITION'	=> $this->flag_position($this->config['flag_position']),
			'FLAGS_VIEWFORUM'	=> $this->config['flags_viewforum'] ? true : false,
			'FLAGS_FORUMROW'	=> $this->config['flags_forumrow'] ? true : false,
			'FLAGS_SEARCH'		=> $this->config['flags_search'] ? true : false,
			'FLAGS_MEMBERLIST'	=> $this->config['flags_memberlist'] ? true : false,
			'S_FLAGS'			=> true,

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
		$this->config->set('flags_num_display', $this->request->variable('flags_num_display', 0));
		$this->config->set('allow_flags', $this->request->variable('allow_flags', 0));
		$this->config->set('flags_required', $this->request->variable('flags_required', 0));
		$this->config->set('flags_display_msg', $this->request->variable('flags_display_msg', 0));
		$this->config->set('flags_display_index', $this->request->variable('flags_display_index', 0));
		$this->config->set('flags_display_to_guests', $this->request->variable('flags_display_to_guests', 0));
		$this->config->set('flag_position', $this->request->variable('flag_position', 0));
		$this->config->set('flags_viewforum', $this->request->variable('flags_viewforum', 0));
		$this->config->set('flags_forumrow', $this->request->variable('flags_forumrow', 0));
		$this->config->set('flags_search', $this->request->variable('flags_search', 0));
		$this->config->set('flags_memberlist', $this->request->variable('flags_memberlist', 0));
	}

	/**
	 * Display the flags
	 *
	 * @return null
	 * @access public
	 */
	public function display_flags()
	{
		$start = $this->request->variable('start', 0);
		$pagination_url = $this->u_action;

		$sql = 'SELECT f.*, COUNT(u.user_flag) as user_count
			FROM ' . $this->flags_table . ' f
				LEFT JOIN ' . USERS_TABLE . " u on f.flag_id = u.user_flag
			GROUP BY f.flag_id
			ORDER BY f.flag_name ASC";
		$result = $this->db->sql_query_limit($sql, $this->config['topics_per_page'], $start);

		// for counting of all the flags
		// used for pagination
		$result2 = $this->db->sql_query($sql);
		$row2 = $this->db->sql_fetchrowset($result2);
		$total_count = (int) sizeof($row2);
		$this->db->sql_freeresult($result2);
		unset($row2);

		while ($row = $this->db->sql_fetchrow($result))
		{
			$user_count = $this->user->lang('FLAG_USERS', (int) $row['user_count']);

			$flag_default = !empty($row['flag_default']) ? true : false;
			$this->template->assign_block_vars('flags', array(
				'FLAG_NAME'		=> $row['flag_name'],
				'FLAG_DEFAULT'	=> $flag_default,
				'FLAG_IMG'		=> $this->ext_path_web . 'flags/' . $row['flag_image'],
				'FLAG_ID'		=> $row['flag_id'],
				'USER_COUNT'	=> $user_count,
				'U_FLAG'		=> $this->helper->route('rmcgirr83_nationalflags_getflags', array('flag_id' => $row['flag_id'])),
				'U_EDIT'		=> $this->u_action . "&amp;flag_id={$row['flag_id']}&amp;action=edit",
				'U_DELETE'		=> $this->u_action . "&amp;flag_id={$row['flag_id']}&amp;action=delete",)
			);
		}
		$this->db->sql_freeresult($result);

		$start = $this->pagination->validate_start($start, $this->config['topics_per_page'], $total_count);
		$this->pagination->generate_template_pagination($pagination_url, 'pagination', 'start', $total_count, $this->config['topics_per_page'], $start);

		$this->template->assign_vars(array(
			'TOTAL_FLAGS'	=> $total_count,
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
			'flag_name'			=> ucfirst($this->request->variable('flag_name', '', true)),
			'flag_image'		=> (!$this->can_upload_flag()) ? $this->request->variable('flag_image', '') : '',
			'flag_default'		=> $this->request->variable('flag_default', 0),
		);

		if ($this->request->is_set_post('submit'))
		{
			$errors = $this->check_flag($flag_row['flag_name'], $errors, 'add_flag', $flag_row['flag_image']);

			if (!sizeof($errors) && $this->can_upload_flag())
			{
				$flag_row['flag_image'] = $this->flag_upload($errors, 'add_flag');
			}

			if (!sizeof($errors))
			{
				// if this flag is set to default, change all other flags to not be set as default
				if ($flag_row['flag_default'])
				{
					$this->change_flag_default();
				}

				$sql = 'INSERT INTO ' . $this->flags_table . ' ' . $this->db->sql_build_array('INSERT', $flag_row);
				$this->db->sql_query($sql);

				$this->log_message('LOG_FLAG_ADD', $flag_row['flag_name'], 'MSG_FLAG_ADDED');
			}
		}

		$this->template->assign_vars(array(
			'L_TITLE'		=> $this->user->lang['FLAG_ADD'],
			'U_ACTION'		=> $this->u_action . '&amp;action=add',
			'U_BACK'		=> $this->u_action,
			'FLAG_NAME'		=> $flag_row['flag_name'],
			'FLAG_IMAGE'	=> $flag_row['flag_image'],
			'ERROR_MSG'		=> (sizeof($errors)) ? implode('<br>', $errors) : '',
			'FLAG_LIST'		=> $this->list_flag_names(),

			'S_ADD_FLAG'	=> true,
			'S_ERROR'		=> (sizeof($errors)) ? true : false,
			'S_UPLOAD_FLAG'	=> $this->can_upload_flag(),
			'S_FORM_ENCTYPE'	=> ' enctype="multipart/form-data"',
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

		$sql = 'SELECT *
			FROM ' . $this->flags_table . '
			WHERE flag_id =' . (int) $flag_id;
		$result = $this->db->sql_query($sql);
		$row = $this->db->sql_fetchrow($result);
		$this->db->sql_freeresult($result);

		if (!$row)
		{
			trigger_error($this->user->lang['FLAG_ERROR_NOT_EXIST'] . adm_back_link($this->u_action . '&amp;mode=manage'), E_USER_WARNING);
		}

		// Add form key
		add_form_key('edit_flag');

		$errors = array();

		$flag_row = array(
			'flag_name'			=> ucfirst($this->request->variable('flag_name', '', true)),
			'flag_image'		=> (!$this->can_upload_flag()) ? $this->request->variable('flag_image', $row['flag_image']) : '',
			'flag_default'		=> $this->request->variable('flag_default', 0),
		);

		if ($this->request->is_set_post('submit'))
		{
			$errors = $this->check_flag($flag_row['flag_name'], $errors, 'edit_flag', $flag_row['flag_image']);

			if (!sizeof($errors) && $this->can_upload_flag())
			{
				$flag_row['flag_image'] = $this->flag_upload($errors, 'edit_flag');
			}

			if (!sizeof($errors))
			{
				// if this flag is set to default, change all other flags to not be set as default
				if ($flag_row['flag_default'])
				{
					$this->change_flag_default();
				}

				$sql = 'UPDATE ' . $this->flags_table . '
					SET ' . $this->db->sql_build_array('UPDATE', $flag_row) . '
					WHERE flag_id = ' . (int) $flag_id;
				$this->db->sql_query($sql);

				$this->log_message('LOG_FLAG_EDIT', $flag_row['flag_name'], 'MSG_FLAG_EDITED');

			}
		}

		$found_flag = $this->ext_path_web . 'flags/' . $row['flag_image'];
		$this->template->assign_vars(array(
			'L_TITLE'		=> $this->user->lang['FLAG_EDIT'],
			'U_ACTION'		=> $this->u_action . "&amp;flag_id=$flag_id&amp;action=edit",
			'U_BACK'		=> $this->u_action . '&amp;mode=manage',
			'ERROR_MSG'		=> (sizeof($errors)) ? implode('<br>', $errors) : '',

			'FLAG_NAME'		=> $row['flag_name'],
			'FLAG_IMAGE'	=> $row['flag_image'],
			'FLAG_ID'		=> $row['flag_id'],
			'FLAG_DEFAULT'	=> $row['flag_default'],
			'FOUND_FLAG'	=> (!empty($found_flag)) ? $found_flag : '',
			'FLAG_LIST'		=> $this->list_flag_names(),

			'S_ADD_FLAG'	=> true,
			'S_UPLOAD_FLAG'	=> $this->can_upload_flag(),
			'S_ERROR'		=> (sizeof($errors)) ? true : false,
			'S_FORM_ENCTYPE'	=> ' enctype="multipart/form-data"',
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
			$this->db->sql_query('DELETE FROM ' . $this->flags_table . ' WHERE flag_id = ' . (int) $flag_id);

			// Reset the flag for users
			$sql = 'UPDATE ' . USERS_TABLE . '
				SET user_flag = 0
				WHERE user_flag = ' . (int) $flag_id;
			$this->db->sql_query($sql);

			// remove the flag from the server
			@unlink($this->ext_path_web . 'flags/' . $flag_row['flag_image']);

			$this->log_message('LOG_FLAGS_DELETED', $flag_row['flag_name'], 'MSG_FLAGS_DELETED');
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
				$message .= $this->user->lang('MSG_FLAG_CONFIRM_DELETE', (int) $row['flag_count']);
			}
			confirm_box(false, $message, build_hidden_fields(array(
				'id'		=> (int) $flag_id,
				'mode'		=> 'manage',
				'action'	=> 'delete'))
			);
			// Use a redirect to take the user back to the previous page
			// if the user chose to not delete the flag from the confirmation page.
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
	private function check_flag($flag_name, $errors, $form_key = '', $flag_image = false)
	{
		if (!check_form_key($form_key))
		{
			$errors[] = $this->user->lang['FORM_INVALID'];
		}

		if (empty($flag_name))
		{
			$errors[] = $this->user->lang['FLAG_ERROR_NO_FLAG_NAME'];
		}

		if (!$this->can_upload_flag())
		{
			if (empty($flag_image))
			{
				$errors[] = $this->user->lang['FLAG_ERROR_NO_FLAG_IMG'];
			}
		}

		if ($form_key == 'add_flag')
		{
			//we don't want two flags with the same name...right?
			$sql = 'SELECT flag_name
				FROM ' . $this->flags_table . "
				WHERE flag_name = '" . $this->db->sql_escape($flag_name) . "'";
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
	* Check if user is able to upload a flag
	*
	* @return bool True if user can upload, false if not
	*/
	protected function can_upload_flag()
	{
		return (file_exists($this->ext_path_web . 'flags') && phpbb_is_writable($this->ext_path_web . 'flags') && (@ini_get('file_uploads') || strtolower(@ini_get('file_uploads')) == 'on'));
	}

	/**
	* List current flag names
	*/
	protected function list_flag_names()
	{
		// ensure cache for the flags is built
		$this->nationalflags->cache_flags();

		$data = $this->cache->get('_user_flags');

		foreach ($data as $key => $row)
		{
			$flag[$key] = $row['flag_image'];
		}
		array_multisort($flag, SORT_NATURAL, $data);

		return implode(', ', $flag);
	}

	/**
	* Copy a flag image to server.
	*
	* @param	string	$flag 	The flag image from usrs hard drive
	* @param	array	$error	The array error, passed by reference
	* @return	false|string	String if no errors, else false
	*/
	private function flag_upload(&$errors, $action = '')
	{
		$old_flag = $this->request->variable('old_flag', '');

		//Set upload directory
		$upload_dir = $this->ext_path_web . 'flags';
		$upload_dir = str_replace(array('../', '..\\', './', '.\\'), '', $upload_dir);

		if ($this->files_factory !== null)
		{
			$upload = $this->files_factory->get('upload')
				->set_error_prefix('FLAG_IMAGE_')
				->set_allowed_extensions(array('gif', 'png', 'jpeg', 'jpg'))
				->set_allowed_dimensions(self::MAX_WIDTH, self::MAX_HEIGHT, self::MAX_WIDTH, self::MAX_HEIGHT);
		}
		else
		{
			if (!class_exists('fileupload'))
			{
				include($this->root_path . 'includes/functions_upload.' . $this->php_ext);
			}
			$upload = new \fileupload('FLAG_IMAGE_', array('gif', 'png', 'jpeg', 'jpg'), false, self::MAX_WIDTH, self::MAX_HEIGHT, self::MAX_WIDTH, self::MAX_HEIGHT);
		}

		// Uploading from a form, form name
		$file = ($this->files_factory !== null) ? $upload->handle_upload('files.types.form', 'flag_upload') : $upload->form_upload('flag_upload');

		// if the flag_upload field is empty and we are editing...return the old flag
		$name = $file->get('realname');
		if ($action == 'edit_flag' && empty($name))
		{
			return $old_flag;
		}

		$file->move_file($upload_dir);

		if (sizeof($file->error))
		{
			$file->remove();
			$errors = array_merge($errors, $file->error);
			return false;
		}
		// phpbb_chmod doesn't work well here on some servers so be explicit
		@chmod($this->ext_path_web . 'flags/' . $file->get('uploadname'), 0644);

		// remove the old flag if set
		@unlink($this->ext_path_web . 'flags/' . $old_flag);

		return $file->get('uploadname');
	}

	/**
	 * Change flag setting to not be default
	 *
	 * @return null
	 * @access private
	*/
	private function change_flag_default()
	{
		$this->db->sql_query('UPDATE ' . $this->flags_table . ' SET flag_default = 0 WHERE flag_default = 1');
	}

	/**
	 * Log Message either edit, add or delete
	 *
	 * @return message
	 * @access private
	*/
	private function log_message($log_message, $flag_name, $user_message)
	{
		$this->log->add('admin', $this->user->data['user_id'], $this->user->ip, $log_message, time(), array($flag_name));

		$this->cache->destroy('_user_flags');
		$this->nationalflags->cache_flags();

		trigger_error($this->user->lang[$user_message] . adm_back_link($this->u_action));
	}
	/**
	* Display drop down of areas to display the flag
	*/
	private function flag_position($flag_position)
	{

		$flag_position_constants = flag_position_constants::getFlagPosition();

		$s_flag_position = '';
		foreach ($flag_position_constants as $name => $value)
		{
			$selected = ($value == $flag_position) ? ' selected="selected"' : '';
			$position_name = $this->user->lang('FLAG_POSITION_' . $name);
			$s_flag_position .= "<option value='{$value}'$selected>$position_name</option>";
		}

		return $s_flag_position;
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
