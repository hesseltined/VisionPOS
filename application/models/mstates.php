<?php

class Mstates extends Model {



	function Mstates()

	{

		parent::Model();

	}



	function getStateList()

	{
	    $data = array(); 
	    $this->db->select('state_abbr, state');
	    $query = $this->db->get('states'); 
	    if ($query->num_rows() > 0)
	    { 
			$statelist = $query->result_array(); 
			return $statelist;
	    }

	}
	
	function get_dropdown_array($key, $value){
        $result = array();
        $array_keys_values = $this->db->query('select '.$key.', '.$value.' from states order by state asc');
       foreach ($array_keys_values->result() as $row)
        {
            $result[$row->$key]= $row->$value;
        }
        return $result;
    } 
	

}

?>