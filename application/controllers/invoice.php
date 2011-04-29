<?php
	class Invoice extends Controller 
{

		// Used for registering and changing password form validation
		var $min_username = 3;
		var $max_username = 20;
		var $min_password = 5;
		var $max_password = 20;	
		
	function Invoice()	{
		parent::Controller();
				
	    $buildheadercontent = '';
		
		$buildheadercontent .= '<link href="' . base_url() . 'css/default.css" rel="stylesheet" type="text/css">';
	    //$buildheadercontent .= '<link href="' . base_url() . 'css/prettyCheckboxes.css" rel="stylesheet" type="text/css">';
		$buildheadercontent .= '<script type="text/javascript" src="' . base_url() . 'js/calendar/calendar.js"></script> ';
		$buildheadercontent .= '<script type="text/javascript" src="' . base_url() . 'js/calendar/lang/calendar-en.js"></script> ';
		$buildheadercontent .= '<script type="text/javascript" src="' . base_url() . 'js/calendar/calendar-setup.js"></script> ';
//		$buildheadercontent .= '<script type="text/javascript" src="' . base_url() . 'js/function_search.js"></script>';
		//$buildheadercontent .= '<script type="text/javascript" src="' . base_url() . 'js/prototype.js"></script> ';
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
			$data['title'] = $this->lang->line('system_name') . ' - ' . $this->lang->line('page_invoice_home');	
			$data['main'] = 'invoice/home';
			$this->load->vars($data);
			$this->load->view('template');
		}

	}
	
	function create()
	{
		if ( ! $this->dx_auth->is_logged_in())
		{				 
			$this->login();
		} else {
		
			if ( isset( $_POST['submit'] )) 
			{

			//	$this->load->model('minvoices');
				
				$invoice_already_created = $this->minvoices-> invoice_already_created();
			
				if (!$invoice_already_created) {
					$invoice_id = $this->minvoices->create_invoice( $_POST['frame_price'], $_POST['lens_price'], $_POST['treatment_price'], $_POST['coating_price'], $_POST['subtotal'], $_POST['discount'], $_POST['tax'], $_POST['total'], $_POST['deposit'] );
					
					//computer balance due to enter in ledger based on order total minus deposit
					$balance_due = $_POST['total'] - $_POST['deposit'];

					$this->load->model('mledger');
					$entry_type = 0;	//type = new invoice
					$ledger_id = $this->mledger->write_to_ledger( $balance_due, $entry_type );
				
								
					if ($invoice_id > 0){
						$this->session->set_flashdata('flashmessage', 'Invoice created successfully');
						$this->session->unset_userdata( 'order_id' );
					} else {
						$this->