<?php
class Ajaxinventory extends Model {
	function Ajaxinventory()
	{
		parent::Model();
	}		
	
	function get_frame_color($frame_id='')	
	{	
		if($frame_id=='Other' || $frame_id=='')
			return array();
			
		$result = array();	    
		$query = $this->db->query('SELECT color, id FROM frame_colors WHERE active = TRUE and frame_id='.$frame_id.' ORDER BY color asc');	
		if ($query->num_rows() > 0) 
		{				
			$result =  $query->result_array();			
			return $result;		
		}
		else
			return array();
	}	
	
	function get_inventory_frame_manufacturers()	
	{	    
			$result = array();	    
			$query = $this->db->query('SELECT manufacturer, id FROM frame_manufacturers WHERE active = TRUE ORDER BY manufacturer asc');		
			if ($query->num_rows() > 0) {				$result =  $query->result_array();			$result = array_merge(array("0"=>array("id"=>"","manufacturer"=>"- - - ")),$result);			
			return $result;		
		}   			
	}			
	
	function add_inventory($manufacturer, $mfg_other='', $div, $div_other='', $frame_id, $other='', $color_id,$color_other='', $store_id, $eye_size , $bridge_size , $temple_size, $cost_price , $retail_price )	
	{
		if($manufacturer=='Other')
		{
			$data = array( 'manufacturer' => $mfg_other, 
							'active' => 1
						  );			
			$query  = $this->db->get_where("frame_manufacturers",$data);
			$arr    = $query->row_array();
			if(count($arr)<=0)
			{
				$this->db->insert('frame_manufacturers', $data );
				$manufacturer = $this->db->insert_id();		
			}
			else
				$manufacturer = $arr['id'];					
		}
		
		if($div=='Other')
		{ 	 	
			$data = array(  'manufacturer_id' => $manufacturer,
							'division' => $div_other,
							'active' => 1
						  );	
			$query  = $this->db->get_where("frame_divisions",$data);
			$arr    = $query->row_array();
			if(count($arr)<=0)
			{
				$this->db->insert('frame_divisions', $data );
				$div = $this->db->insert_id();		
			}
			else
			{
				$div = $arr['id'];	
			}
		}
		
		if($frame_id=='' || $frame_id=='Other')
		{			
			$ndata = array( 'division_id' => $div, 		  'name' 		  => $other,
							'cost_price'  => $cost_price,  'retail_price' => $retail_price);
			
			$query  = $this->db->get_where("frames",$ndata);
			$arr    = $query->row_array();
			if(count($arr)<=0)
			{
				$this->db->insert('frames', $ndata );			
				$frame_id = $this->db->insert_id();	
			}
			else
				$frame_id = $arr['id'];
		}
		
		if($color_id=='Other')
		{ 	 	
			$data = array(  'color'    => $color_other,
							'frame_id' => $frame_id,
							'active' => 1
						  );
			$query  = $this->db->get_where("frame_colors",$data);
			$arr    = $query->row_array();
			if(count($arr)<=0)
			{				
				$this->db->insert('frame_colors', $data );
				$color_id = $this->db->insert_id();
            }
			else
				$color_id = $arr['id'];
		}
		$date_in = date('Y-m-d');
		$ndata = array(	'frame_id' =>$frame_id,
						'color_id' => $color_id,
						'store_id' => $store_id,   
						'eye_size_min'=> $eye_size , 
					    'bridge_size' => $bridge_size,
						'temple_size' => $temple_size,
						'date_in'     => $date_in
					    );			
		$this->db->insert('frame_inventory', $ndata );			
		return true;	
	}	
	
	
	function all_store()
	{
		$this->db->select('store_id,name');
		$query = $this->db->get('stores');
		return $query->result_array();
	}
	
	function get_frame_price($id)
	{
		$this->db->select('cost_price,retail_price');
		$this->db->where( 'id', $id );
		$query = $this->db->get('frames');
		return $query->row_array();
	}
	
	function get_coating_price($id)
	{
		$this->db->select('cost_price,retail_price');
		$this->db->where( 'id', $id );
		$query = $this->db->get('lens_coatings');
		return $query->row_array();
	}
	
	function get_lens_price($design_id,$material_id)
	{
		$this->db->select('cost_price,retail_price');
		$this->db->where( 'design_id', $design_id ); 	
		$this->db->where( 'material_id', $material_id ); 
		$query = $this->db->get('lens_pricing');
		return $query->row_array();
	}
	
	function treatment_price($str)
	{
		$query = $this->db->query("select sum(cost_price) as cost_price,sum(retail_price) as retail_price from l