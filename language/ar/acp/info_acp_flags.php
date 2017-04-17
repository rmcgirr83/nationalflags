<?php

/**
*
*
* @package - National Flags language
* @copyright (c) RMcGirr83
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
	//Module and page titles
	'ACP_CAT_FLAGS'						=> 'أعلام الدول',
	'ACP_FLAGS'							=> 'أعلام الدول',
	'ACP_FLAGS_EXPLAIN'					=> 'من هنا تستطيع إضافة / تعديل / حذف الأعلام التي تريدها. <strong>يجب عليك رفع صور الأعلام التي تريدها إلى المسار ext/rmcgirr83/nationalflags/flags قبل إضافة العلم الجديد. إسم صورة العلم يجب أن تكون بحروف مُختصرة , مثال : ye.gif</strong>',
	'ACP_FLAGS_DONATE'					=> 'نرجوا <a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=S4UTZ9YNKEDDN" onclick="window.open(this.href); return false;"><strong>التبرع</strong></a> لو أعجبتك هذه الإضافة',
	'ACP_FLAG_USERS'					=> 'عدد الأعضاء',

	//Add/Edit Flags
	'FLAG_EDIT'							=> 'تعديل الصورة',
	'FLAG_NAME'							=> 'إسم العلم ',
	'FLAG_NAME_EXPLAIN'					=> 'اكتب عنوان العلم في هذا الحقل.',
	'FLAG_IMG'							=> 'إسم الصورة ',
	'FLAG_IMG_EXPLAIN'					=> 'مثال : ye.gif. يجب رفع الصور الجديدة إلى المسار ext/rmcgirr83/nationalflags/flags.',
	'FLAG_IMAGE'						=> 'صورة العلم',
	'FLAG_ADD'							=> 'إضافة علم جديد',

	//Settings
	'ACP_FLAG_SETTINGS'					=> 'الإعدادات',
	'YES_FLAGS'							=> 'تفعيل ',
	'YES_FLAGS_EXPLAIN'					=> 'حدد تفعيل أو تعطيل أعلام الدول',
	'FLAGS_VERSION'						=> 'النسخة :',
	'FLAGS_REQUIRED'					=> 'حقل مطلوب ',
	'FLAGS_REQUIRED_EXPLAIN'			=> 'اختيارك "نعم" سوف يجعل تحديد "أعلام الدول" إجباري للأعضاء المُسجلين الجُدد و الأعضاء الذين يدخلون ملفهم الشخصي',
	'FLAGS_DISPLAY_MSG'					=> 'إظهار رسالة ',
	'FLAGS_DISPLAY_MSG_EXPLAIN'			=> 'اختيارك "نعم" يعني إظهار رسالة في المنتدى تطلب من العضو تحديد علم بلاده',
	'FLAGS_NUM_DISPLAY'					=> 'عدد الأعلام ',
	'FLAGS_NUM_DISPLAY_EXPLAIN'			=> 'عدد الأعلام التي سيتم عرضها في الصفحة الرئيسية للمنتدي',
	'FLAGS_ON_INDEX'					=> 'الصفحة الرئيسية ',
	'FLAGS_ON_INDEX_EXPLAIN'			=> 'عرض ملخص عن أعلام الأعضاء في الصفحة الرئيسية',

	//Logs, messages and errors
	'LOG_FLAGS_DELETED'					=> '<strong>حذف العلم</strong><br />» %1$s',
	'LOG_FLAG_EDIT'						=> '<strong>تحديث العلم</strong><br />» %1$s',
	'LOG_FLAG_ADD'						=> '<strong>إضافة علم جديد</strong><br />» %1$s',
	'MSG_FLAGS_DELETED'					=> 'تم حذف العلم.',
	'MSG_CONFIRM'						=> 'هل أنت متأكد من حذف هذا العلم ?',
	'MSG_FLAG_CONFIRM_DELETE'			=> '<br /><strong>%d</strong> عضو لديه هذا العلم و سيكون عليه تحديد علم آخر إذا حذفت هذا العلم.',
	'MSG_FLAGS_CONFIRM_DELETE'			=> '<br /><strong>%d</strong> أعضاء لديهم هذا العلم و سيكون عليهم تحديد علم آخر إذا حذفت هذا العلم.',
	'MSG_FLAG_EDITED'					=> 'تم تعديل العلم.',
	'MSG_FLAG_ADDED'					=> 'تم إضافة علم جديد.',
	'FLAG_ERROR_NO_FLAG_NAME'			=> 'لم يتم إضافة إسم العلم , هذا الحقل مطلوب.',
	'FLAG_ERROR_NO_FLAG_IMG'			=> 'لم يتم إضافة صورة العلم , هذا الحقل مطلوب.',
	'FLAG_ERROR_NOT_EXIST'				=> 'العلم الذي حددته غير موجود.',
	'FLAG_CONFIG_SAVED'					=> '<strong>تم تغيير إعدادات أعلام الدول</strong>',
	'FLAG_NAME_EXISTS'					=> 'إسم العلم الذي أضفته موجود مُسبقاً',
	'FLAG_SETTINGS_CHANGED'				=> 'تم تغيير إعدادات أعلام الدول.',
));
