<?php
/**
*
* @package National Flags
* @copyright (c) 2015 Rich Mcgirr (RMcGirr83)
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace rmcgirr83\nationalflags\migrations;

class m7_update_data extends \phpbb\db\migration\migration
{
	public function effectively_installed()
	{
		return isset($this->config['nationalflags_version']) && version_compare($this->config['nationalflags_version'], '2.0.0', '>=');
	}

	static public function depends_on()
	{
		return array('\rmcgirr83\nationalflags\migrations\m6_update_data');
	}

	public function update_data()
	{
		return array(
			array('config.update', array('nationalflags_version', '2.0.0')),
			array('config.remove', array('allow_flags')),
			array('config.add', array('flag_position', 0)),
		);
	}

	public function update_schema()
	{
		return array(
			'add_columns'	=> array(
				$this->table_prefix . 'flags'        => array(
					'flag_default'	=> array('BOOL', 0),
				),
			),
		);
	}

	public function revert_schema()
	{
		return array(
			'drop_columns'	=> array(
				$this->table_prefix . 'flags'        => array(
					'flag_default',
				),
			),
		);
	}
}
