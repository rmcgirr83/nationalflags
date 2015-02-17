<?php
/**
*
* @package National Flags
* @copyright (c) 2015 Rich McGirr (RMcGirr83)
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace rmcgirr83\nationalflags\acp;

class nationalflags_info
{
	function module()
	{
		return array(
			'filename'	=> '\rmcgirr83\nationalflags\acp\nationalflags_module',
			'title'	=> 'ACP_FLAGS',
			'version'	=> '1.0.0',
			'modes'	=> array(
				'config'	=> array('title' => 'ACP_FLAG_SETTINGS', 'auth' => 'ext_rmcgirr83/nationalflags && acl_a_board', 'cat' => array('ACP_CAT_FLAGS')),
				'manage'		=> array('title' => 'ACP_FLAGS', 'auth' => 'ext_rmcgirr83/nationalflags && acl_a_board', 'cat' => array('ACP_CAT_FLAGS')),
			),
		);
	}
}
