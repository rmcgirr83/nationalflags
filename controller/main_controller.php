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

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
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

	/** @var \phpbb\pagination */
	protected $pagination;

	/** @var \phpbb\controller\helper */
	protected $helper;

	/* @var \phpbb\request\request */
	protected $request;

	/** @var \phpbb\extension\manager "Extension Manager" */
	protected $ext_manager;

	/** @var \phpbb\path_helper */
	protected $path_helper;

	/** @var \phpbb\template\template */
	protected $template;

	/** @var \phpbb\user */
	protected $user;

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
	protected $functions;

	/**
	* Constructor
	*
	* @param \phpbb\auth\auth					$auth			Auth object
	* @param \phpbb\cache\service				$cache			Cache object
	* @param \phpbb\config\config               $config         Config object
	* @param \phpbb\db\driver\driver			$db				Database object
	* @param \phpbb\pagination					$pagination		Pagination object
	* @param \phpbb\controller\helper           $helper         Controller helper object
	* @param \phpbb\request\request				$request		Request object
	* @param \phpbb\extension\manager			$ext_manager		Extension manager object
	* @param \phpbb\path_helper					$path_helper	Path helper object
	* @param \phpbb\template\template           $template       Template object
	* @param \phpbb\user                        $user           User object
	* @param string                             $root_path      phpBB root path
	* @param string                             $php_ext        phpEx
	* @param string								$flags_table	Name of the table used to store flag data
	* @param \rmcgirr83\nationalflags\core\nationalflags	$functions	functions to be used by class
	* @access public
	*/
	public function __construct(
			\phpbb\auth\auth $auth,
			\phpbb\cache\service $cache,
			\phpbb\config\config $config,
			\phpbb\db\driver\driver_interface $db,
			\phpbb\pagination $pagination,
			\phpbb\controller\helper $helper,
			\phpbb\request\request $request,
			\phpbb\extension\manager $ext_manager,
			\phpbb\path_helper $path_helper,
			\phpbb\template\template $template,
			\phpbb\user $user,
			$root_path,
			$php_ext,
			$flags_table,
			\rmcgirr83\nationalflags\core\nationalflags $functions)
	{
		$this->auth = $auth;
		$this->cache = $cache;
		$this->config = $config;
		$this->db = $db;
		$this->pagination = $pagination;
		$this->helper = $helper;
		$this->request = $request;
		$this->ext_manager	 = $ext_manager;
		$this->path_helper	 = $path_helper;
		$this->template = $template;
		$this->user = $user;
		$this->root_path = $root_path;
		$this->php_ext = $php_ext;
		$this->flags_table = $flags_table;
		$this->functions = $functions;

		$this->ext_path = $this->ext_manager->get_extension_path('rmcgirr83/nationalflags', true);
	}

	/**
	 * Display the flags page
	 *
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
			LEFT JOIN ' . USERS_TABLE . ' u on f.flag_id = u.user_flag
		WHERE ' . $this->db->sql_in_set('u.user_type', array(USER_NORMAL, USER_FOUNDER)) . ' AND u.user_flag > 0
		GROUP BY f.flag_id
		ORDER BY user_count DESC, f.flag_name ASC';
		$result = $this->db->sql_query($sql);

		$flags = array();
		$countries = $users_count = 0;
		while ($row = $this->db->sql_fetchrow($result))
		{
			++$countries;
			$flag_id = $row['flag_id'];
			$user_count = $row['user_count'];
			$users_count = $users_count + $user_count;
			$user_flag_count = $this->user->lang('FLAG_USERS', (int) $user_count);

			$flag_image = $this->functions->get_user_flag($row['flag_id']);

			$this->template->assign_block_vars('flag', array(
				'FLAG' 				=> $flag_image,
				'FLAG_USER_COUNT'	=> $user_flag_count,
				'U_FLAG'			=> $this->helper->route('rmcgirr83_nationalflags_getflags', array('flag_id' => $row['flag_id'])),
			));
		}
		$this->db->sql_freeresult($result);

		$flag_users = $this->user->lang('FLAG_USERS', (int) $users_count);

		$countries = $this->user->lang('FLAGS', (int) $countries);

		$this->template->assign_vars(array(
			'L_FLAGS'	=> $countries . '&nbsp;&nbsp;' . $flag_users,
			'S_FLAGS'		=> true,
		));

		// Assign breadcrumb template vars for the flags page
		$this->template->assign_block_vars('navlinks', array(
			'U_VIEW_FORUM'		=> $this->helper->route('rmcgirr83_nationalflags_display'),
			'FORUM_NAME'		=> $this->user->lang('NATIONAL_FLAGS'),
		));

		// Send all data to the template file
		return $this->helper->render('flags_list.html', $this->user->lang('NATIONAL_FLAGS'));
	}

	/**
	 * Display the users of flags page
	 *
	 * @param $flag_id	int		the id of the flag
	 * @param $page		int		page number we are on
	 * @access public
	 */
	public function getFlags($flag_id, $page = 0)
	{
		// When flags are disabled, redirect users back to the forum index
		if (empty($this->config['allow_flags']))
		{
			redirect(append_sid("{$this->root_path}index.{$this->php_ext}"));
		}

		$flags = $this->cache->get('_user_flags');

		// ensure our flag id passed actually exists in the cache
		if (!isset($flags[$flag_id]))
		{
			throw new NotFoundHttpException($this->user->lang('FLAG_NOT_EXIST'));
		}

		$flag_name = $flags[$flag_id]['flag_name'];
		$page_title = $flag_name;
		if ($page > 1)
		{
			$page_title .= ' - ' . $this->user->lang('PAGE_TITLE_NUMBER', $page);
		}

		$this->display_flag($flag_id, ($page - 1) * $this->config['posts_per_page'], $this->config['posts_per_page']);

		// Send all data to the template file
		return $this->helper->render('flag_users.html', $page_title);
	}

	/**
	 * Display flag
	 *
	 * @param $flag_id		int		the id of the flag
	 * @param $start		int		page number we start at
	 * @param $limit		int		limit to display for pagination
	 * @return null
	 * @access public
	 */
	protected function display_flag($flag_id, $start, $limit)
	{

		//let's get the flag requested
		$sql = 'SELECT flag_id, flag_name, flag_image
			FROM ' . $this->flags_table . '
			WHERE flag_id = ' . (int) $flag_id;
		$result = $this->db->sql_query($sql);
		$row = $this->db->sql_fetchrow($result);
		$this->db->sql_freeresult($result);

		// now users that have the flag
		$sql = 'SELECT *
			FROM ' . USERS_TABLE . '
			WHERE user_flag = ' . (int) $row['flag_id'] . '
				AND ' . $this->db->sql_in_set('user_type', array(USER_NORMAL, USER_FOUNDER)) . '
			ORDER BY username_clean';
		$result = $this->db->sql_query_limit($sql, $limit, $start);
		$rows = $this->db->sql_fetchrowset($result);
		$this->db->sql_freeresult($result);

		// for counting of total flag users
		$result = $this->db->sql_query($sql);
		$row2 = $this->db->sql_fetchrowset($result);
		$total_users = (int) count($row2);
		$this->db->sql_freeresult($result);
		unset($row2);

		foreach ($rows as $userrow)
		{
			$user_id = $userrow['user_id'];

			$username = ($this->auth->acl_get('u_viewprofile')) ? get_username_string('full', $user_id, $userrow['username'], $userrow['user_colour']) : get_username_string('no_profile', $user_id, $userrow['username'], $userrow['user_colour']);

			$this->template->assign_block_vars('user_row', array(
				'JOINED'		=> $this->user->format_date($userrow['user_regdate']),
				'VISITED'		=> (empty($userrow['user_lastvisit'])) ? ' - ' : $this->user->format_date($userrow['user_lastvisit']),
				'POSTS'			=> ($userrow['user_posts']) ? $userrow['user_posts'] : 0,
				'USERNAME_FULL'		=> $username,
				'U_SEARCH_USER'		=> ($this->auth->acl_get('u_search')) ? append_sid("{$this->root_path}search.$this->php_ext", "author_id=$user_id&amp;sr=posts") : '',
			));
		}

		$this->pagination->generate_template_pagination(array(
			'routes' => array(
				'rmcgirr83_nationalflags_getflags',
				'rmcgirr83_nationalflags_getflags_page',
			),
			'params' => array(
				'flag_id' => $flag_id,
			),
		), 'pagination', 'page', $total_users, $limit, $start);

		$flag_image = $this->functions->get_user_flag($row['flag_id']);

		$users_count = $total_users;

		$total_users = $this->user->lang('FLAG_USERS', (int) $total_users);

		$this->template->assign_vars(array(
			'FLAG'			=> html_entity_decode($row['flag_name']),
			'FLAG_IMAGE'	=> $flag_image,
			'TOTAL_USERS'	=> $total_users,
			'S_VIEWONLINE'	=> $this->auth->acl_get('u_viewonline'),
			'S_FLAGS'		=> true,
			'S_FLAG_USERS'	=> (!empty($users_count)) ? true : false,
			'MESSAGE_TEXT'	=> (empty($users_count)) ? $this->user->lang['NO_USER_HAS_FLAG'] : '',
		));

		// Assign breadcrumb template vars for the flags page
		$this->template->assign_block_vars('navlinks', array(
			'U_VIEW_FORUM'		=> $this->helper->route('rmcgirr83_nationalflags_display'),
			'FORUM_NAME'		=> $this->user->lang('NATIONAL_FLAGS'),
		));

		// Assign breadcrumb template vars for the flags page
		$this->template->assign_block_vars('navlinks', array(
			'U_VIEW_FORUM'		=> $this->helper->route('rmcgirr83_nationalflags_getflags', array('flag_id' => $flag_id)),
			'FORUM_NAME'		=> $row['flag_name'],
		));
	}

	/**
	 * Display flag on change in ucp
	 * Ajax function
	 * @param $flag_id
	 *
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function getFlag($flag_id)
	{
		if (empty($flag_id))
		{
			if ($this->config['flags_required'])
			{
				return new Response($this->user->lang['MUST_CHOOSE_FLAG']);
			}
			else
			{
				return new Response($this->user->lang['NO_SUCH_FLAG']);
			}
		}

		$flags = $this->cache->get('_user_flags');

		$flag_img = $this->ext_path . 'flags/' . strtolower($flags[$flag_id]['flag_image']);
		$flag_img = str_replace('./', generate_board_url() . '/', $flag_img); //fix paths

		$flag_name = $flags[$flag_id]['flag_name'];

		$return = '<img class="flag_image" src="' . $flag_img . '" alt="' . $flag_name . '" title="' . $flag_name . '" />';

		return new Response($return);
	}
}
