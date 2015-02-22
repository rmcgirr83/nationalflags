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
	protected $helper;

	/** @var \phpbb\db\driver\driver */
	protected $db;

	/** @var \phpbb\request\request */
	protected $request;

	/** @var \phpbb\template\template */
	protected $template;

	/** @var \phpbb\user */
	protected $user;

	/** @var string phpBB root path */
	protected $phpbb_root_path;

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

	public function __construct(
			\phpbb\auth\auth $auth,
			\phpbb\cache\service $cache,
			\phpbb\config\config $config,
			\phpbb\controller\helper $helper,
			\phpbb\db\driver\driver_interface $db,
			\phpbb\request\request $request,
			\phpbb\template\template $template,
			\phpbb\user $user,
			$phpbb_root_path,
			$php_ext,
			$flags_path,
			\rmcgirr83\nationalflags\core\functions_nationalflags $functions)
	{
		$this->auth = $auth;
		$this->cache = $cache;
		$this->config = $config;
		$this->helper = $helper;
		$this->db = $db;
		$this->request = $request;
		$this->template = $template;
		$this->user = $user;
		$this->root_path = $phpbb_root_path;
		$this->php_ext = $php_ext;
		$this->flags_path = $flags_path;
		$this->nf_functions = $functions;
	}

	/**
	* Assign functions defined in this class to event listeners in the core
	*
	* @return array
	* @static
	* @access public
	*/
	static public function getSubscribedEvents()
	{
		return array(
			'core.user_setup'						=> 'flag_setup',
			'core.index_modify_page_title'			=> 'main',
			'core.page_header_after'				=> 'display_message',
			'core.ucp_profile_modify_profile_info'	=> 'user_flag_profile',
			'core.ucp_profile_info_modify_sql_ary'	=> 'user_flag_profile_sql',
			'core.ucp_register_data'				=> 'user_flag_registration',
			'core.ucp_register_data_check'			=> 'user_flag_registration_check',
			'core.ucp_register_user_row_after'		=> 'user_flag_registration_sql',
			'core.viewonline_overwrite_location'	=> 'viewonline_page',
			'core.viewtopic_cache_user_data'		=> 'viewtopic_cache_user_data',
			'core.viewtopic_cache_guest_data'		=> 'viewtopic_cache_guest_data',
			'core.viewtopic_modify_post_row'		=> 'viewtopic_modify_post_row',
			'core.memberlist_view_profile'			=> 'memberlist_view_profile',
		);
	}

	/**
	* Set up the flags and add the lang vars
	*
	* @param object $event The event object
	* @return null
	* @access public
	*/
	public function flag_setup($event)
	{
		if (empty($this->config['allow_flags']))
		{
			return;
		}
		// Need to ensure the flags are cached on page load
		$this->nf_functions->cache_flags();

		$this->template->assign_vars(array(
			'S_FLAGS'	=> $this->config['allow_flags'],
			'U_FLAGS'	=> $this->helper->route('rmcgirr83_nationalflags_main_controller'),
		));

		$lang_set_ext = $event['lang_set_ext'];
		$lang_set_ext[] = array(
			'ext_name' => 'rmcgirr83/nationalflags',
			'lang_set' => 'common',
		);
		$event['lang_set_ext'] = $lang_set_ext;
	}
	/**
	* Set up the flags on the index page
	*
	* @param object $event The event object
	* @return null
	* @access public
	*/
	public function main($event)
	{
		if (empty($this->config['allow_flags']))
		{
			return;
		}
		//display flags on the index page
		$this->nf_functions->top_flags();
	}
	/**
	* Create URL and message to users if wanted.
	*
	* @param object $event The event object
	* @return null
	* @access public
	*/
	public function display_message($event)
	{
		if (!$this->auth->acl_get('u_chgprofileinfo') || empty($this->config['allow_flags']))
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

	/**
	* Allow users to change their flag
	*
	* @param object $event The event object
	* @return null
	* @access public
	*/
	public function user_flag_profile($event)
	{
		if (empty($this->config['allow_flags']))
		{
			return;
		}

		// Request the user option vars and add them to the data array
		$event['data'] = array_merge($event['data'], array(
			'user_flag'	=> $this->request->variable('user_flag', $this->user->data['user_flag']),
		));

		// Output the data vars to the template (except on form submit)
		if (!$event['submit'])
		{
			$flags = $this->cache->get('_user_flags');
			$flag_name = $flag_image = '';
			$flag_id = 0;
			if ($event['data']['user_flag'])
			{
				$flag_name = $flags[$event['data']['user_flag']]['flag_name'];
				$flag_image = $flags[$event['data']['user_flag']]['flag_image'];
				$flag_id = $flags[$event['data']['user_flag']]['flag_id'];
			}

			$s_flag_options = $this->nf_functions->list_all_flags($event['data']['user_flag']);

			$this->template->assign_vars(array(
				'USER_FLAG'		=> $event['data']['user_flag'],
				'FLAG_IMAGE'	=> ($flag_image) ? $this->flags_path . $flag_image : '',
				'FLAG_NAME'		=> $flag_name,
				'S_FLAGS_ENABLED'	=> true,
				'S_FLAG_OPTIONS'	=> $s_flag_options,
				'AJAX_FLAG_INFO' 	=> $this->helper->route('rmcgirr83_nationalflags_getflag_controller', array('flag_id' => 'FLAG_ID')),
			));
		}
	}

	/**
	* User changed their flag so update the database
	*
	* @param object $event The event object
	* @return null
	* @access public
	*/
	public function user_flag_profile_sql($event)
	{
		if (empty($this->config['allow_flags']))
		{
			return;
		}
		$event['sql_ary'] = array_merge($event['sql_ary'], array(
				'user_flag' => $event['data']['user_flag'],
		));
	}

	/**
	* Allow users to select a flag on registration
	*
	* @param object $event The event object
	* @return null
	* @access public
	*/
	public function user_flag_registration($event)
	{
		if (empty($this->config['allow_flags']) || empty($this->config['flags_on_reg']))
		{
			return;
		}

		// Request the user option vars and add them to the data array
		$event['data'] = array_merge($event['data'], array(
			'user_flag'	=> $this->request->variable('user_flag', $this->user->data['user_flag']),
		));

		$flags = $this->cache->get('_user_flags');
		$flag_name = $flag_image = '';
		$flag_id = 0;
		if ($event['data']['user_flag'])
		{
			$flag_name = $flags[$event['data']['user_flag']]['flag_name'];
			$flag_image = $flags[$event['data']['user_flag']]['flag_image'];
			$flag_id = $flags[$event['data']['user_flag']]['flag_id'];
		}

		$s_flag_options = $this->nf_functions->list_all_flags($event['data']['user_flag']);

		$this->template->assign_vars(array(
			'USER_FLAG'		=> $event['data']['user_flag'],
			'FLAG_IMAGE'	=> ($flag_image) ? $this->flags_path . $flag_image : '',
			'FLAG_NAME'		=> $flag_name,
			'S_FLAGS_ENABLED'	=> true,
			'S_FLAG_OPTIONS'	=> $s_flag_options,
			'AJAX_FLAG_INFO' 	=> $this->helper->route('rmcgirr83_nationalflags_getflag_controller', array('flag_id' => 'FLAG_ID')),
		));
	}

	/**
	* check registration data
	*
	* @param object $event The event object
	* @return null
	* @access public
	*/
	public function user_flag_registration_check($event)
	{
		if (empty($this->config['allow_flags']) || empty($this->config['flags_on_reg']))
		{
			return;
		}

		if ($event['submit'] && empty($event['data']['user_flag']))
		{
			$array = $event['error'];
			$array[] = $this->user->lang['MUST_CHOOSE_FLAG'];
			$event['error'] = $array;
		}
	}

	/**
	* Update registration data
	*
	* @param object $event The event object
	* @return null
	* @access public
	*/
	public function user_flag_registration_sql($event)
	{
		if (empty($this->config['allow_flags']) || empty($this->config['flags_on_reg']))
		{
			return;
		}

		$event['user_row'] = array_merge($event['user_row'], array(
				'user_flag' => $this->request->variable('user_flag', 0),
		));
	}

	/**
	* Show users as viewing the flags on Who Is Online page
	*
	* @param object $event The event object
	* @return null
	* @access public
	*/
	public function viewonline_page($event)
	{
		if ($event['on_page'][1] == 'app')
		{
			if (strrpos($event['row']['session_page'], 'app.' . $this->php_ext . '/flags') === 0)
			{
				$event['location'] = $this->user->lang('FLAGS_VIEWONLINE');
				$event['location_url'] = $this->helper->route('rmcgirr83_nationalflags_main_controller');
			}
		}
	}

	public function viewtopic_cache_user_data($event)
	{
		if (empty($this->config['allow_flags']))
		{
			return;
		}
		$array = $event['user_cache_data'];
		$flag = $this->nf_functions->get_user_flag($event['row']['user_flag']);
		$array['user_flag'] = $flag;
		$event['user_cache_data'] = $array;
	}

	public function viewtopic_cache_guest_data($event)
	{
		if (empty($this->config['allow_flags']))
		{
			return;
		}

		$array = $event['user_cache_data'];
		$flag = '';
		$array['user_flag'] = $flag;
		$event['user_cache_data'] = $array;
	}

	public function viewtopic_modify_post_row($event)
	{
		if (empty($this->config['allow_flags']))
		{
			return;
		}

		$event['post_row'] = array_merge($event['post_row'], array('USER_FLAG' => $event['user_poster_data']['user_flag']));
	}

	public function memberlist_view_profile($event)
	{
		if (empty($this->config['allow_flags']))
		{
			return;
		}
		$flag = $this->nf_functions->get_user_flag($event['member']['user_flag']);

		$this->template->assign_vars(array(
			'NATIONAL_FLAG'	=> $flag,
			'U_FLAG'		=> $this->helper->route('rmcgirr83_nationalflags_getflagusers_controller', array('flag_id' => $event['member']['user_flag'])),
		));
	}
}
