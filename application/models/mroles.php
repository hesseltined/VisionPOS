<?php

class Musers extends Model {



	function Musers()

	{

		parent::Model();

	}
	
	function getStoreID($userid)
	{
		$this->db->where('id', $userid);
		$this->db->select('store_id');
		$query =  $this->db->get('users');
		$row = $query->row();
		$store_id =  $row->store_id;
		return $store_id;
	}	
	
	function getUserRecord()
	{
		$this->db->select('users.username, users.email, stores.store_id');
		$this->db->where('id', $this->uri->segment(3));
		$this->db->join('stores', 'stores.store_id = users.store_id', 'left');
		$query = $this->db->get('users','','1');
		if ($query->num_rows() > 0) 
		{
			return $query->result_array(); 
		}
	}	

	function editUser()
	{
	
		$data = array( 
		'store_id' => $_POST['store_id'],
		'username' => $_POST['username'], 
		'email' => $_POST['email']); 
		
		$this->db->where('id', $_POST['user_id']);
		$this->db->update('users', $data); 	
	}

}

?>