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

use phpbb\exception\http_exception;

/**
* Main controller
*/
class main_controller
{
	/** @var \phpbb\auth\auth */
	protected $auth;

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
	protected $nationalflags;

	/** @var \phpbb\files\factory */
	protected $files_factory;

	const MAX_SIZE = 30; // Max size img

	/**
	* Constructor
	*
	* @param \phpbb\auth\auth					$auth			Auth object
	* @param \phpbb\config\config               $config         Config object
	* @param \phpbb\db\driver\driver			$db				Database object
	* @param \phpbb\pagination					$pagination		Pagination object
	* @param \phpbb\controller\helper           $helper         Controller helper object
	* @param \phpbb\request\request				$request		Request object
	* @param \phpbb\extension\manager			$ext_manager	Extension manager object
	* @param \phpbb\path_helper					$path_helper	Path helper object
	* @param \phpbb\template\template           $template       Template object
	* @param \phpbb\user                        $user           User object
	* @param string                             $root_path      phpBB root path
	* @param string                             $php_ext        phpEx
	* @param string								$flags_table	Name of the table used to store flag data
	* @param \rmcgirr83\nationalflags\core\nationalflags	$nationalflags	methods to be used by class
	* @param \phpbb\files\factory				$files_factory	File classes factory
	* @access public
	*/
	public function __construct(
			\phpbb\auth\auth $auth,
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
			\rmcgirr83\nationalflags\core\nationalflags $nationalflags,
			\phpbb\files\factory $files_factory = null)
	{
		$this->auth = $auth;
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
		$this->nationalflags = $nationalflags;
		$this->files_factory = $files_factory;

		$this->ext_path = $this->ext_manager->get_extension_path('rmcgirr83/nationalflags', true);
	}

