<?php
/**
*
* @package National Flags
* @copyright (c) 2015 Rich McGirr
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
	/* @var \rmcgirr83\topfive\core\functions_nationalflags */
	/*protected $nf_functions;*/

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

	public function __construct(/*\rmcgirr83\nationalflags\core\functions_nationalflags $functions,*/ \phpbb\config\config $config, \phpbb\controller\helper $controller_helper, \phpbb\db\driver\driver_interface $db, \phpbb\template\template $template, \phpbb\user $user, $phpbb_root_path, $php_ext)
	{
		/*$this->nf_functions = $functions;*/
		$this->config = $config;
		$this->controller_helper = $controller_helper;
		$this->db = $db;
		$this->template = $template;
		$this->user = $user;
		$this->root_path = $phpbb_root_path;
		$this->php_ext = $php_ext;
	}

	static public function getSubscribedEvents()
	{

		return array(
			'core.user_setup' => 'load_language_on_setup',
			'core.page_header_after'	=> 'display_message',
		);
	}

	public function load_language_on_setup($event)
	{
		$lang_set_ext = $event['lang_set_ext'];
		$lang_set_ext[] = array(
			'ext_name' => 'rmcgirr83/nationalflags',
			'lang_set' => 'common',
		);
		$event['lang_set_ext'] = $lang_set_ext;
	}

	public function display_message($event)
	{
		if (!$this->config['flags_display_msg'])
		{
			return;
		}

		if ($this->config['allow_flags'])
		{
			$this->template->assign_vars(array(
				'S_FLAG_MESSAGE'	=> (empty($this->user->data['user_flag'])) ? true : false,
				'L_FLAG_PROFILE'	=> $this->user->lang('USER_NEEDS_FLAG', '<a href="' . append_sid("{$this->root_path}ucp.$this->php_ext", 'i=profile') . '">', '</a>'),
			));
		}
	}
}
