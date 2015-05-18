<?php

/**
*
*
* @package - National Flags language
* @copyright (c) 2015 RMcGirr83
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
	'FLAG'				=> '%s flagga',
	'FLAGS'				=> '%s flaggor',
	'USER_FLAG'			=> 'Flagga',
	'NATIONAL_FLAGS'	=> 'Flaggor',
	'FLAG_EXPLAIN'		=> 'Välj din flagga',
	'USER_NEEDS_FLAG'	=> '%sGå till din profil%s och välj en flagga.',
	'FLAGS_VIEWONLINE'	=> 'Tittar på flaggor',
	'FLAG_USER'			=> '%s användare',
	'FLAG_USERS'		=> '%s användare',
	'MUST_CHOOSE_FLAG'	=> 'Du måste välja en flagga.',
	'NO_SUCH_FLAG'		=> 'Välj en flagga.',
	'NO_USER_HAS_FLAG'	=> 'Ingen användare har valt denna flagga',
	'FLAG_NOT_EXIST'	=> 'Flaggan existerar ej',
));