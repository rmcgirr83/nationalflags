<?php
/**
*
*
* @package - National Flags language
* @copyright (c) RMcGirr83
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
	'ACP_CAT_FLAGS'						=> 'Nationale Vlaggen',
	'ACP_FLAGS'							=> 'Nationale Vlaggen',
	'ACP_FLAGS_EXPLAIN'					=> 'Hier kun je vlaggen toevoegen/wijzigen en verwijderen. <strong>Als je afbeeldingen wilt gebruiken moet je ze uploaden naar ext/rmcgirr83/nationalflags/flags voordat je de nieuwe vlag kunt gebruiken.</strong>',
	'ACP_FLAGS_DONATE'					=> 'Overweeg een <a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=S4UTZ9YNKEDDN" onclick="window.open(this.href); return false;"><strong>Donatie</strong></a> als je deze Extensie bevalt.',
	'ACP_FLAG_USERS'					=> 'Aantal Gebruikers',
	//Add/Edit Flags
	'FLAG_EDIT'							=> 'Wijzig Vlag',
	'FLAG_NAME'							=> 'Naam Vlag',
	'FLAG_NAME_EXPLAIN'					=> 'De naam van de vlag. Deze naam is de omschrijving zoals die zichtbaar is voor de gebruiker.',
	'FLAG_IMG'							=> 'Naam afbeelding',
	'FLAG_IMG_EXPLAIN'					=> 'De naam van de afbeelding. Bijvoorbeeld: nl.gif. Nieuwe afbeeldingen dienen geupload te worden naar ext/rmcgirr83/nationalflags/flags.',
	'FLAG_IMAGE'						=> 'Afbeelding Vlag',
	'FLAG_ADD'							=> 'Voeg nieuwe vlag toe',
	//Settings
	'ACP_FLAG_SETTINGS'					=> 'Nationale Vlag Instellingen',
	'YES_FLAGS'							=> 'Activeer Vlaggen',
	'YES_FLAGS_EXPLAIN'					=> 'Kies voor activeren/de-activeren van de vkaggen',
	'FLAGS_VERSION'						=> 'Nationale Vlaggen Versie',
	'FLAGS_REQUIRED'					=> 'Verplicht veld',
	'FLAGS_REQUIRED_EXPLAIN'			=> 'Als je hier Ja kiest dan zijn nieuwe registranten en een ieder die naar hun eigen profiel pagina gaan gedwongen een vlag te kiezen',
	'FLAGS_DISPLAY_MSG'					=> 'Bericht Weergeven',
	'FLAGS_DISPLAY_MSG_EXPLAIN'			=> 'Indien Ja dan verschijnt er een bericht op het forum om een vlag te kiezen.',
	//Logs, messages and errors
	'LOG_FLAGS_DELETED'					=> 'Verwijder Vlag: %1$s',
	'LOG_FLAG_EDIT'						=> 'Wijzig Vlag: %1$s',
	'LOG_FLAG_ADD'						=> 'Nieuwe Vlag toegevoegd: %1$s',
	'MSG_FLAGS_DELETED'					=> 'Vlag is verwijderd.',
	'MSG_CONFIRM'						=> 'Ben je zeker dat je deze flag wilt verwijderen?',
	'MSG_FLAG_CONFIRM_DELETE'			=> '<br /><strong>%d</strong> gebuiker heeft deze vlag en je moet een andere vlag kiezen als de deze wilt verwijderen.',
	'MSG_FLAGS_CONFIRM_DELETE'			=> '<br /><strong>%d</strong> gebruikes hebben deze vlag ena je moet een andere vlag kiezen als je deze wilt verwijderen.',
	'MSG_FLAG_EDITED'					=> 'Vlag is gewijzigd.',
	'MSG_FLAG_ADDED'					=> 'Nieuwe Vlag is toegevoegd.',
	'FLAG_ERROR_NO_FLAG_NAME'			=> 'Naam van de vlag bestaat niet, dit is een verplicht veld.',
	'FLAG_ERROR_NO_FLAG_IMG'			=> 'Afbeelding van de vlag bestaat niet, dit is een verplicht veld.',
	'FLAG_ERROR_NOT_EXIST'				=> 'De gekozen vlag bestaat niet.',
	'FLAG_CONFIG_SAVED'					=> '<strong>Nationale Vlaggen instellingen zijn gewijzigd</strong>',
	'FLAG_NAME_EXISTS'					=> 'Een vlag met die naam bestaat al',
	'FLAG_SETTINGS_CHANGED'				=> 'Nationale Vlaggen installingen gewijzigd.',
));
