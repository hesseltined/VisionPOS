<?php

class Mstores extends Model {



	function Mstores()

	{

		parent::Model();

	}



	function getStoreList()

	{
	    $data = array(); 
	    $this->db->select('store_id, name');
	    $query = $this->db->get('stores'); 
	    if ($query->num_rows() > 0)
	    { 
			$storelist = $query->result_array(); 
			return $storelist;
	    }

	}

	function getstoredetails()
	{
	    $data = array(); 
	    $this->db->select('stores.store_id, stores.name, stores.city, stores.state, stores.zip, stores.number, users.username as manager, stores.address, stores.email, stores.phone');
	    $this->db->where('stores.store_id <>', $this->uri->segment(4)) ;
	    $this->db->join('users', 'users.id = stores.manager', 'LEFT');
	    $query = $this->db->get('stores'); 
	    
		if ($query->num_rows() > 0) 
		{
			return $query->result_array(); 
		}
	}
	
	function getStores()
	{
	    $data = array(); 
	    $this->db->select('stores.store_id, stores.name, stores.city, stores.state, stores.zip, stores.number, users.username as manager, stores.address, stores.email, stores.phone');
	    $this->db->where('number <>', '99');
	    $this->db->join('users', 'users.id = stores.manager', 'LEFT');
	    $query = $this->db->get('stores'); 
	    
		if ($query->num_rows() > 0) 
		{
			return $query->result_array(); 
		}
	}
	
	function getStoreName($store_id)
	{
		$this->db->where('store_id', $store_id);
		$this->db->orderby('name');
		$this->db->select('name');
		$query = $this->db->get('stores');
		$row = $query->row();
		$storename = $row->name;
		return $storename;
	}

	function getStoreNumber($store_id)
	{
		$this->db->where('store_id', $store_id);
		$this->db->orderby('store_id');
		$this->db->select('store_id');
		$query = $this->db->get('stores');
		$row = $query->row();
		$storenumber = $row->store_id;
		return $storenumber;
	}
	
	function getStoreID($storenumber)
	{
		$this->db->where('store_id', $storenumber);
		$this->db->select('store_id');
		$query =  $this->db->get('stores');
		$row = $query->row();
		$store_id =  $row->store_id;
		return $store_id;
	}
	
	function get_dropdown_array($key, $value){
        $result = array();
        $array_keys_values = $this->db->query('SELECT '.$key.', '.$value.' FROM stores ORDER BY name ASC');
       foreach ($array_keys_values->result() as $row)
        {
            $result[$row->$key]= $row->$value;
        }
        $result['all'] = 'All Stores';
        return $result;
    } 
	

}

?>