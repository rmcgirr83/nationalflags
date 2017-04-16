<?php

/**
*
*
* @package - National Flags language
* @copyright (c) RMcGirr83
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
* German translation by franki (http://dieahnen.de/ahnenforum/)
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
	'ACP_CAT_FLAGS'						=> 'National Flaggen',
	'ACP_FLAGS'							=> 'National Flaggen',
	'ACP_FLAGS_EXPLAIN'					=> 'Hier kannst Du Flaggen hinzufügen/bearbeiten und Löschen. <strong>Wenn Du ein Bilde verwenden möchtest sollten Du es nach ext/rmcgirr83/Nationalflags/Flags hochladen, bevor Du die neue Flagge hinzufügst.</strong>',
	'ACP_FLAGS_DONATE'					=> 'Denken bitte über eine <a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=S4UTZ9YNKEDDN" onclick="window.open(this.href); return false;"><strong>Spende</strong></a>nach, wenn Dir die Erweiterung gefällt',
	'ACP_FLAG_USERS'					=> 'Anzahl von Benutzern',

	//Add/Edit Flags
	'FLAG_EDIT'							=> 'Flagge bearbeiten',
	'FLAG_NAME'							=> 'Flaggen Name',
	'FLAG_NAME_EXPLAIN'					=> 'Der Name der Flagge. Der Flaggen-Titel wird hier angezeigt.',
	'FLAG_IMG'							=> 'Bild Name',
	'FLAG_IMG_EXPLAIN'					=> 'Der Name des Bildes. Beispiel: UK.gif. Neue Bilder müssen nach "ext/rmcgirr83/nationalflags/flags" hochgeladen werden<br />Wenn Du ein Bild nicht verwenden willst, lasse dieses Feld leer.',
	'FLAG_IMAGE'						=> 'Flaggen-Bild',
	'FLAG_ADD'							=> 'Neue Flagge hinzufügen',

	//Settings
	'ACP_FLAG_SETTINGS'					=> 'Nationalflaggen Einstellungen',
	'YES_FLAGS'							=> 'Flaggen aktivieren',
	'YES_FLAGS_EXPLAIN'					=> 'Wählen aktivieren/deaktivieren der Flaggen',
	'FLAGS_VERSION'						=> 'Nationalflaggen Version',
	'FLAGS_REQUIRED'					=> 'Pflichtfeld',
	'FLAGS_REQUIRED_EXPLAIN'			=> 'Wähle hier "Ja" um registrierte Benutzer aufzuforden ihr Profil zu besuchen und eine Flagge auszuwählen',
	'FLAGS_DISPLAY_MSG'					=> 'Eine Nachricht anzeigen',
	'FLAGS_DISPLAY_MSG_EXPLAIN'			=> 'Die Auswahl Ja gibt eine Nachricht im Forum für einen Benutzer damit dieser ein Flag auswählt',

	//Logs, messages and errors
	'LOG_FLAGS_DELETED'					=> 'Flagge gelöscht: %1$s',
	'LOG_FLAG_EDIT'						=> 'Flagge aktuallisiert: %1$s',
	'LOG_FLAG_ADD'						=> 'Neue Flagge hinzugefügt: %1$s',
	'MSG_FLAGS_DELETED'					=> 'Flagge wurde gelöscht.',
	'MSG_CONFIRM'						=> 'Bist Du sicher, dass diese Flag gelöscht werden soll?',
	'MSG_FLAG_CONFIRM_DELETE'			=> '<br /><strong>%d</strong> Benutzer hat diese Flagge und muss eine andere Flagge auswählen, wenn Du beschließt, diese zu löschen.',
	'MSG_FLAGS_CONFIRM_DELETE'			=> '<br /><strong>%d</strong> Benutzer haben diese Flagge und muss eine andere Flagge auswählen, wenn Du beschließt, diese zu löschen.',
	'MSG_FLAG_EDITED'					=> 'Flagge wurde bearbeitet.',
	'MSG_FLAG_ADDED'					=> 'Neue Flagge wurde hinzugefügt.',
	'FLAG_ERROR_NO_FLAG_NAME'			=> 'Kein Flaggenname definiert, dies ist ein Pflichtfeld.',
	'FLAG_ERROR_NO_FLAG_IMG'			=> 'Keine Flagge definiert, dies ist ein Pflichtfeld.',
	'FLAG_ERROR_NOT_EXIST'				=> 'Die ausgewählten Flagge ist nicht vorhanden.',
	'FLAG_CONFIG_SAVED'					=> 'Flaggen-Konfiguration wurde aktualisiert',
	'FLAG_NAME_EXISTS'					=> 'Eine Flagge mit diesem Namen ist bereits vorhanden',
	'FLAG_SETTINGS_CHANGED'				=> 'Nationalflaggen-Einstellungen geändert.',

));
