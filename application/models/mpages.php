<?php 

class Mpages extends Model 
{


	function Mpages()

	{

		parent::Model();

	}
	
	function getpages()
	{
		$data=array(); 
		$this->db->order_by('page_rank');
		$this->db->where('active  >', 0);	
    	$query=$this->db->get('pages'); 
    	if ($query->num_rows() > 0)
    	{ 
      		foreach ($query->result_array() as $row)
      		{ 
        		$data[] = $row; 
      		} 
    	} 
		else
		{
			show_error('could not retrieve pages listing to build Navigation bar : table:pages');
		}
		$query->free_result(); 
    	return $data; 
    }
}
?>