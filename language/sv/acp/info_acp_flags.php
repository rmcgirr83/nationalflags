<?php

/**
*
*
* @package - National Flags language
* @copyright (c) RMcGirr83
* Swedish translation by Holger (http://www.maskinisten.net)
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
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
	'ACP_CAT_FLAGS'						=> 'Flaggor',
	'ACP_FLAGS'							=> 'Flaggor',
	'ACP_FLAGS_EXPLAIN'					=> 'Här kan du hantera de olika flaggorna. <strong>Om du vill använda bilder så måste du ladda upp dem till ext/rmcgirr83/nationalflags/flags innan du lägger till en ny flagga.  Flaggans filnamn måste vara i små bokstäver, t.ex. uk.gif</strong>',
	'ACP_FLAGS_DONATE'					=> '<a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=S4UTZ9YNKEDDN" onclick="window.open(this.href); return false;"><strong>Donera gärna</strong></a> om du tycker om detta tillägg',
	'ACP_FLAG_USERS'					=> 'Antal användare',

	//Add/Edit Flags
	'FLAG_EDIT'							=> 'Redigera flagga',
	'FLAG_NAME'							=> 'Flaggans namn',
	'FLAG_NAME_EXPLAIN'					=> 'Flaggans namn. Detta namn visas som det är här.',
	'FLAG_IMG'							=> 'Filnamn',
	'FLAG_IMG_EXPLAIN'					=> 'Filens namn, t.ex. uk.gif. Nya bilder måste laddas upp till ext/rmcgirr83/nationalflags/flags.',
	'FLAG_IMAGE'						=> 'Flaggbild',
	'FLAG_ADD'							=> 'Lägg till ny flagga',

	//Settings
	'ACP_FLAG_SETTINGS'					=> 'Flaggor inställningar',
	'YES_FLAGS'							=> 'Aktivera flaggor',
	'YES_FLAGS_EXPLAIN'					=> 'Aktivera eller deaktivera flaggorna',
	'FLAGS_VERSION'						=> 'Version',
	'FLAGS_REQUIRED'					=> 'Erforderligt fält',
	'FLAGS_REQUIRED_EXPLAIN'			=> 'Väljer du Ja så måste nya medlemmar som registrerar sig och aktiva medlemmar som går till profilen välja flagga.',
	'FLAGS_DISPLAY_MSG'					=> 'Visa ett meddelande',
	'FLAGS_DISPLAY_MSG_EXPLAIN'			=> 'Väljer du Ja så visas ett meddelande i forumet som uppmanar användaren att välja en flagga.',

	//Logs, messages and errors
	'LOG_FLAGS_DELETED'					=> 'Raderad flagga: %1$s',
	'LOG_FLAG_EDIT'						=> 'Aktualiserad flagga: %1$s',
	'LOG_FLAG_ADD'						=> 'Ny flagga: %1$s',
	'MSG_FLAGS_DELETED'					=> 'Flaggan har raderats.',
	'MSG_CONFIRM'						=> 'Är du säker på att du vill radera denna flagga?',
	'MSG_FLAG_CONFIRM_DELETE'			=> '<br /><strong>%d</strong> användare har valt denna flagga och måste välja en ny om du raderar denna flagga.',
	'MSG_FLAGS_CONFIRM_DELETE'			=> '<br /><strong>%d</strong> användare har valt denna flagga och måste välja en ny om du raderar denna flagga.',
	'MSG_FLAG_EDITED'					=> 'Flaggan har redigerats.',
	'MSG_FLAG_ADDED'					=> 'Ny flagga har lagts till.',
	'FLAG_ERROR_NO_FLAG_NAME'			=> 'Inget namn på flaggan, detta fält är erforderligt.',
	'FLAG_ERROR_NO_FLAG_IMG'			=> 'Ingen flaggbild har valts, detta fält är erforderligt.',
	'FLAG_ERROR_NOT_EXIST'				=> 'Den valda flaggan existerar ej.',
	'FLAG_CONFIG_SAVED'					=> '<strong>Inställningarna har sparats</strong>',
	'FLAG_NAME_EXISTS'					=> 'Det existerar redan en flagga med detta namn',
	'FLAG_SETTINGS_CHANGED'				=> 'Inställningarna har sparats.',
));
