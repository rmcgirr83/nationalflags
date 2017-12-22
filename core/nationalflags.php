<?php
/**
*
* @package National Flags
* @copyright (c) 2015 Rich McGirr(RMcGirr83)
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

namespace rmcgirr83\nationalflags\core;

use Symfony\Component\HttpFoundation\JsonResponse;
use rmcgirr83\nationalflags\core\flag_position_constants;

class nationalflags
{

	/**
	 * Target flag_is_set
	 */
	protected $flag_is_set = false;

	/** @var \phpbb\config\config */
	protected $config;

	/** @var \phpbb\controller\helper */
	protected $helper;

	/** @var \phpbb\cache\service */
	protected $cache;

	/** @var \phpbb\db\driver\driver */
	protected $db;

	/** @var \phpbb\template\template */
	protected $template;

	/** @var \phpbb\user */
	protected $user;

	/**
	 * The database table the flags are stored in
	 *
	 * @var string
	 */
	protected $flags_table;

	/** @var \phpbb\extension\manager "Extension Manager" */
	protected $ext_manager;

	/** @var \phpbb\path_helper */
	protected $path_helper;

	/** @var \phpbb\files\factory */
	protected $files_factory;

	/**
	 * Constructor
	 *
	 * @param \phpbb\config\config			$config				Config object
	 * @param \phpbb\controller\helper		$helper				Controller helper object
	 * @param \phpbb\cache\service			$cache				Cache object
	 * @param \phpbb\db\driver\driver		$db					Database object
	 * @param \phpbb\template\template		$template			Template object
	 * @param \phpbb\user					$user				User object
	 * @param string						$flags_table		Name of the table used to store flag data
	 * @param \phpbb\extension\manager		$ext_manager		Extension manager object
	 * @param \phpbb\path_helper			$path_helper		Path helper object
	* @param \phpbb\files\factory			$files_factory		File classes factory
	 */
	public function __construct(
			\phpbb\config\config $config,
			\phpbb\controller\helper $helper,
			\phpbb\cache\service $cache,
			\phpbb\db\driver\driver_interface $db,
			\phpbb\template\template $template,
			\phpbb\user $user,
			$flags_table,
			\phpbb\extension\manager $ext_manager,
			\phpbb\path_helper $path_helper,
			\phpbb\files\factory $files_factory = null,
			\phpbb\collapsiblecategories\operator\operator $operator = null)
	{
		$this->config = $config;
		$this->helper = $helper;
		$this->cache = $cache;
		$this->db = $db;
		$this->template = $template;
		$this->user = $user;
		$this->flags_table = $flags_table;
		$this->ext_manager	 = $ext_manager;
		$this->path_helper	 = $path_helper;
		$this->files_factory = $files_factory;
		$this->operator = $operator;

		$this->ext_path = $this->ext_manager->get_extension_path('rmcgirr83/nationalflags', true);
		$this->ext_path_web = $this->path_helper->update_web_root_path($this->ext_path);
	}

	/**
	 * Get user flag
	 *
	 * @return string flag
	 */

	public function get_user_flag($flag_id = false, $size = 0)
	{
		$flags = $this->get_flag_cache();

		if ($flag_id)
		{
			$flag_name = isset($this->user->lang[strtoupper(str_replace(" ", "_", $flags[$flag_id]['flag_name']))]) ? html_entity_decode($this->user->lang[strtoupper(str_replace(" ", "_", $flags[$flag_id]['flag_name']))]) : html_entity_decode($flags_array[$flag_id]['flag_name']);
			$size = (!empty($size)) ? 'style="height:' . $size . 'px; width:auto;"' : '';
			$flag = '<img class="flag_image" src="' . $this->ext_path_web . 'flags/' . $flags[$flag_id]['flag_image'] . '"' . $size . 'alt="' . $flag_name . '" title="' . $flag_name . '" />';

			return $flag;
		}
		return false;
	}
	/**
	 * cache_flags
	 *
	 * Build the cache of the flags
	 *
	 * @return null
	 */

	public function cache_flags()
	{
		if (($this->cache->get('_user_flags')) === false)
		{
			$sql = 'SELECT *
				FROM ' . $this->flags_table . '
			ORDER BY flag_id';
			$result = $this->db->sql_query($sql);

			$user_flags = array();
			while ($row = $this->db->sql_fetchrow($result))
			{
				$user_flags[$row['flag_id']] = array(
					'flag_id'		=> $row['flag_id'],
					'flag_name'		=> $row['flag_name'],
					'flag_image'	=> $row['flag_image'],
					'flag_default'	=> $row['flag_default'],
				);
			}
			$this->db->sql_freeresult($result);

			// cache this data for ever, can only change in ACP
			$this->cache->put('_user_flags', $user_flags);
		}
	}

	/**
	 * Get list_flags
	 *
	 * @param int $flag_id
	 * @return string flag_options
	 */

	public function list_flags($flag_id = false)
	{
		$sql = 'SELECT *
			FROM ' . $this->flags_table . '
		ORDER BY flag_name';
		$result = $this->db->sql_query($sql);

		$flag_options = '<option value="0">' . $this->user->lang['FLAG_EXPLAIN'] . '</option>';
		while ($row = $this->db->sql_fetchrow($result))
		{
			$selected = ($row['flag_id'] == $flag_id && !$this->flag_is_set) ? ' selected="selected"' : '';
			if (!empty($selected))
			{
				$this->flag_is_set = true;
			}
			else if ($row['flag_default'] && !$this->flag_is_set)
			{
				$selected = ' selected="selected"';
			}
			$flag_name = isset($this->user->lang[strtoupper(str_replace(" ", "_", $row['flag_name']))]) ? html_entity_decode($this->user->lang[strtoupper(str_replace(" ", "_", $row['flag_name']))]) : $row['flag_name'];
			$flag_options .= '<option value="' . $row['flag_id'] . '" ' . $selected . '>' . $flag_name . '</option>';
		}
		$this->db->sql_freeresult($result);

		return $flag_options;
	}

	/**
	 * Get top_flags
	 * displayed on the index page
	 */
	public function top_flags()
	{

		// If setting in ACP is set to not allow guests and bots to view the flags
		if (!$this->display_flags_on_forum())
		{
			return false;
		}
		// grab all the flags
		$sql_array = array(
			'SELECT'	=> 'u.user_flag, COUNT(u.user_flag) AS fnum',
			'FROM'		=> array(USERS_TABLE => 'u'),
			'WHERE'		=> $this->db->sql_in_set('u.user_type', array(USER_NORMAL, USER_FOUNDER)) . ' AND u.user_flag > 0',
			'GROUP_BY'	=> 'u.user_flag',
			'ORDER_BY'	=> 'fnum DESC, u.user_flag ASC',
		);

		// we limit the number of flags to display to the number set in the ACP settings
		$result = $this->db->sql_query_limit($this->db->sql_build_query('SELECT', $sql_array), $this->config['flags_num_display']);

		$count = 0;
		$flags = $this->get_flag_cache();

		while ($row = $this->db->sql_fetchrow($result))
		{
			++$count;
			$this->template->assign_block_vars('flag', array(
				'FLAG' 			=> $this->get_user_flag($row['user_flag']),
				'FLAG_USERS'	=> $this->user->lang('FLAG_USERS', (int) $row['fnum']),
				'U_FLAG'		=> $this->helper->route('rmcgirr83_nationalflags_getflags', array('flag_id' => $flags[$row['user_flag']]['flag_id'])),
			));
		}
		$this->db->sql_freeresult($result);

		if ($count)
		{
			if ($this->operator !== null)
			{
				$fid = 'nationalflags'; // can be any unique string to identify your extension's collapsible element
				$this->template->assign_vars(array(
					'S_NATIONALFLAGS_HIDDEN' => in_array($fid, $this->operator->get_user_categories()),
					'U_NATIONALFLAGS_COLLAPSE_URL' => $this->helper->route('phpbb_collapsiblecategories_main_controller', array(
						'forum_id' => $fid,
						'hash' => generate_link_hash("collapsible_$fid")))
				));
			}
			$this->template->assign_vars(array(
				'U_FLAGS'		=> $this->helper->route('rmcgirr83_nationalflags_display'),
				'S_FLAGS'		=> true,
				'PHPBB_IS_32'	=> ($this->files_factory !== null) ? true : false,
			));
		}
	}

	/**
	 * Display flag on change in ucp
	 * Ajax function
	 * @param $flag_id
	 *
	 * @return \Symfony\Component\HttpFoundation\JsonResponse
	 */
	public function getFlag($flag_id)
	{
		$flags = $this->get_flag_cache();

		foreach ($flags as $id => $data)
		{
			$flags_id[] = $id;
		}
		if (!in_array($flag_id, $flags_id))
		{
			if ($this->config['flags_required'])
			{
				return new JsonResponse(array(
					'error' => $this->user->lang['MUST_CHOOSE_FLAG'],
				));
			}
			else
			{
				return new JsonResponse(array(
					'error' => $this->user->lang['NO_SUCH_FLAG'],
				));
			}
		}

		$flag_img = $this->ext_path . 'flags/' . $flags[$flag_id]['flag_image'];
		$flag_img = str_replace('./', generate_board_url() . '/', $flag_img); //fix paths

		$flag_name = isset($this->user->lang[strtoupper(str_replace(" ", "_", $flags[$flag_id]['flag_name']))]) ? $this->user->lang[strtoupper(str_replace(" ", "_", $flags[$flag_id]['flag_name']))] : $flags[$flag_id]['flag_name'];

		$json = new JsonResponse(array(
				'flag_image'     => $flag_img,
				'flag_name'     => $flag_name,
		));
		return $json;
	}

	/**
	 * Get the cache of the flags
	 *
	 * @return string flag_cache
	 * @access public
	 */
	public function get_flag_cache()
	{
		return $this->cache->get('_user_flags');
	}

	/**
	 * Get the cache of the users and their flags
	 *
	 * @return string users and flags
	 * @access public
	 */
	public function get_users_and_flags_cache()
	{
		return $this->cache->get('_users_and_flags');
	}

	/**
	* Display Flag to guests
	*/
	public function display_flags_on_forum()
	{
		if (!$this->config['flags_display_to_guests'])
		{
			$check_display = ($this->user->data['user_id'] == ANONYMOUS || $this->user->data['is_bot']) ? false : true;
			return $check_display;
		}

		return true;
	}

	/**
	* Flag position
	*/
	public function flag_display_position()
	{
		$flag_position_constants = flag_position_constants::getFlagPosition();

		$flag_display_position = '';
		foreach ($flag_position_constants as $name => $value)
		{
			if ($value == $this->config['flag_position'])
			{
				$flag_display_position = 'FLAG_POSITION_' . $name;
			}
		}
		return $flag_display_position;
	}

	/**
	* Build users and flags	A cache of user ids and the applicable flag id
	*
	*/
	public function build_users_and_flags()
	{
		if (($this->cache->get('_users_and_flags')) === false)
		{
			$sql = 'SELECT user_id, user_flag
				FROM ' . USERS_TABLE . '
			WHERE user_flag > 0
			ORDER BY user_id';
			$result = $this->db->sql_query($sql);

			$users_and_flags = array();
			while ($row = $this->db->sql_fetchrow($result))
			{
				$users_and_flags[$row['user_id']] = $row['user_flag'];
			}
			$this->db->sql_freeresult($result);

			// cache this data for 5 minutes, this improves performance
			$this->cache->put('_users_and_flags', $users_and_flags, 300);
		}
	}
}
