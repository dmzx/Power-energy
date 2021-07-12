<?php
/**
 *
 * Power energy. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2021, dmzx, https://www.dmzx-web.net
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace dmzx\powerenergy\migrations;

class powerenergy_v101 extends \phpbb\db\migration\migration
{
	public static function depends_on()
	{
		return [
			'\dmzx\powerenergy\migrations\install_powerenergy'
		];
	}

	public function update_data()
	{
		return [
			// Update config
			['config.update', ['dmzx_powerenergy_version', '1.0.1']],
		];
	}
}
