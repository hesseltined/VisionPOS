<?php
class Auth extends Controller
{
	// Used for registering and changing password form validation
	var $min_username = 3;
	var $max_username = 20;
	var $min_password = 4;
	var $max_password = 20;

	function Auth()
	{
		parent::Controller();
				
	    $buildheadercontent = '';
		
		$buildheadercontent .= '<link href="' . base_url() . 'css/default.css" rel="stylesheet" type="text/css">';
	    $buildheadercontent .= '<link href="' . base_url() . 'css/prettyCheckboxes.css" rel="stylesheet" type="text/css">';
		$buildheadercontent .= '<script type="text/javascript" src="' . base_url() . 'js/calendar/calendar.js"></script> ';
		$buildheadercontent .= '<script type="text/javascript" src="' . base_url() . 'js/calendar/lang/calendar-en.js"></script> ';
		$buildheadercontent .= '<script type="text/javascript" src="' . base_url() . 'js/calendar/calendar-setup.js"></script> ';
//		$buildheadercontent .= '<script type="text/javascript" src="' . base_url() . 'js/function_search.js"></script>';
		$buildheadercontent .= '<script type="text/javascript" src="' . base_url() . 'js/prototype.js"></script> ';
		$buildheadercontent .= '<script type="text/javascript" src="' . base_url() . 'js/effects.js"></script> ';
		$buildheadercontent .= '<script type="text/javascript" src="' . base_url() . 'js/controls.js"></script> ';
		$buildheadercontent .= '<script type="text/javascript" src="' . base_url() . 'js/jquery-1.3.2.js"></script> ';
		$buildheadercontent .= '<script type="text/javascript" src="' . base_url() . 'js/prettyCheckboxes.js"  charset="utf-8"></script>';
		$buildheadercontent .= '<!-- the scriptaculous javascript library is available at http://script.aculo.us/ -->'; //</script>;

		$loadmyjs['extraHeadContent'] =	$buildheadercontent;
		$this->load->vars($loadmyjs);		
		$this->load->library('Form_validation');
		$this->load->library('DX_Auth');
		
		//If not yet set then l set the session for StoreName to display in the NAVBAR.  
		//  Useres DX_Auth User_id to lookup the store id then look up the store name.
		if ($this->dx_auth->is_logged_in()){
			if (!$this->session->userdata('storename')) {
				$this->load->model('mstores');
				$this->load->model('musers');
				$this->session->set_userdata('store_id' , $this->musers->GetStoreID($this->dx_auth->get_user_id()));
				$this->session->set_userdata('storename', $this->mstores->getStoreName($this->session->userdata('store_id')));
				$this->session->set_userdata('storenumber', $this->mstores->getStoreNumber($this->session->userdata('store_id')));
				
			}
		}
        	
	} 
       
     function index_doug()  
     {  
         $this->login();  
     }  
       
     /* Callback function */  
       
     function username_check($username)  
     {  
         $result = $this->dx_auth->is_username_available($username);  
         if ( ! $result)  
         {  
             $this->form_validation->set_message('username_check', 'Username already exist. Please choose another username.');  
         }  
                   
         return $result;  
     }  
   
     function email_check($email)  
     {  
         $result = $this->dx_auth->is_email_available($email);  
         if ( ! $result)  
         {  
             $this->form_validation->set_message('email_check', 'Email is already used by another user. Please choose another email address.');  
         }  
                   
         return $result;  
     }  
   
     function captcha_check($code)  
     {  
         $result = TRUE;  
           
         if ($this->dx_auth->is_captcha_expired())  
         {  
             // Will replace this error msg with $lang  
             $this->form_validation->set_message('captcha_check', 'Your confirmation code has expired. Please try again.');              
             $result = FALSE;  
         }  
         elseif ( ! $this->dx_auth->is_captcha_match($code))  
         {  
             $this->form_validation->set_message('captcha_check', 'Your confirmation code does not match the one in the image. Try again.');             
             $result = FALSE;  
         }  
   
         return $result;  
     }  
           
     /* End of Callback function */  
       
