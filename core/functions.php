<?php
/**
 *
 * Power energy. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2021, dmzx, https://www.dmzx-web.net
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace dmzx\powerenergy\core;

use phpbb\template\template;
use phpbb\extension\manager;
use phpbb\config\config;

class functions
{
	/** @var template */
	protected $template;

	/** @var manager */
	protected $extension_manager;

	/** @var config */
	protected $config;

	/**
	* Constructor
	*
	* @param template			$template
	* @param manager 			$extension_manager
	* @param config				$config
	*/
	function __construct(
		template $template,
		manager $extension_manager,
		config $config
	)
	{
		$this->template				= $template;
		$this->extension_manager	= $extension_manager;
		$this->config				= $config;
	}

	// Get curl
	public function get_ip_array($get_data)
	{
		$ip_adres = $this->config['smartreadout_ip_adress'];
		$ip_port = $this->config['smartreadout_ip_port'];

		if ($ip_port ==	'')
		{
			$url_to_api = 'http://' . $ip_adres . '/api/v1/hist/' . $get_data;
		}
		else
		{
			$url_to_api = 'http://' . $ip_adres . ':' . $ip_port . '/api/v1/hist/' . $get_data;
		}

		$curl_handle = curl_init();
		curl_setopt($curl_handle, CURLOPT_URL, $url_to_api);
		curl_setopt($curl_handle, CURLOPT_HTTPHEADER,['Content-Type: application/json']);
		curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
		$ip_query = curl_exec($curl_handle);
		curl_close($curl_handle);

		$ip_array = json_decode($ip_query);

		return $ip_array;
	}

	// Assign author
	public function assign_authors()
	{
		$md_manager = $this->extension_manager->create_extension_metadata_manager('dmzx/powerenergy', $this->template);
		$meta = $md_manager->get_metadata();
		$author_names = [];
		$author_homepages = [];

		foreach ($meta['authors'] as $author)
		{
			$author_names[] = $author['name'];
			$author_homepages[] = sprintf('<a href="%1$s" title="%2$s">%2$s</a>', $author['homepage'], $author['name']);
		}

		$this->template->assign_vars([
			'POWERENERGY_DISPLAY_NAME'		=> $meta['extra']['display-name'],
			'POWERENERGY_AUTHOR_NAMES'		=> implode(' &amp; ', $author_names),
			'POWERENERGY_AUTHOR_HOMEPAGES'	=> implode(' &amp; ', $author_homepages),
		]);

		return;
	}
}
