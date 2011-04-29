<?php
	class Order extends Controller 
{

		// Used for registering and changing password form validation
		var $min_username = 3;
		var $max_username = 20;
		var $min_password = 5;
		var $max_password = 20;	
		
	function Order()	{
		parent::Controller();
				
	    $buildheadercontent = '';
		$buildheadercontent .= '<link href="' . base_url() . 'css/cssReset.css" rel="stylesheet" type="text/css" />';
		$buildheadercontent .= '<link href="' . base_url() . 'css/my_form.css" rel="stylesheet" type="text/css" />';
		$buildheadercontent .= '<link href="' . base_url() . 'css/default.css" rel="stylesheet" type="text/css" />';
//		$buildheadercontent .= '<script type="text/javascript" src="' . base_url() . 'js/calendar/calendar.js"></script> ';
//		$buildheadercontent .= '<script type="text/javascript" src="' . base_url() . 'js/calendar/lang/calendar-en.js"></script> ';
//		$buildheadercontent .= '<script type="text/javascript" src="' . base_url() . 'js/calendar/calendar-setup.js"></script> ';
//		$buildheadercontent .= '<script type="text/javascript" src="' . base_url() . 'js/prototype.js"></script> ';
//		$buildheadercontent .= '<script type="text/javascript" src="' . base_url() . 'js/effects.js"></script> ';
//		$buildheadercontent .= '<script type="text/javascript" src="' . base_url() . 'js/controls.js"></script> ';
		//$buildheadercontent .= '<script type="text/javascript" src="' . base_url() . 'js/jquery-1.3.2.js"></script> ';
                $buildheadercontent .= '<script type="text/javascript" src="' . base_url() . 'js/jquery.validate.min.js"></script> ';
//		$buildheadercontent .= '<script type="text/javascript" src="' . base_url() . 'js/prettyCheckboxes.js"  charset="utf-8"></script>';
//		$buildheadercontent .= '<!-- the scriptaculous javascript library is available at http://script.aculo.us/ -->';
		$buildheadercontent .= '<script type="text/javascript" src="' . base_url() . 'js/pos.js"></script> ';
		$buildheadercontent .= '<script type="text/javascript" src="' . base_url() . 'js/jquery.datevalidator.js"></script>';
		 //</script>;
		//$buildheadercontent .= '<link href="' . base_url() . 'css/prettyCheckboxes.css" rel="stylesheet" type="text/css">';
		//$buildheadercontent .= '<script type="text/javascript" src="' . base_url() . 'js/function_search.js"></script>';

		$loadmyjs['extraHeadContent'] =	$buildheadercontent;
		$this->load->vars($loadmyjs);		
		$this->load->library('Form_validation');
		$this->load->library('DX_Auth');
		$this->load->library('Pagination');
		$this->load->helper('form');
		$this->load->helper('url');
		//		$this->load->library('Table');
		
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
		
		if (ini_get('display_errors') == 1)
		{
//			echo 'Enabled';
		} else {
//			echo 'disabled';
		}
		$data['title'] = $this->lang->line('system_name') . ' - ' . $this->lang->line('page_order_home');	
		$data['main'] = 'order_home';
		$this->load->vars($data);
		$this->load->view('template');
		}
	}

	function edit_order()
	{
		if ( ! $this->dx_auth->is_logged_in())
		{				 
			$this->login();
		} else {
			$this->load->model('ajaxinventory');
			if ( $this->uri->segment(4) == 'shortcut' )
			{
				//jump to create order shortcut used so set the client_id session from the URI
				$this->session->set_userdata('current_client' , $this->uri->segment(3) );			
			}
			
			$this->load->model('msettings');
			$this->load->helper('list_builder');
			$this->load->helper('array');
			
			
			//Create list for dropdowns.  Pulls all data from the settings table. 
			$sphere_params = $this->msettings->sphere_params();
			$data['sphere_values'] = list_builder( $sphere_params );

			$cylinder_params = $this->msettings->cylinder_params();
			$data['cylinder_values'] = list_builder( $cylinder_params );
			
			$add_params = $this->msettings->add_params();
			$data['add_values'] = list_builder( $add_params );
			
			$prism_params = $this->msettings->prism_params();
			$data['prism_values'] = list_builder( $prism_params );
			
			$axis_params = $this->msettings->axis_params();
			$data['axis_values'] = list_builder( $axis_params );
			
			$bridge_params = $this->msettings->bridge_params();
			$data['bridge_values'] = list_builder( $bridge_params );
			
			$pd_params = $this->msettings->pd_params();
			$data['pd_values'] = list_builder( $pd_params );

			$segment_height_params = $this->msettings->segment_height_params();
			$data['segment_height_values'] = list_builder( $segment_height_params );
			
			$temple_length_params = $this->msettings->temple_length_params();
			$data['temple_length_values'] = list_builder( $temple_length_params );
			
			$lens_a_params = $this->msettings->lens_a_params();
			$data['lens_a_values'] = list_builder( $lens_a_params );
			
			$lens_b_params = $this->msettings->lens_b_params();
			$data['lens_b_values'] = list_builder( $lens_b_params );
		
			$lens_ed_params = $this->msettings->lens_ed_params();
			$data['lens_ed_values'] = list_builder( $lens_ed_params );
			
			$eye_size_params = $this->msettings->eye_size_params();
			$data['eye_size_params'] = list_builder( $eye_size_params );
			
			$lens_gradient_params = $this->msettings->lens_gradient_params();
			$data['lens_gradient_params'] = list_builder( $lens_gradient_params );

			//Get current client name and address for display on order form
			$this->load->model('mclients');
			$client_info =  $this->mclients->get_client_name_and_address( $this->session->userdata('current_client') );
			foreach($client_info as $client){
				$data['firstname'] = $client['firstname'];
				$data['lastname'] = $client['lastname'];
				$data['address'] = $client['address'];
				$data['address2'] = $client['address2'];
				$data['city'] = $client['city'];
				$data['state'] = $client['state'];
				$data['zip'] = $client['zip'];
				$data['phone'] = $client['phone'];
				$data['phone2'] = $client['phone2'];
				$data['phone3'] = $client['phone3'];
				$data['email'] = $client['email'];
                                $data['dob'] = date("m/d/y",strtotime($client['dob']));
				/*
				$data['current_client_info'] = $client['firstname'] . ' ' . $client['lastname'] . ', ' . $client['address'] . ' ' . $client['address2'] . ', ' . $client['city'] . '  ' . $client['state'] . ' ' . $client['zip'] ;
				*/
				
			}
			
			if (!isset($_POST['dispencer_id'])) {
				$dispencer_id = '';
//				echo 'ERROR - You must enter a dispencer ID<BR>';
			} else {
				$dispencer_id = $_POST['dispencer_id'];	
				//verify valid dispencer ID was entered
			}
				
			if (isset( $_POST['sphere_r'] ) ) {if ( $_POST['sphere_r'] ) {$data['sphere_r'] =  $_POST['sphere_r']; } else { $data['sphere_r'] = $sphere_params->default_value; } } else { $data['sphere_r'] = $sphere_params->default_value; }
			
			if (isset( $_POST['sphere_l'] ) ) { if ( $_POST['sphere_l'] ) { $data['sphere_l'] =  $_POST['sphere_l']; } else { $data['sphere_l'] = $sphere_params->default_value; } } else { $data['sphere_l'] = $sphere_params->default_value ; }
			
			if (isset( $_POST['cylinder_r'] ) ) { if ( $_POST['cylinder_r'] ) { $data['cylinder_r'] =  $_POST['cylinder_r']; } else { $data['cylinder_r'] = $cylinder_params->default_value ; } } else { $data['cylinder_r'] = $cylinder_params->default_value ; }
			
			if (isset( $_POST['cylinder_l'] ) ) { if ( $_POST['cylinder_l'] ) { $data['cylinder_l'] =  $_POST['cylinder_l']; } else { $data['cylinder_l'] = $cylinder_params->default_value; } } else { $data['cylinder_l'] = $cylinder_params->default_value ; }
			
			if (isset( $_POST['axis_r'] ) ) { if ( $_POST['axis_r'] ) { $data['axis_r'] =  $_POST['axis_r']; } else { $data['axis_r'] = $axis_params->default_value ; } } else { $data['axis_r'] = $axis_params->default_value  ; }
			
			if (isset( $_POST['axis_l'] ) ) { if ( $_POST['axis_l'] ) { $data['axis_l'] =  $_POST['axis_l']; } else { $data['axis_l'] = $axis_params->default_value  ; } } else { $data['axis_l'] = $axis_params->default_value  ; }
			
			if (isset( $_POST['add_r'] ) ) { if ( $_POST['add_r'] ) { $data['add_r'] =  $_POST['add_r']; } else { $data['add_r'] = $add_params->default_value ; } } else { $data['add_r'] = $add_params->default_value ; }
			
			if (isset( $_POST['add_l'] ) ) { if ( $_POST['add_l'] ) { $data['add_l'] =  $_POST['add_l']; } else { $data['add_l'] = $add_params->default_value ; } } else { $data['add_l'] = $add_params->default_value  ;}
			
			if (isset( $_POST['prism1_r'] ) ) { if ( $_POST['prism1_r'] ) { $data['prism1_r'] =  $_POST['prism1_r']; } else { $data['prism1_r'] = $prism_params->default_value  ; } } else { $data['prism1_r'] = $prism_params->default_value ; }
			
			if (isset( $_POST['prism1_l'] ) ) { if ( $_POST['prism1_l'] ) { $data['prism1_l'] =  $_POST['prism1_l']; } else { $data['prism1_l'] = $prism_params->default_value ; } } else { $data['prism1_l'] = $prism_params->default_value ; }
			
			if (isset( $_POST['base1_r'] ) ) { if ( $_POST['base1_r'] ) { $data['base1_r'] =  $_POST['base1_r']; } else { $data['base1_r'] = 1 ; } } else { $data['base1_r'] = 1 ; }
			
			if (isset( $_POST['base1_l'] ) ) { if ( $_POST['base1_l'] ) { $data['base1_l'] =  $_POST['base1_l']; } else { $data['base1_l'] = 1 ; } } else { $data['base1_l'] = 1 ; }
			
			if (isset( $_POST['prism2_r'] ) ) { if ( $_POST['prism2_r'] ) { $data['prism2_r'] =  $_POST['prism2_r']; } else { $data['prism2_r'] = $prism_params->default_value ; } } else { $data['prism2_r'] = $prism_params->default_value ; }
			
			if (isset( $_POST['prism2_l'] ) ) { if ( $_POST['prism2_l'] ) { $data['prism2_l'] =  $_POST['prism2_l']; } else { $data['prism2_l'] = $prism_params->default_value ; } } else { $data['prism2_l'] = $prism_params->default_value  ;}
			
			if (isset( $_POST['base2_r'] ) ) { if ( $_POST['base2_r'] ) { $data['base2_r'] =  $_POST['base2_r']; } else { $data['base2_r'] = 1; } } else { $data['base2_r'] = 1 ; }
			
			if (isset( $_POST['base2_l'] ) ) { if ( $_POST['base2_l'] ) { $data['base2_l'] =  $_POST['base2_l']; } else { $data['base2_l'] = 1; } } else { $data['base2_l'] = 1 ; }
			
			if (isset( $_POST['pd_near_r'] ) ) { if ( $_POST['pd_near_r'] ) { $data['pd_near_r'] =  $_POST['pd_near_r']; } else { $data['pd_near_r'] = $pd_params->default_value ; } } else { $data['pd_near_r'] = $pd_params->default_value ; }
		
			if (isset( $_POST['pd_near_l'] ) ) { if ( $_POST['pd_near_l'] ) { $data['pd_near_l'] =  $_POST['pd_near_l']; } else { $data['pd_near_l'] = $pd_params->default_value ; } } else { $data['pd_near_l'] = $pd_params->default_value ; }
			
			if (isset( $_POST['pd_far_r'] ) ) { if ( $_POST['pd_far_r'] ) { $data['pd_far_r'] =  $_POST['pd_far_r']; } else { $data['pd_far_r'] = $pd_params->default_value ; } } else { $data['pd_far_r'] = $pd_params->default_value ; }
			
			if (isset( $_POST['pd_far_l'] ) ) { if ( $_POST['pd_far_l'] ) { $data['pd_far_l'] =  $_POST['pd_far_l']; } else { $data['pd_far_l'] = $pd_params->default_value ; } } else { $data['pd_far_l'] = $pd_params->default_value ; }
			
			if (isset( $_POST['segment_height_r'] ) ) { if ( $_POST['segment_height_r'] ) { $data['segment_height_r'] =  $_POST['segment_height_r']; } else { $data['segment_height_r'] = $segment_height_params->default_value ; } } else { $data['segment_height_r'] = $segment_height_params->default_value ; }
			
			if (isset( $_POST['segment_height_l'] ) ) { if ( $_POST['segment_height_l'] ) { $data['segment_height_l'] =  $_POST['segment_height_l']; } else { $data['segment_height_l'] = $segment_height_params->default_value ; } } else { $data['segment_height_l'] = $segment_height_params->default_value ; }
			
			if (isset( $_POST['order_type'] ) ) { if ( $_POST['order_type'] ) { $data['order_type'] =  $_POST['order_type']; } else { $data['order_type'] = 'New' ; } } else { $data['order_type'] = 'New' ; }
			
			if (isset( $_POST['remake_reason'] ) ) { if ( $_POST['remake_reason'] ) { $data['remake_reason'] =  $_POST['remake_reason']; } else { $data['remake_reason'] = ''; } } else { $data['remake_reason'] = '' ; }
//******
			if (isset( $_POST['lens_type'] ) ) { if ( $_POST['lens_type'] ) { $data['lens_type'] =  $_POST['lens_type']; } else { $data['lens_type'] = ''; } } else { $data['lens_type'] = '' ; }
			
			if (isset( $_POST['lens_design'] ) ) { if ( $_POST['lens_design'] ) { $data['lens_design'] =  $_POST['lens_design']; } else { $data['lens_design'] = ''; } } else { $data['lens_design'] = '' ; }

			if (isset( $_POST['lens_material'] ) ) { if ( $_POST['lens_material'] ) { $data['lens_material'] =  $_POST['lens_material']; } else { $data['lens_material'] = ''; } } else { $data['lens_material'] = '' ; }
			
			if (isset( $_POST['lens_treatment'] ) ) { if ( $_POST['lens_treatment'] ) { $data['lens_treatment'] =  $_POST['lens_treatment']; } else { $data['lens_treatment'] = 1 ; } } else { $data['lens_treatment'] = 1 ; }
			
			if (isset( $_POST['lens_coating'] ) ) { if ( $_POST['lens_coating'] ) { $data['lens_coating'] =  $_POST['lens_coating']; } else { $data['lens_coating'] = ''; } } else { $data['lens_coating'] = '' ; }
			
			if (isset( $_POST['lens_color'] ) ) { if ( $_POST['lens_color'] ) { $data['lens_color'] =  $_POST['lens_color']; } else { $data['lens_color'] = ''; } } else { $data['lens_color'] = '' ; }

			if (isset( $_POST['diag_code'] ) ) { if ( $_POST['diag_code'] ) { $data['diag_code'] =  $_POST['diag_code']; } else { $data['diag_code'] = ''; } } else { $data['diag_code'] = '' ; }
			
			if (isset( $_POST['date_filed'] ) ) { if ( $_POST['date_filed'] ) { $data['date_filed'] =  $_POST['date_filed']; } else { $data['date_filed'] = ''; } } else { $data['date_filed'] = '' ; }
			
			if (isset( $_POST['authorization'] ) ) { if ( $_POST['authorization'] ) { $data['authorization'] =  $_POST['authorization']; } else { $data['authorization'] = ''; } } else { $data['authorization'] = '' ; }
		
			if (isset( $_POST['lens_size_a'] ) ) { if ( $_POST['lens_size_a'] ) { $data['lens_size_a'] =  $_POST['lens_size_a']; } else { $data['lens_size_a'] = $lens_a_params->default_value ; } } else { $data['lens_size_a'] = $lens_a_params->default_value ; }
			
			if (isset( $_POST['lens_size_b'] ) ) { if ( $_POST['lens_size_b'] ) { $data['lens_size_b'] =  $_POST['lens_size_b']; } else { $data['lens_size_b'] = $lens_b_params->default_value ; } } else { $data['lens_size_b'] = $lens_b_params->default_value ; }
			
			if (isset( $_POST['lens_size_ed'] ) ) { if ( $_POST['lens_size_ed'] ) { $data['lens_size_ed'] =  $_POST['lens_size_ed']; } else { $data['lens_size_ed'] = $lens_ed_params->default_value ; } } else { $data['lens_size_ed'] = $lens_ed_params->default_value ; }					

			if (isset( $_POST['frame_manufacturer'] ) ) { if ( $_POST['frame_manufacturer'] ) { $data['frame_manufacturer'] =  $_POST['frame_manufacturer']; } else { $data['frame_manufacturer'] = ''; } } else { $data['frame_manufacturer'] = '' ; }

			if (isset( $_POST['frame_division'] ) ) { if ( $_POST['frame_division'] ) { $data['frame_division'] =  $_POST['frame_division']; } else { $data['frame_division'] = ''; } } else { $data['frame_division'] = '' ; }
		
			if (isset( $_POST['frame_name'] ) ) { if ( $_POST['frame_name'] ) { $data['frame_name'] =  $_POST['frame_name']; } else { $data['frame_name'] = ''; } } else { $data['frame_name'] = '' ; }

			if (isset( $_POST['frame_color'] ) ) { if ( $_POST['frame_color'] ) { $data['frame_color'] =  $_POST['frame_color']; } else { $data['frame_color'] = ''; } } else { $data['frame_color'] = '' ; }

			if (isset( $_POST['bridge_size'] ) ) { if ( $_POST['bridge_size'] ) { $data['bridge_size'] =  $_POST['bridge_size']; } else { $data['bridge_size'] = ''; } } else { $data['bridge_size'] = '' ; }

			if (isset( $_POST['temple_length'] ) ) { if ( $_POST['temple_length'] ) { $data['temple_length'] =  $_POST['temple_length']; } else { $data['temple_length'] = ''; } } else { $data['temple_length'] = '' ; }
			
			if (isset( $_POST['eye_size'] ) ) { if ( $_POST['eye_size'] ) { $data['eye_size'] =  $_POST['eye_size']; } else { $data['eye_size'] = ''; } } else { $data['eye_size'] = '' ; }
			
			if (isset( $_POST['lens_gradient'] ) ) { if ( $_POST['lens_gradient'] ) { $data['lens_gradient'] =  $_POST['lens_gradient']; } else { $data['lens_gradient'] = ''; } } else { $data['lens_gradient'] = '' ; }
			
			if (isset( $_POST['special_instructions'] ) ) { if ( $_POST['special_instructions'] ) { $data['special_instructions'] =  $_POST['special_instructions']; } else { $data['special_instructions'] = ''; } } else { $data['special_instructions'] = '' ; }	
			
//			echo 'XXXX' . $data['lens_gradient'];

//echo $add_missing;					
//echo $axis_missing;

			$attributes = array('class' => 'order_form', 'id' => 'order_form');
			$data['form_open'] = form_open('order/edit_order', $attributes );
						
			$insurance_info = $this->mclients->get_insurance_info();

			foreach ($insurance_info as $insurance){
				
				if ( isset( $_POST['carriers'] ) ) {
					$carrier = $_POST['carriers'] ;
				} else {
					$carrier = $insurance['insurance_id'] ;
				}
			
				$form_data = array(
				              'name'        => 'insurance_id',
				              'id'          => 'insurance_id',
				              'value'       => $carrier,
				              'maxlength'   => '50',
				              'size'        => '30',
				            );
				$data['insurance_id_field']	= form_input($form_data) ;
				
				//If Insurance company selected then DOB is required.  If DOB is default value of 1900-01-01 then NULL it out on the form.
				if ( $insurance['dob'] == '1900-01-01' ) {
					$dob = NULL;
				} else {
					$dob = $insurance['dob'] ;
					
				}	
					
				$form_data = array(
				              'name'        => 'dob',
				              'id'          => 'dob',
				              'value'       => $dob,
				              'maxlength'   => '100',
				              'size'        => '10',
				            );
				$data['dob_field']	= form_input($form_data) ;
				
				$data['carrier'] = $insurance['insurance'] ;
				
				$doctor_id = $insurance['doctor_id'];
				
			$this->load->model('mdoctors');
			$content_doctors = $this->mdoctors->get_dropdown_array('doctor_id', 'lastname');
			
			$form_data = 'class="select_doctor" id="doctor_id" '; //onchange=checkForOtherDoctor();';
			$data['select_doctor'] = form_dropdown('doctor_id', $content_doctors, $doctor_id, $form_data ) ;
				
			}
			
			$form_data = array(
			              'name'        => 'dispencer_id',
			              'id'          => 'dispencer_id',
			              'value'       => $dispencer_id,
			              'maxlength'   => '5',
			              'size'        => '5',
			            );
			$data['dispencer_id_field']	= form_input($form_data) ;
		
			$form_data = array(
			              'name'        => 'date_filed',
			              'id'          => 'date_filed',
			              'value'       => $data['date_filed'],
			              'maxlength'   => '10',
			              'size'        => '10',
			            );
			$data['date_filed_field']	= form_input($form_data) ;
			
			$form_data = array(
			              'name'        => 'authorization',
			              'id'          => 'authorization',
			              'value'       => $data['authorization'],
			              'maxlength'   => '25',
			              'size'        => '15',
			            );
			$data['authorization_field']	= form_input($form_data) ;
//  @@@@@
			$form_data = array(
			              'name'        => 'lens_size_a',
			              'id'          => 'lens_size_a',
			              'value'       => $data['lens_size_a'],
			              'maxlength'   => '5',
			              'size'        => '5',
			            );
			$data['lens_size_a_field']	= form_input($form_data) ;
			
			$form_data = array(
			              'name'        => 'lens_size_b',
			              'id'          => 'lens_size_b',
			              'value'       => $data['lens_size_b'],
			              'maxlength'   => '5',
			              'size'        => '5',
			            );
			$data['lens_size_b_field']	= form_input($form_data) ;
			
			$form_data = array(
			              'name'        => 'lens_size_ed',
			              'id'          => 'lens_size_ed',
			              'value'       => $data['lens_size_ed'],
			              'maxlength'   => '5',
			              'size'        => '5',
			            );
			$data['lens_size_ed_field']	= form_input($form_data) ;					
			
			$form_data = array(
			              'name'        => 'special_instructions',
			              'id'          => 'special_instructions',
			              'value'       => $data['special_instructions'],
			              'rows'   => '4',
			              'cols'        => '65',
			            );

			$this->load->model('mlists');
			$data['list_carriers'] = $this->mlists->get_list_carriers();
			$data['list_diag_codes'] = $this->mlists->get_list_diag_codes();
			$data['list_order_type'] = $this->mlists->get_list_order_type();
			$data['list_frame_manufacturers'] = $this->get_frame_manufacturers();
			$data['frame_divisions'] = $this->mlists->get_frame_divisions();
			$data['frame_names'] = $this->mlists->get_frame_names();
			$data['frame_colors'] = $this->mlists->get_frame_colors();					
			$data['list_lens_shapes'] = $this->mlists->get_list_lens_shapes();
			$data['list_lens_sizes'] = $this->mlists->get_list_lens_sizes();		
			$data['list_lens_types'] = $this->mlists->get_list_lens_types();
			$data['list_lens_designs'] = $this->mlists->get_list_lens_designs();
			$data['list_lens_materials'] = $this->mlists->get_list_lens_materials();
			$data['list_lens_treatments'] = $this->mlists->get_list_lens_treatments();
			$data['list_lens_coatings'] = $this->mlists->get_list_lens_coatings();
			$data['list_lens_colors'] = $this->mlists->get_list_lens_colors();				
			$data['list_bridge_sizes'] = $this->mlists->get_list_bridge_sizes();
			$data['list_remake_reasons'] = $this->mlists->get_list_remake_reasons();
			$data['list_temple_lengths'] = $this->mlists->get_list_temple_lengths();
			$data['list_lens_pd'] = $this->mlists->get_list_lens_pd();
			$data['list_lens_bases'] = $this->mlists->get_list_lens_bases();
			
			$data['list_all_store'] = $this->ajaxinventory->all_store();

			//output the page
			$data['special_instructions_field']	= form_textarea($form_data) ;
			$data['title'] = $this->lang->line('system_name') . ' - ' . $this->lang->line('page_order_create_order');	
			$data['main'] = 'order/order_form';
			$this->load->vars($data);
			$this->load->view('template');
		
					
			if ( isset($_POST['submit'] ) )
			{
				//initialize $iscomplete
				$iscomplete = FALSE;
				
				if ( $_POST['doctor_id'] == 'OTHER' ) {
					//OTHER selected to require that otherDoctor has a valid value to add to the database
					if ( $_POST['otherDoctor'] ) {
						//value has been entered so it's ok				
						echo $_POST['otherDoctor'] . ' OTHER DOCTOR<BR>';
					} else {
						//no value entered even though OTHER was selected so show an error
						echo 'ERROR- you must use other doctor if selecting OTHER<BR>';
					}
				} else {
//					echo 'doctor selected: ' . $_POST['doctor_id']. 'XX';
				}
				
				//If an insurance carrier was selected on the form the DO NOT reload if from the client record.
				//Also set the insurance_required flag to TRUE/FALSE, used to check all other required insurance fields if TRUE
				if ( isset( $_POST['carrier'] ) ) {
					if ( $_POST['carrier'] == 'NONE' ) {
						$insurance_required = FALSE;
					} else {
						$insurance_required = TRUE;
					}
				} else {
					$insurance_required = FALSE;
				}
				
				//if it's deterined insurance values are required then go through the checks
				if ( $insurance_required ) {
					$dob_exists = isset( $_POST['dob']  );
					$insurance_id_exists = isset( $_POST['insurance_id'] );
	//NOT FINISHED  *******************************************************************************************************
				} 
				
				//check if axis and cylinder are required
				if ( $_POST['cylinder_r'] != 0 || $_POST['cylinder_l'] <> 0 ) 
				{
				//cylinder is set so Axis is also required.
					If ( $_POST['axis_l'] == 0 || $_POST['axis_r'] == 0 ) $axis_missing = TRUE;
				} else {
					$axis_missing = FALSE;
				} 
				
				//Add_l and Add_r are required if lens_type <> 'single vision'
				$add_missing = FALSE;
				if ( $_POST['lens_type'] <> 'Single Vision' ) {
					if ( $_POST['add_l'] == 0 || $_POST['add_r'] == 0 ) {
						$add_missing = TRUE ;
					} 
					//Only show segment height if NOT single vision
					//$data['show_segment_height'] = TRUE;
				} else {
					//$data['show_segment_height'] = FALSE;
				}	
				
				$iscomplete = TRUE;
				
				if ( $iscomplete ) {
				
					/** Update Client Data */
					$this->load->helper('array');
					$this->load->model('mclients');
					$client_data = array(
						'firstname' => element('first_name', $_POST, NULL),
						'lastname' => element('last_name', $_POST, NULL),
						'address' => element('address_1_field', $_POST, NULL),
						'address2' => element('address_2_field', $_POST, NULL),
						'phone' => element('phone_1_field', $_POST, NULL),
						'phone2' => element('phone_2_field', $_POST, NULL),
						'phone3' => element('phone_3_field', $_POST, NULL),
						'city' => element('city', $_POST, NULL),
						'zip' => element('zip_code', $_POST, NULL),
						'email' => element('patient_email_field', $_POST, NULL),
					);
					$this->mclients->updateClientById($this->session->userdata('current_client'), $client_data);
					/** End Update Client Data */
					
					$this->load->model('morders');
					$uninvoiced_order = $this->morders->check_for_uninvoiced_order( $this->session->userdata('current_client') );
				
					$order_id = $this->morders->write_order();

                                        # INSERT TREATMENTS

                                        $lt_segments = explode(",", $this->input->post("real_treatments_selected"));
                                        foreach ($lt_segments as $tid)
                                        {
                                            if ($tid == "")
                                                    continue;
                                            $t_data = array("order_id" => $order_id, "treatment_id" => $tid);
                                            $this->db->insert("orders_treatments", $t_data);
                                        }

                                        # INSERT INVOICE

                                        $data_invoice = array("order_id" => $order_id,
                                                              "client_id" => $this->session->userdata('current_client'),
                                                              "frame_price" => $this->input->post("frame_price"),
                                                              "lens_price" => $this->input->post("lens_price"),
                                                              "treatment_price" => $this->morders->lens_treatment_price($this->input->post("lens_treatment")),
                                                              "coating_price" => $this->morders->coating_price($this->input->post("lens_coating")),
                                                              "discount" => $this->input->post("drop_discount"),
                                                              "labfee" => 0,
                                                              "subtotal" => $this->input->post("subtotal_price"),
                                                              "tax" => $this->input->post("tax"),
                                                              "total" => $this->input->post("drop_total"),
                                                              "deposit" => $this->input->post("drop_deposit")

                                                            );
                                        
                                        $this->db->insert("invoices", $data_invoice);
					redirect( "order/view_order/$order_id");
				}
			} 	
		}
	}
		
	function view_order()
	{
		if ( ! $this->dx_auth->is_logged_in())
		{				 
			$this->login();
		} else {
			$data['title'] = $this->lang->line('system_name') . ' - ' . $this->lang->line('page_order_view_order');	
			$data['main'] = 'order/view';

			$this->load->model('morders');
			$data['orderdata'] = $this->morders->get_order( $this->uri->segment(3) );

			$this->load->vars($data);
			$this->load->view('template');
		}
	}