     function login()  
     {  
         if ( ! $this->dx_auth->is_logged_in())  
         {  
             $val = $this->form_validation;  
               
             // Set form validation rules  
             $val->set_rules('username', 'Username', 'trim|required|xss_clean');  
             $val->set_rules('password', 'Password', 'trim|required|xss_clean');  
             $val->set_rules('remember', 'Remember me', 'integer');  
   
             // Set captcha rules if login attempts exceed max attempts in config  
             if ($this->dx_auth->is_max_login_attempts_exceeded())  
             {  
                 $val->set_rules('captcha', 'Confirmation Code', 'trim|required|xss_clean|callback_captcha_check');  
             }  
                   
             if ($val->run() AND $this->dx_auth->login($val->set_value('username'), $val->set_value('password'), $val->set_value('remember')))  
             {  
                 // Redirect to homepage  
                 redirect('', 'location');  
             }  
             else  
             {  
                 // Check if the user is failed logged in because user is banned user or not  
                 if ($this->dx_auth->is_banned())  
	{
					// Redirect to banned uri
					$this->dx_auth->deny_access('banned');
				}
				else
				{						
					// Default is we don't show captcha until max login attempts eceeded
					$data['show_captcha'] = FALSE;
				
					// Show captcha if login attempts exceed max attempts in config
					if ($this->dx_auth->is_max_login_attempts_exceeded())
					{
						// Create catpcha						
						$this->dx_auth->captcha();
						
						// Set view data to show captcha on view file
						$data['show_captcha'] = TRUE;
					}
					
					// Load login page view
					$data['main'] = $this->dx_auth->login_view;
					$this->load->vars($data);
					$this->load->view('template');
					//$this->load->view($this->dx_auth->login_view, $data);
				}
			}
		}
		else
		{
			$this->session->set_flashdata('flashmessage','You are already logged in.');
			redirect('main/search','location');
			//$this->load->view($this->dx_auth->logged_in_view, $data);
		}
	}
	
	function logout()
	{
		$this->dx_auth->logout();
	//	$this->session->set_flashdata('flashmessage','You have been logged out.');			
		redirect('','location');
	}
	
	function register()
	{		
		if ( $this->dx_auth->is_admin() AND $this->dx_auth->allow_registration)
		{	
			$val = $this->form_validation;
			
			// Set form validation rules			
			$val->set_rules('username', 'Username', 'trim|required|xss_clean|min_length['.$this->min_username.']|max_length['.$this->max_username.']|callback_username_check|alpha_dash');
			$val->set_rules('password', 'Password', 'trim|required|xss_clean|min_length['.$this->min_password.']|max_length['.$this->max_password.']|matches[confirm_password]');
			$val->set_rules('confirm_password', 'Confirm Password', 'trim|required|xss_clean');
			$val->set_rules('email', 'Email', 'trim|required|xss_clean|valid_email|callback_email_check');
			
			if ($this->dx_auth->captcha_registration)
			{
				$val->set_rules('captcha', 'Confirmation Code', 'trim|xss_clean|required|callback_captcha_check');
			}
			

			// Run form validation and register user if it's pass the validation
			if ($val->run() AND $this->dx_auth->register($val->set_value('username'), $val->set_value('password'), $val->set_value('email'), $_POST['store_id'] ))
			{	
			
				//Added 4-26-2010 - Doug
				$this->session->set_flashdata('flashmessage','User successfully created.' );
				
				/*
				// Set success message accordingly
				if ($this->dx_auth->email_activation)
				{
					$this->session->set_flashdata('flashmessage','You have successfully registered. You will be notified when a System Administrator has activated your account.' );
				}
				else
				{					
					$this->session->set_flashdata('flashmessage','You have successfully registered. '.anchor(site_url($this->dx_auth->login_uri), 'Login') );
				}
				*/
				
				// Load registration success page
				$data['main'] = $this->dx_auth->register_success_view;
				$this->load->vars($data);
				$this->load->view('template');
				//$this->load->view($this->dx_auth->register_success_view, $data);
			}
			else
			{
				// Is registration using captcha
				if ($this->dx_auth->captcha_registration)
				{
					$this->dx_auth->captcha();										
				}

				// Load registration page
				//load stores list for dropdown - added by Doug to provide drop down store list on registration page
				$this->load->model('mstores');
				$data['content_stores'] = $this->mstores->get_dropdown_array('store_id', 'name');
				$data['main'] = $this->dx_auth->register_view;
				$this->load->vars($data);
				$this->load->view('template');				
				//$this->load->view($this->dx_auth->register_view);
			}
		} else {
			echo '<p>INVALID URL</p>';
		}
			
		/* removed to enable registration as an admin - Doug 4/26/2010 
		elseif ( ! $this->dx_auth->allow_registration)
		{
			$this->session->set_flashdata('flashmessage','Registration has been disabled.');
			$data['main'] = $this->dx_auth->register_disabled_view;
			$this->load->vars($data);
			$this->load->view('template');
			//$this->load->view($this->dx_auth->register_disabled_view, $data);
		}
		else
		{
			$this->session->set_flashdata('flashmessage','You have to logout first, before registering.');
			$data['main'] = $this->dx_auth->logged_in_view;
			$this->load->vars($data);
			$this->load->view('template');
			//$this->load->view($this->dx_auth->logged_in_view, $data);
		}
		*/
	}
	

	function activate()
	{
		// Get username and key
		$username = $this->uri->segment(3);
		$key = $this->uri->segment(4);

		// Activate user
		if ($this->dx_auth->activate($username, $key)) 
		{
			$this->session->set_flashdata('flashmessage','Your account have been successfully activated. '.anchor(site_url($this->dx_auth->login_uri), 'Login') );
			$data['main'] = $this->dx_auth->activate_success_view;
			$this->load->vars($data);
			$this->load->view('template');
			//$this->load->view($this->dx_auth->activate_success_view, $data);
		}
		else
		{
			$this->session->set_flashdata('flashmessage','The activation code you entered was incorrect. Please allow up to one business day for activation.');
			$data['main'] = $this->dx_auth->activate_failed_view;
			$this->load->vars($data);
			$this->load->view('template');
			//$this->load->view($this->dx_auth->activate_failed_view, $data);
		}
	}
	
