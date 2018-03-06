<?php
/**
*
* @package National Flags
* @copyright (c) 2018 Rich Mcgirr (RMcGirr83)
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace rmcgirr83\nationalflags\migrations;

class m10_update_data extends \phpbb\db\migration\migration
{
	static public function depends_on()
	{
		return array('\rmcgirr83\nationalflags\migrations\m9_update_data');
	}

	public function update_data()
	{
		return array(
			array('config.add', array('flags_viewforum', true)),
			array('config.add', array('flags_forumrow', true)),
			array('config.add', array('flags_search', true)),
			array('config.add', array('flags_memberlist', true)),
		);
	}
}
