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
		$enableable = (phpbb_version_compare(PHPBB_VERSION, '3.3', '>=') && version_compare(PHP_VERSION, '7.4.*', '>'));
		if (!$enableable)
		{
			$language = $this->container->get('language');
			$language->add_lang('nationalflags_acp', 'rmcgirr83/nationalflags');
			trigger_error($language->lang(('FLAGS_REQUIRE_540'), E_USER_WARNING));
		}

		return $enableable;
	}
}
