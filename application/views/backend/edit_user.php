<!-- VIEW-> edit_user.php  -->



<div id="client_input"><fieldset><legend>Edit User Account</legend>

<?php
  	
		echo $open_form;

		echo '<div id="data-row1">';
		echo '<label class="field1" for="username">Username<br />';
		$data = array(
			'name'        => 'username',
			'id'          => 'username',
			'value'       => $username,
			  'maxlength'   => '37',
			  'size'        => '30',
			);
		echo form_input($data) .'</label>';


		echo '<label class="field2" for="email">Email Address<br />';
		$data = array(
			'name'        => 'email',
			'id'          => 'email',
			'value'       => $email,
			'maxlength'   => '37',
			'size'        => '30',
			);
		echo form_input($data) .'</label>';
		echo '</div>';

		echo  $security_roles;

		echo '<div id="data-row8">';
			
		echo '<label class="field1" for="store_id">Store<BR>';
		echo form_dropdown('store_id', $content_stores, $store_id ) . '</label>';
				
		
		echo '</div>'; 
			
		echo '<div style="clear:both"></div>';

		echo '<div>';
		echo $form_submit_edit . $form_submit_delete;
		echo '</div>';
		echo '<div style="clear:both"></div>';
		
		echo form_close(); 

?>
</fieldset>
</div>