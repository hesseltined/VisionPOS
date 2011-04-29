<!-- VIEW-> client_input_edit.php  -->



<div id="client_input"><fieldset><legend>Edit Client Information</legend>

<?php

  	foreach($clientdata as $client){
 		$hidden = array('customer_number' => $this->uri->segment(3));
		echo form_open('main/edit_client/'. $this->uri->segment(3) . '/editmas90', '',$hidden); 

		echo '<div id="data-row1">';
		echo '<label class="field1" for="firstname">First Name<br />';
		$data = array(
			'name'        => 'firstname',
			'id'          => 'firstname',
			'value'       => $client['clientfirstname'],
			  'maxlength'   => '37',
			  'size'        => '30',
			);
		echo form_input($data) .'</label>';

		echo '<div id="data-row2">';
		echo '<label class="field1" for="address1">Street Address<br />';
		$data = array(
			'name'        => 'address1',
			'id'          => 'address1',
			'value'       => $client['address1'],
			  'maxlength'   => '37',
			  'size'        => '30',
			);
		echo form_input($data) .'</label>';
		
		echo '<label class="field2" for="address2">Street Address (cont.)<br />';
		$data = array(
			'name'        => 'address2',
			'id'          => 'address2',
			'value'       => $client['address2'],
			  'maxlength'   => '37',
			  'size'        => '30',
			);
		echo form_input($data) .'</label>';
		
		echo '<label class="field2" for="address3">Street Address (cont.)<br />';
		$data = array(
			'name'        => 'address3',
			'id'          => 'address3',
			'value'       => $client['address3'],
			  'maxlength'   => '37',
			  'size'        => '30',
			);
		echo form_input($data) .'</label>';
		
		echo '</div>';
		echo '<div style="clear:both"></div>';

		echo '<div id="data-row3">';
		echo '<label class="field1" for="city">City<br />';
		$data = array(
			'name'        => 'city',
			'id'          => 'city',
			'value'       => $client['city'],
			  'maxlength'   => '37',
			  'size'        => '30',
			);
		echo form_input($data) .'</label>';

		echo '<label class="field4" for="state">State<BR>';
		echo form_dropdown('state', $content_states, 'IA') . '</label>';

		echo '<label class="field3" for="zipcode">Zip Code<BR>';
		$data = array(
			'name'        => 'zipcode',
			'id'          => 'zipcode',
			'value'       => $client['zipcode'],
			'maxlength'   => '10',
			'size'        => '10',
			);
		echo form_input($data) .'</label>';
		echo '</div>';
		echo '<div style="clear:both"></div>';

		echo '<div id="data-row4">';
		echo '<label class="field1" for="phone">Primary Phone<BR>';
		$data = array(
			'name'        => 'phone',
			'id'          => 'phone',
			'value'       => $client['phone'],
              'maxlength'   => '12',
              'size'        => '20',
			);
		echo form_input($data) .'</label>';

		echo '</div>';
		echo '<div><BR>';
		echo form_submit('submit','Edit Client');
		echo '</div>';
		echo '<div style="clear:both"></div>';
		
		echo form_close(); 
	}

?>
</fieldset>
</div>