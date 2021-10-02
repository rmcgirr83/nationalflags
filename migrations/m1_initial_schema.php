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
		return ['\phpbb\db\migration\data\v31x\v314rc1'];
	}

	public function update_schema()
	{
		return [
			'add_columns'	=> [
				$this->table_prefix . 'users'	=> [
					'user_flag'	=> ['UINT', 0],
				],
			],
			'add_tables'    => [
				$this->table_prefix . 'flags'        => [
					'COLUMNS' => [
						'flag_id' => ['UINT', null, 'auto_increment'],
						'flag_name' => ['VCHAR_UNI:255', ''],
						'flag_image' => ['VCHAR', ''],
					],
					'PRIMARY_KEY'	=> ['flag_id'],
				],
			],
		];
	}

	public function revert_schema()
	{
		return [
			'drop_columns' => [
				$this->table_prefix . 'users'	=> [
					'user_flag',
				],
			],
			'drop_tables' => [
				$this->table_prefix . 'flags',
			],
		];
	}
}