function dispancerUsernameById()
{
	$this->load->model('musers');
	$dispencer_id	=	(int)$this->input->post('dispencer_id');
   	echo $this->musers->getUserNameByDispencerId($dispencer_id);
   
}
function getFrameDivisionByManufacturerId()
{
	$this->load->model('mlists');
	$manufacturer_id	=	(int)$this->input->post('manufacturer_id');
   	$frame_divisions	= $this->mlists->get_frame_divisions_by_manufacturer_id($manufacturer_id);
   echo json_encode($frame_divisions);
   // echo form_dropdown('frame_division', $frame_divisions);
   
}
function getFrameNameByDivisionId()
{
	$this->load->model('mlists');
	$division_id	=	(int)$this->input->post('division_id');
   	$frame_name	= $this->mlists->get_frame_names_by_division_id($division_id);
    echo json_encode($frame_name);
    
   
}
function getFrameColorByName()
{
	$this->load->model('mlists');
	$frame_id	=	(int)$this->input->post('frame_id');
   	$frame_colors	=	$this->mlists->get_frame_colors_frame_id($frame_id);
    echo json_encode($frame_colors);
    
   
}

function getLensDesignByTypeId()
{
	$this->load->model('mlists');
	$lens_type_id	=	(int)$this->input->post('lens_type_id');
   	$lens_design	=	$this->mlists->get_list_lens_designs_by_type_id($lens_type_id);
    echo json_encode($lens_design);
    
   
}

function getLensMaterialByDesignId()
{
	$this->load->model('mlists');
	$lens_type_id	=	(int)$this->input->post('lens_type_id');
   	$lens_design	=	$this->mlists->getLensMaterialByDesignId($lens_type_id);
    echo json_encode($lens_design);
    
   
}

	function get_frame_manufacturers()	
	{	    
		$result = array();	    
		$query = $this->db->query('SELECT manufacturer, id FROM frame_manufacturers WHERE active = TRUE ORDER BY manufacturer asc');		
		if ($query->num_rows() > 0) 
		{				
			$result =  $query->result_array();			
			$result = array_merge(array("0"=>array("id"=>"","manufacturer"=>"- - - ")),$result);
			foreach($result as $item)
			{
				$key = $item['id'];
				$option1[$key] = $item['manufacturer'];
			}				
			return $option1;		
		}   			
	}	

	function login()
	{
		redirect('auth/login');
	}


        
}
?>
