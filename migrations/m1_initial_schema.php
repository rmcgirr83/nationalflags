<?php
/**
*
* @package National Flags
* @copyright (c) 2015 Rich McGirr (RMcGirr83)
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace rmcgirr83\nationalflags\migrations;

class m1_initial_schema extends \phpbb\db\migration\migration
{
	public function effectively_installed()
	{
		return $this->db_tools->sql_column_exists($this->table_prefix . 'users', 'user_flag') && $this->db_tools->sql_table_exists($this->table_prefix . 'flags');
	}

	static public function depends_on()
	{
		return array('\phpbb\db\migration\data\v31x\v314rc1');
	}

	public function update_schema()
	{
		return array(
			'add_columns'	=> array(
				$this->table_prefix . 'users'	=> array(
					'user_flag'	=> array('UINT', 0),
				),
			),
			'add_tables'    => array(
				$this->table_prefix . 'flags'        => array(
					'COLUMNS' => array(
						'flag_id' => array('UINT', null, 'auto_increment'),
						'flag_name' => array('VCHAR_UNI:255', ''),
						'flag_image' => array('VCHAR', ''),
					),
					'PRIMARY_KEY'	=> array('flag_id'),
				),
			),
		);
	}

	public function revert_schema()
	{
		return array(
			'drop_columns' => array(
				$this->table_prefix . 'users'	=> array(
					'user_flag',
				),
			),
			'drop_tables' => array(
				$this->table_prefix . 'flags',
			),
		);
	}
}
