<?php
/**
*
* @package National Flags
* @copyright (c) 2015 Rich McGirr(RMcGirr83)
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

/**
* @ignore
*/
if (!defined('IN_PHPBB'))
{
	exit;
}

/**
 * Get user flag
 *
 * @param int $row User's flag
 * @return string flag
 */

function get_user_flag($flag_id = false)
{
	global $db, $config, $phpbb_root_path, $cache;

	if (($user_flags = $cache->get('_user_flags')) === false)
	{
	    $user_flags = array();

		$sql = 'SELECT flag_id, flag_name, flag_image
			FROM ' . FLAGS_DATA_TABLE . '
		ORDER BY flag_id';
		$result = $db->sql_query($sql);

		while ($row = $db->sql_fetchrow($result))
		{
			$user_flags[$row['flag_id']] = array(
				'flag_id'		=> $row['flag_id'],
                'flag_name'		=> $row['flag_name'],
                'flag_image'	=> $row['flag_image'],
			);
		}
        $db->sql_freeresult($result);

		// cache this data for ever, can only change in ACP
		$cache->put('_user_flags', $user_flags);
	}
	if ($flag_id)
	{
		//get the display type
		$display = $config['flag_type'];
		if ($display == USER_FLAG_TEXT)//Text only
		{
			$flag = $user_flags[$flag_id]['flag_name'];
		}
		elseif ($display == USER_FLAG_IMAGE)//Image
		{
			$flag = '<img src="' . $phpbb_root_path . 'images/flags/' . $user_flags[$flag_id]['flag_image'] . '" alt="'. htmlspecialchars($user_flags[$flag_id]['flag_name']) . '" title="'. htmlspecialchars($user_flags[$flag_id]['flag_name']) . '" />';
		}
		else// it's not 1 or 2 so it must be 3 which is both
		{
			$flag = $user_flags[$flag_id]['flag_name'] . '<img src="' . $phpbb_root_path . 'images/flags/' . $user_flags[$flag_id]['flag_image'] . '" alt="'. htmlspecialchars($user_flags[$flag_id]['flag_name']) . '" title="'. htmlspecialchars($user_flags[$flag_id]['flag_name']) . '" />';
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

function list_all_flags($flag_id)
{
	global $db, $user;

	$sql = 'SELECT flag_id, flag_name, flag_image
		FROM ' . FLAGS_DATA_TABLE . '
	ORDER BY flag_name';
	$result = $db->sql_query($sql);

	$flag_options = '<option value="0">' . $user->lang['FLAG_EXPLAIN'] . '</option>';
	while ($row = $db->sql_fetchrow($result))
	{
		$selected = ($row['flag_id'] == $flag_id) ? ' selected="selected"' : '';
		$flag_options .= '<option value="' . $row['flag_id'] . '" ' . $selected . '>' . $row['flag_name'] . '</option>';
	}
	$db->sql_freeresult($result);

	return $flag_options;
}

/**
 * Get top_flags
 */
function top_flags()
{
	global $db, $template, $user;

	$sql = 'SELECT user_flag, COUNT(user_flag) AS fnum
		FROM ' . USERS_TABLE . '
	WHERE user_flag > 0
	GROUP BY user_flag
	ORDER BY fnum DESC';
	$result = $db->sql_query_limit($sql, 5);

	$count = 0;
	while ($row = $db->sql_fetchrow($result))
	{
		++$count;

		$template->assign_block_vars('fnum', array(
			'FLAG' 			=> get_user_flag($row['user_flag']),
			'L_FLAG_USERS'	=> $row['fnum'] == 1 ? sprintf($user->lang['FLAG_USER'], $row['fnum']) : sprintf($user->lang['FLAG_USERS'], $row['fnum']),
		));
	}
	$db->sql_freeresult($result);

	if($count)
	{
		$template->assign_vars(array(
			'S_FLAGS_FOUND'	=> true,
		));
	}

	return;
}