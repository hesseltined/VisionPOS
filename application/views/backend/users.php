<html>

	<head><title>Manage users</title></head>

	<body>

	<?php  				

		// Show reset password message if exist

		if (isset($reset_message))

			echo $reset_message;

		

		// Show error

		echo validation_errors();

		

		$this->table->set_heading('', 'Username', 'Store ID', 'Email', 'Role', 'Banned', 'Last IP', 'Last login', 'Created', 'Delete');

		

		foreach ($users as $user) 

		{

			$banned = ($user->banned == 1) ? 'Yes' : 'No';

			

			$this->table->add_row(

				form_checkbox('checkbox_'.$user->id, $user->id),

				anchor('backend/edit_user/'. $user->id, $user->username), 
				$user->store_id,

				$user->email, 

				$user->role_name, 			

				$banned, 

				$user->last_ip,

				date('Y-m-d', strtotime($user->last_login)), 

				date('Y-m-d', strtotime($user->created)),
				anchor('backend/delete_user/' . $user->id, '<img src="../images/delete.png">')     //DOUG - added 9-14-10 to allow deleting user from user list.
				);

		}
		

		echo form_open($this->uri->uri_string());

				

		echo form_submit('ban', 'Ban user');

		echo form_submit('unban', 'Unban user');

		echo form_submit('reset_pass', 'Reset password');
		
/*		
<div class="register"> <?php
if ($this->dx_auth->allow_registration) {
	echo anchor($this->dx_auth->register_uri, 'Register');
};
?>
</div>		
*/

		
		

		echo '<hr/>';

		

		echo $this->table->generate(); 

		

		echo $pagination;
		
		echo form_close();
		
		echo '<p>';
		echo form_open($this->dx_auth->register_uri);
			echo form_submit('Create New User', 'Create New User');
		echo form_close();
		echo '</p>';

			

	?>

	</body>

</html>