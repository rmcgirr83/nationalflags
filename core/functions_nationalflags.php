<?php
/**
*
* @package National Flags
* @copyright (c) 2015 Rich McGirr(RMcGirr83)
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

namespace rmcgirr83\nationalflags\core;

class functions_topfive
{
	/** @var \phpbb\auth\auth */
	protected $auth;

	/** @var \phpbb\config\config */
	protected $config;

	/** @var \phpbb\cache\service */
	protected $cache;

	/** @var \phpbb\content_visibility */
	protected $content_visibility;

	/** @var \phpbb\db\driver\driver */
	protected $db;

	/** @var \phpbb\event\dispatcher_interface */
	protected $dispatcher;

	/** @var \phpbb\template\template */
	protected $template;

	/** @var \phpbb\user */
	protected $user;

	/** @var string phpBB root path */
	protected $phpbb_root_path;

	/** @var string PHP extension */
	protected $php_ext;

	public function __construct(\phpbb\auth\auth $auth, \phpbb\config\config $config, \phpbb\cache\service $cache, \phpbb\content_visibility $content_visibility, \phpbb\db\driver\driver_interface $db, \phpbb\event\dispatcher_interface $dispatcher, \phpbb\template\template $template, \phpbb\user $user, $phpbb_root_path, $php_ext)
	{
		$this->auth = $auth;
		$this->config = $config;
		$this->cache = $cache;
		$this->content_visibility = $content_visibility;
		$this->db = $db;
		$this->dispatcher = $dispatcher;
		$this->template = $template;
		$this->user = $user;
		$this->root_path = $phpbb_root_path;
		$this->php_ext = $php_ext;
	}
	/**
	 * Get user flag
	 *
	 * @param int $row User's flag
	 * @return string flag
	 */

	public function get_user_flag($flag_id = false)
	{

		if (($user_flags = $this->cache->get('_user_flags')) === false)
		{
			$user_flags = array();

			$sql = 'SELECT flag_id, flag_name, flag_image
				FROM ' . FLAGS_DATA_TABLE . '
			ORDER BY flag_id';
			$result = $this->db->sql_query($sql);

			while ($row = $this->db->sql_fetchrow($result))
			{
				$user_flags[$row['flag_id']] = array(
					'flag_id'		=> $row['flag_id'],
					'flag_name'		=> $row['flag_name'],
					'flag_image'	=> $row['flag_image'],
				);
			}
			$this->db->sql_freeresult($result);

			// cache this data for ever, can only change in ACP
			$this->cache->put('_user_flags', $user_flags);
		}
		if ($flag_id)
		{
			//get the display type
			$display = $this->config['flag_type'];
			if ($display == USER_FLAG_TEXT)//Text only
			{
				$flag = $user_flags[$flag_id]['flag_name'];
			}
			elseif ($display == USER_FLAG_IMAGE)//Image
			{
				$flag = '<img src="' . $this->root_path . 'images/flags/' . $user_flags[$flag_id]['flag_image'] . '" alt="'. htmlspecialchars($user_flags[$flag_id]['flag_name']) . '" title="'. htmlspecialchars($user_flags[$flag_id]['flag_name']) . '" />';
			}
			else// it's not 1 or 2 so it must be 3 which is both
			{
				$flag = $user_flags[$flag_id]['flag_name'] . '<img src="' . $this->root_path . 'images/flags/' . $user_flags[$flag_id]['flag_image'] . '" alt="'. htmlspecialchars($user_flags[$flag_id]['flag_name']) . '" title="'. htmlspecialchars($user_flags[$flag_id]['flag_name']) . '" />';
			}
			return $flag;
		}
		return;
	}

	/**
	 * Get list_all_flags
	 *
	 * @param int $flag_id
	 * @return string flag_options
	 */

	public function list_all_flags($flag_id)
	{
		$sql = 'SELECT flag_id, flag_name, flag_image
			FROM ' . FLAGS_DATA_TABLE . '
		ORDER BY flag_name';
		$result = $this->db->sql_query($sql);

		$flag_options = '<option value="0">' . $this->user->lang['FLAG_EXPLAIN'] . '</option>';
		while ($row = $this->db->sql_fetchrow($result))
		{
			$selected = ($row['flag_id'] == $flag_id) ? ' selected="selected"' : '';
			$flag_options .= '<option value="' . $row['flag_id'] . '" ' . $selected . '>' . $row['flag_name'] . '</option>';
		}
		$this->db->sql_freeresult($result);

		return $flag_options;
	}

	/**
	 * Get top_flags
	 */
	public function top_flags()
	{
		$sql = 'SELECT user_flag, COUNT(user_flag) AS fnum
			FROM ' . USERS_TABLE . '
		WHERE user_flag > 0
		GROUP BY user_flag
		ORDER BY fnum DESC';
		$result = $this->db->sql_query_limit($sql, 5);

		$count = 0;
		while ($row = $this->db->sql_fetchrow($result))
		{
			++$count;

			$template->assign_block_vars('fnum', array(
				'FLAG' 			=> get_user_flag($row['user_flag']),
				'L_FLAG_USERS'	=> $row['fnum'] == 1 ? sprintf($user->lang['FLAG_USER'], $row['fnum']) : sprintf($user->lang['FLAG_USERS'], $row['fnum']),
			));
		}
		$this->db->sql_freeresult($result);

		if($count)
		{
			$this->template->assign_vars(array(
				'S_FLAGS_FOUND'	=> true,
			));
		}
		return;
	}
}