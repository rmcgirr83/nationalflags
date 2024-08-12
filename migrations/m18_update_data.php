<?php
/**
*
* @package National Flags
* @copyright (c) 2024 Rich Mcgirr (RMcGirr83)
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace rmcgirr83\nationalflags\migrations;

class m18_update_data extends \phpbb\db\migration\migration
{
	static public function depends_on()
	{
		return ['\rmcgirr83\nationalflags\migrations\m17_add_data'];
	}

	public function update_data()
	{
		return [
			['custom', [
				[&$this, 'flag_update_image']
			]],
		];
	}

	public function flag_update_image()
	{
		// Instead of updating on name, we'll update based on flag image name
		if ($this->db_tools->sql_table_exists($this->table_prefix . 'flags'))
		{
			$sql_ary = [
				[
					'flag_name'		=> 'Colombia',
					'flag_image'	=> 'co.png',
				],
				[
					'flag_name'		=> 'Saint Barthelemy',
					'flag_image'	=> 'bl.png',
				],
			];
			foreach ($sql_ary as $num => $flag)
			{
				$sql = 'UPDATE ' . $this->table_prefix . 'flags
					SET ' . $this->db->sql_build_array('UPDATE', [
								'flag_name' => (string) $flag['flag_name']]
							) .
					" WHERE flag_image = '" . (string) $flag['flag_image'] . "'";
				$this->db->sql_query($sql);
			}
			$sql_ary = [
				[
					'flag_name'		=> 'Wales',
					'flag_image'	=> 'gb-wls.png',
				],
			];
			foreach ($sql_ary as $num => $flag)
			{
				$sql = 'UPDATE ' . $this->table_prefix . 'flags
					SET ' . $this->db->sql_build_array('UPDATE', [
								'flag_image' => (string) $flag['flag_image']]
							) .
					" WHERE flag_name = '" . (string) $flag['flag_name'] . "'";
				$this->db->sql_query($sql);
			}
		}
	}
}
