<?php
/**
*
* National Flags extension for the phpBB Forum Software package.
*
* @copyright (c) 2015 Rich McGirr (RMcGirr83)
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace rmcgirr83\nationalflags\controller;

use Symfony\Component\HttpFoundation\Response;

/**
* Main controller
*/
class main_controller
{
	/** @var \phpbb\auth\auth */
	protected $auth;

	/** @var \phpbb\cache\service */
	protected $cache;

	/** @var \phpbb\config\config */
	protected $config;

	/** @var \phpbb\db\driver\driver */
	protected $db;

	/** @var \phpbb\controller\helper */
	protected $helper;

	/** @var \phpbb\template\template */
	protected $template;

	/** @var \phpbb\user */
	protected $user;

	/** @var string phpBB root path */
	protected $root_path;

	/** @var string phpEx */
	protected $php_ext;

	/**
	* The database table the rules are stored in
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
	/**
	* Constructor
	*
	* @param \phpbb\cache\service				$cache			Cache object
	* @param \phpbb\config\config               $config         Config object
	* @param \phpbb\controller\helper           $helper         Controller helper object
	* @param \phpbb\template\template           $template       Template object
	* @param \phpbb\user                        $user           User object
	* @param string                             $root_path      phpBB root path
	* @param string                             $php_ext        phpEx
	* @param string								$flags_path		path to flags directory
	* @param \rmcgirr83\nationalflags\functions	$nf_functions	functions to be used by class
	* @access public
	*/
	public function __construct(
			\phpbb\auth\auth $auth,
			\phpbb\cache\service $cache,
			\phpbb\config\config $config,
			\phpbb\db\driver\driver_interface $db,
			\phpbb\controller\helper $helper,
			\phpbb\template\template $template,
			\phpbb\user $user,
			$root_path,
			$php_ext,
			$flags_table,
			$flags_path,
			\rmcgirr83\nationalflags\core\functions_nationalflags $functions)
	{
		$this->auth = $auth;
		$this->cache = $cache;
		$this->config = $config;
		$this->db = $db;
		$this->helper = $helper;
		$this->template = $template;
		$this->user = $user;
		$this->root_path = $root_path;
		$this->php_ext = $php_ext;
		$this->flags_table = $flags_table;
		$this->flags_path = $flags_path;
		$this->nf_functions = $functions;
	}

	/**
	* Display the flags page
	*
	* @return \Symfony\Component\HttpFoundation\Response A Symfony Response object
	* @access public
	*/
	public function displayFlags()
	{
		// When flags are disabled, redirect users back to the forum index
		if (empty($this->config['allow_flags']))
		{
			redirect(append_sid("{$this->root_path}index.{$this->php_ext}"));
		}

		//let's get the flags
		$sql = 'SELECT f.flag_id, f.flag_name, f.flag_image, COUNT(u.user_flag) as user_count
			FROM ' . $this->flags_table . ' f
			LEFT JOIN ' . USERS_TABLE . " u on f.flag_id = u.user_flag
		WHERE u.user_type IN (" . USER_NORMAL . ', ' . USER_FOUNDER . ") AND u.user_flag > 0
		GROUP BY f.flag_id
		ORDER BY user_count DESC";
		$result = $this->db->sql_query($sql);

		$flags = array();
		$countries = $users_count = 0;
		while ($row = $this->db->sql_fetchrow($result))
		{
			++$countries;
			$flag_id = $row['flag_id'];
			$user_count = $row['user_count'];
			$users_count = $users_count + $user_count;
			if ($user_count == 1)
			{
				$user_flag_count = sprintf($this->user->lang['FLAG_USER'], $user_count);
			}
			else
			{
				$user_flag_count = sprintf($this->user->lang['FLAG_USERS'], $user_count);
			}

			$this->template->assign_block_vars('flag', array(
				'FLAG' 			=> $this->nf_functions->get_user_flag($flag_id),
				'FLAG_USER_COUNT'	=> $user_flag_count,
				'U_FLAG'		=> $this->helper->route('rmcgirr83_nationalflags_getflagusers_controller', array('flag_id' => $flag_id)),
			));
		}
		$this->db->sql_freeresult($result);

		if ($users_count == 1)
		{
			$flag_users = sprintf($this->user->lang['FLAG_USER'], $users_count);
		}
		else
		{
			$flag_users = sprintf($this->user->lang['FLAG_USERS'], $users_count);
		}

		$this->template->assign_vars(array(
			'L_FLAGS'			=> $countries . ' ' . $this->user->lang['FLAGS'] . '&nbsp;&nbsp;' . $flag_users,
		));

		// Assign breadcrumb template vars for the flags page
		$this->template->assign_block_vars('navlinks', array(
			'U_VIEW_FORUM'		=> $this->helper->route('rmcgirr83_nationalflags_main_controller'),
			'FORUM_NAME'		=> $this->user->lang('FLAGS'),
		));

		// Send all data to the template file
		return $this->helper->render('flags_list.html', $this->user->lang('FLAGS'));
	}

