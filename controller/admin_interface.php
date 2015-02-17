<?php
/**
*
* National Flags extension for the phpBB Forum Software package.
*
* @copyright (c) 2015 Rich McGirr (RMcGirr83)
* @license GNU General Public License, version 2 (GPL-2.0)
*
*/

namespace rmcgirr83\nationalflags\controller;

/**
* Interface for our admin controller
*
* This describes all of the methods we'll use for the admin front-end of this extension
*/
interface admin_interface
{
	/**
	* Display the options a user can configure for this extension
	*
	* @return null
	* @access public
	*/
	public function display_options();

	/**
	* Display the flags
	*
	* @return null
	* @access public
	*/
	public function display_flags();

	/**
	* Add a flag
	*
	* @return null
	* @access public
	*/
	public function add_flag();

	/**
	* Edit a flag
	*
	* @param int $flag_id The flag identifier to edit
	* @return null
	* @access public
	*/
	public function edit_flag($flag_id);

	/**
	* Delete a flag
	*
	* @param int $flag_id The flag identifier to delete
	* @return null
	* @access public
	*/
	public function delete_flag($flag_id);

	/**
	* Set page url
	*
	* @param string $u_action Custom form action
	* @return null
	* @access public
	*/
	public function set_page_url($u_action);

}
