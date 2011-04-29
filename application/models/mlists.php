<?php
class Mlists extends Model {

	function Mlists()
	{
		parent::Model();
	}
	
	function get_list_carriers(){
        $result = array();
        $array_keys_values = $this->db->query('SELECT carrier FROM list_carriers WHERE active = TRUE ORDER BY id ASC');
       foreach ($array_keys_values->result() as $row)
        {
            $result[$row->carrier]= $row->carrier;
            //add blank AND {manager allowed discount} to beginning of array
            $result=array_merge(array("DISCOUNT"=>$this->lang->line('discount_allowed')),$result); 
            $result=array_merge(array("NONE"=>"{None}"),$result); 
        }
        return $result;
    } 

	function get_list_bridges(){
	    $result = array();
	    $array_keys_values = $this->db->query('SELECT bridge FROM list_bridges WHERE active = TRUE ORDER BY bridge asc');
	   foreach ($array_keys_values->result() as $row)
	    {
	        $result[$row->bridge]= $row->bridge;
	    }
	    return $result;
	}	

	function get_list_discounts(){
	    $result = array();
	    $array_keys_values = $this->db->query('SELECT description, discount_id FROM list_discounts WHERE active = TRUE ORDER BY description asc');
	   foreach ($array_keys_values->result() as $row)
	    {
	        $result[$row->description]= $row->discount_id;
	    }
	    return $result;
	}
	
	function get_frame_divisions(){
	    $result = array();
	    $array_keys_values = $this->db->query('SELECT division FROM frame_divisions WHERE active = TRUE ORDER BY division asc');
	   foreach ($array_keys_values->result() as $row)
	    {
	        $result[$row->division]= $row->division;
	    }
	    return $result;
	}
	
	function get_list_all_frame_divisions(){
	    $result = array();
	    $array_keys_values = $this->db->query('SELECT division FROM frame_divisions WHERE active = TRUE ORDER BY division asc');
	   foreach ($array_keys_values->result() as $row)
	    {
	        $result[$row->division]= $row->division;
	    }
	    return $result;
	}
	
	function get_list_invoice_Status(){
	    $result = array();
	    $array_keys_values = $this->db->query('SELECT status FROM list_invoice_status WHERE active = TRUE ORDER BY status asc');
	   foreach ($array_keys_values->result() as $row)
	    {
	        $result[$row->status]= $row->status;
	    }
	    return $result;
	}

	function get_list_order_type(){
	    $result = array();
	    $array_keys_values = $this->db->query('SELECT order_type FROM list_order_type WHERE active = TRUE ORDER BY order_type asc');
	   foreach ($array_keys_values->result() as $row)
	    {
	        $result[$row->order_type]= $row->order_type;
	    }
	    return $result;
	}
	
	function get_list_lens_types(){
	    $result = array();
	    $array_keys_values = $this->db->query('SELECT id, type FROM lens_types WHERE active = TRUE ORDER BY id asc');
	   foreach ($array_keys_values->result() as $row)
	    {
	        $result[$row->id]= $row->type;
	    }
	    return $result;
	}
	
	function get_list_lens_designs(){
	    $result = array();
	    $array_keys_values = $this->db->query('SELECT id, design FROM lens_designs WHERE active = TRUE ORDER BY design asc');
	   foreach ($array_keys_values->result() as $row)
	    {
	        $result[$row->id]= $row->design ;
	    }
	    return $result;
	}		
	
	function get_list_lens_designs_by_type_id($lensTypeId)
	{	    
		$result = array();		
		$array_keys_values = $this->db->query('SELECT id, design FROM lens_designs WHERE type_id='.$lensTypeId.' and active = TRUE ORDER BY design asc');	   
		foreach ($array_keys_values->result() as $row)	    
		{	        
			$result[$row->id]= $row->design ;	    
		}	    
		return $result;	
	}	
	
	function get_frame_colors_frame_id($frame_id 	)
	{	    
		$result = array();		
		$array_keys_values = $this->db->query('SELECT id, color FROM frame_colors WHERE frame_id ='.$frame_id.' or frame_id=0');	   
		foreach ($array_keys_values->result() as $row)	    
		{	        
			$result[$row->id]= $row->color ;	    
		}	    
		return $result;	
	}
	
	function get_list_lens_materials(){
	    $result = array();
	    $array_keys_values = $this->db->query('SELECT id,