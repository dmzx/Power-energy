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

class install_powerenergy extends \phpbb\db\migration\migration
{
	public static function depends_on()
	{
		return [
			'\phpbb\db\migration\data\v320\v320'
		];
	}

	public function update_data()
	{
		return [
			// Add config
			['config.add', ['dmzx_powerenergy_version', '1.0.0']],
			// Add user permission
			['permission.add', ['u_dmzx_powerenergy', true]],
			// Set permission
			['permission.permission_set', ['ADMINISTRATORS', 'u_dmzx_powerenergy', 'group']],
		];
	}
}