	/**
	 * Display the flags page
	 *
	 * @access public
	 */
	public function displayFlags()
	{
		// If setting in ACP is set to not allow guests and bots to view the flags
		if (!$this->nationalflags->display_flags_on_forum())
		{
			throw new http_exception(401, 'NOT_AUTHORISED');
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

			$flag_image = $this->nationalflags->get_user_flag($row['flag_id']);

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
			'PHPBB_IS_32'	=> ($this->files_factory !== null) ? true : false,
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
		// If setting in ACP is set to not allow guests and bots to view the flags
		if (!$this->nationalflags->display_flags_on_forum())
		{
			throw new http_exception(401, 'NOT_AUTHORISED');
		}

		$flags = $this->nationalflags->get_flag_cache();

		// ensure our flag id passed actually exists in the cache
		if (!isset($flags[$flag_id]))
		{
			throw new http_exception(404, 'FLAG_NOT_EXIST');
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
		// Get users that have the flag
		$sql = 'SELECT *
			FROM ' . USERS_TABLE . '
			WHERE user_flag = ' . (int) $flag_id . '
				AND ' . $this->db->sql_in_set('user_type', array(USER_NORMAL, USER_FOUNDER)) . '
			ORDER BY username_clean';
		$result = $this->db->sql_query_limit($sql, $limit, $start);
		$rows = $this->db->sql_fetchrowset($result);
		$this->db->sql_freeresult($result);

		// for counting of total flag users
		$result = $this->db->sql_query($sql);
		$row2 = $this->db->sql_fetchrowset($result);
		$total_users = (int) sizeof($row2);
		$this->db->sql_freeresult($result);
		unset($row2);

		foreach ($rows as $userrow)
		{
			$user_id = $userrow['user_id'];

			$username = ($this->auth->acl_get('u_viewprofile')) ? get_username_string('full', $user_id, $userrow['username'], $userrow['user_colour']) : get_username_string('no_profile', $user_id, $userrow['username'], $userrow['user_colour']);
			$user_avatar = ($this->user->optionget('viewavatars')) ? phpbb_get_user_avatar($this->avatar_img_resize($userrow)) : '';

			$this->template->assign_block_vars('user_row', array(
				'JOINED'		=> $this->user->format_date($userrow['user_regdate']),
				'VISITED'		=> (empty($userrow['user_lastvisit'])) ? ' - ' : $this->user->format_date($userrow['user_lastvisit']),
				'POSTS'			=> ($userrow['user_posts']) ? $userrow['user_posts'] : 0,
				'USERNAME_FULL'		=> $username,
				'USER_AVATAR'		=> $user_avatar,
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

		$flag_image = $this->nationalflags->get_user_flag((int) $flag_id);

		$users_count = $total_users;

		$total_users = $this->user->lang('FLAG_USERS', (int) $total_users);

		$flags_array = $this->nationalflags->get_flag_cache();

		$flag_name = isset($this->user->lang[strtoupper(str_replace(" ", "_", $flags_array[$flag_id]['flag_name']))]) ? html_entity_decode($this->user->lang[strtoupper(str_replace(" ", "_", $flags_array[$flag_id]['flag_name']))]) : html_entity_decode($flags_array[$flag_id]['flag_name']);

		$this->template->assign_vars(array(
			'FLAG'			=> $flag_name,
			'FLAG_IMAGE'	=> $flag_image,
			'TOTAL_USERS'	=> $total_users,
			'S_VIEWONLINE'	=> $this->auth->acl_get('u_viewonline'),
			'S_FLAGS'		=> true,
			'S_FLAG_USERS'	=> (!empty($users_count)) ? true : false,
			'MESSAGE_TEXT'	=> (empty($users_count)) ? $this->user->lang['NO_USER_HAS_FLAG'] : '',
			'PHPBB_IS_32'	=> ($this->files_factory !== null) ? true : false,
		));

		// Assign breadcrumb template vars for the flags page
		$this->template->assign_block_vars('navlinks', array(
			'U_VIEW_FORUM'		=> $this->helper->route('rmcgirr83_nationalflags_display'),
			'FORUM_NAME'		=> $this->user->lang('NATIONAL_FLAGS'),
		));

		$flag_name = isset($this->user->lang[strtoupper(str_replace(" ", "_", $flags_array[$flag_id]['flag_name']))]) ? html_entity_decode($this->user->lang[strtoupper(str_replace(" ", "_", $flags_array[$flag_id]['flag_name']))]) : html_entity_decode($flags_array[$flag_id]['flag_name']);
		// Assign breadcrumb template vars for the flags page
		$this->template->assign_block_vars('navlinks', array(
			'U_VIEW_FORUM'		=> $this->helper->route('rmcgirr83_nationalflags_getflags', array('flag_id' => $flag_id)),
			'FORUM_NAME'		=> $flag_name,
		));
	}

	/* Generate and resize avatar
	* from last post avatar extension
	*/
	private function avatar_img_resize($avatar)
	{
		if (!empty($avatar['user_avatar']))
		{
			if ($avatar['user_avatar_width'] >= $avatar['user_avatar_height'])
			{
				$avatar_width = ($avatar['user_avatar_width'] > self::MAX_SIZE) ? self::MAX_SIZE : $avatar['user_avatar_width'];
				if ($avatar_width == self::MAX_SIZE)
				{
					$avatar['user_avatar_height'] = round(self::MAX_SIZE/$avatar['user_avatar_width']*$avatar['user_avatar_height']);
				}
				$avatar['user_avatar_width'] = $avatar_width;
			}
			else
			{
				$avatar_height = ($avatar['user_avatar_height'] > self::MAX_SIZE) ? self::MAX_SIZE : $avatar['user_avatar_height'];
				if ($avatar_height == self::MAX_SIZE)
				{
					$avatar['user_avatar_width'] = round(self::MAX_SIZE/$avatar['user_avatar_height']*$avatar['user_avatar_width']);
				}
				$avatar['user_avatar_height'] = $avatar_height;
			}
		}
		else
		{
			$no_avatar = "{$this->path_helper->get_web_root_path()}styles/" . rawurlencode($this->user->style['style_path']) . '/theme/images/no_avatar.gif';
			$avatar = array(
				'user_avatar' => $no_avatar,
				'user_avatar_type' => AVATAR_REMOTE,
				'user_avatar_width' => self::MAX_SIZE,
				'user_avatar_height' => self::MAX_SIZE,
			);
		}
		return $avatar;
	}
}
