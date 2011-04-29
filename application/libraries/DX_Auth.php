<?php if (!defined('BASEPATH')) exit('No direct script access allowed');



/**

 * DX Auth Class

 *

 * Authentication library for Code Igniter.

 *

 * @author		Dexcell

 * @version		1.0.6

 * @based on	CL Auth by Jason Ashdown (http://http://www.jasonashdown.co.uk/)

 * @link			http://dexcell.shinsengumiteam.com/dx_auth

 * @license		MIT License Copyright (c) 2008 Erick Hartanto

 * @credits		http://dexcell.shinsengumiteam.com/dx_auth/general/credits.html

 */

 

class DX_Auth

{

	// Private

	var $_banned;

	var $_ban_reason;

	var $_auth_error;	// Contain user error when login

	var $_captcha_image;

	

	function DX_Auth()

	{

		$this->ci =& get_instance();



		log_message('debug', 'DX Auth Initialized');



		// Load required library

		$this->ci->load->library('Session');

		$this->ci->load->database();
		

		// Load DX Auth config

		$this->ci->load->config('dx_auth');

		

		// Load DX Auth language		

		$this->ci->lang->load('dx_auth');

		

		// Load DX Auth event

		$this->ci->load->library('DX_Auth_Event');

		

		// Initialize

		$this->_init();

	}



	/* Private function */



	function _init()

	{

		// When we load this library, auto Login any returning users

		$this->autologin();

		

		// Init helper config variable

		$this->email_activation = $this->ci->config->item('DX_email_activation');

		

		$this->allow_registration = $this->ci->config->item('DX_allow_registration');

		$this->captcha_registration = $this->ci->config->item('DX_captcha_registration');

		

		$this->captcha_login = $this->ci->config->item('DX_captcha_login');

		

		// URIs

		$this->banned_uri = $this->ci->config->item('DX_banned_uri');

		$this->deny_uri = $this->ci->config->item('DX_deny_uri');

		$this->login_uri = $this->ci->config->item('DX_login_uri');

		$this->logout_uri = $this->ci->config->item('DX_logout_uri');

		$this->register_uri = $this->ci->config->item('DX_register_uri');

		$this->activate_uri = $this->ci->config->item('DX_activate_uri');

		$this->forgot_password_uri = $this->ci->config->item('DX_forgot_password_uri');

		$this->reset_password_uri = $this->ci->config->item('DX_reset_password_uri');

		$this->change_password_uri = $this->ci->config->item('DX_change_password_uri');	

		$this->cancel_account_uri = $this->ci->config->item('DX_cancel_account_uri');	

		

		// Forms view

		$this->login_view = $this->ci->config->item('DX_login_view');

		$this->register_view = $this->ci->config->item('DX_register_view');

		$this->forgot_password_view = $this->ci->config->item('DX_forgot_password_view');

		$this->change_password_view = $this->ci->config->item('DX_change_password_view');

		$this->cancel_account_view = $this->ci->config->item('DX_cancel_account_view');

		

		// Pages view

		$this->deny_view = $this->ci->config->item('DX_deny_view');

		$this->banned_view = $this->ci->config->item('DX_banned_view');

		$this->logged_in_view = $this->ci->