<?php
/**
*
* @package National Flags
* @copyright (c) 2020 Rich McGirr (RMcGirr83)
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace rmcgirr83\nationalflags\migrations;

class m2_schema extends \phpbb\db\migration\migration
{
	static public function depends_on()
	{
		return ['\phpbb\db\migration\data\v30x\release_3_0_0'];
	}

	public function update_schema()
	{
		return [
			'add_index' => [
				$this->table_prefix . 'users' => [
					'user_flag' => ['user_flag'],
				],
			],
		];
	}

	public function revert_schema()
	{
		return [
			'drop_keys' => [
				$this->table_prefix . 'users' => [
					'user_flag'
				],
			],
		];
	}
}
