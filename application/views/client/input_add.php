<div id="client_input">
<fieldset><legend>Add Client Information</legend>
 <?php

		echo form_open('main/new_client');
		

		echo '<div id="data-row1">';
		echo '<label class="field1" for="firstname">First Name<br />';
		$data = array(
              'name'        => 'firstname',
              'id'          => 'firstname',
			  'maxlength'   => '30',
			  'size'        => '30',
            );
		echo form_input($data) .'</label>';
		echo '<label class="field2" for="lastname">Last Name<br />';
		$data = array(
              'name'        => 'lastname',
              'id'          => 'lastname',
			  'maxlength'   => '30',
			  'size'        => '30',
            );
		echo form_input($data) .'</label>';
		echo '<p class="clear">&nbsp;</p>';
		echo '</div>';

		echo '<div id="data-row2">';
		echo '<label class="field1" for="addres">Street Address<br />';
		$data = array(
              'name'        => 'address',
              'id'          => 'address',
			  'maxlength'   => '30',
			  'size'        => '30',
            );

		echo form_input($data) .'</label>';
		echo '<label class="field2" for="address2">Street Address (cont.)<br />';
		$data = array(
              'name'        => 'address2',
              'id'          => 'address2',
			  'maxlength'   => '30',
			  'size'        => '30',
            );
		echo form_input($data) .'</label>';
		echo '<p class="clear">&nbsp;</p>';
		echo '</div>';

		echo '<div id="data-row3">';
		echo '<label class="field1" for="city">City<br />';
		$data = array(
              'name'        => 'city',
              'id'          => 'city',
			  'maxlength'   => '30',
			  'size'        => '30',
            );
		echo form_input($data) .'</label>';

		echo '<label class="field4" for="state">State<BR>';
		echo form_dropdown('state', $content_states, 'IA') . '</label>';


		echo '<label class="field3" for="zip">Zip Code<br>';
		$data = array(
              'name'        => 'zip',
              'id'          => 'zip',
              'maxlength'   => '9',
              'size'        => '9',

            );
		echo form_input($data) .'</label>';
		echo '<p class="clear">&nbsp;</p>';
		echo '</div>';

		echo '<div id="data-row4">';
		echo '<label class="field1" for="phone">Primary Phone<br>';
		$data = array(
              'name'        => 'phone',
              'id'          => 'phone',
              'maxlength'   => '11',
              'size'        => '11',

            );
		echo form_input($data) .'</label>';

		echo '<label class="field2" for="phone2">Mobile Phone<br>';
		$data = array(
              'name'        => 'phone2',
              'id'          => 'phone2',
              'maxlength'   => '11',
              'size'        => '11',

            );
		echo form_input($data) .'</label>';

		echo '<label class="field3" for="phone3">Work Phone<br>';
		$data = array(
              'name'        => 'phone3',
              'id'          => 'phone3',
              'maxlength'   => '11',
              'size'        => '11',

            );
		echo form_input($data) .'</label>';
		echo '<p class="clear">&nbsp;</p>';
		echo '</div>';

		echo '<div id="data-row5">';
		echo '<label class="field1" for="email">Email Address<br>';
		$data = array(
              'name'        => 'email',
              'id'          => 'email',
              'maxlength'   => '50',
              'size'        => '50',

            );
		echo form_input($data) .'</label>';
		echo '<p class="clear">&nbsp;</p>';
		echo '</div>';

		echo '<div id="data-row6" >';	// id="data-row5"
		echo '<label class="field1" for="examtype">Exam Type<br>';
		$options = array(
				'undefined' => 'Undefined',
              'glasses'  => 'Glasses',
              'Contacts'    => 'Contact Lens',
              'Both'   => 'Glasses & Contact Lens',
	          'ExamOnly' => 'Exam Only',
		                );
		echo form_dropdown('examtype', $options, 'undefined');
		echo '</label>';
		echo '<label class="field4" for="doctor_id">Doctor<BR>';
		echo form_dropdown('doctor_id', $content_doctors, '1') . '</label>';
		echo '<p class="clear">&nbsp;</p>';
        echo '</div>'; 
		
		echo '<div id="data-row7" >';
		echo '<div class="field2">
				<label for="examdate">Last Exam Date</label><br/><input type="text" label="Calendar" name="examdate" id="examdate" value=' . $prepop_lastexam . '>
				<img src="' . base_url() . 'images/44white_shadow-145.png" id="exam_f_trigger_c" style="cursor: pointer; " title="Date selector" onmouseover="this.style.background=\'\';" onmouseout="this.style.background=\'\'" alt="Date Selector" class="btn_calendar" />		
				';
		echo '<script type="text/javascript">
				Calendar.setup({
					inputField     :    "examdate",     // id of the input field
					ifFormat       :    "%Y-%m-%d",      // format of the input field
					button         :    "exam_f_trigger_c",  // trigger for the calendar (button ID)
					align          :    "cc",           // alignment (defaults to "Bl")
					singleClick    :    true,
					step           :    1                // show all years in drop-down boxes (instead of every other year as default)
					});
			</script></div>';
		echo '<div class="field3">
				<label for="examdue">Next Exam Due</label><br/><input type="text" label="Calendar" name="examdue" id="examdue">
				<img src="' . base_url() . 'images/44white_shadow-145.png" id="examdue_f_trigger_d" style="cursor: pointer; " title="Date selector" onmouseover="this.style.background=\'\';" onmouseout="this.style.background=\'\'"  alt="Date Selector" class="btn_calendar"/>		
				';
        echo '<label class="special-field2" for="notes">Notes<br/>';
		$data = array(
              'name'        => 'notes',
              'id'          => 'notes',
              'rows'        => '14',
              'cols'        => '48',

            );
		echo form_textarea($data).'</label>';	
		echo '<script type="text/javascript">
				Calendar.setup({
					inputField     :    "examdue",     // id of the input field
					ifFormat       :    "%Y-%m-%d",      // format of the input field
					button         :    "examdue_f_trigger_d",  // trigger for the calendar (button ID)
					align          :    "cc",           // alignment (defaults to "Bl")
					singleClick    :    true,
					step           :    1                // show all years in drop-down boxes (instead of every other year as default)
					});
			</script></div>';
		echo '<p class="clear">&nbsp;</p>';	
		echo '</div>'; 
	
		echo '<BR>';

		

		
		echo '<p class="clear">&nbsp;</p>';		
				
		echo '<div id="data-row9">';	
		echo '<label class="field1" for="store_id">Store<BR>';
		
		$store_id = $this->session->userdata('store_id');
		echo form_dropdown('store_id', $content_stores, $store_id) . '</label>';	
		
		echo '<p class="clear">&nbsp;</p>';
		echo '</div>'; 
		
		echo '<div class="submit_div">';
		echo '<button  class="button_grey" type="submit" value="search" id="search_button" name="submit" >
					<span>Add Client</span>
			  </button>';
			  
		echo '</div>';
		
		echo form_close();
		
		
?>
</fieldset>
</div>