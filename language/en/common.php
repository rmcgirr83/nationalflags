<?php

/**
*
*
* @package - National Flags language
* @copyright (c) 2015 RMcGirr83
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
	'FLAGS'				=> array(
		1 => '%s flag',
		2 => '%s flags',
	),
	'USER_FLAG'			=> 'Flag',
	'USER_FLAG_EXPLAIN'	=> 'The board default flag is being displayed.',
	'NATIONAL_FLAGS'	=> 'Flags',
	'FLAG_EXPLAIN'		=> 'Choose your flag',
	'USER_NEEDS_FLAG'	=> 'Please take a moment and %svisit your profile%s to choose a flag.',
	'FLAGS_VIEWONLINE'	=> 'Viewing flags',
	'FLAG_USERS'		=>  array(
		1 => '%s User',
		2 => '%s Users',
	),
	'MUST_CHOOSE_FLAG'	=> '<span class="error">You must choose a flag.</span>',
	'NO_SUCH_FLAG'		=> 'Please choose a flag.',
	'NO_USER_HAS_FLAG'	=> 'No user has this flag',
	'FLAG_NOT_EXIST'	=> 'Flag does not exist',
));
