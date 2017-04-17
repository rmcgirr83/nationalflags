<?php

/**
*
*
* @package - National Flags language
* @copyright (c) 2015 RMcGirr83
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
* Translated By : Bassel Taha Alhitary - www.alhitary.net
*/

if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = array();
}

// DEVELOPERS PLEASE NOTE
//
// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
//
// Placeholders can now contain order information, e.g. instead of
// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
// translators to re-order the output of data while ensuring it remains correct
//
// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
// equally where a string contains only two placeholders which are used to wrap text
// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
// Some characters you may want to copy&paste:
// ’ » “ ” …

$lang = array_merge($lang, array(
	'FLAGS'				=> array(
		1 => '1 علم',
		2 => '%s أعلام',
	),
	'USER_FLAG'			=> 'علم',
	'NATIONAL_FLAGS'	=> 'أعلام',
	'FLAG_EXPLAIN'		=> 'حدد علم بلادك',
	'USER_NEEDS_FLAG'	=> 'نرجوا أخذ دقيقة من وقتك و %sزيارة ملفك الشخصي%s لتحديد علم بلادك.',
	'FLAGS_VIEWONLINE'	=> 'يُشاهد الأعلام',
	'FLAG_USERS'		=>  array(
		1 => '1 عضو',
		2 => '%s أعضاء',
	),
	'MUST_CHOOSE_FLAG'	=> 'يجب عليك تحديد علم بلادك.',
	'NO_SUCH_FLAG'		=> 'الرجاء تحديد علم بلادك.',
	'NO_USER_HAS_FLAG'	=> 'لا يوجد أعضاء لديه هذا العلم',
	'FLAG_NOT_EXIST'	=> 'العلم غير موجود',
));
