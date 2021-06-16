<?php
/**
 *
 * Power energy. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2021, dmzx, https://www.dmzx-web.net
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace dmzx\powerenergy;

use phpbb\extension\base;

class ext extends base
{
	public function is_enableable()
	{
		// Set globals for use in the language file
		global $ver_error, $smartreadout_error;

		$ext_manager = $this->container->get('ext.manager');

		// Requires phpBB 3.2.0 or newer.
		$ver 		= phpbb_version_compare(PHPBB_VERSION, '3.2.0', '>=');

		// Display a custom warning message if this requirement fails.
		$ver_error 	= ($ver) ? false : true;

		if ($ver_error)
		{
			$this->container->get('user')->add_lang_ext('dmzx/powerenergy', 'ext_enable_error');

			return false;
		}

		if (!$ext_manager->is_enabled('dmzx/smartreadout'))
		{
			$smartreadout 	= $ext_manager->is_enabled('dmzx/smartreadout');

			// Display a custom warning message if this requirement fails.
			$smartreadout_error	= ($smartreadout) ? false : true;

			$this->container->get('user')->add_lang_ext('dmzx/powerenergy', 'ext_enable_error');

			return false;
		}

		return true;
	}
}
