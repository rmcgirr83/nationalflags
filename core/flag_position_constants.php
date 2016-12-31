<?php
/**
*
* @package National Flags
* @copyright (c) 2015 Rich McGirr(RMcGirr83)
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

namespace rmcgirr83\nationalflags\core;

class flag_position_constants
{
	public static function getFlagPosition()
	{
		return array(
			'AFTER_CONTACT_FIELDS' => 0,
			'AFTER_AVATAR' => 1,
			'BEFORE_AVATAR' => 2,
			'AFTER_USER_NAME' => 3,
			'BEFORE_USER_NAME' => 4,
			'ABOVE_RANK' => 5,
			'BELOW_RANK' => 6,
			'AFTER_PROFILE_FIELDS' => 7,
			'BEFORE_PROFILE_FIELDS' => 8,
		);
	}
}
