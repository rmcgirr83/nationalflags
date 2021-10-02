<?php
/**
*
* @package National Flags
* @copyright (c) 2015 Rich Mcgirr (RMcGirr83)
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace rmcgirr83\nationalflags\migrations;

class m3_add_data extends \phpbb\db\migration\migration
{
	public function effectively_installed()
	{
		return isset($this->config['nationalflags_version']) && version_compare($this->config['nationalflags_version'], '1.0.1', '>=');
	}

	static public function depends_on()
	{
		return ['\rmcgirr83\nationalflags\migrations\m2_initial_data'];
	}

	public function update_data()
	{
		return [
			['config.add', ['flags_num_display', 10]],
			['config.add', ['flags_display_index', true]],
			['config.update', ['nationalflags_version', '1.0.1']],
		];
	}
}
