<?php
/**
*
* National Flags extension for the phpBB Forum Software package.
*
* @copyright (c) 2015 Rich McGirr (RMcGirr83)
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace rmcgirr83\nationalflags\acp;

class nationalflags_module
{
	public	$u_action;

	function main($id, $mode)
	{
		global $phpbb_container, $language, $request, $template;

		$language->add_lang(['nationalflags_acp', 'common'], 'rmcgirr83/nationalflags');
		$language->add_lang('posting');

		// Get an instance of the admin controller
		$admin_controller = $phpbb_container->get('rmcgirr83.nationalflags.admin.controller');

		// Requests
		$action = $request->variable('action', '');
		$flag_id = $request->variable('flag_id', 0);
		if ($request->is_set_post('add'))
		{
			$action = 'add';
		}
		// Make the $u_action url available in the admin controller
		$admin_controller->set_page_url($this->u_action);

		$template->assign_vars([
			'L_BUY_ME_A_BEER_EXPLAIN'	=> $language->lang('BUY ME A BEER_EXPLAIN', '<a href="https://paypal.me/RMcGirr83" target="_blank" rel=”noreferrer noopener”>', '</a>')
		]);
		// Load the "settings" or "manage" module modes
		switch ($mode)
		{
			case 'config':
				// Load a template from adm/style for our ACP page
				$this->tpl_name = 'nationalflags_settings';

				// Set the page title for our ACP page
				$this->page_title = $language->lang('ACP_FLAG_SETTINGS');

				// Load the display options handle in the admin controller
				$admin_controller->display_options();
			break;

			case 'manage':
				// Load a template from adm/style for our ACP page
				$this->tpl_name = 'nationalflags_manage';

				// Set the page title for our ACP page
				$this->page_title = $language->lang('ACP_FLAGS');

				// Perform any actions submitted by the user
				switch ($action)
				{
					case 'add':
						// Set the page title for our ACP page
						$this->page_title = $language->lang('FLAG_ADD');

						// Load the add flag handle in the admin controller
						$admin_controller->add_flag();

						// Return to stop execution of this script
						return;
					break;

					case 'edit':
						// Set the page title for our ACP page
						$this->page_title = $language->lang('FLAG_EDIT');

						// Load the edit flag handle in the admin controller
						$admin_controller->edit_flag($flag_id);

						// Return to stop execution of this script
						return;
					break;

					case 'delete':
						// Delete a flag
						$admin_controller->delete_flag($flag_id);
					break;

					default:
						$admin_controller->display_flags();
					break;
				}
			break;
		}
	}
}