	/**
	* Display the users of flags page
	*
	* @param $flag_id
	* @return \Symfony\Component\HttpFoundation\Response A Symfony Response object
	* @access public
	*/
	public function getFlagUsers($flag_id)
	{
		// When flags are disabled, redirect users back to the forum index
		if (empty($this->config['allow_flags']))
		{
			redirect(append_sid("{$this->root_path}index.{$this->php_ext}"));
		}

		//let's get the flag requested
		$sql = 'SELECT flag_id, flag_name, flag_image
			FROM ' . $this->flags_table . '
			WHERE flag_id = ' .(int) $flag_id;
		$result = $this->db->sql_query($sql);
		$row = $this->db->sql_fetchrow($result);
		$this->db->sql_freeresult($result);

		if (!$row)
		{
			trigger_error('NO_USER_HAS_FLAG');
		}

		// now users that have that flag
		$sql = 'SELECT *
			FROM ' . USERS_TABLE . '
			WHERE user_flag = ' . (int) $flag_id . '
				AND ' . $this->db->sql_in_set ('user_type', array(USER_NORMAL, USER_FOUNDER)) . '
			ORDER BY username_clean';
		$result = $this->db->sql_query($sql);
		$rows = $this->db->sql_fetchrowset($result);
		$this->db->sql_freeresult($result);

		// for counting of flag users
		$result = $this->db->sql_query($sql);
		$row2 = $this->db->sql_fetchrowset($result);
		$total_users = (int) count($row2);
		$this->db->sql_freeresult($result);
		unset($row2);

		foreach($rows as $userrow)
		{
			$user_id = $userrow['user_id'];

			$username = $this->auth->acl_get('u_viewprofile') ? get_username_string('full', $user_id, $userrow['username'], $userrow['user_colour']) : get_username_string('no_profile', $user_id, $userrow['username'], $userrow['user_colour']);

			$this->template->assign_block_vars('user_row', array(
				'JOINED'		=> $this->user->format_date($userrow['user_regdate']),
				'VISITED'		=> (empty($row['user_lastvisit'])) ? ' - ' : $this->user->format_date($userrow['user_lastvisit']),
				'POSTS'			=> ($userrow['user_posts']) ? $userrow['user_posts'] : 0,
				'USERNAME_FULL'		=> $username,
				'U_SEARCH_USER'		=> ($this->auth->acl_get('u_search')) ? append_sid("{$this->root_path}search.$this->php_ext", "author_id=$user_id&amp;sr=posts") : '',
			));
		}
		$this->db->sql_freeresult($result);

		// Assign breadcrumb template vars for the flags page
		$this->template->assign_block_vars('navlinks', array(
			'U_VIEW_FORUM'		=> $this->helper->route('rmcgirr83_nationalflags_main_controller'),
			'FORUM_NAME'		=> $this->user->lang('FLAGS'),
		));

		$flag_image = $this->nf_functions->get_user_flag($flag_id);
		$flag_image = str_replace('./', generate_board_url() . '/', $flag_image); // Fix paths
		if ($total_users == 1)
		{
			$total_users = sprintf($this->user->lang['FLAG_USER'], $total_users);
		}
		else
		{
			$total_users = sprintf($this->user->lang['FLAG_USERS'], $total_users);
		}
		$this->template->assign_vars(array(
			'FLAG'			=> $row['flag_name'],
			'FLAG_IMAGE'	=> $flag_image,
			'TOTAL_USERS'	=> $total_users,
			'S_VIEWONLINE'	=> $this->auth->acl_get('u_viewonline'),
		));
		// Send all data to the template file
		return $this->helper->render('flag_users.html', $this->user->lang('FLAGS'));
	}

	/**
	 * Display flag on change in ucp
	 * Ajax function
	 * @param $id
	 *
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function getFlag($flag_id)
	{
		if (empty($flag_id))
		{
			if ($this->config['flags_on_reg'])
			{
				return new Response($this->user->lang['MUST_CHOOSE_FLAG']);
			}
			else
			{
				return new Response($this->user->lang['NO_SUCH_FLAG']);
			}
		}

		$flag = $this->cache->get('_user_flags');
		$flag_img = $this->root_path . $this->flags_path . $flag[$flag_id]['flag_image'];
		$flag_name = $flag[$flag_id]['flag_name'];

		$return = '<img src="' . $flag_img . '" alt="' . $flag_name .'" title="' . $flag_name .'" style="vertical-align:middle;" />';

		return new Response($return);
	}
}
