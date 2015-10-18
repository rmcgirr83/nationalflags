<?php
/**
*
* @package National Flags
* @copyright (c) 2015 Rich Mcgirr (RMcGirr83)
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace rmcgirr83\nationalflags\migrations;

class m5_update_data extends \phpbb\db\migration\migration
{
	public function effectively_installed()
	{
		return isset($this->config['nationalflags_version']) && version_compare($this->config['nationalflags_version'], '1.0.3', '>=');
	}

	static public function depends_on()
	{
		return array('\rmcgirr83\nationalflags\migrations\m4_add_data');
	}

	public function update_data()
	{
		return array(
			array('config.update', array('nationalflags_version', '1.0.3')),
			array('config.add', array('flags_display_to_guests', true)),
		);
	}
}
