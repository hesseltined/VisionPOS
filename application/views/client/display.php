<div class="display-containerr" ><fieldset><legend>Client Information</legend>

<?php 

	echo '<div id="customer-functions-box">'; // begain customer functions


	echo '<ul class="customer-functions">';
	echo '<li>'.anchor('main/checkin/' . $this->uri->segment(3), 'Check-In Client').'</li>';

	echo '<li>'.anchor('main/logcontact/' . $this->uri->segment(3), 'Customer Contact').'</li>';
																  
	echo '<li>'.anchor('main/edit_client/' . $this->uri->segment(3) , 'Edit').'</li>';

	echo '<li>'.$new_order_button.'</li>';
	
	echo '<li>'.$balance_statement.'</li>';;
	echo '</ul>';
	echo '</div>'; // end customer functions

	
	echo '<div>' . $this->session->userdata('message') .'</div>';
	
	$this->session->unset_userdata('message');


	foreach ($clientdata as $client){


	echo '<div class="display-container">'; // begain of wrap name and phone data box
	
	echo '<div class="data-box1">';
	echo '<ul class="display-client-style">';
	echo '<li>' . '<span style="color: green">Store:</span>' . $client['storename'] . '</li>';
	echo '<li>' . $client['clientfirstname'] . ' ' . $client['clientlastname'] . '</li>';
	echo '<li>' . $client['address'] . '</li>';

	if ($client['address2'] != ''){

	echo '<li>' . $client['address2'] . '</li>';
	}
	echo '<li>' . $client['city'] . ', ' . $client['state'] . ' ' . $client['zip'] . '</li>';
	echo '</ul>';
	echo '</div>';


	echo '<div class="data-box2">';
	echo '<ul class="display-client-style">'; // begain phone & email going right side of name & address
	echo '<li>Phone: ' . format_phone_number($client['phone']) . '</li>';
	if ($client['phone2'] != ''){
	echo '<li>Mobile:' . format_phone_number($client['phone2']) . '</li>';
	}
	if ($client['phone3'] != ''){
	echo '<li>Work:' . format_phone_number($client['phone3']) . '</li>';
	}
	echo '<li>Email Address: ';

	if ($client['email'] !='')	{

	echo '<a href="mailto:' . $client['email'] . '">' . $client['email'] . '</a>';

	} else	{

	echo '<span style="color: red">No email on record</span>';

	}

	echo '</li>';
	echo '</ul>';
	echo '</div>';
	echo '<div class="clear">&nbsp;</div>';

	
	echo '</div>'; // end phone & email // end of wrap name and phone detail box
	
	


	
	echo '<div class="display-container">'; // begain for exams
	
	if ( $client['examtype'] =='') {

		$examtype = '<span style="color: red">No Value Provided</span>';
	} else {
		$examtype = $client['examtype'];
	}


	echo '<div class="data-box1">';
	
	echo '<ul class="display-client-style">';
	echo '<li>Type: ' . $examtype . '</li>';
	echo '<li>Last Exam Date: ' . $client['examdate'] . '</li>';
	echo '<li>Next Exam Due Date: ' . $client['examdue'] . '</li>';
	echo '</ul>';
	echo '</div>';
	
	echo '<div class="data-box2">';
	
	echo '<ul class="display-client-style">';
	echo '<li>Doctor: ' . $client['doctorfirstname'] . ' ' . $client['doctorlastname'] . '</li>';
	echo '<li>Last Recall Sent: ' . $client['recalldate'] . '</li>';
	echo '<li>Last Customer Contact: ' . $client['lastcontact'] . '</li>';
	echo '<li>Notes: ' . $client['notes'] . '</li>';
	echo '</ul>';
	echo '</div>';
	echo '<div class="clear">&nbsp;</div>';
	echo '</div><br />'; //End of exams
	
	
	if (isset($list_orders)) {
		
		echo '<div class="display-container">';
		echo '<p>';
		echo $list_orders;		
	} else {
		echo '<div class="display-container-no-order" style="border:0;">';
		echo '<p>';
		echo 'No existing orders';
	}
    echo'</p></div>';
	echo '<div class="display-container-no-order">';

	if($client['clientstatus'] == 0) {

		$showarchived =  'True &nbsp;';

		$showarchived .= anchor('main/unarchive_client/' . $this->uri->segment(3), ' Set Client back to Active');

	} else { 

		$showarchived = 'False &nbsp;';

		//	if ($this->dx_auth->is_admin()){

		$showarchived .= anchor('main/archive_client/' . $this->uri->segment(3), ' Archive Client Record');

		//	}

	}

	echo '<p>&nbsp; Archived? ' . $showarchived . '</p>';  // FINISH THIS LATER - Need to add confirmation javascript
	echo '<hr/>';
	echo '</div>';

	}
	
	echo '<div>';
	echo '<ul class="customer-functions">';
	echo '<li>'.anchor('main/checkin/' . $thi