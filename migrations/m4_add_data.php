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
		return array('\rmcgirr83\nationalflags\migrations\m3_add_data');
	}

	public function update_data()
	{
		return array(
			array('config.update', array('nationalflags_version', '1.0.2')),
			array('custom', array(
				array(&$this, 'flag_update_images')
			)),
		);
	}

	public function flag_update_images()
	{
		if ($this->db_tools->sql_table_exists($this->table_prefix . 'flags'))
		{
			$sql_ary = array(
				array(
					'flag_name'		=> 'Cocos (Keeling) Islands ',
					'flag_image'	=> 'CC.png',
				),
				array(
					'flag_name'		=> 'Cook Islands',
					'flag_image'	=> 'CK.png',
				),
				array(
					'flag_name'		=> 'Curaçao',
					'flag_image'	=> 'CW.png',
				),
				array(
					'flag_name'		=> 'Christmas Island',
					'flag_image'	=> 'CX.png',
				),
				array(
					'flag_name'		=> 'Gibraltar',
					'flag_image'	=> 'GI.png',
				),
				array(
					'flag_name'		=> 'Saint-Martin (French part)',
					'flag_image'	=> 'MF.png',
				),
				array(
					'flag_name'		=> 'Martinique',
					'flag_image'	=> 'MQ.png',
				),
				array(
					'flag_name'		=> 'New Caledonia',
					'flag_image'	=> 'NC.png',
				),
				array(
					'flag_name'		=> 'Niue',
					'flag_image'	=> 'NU.png',
				),
				array(
					'flag_name'		=> 'French Polynesia',
					'flag_image'	=> 'PF.png',
				),
				array(
					'flag_name'		=> 'South Sudan',
					'flag_image'	=> 'SS.png',
				),
				array(
					'flag_name'		=> 'French Southern Territories',
					'flag_image'	=> 'TF.png',
				),
				array(
					'flag_name'		=> 'Tokelau',
					'flag_image'	=> 'TK.png',
				),
				array(
					'flag_name'		=> 'Wallis and Futuna Islands',
					'flag_image'	=> 'WF.png',
				),
				array(
					'flag_name'		=> 'Mayotte',
					'flag_image'	=> 'YT.png',
				),
			);
			$this->db->sql_multi_insert($this->table_prefix . 'flags', $sql_ary);

			$update_ary = array(
				array(
					'flag_name'	=> 'Korea South',
					'flag_image' => 'KR.png',
				),
				array(
					'flag_name'	=> 'Korea North',
					'flag_image' => 'KP.png',
				),
			);
			foreach ($update_ary as $num => $flag)
			{
				$sql = 'UPDATE ' . $this->table_prefix . 'flags
					SET ' . $this->db->sql_build_array('UPDATE', array(
								'flag_image'	=> (string) $flag['flag_image'])
							) .
					" WHERE flag_name = '" . (string) $flag['flag_name'] . "'";
				$this->db->sql_query($sql);
			}
		}
	}
}
