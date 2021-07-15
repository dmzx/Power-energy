<?php
/**
 *
 * Power energy. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2021, dmzx, https://www.dmzx-web.net
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace dmzx\powerenergy\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use phpbb\language\language;
use phpbb\controller\helper;
use phpbb\template\template;
use phpbb\auth\auth;

class main_listener implements EventSubscriberInterface
{
	/* @var language */
	protected $language;

	/* @var helper */
	protected $helper;

	/* @var template */
	protected $template;

	/** @var auth */
	protected $auth;

	/** @var string phpEx */
	protected $php_ext;

	/**
	 * Constructor
	 *
	 * @param language		$language
	 * @param helper		$helper
	 * @param template		$template
	 * @param auth			$auth
	 * @param string		$php_ext
	 */
	public function __construct(
		language $language,
		helper $helper,
		template $template,
		auth $auth,
		$php_ext
	)
	{
		$this->language = $language;
		$this->helper	= $helper;
		$this->template = $template;
		$this->auth 	= $auth;
		$this->php_ext	= $php_ext;
	}

	public static function getSubscribedEvents(): array
	{
		return [
			'core.user_setup'							=> 'load_language_on_setup',
			'core.page_header'							=> 'add_page_header_link',
			'core.viewonline_overwrite_location'		=> 'viewonline_page',
			'core.permissions'							=> 'add_permissions',
		];
	}

	public function load_language_on_setup($event):void
	{
		$lang_set_ext = $event['lang_set_ext'];
		$lang_set_ext[] = [
			'ext_name' => 'dmzx/powerenergy',
			'lang_set' => 'common',
		];
		$event['lang_set_ext'] = $lang_set_ext;
	}

	public function add_page_header_link():void
	{
		$this->template->assign_vars([
			'U_POWERENERGY_PAGE'	=> $this->helper->route('dmzx_powerenergy_controller'),
			'POWERENERGY_ALLOW_USE'	=> $this->auth->acl_get('u_dmzx_powerenergy'),
		]);
	}

	public function viewonline_page($event):void
	{
		if ($event['on_page'][1] === 'app' && strrpos($event['row']['session_page'], 'app.' . $this->php_ext . '/powerenergy') === 0)
		{
			$event['location'] = $this->language->lang('VIEWING_DMZX_POWERENERGY');
			$event['location_url'] = $this->helper->route('dmzx_powerenergy_controller');
		}
	}

	public function add_permissions($event):void
	{
		$permissions = $event['permissions'];
		$permissions['u_dmzx_powerenergy'] = ['lang' => 'ACL_U_DMZX_POWERENERGY', 'cat' => 'misc'];
		$event['permissions'] = $permissions;
	}
}
