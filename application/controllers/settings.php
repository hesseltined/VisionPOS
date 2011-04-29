<?php
	class Settings extends Controller 
{

		// Used for registering and changing password form validation
		var $min_username = 3;
		var $max_username = 20;
		var $min_password = 5;
		var $max_password = 20;	
		
	function Settings()	{
		parent::Controller();
				
	    $buildheadercontent = '';
		
		$buildheadercontent .= '<link href="' . base_url() . 'css/default.css" rel="stylesheet" type="text/css">';
	    //$buildheadercontent .= '<link href="' . base_url() . 'css/prettyCheckboxes.css" rel="stylesheet" type="text/css">';
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
//		$this->load->library('Table');
		$this->load->library('Pagination');
		
		$this->load->helper('form');
		$this->load->helper('url');
		
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

	function index()
	{

		if ( ! $this->dx_auth->is_logged_in())
		{				 
			$this->login();
		} else {
			$data['title'] = $this->lang->line('system_name') . ' - ' . $this->lang->line('page_settings_home');	
			$data['main'] = 'settings/home';
			$this->load->vars($data);
			$this->load->view('template');
		}

	}
	
	function edit_doctors()
	{
		if ( ! $this->dx_auth->is_logged_in())
		{				 
			redirect('/main/login/', 'refresh');
		} else {
			$this->load->helper('form');
			$attributes = array('class' => 'add_frame', 'id' => 'frame');
			$open_string = '<div width="100" class="add_doctor"><div>';
			$close_string = "</div></div></p>";
			$add_doctor_form = '<p>' 
				. $open_string
				. form_fieldset('Add Doctor')
				. form_open('settings/add_doctor', 'input')
				. 'Doctor First, Last name: '
				. form_input('firstname') 
				. form_input('lastname')
				. form_submit('submit','submit') 
				. form_close() 
				. $close_string;
			
			$this->load->model('mdoctors');
			$doctors = $this->mdoctors->get_list_doctors( $this->uri->segment(3), $this->uri->segment(4) );
	
			$resultrows = array();
			$data['doctor_table'] = 'No Results';
//			echo print_r($doctors);
			if (isset( $doctors ) )	
			{
				$numresults = 0;
				foreach ($doctors as $doctor)	{
					if ( $doctor['firstname'] <> ''){
						$firstname = ', ' . $doctor['firstname'] ;
					} else {
	