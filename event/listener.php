<?php
/**
*
* National Flags extension for the phpBB Forum Software package.
*
* @copyright (c) 2015 Rich McGirr (RMcGirr83)
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace rmcgirr83\nationalflags\event;

/**
* @ignore
*/
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
* Event listener
*/
class listener implements EventSubscriberInterface
{
	/** @var \phpbb\auth\auth */
	protected $auth;

	/** @var \phpbb\cache\service */
	protected $cache;

	/** @var \phpbb\config\config */
	protected $config;

	/** @var \phpbb\controller\helper */
	protected $controller_helper;

	/** @var \phpbb\db\driver\driver */
	protected $db;

	/** @var \phpbb\template\template */
	protected $template;

	/** @var \phpbb\user */
	protected $user;

	/** @var string phpBB root path */
	protected $phpbb_root_path;

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

	/* @var \rmcgirr83\nationalflags\core\ajax_nationalflags */
	protected $ajax_functions;

	public function __construct(
			\phpbb\auth\auth $auth,
			\phpbb\cache\service $cache,
			\phpbb\config\config $config,
			\phpbb\controller\helper $controller_helper,
			\phpbb\db\driver\driver_interface $db,
			\phpbb\template\template $template,
			\phpbb\user $user,
			$phpbb_root_path,
			$php_ext,
			$flags_table,
			$flags_path,
			\rmcgirr83\nationalflags\core\functions_nationalflags $functions,
			\rmcgirr83\nationalflags\core\ajax_nationalflags $ajax)
	{
		$this->auth = $auth;
		$this->cache = $cache;
		$this->config = $config;
		$this->controller_helper = $controller_helper;
		$this->db = $db;
		$this->template = $template;
		$this->user = $user;
		$this->root_path = $phpbb_root_path;
		$this->php_ext = $php_ext;
		$this->flags_table = $flags_table;
		$this->flags_path = $flags_path;
		$this->nf_functions = $functions;
		$this->nf_ajax = $ajax;
	}

	static public function getSubscribedEvents()
	{
		return array(
			'core.user_setup'						=> 'flag_setup',
			'core.page_header_after'				=> 'display_message',
			'core.ucp_profile_modify_profile_info'	=> 'user_flag_profile',
			'core.ucp_profile_info_modify_sql_ary'	=> 'user_flag_sql',
		);
	}

	public function flag_setup($event)
	{
		if (!$this->config['allow_flags'])
		{
			return;
		}
		// Need to ensure the flags are cached on page load
		$this->nf_functions->query_flags();

		$lang_set_ext = $event['lang_set_ext'];
		$lang_set_ext[] = array(
			'ext_name' => 'rmcgirr83/nationalflags',
			'lang_set' => 'common',
		);
		$event['lang_set_ext'] = $lang_set_ext;
	}

	public function display_message($event)
	{
		if (!$this->auth->acl_get('u_chgprofileinfo'))
		{
			return;
		}

		if ($this->config['flags_display_msg'] && $this->config['allow_flags'])
		{
			$this->template->assign_vars(array(
				'S_FLAG_MESSAGE'	=> (empty($this->user->data['user_flag'])) ? true : false,
				'L_FLAG_PROFILE'	=> $this->user->lang('USER_NEEDS_FLAG', '<a href="' . append_sid("{$this->root_path}ucp.$this->php_ext", 'i=profile') . '">', '</a>'),
			));
		}
	}

	public function user_flag_profile($event)
	{
		if (!$this->auth->acl_get('u_chgprofileinfo'))
		{
			return;
		}
		if ($this->config['allow_flags'])
		{
			// Request the user option vars and add them to the data array
			$event['data'] = array_merge($event['data'], array(
				'user_flag'	=> $this->request->variable('user_flag', (int) $this->user->data['user_flag']),
			));

			// Output the data vars to the template (except on form submit)
			if (!$event['submit'])
			{
				$this->template->assign_vars(array(
					'USER_FLAG'	=> $event['data']['user_flag'],
					'S_FLAGS_ENABLED' => true,
				));
			}
		}
	}

	public function user_flag_sql($event)
	{
		$event['sql_ary'] = array_merge($event['sql_ary'], array(
			'user_flag' => $event['data']['user_flag'],
		));
	}
}
