<?php

class Moptions extends Model {



	function Moptions()

	{

		parent::Model();

	}



	function site_info ()

	{
	    $data = array(); 
	    $Q = $this->db->get('config'); 
	    if ($Q->num_rows() > 0)
	    { 
			$data = $Q->row_array(); 
			$data['test'] = 'This is test data';
	    }

	}

}

?>