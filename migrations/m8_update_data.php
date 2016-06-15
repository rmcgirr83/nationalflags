<?php
/**
*
* @package National Flags
* @copyright (c) 2015 Rich Mcgirr (RMcGirr83)
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace rmcgirr83\nationalflags\migrations;

class m8_update_data extends \phpbb\db\migration\migration
{
	static public function depends_on()
	{
		return array('\rmcgirr83\nationalflags\migrations\m7_update_data');
	}

	public function update_data()
	{
		return array(
			array('config.remove', array('nationalflags_version')),
		);
	}
}
