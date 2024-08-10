<?php
/**
*
* @package National Flags
* @copyright (c) 2024 Rich Mcgirr (RMcGirr83)
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace rmcgirr83\nationalflags\migrations;

class m17_add_data extends \phpbb\db\migration\migration
{

	static public function depends_on()
	{
		return ['\rmcgirr83\nationalflags\migrations\m16_update_data'];
	}

	public function update_data()
	{
		return [
			['custom', [
				[&$this, 'flag_add_flags']
			]],
		];
	}

	public function flag_add_flags()
	{
		if ($this->db_tools->sql_table_exists($this->table_prefix . 'flags'))
		{
			$sql_ary = [
				[
					'flag_name'		=> 'Bouvet Island',
					'flag_image'	=> 'bv.png',
				],
				[
					'flag_name'		=> 'French Guiana',
					'flag_image'	=> 'gf.png',
				],
				[
					'flag_name'		=> 'Guadeloupe',
					'flag_image'	=> 'gp.png',
				],
				[
					'flag_name'		=> 'Heard &amp; McDonald Islands',
					'flag_image'	=> 'hm.png',
				],
				[
					'flag_name'		=> 'British Indian Ocean Territory',
					'flag_image'	=> 'io.png',
				],
				[
					'flag_name'		=> 'Saint Pierre &amp; Miquelon',
					'flag_image'	=> 'pm.png',
				],
				[
					'flag_name'		=> 'Reunion',
					'flag_image'	=> 're.png',
				],
				[
					'flag_name'		=> 'Svalbard &amp; Jan Mayen',
					'flag_image'	=> 'sj.png',
				],
				[
					'flag_name'		=> 'Sint Maarten (Dutch Part)',
					'flag_image'	=> 'sx.png',
				],
				[
					'flag_name'		=> 'United States Minor Outlying Islands',
					'flag_image'	=> 'um.png',
				],
				[
					'flag_name'		=> 'Serbia',
					'flag_image'	=> 'rs.png',
				],
				[
					'flag_name'		=> 'Montenegro',
					'flag_image'	=> 'me.png',
				],
				[
					'flag_name'		=> 'England',
					'flag_image'	=> 'gb-eng.png',
				],
				[
					'flag_name'		=> 'Scotland',
					'flag_image'	=> 'gb-sct.png',
				],
				[
					'flag_name'		=> 'Northern Ireland',
					'flag_image'	=> 'gb-nir.png',
				],
				[
					'flag_name'		=> 'Antarctica',
					'flag_image'	=> 'aq.png',
				],
				[
					'flag_name'		=> 'Aland Islands',
					'flag_image'	=> 'ax.png',
				],
				[
					'flag_name'		=> 'Bonaire Sint Eustatius &amp; Saba',
					'flag_image'	=> 'bq.png',
				],
				[
					'flag_name'		=> 'Guernsey',
					'flag_image'	=> 'gg.png',
				],
				[
					'flag_name'		=> 'South Georgia &amp; the South Sandwich Islands',
					'flag_image'	=> 'gs.png',
				],
				[
					'flag_name'		=> 'Jersey',
					'flag_image'	=> 'je.png',
				],
				[
					'flag_name'		=> 'Northern Mariana Islands',
					'flag_image'	=> 'mp.png',
				],
								[
					'flag_name'		=> 'Holy See',
					'flag_image'	=> 'va.png',
				],
			];
			$this->db->sql_multi_insert($this->table_prefix . 'flags', $sql_ary);
		}
	}
}
