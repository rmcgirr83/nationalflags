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
		return ['\rmcgirr83\nationalflags\migrations\m1_initial_schema'];
	}

	public function update_data()
	{
		return [
			['config.add', ['nationalflags_version', '1.0.0']],
			['config.add', ['allow_flags', false]],
			['config.add', ['flags_display_msg', true]],
			['config.add', ['flags_required', true]],
			['module.add', ['acp', 'ACP_CAT_DOT_MODS', 'ACP_CAT_FLAGS']],
			['module.add', [
				'acp', 'ACP_CAT_FLAGS', [
					'module_basename'	=> '\rmcgirr83\nationalflags\acp\nationalflags_module',
					'modes'				=> ['config', 'manage'],
				],
			]],
			['custom', [
				[&$this, 'flag_install_images']
			]],
		];
	}

	public function flag_install_images()
	{
		if ($this->db_tools->sql_table_exists($this->table_prefix . 'flags'))
		{
			$sql_ary = [
				[
					'flag_name'		=> 'Afghanistan',
					'flag_image'	=> 'AF.png',
				],
				[
					'flag_name'		=> 'Albania',
					'flag_image'	=> 'AL.png',
				],
				[
					'flag_name'		=> 'Algeria',
					'flag_image'	=> 'DZ.png',
				],
				[
					'flag_name'		=> 'American Samoa',
					'flag_image'	=> 'AS.png',
				],
				[
					'flag_name'		=> 'Andorra',
					'flag_image'	=> 'AD.png',
				],
				[
					'flag_name'		=> 'Angola',
					'flag_image'	=> 'AO.png',
				],
				[
					'flag_name'		=> 'Anguilla',
					'flag_image'	=> 'AI.png',
				],
				[
					'flag_name'		=> 'Antigua &amp; Barbuda',
					'flag_image'	=> 'AG.png',
				],
				[
					'flag_name'		=> 'Argentina',
					'flag_image'	=> 'AR.png',
				],
				[
					'flag_name'		=> 'Armenia',
					'flag_image'	=> 'AM.png',
				],
				[
					'flag_name'		=> 'Aruba',
					'flag_image'	=> 'AW.png',
				],
				[
					'flag_name'		=> 'Australia',
					'flag_image'	=> 'AU.png',
				],
				[
					'flag_name'		=> 'Austria',
					'flag_image'	=> 'AT.png',
				],
				[
					'flag_name'		=> 'Azerbaijan',
					'flag_image'	=> 'AZ.png',
				],
				[
					'flag_name'		=> 'Bahamas',
					'flag_image'	=> 'BS.png',
				],
				[
					'flag_name'		=> 'Bahrain',
					'flag_image'	=> 'BH.png',
				],
				[
					'flag_name'		=> 'Bangladesh',
					'flag_image'	=> 'BD.png',
				],
				[
					'flag_name'		=> 'Barbados',
					'flag_image'	=> 'BB.png',
				],
				[
					'flag_name'		=> 'Belarus',
					'flag_image'	=> 'BY.png',
				],
				[
					'flag_name'		=> 'Belgium',
					'flag_image'	=> 'BE.png',
				],
				[
					'flag_name'		=> 'Belize',
					'flag_image'	=> 'BZ.png',
				],
				[
					'flag_name'		=> 'Benin',
					'flag_image'	=> 'BJ.png',
				],
				[
					'flag_name'		=> 'Bermuda',
					'flag_image'	=> 'BM.png',
				],
				[
					'flag_name'		=> 'Bhutan',
					'flag_image'	=> 'BT.png',
				],
				[
					'flag_name'		=> 'Bolivia',
					'flag_image'	=> 'BO.png',
				],
				[
					'flag_name'		=> 'Bonaire',
					'flag_image'	=> 'BL.png',
				],
				[
					'flag_name'		=> 'Bosnia &amp; Herzegovina',
					'flag_image'	=> 'BA.png',
				],
				[
					'flag_name'		=> 'Botswana',
					'flag_image'	=> 'BW.png',
				],
				[
					'flag_name'		=> 'Brazil',
					'flag_image'	=> 'BR.png',
				],
				[
					'flag_name'		=> 'Brunei',
					'flag_image'	=> 'BN.png',
				],
				[
					'flag_name'		=> 'Bulgaria',
					'flag_image'	=> 'BG.png',
				],
				[
					'flag_name'		=> 'Burkina Faso',
					'flag_image'	=> 'BF.png',
				],
				[
					'flag_name'		=> 'Burundi',
					'flag_image'	=> 'BI.png',
				],
				[
					'flag_name'		=> 'Cambodia',
					'flag_image'	=> 'KH.png',
				],
				[
					'flag_name'		=> 'Cameroon',
					'flag_image'	=> 'CM.png',
				],
				[
					'flag_name'		=> 'Canada',
					'flag_image'	=> 'CA.png',
				],
				[
					'flag_name'		=> 'Cape Verde',
					'flag_image'	=> 'CV.png',
				],
				[
					'flag_name'		=> 'Cayman Islands',
					'flag_image'	=> 'KY.png',
				],
				[
					'flag_name'		=> 'Central African Republic',
					'flag_image'	=> 'CF.png',
				],
				[
					'flag_name'		=> 'Chad',
					'flag_image'	=> 'TD.png',
				],
				[
					'flag_name'		=> 'Chile',
					'flag_image'	=> 'CL.png',
				],
				[
					'flag_name'		=> 'China',
					'flag_image'	=> 'CN.png',
				],
				[
					'flag_name'		=> 'Columbia',
					'flag_image'	=> 'CO.png',
				],
				[
					'flag_name'		=> 'Comoros',
					'flag_image'	=> 'KM.png',
				],
				[
					'flag_name'		=> 'Congo',
					'flag_image'	=> 'CG.png',
				],
				[
					'flag_name'		=> 'Congo Democratic Republic',
					'flag_image'	=> 'CD.png',
				],
				[
					'flag_name'		=> 'Costa Rica',
					'flag_image'	=> 'CR.png',
				],
				[
					'flag_name'		=> 'Cote D-Ivoire',
					'flag_image'	=> 'CI.png',
				],
				[
					'flag_name'		=> 'Croatia',
					'flag_image'	=> 'HR.png',
				],
				[
					'flag_name'		=> 'Cuba',
					'flag_image'	=> 'CU.png',
				],
				[
					'flag_name'		=> 'Cyprus',
					'flag_image'	=> 'CY.png',
				],
				[
					'flag_name'		=> 'Czech Republic',
					'flag_image'	=> 'CZ.png',
				],
				[
					'flag_name'		=> 'Denmark',
					'flag_image'	=> 'DK.png',
				],
				[
					'flag_name'		=> 'Djibouti',
					'flag_image'	=> 'DJ.png',
				],
				[
					'flag_name'		=> 'Dominica',
					'flag_image'	=> 'DM.png',
				],
				[
					'flag_name'		=> 'Dominican Republic',
					'flag_image'	=> 'DO.png',
				],
				[
					'flag_name'		=> 'East Timor',
					'flag_image'	=> 'TL.png',
				],
				[
					'flag_name'		=> 'Ecuador',
					'flag_image'	=> 'EC.png',
				],
				[
					'flag_name'		=> 'Egypt',
					'flag_image'	=> 'EG.png',
				],
				[
					'flag_name'		=> 'El Salvador',
					'flag_image'	=> 'SV.png',
				],
				[
					'flag_name'		=> 'Equatorial Guinea',
					'flag_image'	=> 'GQ.png',
				],
				[
					'flag_name'		=> 'Eritrea',
					'flag_image'	=> 'ER.png',
				],
				[
					'flag_name'		=> 'Estonia',
					'flag_image'	=> 'EE.png',
				],
				[
					'flag_name'		=> 'Ethiopia',
					'flag_image'	=> 'ET.png',
				],
				[
					'flag_name'		=> 'Falkland Islands',
					'flag_image'	=> 'FK.png',
				],
				[
					'flag_name'		=> 'Faroe Islands',
					'flag_image'	=> 'FO.png',
				],
				[
					'flag_name'		=> 'Fiji',
					'flag_image'	=> 'FJ.png',
				],
				[
					'flag_name'		=> 'Finland',
					'flag_image'	=> 'FI.png',
				],
				[
					'flag_name'		=> 'France',
					'flag_image'	=> 'FR.png',
				],
				[
					'flag_name'		=> 'Gabon',
					'flag_image'	=> 'GA.png',
				],
				[
					'flag_name'		=> 'Gambia',
					'flag_image'	=> 'GM.png',
				],
				[
					'flag_name'		=> 'Georgia',
					'flag_image'	=> 'GE.png',
				],
				[
					'flag_name'		=> 'Germany',
					'flag_image'	=> 'DE.png',
				],
				[
					'flag_name'		=> 'Ghana',
					'flag_image'	=> 'GH.png',
				],
				[
					'flag_name'		=> 'Great Britain',
					'flag_image'	=> 'GB.png',
				],
				[
					'flag_name'		=> 'Greece',
					'flag_image'	=> 'GR.png',
				],
				[
					'flag_name'		=> 'Greenland',
					'flag_image'	=> 'GL.png',
				],
				[
					'flag_name'		=> 'Grenada',
					'flag_image'	=> 'GD.png',
				],
				[
					'flag_name'		=> 'Guam',
					'flag_image'	=> 'GU.png',
				],
				[
					'flag_name'		=> 'Guatemala',
					'flag_image'	=> 'GT.png',
				],
				[
					'flag_name'		=> 'Guinea',
					'flag_image'	=> 'GN.png',
				],
				[
					'flag_name'		=> 'Guinea Bissau',
					'flag_image'	=> 'GW.png',
				],
				[
					'flag_name'		=> 'Guyana',
					'flag_image'	=> 'GY.png',
				],
				[
					'flag_name'		=> 'Haiti',
					'flag_image'	=> 'HT.png',
				],
				[
					'flag_name'		=> 'Honduras',
					'flag_image'	=> 'HN.png',
				],
				[
					'flag_name'		=> 'Hong Kong',
					'flag_image'	=> 'HK.png',
				],
				[
					'flag_name'		=> 'Hungary',
					'flag_image'	=> 'HU.png',
				],
				[
					'flag_name'		=> 'Iceland',
					'flag_image'	=> 'IS.png',
				],
				[
					'flag_name'		=> 'India',
					'flag_image'	=> 'IN.png',
				],
				[
					'flag_name'		=> 'Indonesia',
					'flag_image'	=> 'ID.png',
				],
				[
					'flag_name'		=> 'Iran',
					'flag_image'	=> 'IR.png',
				],
				[
					'flag_name'		=> 'Iraq',
					'flag_image'	=> 'IQ.png',
				],
				[
					'flag_name'		=> 'Ireland',
					'flag_image'	=> 'IE.png',
				],
				[
					'flag_name'		=> 'Isle of Man',
					'flag_image'	=> 'IM.png',
				],
				[
					'flag_name'		=> 'Israel',
					'flag_image'	=> 'IL.png',
				],
				[
					'flag_name'		=> 'Italy',
					'flag_image'	=> 'IT.png',
				],
				[
					'flag_name'		=> 'Jamaica',
					'flag_image'	=> 'JM.png',
				],
				[
					'flag_name'		=> 'Japan',
					'flag_image'	=> 'JP.png',
				],
				[
					'flag_name'		=> 'Jordan',
					'flag_image'	=> 'JO.png',
				],
				[
					'flag_name'		=> 'Kazakhstan',
					'flag_image'	=> 'KZ.png',
				],
				[
					'flag_name'		=> 'Kenya',
					'flag_image'	=> 'KE.png',
				],
				[
					'flag_name'		=> 'Kiribati',
					'flag_image'	=> 'KI.png',
				],
				[
					'flag_name'		=> 'Korea North',
					'flag_image'	=> 'NK.png',
				],
				[
					'flag_name'		=> 'Korea South',
					'flag_image'	=> 'KS.png',
				],
				[
					'flag_name'		=> 'Kuwait',
					'flag_image'	=> 'KW.png',
				],
				[
					'flag_name'		=> 'Kyrgyzstan',
					'flag_image'	=> 'KG.png',
				],
				[
					'flag_name'		=> 'Laos',
					'flag_image'	=> 'LA.png',
				],
				[
					'flag_name'		=> 'Latvia',
					'flag_image'	=> 'LV.png',
				],
				[
					'flag_name'		=> 'Lebanon',
					'flag_image'	=> 'LB.png',
				],
				[
					'flag_name'		=> 'Lesotho',
					'flag_image'	=> 'LS.png',
				],
				[
					'flag_name'		=> 'Liberia',
					'flag_image'	=> 'LR.png',
				],
				[
					'flag_name'		=> 'Libya',
					'flag_image'	=> 'LY.png',
				],
				[
					'flag_name'		=> 'Liechtenstein',
					'flag_image'	=> 'LI.png',
				],
				[
					'flag_name'		=> 'Lithuania',
					'flag_image'	=> 'LT.png',
				],
				[
					'flag_name'		=> 'Luxembourg',
					'flag_image'	=> 'LU.png',
				],
				[
					'flag_name'		=> 'Macau',
					'flag_image'	=> 'MO.png',
				],
				[
					'flag_name'		=> 'Macedonia',
					'flag_image'	=> 'MK.png',
				],
				[
					'flag_name'		=> 'Madagascar',
					'flag_image'	=> 'MG.png',
				],
				[
					'flag_name'		=> 'Malawi',
					'flag_image'	=> 'MW.png',
				],
				[
					'flag_name'		=> 'Malaysia',
					'flag_image'	=> 'MY.png',
				],
				[
					'flag_name'		=> 'Maldives',
					'flag_image'	=> 'MV.png',
				],
				[
					'flag_name'		=> 'Mali',
					'flag_image'	=> 'ML.png',
				],
				[
					'flag_name'		=> 'Malta',
					'flag_image'	=> 'MT.png',
				],
				[
					'flag_name'		=> 'Marshall Islands',
					'flag_image'	=> 'MH.png',
				],
				[
					'flag_name'		=> 'Mauritania',
					'flag_image'	=> 'MR.png',
				],
				[
					'flag_name'		=> 'Mauritius',
					'flag_image'	=> 'MU.png',
				],
				[
					'flag_name'		=> 'Mexico',
					'flag_image'	=> 'MX.png',
				],
				[
					'flag_name'		=> 'Micronesia',
					'flag_image'	=> 'FM.png',
				],
				[
					'flag_name'		=> 'Moldova',
					'flag_image'	=> 'MD.png',
				],
				[
					'flag_name'		=> 'Monaco',
					'flag_image'	=> 'MC.png',
				],
				[
					'flag_name'		=> 'Mongolia',
					'flag_image'	=> 'MN.png',
				],
				[
					'flag_name'		=> 'Montserrat',
					'flag_image'	=> 'MS.png',
				],
				[
					'flag_name'		=> 'Morocco',
					'flag_image'	=> 'MA.png',
				],
				[
					'flag_name'		=> 'Mozambique',
					'flag_image'	=> 'MZ.png',
				],
				[
					'flag_name'		=> 'Myanmar',
					'flag_image'	=> 'MM.png',
				],
				[
					'flag_name'		=> 'Nambia',
					'flag_image'	=> 'NA.png',
				],
				[
					'flag_name'		=> 'Nauru',
					'flag_image'	=> 'NR.png',
				],
				[
					'flag_name'		=> 'Nepal',
					'flag_image'	=> 'NP.png',
				],
				[
					'flag_name'		=> 'Netherland Antilles',
					'flag_image'	=> 'AN.png',
				],
				[
					'flag_name'		=> 'Netherlands',
					'flag_image'	=> 'NL.png',
				],
				[
					'flag_name'		=> 'New Zealand',
					'flag_image'	=> 'NZ.png',
				],
				[
					'flag_name'		=> 'Nicaragua',
					'flag_image'	=> 'NI.png',
				],
				[
					'flag_name'		=> 'Niger',
					'flag_image'	=> 'NE.png',
				],
				[
					'flag_name'		=> 'Nigeria',
					'flag_image'	=> 'NG.png',
				],
				[
					'flag_name'		=> 'Norfolk Island',
					'flag_image'	=> 'NF.png',
				],
				[
					'flag_name'		=> 'Norway',
					'flag_image'	=> 'NO.png',
				],
				[
					'flag_name'		=> 'Oman',
					'flag_image'	=> 'OM.png',
				],
				[
					'flag_name'		=> 'Pakistan',
					'flag_image'	=> 'PK.png',
				],
				[
					'flag_name'		=> 'Palau Island',
					'flag_image'	=> 'PW.png',
				],
				[
					'flag_name'		=> 'Palestine',
					'flag_image'	=> 'PS.png',
				],
				[
					'flag_name'		=> 'Panama',
					'flag_image'	=> 'PA.png',
				],
				[
					'flag_name'		=> 'Papua New Guinea',
					'flag_image'	=> 'PG.png',
				],
				[
					'flag_name'		=> 'Paraguay',
					'flag_image'	=> 'PY.png',
				],
				[
					'flag_name'		=> 'Peru',
					'flag_image'	=> 'PE.png',
				],
				[
					'flag_name'		=> 'Philippines',
					'flag_image'	=> 'PH.png',
				],
				[
					'flag_name'		=> 'Pitcairn Island',
					'flag_image'	=> 'PN.png',
				],
				[
					'flag_name'		=> 'Poland',
					'flag_image'	=> 'PL.png',
				],
				[
					'flag_name'		=> 'Portugal',
					'flag_image'	=> 'PT.png',
				],
				[
					'flag_name'		=> 'Puerto Rico',
					'flag_image'	=> 'PR.png',
				],
				[
					'flag_name'		=> 'Qatar',
					'flag_image'	=> 'QA.png',
				],
				[
					'flag_name'		=> 'Romania',
					'flag_image'	=> 'RO.png',
				],
				[
					'flag_name'		=> 'Russia',
					'flag_image'	=> 'RU.png',
				],
				[
					'flag_name'		=> 'Rwanda',
					'flag_image'	=> 'RW.png',
				],
				[
					'flag_name'		=> 'Samoa',
					'flag_image'	=> 'WS.png',
				],
				[
					'flag_name'		=> 'San Marino',
					'flag_image'	=> 'SM.png',
				],
				[
					'flag_name'		=> 'Sao Tome &amp; Principe',
					'flag_image'	=> 'ST.png',
				],
				[
					'flag_name'		=> 'Saudi Arabia',
					'flag_image'	=> 'SA.png',
				],
				[
					'flag_name'		=> 'Senegal',
					'flag_image'	=> 'SN.png',
				],
				[
					'flag_name'		=> 'Seychelles',
					'flag_image'	=> 'SC.png',
				],
				[
					'flag_name'		=> 'Sierra Leone',
					'flag_image'	=> 'SL.png',
				],
				[
					'flag_name'		=> 'Singapore',
					'flag_image'	=> 'SG.png',
				],
				[
					'flag_name'		=> 'Slovakia',
					'flag_image'	=> 'SK.png',
				],
				[
					'flag_name'		=> 'Slovenia',
					'flag_image'	=> 'SI.png',
				],
				[
					'flag_name'		=> 'Solomon Islands',
					'flag_image'	=> 'SB.png',
				],
				[
					'flag_name'		=> 'Somalia',
					'flag_image'	=> 'SO.png',
				],
				[
					'flag_name'		=> 'South Africa',
					'flag_image'	=> 'ZA.png',
				],
				[
					'flag_name'		=> 'Spain',
					'flag_image'	=> 'ES.png',
				],
				[
					'flag_name'		=> 'Sri Lanka',
					'flag_image'	=> 'LK.png',
				],
				[
					'flag_name'		=> 'St Helena',
					'flag_image'	=> 'SH.png',
				],
				[
					'flag_name'		=> 'St Kitts-Nevis',
					'flag_image'	=> 'KN.png',
				],
				[
					'flag_name'		=> 'St Lucia',
					'flag_image'	=> 'LC.png',
				],
				[
					'flag_name'		=> 'St Vincent &amp; Grenadines',
					'flag_image'	=> 'VC.png',
				],
				[
					'flag_name'		=> 'Sudan',
					'flag_image'	=> 'SD.png',
				],
				[
					'flag_name'		=> 'Suriname',
					'flag_image'	=> 'SR.png',
				],
				[
					'flag_name'		=> 'Swaziland',
					'flag_image'	=> 'SZ.png',
				],
				[
					'flag_name'		=> 'Sweden',
					'flag_image'	=> 'SE.png',
				],
					[
					'flag_name'		=> 'Switzerland',
					'flag_image'	=> 'CH.png',
				],
				[
					'flag_name'		=> 'Syria',
					'flag_image'	=> 'SY.png',
				],
				[
					'flag_name'		=> 'Taiwan',
					'flag_image'	=> 'TW.png',
				],
				[
					'flag_name'		=> 'Tajikistan',
					'flag_image'	=> 'TJ.png',
				],
				[
					'flag_name'		=> 'Tanzania',
					'flag_image'	=> 'TZ.png',
				],
				[
					'flag_name'		=> 'Thailand',
					'flag_image'	=> 'TH.png',
				],
				[
					'flag_name'		=> 'Togo',
					'flag_image'	=> 'TG.png',
				],
				[
					'flag_name'		=> 'Tonga',
					'flag_image'	=> 'TO.png',
				],
				[
					'flag_name'		=> 'Trinidad &amp; Tobago',
					'flag_image'	=> 'TT.png',
				],
				[
					'flag_name'		=> 'Tunisia',
					'flag_image'	=> 'TN.png',
				],
				[
					'flag_name'		=> 'Turkey',
					'flag_image'	=> 'TR.png',
				],
				[
					'flag_name'		=> 'Turkmenistan',
					'flag_image'	=> 'TM.png',
				],
				[
					'flag_name'		=> 'Turks &amp; Caicos Is',
					'flag_image'	=> 'TC.png',
				],
				[
					'flag_name'		=> 'Tuvalu',
					'flag_image'	=> 'TV.png',
				],
				[
					'flag_name'		=> 'Uganda',
					'flag_image'	=> 'UG.png',
				],
				[
					'flag_name'		=> 'Ukraine',
					'flag_image'	=> 'UA.png',
				],
				[
					'flag_name'		=> 'United Arab Emirates',
					'flag_image'	=> 'AE.png',
				],
				[
					'flag_name'		=> 'United States of America',
					'flag_image'	=> 'US.png',
				],
				[
					'flag_name'		=> 'Uruguay',
					'flag_image'	=> 'UY.png',
				],
				[
					'flag_name'		=> 'Uzbekistan',
					'flag_image'	=> 'UZ.png',
				],
				[
					'flag_name'		=> 'Vanuatu',
					'flag_image'	=> 'VU.png',
				],
				[
					'flag_name'		=> 'Venezuela',
					'flag_image'	=> 'VE.png',
				],
				[
					'flag_name'		=> 'Vietnam',
					'flag_image'	=> 'VN.png',
				],
				[
					'flag_name'		=> 'Virgin Islands (Brit)',
					'flag_image'	=> 'VG.png',
				],
				[
					'flag_name'		=> 'Virgin Islands (USA)',
					'flag_image'	=> 'VI.png',
				],
				[
					'flag_name'		=> 'Wales',
					'flag_image'	=> 'WLS.png',
				],
				[
					'flag_name'		=> 'Western Sahara',
					'flag_image'	=> 'EH.png',
				],
				[
					'flag_name'		=> 'Yemen',
					'flag_image'	=> 'YE.png',
				],
				[
					'flag_name'		=> 'Zambia',
					'flag_image'	=> 'ZM.png',
				],
				[
					'flag_name'		=> 'Zimbabwe',
					'flag_image'	=> 'ZW.png',
				],
			];
			$this->db->sql_multi_insert($this->table_prefix . 'flags', $sql_ary);
		}
	}
}
