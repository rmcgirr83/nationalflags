<?php
/**
*
* @package National Flags
* @copyright (c) 2015 Rich Mcgirr (RMcGirr83)
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace rmcgirr83\nationalflags\migrations;

class m2_initial_data extends \phpbb\db\migration\migration
{
	public function effectively_installed()
	{
		return isset($this->config['nationalflags_version']) && version_compare($this->config['nationalflags_version'], '1.0.0', '>=');
	}

	static public function depends_on()
	{
		return array('\rmcgirr83\nationalflags\migrations\m1_initial_schema');
	}

	public function update_data()
	{
		return array(
			array('config.add', array('nationalflags_version', '1.0.0')),
			array('config.add', array('allow_flags', false)),
			array('config.add', array('flags_display_msg', true)),
			array('config.add', array('flags_required', true)),
			array('module.add', array('acp', 'ACP_CAT_DOT_MODS', 'ACP_CAT_FLAGS')),
			array('module.add', array(
				'acp', 'ACP_CAT_FLAGS', array(
					'module_basename'	=> '\rmcgirr83\nationalflags\acp\nationalflags_module',
					'modes'				=> array('config', 'manage'),
				),
			)),
			array('custom', array(
				array(&$this, 'flag_install_images')
			)),
		);
	}

	public function flag_install_images()
	{
		if ($this->db_tools->sql_table_exists($this->table_prefix . 'flags'))
		{
			$sql_ary = array(
				array(
					'flag_name'		=> 'Afghanistan',
					'flag_image'	=> 'AF.png',
				),
				array(
					'flag_name'		=> 'Albania',
					'flag_image'	=> 'AL.png',
				),
				array(
					'flag_name'		=> 'Algeria',
					'flag_image'	=> 'DZ.png',
				),
				array(
					'flag_name'		=> 'American Samoa',
					'flag_image'	=> 'AS.png',
				),
				array(
					'flag_name'		=> 'Andorra',
					'flag_image'	=> 'AD.png',
				),
				array(
					'flag_name'		=> 'Angola',
					'flag_image'	=> 'AO.png',
				),
				array(
					'flag_name'		=> 'Anguilla',
					'flag_image'	=> 'AI.png',
				),
				array(
					'flag_name'		=> 'Antigua &amp; Barbuda',
					'flag_image'	=> 'AG.png',
				),
				array(
					'flag_name'		=> 'Argentina',
					'flag_image'	=> 'AR.png',
				),
				array(
					'flag_name'		=> 'Armenia',
					'flag_image'	=> 'AM.png',
				),
				array(
					'flag_name'		=> 'Aruba',
					'flag_image'	=> 'AW.png',
				),
				array(
					'flag_name'		=> 'Australia',
					'flag_image'	=> 'AU.png',
				),
				array(
					'flag_name'		=> 'Austria',
					'flag_image'	=> 'AT.png',
				),
				array(
					'flag_name'		=> 'Azerbaijan',
					'flag_image'	=> 'AZ.png',
				),
				array(
					'flag_name'		=> 'Bahamas',
					'flag_image'	=> 'BS.png',
				),
				array(
					'flag_name'		=> 'Bahrain',
					'flag_image'	=> 'BH.png',
				),
				array(
					'flag_name'		=> 'Bangladesh',
					'flag_image'	=> 'BD.png',
				),
				array(
					'flag_name'		=> 'Barbados',
					'flag_image'	=> 'BB.png',
				),
				array(
					'flag_name'		=> 'Belarus',
					'flag_image'	=> 'BY.png',
				),
				array(
					'flag_name'		=> 'Belgium',
					'flag_image'	=> 'BE.png',
				),
				array(
					'flag_name'		=> 'Belize',
					'flag_image'	=> 'BZ.png',
				),
				array(
					'flag_name'		=> 'Benin',
					'flag_image'	=> 'BJ.png',
				),
				array(
					'flag_name'		=> 'Bermuda',
					'flag_image'	=> 'BM.png',
				),
				array(
					'flag_name'		=> 'Bhutan',
					'flag_image'	=> 'BT.png',
				),
				array(
					'flag_name'		=> 'Bolivia',
					'flag_image'	=> 'BO.png',
				),
				array(
					'flag_name'		=> 'Bonaire',
					'flag_image'	=> 'BL.png',
				),
				array(
					'flag_name'		=> 'Bosnia &amp; Herzegovina',
					'flag_image'	=> 'BA.png',
				),
				array(
					'flag_name'		=> 'Botswana',
					'flag_image'	=> 'BW.png',
				),
				array(
					'flag_name'		=> 'Brazil',
					'flag_image'	=> 'BR.png',
				),
				array(
					'flag_name'		=> 'Brunei',
					'flag_image'	=> 'BN.png',
				),
				array(
					'flag_name'		=> 'Bulgaria',
					'flag_image'	=> 'BG.png',
				),
				array(
					'flag_name'		=> 'Burkina Faso',
					'flag_image'	=> 'BF.png',
				),
				array(
					'flag_name'		=> 'Burundi',
					'flag_image'	=> 'BI.png',
				),
				array(
					'flag_name'		=> 'Cambodia',
					'flag_image'	=> 'KH.png',
				),
				array(
					'flag_name'		=> 'Cameroon',
					'flag_image'	=> 'CM.png',
				),
				array(
					'flag_name'		=> 'Canada',
					'flag_image'	=> 'CA.png',
				),
				array(
					'flag_name'		=> 'Cape Verde',
					'flag_image'	=> 'CV.png',
				),
				array(
					'flag_name'		=> 'Cayman Islands',
					'flag_image'	=> 'KY.png',
				),
				array(
					'flag_name'		=> 'Central African Republic',
					'flag_image'	=> 'CF.png',
				),
				array(
					'flag_name'		=> 'Chad',
					'flag_image'	=> 'TD.png',
				),
				array(
					'flag_name'		=> 'Chile',
					'flag_image'	=> 'CL.png',
				),
				array(
					'flag_name'		=> 'China',
					'flag_image'	=> 'CN.png',
				),
				array(
					'flag_name'		=> 'Columbia',
					'flag_image'	=> 'CO.png',
				),
				array(
					'flag_name'		=> 'Comoros',
					'flag_image'	=> 'KM.png',
				),
				array(
					'flag_name'		=> 'Congo',
					'flag_image'	=> 'CG.png',
				),
				array(
					'flag_name'		=> 'Congo Democratic Republic',
					'flag_image'	=> 'CD.png',
				),
				array(
					'flag_name'		=> 'Costa Rica',
					'flag_image'	=> 'CR.png',
				),
				array(
					'flag_name'		=> 'Cote D-Ivoire',
					'flag_image'	=> 'CI.png',
				),
				array(
					'flag_name'		=> 'Croatia',
					'flag_image'	=> 'HR.png',
				),
				array(
					'flag_name'		=> 'Cuba',
					'flag_image'	=> 'CU.png',
				),
				array(
					'flag_name'		=> 'Cyprus',
					'flag_image'	=> 'CY.png',
				),
				array(
					'flag_name'		=> 'Czech Republic',
					'flag_image'	=> 'CZ.png',
				),
				array(
					'flag_name'		=> 'Denmark',
					'flag_image'	=> 'DK.png',
				),
				array(
					'flag_name'		=> 'Djibouti',
					'flag_image'	=> 'DJ.png',
				),
				array(
					'flag_name'		=> 'Dominica',
					'flag_image'	=> 'DM.png',
				),
				array(
					'flag_name'		=> 'Dominican Republic',
					'flag_image'	=> 'DO.png',
				),
				array(
					'flag_name'		=> 'East Timor',
					'flag_image'	=> 'TL.png',
				),
				array(
					'flag_name'		=> 'Ecuador',
					'flag_image'	=> 'EC.png',
				),
				array(
					'flag_name'		=> 'Egypt',
					'flag_image'	=> 'EG.png',
				),
				array(
					'flag_name'		=> 'El Salvador',
					'flag_image'	=> 'SV.png',
				),
				array(
					'flag_name'		=> 'Equatorial Guinea',
					'flag_image'	=> 'GQ.png',
				),
				array(
					'flag_name'		=> 'Eritrea',
					'flag_image'	=> 'ER.png',
				),
				array(
					'flag_name'		=> 'Estonia',
					'flag_image'	=> 'EE.png',
				),
				array(
					'flag_name'		=> 'Ethiopia',
					'flag_image'	=> 'ET.png',
				),
				array(
					'flag_name'		=> 'Falkland Islands',
					'flag_image'	=> 'FK.png',
				),
				array(
					'flag_name'		=> 'Faroe Islands',
					'flag_image'	=> 'FO.png',
				),
				array(
					'flag_name'		=> 'Fiji',
					'flag_image'	=> 'FJ.png',
				),
				array(
					'flag_name'		=> 'Finland',
					'flag_image'	=> 'FI.png',
				),
				array(
					'flag_name'		=> 'France',
					'flag_image'	=> 'FR.png',
				),
				array(
					'flag_name'		=> 'Gabon',
					'flag_image'	=> 'GA.png',
				),
				array(
					'flag_name'		=> 'Gambia',
					'flag_image'	=> 'GM.png',
				),
				array(
					'flag_name'		=> 'Georgia',
					'flag_image'	=> 'GE.png',
				),
				array(
					'flag_name'		=> 'Germany',
					'flag_image'	=> 'DE.png',
				),
				array(
					'flag_name'		=> 'Ghana',
					'flag_image'	=> 'GH.png',
				),
				array(
					'flag_name'		=> 'Great Britain',
					'flag_image'	=> 'GB.png',
				),
				array(
					'flag_name'		=> 'Greece',
					'flag_image'	=> 'GR.png',
				),
				array(
					'flag_name'		=> 'Greenland',
					'flag_image'	=> 'GL.png',
				),
				array(
					'flag_name'		=> 'Grenada',
					'flag_image'	=> 'GD.png',
				),
				array(
					'flag_name'		=> 'Guam',
					'flag_image'	=> 'GU.png',
				),
				array(
					'flag_name'		=> 'Guatemala',
					'flag_image'	=> 'GT.png',
				),
				array(
					'flag_name'		=> 'Guinea',
					'flag_image'	=> 'GN.png',
				),
				array(
					'flag_name'		=> 'Guinea Bissau',
					'flag_image'	=> 'GW.png',
				),
				array(
					'flag_name'		=> 'Guyana',
					'flag_image'	=> 'GY.png',
				),
				array(
					'flag_name'		=> 'Haiti',
					'flag_image'	=> 'HT.png',
				),
				array(
					'flag_name'		=> 'Honduras',
					'flag_image'	=> 'HN.png',
				),
				array(
					'flag_name'		=> 'Hong Kong',
					'flag_image'	=> 'HK.png',
				),
				array(
					'flag_name'		=> 'Hungary',
					'flag_image'	=> 'HU.png',
				),
				array(
					'flag_name'		=> 'Iceland',
					'flag_image'	=> 'IS.png',
				),
				array(
					'flag_name'		=> 'India',
					'flag_image'	=> 'IN.png',
				),
				array(
					'flag_name'		=> 'Indonesia',
					'flag_image'	=> 'ID.png',
				),
				array(
					'flag_name'		=> 'Iran',
					'flag_image'	=> 'IR.png',
				),
				array(
					'flag_name'		=> 'Iraq',
					'flag_image'	=> 'IQ.png',
				),
				array(
					'flag_name'		=> 'Ireland',
					'flag_image'	=> 'IE.png',
				),
				array(
					'flag_name'		=> 'Isle of Man',
					'flag_image'	=> 'IM.png',
				),
				array(
					'flag_name'		=> 'Israel',
					'flag_image'	=> 'IL.png',
				),
				array(
					'flag_name'		=> 'Italy',
					'flag_image'	=> 'IT.png',
				),
				array(
					'flag_name'		=> 'Jamaica',
					'flag_image'	=> 'JM.png',
				),
				array(
					'flag_name'		=> 'Japan',
					'flag_image'	=> 'JP.png',
				),
				array(
					'flag_name'		=> 'Jordan',
					'flag_image'	=> 'JO.png',
				),
				array(
					'flag_name'		=> 'Kazakhstan',
					'flag_image'	=> 'KZ.png',
				),
				array(
					'flag_name'		=> 'Kenya',
					'flag_image'	=> 'KE.png',
				),
				array(
					'flag_name'		=> 'Kiribati',
					'flag_image'	=> 'KI.png',
				),
				array(
					'flag_name'		=> 'Korea North',
					'flag_image'	=> 'NK.png',
				),
				array(
					'flag_name'		=> 'Korea South',
					'flag_image'	=> 'KS.png',
				),
				array(
					'flag_name'		=> 'Kuwait',
					'flag_image'	=> 'KW.png',
				),
				array(
					'flag_name'		=> 'Kyrgyzstan',
					'flag_image'	=> 'KG.png',
				),
				array(
					'flag_name'		=> 'Laos',
					'flag_image'	=> 'LA.png',
				),
				array(
					'flag_name'		=> 'Latvia',
					'flag_image'	=> 'LV.png',
				),
				array(
					'flag_name'		=> 'Lebanon',
					'flag_image'	=> 'LB.png',
				),
				array(
					'flag_name'		=> 'Lesotho',
					'flag_image'	=> 'LS.png',
				),
				array(
					'flag_name'		=> 'Liberia',
					'flag_image'	=> 'LR.png',
				),
				array(
					'flag_name'		=> 'Libya',
					'flag_image'	=> 'LY.png',
				),
				array(
					'flag_name'		=> 'Liechtenstein',
					'flag_image'	=> 'LI.png',
				),
				array(
					'flag_name'		=> 'Lithuania',
					'flag_image'	=> 'LT.png',
				),
				array(
					'flag_name'		=> 'Luxembourg',
					'flag_image'	=> 'LU.png',
				),
				array(
					'flag_name'		=> 'Macau',
					'flag_image'	=> 'MO.png',
				),
				array(
					'flag_name'		=> 'Macedonia',
					'flag_image'	=> 'MK.png',
				),
				array(
					'flag_name'		=> 'Madagascar',
					'flag_image'	=> 'MG.png',
				),
				array(
					'flag_name'		=> 'Malawi',
					'flag_image'	=> 'MW.png',
				),
				array(
					'flag_name'		=> 'Malaysia',
					'flag_image'	=> 'MY.png',
				),
				array(
					'flag_name'		=> 'Maldives',
					'flag_image'	=> 'MV.png',
				),
				array(
					'flag_name'		=> 'Mali',
					'flag_image'	=> 'ML.png',
				),
				array(
					'flag_name'		=> 'Malta',
					'flag_image'	=> 'MT.png',
				),
				array(
					'flag_name'		=> 'Marshall Islands',
					'flag_image'	=> 'MH.png',
				),
				array(
					'flag_name'		=> 'Mauritania',
					'flag_image'	=> 'MR.png',
				),
				array(
					'flag_name'		=> 'Mauritius',
					'flag_image'	=> 'MU.png',
				),
				array(
					'flag_name'		=> 'Mexico',
					'flag_image'	=> 'MX.png',
				),
				array(
					'flag_name'		=> 'Micronesia',
					'flag_image'	=> 'FM.png',
				),
				array(
					'flag_name'		=> 'Moldova',
					'flag_image'	=> 'MD.png',
				),
				array(
					'flag_name'		=> 'Monaco',
					'flag_image'	=> 'MC.png',
				),
				array(
					'flag_name'		=> 'Mongolia',
					'flag_image'	=> 'MN.png',
				),
				array(
					'flag_name'		=> 'Montserrat',
					'flag_image'	=> 'MS.png',
				),
				array(
					'flag_name'		=> 'Morocco',
					'flag_image'	=> 'MA.png',
				),
				array(
					'flag_name'		=> 'Mozambique',
					'flag_image'	=> 'MZ.png',
				),
				array(
					'flag_name'		=> 'Myanmar',
					'flag_image'	=> 'MM.png',
				),
				array(
					'flag_name'		=> 'Nambia',
					'flag_image'	=> 'NA.png',
				),
				array(
					'flag_name'		=> 'Nauru',
					'flag_image'	=> 'NR.png',
				),
				array(
					'flag_name'		=> 'Nepal',
					'flag_image'	=> 'NP.png',
				),
				array(
					'flag_name'		=> 'Netherland Antilles',
					'flag_image'	=> 'AN.png',
				),
				array(
					'flag_name'		=> 'Netherlands',
					'flag_image'	=> 'NL.png',
				),
				array(
					'flag_name'		=> 'New Zealand',
					'flag_image'	=> 'NZ.png',
				),
				array(
					'flag_name'		=> 'Nicaragua',
					'flag_image'	=> 'NI.png',
				),
				array(
					'flag_name'		=> 'Niger',
					'flag_image'	=> 'NE.png',
				),
				array(
					'flag_name'		=> 'Nigeria',
					'flag_image'	=> 'NG.png',
				),
				array(
					'flag_name'		=> 'Norfolk Island',
					'flag_image'	=> 'NF.png',
				),
				array(
					'flag_name'		=> 'Norway',
					'flag_image'	=> 'NO.png',
				),
				array(
					'flag_name'		=> 'Oman',
					'flag_image'	=> 'OM.png',
				),
				array(
					'flag_name'		=> 'Pakistan',
					'flag_image'	=> 'PK.png',
				),
				array(
					'flag_name'		=> 'Palau Island',
					'flag_image'	=> 'PW.png',
				),
				array(
					'flag_name'		=> 'Palestine',
					'flag_image'	=> 'PS.png',
				),
				array(
					'flag_name'		=> 'Panama',
					'flag_image'	=> 'PA.png',
				),
				array(
					'flag_name'		=> 'Papua New Guinea',
					'flag_image'	=> 'PG.png',
				),
				array(
					'flag_name'		=> 'Paraguay',
					'flag_image'	=> 'PY.png',
				),
				array(
					'flag_name'		=> 'Peru',
					'flag_image'	=> 'PE.png',
				),
				array(
					'flag_name'		=> 'Philippines',
					'flag_image'	=> 'PH.png',
				),
				array(
					'flag_name'		=> 'Pitcairn Island',
					'flag_image'	=> 'PN.png',
				),
				array(
					'flag_name'		=> 'Poland',
					'flag_image'	=> 'PL.png',
				),
				array(
					'flag_name'		=> 'Portugal',
					'flag_image'	=> 'PT.png',
				),
				array(
					'flag_name'		=> 'Puerto Rico',
					'flag_image'	=> 'PR.png',
				),
				array(
					'flag_name'		=> 'Qatar',
					'flag_image'	=> 'QA.png',
				),
				array(
					'flag_name'		=> 'Romania',
					'flag_image'	=> 'RO.png',
				),
				array(
					'flag_name'		=> 'Russia',
					'flag_image'	=> 'RU.png',
				),
				array(
					'flag_name'		=> 'Rwanda',
					'flag_image'	=> 'RW.png',
				),
				array(
					'flag_name'		=> 'Samoa',
					'flag_image'	=> 'WS.png',
				),
				array(
					'flag_name'		=> 'San Marino',
					'flag_image'	=> 'SM.png',
				),
				array(
					'flag_name'		=> 'Sao Tome &amp; Principe',
					'flag_image'	=> 'ST.png',
				),
				array(
					'flag_name'		=> 'Saudi Arabia',
					'flag_image'	=> 'SA.png',
				),
				array(
					'flag_name'		=> 'Senegal',
					'flag_image'	=> 'SN.png',
				),
				array(
					'flag_name'		=> 'Seychelles',
					'flag_image'	=> 'SC.png',
				),
				array(
					'flag_name'		=> 'Sierra Leone',
					'flag_image'	=> 'SL.png',
				),
				array(
					'flag_name'		=> 'Singapore',
					'flag_image'	=> 'SG.png',
				),
				array(
					'flag_name'		=> 'Slovakia',
					'flag_image'	=> 'SK.png',
				),
				array(
					'flag_name'		=> 'Slovenia',
					'flag_image'	=> 'SI.png',
				),
				array(
					'flag_name'		=> 'Solomon Islands',
					'flag_image'	=> 'SB.png',
				),
				array(
					'flag_name'		=> 'Somalia',
					'flag_image'	=> 'SO.png',
				),
				array(
					'flag_name'		=> 'South Africa',
					'flag_image'	=> 'ZA.png',
				),
				array(
					'flag_name'		=> 'Spain',
					'flag_image'	=> 'ES.png',
				),
				array(
					'flag_name'		=> 'Sri Lanka',
					'flag_image'	=> 'LK.png',
				),
				array(
					'flag_name'		=> 'St Helena',
					'flag_image'	=> 'SH.png',
				),
				array(
					'flag_name'		=> 'St Kitts-Nevis',
					'flag_image'	=> 'KN.png',
				),
				array(
					'flag_name'		=> 'St Lucia',
					'flag_image'	=> 'LC.png',
				),
				array(
					'flag_name'		=> 'St Vincent &amp; Grenadines',
					'flag_image'	=> 'VC.png',
				),
				array(
					'flag_name'		=> 'Sudan',
					'flag_image'	=> 'SD.png',
				),
				array(
					'flag_name'		=> 'Suriname',
					'flag_image'	=> 'SR.png',
				),
				array(
					'flag_name'		=> 'Swaziland',
					'flag_image'	=> 'SZ.png',
				),
				array(
					'flag_name'		=> 'Sweden',
					'flag_image'	=> 'SE.png',
				),
					array(
					'flag_name'		=> 'Switzerland',
					'flag_image'	=> 'CH.png',
				),
				array(
					'flag_name'		=> 'Syria',
					'flag_image'	=> 'SY.png',
				),
				array(
					'flag_name'		=> 'Taiwan',
					'flag_image'	=> 'TW.png',
				),
				array(
					'flag_name'		=> 'Tajikistan',
					'flag_image'	=> 'TJ.png',
				),
				array(
					'flag_name'		=> 'Tanzania',
					'flag_image'	=> 'TZ.png',
				),
				array(
					'flag_name'		=> 'Thailand',
					'flag_image'	=> 'TH.png',
				),
				array(
					'flag_name'		=> 'Togo',
					'flag_image'	=> 'TG.png',
				),
				array(
					'flag_name'		=> 'Tonga',
					'flag_image'	=> 'TO.png',
				),
				array(
					'flag_name'		=> 'Trinidad &amp; Tobago',
					'flag_image'	=> 'TT.png',
				),
				array(
					'flag_name'		=> 'Tunisia',
					'flag_image'	=> 'TN.png',
				),
				array(
					'flag_name'		=> 'Turkey',
					'flag_image'	=> 'TR.png',
				),
				array(
					'flag_name'		=> 'Turkmenistan',
					'flag_image'	=> 'TM.png',
				),
				array(
					'flag_name'		=> 'Turks &amp; Caicos Is',
					'flag_image'	=> 'TC.png',
				),
				array(
					'flag_name'		=> 'Tuvalu',
					'flag_image'	=> 'TV.png',
				),
				array(
					'flag_name'		=> 'Uganda',
					'flag_image'	=> 'UG.png',
				),
				array(
					'flag_name'		=> 'Ukraine',
					'flag_image'	=> 'UA.png',
				),
				array(
					'flag_name'		=> 'United Arab Emirates',
					'flag_image'	=> 'AE.png',
				),
				array(
					'flag_name'		=> 'United States of America',
					'flag_image'	=> 'US.png',
				),
				array(
					'flag_name'		=> 'Uruguay',
					'flag_image'	=> 'UY.png',
				),
				array(
					'flag_name'		=> 'Uzbekistan',
					'flag_image'	=> 'UZ.png',
				),
				array(
					'flag_name'		=> 'Vanuatu',
					'flag_image'	=> 'VU.png',
				),
				array(
					'flag_name'		=> 'Venezuela',
					'flag_image'	=> 'VE.png',
				),
				array(
					'flag_name'		=> 'Vietnam',
					'flag_image'	=> 'VN.png',
				),
				array(
					'flag_name'		=> 'Virgin Islands (Brit)',
					'flag_image'	=> 'VG.png',
				),
				array(
					'flag_name'		=> 'Virgin Islands (USA)',
					'flag_image'	=> 'VI.png',
				),
				array(
					'flag_name'		=> 'Wales',
					'flag_image'	=> 'WLS.png',
				),
				array(
					'flag_name'		=> 'Western Sahara',
					'flag_image'	=> 'EH.png',
				),
				array(
					'flag_name'		=> 'Yemen',
					'flag_image'	=> 'YE.png',
				),
				array(
					'flag_name'		=> 'Zambia',
					'flag_image'	=> 'ZM.png',
				),
				array(
					'flag_name'		=> 'Zimbabwe',
					'flag_image'	=> 'ZW.png',
				),
			);
			$this->db->sql_multi_insert($this->table_prefix . 'flags', $sql_ary);
		}
	}
}