	function forgot_password()
	{
		$val = $this->form_validation;
		
		// Set form validation rules
		$val->set_rules('login', 'Username or Email address', 'trim|required|xss_clean');

		// Validate rules and call forgot password function
		if ($val->run() AND $this->dx_auth->forgot_password($val->set_value('login')))
		{
			$this->session->set_flashdata('flashmessage','An email has been sent to your email with instructions with how to activate your new password.');
			redirect('auth/login','location');
			//$this->load->view($this->dx_auth->forgot_password_success_view, $data);
		}
		else
		{
			$data['main'] = $this->dx_auth->forgot_password_view;
			$this->load->vars($data);
			$this->load->view('template');
			//$this->load->view($this->dx_auth->forgot_password_view);
		}
	}
	
	function reset_password()
	{
		// Get username and key
		$username = $this->uri->segment(3);
		$key = $this->uri->segment(4);

		// Reset password
		if ($this->dx_auth->reset_password($username, $key))
		{
			$this->session->set_flashdata('flashmessage','You have successfully reset you password, '.anchor(site_url($this->dx_auth->login_uri), 'Login') );
			$data['main'] = $this->dx_auth->reset_password_success_view;
			$this->load->vars($data);
			$this->load->view('template');
			//$this->load->view($this->dx_auth->reset_password_success_view, $data);
		}
		else
		{
			$this->session->set_flashdata('flashmessage','Reset failed. Your username and key are incorrect. Please check your email again and follow the instructions.');
			$data['main'] = $this->dx_auth->reset_password_failed_view;
			$this->load->vars($data);
			$this->load->view('template');
			//$this->load->view($this->dx_auth->reset_password_failed_view, $data);
		}
	}
	
	function change_password()
	{
		// Check if user logged in or not
		if ($this->dx_auth->is_logged_in())
		{			
			$val = $this->form_validation;
			
			// Set form validation
			$val->set_rules('old_password', 'Old Password', 'trim|required|xss_clean|min_length['.$this->min_password.']|max_length['.$this->max_password.']');
			$val->set_rules('new_password', 'New Password', 'trim|required|xss_clean|min_length['.$this->min_password.']|max_length['.$this->max_password.']|matches[confirm_new_password]');
			$val->set_rules('confirm_new_password', 'Confirm new Password', 'trim|required|xss_clean');
			
			// Validate rules and change password
			if ($val->run() AND $this->dx_auth->change_password($val->set_value('old_password'), $val->set_value('new_password')))
			{
				$this->session->set_flashdata('flashmessage','Your password has successfully been changed.');
				redirect('main/search','location');
				//$this->load->view($this->dx_auth->change_password_success_view, $data);
			}
			else
			{	
				$this->session->set_flashdata('flashmessage','Your new password did not match or meet the required rules. Please try again.');
				$data['main'] = $this->dx_auth->change_password_view;
				$this->load->vars($data);
				$this->load->view('template');
				//$this->load->view($this->dx_auth->change_password_view);
			}
		}
		else
		{
			// Redirect to login page
			$this->dx_auth->deny_access('login');
		}
	}	
	
	function cancel_account()
	{
		// Check if user logged in or not
		if ($this->dx_auth->is_logged_in())
		{			
			$val = $this->form_validation;
			
			// Set form validation rules
			$val->set_rules('password', 'Password', "trim|required|xss_clean");
			
			// Validate rules and change password
			if ($val->run() AND $this->dx_auth->cancel_account($val->set_value('password')))
			{
				// Redirect to homepage
				redirect('search', 'location');
			}
			else
			{
				$data['main'] = $this->dx_auth->cancel_account_view;
				$this->load->vars($data);
				$this->load->view('template');
				//$this->load->view($this->dx_auth->cancel_account_view);
			}
		}
		else
		{
			// Redirect to login page
			$this->dx_auth->deny_access('login');
		}
	}

	// Example how to get permissions you set permission in /backend/custom_permissions/
	function custom_permissions()
	{
		if ($this->dx_auth->is_logged_in())
		{
			echo 'My role: '.$this->dx_auth->get_role_name().'<br/>';
			echo 'My permission: <br/>';
			
			if ($this->dx_auth->get_permission_value('edit') != NULL AND $this->dx_auth->get_permission_value('edit'))
			{
				echo 'Edit is allowed';
			}
			else
			{
				echo 'Edit is not allowed';
			}
			
			echo '<br/>';
			
			if ($this->dx_auth->get_permission_value('delete') != NULL AND $this->dx_auth->get_permission_value('delete'))
			{
				echo 'Delete is allowed';
			}
			else
			{
				echo 'Delete is not allowed';
			}
		}
	}
}
?>