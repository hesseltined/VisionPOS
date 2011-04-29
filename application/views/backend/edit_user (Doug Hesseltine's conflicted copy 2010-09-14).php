<!-- VIEW-> edit_user.php  -->



<div id="client_input"><fieldset><legend>Edit User Account</legend>

<?php

  	foreach($userdata as $user){
 		$hidden = array('user_id' => $this->uri->segment(3));
		echo form_open('backend/edit_user/'. $this->uri->segment(3), '',$hidden); 

		echo '<div id="data-row1">';
		echo '<label class="field1" for="username">Username<br />';
		$data = array(
			'name'        => 'username',
			'id'          => 'username',
			'value'       => $user['username'],
			  'maxlength'   => '37',
			  'size'        => '30',
			);
		echo form_input($data) .'</label>';


		echo '<label class="field2" for="email">Email Address<br />';
		$data = array(
			'name'        => 'email',
			'id'          => 'email',
			'value'       => $user['email'],
			  'maxlength'   => '37',
			  'size'        => '30',
			);
		echo form_input($data) .'</label>';
		echo '</div>';



		echo '<div id="data-row8">';
			
		echo '<label class="field1" for="store_id">Store<BR>';
		echo form_dropdown('store_id', $content_stores, $user['store_id']) . '</label>';
				
		
		echo '</div>'; 
			
		echo '<div style="clear:both"></div>';

		echo '<div>';
		echo form_submit('submit','Edit User');
		echo '</div>';
		echo '<div style="clear:both"></div>';
		
		echo form_close(); 
	}

?>
</fieldset>
</div>