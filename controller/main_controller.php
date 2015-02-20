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
	/** @var \phpbb\cache\service */
	protected $cache;

	/** @var \phpbb\config\config */
	protected $config;

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
			\phpbb\cache\service $cache,
			\phpbb\config\config $config,
			\phpbb\controller\helper $helper,
			\phpbb\template\template $template,
			\phpbb\user $user,
			$root_path,
			$php_ext,
			$flags_path,
			\rmcgirr83\nationalflags\core\functions_nationalflags $functions)
	{
		$this->cache = $cache;
		$this->config = $config;
		$this->helper = $helper;
		$this->template = $template;
		$this->user = $user;
		$this->root_path = $root_path;
		$this->php_ext = $php_ext;
		$this->flags_path = $flags_path;
		$this->nf_functions = $functions;
	}

	/**
	* Display the flags page
	*
	* @return \Symfony\Component\HttpFoundation\Response A Symfony Response object
	* @access public
	*/
	public function display()
	{
		// When flags are disabled, redirect users back to the forum index
		if (empty($this->config['allow_flags']))
		{
			redirect(append_sid("{$this->root_path}index.{$this->php_ext}"));
		}

		// Assign values to template vars for the flags page
		$this->template->assign_vars(array(
/*
			'USER_FLAGS'		=> true,
			'PAGE_NUMBER'		=> on_page($total_users, (int) $config['topics_per_page'], $start),
			'TOTAL_USERS'		=> ($total_users <> 1) ? sprintf($user->lang['FLAG_USERS'], $total_users) : sprintf($user->lang['FLAG_USER'], $total_users),
			'PAGINATION'		=> generate_pagination($pagination_url, $total_users, $config['topics_per_page'], $start),
			'U_SORT_USERNAME'		=> $sort_url . '&amp;sk=a&amp;sd=' . (($sort_key == 'a' && $sort_dir == 'a') ? 'd' : 'a'),
			'U_SORT_JOINED'			=> $sort_url . '&amp;sk=c&amp;sd=' . (($sort_key == 'c' && $sort_dir == 'a') ? 'd' : 'a'),
			'U_SORT_POSTS'			=> $sort_url . '&amp;sk=d&amp;sd=' . (($sort_key == 'd' && $sort_dir == 'a') ? 'd' : 'a'),
			'U_SORT_WEBSITE'		=> $sort_url . '&amp;sk=f&amp;sd=' . (($sort_key == 'f' && $sort_dir == 'a') ? 'd' : 'a'),
			'U_SORT_LOCATION'		=> $sort_url . '&amp;sk=b&amp;sd=' . (($sort_key == 'b' && $sort_dir == 'a') ? 'd' : 'a'),
			'U_SORT_ACTIVE'			=> ($auth->acl_get('u_viewonline')) ? $sort_url . '&amp;sk=l&amp;sd=' . (($sort_key == 'l' && $sort_dir == 'a') ? 'd' : 'a') : '',
			'U_LIST_CHAR'			=> $sort_url . '&amp;sk=a&amp;sd=' . (($sort_key == 'l' && $sort_dir == 'a') ? 'd' : 'a'),
			'S_MODE_SELECT'		=> $s_sort_key,
			'S_ORDER_SELECT'	=> $s_sort_dir,
			'S_MODE_ACTION'		=> $pagination_url,
*/
		));

		// Assign breadcrumb template vars for the flags page
		$this->template->assign_block_vars('navlinks', array(
			'U_VIEW_FORUM'		=> $this->helper->route('rmcgirr83_nationalflags_main_controller'),
			'FORUM_NAME'		=> $this->user->lang('FLAGS'),
		));

		// Send all data to the template file
		return $this->helper->render('nationalflags_controller.html', $this->user->lang('FLAGS'));
	}

	/**
	 * Display flag on change in ucp
	 *
	 * @param $id
	 *
	 * @return \Symfony\Component\HttpFoundation\JsonResponse
	 */
	public function getFlag($id)
	{
		if (empty($id))
		{
			return;
		}

		$flag = $this->cache->get('_user_flags');
		$flag_img = $this->flags_path . $flag[$id]['flag_image'];
		$flag_name = $flag[$id]['flag_name'];

		$return = '<img src="' . $flag_img . '" alt="' . $flag_name .'" title="' . $flag_name .'" style="vertical-align:middle;" />';

		return new Response($return);
	}
}
