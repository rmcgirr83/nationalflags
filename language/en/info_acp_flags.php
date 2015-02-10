<?php

/**
*
*
* @package - National Flags language
* @version $Id: info_acp_flags.php
* @copyright (c) RMcGirr83
* @copyright (c) Anybloodyid
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
	'ACP_FLAGS_EXPLAIN'					=> 'Here you can add/edit and delete the different Flags. <strong>If you want to use images you should upload them to images/flags/ before you add the new Flag.</strong>',

	//Add/Edit Flags
	'FLAG_EDIT'							=> 'Edit Flag',
	'FLAG_ADD'							=> 'Add new Flag',
	'FLAG_NAME'							=> 'Flag Name',
	'FLAG_NAME_EXPLAIN'					=> 'The name of the Flag. If you choose to display as text or both the flag will displayed as it is here.',
	'FLAG_IMG'							=> 'Image Name',
	'FLAG_IMG_EXPLAIN'					=> 'The name of the image. Example: UK.gif. New images should be uploaded to images/flags/<br />If you do not want to use an image just leave this blank.',
	'FLAG_IMAGE'						=> 'Flag Image',
	'FLAG_ADD'							=> 'Add new flag',

	//A couple for the ACP User Profile
	'FLAG'								=> 'Flag',
	'FLAG_EXPLAIN'						=> 'Choose your National Flag.',

	//Settings
	'ACP_FLAG_SETTINGS'					=> 'National Flag Settings',
	'YES_FLAGS'							=> 'Enable Flags',
	'YES_FLAGS_EXPLAIN'					=> 'Choose to disable or enable the Flags',
	'FLAG_TYPE'							=> 'Display behaviour',
	'FLAG_TYPE_EXPLAIN'					=> 'Choose how to display the flag.',
	'FLAG_TEXT'							=> 'Text',
	'FLAG_IMAGE'						=> 'Image',
	'FLAG_BOTH'							=> 'Both',
	'FLAGS_VERSION'						=> 'National Flags Version',

	//Logs, messages and errors
	'LOG_FLAGS_DELETED'					=> 'Deleted Flag: %1$s',
	'LOG_FLAG_EDIT'						=> 'Updated Flag: %1$s',
	'LOG_FLAG_ADD'						=> 'Added new Flag: %1$s',
	'MSG_FLAGS_DELETED'					=> 'Flag has been deleted.',
	'MSG_FLAG_CONFIRM_DELETE'			=> 'Are you sure you want to delete this Flag?<br /><strong>%d</strong> user has this flag and will have to select a different flag if you choose to delete this one.',
	'MSG_FLAGS_CONFIRM_DELETE'			=> 'Are you sure you want to delete this Flag?<br /><strong>%d</strong> users have this flag and will have to select a different flag if you choose to delete this one.',
	'MSG_FLAG_EDITED'					=> 'Flag has been edited.',
	'MSG_FLAG_ADDED'					=> 'New Flag has been added.',
	'FLAG_ERROR_NO_FLAG_NAME'			=> 'No Flag name defined, this is a required field.',
	'FLAG_ERROR_NOT_EXIST'				=> 'The selected Flag does not exist.',
	'FLAG_CONFIG_SAVED'					=> 'Flag configuration has been updated',
	'FLAG_NAME_EXISTS'					=> 'A flag with that name already exists',

	//Install file entries
	'INSTALL_FLAG'						=> 'National Flags',
	'INSTALL_FLAG_EXPLAIN'				=> 'Here you can install, update or uninstall National Flags.',
	'INSTALL_FLAG_CONFIRM'				=> 'Are you sure you want to install National Flags?',
	'UPDATE_INSTALL_FLAG'				=> 'Update National Flags',
	'UPDATE_INSTALL_FLAG_CONFIRM'		=> 'Are you sure you want to update National Flags?',
	'UNINSTALL_INSTALL_FLAG'			=> 'Uninstall National Flags',
	'UNINSTALL_INSTALL_FLAG_CONFIRM'	=> 'Are you sure you want to uninstall National Flags?',
	'INSERT_IMAGES'						=> 'Images inserted.',
));

?>