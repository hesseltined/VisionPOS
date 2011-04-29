<!-- stores_list.php  -->
<html>
	<head><title>Manage Stores</title></head>
	<body>

<?php if ($this->uri->segment(3)=='edit') {?>



<?php }?>  <!-- close tag for edit IF statement -->


<?php if (isset($table)) {	
	echo $table; '<BR />';
	} else {
	echo 'Sorry, could not get list of stores.';
	}
?>

	</body>
</html>


<div id="client_input"><fieldset><legend>Edit Store Information</legend>
<?php
  	foreach($clientdata as $client){
 		$hidden = array('client_id' => $this->uri->segment(3));
		echo form_open('main/stores/edit/'. $this->uri->segment(3), '',$hidden); 

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


		echo '<label class="field2" for="lastname">Last Name<br />';
		$data = array(
			'name'        => 'lastname',
			'id'          => 'lastname',
			'value'       => $client['clientlastname'],
			  'maxlength'   => '37',
			  'size'        => '30',
			);
		echo form_input($data) .'</label>';
		echo '</div>';
		echo '<div style="clear:both"></div>';



		echo '<div id="data-row2">';
		echo '<label class="field1" for="address">Street Address<br />';
		$data = array(
			'name'        => 'address',
			'id'          => 'address',
			'value'       => $client['address'],
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


		echo '<label class="field3" for="zip">Zip Code<BR>';
		$data = array(
			'name'        => 'zip',
			'id'          => 'zip',
			'value'       => $client['zip'],
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
              'size'        => '10',
			);
		echo form_input($data) .'</label>';


		echo '<label class="field2" for="phone2">Mobile Phone<BR>';
		$data = array(
			'name'        => 'phone2',
			'id'          => 'phone2',
			'value'       => $client['phone2'],
              'maxlength'   => '12',
              'size'        => '10',
			);
		echo form_input($data) .'</label>';


		echo '<label class="field3" for="phone3">Work Phone<BR>';
		$data = array(
			'name'        => 'phone3',
			'id'          => 'phone3',
			'value'       => $client['phone3'],
              'maxlength'   => '12',
              'size'        => '10',
			);
		echo form_input($data) .'</label>';
		echo '</div>';
		echo '<div style="clear:both"></div>';

		echo '<div id="data-row5">';
		echo '<label class="field1" for="email">Email Address<BR>';
		$data = array(
			'name'        => 'email',
			'id'          => 'email',
			'value'       => $client['email'],
			'maxlength'   => '47',
			'size'        => '49',

			);
		echo form_input($data) .'</label>';
		echo '</div>';
		echo '<div style="clear:both"></div>';


		echo '<div id="data-row6">';
		echo '<label class="field1" for="type">Exam Type<BR>';
		$options = array(
			'Glasses'  => 'Glasses',
			'Contacts'    => 'Contact Lens',
			'Both'   => 'Glasses & Contact Lens',
			'ExamOnly' => 'Exam Only',
			);
		echo form_dropdown('examtype', $options, $client['examtype']);
		echo '</label>';



		echo '<div class="special-field2"><table cellspacing="0" cellpadding="0" style="border-collapse: collapse"><tr>
				<td><label for="examdate">Last Exam Date</label><br/><input type="text" label="Calendar" name="examdate" id="examdate"  value=' . $client['examdate'] . '></td>
				<td><img src="' . base_url() . 'images/44white_shadow-145.png" id="exam_f_trigger_c" style="cursor: pointer; " title="Date selector" onmouseover="this.style.background=\'\';" onmouseout="this.style.background=\'\'" alt="Date Selector" /></td>
				</table>
				';

		echo '<script type="text/javascript">
				Calendar.setup({
					inputField     :    "examdue",     // id of the input field
					ifFormat       :    "%Y-%m-%d",      // format of the input field
					button         :    "examdue_f_trigger_c",  // trigger for the calendar (button ID)
					align          :    "cc",           // alignment (defaults to "Bl")
					singleClick    :    true,
					step           :    1                // show all years in drop-down boxes (instead of every other year as default)
					});
			</script></div>';
			echo '</div>';
		echo '<div style="clear:both"></div>';

		echo '<div id="data-row7">';
		
		echo '<label class="field1" for="doctor_id">Doctor<BR>';
		echo form_dropdown('doctor_id', $content_doctors, $client['doctor_id']) . '</label>';
		
		echo '<div class="special-field2"><table cellspacing="0" cellpadding="0" style="border-collapse: collapse"><tr>
				 <td><label for="recalldate">Recall Date</label><br/><input type="text" label="Calendar" name="recalldate" id="recalldate"  value=' . $client['recalldate'] . '></td>
				<td><img src="' . base_url() . 'images/44white_shadow-145.png" id="recall_f_trigger_c" style="cursor: pointer; " title="Date selector" onmouseover="this.style.background=\'\';" onmouseout="this.style.background=\'\'"  alt="Date Selector"/></td>
				</table>
				';

		echo '<script type="text/javascript">
					Calendar.setup({
					inputField     :    "lastcontact",     // id of the input field
					ifFormat       :    "%Y-%m-%d",      // format of the input field
					button         :    "lastcontact_f_trigger_c",  // trigger for the calendar (button ID)
					align          :    "cc",           // alignment (defaults to "Bl")
					singleClick    :    true,
					step           :    1                // show all years in drop-down boxes (instead of every other year as default)
					});
			</script></div>';
			echo '</div>';
	
		echo '<div id="data-row8">';
			
		echo '<label class="field1" for="store_id">Store<BR>';
		echo form_dropdown('store_id', $content_stores, $client['store_id']) . '</label>';
			

		echo '<label class="special-field1" for="lastpurchaseamount">Last Purchase Amount<br>$';
		$data = array(
              'name'        => 'lastpurchaseamount',
              'id'          => 'lastpurchaseamount',
              'value' => $client['lastpurchaseamount'],
              'maxlength'   => '10',
              'size'        => '8',

            );
		echo form_input($data) .'</label>';
		
		echo '<div id="data-row9">';
		echo '<label class="special-field2" for="notes">Notes<br>';
		$data = array(
              'name'        => 'notes',
              'value' => $client['notes'],
              'id'          => 'notes',
              'rows'   => '2',
              'cols'        => '100',

            );
		echo form_textarea($data) .'</label>';
		echo '</div>';
		
		echo '</div>'; 
			
		echo '<div style="clear:both"></div>';

		echo '<div>';
		echo form_submit('submit','Edit Client');
		echo '</div>';
		echo '<div style="clear:both"></div>';
		
		echo form_close(); 
	}

?>
</fieldset>
</div>