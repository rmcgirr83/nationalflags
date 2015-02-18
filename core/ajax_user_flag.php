<?php
/**
*
* @package National Flags
* @copyright (c) 2015 Rich McGirr(RMcGirr83)
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

namespace rmcgirr83\nationalflags\core;

class ajax_nationalflags
{

	/** @var \phpbb\cache\service */
	protected $cache;

	/**
	* the path to the flags directory
	*
	*@var string
	*/
	protected $flags_path;

	/** @var string phpBB root path */
	protected $phpbb_root_path;


	public function __construct(\phpbb\cache\service $cache, $flags_path, $phpbb_root_path)
	{
		$this->cache = $cache;
		$this->flags_path = $flags_path;
		$this->root_path = $phpbb_root_path;
	}

	public function ajax_flags($flag_id)
	{

		if (empty($flag_id))
		{
			return;
		}

		$flag = $this->cache->get('_user_flags');
		$flag_img = $this->root_path . $this->flags_path. $flag[$flag_id]['flag_image'];
		$flag_name = $flag[$flag_id]['flag_name'];

		$return = '<img src="' . $flag_img . '" alt="' . $flag_name .'" title="' . $flag_name .'" style="vertical-align:middle;" />';
		echo $return;
	}
}
