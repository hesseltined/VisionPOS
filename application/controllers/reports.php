<?php
class Reports extends Controller 
{

		// Used for registering and changing password form validation
		var $min_username = 3;
		var $max_username = 20;
		var $min_password = 5;
		var $max_password = 20;	
		
	function Reports()	{
		parent::Controller();
				
	    $buildheadercontent = '';
		
		$buildheadercontent .= '<link href="' . base_url() . 'css/cssReset.css" rel="stylesheet" type="text/css">';
		$buildheadercontent .= '<link href="' . base_url() . 'css/default.css" rel="stylesheet" type="text/css">';
                $buildheadercontent .= '<link href="' . base_url() . 'css/table.css" rel="stylesheet" type="text/css">';
	    //$buildheadercontent .= '<link href="' . base_url() . 'css/prettyCheckboxes.css" rel="stylesheet" type="text/css">';
		$buildheadercontent .= '<script type="text/javascript" src="' . base_url() . 'js/calendar/calendar.js"></script> ';
		$buildheadercontent .= '<script type="text/javascript" src="' . base_url() . 'js/calendar/lang/calendar-en.js"></script> ';
		$buildheadercontent .= '<script type="text/javascript" src="' . base_url() . 'js/calendar/calendar-setup.js"></script> ';
//		$buildheadercontent .= '<script type="text/javascript" src="' . base_url() . 'js/function_search.js"></script>';
		//$buildheadercontent .= '<script type="text/javascript" src="' . base_url() . 'js/prototype.js"></script> ';
		//$buildheadercontent .= '<script type="text/javascript" src="' . base_url() . 'js/effects.js"></script> ';
		//$buildheadercontent .= '<script type="text/javascript" src="' . base_url() . 'js/controls.js"></script> ';
		//$buildheadercontent .= '<script type="text/javascript" src="' . base_url() . 'js/jquery-1.3.2.js"></script> ';
		$buildheadercontent .= '<script type="text/javascript" src="' . base_url() . 'js/prettyCheckboxes.js"  charset="utf-8"></script>';
		$buildheadercontent .= '<!-- the scriptaculous javascript library is available at http://script.aculo.us/ -->'; //</script>;

		$loadmyjs['extraHeadContent'] =	$buildheadercontent;
		$this->load->vars($loadmyjs);		
		$this->load->library('Form_validation');
		$this->load->library('DX_Auth');
		$this->load->library('Table');
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
			redirect('/main/login/', 'refresh');
		} else {
		$data['title'] = 'Real Optics Inc - Client Database Reports	
		';		
		$data['main'] = 'reports/home';
		$this->load->vars($data);
		$this->load->view('template');
		}
	}
	
	function recall_report()
	{
		$data['recalls']= '';
		if ( ! $this->dx_auth->is_logged_in())
		{				 
			redirect('/main/login/', 'refresh');
		} else {
			if (isset($_POST['begindate']))
			{
			$data['recalls'] = $this->mclients->getRecalls($_POST['begindate'], $_POST['enddate'], $_POST['maxrecords'], $_POST['store_id']);
				if (isset($_POST['enteredverificationcode']))
				{
					if ( $this->uri->segment(3) == $_POST['enteredverificationcode'])
					{	redirect('main/archive_recalls/' . $_POST['begindate'] . '/' . $_POST['enddate'] . '/' . $_POST['maxrecords'] . '/' . $_POST['store_id']) ;
					} else {
						$message = 'If trying to archive users you must enter the correct verification code.';
						$this->session->set_flashdata('flashmessage',$message);
					}
				};
			};
			$data['verificationcode'] = rand(10000, 99999);
			$this->load->helper('firstdayofmonth');
			$this->load->helper('lastdayofmonth');
			$data['begindate'] =  firstdayofmonth();
			$data['enddate'] = lastdayofmonth();
				
			$this->load->model('mstores');
			$data['content_stores'] = $this->mstores->get_dropdown_array('store_id', 'name'); 
			//echo print_r($data['recalls']);
			$data['title'] = "Recall Report";
			$data['main'] = 'reports/recall';
			$data['store_id'] = $this->dx_auth->get_store_id();
			$data['exported'] = 'exported';
			$this->load->vars($data);
			$this->load->view('template');
		}
	}

	function call_report()
	{
		$data['callreport']= '';
		if ( ! $this->dx_auth->is_logged_in())
		{				 
			redirect('/main/login/', 'refresh');
		} else {
			if (isset($_POST['begindate']))
			{
				$callreport = $this->mclients->getCallReport($_POST['begindate'], $_POST['enddate'], $_POST['maxrecords'], $_POST['store_id']);
						
				$resultrows = array();
				if (isset($callreport) )	{
				
					//echo print_r($searchresults);
					$numresults = 0;
					foreach ($callreport as $rows)	{
						$row = array(
				        $rows['firstname'] . ' ' . $rows['lastname'],
				        $rows['address'],
				        $rows['city'],
				        $rows['phone'],
				        $rows['examtype'],
				        $rows['examdate']
						);
						$this->table->add_row($row);
						$numresults++;
					}
						
		            //$this->table->set_caption('Call Report data<p><p/>');
		            $this->table->set_heading(array('Client',  'Address', 'City', 'Phone', 'Exam Type', 'Last Exam'));
					$tmpl = array (
		                'table_open'          => '<table class="search-results-table-box" border="1" cellpadding="4" cellspacing="1">',
		                'heading_row_start'   => '<tr>',
		                'heading_row_end'     => '</tr>',
		                'heading_cell_start'  => '<th class="search_results_header">',
		                'heading_cell_end'    => '</th>',
		                'row_start'           => '<tr class="search_results_table_row_even">',
		                'row_end'             => '</tr>',
		                'cell_start'          => '<td>',
		                'cell_end'            => '</td>',
		                'row_alt_start'       => '<tr class="search_results_table_row_odd">',
		                'row_alt_end'         => '</tr>',
		                'cell_alt_start'      => '<td>',
		                'cell_alt_end'        => '</td>',
		                'table_close'         => '</table>'
		          );

					$this->table->set_template($tmpl); 		
					$data['callreport'] = $this->table->generate();
					$data['numresults'] = $numresults;
				}		
			}
			
			$this->load->helper('firstdayofmonth');
			$this->load->helper('lastdayofmonth');
			$data['begindate'] =  firstdayofmonth();
			$data['enddate'] = lastdayofmonth();
				
			$this->load->model('mstores');
			$data['content_stores'] = $this->mstores->get_dropdown_array('store_id', 'name'); 
			$data['title'] = "Call Report";
			$data['main'] = 'reports/call';
			$data['store_id'] = $this->dx_auth->get_store_id();
		
			$this->load->vars($data);
			$this->load->view('template');
		}
	}
	
	function mas90report()
	{
		$data['mas90report']= '';
		if ( ! $this->dx_auth->is_logged_in())
		{				 
			redirect('/main/login/', 'refresh');
		} else {
			//load mas90data model 
			$this->load->model('mmas90data');
			if ( strtoupper($this->uri->segment(10)) == '' )	
			
			{	//no switch passed so preview report.
				if (isset($_POST['begindate']))
					{ 	
						$data['begindate'] = $_POST['begindate'];
					} else { 
						$data['begindate'] = '2009-09-02';
					}
				if (isset($_POST['enddate']))
					{ 	
						$data['enddate'] = $_POST['enddate'];
					} else { 
						$data['enddate'] = '2020-02-02';
					}
				if (isset($_POST['maxamount']))
					{ 	
						$data['maxamount'] = $_POST['maxamount'];
					} else { 
						$data['maxamount'] = '555';
					}
					
				if (isset($_POST['maxrecords']))  //options provided so run report
				{
				
					$zipcodes = str_replace(',', ' ', $_POST['zipcodes'] ) ;
					$zipcodes = str_replace('  ', ' ', $zipcodes ) ;
					//echo 'zipcodes-cleaned-->' . $zipcodes . '<--<BR>';
					$this->load->model('mmas90data');
					
					//$data['mas90report']
					$salesreport = $this->mmas90data->getSalesReport(
						$data['begindate'],
						$data['enddate'],
						$_POST['maxrecords'], 
						$_POST['minamount'], 
						$data['maxamount'], 
						$_POST['store_id'], 
						$zipcodes,
						'preview'
						);

					$resultrows = array();
					if (isset($salesreport) )	
					{
						$numresults = 0;
						foreach ($salesreport as $rows)	{
							$row = array(
					        $rows['customer_name'],
					        $rows['address1'],
					        $rows['city'] . ', ' . $rows['state'] . ' ' .$rows['zipcode'],
					        $rows['phone'],
					        $rows['period'],
					        $rows['amount']
							);
							$this->table->add_row($row);
							$numresults++;
						}
							
			            $this->table->set_heading(array('Client',  'Address', 'City/State/Zip','Phone', 'Period', 'Amount'));
						$tmpl = array (
			                'table_open'          => '<table class="search-results-table-box" border="1" cellpadding="4" cellspacing="1">',
			                'heading_row_start'   => '<tr>',
			                'heading_row_end'     => '</tr>',
			                'heading_cell_start'  => '<th class="search_results_header">',
			                'heading_cell_end'    => '</th>',
			                'row_start'           => '<tr class="search_results_table_row_even">',
			                'row_end'             => '</tr>',
			                'cell_start'          => '<td>',
			                'cell_end'            => '</td>',
			                'row_alt_start'       => '<tr class="search_results_table_row_odd">',
			                'row_alt_end'         => '</tr>',
			                'cell_alt_start'      => '<td>',
			                'cell_alt_end'        => '</td>',
			                'table_close'         => '</table>'
			          );
	
						$this->table->set_template($tmpl); 		
						$data['mas90report'] = $this->table->generate();
						$data['numresults'] = $numresults;
					}
					
				}	
				
				//send formatted data to page to display
				$data['content_stores'] = $this->mstores->get_dropdown_array('store_id', 'name');
				$data['title'] = "Sales Report";
				$data['main'] = 'reports/mas90report';
				$this->load->vars($data);
				$this->load->view('template');
				
				//end of labels OR preview
				
			} elseif (strtoupper($this->uri->segment(10)) == 'CSV' ) {	
				//destination PDF so EXPORT to CSV
				$this->load->helper('download');
				$csv = $this->mmas90data->getSalesReport($this->uri->segment(3), $this->uri->segment(4), $this->uri->segment(5), $this->uri->segment(6), $this->uri->segment(7),$this->uri->segment(8),$this->uri->segment(9), $this->uri->segment(10) ); 
				$name = 'mas90report_export.csv';
				//echo print_r($csv); 
				force_download($name,$csv);
			} elseif (strtoupper($this->uri->segment(10)) == 'LABELS' ) {
				//destination LABELS so print to PDF 
				$labels = $this->mmas90data->getSalesReport($this->uri->segment(3), $this->uri->segment(4), $this->uri->segment(5), $this->uri->segment(6), $this->uri->segment(7),$this->uri->segment(8),$this->uri->segment(9), $this->uri->segment(10) ); 
				$this->load->library('cezpdf');
				$this->load->library('Clabel');
				$this->load->helper('pdf');
				$i=0;
				foreach ($labels as $label){ 
					$labeldata[$i] = array ('line1'=> trim($label['customer_name']), 'line2'=>$label['address1'], 'line3'=>$label['address2'], 'line3'=>$label['address3'], 'line4'=>$label['city'] . ', ' . $label['state'] .' ' . $label['zipcode']);
					$i++;
				}
				prep_pdf_recallreport(); // creates the footer for the document we are creating.
				
				$labeltype="Av8160";
				$label= new Clabel($labeltype);
				$label->makeLabel($labeldata);
			}	else {
				echo 'ERROR --> Invalid destination paramater passed<BR>';
			}
			
		}
	}
	
	function print_call_sheet()
	{
		if ( ! $this->dx_auth->is_logged_in())
		{				 
			redirect('/main/login/', 'refresh');
		} else {
		
			$clientstoprint = $this->mclients->getCallReport($this->uri->segment(3), $this->uri->segment(4), $this->uri->segment(5), $this->uri->segment(6));

						
			foreach ($clientstoprint as $client){ 
			
				if ( $client['phone2'] <> '' ) { $phone2 = ' \ ' . $client['phone2']; } else { $phone2 = ''; }
				$table_data[] = array ('name'=> trim($client['firstname']) . ' ' . $client['lastname'], 'address'=>$client['address'] . ' ' . $client['address2'] . ', '.  $client['city'], 'phone'=> $client['phone'] . $phone2,'lastexam'=>$client['examdate'], 'answered'=>' Y/N ', 'response'=>'                                ', 'date'=>'     /    /     ');
			}
			
			$this->load->library('cezpdf');
			$this->load->helper('pdf');

			prep_pdf_callreport(); // creates the footer for the document we are creating.
		
			$col_names = array ( 'name' => 'Name',
								'address' => 'Address',
								'phone' => 'Phone',
								'lastexam' => 'Last Exam',
								'answered' => 'Answer?',
								'response' => 'Response',
								'date' => 'Date'
								);
								
			$this->cezpdf->ezTable($table_data, $col_names, 'Call Report', array('width'=>550));
			$this->cezpdf->ezStream();
		}
	}

	function print_recall_labels()
	{
		if ( ! $this->dx_auth->is_logged_in())
		{				 
			redirect('/main/login/', 'refresh');
		} else {
		
			$clientstoprint = $this->mclients->getRecalls($this->uri->segment(3), $this->uri->segment(4), $this->uri->segment(5), $this->uri->segment(6));

			$i = 1;
						
			foreach ($clientstoprint as $client){ 
			
				$labeldata[$i] = array ('line1'=> trim($client['firstname']) . ' ' . $client['lastname'], 'line2'=>$client['address'], 'line3'=>$client['address2'], 'line3'=>'', 'line4'=>$client['city'] . ', ' . $client['state'] .' ' . $client['zip']);

				$i++;
			}
			
			$this->load->library('cezpdf');
			$this->load->library('Clabel');
			$this->load->helper('pdf');

			prep_pdf_recallreport(); // creates the footer for the document we are creating.
			
			$labeltype="Av8160";
			$label= new Clabel($labeltype);
			$label->makeLabel($labeldata);
			
		}
	}
			
	function record_recalls()
	{
		if ( ! $this->dx_auth->is_logged_in())
		{				 
			redirect('/main/login/', 'refresh');
		} else {
			$result = $this->mclients->recordRecalls($this->uri->segment(3),$this->uri->segment(4),$this->uri->segment(5), $this->uri->segment(6));
			$message = 'Results: ' . $result . '--Clients marked as "Recalled"';
			$this->session->set_flashdata('flashmessage',$message);
			redirect('reports/recall_report','location');
		}	
	}

	function archive_recalls()
	{
		if ( ! $this->dx_auth->is_logged_in())
		{				 
			redirect('/main/login/', 'refresh');
		} else {
			$result = $this->mclients->archiveRecalls($this->uri->segment(3),$this->uri->segment(4),$this->uri->segment(5), $this->uri->segment(6));
			$message = 'Results: ' . $result . '--Clients marked as "Archived"';
			$this->session->set_flashdata('flashmessage',$message);
			redirect('reports/recall_report','location');
		}	
	}

	function record_calls_printed()
	{
		if ( ! $this->dx_auth->is_logged_in())
		{				 
			redirect('/main/login/', 'refresh');
		} else {
			$result = $this->mclients->recordcallsprinted($this->uri->segment(3),$this->uri->segment(4),$this->uri->segment(5), $this->uri->segment(6));
			$message = 'Results: ' . $result . '--Clients marked as "Called"';
			$this->session->set_flashdata('flashmessage',$message);
			redirect('reports/call_report','location');
		}	
	}

        public function inventory()
        {
            $this->load->model("Minventory","inventory");

            $data['inventory'] = $this->inventory->report();
            $data['main'] = "reports/inventory";
            $data['title'] = "Inventory Report";

            $this->load->vars($data);
            $this->load->view("template");
        }

        public function inventory_to_csv()
        {
            $this->load->helper('download');
            $this->load->dbutil();
            $this->load->model("Minventory","inventory");
            $delimiter = ",";
            $newline = "\r\n";
            
            $content = $this->dbutil->csv_from_result($this->inventory->report(),$delimiter, $newline);
            $filename = "inventory-" . date("Y-m-d");
            force_download("$filename.csv", $content);
        }
	


}
?>