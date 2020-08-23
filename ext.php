<?php
/**
*
* @package National Flags
* @copyright (c) 2015 Rich McGirr(RMcGirr83)
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

namespace rmcgirr83\nationalflags;

/**
* Extension class for custom enable/disable/purge actions
*/
class ext extends \phpbb\extension\base
{
	/**
	 * Enable extension if phpBB version requirement is met
	 *
	 * @return bool
	 * @access public
	 */
	public function is_enableable()
	{
		$enableable = (phpbb_version_compare(PHPBB_VERSION, '3.2.6', '>=') && version_compare(PHP_VERSION, '7.1.*', '>'));
		if (!$enableable)
		{
			$user = $this->container->get('user');
			$user->add_lang_ext('rmcgirr83/nationalflags', 'nationalflags_acp');
			trigger_error($user->lang('FLAGS_REQUIRE_540'), E_USER_WARNING);
		}

		return $enableable;
	}
}
