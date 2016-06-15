<?php
/**
*
* @package National Flags
* @copyright (c) 2015 Rich Mcgirr (RMcGirr83)
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace rmcgirr83\nationalflags\migrations;

class m6_update_data extends \phpbb\db\migration\migration
{
	public function effectively_installed()
	{
		return isset($this->config['nationalflags_version']) && version_compare($this->config['nationalflags_version'], '1.0.4', '>=');
	}

	static public function depends_on()
	{
		return array('\rmcgirr83\nationalflags\migrations\m5_update_data');
	}

	public function update_data()
	{
		return array(
			array('config.update', array('nationalflags_version', '1.0.4')),
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
					'flag_name'		=> 'Afghanistan',
					'flag_image'	=> 'af.png',
				),
				array(
					'flag_name'		=> 'Albania',
					'flag_image'	=> 'al.png',
				),
				array(
					'flag_name'		=> 'Algeria',
					'flag_image'	=> 'dz.png',
				),
				array(
					'flag_name'		=> 'American Samoa',
					'flag_image'	=> 'as.png',
				),
				array(
					'flag_name'		=> 'Andorra',
					'flag_image'	=> 'ad.png',
				),
				array(
					'flag_name'		=> 'Angola',
					'flag_image'	=> 'ao.png',
				),
				array(
					'flag_name'		=> 'Anguilla',
					'flag_image'	=> 'ai.png',
				),
				array(
					'flag_name'		=> 'Antigua &amp; Barbuda',
					'flag_image'	=> 'ag.png',
				),
				array(
					'flag_name'		=> 'Argentina',
					'flag_image'	=> 'ar.png',
				),
				array(
					'flag_name'		=> 'Armenia',
					'flag_image'	=> 'am.png',
				),
				array(
					'flag_name'		=> 'Aruba',
					'flag_image'	=> 'aw.png',
				),
				array(
					'flag_name'		=> 'Australia',
					'flag_image'	=> 'au.png',
				),
				array(
					'flag_name'		=> 'Austria',
					'flag_image'	=> 'at.png',
				),
				array(
					'flag_name'		=> 'Azerbaijan',
					'flag_image'	=> 'az.png',
				),
				array(
					'flag_name'		=> 'Bahamas',
					'flag_image'	=> 'bs.png',
				),
				array(
					'flag_name'		=> 'Bahrain',
					'flag_image'	=> 'bh.png',
				),
				array(
					'flag_name'		=> 'Bangladesh',
					'flag_image'	=> 'bd.png',
				),
				array(
					'flag_name'		=> 'Barbados',
					'flag_image'	=> 'bb.png',
				),
				array(
					'flag_name'		=> 'Belarus',
					'flag_image'	=> 'by.png',
				),
				array(
					'flag_name'		=> 'Belgium',
					'flag_image'	=> 'be.png',
				),
				array(
					'flag_name'		=> 'Belize',
					'flag_image'	=> 'bz.png',
				),
				array(
					'flag_name'		=> 'Benin',
					'flag_image'	=> 'bj.png',
				),
				array(
					'flag_name'		=> 'Bermuda',
					'flag_image'	=> 'bm.png',
				),
				array(
					'flag_name'		=> 'Bhutan',
					'flag_image'	=> 'bt.png',
				),
				array(
					'flag_name'		=> 'Bolivia',
					'flag_image'	=> 'bo.png',
				),
				array(
					'flag_name'		=> 'Bonaire',
					'flag_image'	=> 'bl.png',
				),
				array(
					'flag_name'		=> 'Bosnia &amp; Herzegovina',
					'flag_image'	=> 'ba.png',
				),
				array(
					'flag_name'		=> 'Botswana',
					'flag_image'	=> 'bw.png',
				),
				array(
					'flag_name'		=> 'Brazil',
					'flag_image'	=> 'br.png',
				),
				array(
					'flag_name'		=> 'Brunei',
					'flag_image'	=> 'bn.png',
				),
				array(
					'flag_name'		=> 'Bulgaria',
					'flag_image'	=> 'bg.png',
				),
				array(
					'flag_name'		=> 'Burkina Faso',
					'flag_image'	=> 'bf.png',
				),
				array(
					'flag_name'		=> 'Burundi',
					'flag_image'	=> 'bi.png',
				),
				array(
					'flag_name'		=> 'Cambodia',
					'flag_image'	=> 'kh.png',
				),
				array(
					'flag_name'		=> 'Cameroon',
					'flag_image'	=> 'cm.png',
				),
				array(
					'flag_name'		=> 'Canada',
					'flag_image'	=> 'ca.png',
				),
				array(
					'flag_name'		=> 'Cape Verde',
					'flag_image'	=> 'cv.png',
				),
				array(
					'flag_name'		=> 'Cayman Islands',
					'flag_image'	=> 'ky.png',
				),
				array(
					'flag_name'		=> 'Central African Republic',
					'flag_image'	=> 'cf.png',
				),
				array(
					'flag_name'		=> 'Chad',
					'flag_image'	=> 'td.png',
				),
				array(
					'flag_name'		=> 'Chile',
					'flag_image'	=> 'cl.png',
				),
				array(
					'flag_name'		=> 'China',
					'flag_image'	=> 'cn.png',
				),
				array(
					'flag_name'		=> 'Columbia',
					'flag_image'	=> 'co.png',
				),
				array(
					'flag_name'		=> 'Comoros',
					'flag_image'	=> 'km.png',
				),
				array(
					'flag_name'		=> 'Congo',
					'flag_image'	=> 'cg.png',
				),
				array(
					'flag_name'		=> 'Congo Democratic Republic',
					'flag_image'	=> 'cd.png',
				),
				array(
					'flag_name'		=> 'Costa Rica',
					'flag_image'	=> 'cr.png',
				),
				array(
					'flag_name'		=> 'Cote D-Ivoire',
					'flag_image'	=> 'ci.png',
				),
				array(
					'flag_name'		=> 'Croatia',
					'flag_image'	=> 'hr.png',
				),
				array(
					'flag_name'		=> 'Cuba',
					'flag_image'	=> 'cu.png',
				),
				array(
					'flag_name'		=> 'Cyprus',
					'flag_image'	=> 'cy.png',
				),
				array(
					'flag_name'		=> 'Czech Republic',
					'flag_image'	=> 'cz.png',
				),
				array(
					'flag_name'		=> 'Denmark',
					'flag_image'	=> 'dk.png',
				),
				array(
					'flag_name'		=> 'Djibouti',
					'flag_image'	=> 'dj.png',
				),
				array(
					'flag_name'		=> 'Dominica',
					'flag_image'	=> 'dm.png',
				),
				array(
					'flag_name'		=> 'Dominican Republic',
					'flag_image'	=> 'do.png',
				),
				array(
					'flag_name'		=> 'East Timor',
					'flag_image'	=> 'tl.png',
				),
				array(
					'flag_name'		=> 'Ecuador',
					'flag_image'	=> 'ec.png',
				),
				array(
					'flag_name'		=> 'Egypt',
					'flag_image'	=> 'eg.png',
				),
				array(
					'flag_name'		=> 'El Salvador',
					'flag_image'	=> 'sv.png',
				),
				array(
					'flag_name'		=> 'Equatorial Guinea',
					'flag_image'	=> 'gq.png',
				),
				array(
					'flag_name'		=> 'Eritrea',
					'flag_image'	=> 'er.png',
				),
				array(
					'flag_name'		=> 'Estonia',
					'flag_image'	=> 'ee.png',
				),
				array(
					'flag_name'		=> 'Ethiopia',
					'flag_image'	=> 'et.png',
				),
				array(
					'flag_name'		=> 'Falkland Islands',
					'flag_image'	=> 'fk.png',
				),
				array(
					'flag_name'		=> 'Faroe Islands',
					'flag_image'	=> 'fo.png',
				),
				array(
					'flag_name'		=> 'Fiji',
					'flag_image'	=> 'fj.png',
				),
				array(
					'flag_name'		=> 'Finland',
					'flag_image'	=> 'fi.png',
				),
				array(
					'flag_name'		=> 'France',
					'flag_image'	=> 'fr.png',
				),
				array(
					'flag_name'		=> 'Gabon',
					'flag_image'	=> 'ga.png',
				),
				array(
					'flag_name'		=> 'Gambia',
					'flag_image'	=> 'gm.png',
				),
				array(
					'flag_name'		=> 'Georgia',
					'flag_image'	=> 'ge.png',
				),
				array(
					'flag_name'		=> 'Germany',
					'flag_image'	=> 'de.png',
				),
				array(
					'flag_name'		=> 'Ghana',
					'flag_image'	=> 'gh.png',
				),
				array(
					'flag_name'		=> 'Great Britain',
					'flag_image'	=> 'gb.png',
				),
				array(
					'flag_name'		=> 'Greece',
					'flag_image'	=> 'gr.png',
				),
				array(
					'flag_name'		=> 'Greenland',
					'flag_image'	=> 'gl.png',
				),
				array(
					'flag_name'		=> 'Grenada',
					'flag_image'	=> 'gd.png',
				),
				array(
					'flag_name'		=> 'Guam',
					'flag_image'	=> 'gu.png',
				),
				array(
					'flag_name'		=> 'Guatemala',
					'flag_image'	=> 'gt.png',
				),
				array(
					'flag_name'		=> 'Guinea',
					'flag_image'	=> 'gn.png',
				),
				array(
					'flag_name'		=> 'Guinea Bissau',
					'flag_image'	=> 'gw.png',
				),
				array(
					'flag_name'		=> 'Guyana',
					'flag_image'	=> 'gy.png',
				),
				array(
					'flag_name'		=> 'Haiti',
					'flag_image'	=> 'ht.png',
				),
				array(
					'flag_name'		=> 'Honduras',
					'flag_image'	=> 'hn.png',
				),
				array(
					'flag_name'		=> 'Hong Kong',
					'flag_image'	=> 'hk.png',
				),
				array(
					'flag_name'		=> 'Hungary',
					'flag_image'	=> 'hu.png',
				),
				array(
					'flag_name'		=> 'Iceland',
					'flag_image'	=> 'is.png',
				),
				array(
					'flag_name'		=> 'India',
					'flag_image'	=> 'in.png',
				),
				array(
					'flag_name'		=> 'Indonesia',
					'flag_image'	=> 'id.png',
				),
				array(
					'flag_name'		=> 'Iran',
					'flag_image'	=> 'ir.png',
				),
				array(
					'flag_name'		=> 'Iraq',
					'flag_image'	=> 'iq.png',
				),
				array(
					'flag_name'		=> 'Ireland',
					'flag_image'	=> 'ie.png',
				),
				array(
					'flag_name'		=> 'Isle of Man',
					'flag_image'	=> 'im.png',
				),
				array(
					'flag_name'		=> 'Israel',
					'flag_image'	=> 'il.png',
				),
				array(
					'flag_name'		=> 'Italy',
					'flag_image'	=> 'it.png',
				),
				array(
					'flag_name'		=> 'Jamaica',
					'flag_image'	=> 'jm.png',
				),
				array(
					'flag_name'		=> 'Japan',
					'flag_image'	=> 'jp.png',
				),
				array(
					'flag_name'		=> 'Jordan',
					'flag_image'	=> 'jo.png',
				),
				array(
					'flag_name'		=> 'Kazakhstan',
					'flag_image'	=> 'kz.png',
				),
				array(
					'flag_name'		=> 'Kenya',
					'flag_image'	=> 'ke.png',
				),
				array(
					'flag_name'		=> 'Kiribati',
					'flag_image'	=> 'ki.png',
				),
				array(
					'flag_name'		=> 'Korea North',
					'flag_image'	=> 'kp.png',
				),
				array(
					'flag_name'		=> 'Korea South',
					'flag_image'	=> 'kr.png',
				),
				array(
					'flag_name'		=> 'Kuwait',
					'flag_image'	=> 'kw.png',
				),
				array(
					'flag_name'		=> 'Kyrgyzstan',
					'flag_image'	=> 'kg.png',
				),
				array(
					'flag_name'		=> 'Laos',
					'flag_image'	=> 'la.png',
				),
				array(
					'flag_name'		=> 'Latvia',
					'flag_image'	=> 'lv.png',
				),
				array(
					'flag_name'		=> 'Lebanon',
					'flag_image'	=> 'lb.png',
				),
				array(
					'flag_name'		=> 'Lesotho',
					'flag_image'	=> 'ls.png',
				),
				array(
					'flag_name'		=> 'Liberia',
					'flag_image'	=> 'lr.png',
				),
				array(
					'flag_name'		=> 'Libya',
					'flag_image'	=> 'ly.png',
				),
				array(
					'flag_name'		=> 'Liechtenstein',
					'flag_image'	=> 'li.png',
				),
				array(
					'flag_name'		=> 'Lithuania',
					'flag_image'	=> 'lt.png',
				),
				array(
					'flag_name'		=> 'Luxembourg',
					'flag_image'	=> 'lu.png',
				),
				array(
					'flag_name'		=> 'Macau',
					'flag_image'	=> 'mo.png',
				),
				array(
					'flag_name'		=> 'Macedonia',
					'flag_image'	=> 'mk.png',
				),
				array(
					'flag_name'		=> 'Madagascar',
					'flag_image'	=> 'mg.png',
				),
				array(
					'flag_name'		=> 'Malawi',
					'flag_image'	=> 'mw.png',
				),
				array(
					'flag_name'		=> 'Malaysia',
					'flag_image'	=> 'my.png',
				),
				array(
					'flag_name'		=> 'Maldives',
					'flag_image'	=> 'mv.png',
				),
				array(
					'flag_name'		=> 'Mali',
					'flag_image'	=> 'ml.png',
				),
				array(
					'flag_name'		=> 'Malta',
					'flag_image'	=> 'mt.png',
				),
				array(
					'flag_name'		=> 'Marshall Islands',
					'flag_image'	=> 'mh.png',
				),
				array(
					'flag_name'		=> 'Mauritania',
					'flag_image'	=> 'mr.png',
				),
				array(
					'flag_name'		=> 'Mauritius',
					'flag_image'	=> 'mu.png',
				),
				array(
					'flag_name'		=> 'Mexico',
					'flag_image'	=> 'mx.png',
				),
				array(
					'flag_name'		=> 'Micronesia',
					'flag_image'	=> 'fm.png',
				),
				array(
					'flag_name'		=> 'Moldova',
					'flag_image'	=> 'md.png',
				),
				array(
					'flag_name'		=> 'Monaco',
					'flag_image'	=> 'mc.png',
				),
				array(
					'flag_name'		=> 'Mongolia',
					'flag_image'	=> 'mn.png',
				),
				array(
					'flag_name'		=> 'Montserrat',
					'flag_image'	=> 'ms.png',
				),
				array(
					'flag_name'		=> 'Morocco',
					'flag_image'	=> 'ma.png',
				),
				array(
					'flag_name'		=> 'Mozambique',
					'flag_image'	=> 'mz.png',
				),
				array(
					'flag_name'		=> 'Myanmar',
					'flag_image'	=> 'mm.png',
				),
				array(
					'flag_name'		=> 'Nambia',
					'flag_image'	=> 'na.png',
				),
				array(
					'flag_name'		=> 'Nauru',
					'flag_image'	=> 'nr.png',
				),
				array(
					'flag_name'		=> 'Nepal',
					'flag_image'	=> 'np.png',
				),
				array(
					'flag_name'		=> 'Netherland Antilles',
					'flag_image'	=> 'an.png',
				),
				array(
					'flag_name'		=> 'Netherlands',
					'flag_image'	=> 'nl.png',
				),
				array(
					'flag_name'		=> 'New Zealand',
					'flag_image'	=> 'nz.png',
				),
				array(
					'flag_name'		=> 'Nicaragua',
					'flag_image'	=> 'ni.png',
				),
				array(
					'flag_name'		=> 'Niger',
					'flag_image'	=> 'ne.png',
				),
				array(
					'flag_name'		=> 'Nigeria',
					'flag_image'	=> 'ng.png',
				),
				array(
					'flag_name'		=> 'Norfolk Island',
					'flag_image'	=> 'nf.png',
				),
				array(
					'flag_name'		=> 'Norway',
					'flag_image'	=> 'no.png',
				),
				array(
					'flag_name'		=> 'Oman',
					'flag_image'	=> 'om.png',
				),
				array(
					'flag_name'		=> 'Pakistan',
					'flag_image'	=> 'pk.png',
				),
				array(
					'flag_name'		=> 'Palau Island',
					'flag_image'	=> 'pw.png',
				),
				array(
					'flag_name'		=> 'Palestine',
					'flag_image'	=> 'ps.png',
				),
				array(
					'flag_name'		=> 'Panama',
					'flag_image'	=> 'pa.png',
				),
				array(
					'flag_name'		=> 'Papua New Guinea',
					'flag_image'	=> 'pg.png',
				),
				array(
					'flag_name'		=> 'Paraguay',
					'flag_image'	=> 'py.png',
				),
				array(
					'flag_name'		=> 'Peru',
					'flag_image'	=> 'pe.png',
				),
				array(
					'flag_name'		=> 'Philippines',
					'flag_image'	=> 'ph.png',
				),
				array(
					'flag_name'		=> 'Pitcairn Island',
					'flag_image'	=> 'pn.png',
				),
				array(
					'flag_name'		=> 'Poland',
					'flag_image'	=> 'pl.png',
				),
				array(
					'flag_name'		=> 'Portugal',
					'flag_image'	=> 'pt.png',
				),
				array(
					'flag_name'		=> 'Puerto Rico',
					'flag_image'	=> 'pr.png',
				),
				array(
					'flag_name'		=> 'Qatar',
					'flag_image'	=> 'qa.png',
				),
				array(
					'flag_name'		=> 'Romania',
					'flag_image'	=> 'ro.png',
				),
				array(
					'flag_name'		=> 'Russia',
					'flag_image'	=> 'ru.png',
				),
				array(
					'flag_name'		=> 'Rwanda',
					'flag_image'	=> 'rw.png',
				),
				array(
					'flag_name'		=> 'Samoa',
					'flag_image'	=> 'ws.png',
				),
				array(
					'flag_name'		=> 'San Marino',
					'flag_image'	=> 'sm.png',
				),
				array(
					'flag_name'		=> 'Sao Tome &amp; Principe',
					'flag_image'	=> 'st.png',
				),
				array(
					'flag_name'		=> 'Saudi Arabia',
					'flag_image'	=> 'sa.png',
				),
				array(
					'flag_name'		=> 'Senegal',
					'flag_image'	=> 'sn.png',
				),
				array(
					'flag_name'		=> 'Seychelles',
					'flag_image'	=> 'sc.png',
				),
				array(
					'flag_name'		=> 'Sierra Leone',
					'flag_image'	=> 'sl.png',
				),
				array(
					'flag_name'		=> 'Singapore',
					'flag_image'	=> 'sg.png',
				),
				array(
					'flag_name'		=> 'Slovakia',
					'flag_image'	=> 'sk.png',
				),
				array(
					'flag_name'		=> 'Slovenia',
					'flag_image'	=> 'si.png',
				),
				array(
					'flag_name'		=> 'Solomon Islands',
					'flag_image'	=> 'sb.png',
				),
				array(
					'flag_name'		=> 'Somalia',
					'flag_image'	=> 'so.png',
				),
				array(
					'flag_name'		=> 'South Africa',
					'flag_image'	=> 'za.png',
				),
				array(
					'flag_name'		=> 'Spain',
					'flag_image'	=> 'es.png',
				),
				array(
					'flag_name'		=> 'Sri Lanka',
					'flag_image'	=> 'lk.png',
				),
				array(
					'flag_name'		=> 'St Helena',
					'flag_image'	=> 'sh.png',
				),
				array(
					'flag_name'		=> 'St Kitts-Nevis',
					'flag_image'	=> 'kn.png',
				),
				array(
					'flag_name'		=> 'St Lucia',
					'flag_image'	=> 'lc.png',
				),
				array(
					'flag_name'		=> 'St Vincent &amp; Grenadines',
					'flag_image'	=> 'vc.png',
				),
				array(
					'flag_name'		=> 'Sudan',
					'flag_image'	=> 'so.png',
				),
				array(
					'flag_name'		=> 'Suriname',
					'flag_image'	=> 'sr.png',
				),
				array(
					'flag_name'		=> 'Swaziland',
					'flag_image'	=> 'sz.png',
				),
				array(
					'flag_name'		=> 'Sweden',
					'flag_image'	=> 'se.png',
				),
					array(
					'flag_name'		=> 'Switzerland',
					'flag_image'	=> 'ch.png',
				),
				array(
					'flag_name'		=> 'Syria',
					'flag_image'	=> 'sy.png',
				),
				array(
					'flag_name'		=> 'Taiwan',
					'flag_image'	=> 'tw.png',
				),
				array(
					'flag_name'		=> 'Tajikistan',
					'flag_image'	=> 'tj.png',
				),
				array(
					'flag_name'		=> 'Tanzania',
					'flag_image'	=> 'tz.png',
				),
				array(
					'flag_name'		=> 'Thailand',
					'flag_image'	=> 'th.png',
				),
				array(
					'flag_name'		=> 'Togo',
					'flag_image'	=> 'tg.png',
				),
				array(
					'flag_name'		=> 'Tonga',
					'flag_image'	=> 'to.png',
				),
				array(
					'flag_name'		=> 'Trinidad &amp; Tobago',
					'flag_image'	=> 'tt.png',
				),
				array(
					'flag_name'		=> 'Tunisia',
					'flag_image'	=> 'tn.png',
				),
				array(
					'flag_name'		=> 'Turkey',
					'flag_image'	=> 'tr.png',
				),
				array(
					'flag_name'		=> 'Turkmenistan',
					'flag_image'	=> 'tm.png',
				),
				array(
					'flag_name'		=> 'Turks &amp; Caicos Is',
					'flag_image'	=> 'tc.png',
				),
				array(
					'flag_name'		=> 'Tuvalu',
					'flag_image'	=> 'tv.png',
				),
				array(
					'flag_name'		=> 'Uganda',
					'flag_image'	=> 'ug.png',
				),
				array(
					'flag_name'		=> 'Ukraine',
					'flag_image'	=> 'ua.png',
				),
				array(
					'flag_name'		=> 'United Arab Emirates',
					'flag_image'	=> 'ae.png',
				),
				array(
					'flag_name'		=> 'United States of America',
					'flag_image'	=> 'us.png',
				),
				array(
					'flag_name'		=> 'Uruguay',
					'flag_image'	=> 'uy.png',
				),
				array(
					'flag_name'		=> 'Uzbekistan',
					'flag_image'	=> 'uz.png',
				),
				array(
					'flag_name'		=> 'Vanuatu',
					'flag_image'	=> 'vu.png',
				),
				array(
					'flag_name'		=> 'Venezuela',
					'flag_image'	=> 've.png',
				),
				array(
					'flag_name'		=> 'Vietnam',
					'flag_image'	=> 'vn.png',
				),
				array(
					'flag_name'		=> 'Virgin Islands (Brit)',
					'flag_image'	=> 'vg.png',
				),
				array(
					'flag_name'		=> 'Virgin Islands (USA)',
					'flag_image'	=> 'vi.png',
				),
				array(
					'flag_name'		=> 'Wales',
					'flag_image'	=> 'wls.png',
				),
				array(
					'flag_name'		=> 'Western Sahara',
					'flag_image'	=> 'eh.png',
				),
				array(
					'flag_name'		=> 'Yemen',
					'flag_image'	=> 'ye.png',
				),
				array(
					'flag_name'		=> 'Zambia',
					'flag_image'	=> 'zm.png',
				),
				array(
					'flag_name'		=> 'Zimbabwe',
					'flag_image'	=> 'zw.png',
				),
				array(
					'flag_name'		=> 'Cocos (Keeling) Islands ',
					'flag_image'	=> 'cc.png',
				),
				array(
					'flag_name'		=> 'Cook Islands',
					'flag_image'	=> 'ck.png',
				),
				array(
					'flag_name'		=> 'Curaçao',
					'flag_image'	=> 'cw.png',
				),
				array(
					'flag_name'		=> 'Christmas Island',
					'flag_image'	=> 'cx.png',
				),
				array(
					'flag_name'		=> 'Gibraltar',
					'flag_image'	=> 'gi.png',
				),
				array(
					'flag_name'		=> 'Saint-Martin (French part)',
					'flag_image'	=> 'mf.png',
				),
				array(
					'flag_name'		=> 'Martinique',
					'flag_image'	=> 'mq.png',
				),
				array(
					'flag_name'		=> 'New Caledonia',
					'flag_image'	=> 'nc.png',
				),
				array(
					'flag_name'		=> 'Niue',
					'flag_image'	=> 'nu.png',
				),
				array(
					'flag_name'		=> 'French Polynesia',
					'flag_image'	=> 'pf.png',
				),
				array(
					'flag_name'		=> 'South Sudan',
					'flag_image'	=> 'ss.png',
				),
				array(
					'flag_name'		=> 'French Southern Territories',
					'flag_image'	=> 'tf.png',
				),
				array(
					'flag_name'		=> 'Tokelau',
					'flag_image'	=> 'tk.png',
				),
				array(
					'flag_name'		=> 'Wallis and Futuna Islands',
					'flag_image'	=> 'wf.png',
				),
				array(
					'flag_name'		=> 'Mayotte',
					'flag_image'	=> 'yt.png',
				),
			);
			foreach ($sql_ary as $num => $flag)
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
