<?php
/**
 *
 * Power energy. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2021, dmzx, https://www.dmzx-web.net
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace dmzx\powerenergy\controller;

use phpbb\config\config;
use phpbb\controller\helper;
use phpbb\template\template;
use phpbb\language\language;
use phpbb\auth\auth;
use phpbb\request\request_interface;
use dmzx\powerenergy\core\functions;
use phpbb\exception\http_exception;

class main_controller
{
	/** @var config */
	protected $config;

	/** @var helper */
	protected $helper;

	/** @var template */
	protected $template;

	/** @var language */
	protected $language;

	/** @var auth */
	protected $auth;

	/** @var request_interface */
	protected $request;

	/** @var functions */
	protected $functions;

	/**
	 * Constructor
	 *
	 * @param config				$config
	 * @param helper				$helper
	 * @param template				$template
	 * @param language				$language
	 * @param auth					$auth
	 * @param request_interface		$request
	 * @param functions				$functions
	 */
	public function __construct(
		config $config,
		helper $helper,
		template $template,
		language $language,
		auth $auth,
		request_interface $request,
		functions $functions
	)
	{
		$this->config		= $config;
		$this->helper		= $helper;
		$this->template		= $template;
		$this->language		= $language;
		$this->auth 		= $auth;
		$this->request 		= $request;
		$this->functions	= $functions;
	}

	public function handle()
	{
		// Check auth
		if (!$this->auth->acl_get('u_dmzx_powerenergy'))
		{
			throw new http_exception(403, 'NOT_AUTHORISED');
		}

		// Add lang file
		$this->language->add_lang('powerenergy', 'dmzx/powerenergy');

		$mode = $this->request->variable('mode', 'd');

		switch ($mode)
		{
			case 'h':

				// --------------- Start Hours ---------------------- //
				$get_hours = 'hours';
				$get_ip_array_hours = $this->functions->get_ip_array($get_hours);

				if (!empty($get_ip_array_hours))
				{
					$this->template->assign_block_vars('powerenergy_hours',[
						// Power returned in watt
						'POWERENERGY_HOUR_PWR'				=> (($get_ip_array_hours->hours[0]->ert2 * 1000) - ($get_ip_array_hours->hours[1]->ert2	* 1000) != 0) ? ($get_ip_array_hours->hours[0]->ert2	* 1000) - ($get_ip_array_hours->hours[1]->ert2	* 1000) : ($get_ip_array_hours->hours[0]->ert1 * 1000) - ($get_ip_array_hours->hours[1]->ert1 * 1000),
						'POWERENERGY_HOUR1_PWR'				=> (($get_ip_array_hours->hours[1]->ert2 * 1000) - ($get_ip_array_hours->hours[2]->ert2	* 1000) != 0) ? ($get_ip_array_hours->hours[1]->ert2	* 1000) - ($get_ip_array_hours->hours[2]->ert2	* 1000) : ($get_ip_array_hours->hours[1]->ert1 * 1000) - ($get_ip_array_hours->hours[2]->ert1 * 1000),
						'POWERENERGY_HOUR2_PWR'				=> (($get_ip_array_hours->hours[2]->ert2 * 1000) - ($get_ip_array_hours->hours[3]->ert2	* 1000) != 0) ? ($get_ip_array_hours->hours[2]->ert2	* 1000) - ($get_ip_array_hours->hours[3]->ert2	* 1000) : ($get_ip_array_hours->hours[2]->ert1 * 1000) - ($get_ip_array_hours->hours[3]->ert1 * 1000),
						'POWERENERGY_HOUR3_PWR'				=> (($get_ip_array_hours->hours[3]->ert2 * 1000) - ($get_ip_array_hours->hours[4]->ert2	* 1000) != 0) ? ($get_ip_array_hours->hours[3]->ert2	* 1000) - ($get_ip_array_hours->hours[4]->ert2	* 1000) : ($get_ip_array_hours->hours[3]->ert1 * 1000) - ($get_ip_array_hours->hours[4]->ert1 * 1000),
						'POWERENERGY_HOUR4_PWR'				=> (($get_ip_array_hours->hours[4]->ert2 * 1000) - ($get_ip_array_hours->hours[5]->ert2	* 1000) != 0) ? ($get_ip_array_hours->hours[4]->ert2	* 1000) - ($get_ip_array_hours->hours[5]->ert2	* 1000) : ($get_ip_array_hours->hours[4]->ert1 * 1000) - ($get_ip_array_hours->hours[5]->ert1 * 1000),
						'POWERENERGY_HOUR5_PWR'				=> (($get_ip_array_hours->hours[5]->ert2 * 1000) - ($get_ip_array_hours->hours[6]->ert2	* 1000) != 0) ? ($get_ip_array_hours->hours[5]->ert2	* 1000) - ($get_ip_array_hours->hours[6]->ert2	* 1000) : ($get_ip_array_hours->hours[5]->ert1 * 1000) - ($get_ip_array_hours->hours[6]->ert1 * 1000),
						'POWERENERGY_HOUR6_PWR'				=> (($get_ip_array_hours->hours[6]->ert2 * 1000) - ($get_ip_array_hours->hours[7]->ert2	* 1000) != 0) ? ($get_ip_array_hours->hours[6]->ert2	* 1000) - ($get_ip_array_hours->hours[7]->ert2	* 1000) : ($get_ip_array_hours->hours[6]->ert1 * 1000) - ($get_ip_array_hours->hours[7]->ert1 * 1000),
						'POWERENERGY_HOUR7_PWR'				=> (($get_ip_array_hours->hours[7]->ert2 * 1000) - ($get_ip_array_hours->hours[8]->ert2	* 1000) != 0) ? ($get_ip_array_hours->hours[7]->ert2	* 1000) - ($get_ip_array_hours->hours[8]->ert2	* 1000) : ($get_ip_array_hours->hours[7]->ert1 * 1000) - ($get_ip_array_hours->hours[8]->ert1 * 1000),
						'POWERENERGY_HOUR8_PWR'				=> (($get_ip_array_hours->hours[8]->ert2 * 1000) - ($get_ip_array_hours->hours[9]->ert2	* 1000) != 0) ? ($get_ip_array_hours->hours[8]->ert2	* 1000) - ($get_ip_array_hours->hours[9]->ert2	* 1000) : ($get_ip_array_hours->hours[8]->ert1 * 1000) - ($get_ip_array_hours->hours[9]->ert1 * 1000),
						'POWERENERGY_HOUR9_PWR'				=> (($get_ip_array_hours->hours[9]->ert2 * 1000) - ($get_ip_array_hours->hours[10]->ert2	* 1000) != 0) ? ($get_ip_array_hours->hours[9]->ert2	* 1000) - ($get_ip_array_hours->hours[10]->ert2	* 1000) : ($get_ip_array_hours->hours[9]->ert1 * 1000) - ($get_ip_array_hours->hours[10]->ert1 * 1000),
						'POWERENERGY_HOUR10_PWR'			=> (($get_ip_array_hours->hours[10]->ert2 * 1000) - ($get_ip_array_hours->hours[11]->ert2	* 1000) != 0) ? ($get_ip_array_hours->hours[10]->ert2	* 1000) - ($get_ip_array_hours->hours[11]->ert2	* 1000) : ($get_ip_array_hours->hours[10]->ert1 * 1000) - ($get_ip_array_hours->hours[11]->ert1 * 1000),
						'POWERENERGY_HOUR11_PWR'			=> (($get_ip_array_hours->hours[11]->ert2 * 1000) - ($get_ip_array_hours->hours[12]->ert2	* 1000) != 0) ? ($get_ip_array_hours->hours[11]->ert2	* 1000) - ($get_ip_array_hours->hours[12]->ert2	* 1000) : ($get_ip_array_hours->hours[11]->ert1 * 1000) - ($get_ip_array_hours->hours[12]->ert1 * 1000),
						'POWERENERGY_HOUR12_PWR'			=> (($get_ip_array_hours->hours[12]->ert2 * 1000) - ($get_ip_array_hours->hours[13]->ert2	* 1000) != 0) ? ($get_ip_array_hours->hours[12]->ert2	* 1000) - ($get_ip_array_hours->hours[13]->ert2	* 1000) : ($get_ip_array_hours->hours[12]->ert1 * 1000) - ($get_ip_array_hours->hours[13]->ert1 * 1000),
						'POWERENERGY_HOUR13_PWR'			=> (($get_ip_array_hours->hours[13]->ert2 * 1000) - ($get_ip_array_hours->hours[14]->ert2	* 1000) != 0) ? ($get_ip_array_hours->hours[13]->ert2	* 1000) - ($get_ip_array_hours->hours[14]->ert2	* 1000) : ($get_ip_array_hours->hours[13]->ert1 * 1000) - ($get_ip_array_hours->hours[14]->ert1 * 1000),
						'POWERENERGY_HOUR14_PWR'			=> (($get_ip_array_hours->hours[14]->ert2 * 1000) - ($get_ip_array_hours->hours[15]->ert2	* 1000) != 0) ? ($get_ip_array_hours->hours[14]->ert2	* 1000) - ($get_ip_array_hours->hours[15]->ert2	* 1000) : ($get_ip_array_hours->hours[14]->ert1 * 1000) - ($get_ip_array_hours->hours[15]->ert1 * 1000),
						'POWERENERGY_HOUR15_PWR'			=> (($get_ip_array_hours->hours[15]->ert2 * 1000) - ($get_ip_array_hours->hours[16]->ert2	* 1000) != 0) ? ($get_ip_array_hours->hours[15]->ert2	* 1000) - ($get_ip_array_hours->hours[16]->ert2	* 1000) : ($get_ip_array_hours->hours[15]->ert1 * 1000) - ($get_ip_array_hours->hours[16]->ert1 * 1000),
						'POWERENERGY_HOUR16_PWR'			=> (($get_ip_array_hours->hours[16]->ert2 * 1000) - ($get_ip_array_hours->hours[17]->ert2	* 1000) != 0) ? ($get_ip_array_hours->hours[16]->ert2	* 1000) - ($get_ip_array_hours->hours[17]->ert2	* 1000) : ($get_ip_array_hours->hours[16]->ert1 * 1000) - ($get_ip_array_hours->hours[17]->ert1 * 1000),
						'POWERENERGY_HOUR17_PWR'			=> (($get_ip_array_hours->hours[17]->ert2 * 1000) - ($get_ip_array_hours->hours[18]->ert2	* 1000) != 0) ? ($get_ip_array_hours->hours[17]->ert2	* 1000) - ($get_ip_array_hours->hours[18]->ert2	* 1000) : ($get_ip_array_hours->hours[17]->ert1 * 1000) - ($get_ip_array_hours->hours[18]->ert1 * 1000),
						'POWERENERGY_HOUR18_PWR'			=> (($get_ip_array_hours->hours[18]->ert2 * 1000) - ($get_ip_array_hours->hours[19]->ert2	* 1000) != 0) ? ($get_ip_array_hours->hours[18]->ert2	* 1000) - ($get_ip_array_hours->hours[19]->ert2	* 1000) : ($get_ip_array_hours->hours[18]->ert1 * 1000) - ($get_ip_array_hours->hours[19]->ert1 * 1000),
						'POWERENERGY_HOUR19_PWR'			=> (($get_ip_array_hours->hours[19]->ert2 * 1000) - ($get_ip_array_hours->hours[20]->ert2	* 1000) != 0) ? ($get_ip_array_hours->hours[19]->ert2	* 1000) - ($get_ip_array_hours->hours[20]->ert2	* 1000) : ($get_ip_array_hours->hours[19]->ert1 * 1000) - ($get_ip_array_hours->hours[20]->ert1 * 1000),
						'POWERENERGY_HOUR20_PWR'			=> (($get_ip_array_hours->hours[20]->ert2 * 1000) - ($get_ip_array_hours->hours[21]->ert2	* 1000) != 0) ? ($get_ip_array_hours->hours[20]->ert2	* 1000) - ($get_ip_array_hours->hours[21]->ert2	* 1000) : ($get_ip_array_hours->hours[20]->ert1 * 1000) - ($get_ip_array_hours->hours[21]->ert1 * 1000),
						'POWERENERGY_HOUR21_PWR'			=> (($get_ip_array_hours->hours[21]->ert2 * 1000) - ($get_ip_array_hours->hours[22]->ert2	* 1000) != 0) ? ($get_ip_array_hours->hours[21]->ert2	* 1000) - ($get_ip_array_hours->hours[22]->ert2	* 1000) : ($get_ip_array_hours->hours[21]->ert1 * 1000) - ($get_ip_array_hours->hours[22]->ert1 * 1000),
						'POWERENERGY_HOUR22_PWR'			=> (($get_ip_array_hours->hours[22]->ert2 * 1000) - ($get_ip_array_hours->hours[23]->ert2	* 1000) != 0) ? ($get_ip_array_hours->hours[22]->ert2	* 1000) - ($get_ip_array_hours->hours[23]->ert2	* 1000) : ($get_ip_array_hours->hours[22]->ert1 * 1000) - ($get_ip_array_hours->hours[23]->ert1 * 1000),
						'POWERENERGY_HOUR23_PWR'			=> (($get_ip_array_hours->hours[23]->ert2 * 1000) - ($get_ip_array_hours->hours[24]->ert2	* 1000) != 0) ? ($get_ip_array_hours->hours[23]->ert2	* 1000) - ($get_ip_array_hours->hours[24]->ert2	* 1000) : ($get_ip_array_hours->hours[23]->ert1 * 1000) - ($get_ip_array_hours->hours[24]->ert1 * 1000),
						'POWERENERGY_HOUR24_PWR'			=> (($get_ip_array_hours->hours[24]->ert2 * 1000) - ($get_ip_array_hours->hours[25]->ert2	* 1000) != 0) ? ($get_ip_array_hours->hours[24]->ert2	* 1000) - ($get_ip_array_hours->hours[25]->ert2	* 1000) : ($get_ip_array_hours->hours[24]->ert1 * 1000) - ($get_ip_array_hours->hours[25]->ert1 * 1000),
						'POWERENERGY_HOUR25_PWR'			=> (($get_ip_array_hours->hours[25]->ert2 * 1000) - ($get_ip_array_hours->hours[26]->ert2	* 1000) != 0) ? ($get_ip_array_hours->hours[25]->ert2	* 1000) - ($get_ip_array_hours->hours[26]->ert2	* 1000) : ($get_ip_array_hours->hours[25]->ert1 * 1000) - ($get_ip_array_hours->hours[26]->ert1 * 1000),
						'POWERENERGY_HOUR26_PWR'			=> (($get_ip_array_hours->hours[26]->ert2 * 1000) - ($get_ip_array_hours->hours[27]->ert2	* 1000) != 0) ? ($get_ip_array_hours->hours[26]->ert2	* 1000) - ($get_ip_array_hours->hours[27]->ert2	* 1000) : ($get_ip_array_hours->hours[26]->ert1 * 1000) - ($get_ip_array_hours->hours[27]->ert1 * 1000),
						'POWERENERGY_HOUR27_PWR'			=> (($get_ip_array_hours->hours[27]->ert2 * 1000) - ($get_ip_array_hours->hours[28]->ert2	* 1000) != 0) ? ($get_ip_array_hours->hours[27]->ert2	* 1000) - ($get_ip_array_hours->hours[28]->ert2	* 1000) : ($get_ip_array_hours->hours[27]->ert1 * 1000) - ($get_ip_array_hours->hours[28]->ert1 * 1000),
						'POWERENERGY_HOUR28_PWR'			=> (($get_ip_array_hours->hours[28]->ert2 * 1000) - ($get_ip_array_hours->hours[29]->ert2	* 1000) != 0) ? ($get_ip_array_hours->hours[28]->ert2	* 1000) - ($get_ip_array_hours->hours[29]->ert2	* 1000) : ($get_ip_array_hours->hours[28]->ert1 * 1000) - ($get_ip_array_hours->hours[29]->ert1 * 1000),
						'POWERENERGY_HOUR29_PWR'			=> (($get_ip_array_hours->hours[29]->ert2 * 1000) - ($get_ip_array_hours->hours[31]->ert2	* 1000) != 0) ? ($get_ip_array_hours->hours[29]->ert2	* 1000) - ($get_ip_array_hours->hours[31]->ert2	* 1000) : ($get_ip_array_hours->hours[29]->ert1 * 1000) - ($get_ip_array_hours->hours[31]->ert1 * 1000),
						'POWERENERGY_HOUR30_PWR'			=> (($get_ip_array_hours->hours[30]->ert2 * 1000) - ($get_ip_array_hours->hours[32]->ert2	* 1000) != 0) ? ($get_ip_array_hours->hours[30]->ert2	* 1000) - ($get_ip_array_hours->hours[32]->ert2	* 1000) : ($get_ip_array_hours->hours[30]->ert1 * 1000) - ($get_ip_array_hours->hours[32]->ert1 * 1000),
						// Power used in watt
						'POWERENERGY_HOUR_PWU'				=> (($get_ip_array_hours->hours[0]->edt2 * 1000) - ($get_ip_array_hours->hours[1]->edt2 * 1000) != 0) ? ($get_ip_array_hours->hours[0]->edt2 * 1000) - ($get_ip_array_hours->hours[1]->edt2 * 1000) : ($get_ip_array_hours->hours[0]->edt1 * 1000) - ($get_ip_array_hours->hours[1]->edt1 * 1000),
						'POWERENERGY_HOUR1_PWU'				=> (($get_ip_array_hours->hours[1]->edt2 * 1000) - ($get_ip_array_hours->hours[2]->edt2 * 1000) != 0) ? ($get_ip_array_hours->hours[1]->edt2 * 1000) - ($get_ip_array_hours->hours[2]->edt2 * 1000) : ($get_ip_array_hours->hours[1]->edt1 * 1000) - ($get_ip_array_hours->hours[2]->edt1 * 1000),
						'POWERENERGY_HOUR2_PWU'				=> (($get_ip_array_hours->hours[2]->edt2 * 1000) - ($get_ip_array_hours->hours[3]->edt2 * 1000) != 0) ? ($get_ip_array_hours->hours[2]->edt2 * 1000) - ($get_ip_array_hours->hours[3]->edt2 * 1000) : ($get_ip_array_hours->hours[2]->edt1 * 1000) - ($get_ip_array_hours->hours[3]->edt1 * 1000),
						'POWERENERGY_HOUR3_PWU'				=> (($get_ip_array_hours->hours[3]->edt2 * 1000) - ($get_ip_array_hours->hours[4]->edt2 * 1000) != 0) ? ($get_ip_array_hours->hours[3]->edt2 * 1000) - ($get_ip_array_hours->hours[4]->edt2 * 1000) : ($get_ip_array_hours->hours[3]->edt1 * 1000) - ($get_ip_array_hours->hours[4]->edt1 * 1000),
						'POWERENERGY_HOUR4_PWU'				=> (($get_ip_array_hours->hours[4]->edt2 * 1000) - ($get_ip_array_hours->hours[5]->edt2 * 1000) != 0) ? ($get_ip_array_hours->hours[4]->edt2 * 1000) - ($get_ip_array_hours->hours[5]->edt2 * 1000) : ($get_ip_array_hours->hours[4]->edt1 * 1000) - ($get_ip_array_hours->hours[5]->edt1 * 1000),
						'POWERENERGY_HOUR5_PWU'				=> (($get_ip_array_hours->hours[5]->edt2 * 1000) - ($get_ip_array_hours->hours[6]->edt2 * 1000) != 0) ? ($get_ip_array_hours->hours[5]->edt2 * 1000) - ($get_ip_array_hours->hours[6]->edt2 * 1000) : ($get_ip_array_hours->hours[5]->edt1 * 1000) - ($get_ip_array_hours->hours[6]->edt1 * 1000),
						'POWERENERGY_HOUR6_PWU'				=> (($get_ip_array_hours->hours[6]->edt2 * 1000) - ($get_ip_array_hours->hours[7]->edt2 * 1000) != 0) ? ($get_ip_array_hours->hours[6]->edt2 * 1000) - ($get_ip_array_hours->hours[7]->edt2 * 1000) : ($get_ip_array_hours->hours[6]->edt1 * 1000) - ($get_ip_array_hours->hours[7]->edt1 * 1000),
						'POWERENERGY_HOUR7_PWU'				=> (($get_ip_array_hours->hours[7]->edt2 * 1000) - ($get_ip_array_hours->hours[8]->edt2 * 1000) != 0) ? ($get_ip_array_hours->hours[7]->edt2 * 1000) - ($get_ip_array_hours->hours[8]->edt2 * 1000) : ($get_ip_array_hours->hours[7]->edt1 * 1000) - ($get_ip_array_hours->hours[8]->edt1 * 1000),
						'POWERENERGY_HOUR8_PWU'				=> (($get_ip_array_hours->hours[8]->edt2 * 1000) - ($get_ip_array_hours->hours[9]->edt2 * 1000) != 0) ? ($get_ip_array_hours->hours[8]->edt2 * 1000) - ($get_ip_array_hours->hours[9]->edt2 * 1000) : ($get_ip_array_hours->hours[8]->edt1 * 1000) - ($get_ip_array_hours->hours[9]->edt1 * 1000),
						'POWERENERGY_HOUR9_PWU'				=> (($get_ip_array_hours->hours[9]->edt2 * 1000) - ($get_ip_array_hours->hours[10]->edt2 * 1000) != 0) ? ($get_ip_array_hours->hours[9]->edt2 * 1000) - ($get_ip_array_hours->hours[10]->edt2 * 1000) : ($get_ip_array_hours->hours[9]->edt1 * 1000) - ($get_ip_array_hours->hours[10]->edt1 * 1000),
						'POWERENERGY_HOUR10_PWU'			=> (($get_ip_array_hours->hours[10]->edt2 * 1000) - ($get_ip_array_hours->hours[11]->edt2 * 1000) != 0) ? ($get_ip_array_hours->hours[10]->edt2 * 1000) - ($get_ip_array_hours->hours[11]->edt2 * 1000) : ($get_ip_array_hours->hours[10]->edt1 * 1000) - ($get_ip_array_hours->hours[11]->edt1 * 1000),
						'POWERENERGY_HOUR11_PWU'			=> (($get_ip_array_hours->hours[11]->edt2 * 1000) - ($get_ip_array_hours->hours[12]->edt2 * 1000) != 0) ? ($get_ip_array_hours->hours[11]->edt2 * 1000) - ($get_ip_array_hours->hours[12]->edt2 * 1000) : ($get_ip_array_hours->hours[11]->edt1 * 1000) - ($get_ip_array_hours->hours[12]->edt1 * 1000),
						'POWERENERGY_HOUR12_PWU'			=> (($get_ip_array_hours->hours[12]->edt2 * 1000) - ($get_ip_array_hours->hours[13]->edt2 * 1000) != 0) ? ($get_ip_array_hours->hours[12]->edt2 * 1000) - ($get_ip_array_hours->hours[13]->edt2 * 1000) : ($get_ip_array_hours->hours[12]->edt1 * 1000) - ($get_ip_array_hours->hours[13]->edt1 * 1000),
						'POWERENERGY_HOUR13_PWU'			=> (($get_ip_array_hours->hours[13]->edt2 * 1000) - ($get_ip_array_hours->hours[14]->edt2 * 1000) != 0) ? ($get_ip_array_hours->hours[13]->edt2 * 1000) - ($get_ip_array_hours->hours[14]->edt2 * 1000) : ($get_ip_array_hours->hours[13]->edt1 * 1000) - ($get_ip_array_hours->hours[14]->edt1 * 1000),
						'POWERENERGY_HOUR14_PWU'			=> (($get_ip_array_hours->hours[14]->edt2 * 1000) - ($get_ip_array_hours->hours[15]->edt2 * 1000) != 0) ? ($get_ip_array_hours->hours[14]->edt2 * 1000) - ($get_ip_array_hours->hours[15]->edt2 * 1000) : ($get_ip_array_hours->hours[14]->edt1 * 1000) - ($get_ip_array_hours->hours[15]->edt1 * 1000),
						'POWERENERGY_HOUR15_PWU'			=> (($get_ip_array_hours->hours[15]->edt2 * 1000) - ($get_ip_array_hours->hours[16]->edt2 * 1000) != 0) ? ($get_ip_array_hours->hours[15]->edt2 * 1000) - ($get_ip_array_hours->hours[16]->edt2 * 1000) : ($get_ip_array_hours->hours[15]->edt1 * 1000) - ($get_ip_array_hours->hours[16]->edt1 * 1000),
						'POWERENERGY_HOUR16_PWU'			=> (($get_ip_array_hours->hours[16]->edt2 * 1000) - ($get_ip_array_hours->hours[17]->edt2 * 1000) != 0) ? ($get_ip_array_hours->hours[16]->edt2 * 1000) - ($get_ip_array_hours->hours[17]->edt2 * 1000) : ($get_ip_array_hours->hours[16]->edt1 * 1000) - ($get_ip_array_hours->hours[17]->edt1 * 1000),
						'POWERENERGY_HOUR17_PWU'			=> (($get_ip_array_hours->hours[17]->edt2 * 1000) - ($get_ip_array_hours->hours[18]->edt2 * 1000) != 0) ? ($get_ip_array_hours->hours[17]->edt2 * 1000) - ($get_ip_array_hours->hours[18]->edt2 * 1000) : ($get_ip_array_hours->hours[17]->edt1 * 1000) - ($get_ip_array_hours->hours[18]->edt1 * 1000),
						'POWERENERGY_HOUR18_PWU'			=> (($get_ip_array_hours->hours[18]->edt2 * 1000) - ($get_ip_array_hours->hours[19]->edt2 * 1000) != 0) ? ($get_ip_array_hours->hours[18]->edt2 * 1000) - ($get_ip_array_hours->hours[19]->edt2 * 1000) : ($get_ip_array_hours->hours[18]->edt1 * 1000) - ($get_ip_array_hours->hours[19]->edt1 * 1000),
						'POWERENERGY_HOUR19_PWU'			=> (($get_ip_array_hours->hours[19]->edt2 * 1000) - ($get_ip_array_hours->hours[20]->edt2 * 1000) != 0) ? ($get_ip_array_hours->hours[19]->edt2 * 1000) - ($get_ip_array_hours->hours[20]->edt2 * 1000) : ($get_ip_array_hours->hours[19]->edt1 * 1000) - ($get_ip_array_hours->hours[20]->edt1 * 1000),
						'POWERENERGY_HOUR20_PWU'			=> (($get_ip_array_hours->hours[20]->edt2 * 1000) - ($get_ip_array_hours->hours[21]->edt2 * 1000) != 0) ? ($get_ip_array_hours->hours[20]->edt2 * 1000) - ($get_ip_array_hours->hours[21]->edt2 * 1000) : ($get_ip_array_hours->hours[20]->edt1 * 1000) - ($get_ip_array_hours->hours[21]->edt1 * 1000),
						'POWERENERGY_HOUR21_PWU'			=> (($get_ip_array_hours->hours[21]->edt2 * 1000) - ($get_ip_array_hours->hours[22]->edt2 * 1000) != 0) ? ($get_ip_array_hours->hours[21]->edt2 * 1000) - ($get_ip_array_hours->hours[22]->edt2 * 1000) : ($get_ip_array_hours->hours[21]->edt1 * 1000) - ($get_ip_array_hours->hours[22]->edt1 * 1000),
						'POWERENERGY_HOUR22_PWU'			=> (($get_ip_array_hours->hours[22]->edt2 * 1000) - ($get_ip_array_hours->hours[23]->edt2 * 1000) != 0) ? ($get_ip_array_hours->hours[22]->edt2 * 1000) - ($get_ip_array_hours->hours[23]->edt2 * 1000) : ($get_ip_array_hours->hours[22]->edt1 * 1000) - ($get_ip_array_hours->hours[23]->edt1 * 1000),
						'POWERENERGY_HOUR23_PWU'			=> (($get_ip_array_hours->hours[23]->edt2 * 1000) - ($get_ip_array_hours->hours[24]->edt2 * 1000) != 0) ? ($get_ip_array_hours->hours[23]->edt2 * 1000) - ($get_ip_array_hours->hours[24]->edt2 * 1000) : ($get_ip_array_hours->hours[23]->edt1 * 1000) - ($get_ip_array_hours->hours[24]->edt1 * 1000),
						'POWERENERGY_HOUR24_PWU'			=> (($get_ip_array_hours->hours[24]->edt2 * 1000) - ($get_ip_array_hours->hours[25]->edt2 * 1000) != 0) ? ($get_ip_array_hours->hours[24]->edt2 * 1000) - ($get_ip_array_hours->hours[25]->edt2 * 1000) : ($get_ip_array_hours->hours[24]->edt1 * 1000) - ($get_ip_array_hours->hours[25]->edt1 * 1000),
						'POWERENERGY_HOUR25_PWU'			=> (($get_ip_array_hours->hours[25]->edt2 * 1000) - ($get_ip_array_hours->hours[26]->edt2 * 1000) != 0) ? ($get_ip_array_hours->hours[25]->edt2 * 1000) - ($get_ip_array_hours->hours[26]->edt2 * 1000) : ($get_ip_array_hours->hours[25]->edt1 * 1000) - ($get_ip_array_hours->hours[26]->edt1 * 1000),
						'POWERENERGY_HOUR26_PWU'			=> (($get_ip_array_hours->hours[26]->edt2 * 1000) - ($get_ip_array_hours->hours[27]->edt2 * 1000) != 0) ? ($get_ip_array_hours->hours[26]->edt2 * 1000) - ($get_ip_array_hours->hours[27]->edt2 * 1000) : ($get_ip_array_hours->hours[26]->edt1 * 1000) - ($get_ip_array_hours->hours[27]->edt1 * 1000),
						'POWERENERGY_HOUR27_PWU'			=> (($get_ip_array_hours->hours[27]->edt2 * 1000) - ($get_ip_array_hours->hours[28]->edt2 * 1000) != 0) ? ($get_ip_array_hours->hours[27]->edt2 * 1000) - ($get_ip_array_hours->hours[28]->edt2 * 1000) : ($get_ip_array_hours->hours[27]->edt1 * 1000) - ($get_ip_array_hours->hours[28]->edt1 * 1000),
						'POWERENERGY_HOUR28_PWU'			=> (($get_ip_array_hours->hours[28]->edt2 * 1000) - ($get_ip_array_hours->hours[29]->edt2 * 1000) != 0) ? ($get_ip_array_hours->hours[28]->edt2 * 1000) - ($get_ip_array_hours->hours[29]->edt2 * 1000) : ($get_ip_array_hours->hours[28]->edt1 * 1000) - ($get_ip_array_hours->hours[29]->edt1 * 1000),
						'POWERENERGY_HOUR29_PWU'			=> (($get_ip_array_hours->hours[29]->edt2 * 1000) - ($get_ip_array_hours->hours[31]->edt2 * 1000) != 0) ? ($get_ip_array_hours->hours[29]->edt2 * 1000) - ($get_ip_array_hours->hours[31]->edt2 * 1000) : ($get_ip_array_hours->hours[29]->edt1 * 1000) - ($get_ip_array_hours->hours[31]->edt1 * 1000),
						'POWERENERGY_HOUR30_PWU'			=> (($get_ip_array_hours->hours[30]->edt2 * 1000) - ($get_ip_array_hours->hours[32]->edt2 * 1000) != 0) ? ($get_ip_array_hours->hours[30]->edt2 * 1000) - ($get_ip_array_hours->hours[32]->edt2 * 1000) : ($get_ip_array_hours->hours[30]->edt1 * 1000) - ($get_ip_array_hours->hours[32]->edt1 * 1000),
						// Hours date
						'POWERENERGY_HOUR_DATE'				=> $get_ip_array_hours->hours[0]->recid,
						'POWERENERGY_HOUR1_DATE'				=> $get_ip_array_hours->hours[1]->recid,
						'POWERENERGY_HOUR2_DATE'				=> $get_ip_array_hours->hours[2]->recid,
						'POWERENERGY_HOUR3_DATE'				=> $get_ip_array_hours->hours[3]->recid,
						'POWERENERGY_HOUR4_DATE'				=> $get_ip_array_hours->hours[4]->recid,
						'POWERENERGY_HOUR5_DATE'				=> $get_ip_array_hours->hours[5]->recid,
						'POWERENERGY_HOUR6_DATE'				=> $get_ip_array_hours->hours[6]->recid,
						'POWERENERGY_HOUR7_DATE'				=> $get_ip_array_hours->hours[7]->recid,
						'POWERENERGY_HOUR8_DATE'				=> $get_ip_array_hours->hours[8]->recid,
						'POWERENERGY_HOUR9_DATE'				=> $get_ip_array_hours->hours[9]->recid,
						'POWERENERGY_HOUR10_DATE'				=> $get_ip_array_hours->hours[10]->recid,
						'POWERENERGY_HOUR11_DATE'				=> $get_ip_array_hours->hours[11]->recid,
						'POWERENERGY_HOUR12_DATE'				=> $get_ip_array_hours->hours[12]->recid,
						'POWERENERGY_HOUR13_DATE'				=> $get_ip_array_hours->hours[13]->recid,
						'POWERENERGY_HOUR14_DATE'				=> $get_ip_array_hours->hours[14]->recid,
						'POWERENERGY_HOUR15_DATE'				=> $get_ip_array_hours->hours[15]->recid,
						'POWERENERGY_HOUR16_DATE'				=> $get_ip_array_hours->hours[16]->recid,
						'POWERENERGY_HOUR17_DATE'				=> $get_ip_array_hours->hours[17]->recid,
						'POWERENERGY_HOUR18_DATE'				=> $get_ip_array_hours->hours[18]->recid,
						'POWERENERGY_HOUR19_DATE'				=> $get_ip_array_hours->hours[19]->recid,
						'POWERENERGY_HOUR20_DATE'				=> $get_ip_array_hours->hours[20]->recid,
						'POWERENERGY_HOUR21_DATE'				=> $get_ip_array_hours->hours[21]->recid,
						'POWERENERGY_HOUR22_DATE'				=> $get_ip_array_hours->hours[22]->recid,
						'POWERENERGY_HOUR23_DATE'				=> $get_ip_array_hours->hours[23]->recid,
						'POWERENERGY_HOUR24_DATE'				=> $get_ip_array_hours->hours[24]->recid,
						'POWERENERGY_HOUR25_DATE'				=> $get_ip_array_hours->hours[25]->recid,
						'POWERENERGY_HOUR26_DATE'				=> $get_ip_array_hours->hours[26]->recid,
						'POWERENERGY_HOUR27_DATE'				=> $get_ip_array_hours->hours[27]->recid,
						'POWERENERGY_HOUR28_DATE'				=> $get_ip_array_hours->hours[28]->recid,
						'POWERENERGY_HOUR29_DATE'				=> $get_ip_array_hours->hours[29]->recid,
						'POWERENERGY_HOUR30_DATE'				=> $get_ip_array_hours->hours[30]->recid,

					]);
				}
				// --------------- End Hours ---------------------- //

			break;

			case 'd':
				// --------------- Start Days ---------------------- //
				$get_days = 'days';
				$get_ip_array_days = $this->functions->get_ip_array($get_days);

				if (!empty($get_ip_array_days))
				{
					$this->template->assign_block_vars('powerenergy_days',[
						// Power returned in watt
						'POWERENERGY_DAY_PWR'				=> (($get_ip_array_days->days[0]->ert2 * 1000) - ($get_ip_array_days->days[1]->ert2	* 1000) != 0) ? ($get_ip_array_days->days[0]->ert2	* 1000) - ($get_ip_array_days->days[1]->ert2	* 1000) : ($get_ip_array_days->days[0]->ert1 * 1000) - ($get_ip_array_days->days[1]->ert1 * 1000),
						'POWERENERGY_DAY1_PWR'				=> (($get_ip_array_days->days[1]->ert2 * 1000) - ($get_ip_array_days->days[2]->ert2	* 1000) != 0) ? ($get_ip_array_days->days[1]->ert2	* 1000) - ($get_ip_array_days->days[2]->ert2	* 1000) : ($get_ip_array_days->days[1]->ert1 * 1000) - ($get_ip_array_days->days[2]->ert1 * 1000),
						'POWERENERGY_DAY2_PWR'				=> (($get_ip_array_days->days[2]->ert2 * 1000) - ($get_ip_array_days->days[3]->ert2	* 1000) != 0) ? ($get_ip_array_days->days[2]->ert2	* 1000) - ($get_ip_array_days->days[3]->ert2	* 1000) : ($get_ip_array_days->days[2]->ert1 * 1000) - ($get_ip_array_days->days[3]->ert1 * 1000),
						'POWERENERGY_DAY3_PWR'				=> (($get_ip_array_days->days[3]->ert2 * 1000) - ($get_ip_array_days->days[4]->ert2	* 1000) != 0) ? ($get_ip_array_days->days[3]->ert2	* 1000) - ($get_ip_array_days->days[4]->ert2	* 1000) : ($get_ip_array_days->days[3]->ert1 * 1000) - ($get_ip_array_days->days[4]->ert1 * 1000),
						'POWERENERGY_DAY4_PWR'				=> (($get_ip_array_days->days[4]->ert2 * 1000) - ($get_ip_array_days->days[5]->ert2	* 1000) != 0) ? ($get_ip_array_days->days[4]->ert2	* 1000) - ($get_ip_array_days->days[5]->ert2	* 1000) : ($get_ip_array_days->days[4]->ert1 * 1000) - ($get_ip_array_days->days[5]->ert1 * 1000),
						'POWERENERGY_DAY5_PWR'				=> (($get_ip_array_days->days[5]->ert2 * 1000) - ($get_ip_array_days->days[6]->ert2	* 1000) != 0) ? ($get_ip_array_days->days[5]->ert2	* 1000) - ($get_ip_array_days->days[6]->ert2	* 1000) : ($get_ip_array_days->days[5]->ert1 * 1000) - ($get_ip_array_days->days[6]->ert1 * 1000),
						'POWERENERGY_DAY6_PWR'				=> (($get_ip_array_days->days[6]->ert2 * 1000) - ($get_ip_array_days->days[7]->ert2	* 1000) != 0) ? ($get_ip_array_days->days[6]->ert2	* 1000) - ($get_ip_array_days->days[7]->ert2	* 1000) : ($get_ip_array_days->days[6]->ert1 * 1000) - ($get_ip_array_days->days[7]->ert1 * 1000),
						'POWERENERGY_DAY7_PWR'				=> (($get_ip_array_days->days[7]->ert2 * 1000) - ($get_ip_array_days->days[8]->ert2	* 1000) != 0) ? ($get_ip_array_days->days[7]->ert2	* 1000) - ($get_ip_array_days->days[8]->ert2	* 1000) : ($get_ip_array_days->days[7]->ert1 * 1000) - ($get_ip_array_days->days[8]->ert1 * 1000),
						'POWERENERGY_DAY8_PWR'				=> (($get_ip_array_days->days[8]->ert2 * 1000) - ($get_ip_array_days->days[9]->ert2	* 1000) != 0) ? ($get_ip_array_days->days[8]->ert2	* 1000) - ($get_ip_array_days->days[9]->ert2	* 1000) : ($get_ip_array_days->days[8]->ert1 * 1000) - ($get_ip_array_days->days[9]->ert1 * 1000),
						'POWERENERGY_DAY9_PWR'				=> (($get_ip_array_days->days[9]->ert2 * 1000) - ($get_ip_array_days->days[10]->ert2	* 1000) != 0) ? ($get_ip_array_days->days[9]->ert2	* 1000) - ($get_ip_array_days->days[10]->ert2	* 1000) : ($get_ip_array_days->days[9]->ert1 * 1000) - ($get_ip_array_days->days[10]->ert1 * 1000),
						'POWERENERGY_DAY10_PWR'				=> (($get_ip_array_days->days[10]->ert2 * 1000) - ($get_ip_array_days->days[11]->ert2	* 1000) != 0) ? ($get_ip_array_days->days[10]->ert2	* 1000) - ($get_ip_array_days->days[11]->ert2	* 1000) : ($get_ip_array_days->days[10]->ert1 * 1000) - ($get_ip_array_days->days[11]->ert1 * 1000),
						'POWERENERGY_DAY11_PWR'				=> (($get_ip_array_days->days[11]->ert2 * 1000) - ($get_ip_array_days->days[12]->ert2	* 1000) != 0) ? ($get_ip_array_days->days[11]->ert2	* 1000) - ($get_ip_array_days->days[12]->ert2	* 1000) : ($get_ip_array_days->days[11]->ert1 * 1000) - ($get_ip_array_days->days[12]->ert1 * 1000),
						'POWERENERGY_DAY12_PWR'				=> (($get_ip_array_days->days[12]->ert2 * 1000) - ($get_ip_array_days->days[13]->ert2	* 1000) != 0) ? ($get_ip_array_days->days[12]->ert2	* 1000) - ($get_ip_array_days->days[13]->ert2	* 1000) : ($get_ip_array_days->days[12]->ert1 * 1000) - ($get_ip_array_days->days[13]->ert1 * 1000),
						'POWERENERGY_DAY13_PWR'				=> (($get_ip_array_days->days[13]->ert2 * 1000) - ($get_ip_array_days->days[14]->ert2	* 1000) != 0) ? ($get_ip_array_days->days[13]->ert2	* 1000) - ($get_ip_array_days->days[14]->ert2	* 1000) : ($get_ip_array_days->days[13]->ert1 * 1000) - ($get_ip_array_days->days[14]->ert1 * 1000),
						// Power used in watt
						'POWERENERGY_DAY_PWU'				=> (($get_ip_array_days->days[0]->edt2 * 1000) - ($get_ip_array_days->days[1]->edt2 * 1000) != 0) ? ($get_ip_array_days->days[0]->edt2 * 1000) - ($get_ip_array_days->days[1]->edt2 * 1000) + ($get_ip_array_days->days[0]->edt1 * 1000) - ($get_ip_array_days->days[1]->edt1 * 1000) : ($get_ip_array_days->days[0]->edt1 * 1000) - ($get_ip_array_days->days[1]->edt1 * 1000),
						'POWERENERGY_DAY1_PWU'				=> (($get_ip_array_days->days[1]->edt2 * 1000) - ($get_ip_array_days->days[2]->edt2 * 1000) != 0) ? ($get_ip_array_days->days[1]->edt2 * 1000) - ($get_ip_array_days->days[2]->edt2 * 1000) + ($get_ip_array_days->days[1]->edt1 * 1000) - ($get_ip_array_days->days[2]->edt1 * 1000) : ($get_ip_array_days->days[1]->edt1 * 1000) - ($get_ip_array_days->days[2]->edt1 * 1000),
						'POWERENERGY_DAY2_PWU'				=> (($get_ip_array_days->days[2]->edt2 * 1000) - ($get_ip_array_days->days[3]->edt2 * 1000) != 0) ? ($get_ip_array_days->days[2]->edt2 * 1000) - ($get_ip_array_days->days[3]->edt2 * 1000) + ($get_ip_array_days->days[2]->edt1 * 1000) - ($get_ip_array_days->days[3]->edt1 * 1000) : ($get_ip_array_days->days[2]->edt1 * 1000) - ($get_ip_array_days->days[3]->edt1 * 1000),
						'POWERENERGY_DAY3_PWU'				=> (($get_ip_array_days->days[3]->edt2 * 1000) - ($get_ip_array_days->days[4]->edt2 * 1000) != 0) ? ($get_ip_array_days->days[3]->edt2 * 1000) - ($get_ip_array_days->days[4]->edt2 * 1000) + ($get_ip_array_days->days[3]->edt1 * 1000) - ($get_ip_array_days->days[4]->edt1 * 1000) : ($get_ip_array_days->days[3]->edt1 * 1000) - ($get_ip_array_days->days[4]->edt1 * 1000),
						'POWERENERGY_DAY4_PWU'				=> (($get_ip_array_days->days[4]->edt2 * 1000) - ($get_ip_array_days->days[5]->edt2 * 1000) != 0) ? ($get_ip_array_days->days[4]->edt2 * 1000) - ($get_ip_array_days->days[5]->edt2 * 1000) + ($get_ip_array_days->days[4]->edt1 * 1000) - ($get_ip_array_days->days[5]->edt1 * 1000) : ($get_ip_array_days->days[4]->edt1 * 1000) - ($get_ip_array_days->days[5]->edt1 * 1000),
						'POWERENERGY_DAY5_PWU'				=> (($get_ip_array_days->days[5]->edt2 * 1000) - ($get_ip_array_days->days[6]->edt2 * 1000) != 0) ? ($get_ip_array_days->days[5]->edt2 * 1000) - ($get_ip_array_days->days[6]->edt2 * 1000) + ($get_ip_array_days->days[5]->edt1 * 1000) - ($get_ip_array_days->days[6]->edt1 * 1000) : ($get_ip_array_days->days[5]->edt1 * 1000) - ($get_ip_array_days->days[6]->edt1 * 1000),
						'POWERENERGY_DAY6_PWU'				=> (($get_ip_array_days->days[6]->edt2 * 1000) - ($get_ip_array_days->days[7]->edt2 * 1000) != 0) ? ($get_ip_array_days->days[6]->edt2 * 1000) - ($get_ip_array_days->days[7]->edt2 * 1000) + ($get_ip_array_days->days[6]->edt1 * 1000) - ($get_ip_array_days->days[7]->edt1 * 1000) : ($get_ip_array_days->days[6]->edt1 * 1000) - ($get_ip_array_days->days[7]->edt1 * 1000),
						'POWERENERGY_DAY7_PWU'				=> (($get_ip_array_days->days[7]->edt2 * 1000) - ($get_ip_array_days->days[8]->edt2 * 1000) != 0) ? ($get_ip_array_days->days[7]->edt2 * 1000) - ($get_ip_array_days->days[8]->edt2 * 1000) + ($get_ip_array_days->days[7]->edt1 * 1000) - ($get_ip_array_days->days[8]->edt1 * 1000) : ($get_ip_array_days->days[7]->edt1 * 1000) - ($get_ip_array_days->days[8]->edt1 * 1000),
						'POWERENERGY_DAY8_PWU'				=> (($get_ip_array_days->days[8]->edt2 * 1000) - ($get_ip_array_days->days[9]->edt2 * 1000) != 0) ? ($get_ip_array_days->days[8]->edt2 * 1000) - ($get_ip_array_days->days[9]->edt2 * 1000) + ($get_ip_array_days->days[8]->edt1 * 1000) - ($get_ip_array_days->days[9]->edt1 * 1000) : ($get_ip_array_days->days[8]->edt1 * 1000) - ($get_ip_array_days->days[9]->edt1 * 1000),
						'POWERENERGY_DAY9_PWU'				=> (($get_ip_array_days->days[9]->edt2 * 1000) - ($get_ip_array_days->days[10]->edt2 * 1000) != 0) ? ($get_ip_array_days->days[9]->edt2 * 1000) - ($get_ip_array_days->days[10]->edt2 * 1000) + ($get_ip_array_days->days[9]->edt1 * 1000) - ($get_ip_array_days->days[10]->edt1 * 1000) : ($get_ip_array_days->days[9]->edt1 * 1000) - ($get_ip_array_days->days[10]->edt1 * 1000),
						'POWERENERGY_DAY10_PWU'				=> (($get_ip_array_days->days[10]->edt2 * 1000) - ($get_ip_array_days->days[11]->edt2 * 1000) != 0) ? ($get_ip_array_days->days[10]->edt2 * 1000) - ($get_ip_array_days->days[11]->edt2 * 1000) + ($get_ip_array_days->days[10]->edt1 * 1000) - ($get_ip_array_days->days[11]->edt1 * 1000) : ($get_ip_array_days->days[10]->edt1 * 1000) - ($get_ip_array_days->days[11]->edt1 * 1000),
						'POWERENERGY_DAY11_PWU'				=> (($get_ip_array_days->days[11]->edt2 * 1000) - ($get_ip_array_days->days[12]->edt2 * 1000) != 0) ? ($get_ip_array_days->days[11]->edt2 * 1000) - ($get_ip_array_days->days[12]->edt2 * 1000) + ($get_ip_array_days->days[11]->edt1 * 1000) - ($get_ip_array_days->days[12]->edt1 * 1000) : ($get_ip_array_days->days[11]->edt1 * 1000) - ($get_ip_array_days->days[12]->edt1 * 1000),
						'POWERENERGY_DAY12_PWU'				=> (($get_ip_array_days->days[12]->edt2 * 1000) - ($get_ip_array_days->days[13]->edt2 * 1000) != 0) ? ($get_ip_array_days->days[12]->edt2 * 1000) - ($get_ip_array_days->days[13]->edt2 * 1000) + ($get_ip_array_days->days[12]->edt1 * 1000) - ($get_ip_array_days->days[13]->edt1 * 1000) : ($get_ip_array_days->days[12]->edt1 * 1000) - ($get_ip_array_days->days[13]->edt1 * 1000),
						'POWERENERGY_DAY13_PWU'				=> (($get_ip_array_days->days[13]->edt2 * 1000) - ($get_ip_array_days->days[14]->edt2 * 1000) != 0) ? ($get_ip_array_days->days[13]->edt2 * 1000) - ($get_ip_array_days->days[14]->edt2 * 1000) + ($get_ip_array_days->days[13]->edt1 * 1000) - ($get_ip_array_days->days[14]->edt1 * 1000) : ($get_ip_array_days->days[13]->edt1 * 1000) - ($get_ip_array_days->days[14]->edt1 * 1000),
						// Days date
						'POWERENERGY_DAY_DATE'				=> $get_ip_array_days->days[0]->recid,
						'POWERENERGY_DAY1_DATE'				=> $get_ip_array_days->days[1]->recid,
						'POWERENERGY_DAY2_DATE'				=> $get_ip_array_days->days[2]->recid,
						'POWERENERGY_DAY3_DATE'				=> $get_ip_array_days->days[3]->recid,
						'POWERENERGY_DAY4_DATE'				=> $get_ip_array_days->days[4]->recid,
						'POWERENERGY_DAY5_DATE'				=> $get_ip_array_days->days[5]->recid,
						'POWERENERGY_DAY6_DATE'				=> $get_ip_array_days->days[6]->recid,
						'POWERENERGY_DAY7_DATE'				=> $get_ip_array_days->days[7]->recid,
						'POWERENERGY_DAY8_DATE'				=> $get_ip_array_days->days[8]->recid,
						'POWERENERGY_DAY9_DATE'				=> $get_ip_array_days->days[9]->recid,
						'POWERENERGY_DAY10_DATE'				=> $get_ip_array_days->days[10]->recid,
						'POWERENERGY_DAY11_DATE'				=> $get_ip_array_days->days[11]->recid,
						'POWERENERGY_DAY12_DATE'				=> $get_ip_array_days->days[12]->recid,
						'POWERENERGY_DAY13_DATE'				=> $get_ip_array_days->days[13]->recid,
					]);
				}
				// --------------- End Days ---------------------- //

			break;

			case 'm':
				// --------------- Start Months ---------------------- //
				$get_months = 'months';
				$get_ip_array_months = $this->functions->get_ip_array($get_months);

				if (!empty($get_ip_array_months))
				{
					$this->template->assign_block_vars('powerenergy_months',[
						// Power returned in watt
						'POWERENERGY_MONTH_PWR'				=> ($get_ip_array_months->months[0]->ert2) - ($get_ip_array_months->months[1]->ert2) + ($get_ip_array_months->months[0]->ert1) - ($get_ip_array_months->months[1]->ert1),
						'POWERENERGY_MONTH1_PWR'			=> ($get_ip_array_months->months[1]->ert2) - ($get_ip_array_months->months[2]->ert2) + ($get_ip_array_months->months[1]->ert1) - ($get_ip_array_months->months[2]->ert1),
						'POWERENERGY_MONTH2_PWR'			=> ($get_ip_array_months->months[2]->ert2) - ($get_ip_array_months->months[3]->ert2) + ($get_ip_array_months->months[2]->ert1) - ($get_ip_array_months->months[3]->ert1),
						'POWERENERGY_MONTH3_PWR'			=> ($get_ip_array_months->months[3]->ert2) - ($get_ip_array_months->months[4]->ert2) + ($get_ip_array_months->months[3]->ert1) - ($get_ip_array_months->months[4]->ert1),
						'POWERENERGY_MONTH4_PWR'			=> ($get_ip_array_months->months[4]->ert2) - ($get_ip_array_months->months[5]->ert2) + ($get_ip_array_months->months[4]->ert1) - ($get_ip_array_months->months[5]->ert1),
						'POWERENERGY_MONTH5_PWR'			=> ($get_ip_array_months->months[5]->ert2) - ($get_ip_array_months->months[6]->ert2) + ($get_ip_array_months->months[5]->ert1) - ($get_ip_array_months->months[6]->ert1),
						'POWERENERGY_MONTH6_PWR'			=> ($get_ip_array_months->months[6]->ert2) - ($get_ip_array_months->months[7]->ert2) + ($get_ip_array_months->months[6]->ert1) - ($get_ip_array_months->months[7]->ert1),
						'POWERENERGY_MONTH7_PWR'			=> ($get_ip_array_months->months[7]->ert2) - ($get_ip_array_months->months[8]->ert2) + ($get_ip_array_months->months[7]->ert1) - ($get_ip_array_months->months[8]->ert1),
						'POWERENERGY_MONTH8_PWR'			=> ($get_ip_array_months->months[8]->ert2) - ($get_ip_array_months->months[9]->ert2) + ($get_ip_array_months->months[8]->ert1) - ($get_ip_array_months->months[9]->ert1),
						'POWERENERGY_MONTH9_PWR'			=> ($get_ip_array_months->months[9]->ert2) - ($get_ip_array_months->months[10]->ert2) + ($get_ip_array_months->months[9]->ert1) - ($get_ip_array_months->months[10]->ert1),
						'POWERENERGY_MONTH10_PWR'			=> ($get_ip_array_months->months[10]->ert2) - ($get_ip_array_months->months[11]->ert2) + ($get_ip_array_months->months[10]->ert1) - ($get_ip_array_months->months[11]->ert1),
						'POWERENERGY_MONTH11_PWR'			=> ($get_ip_array_months->months[11]->ert2) - ($get_ip_array_months->months[12]->ert2) + ($get_ip_array_months->months[11]->ert1) - ($get_ip_array_months->months[12]->ert1),
						'POWERENERGY_MONTH12_PWR'			=> ($get_ip_array_months->months[12]->ert2) - ($get_ip_array_months->months[13]->ert2) + ($get_ip_array_months->months[12]->ert1) - ($get_ip_array_months->months[13]->ert1),
						'POWERENERGY_MONTH13_PWR'			=> ($get_ip_array_months->months[13]->ert2) - ($get_ip_array_months->months[14]->ert2) + ($get_ip_array_months->months[13]->ert1) - ($get_ip_array_months->months[14]->ert1),
						// Power used in watt
						'POWERENERGY_MONTH_PWU'				=> ($get_ip_array_months->months[0]->edt2) - ($get_ip_array_months->months[1]->edt2) + ($get_ip_array_months->months[0]->edt1) - ($get_ip_array_months->months[1]->edt1),
						'POWERENERGY_MONTH1_PWU'			=> ($get_ip_array_months->months[1]->edt2) - ($get_ip_array_months->months[2]->edt2) + ($get_ip_array_months->months[1]->edt1) - ($get_ip_array_months->months[2]->edt1),
						'POWERENERGY_MONTH2_PWU'			=> ($get_ip_array_months->months[2]->edt2) - ($get_ip_array_months->months[3]->edt2) + ($get_ip_array_months->months[2]->edt1) - ($get_ip_array_months->months[3]->edt1),
						'POWERENERGY_MONTH3_PWU'			=> ($get_ip_array_months->months[3]->edt2) - ($get_ip_array_months->months[4]->edt2) + ($get_ip_array_months->months[3]->edt1) - ($get_ip_array_months->months[4]->edt1),
						'POWERENERGY_MONTH4_PWU'			=> ($get_ip_array_months->months[4]->edt2) - ($get_ip_array_months->months[5]->edt2) + ($get_ip_array_months->months[4]->edt1) - ($get_ip_array_months->months[5]->edt1),
						'POWERENERGY_MONTH5_PWU'			=> ($get_ip_array_months->months[5]->edt2) - ($get_ip_array_months->months[6]->edt2) + ($get_ip_array_months->months[5]->edt1) - ($get_ip_array_months->months[6]->edt1),
						'POWERENERGY_MONTH6_PWU'			=> ($get_ip_array_months->months[6]->edt2) - ($get_ip_array_months->months[7]->edt2) + ($get_ip_array_months->months[6]->edt1) - ($get_ip_array_months->months[7]->edt1),
						'POWERENERGY_MONTH7_PWU'			=> ($get_ip_array_months->months[7]->edt2) - ($get_ip_array_months->months[8]->edt2) + ($get_ip_array_months->months[7]->edt1) - ($get_ip_array_months->months[8]->edt1),
						'POWERENERGY_MONTH8_PWU'			=> ($get_ip_array_months->months[8]->edt2) - ($get_ip_array_months->months[9]->edt2) + ($get_ip_array_months->months[8]->edt1) - ($get_ip_array_months->months[9]->edt1),
						'POWERENERGY_MONTH9_PWU'			=> ($get_ip_array_months->months[9]->edt2) - ($get_ip_array_months->months[10]->edt2) + ($get_ip_array_months->months[9]->edt1) - ($get_ip_array_months->months[10]->edt1),
						'POWERENERGY_MONTH10_PWU'			=> ($get_ip_array_months->months[10]->edt2) - ($get_ip_array_months->months[11]->edt2) + ($get_ip_array_months->months[10]->edt1) - ($get_ip_array_months->months[11]->edt1),
						'POWERENERGY_MONTH11_PWU'			=> ($get_ip_array_months->months[11]->edt2) - ($get_ip_array_months->months[12]->edt2) + ($get_ip_array_months->months[11]->edt1) - ($get_ip_array_months->months[12]->edt1),
						'POWERENERGY_MONTH12_PWU'			=> ($get_ip_array_months->months[12]->edt2) - ($get_ip_array_months->months[13]->edt2) + ($get_ip_array_months->months[12]->edt1) - ($get_ip_array_months->months[13]->edt1),
						'POWERENERGY_MONTH13_PWU'			=> ($get_ip_array_months->months[13]->edt2) - ($get_ip_array_months->months[14]->edt2) + ($get_ip_array_months->months[13]->edt1) - ($get_ip_array_months->months[14]->edt1),
						// Months date
						'POWERENERGY_MONTH_DATE'				=> $get_ip_array_months->months[0]->recid,
						'POWERENERGY_MONTH1_DATE'				=> $get_ip_array_months->months[1]->recid,
						'POWERENERGY_MONTH2_DATE'				=> $get_ip_array_months->months[2]->recid,
						'POWERENERGY_MONTH3_DATE'				=> $get_ip_array_months->months[3]->recid,
						'POWERENERGY_MONTH4_DATE'				=> $get_ip_array_months->months[4]->recid,
						'POWERENERGY_MONTH5_DATE'				=> $get_ip_array_months->months[5]->recid,
						'POWERENERGY_MONTH6_DATE'				=> $get_ip_array_months->months[6]->recid,
						'POWERENERGY_MONTH7_DATE'				=> $get_ip_array_months->months[7]->recid,
						'POWERENERGY_MONTH8_DATE'				=> $get_ip_array_months->months[8]->recid,
						'POWERENERGY_MONTH9_DATE'				=> $get_ip_array_months->months[9]->recid,
						'POWERENERGY_MONTH10_DATE'			=> $get_ip_array_months->months[10]->recid,
						'POWERENERGY_MONTH11_DATE'			=> $get_ip_array_months->months[11]->recid,
						'POWERENERGY_MONTH12_DATE'			=> $get_ip_array_months->months[12]->recid,
						'POWERENERGY_MONTH13_DATE'			=> $get_ip_array_months->months[13]->recid,

					]);
				}
				// --------------- End Months ---------------------- //

			break;

			default:
		}

		$this->functions->assign_authors();

		$this->template->assign_vars([
			'POWERENERGY_FOOTER_VIEW'	=> true,
			'DMZX_POWERENERGY_VERSION'	=> $this->config['dmzx_powerenergy_version'],
			'U_H_MODE'					=> $this->helper->route('dmzx_powerenergy_controller', ['mode' => 'h']),
			'U_D_MODE'					=> $this->helper->route('dmzx_powerenergy_controller', ['mode' => 'd']),
			'U_M_MODE'					=> $this->helper->route('dmzx_powerenergy_controller', ['mode' => 'm']),

		]);

		$this->template->set_filenames(['body' => $mode . '_powerenergy_body.html']);
		$page_title = $this->language->lang('POWERENERGY_PAGE') . ' &bull; ' . $this->language->lang(strtoupper($mode . '_powerenergy_view'));
		page_header($page_title);
		page_footer();
	}
}
