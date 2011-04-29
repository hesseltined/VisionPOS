<?php
		echo '<p><label for="firstname">First Name</label><br/>'; 
		$data = array(
              'name'        => 'firstname',
              'id'          => 'firstname',
              'value'       => $client['firstname'],
              'maxlength'   => '25',
              'size'        => '25',
              'style'       => 'width:20%',
            );
		echo form_input($data) .'</p>'; 
		echo '<p><label for="lastname">Last Name</label><br/>'; 
		$data = array(
              'name'        => 'lastname',
              'id'          => 'lastname',
              'value'       => $client['lastname'],
              'maxlength'   => '25',
              'size'        => '25',
              'style'       => 'width:20%',
            );
		echo form_input($data) .'</p>';
		
		echo '<p><label for="address">Street Address</label><br/>'; 
		$data = array(
              'name'        => 'address',
              'id'          => 'address',
              'value'       => $client['address'],
              'maxlength'   => '25',
              'size'        => '25',
              'style'       => 'width:20%',
            );
		echo form_input($data) .'</p>';

		echo '<p><label for="address2">Street Address (cont.)</label><br/>'; 
		$data = array(
              'name'        => 'address2',
              'id'          => 'address2',
              'value'       => $client['address2'],
              'maxlength'   => '25',
              'size'        => '25',
              'style'       => 'width:20%',
            );
		echo form_input($data) .'</p>';
		
		echo '<p><label for="city">City</label><br/>'; 
		$data = array(
              'name'        => 'city',
              'id'          => 'city',
              'value'       => $client['city'],
              'maxlength'   => '25',
              'size'        => '25',
              'style'       => 'width:20%',
            );
		echo form_input($data) .'</p>';
		
		echo '<p><label for="state">State</label><br/>'; 
		$options = array(
		                  'IA'  => 'Iowa',
		                  'NE'    => 'Nebraska',
		                  'MN'   => 'Minnesota',
		                );	
		echo form_dropdown('state', $options, $client['state']);

		echo '<p><label for="zip">Zip Code</label><br/>'; 
		$data = array(
              'name'        => 'zip',
              'id'          => 'zip',
              'value'       => $client['zip'],
              'maxlength'   => '10',
              'size'        => '10',
              'style'       => 'width:20%',
            );
		echo form_input($data) .'</p>';
		
		echo '<p><label for="phone">Primary Phone</label><br/>'; 
		$data = array(
              'name'        => 'phone',
              'id'          => 'phone',
              'value'       => $client['phone'],
              'maxlength'   => '15',
              'size'        => '15',
              'style'       => 'width:20%',
            );
		echo form_input($data) .'</p>';
		
		echo '<p><label for="phone2">Mobile Phone</label><br/>'; 
		$data = array(
              'name'        => 'phone2',
              'id'          => 'phone2',
              'value'       => $client['phone2'],
              'maxlength'   => '15',
              'size'        => '15',
              'style'       => 'width:20%',
            );
		echo form_input($data) .'</p>';
		
		echo '<p><label for="phone3">Work Phone</label><br/>'; 
		$data = array(
              'name'        => 'phone3',
              'id'          => 'phone3',
              'value'       => $client['phone3'],
              'maxlength'   => '15',
              'size'        => '15',
              'style'       => 'width:20%',
            );
		echo form_input($data) .'</p>';
		
		echo '<p><label for="email">Email Address</label><br/>'; 
		$data = array(
              'name'        => 'email',
              'id'          => 'email',
              'value'       => $client['email'],
              'maxlength'   => '50',
              'size'        => '50',
              'style'       => 'width:20%',
            );
		echo form_input($data) .'</p>';
		
		echo '<p><label for="type"