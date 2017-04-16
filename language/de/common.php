<?php

/**
*
*
* @package - National Flags language
* @copyright (c) 2015 RMcGirr83
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
	'FLAG'						=> '%s Flagge',
	'FLAGS'						=> '%s Flaggen',
	'USER_FLAG'					=> 'Flagge',
	'NATIONAL_FLAGS'			=> 'Flaggen',
	'FLAG_EXPLAIN'				=> 'Wählen Deine Nationalflagge.',
	'USER_NEEDS_FLAG'			=> 'Bitte nehme dir einen Moment Zeit und %sbesuche Dein Profil%s um eine Flagge auszuwählen.',
	'FLAGS_VIEWONLINE'			=> 'Flaggen anzeigen',
	'FLAG_USER'					=> '%s Benutzer',
	'FLAG_USERS'				=> '%s Benutzer',
	'MUST_CHOOSE_FLAG'			=> 'Du musst eine Flagge auswählen.',
	'NO_SUCH_FLAG'				=> 'Bitte wähle eine Flagge aus',
	'NO_USER_HAS_FLAG'			=> 'Kein Benutzer hat diese Flagge',
	'FLAG_NOT_EXIST'			=> 'Flagge existiert nicht',
));
