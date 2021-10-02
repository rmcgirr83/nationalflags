<?php
/**
*
* @package National Flags
* @copyright (c) 2015 Rich Mcgirr (RMcGirr83)
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace rmcgirr83\nationalflags\migrations;

class m4_add_data extends \phpbb\db\migration\migration
{
	public function effectively_installed()
	{
		return isset($this->config['nationalflags_version']) && version_compare($this->config['nationalflags_version'], '1.0.2', '>=');
	}

	static public function depends_on()
	{
		return ['\rmcgirr83\nationalflags\migrations\m3_add_data'];
	}

	public function update_data()
	{
		return [
			['config.update', ['nationalflags_version', '1.0.2']],
			['custom', [
				[&$this, 'flag_update_images']
			]],
		];
	}

	public function flag_update_images()
	{
		if ($this->db_tools->sql_table_exists($this->table_prefix . 'flags'))
		{
			$sql_ary = [
				[
					'flag_name'		=> 'Cocos (Keeling) Islands ',
					'flag_image'	=> 'CC.png',
				],
				[
					'flag_name'		=> 'Cook Islands',
					'flag_image'	=> 'CK.png',
				],
				[
					'flag_name'		=> 'Curaçao',
					'flag_image'	=> 'CW.png',
				],
				[
					'flag_name'		=> 'Christmas Island',
					'flag_image'	=> 'CX.png',
				],
				[
					'flag_name'		=> 'Gibraltar',
					'flag_image'	=> 'GI.png',
				],
				[
					'flag_name'		=> 'Saint-Martin (French part)',
					'flag_image'	=> 'MF.png',
				],
				[
					'flag_name'		=> 'Martinique',
					'flag_image'	=> 'MQ.png',
				],
				[
					'flag_name'		=> 'New Caledonia',
					'flag_image'	=> 'NC.png',
				],
				[
					'flag_name'		=> 'Niue',
					'flag_image'	=> 'NU.png',
				],
				[
					'flag_name'		=> 'French Polynesia',
					'flag_image'	=> 'PF.png',
				],
				[
					'flag_name'		=> 'South Sudan',
					'flag_image'	=> 'SS.png',
				],
				[
					'flag_name'		=> 'French Southern Territories',
					'flag_image'	=> 'TF.png',
				],
				[
					'flag_name'		=> 'Tokelau',
					'flag_image'	=> 'TK.png',
				],
				[
					'flag_name'		=> 'Wallis and Futuna Islands',
					'flag_image'	=> 'WF.png',
				],
				[
					'flag_name'		=> 'Mayotte',
					'flag_image'	=> 'YT.png',
				],
			];
			$this->db->sql_multi_insert($this->table_prefix . 'flags', $sql_ary);

			$update_ary = [
				[
					'flag_name'	=> 'Korea South',
					'flag_image' => 'KR.png',
				],
				[
					'flag_name'	=> 'Korea North',
					'flag_image' => 'KP.png',
				],
			];
			foreach ($update_ary as $num => $flag)
			{
				$sql = 'UPDATE ' . $this->table_prefix . 'flags
					SET ' . $this->db->sql_build_array('UPDATE', [
								'flag_image'	=> (string) $flag['flag_image']]
							) .
					" WHERE flag_name = '" . (string) $flag['flag_name'] . "'";
				$this->db->sql_query($sql);
			}
		}
	}
}
