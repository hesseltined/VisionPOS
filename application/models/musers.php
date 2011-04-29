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
		$this->db->select('users.username, users.email, stores.store_id, users.role_id AS security_role');
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
		'email' => $_POST['email'],
		'role_id' => $_POST['security_role']
		);
		
		$this->db->where('id', $_POST['user_id']);
		$this->db->update('users', $data); 	
	}
	
	function deleteUser( $user_id )
	{	
		$data = array( 
		'active' => FALSE
		);
		
		$this->db->where('id', $user_id );
		$this->db->update('users', $data); 	
		$result = $this->db->count_all_results();
		return $result;
	}
	function getUserNameByDispencerId($dispencer_id)
	{
		$this->db->select('username');
		$this->db->where('dispencer_id', $dispencer_id );
		$query =  $this->db->get('users');
		//echo $this->db->last_query();
		return ($query->num_rows() > 0)?$query->row()->username:false;
		
		
	}
}
?>