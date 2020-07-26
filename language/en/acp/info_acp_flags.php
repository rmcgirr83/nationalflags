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
	'ACP_CAT_FLAGS'						=> 'National Flags',
	'ACP_FLAGS'							=> 'National Flags',
	'ACP_FLAG_SETTINGS'					=> 'National Flag Settings',
	'LOG_FLAGS_DELETED'					=> '<strong>Deleted flag</strong><br>» %1$s',
	'LOG_FLAG_EDIT'						=> '<strong>Updated flag</strong><br>» %1$s',
	'LOG_FLAG_ADD'						=> '<strong>Added new flag</strong><br>» %1$s',
	//Donation
	'PAYPAL_IMAGE_URL'          => 'https://www.paypalobjects.com/webstatic/en_US/i/btn/png/silver-pill-paypal-26px.png',
	'PAYPAL_ALT'                => 'Donate using PayPal',
	'BUY_ME_A_BEER_URL'         => 'https://paypal.me/RMcGirr83',
	'BUY_ME_A_BEER'				=> 'Buy me a beer for creating this extension',
	'BUY ME A BEER_SHORT'		=> 'Make a donation for this extension',
	'BUY ME A BEER_EXPLAIN'		=> 'This extension is completely free. It is a project that I’m spending my time on for the enjoyment and use of the phpBB community. If you enjoy using this extension, or if it has benefited your forum, please consider %1$sbuying me a beer%2$s. It would be greatly appreciated. <i class="fa fa-smile-o" style="color:green;font-size: 1.5em;" aria-hidden="true"></i>',
));
