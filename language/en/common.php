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

	//A couple for the ACP User Profile
	'FLAG'				=> 'Flag',
	'FLAGS'				=> 'National Flags',
	'FLAG_EXPLAIN'		=> 'Choose your National Flag.',
	'USER_NEEDS_FLAG'	=> 'Please take a moment and %svisit your profile%s to choose a flag.',
	'NATONALFLAGS_VIEWONLINE' => 'Viewing Flags',
	'TOP_FLAG_TITLE'	=> 'Top Flags',
	'FLAG_USER'			=> '%s User',
	'FLAG_USERS'		=> '%s Users',
));
