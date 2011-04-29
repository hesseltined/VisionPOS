<?php
class Mframes extends Model {

	function Mframes()
	{
		parent::Model();
	}
	
	function get_frame_manufacturers(){
	    $result = array();
	    $query = $this->db->query('SELECT manufacturer, id FROM frame_manufacturers WHERE active = TRUE ORDER BY manufacturer asc');
		if ($query->num_rows() > 0) {	
			$result =  $query->result_array();
			return $result;
		}   
		
	}
	
	function get_frame_divisions($manufacturer){
	    $result = array();
	    $query = $this->db->query('SELECT division, id FROM frame_divisions WHERE active = TRUE AND manufacturer_id = \'' . $manufacturer . '\' ORDER BY division asc');
		if ($query->num_rows() > 0) {	
			$result =  $query->result_array();
			return $result;
		} 
	}
	
	function get_frames( $division ){
	    $result = array();
	    $query = $this->db->query('SELECT * FROM frames WHERE active = TRUE AND division_id = \'' . $division . '\' group by name ORDER BY name asc ');
		if ($query->num_rows() > 0) {	
			$result =  $query->result_array();
			return $result;
		} 
	}
	
	function delete_manufacturer( $manufacturer_id )
	{
		$data = array(
			'active' => 'FALSE'
		);
		$this->db->where( 'id', $manufacturer_id );
		$result = $this->db->update( 'frame_manufacturers', $data);
		
		return $result;
	}
	
	function delete_division( $manufacturer_id, $division )
	{
		$data = array(
			'active' => 'FALSE'
		);
		$this->db->where( 'manufacturer_id', $manufacturer_id );
		$this->db->where( 'division', $division );
		$result = $this->db->update( 'frame_divisions', $data);
		
		return $result;
	}
	
	function delete_frame( $frame_id )
	{
		$data = array(
			'active' => 'FALSE'
		);
		$this->db->where( 'id', $frame_id );
		$result = $this->db->update( 'frames', $data);
		
		return $result;
	}
	
	
	function add_manufacturer ( $manufacturer_name )
	{
		$this->db->select('manufacturer'  );
		$this->db->where('manufacturer', $manufacturer_name );
		$num_rows = $this->db->count_all_results('frame_manufacturers');
		
		if ( $num_rows <= 0 ) {
			$data = array( 
				'manufacturer' => $manufacturer_name
			);
			$result = $this->db->insert('frame_manufacturers', $data );
			return $result;
		}  
	}
	
	function add_division ( $manufacturer_id, $division_name )
	{
		$this->db->select('manufacturer'  );
		$this->db->where('manufacturer_id', $manufacturer_id );
		$this->db->where('division', $division_name );
		$num_rows = $this->db->count_all_results('frame_divisions');
		
		if ( $num_rows <= 0 ) {
			$data = array( 
				'manufacturer_id' => $manufacturer_id,
				'division' => $division_name
			);
			$result = $this->db->insert('frame_divisions', $data );
			return $result;
		}  
	}
	
	function add_frame ( $frame_division, $frame_name, $cost_price, $retail_price )
	{
		$this->db->where('division_id', $frame_division );
		$this->db->where('name', $frame_name );
		$num_rows = $this->db->count_all_results('frames');

		if ( $num_rows < 1 ) 
		{
			$data = array( 
				'division_id' => $frame_division,
				'name' => $frame_name,
				'cost_price' => $cost_price,
				'retail_price' => $retail_price
			);
			$result = $this->db->insert('frames', $data );
			return $result;
		}  		
	}
	
	function get_frame_price( $frame_id )
	{
		$this->db->select('retail_price');
		$this->db->where('id', $frame_id );
		$this->db->limit(1);
		$query = $this->db->get('frames');
		if ($query->num_rows() > 0) 
		{
			$row = $query->row();
			$frame_price = $row->retail_price;			
			//$result = array_merge(array("- - -"=>"- - - "),$result);
			return $frame_price;
		} else {
			return 'ERROR';
		}		
	}		function get_frame_color(){	    $result = array();	    $query = $this->db->query('SELECT color, id FROM frame_colors WHERE active = TRUE ORDER BY color asc');		if ($query->num_rows() > 0) {				$result =  $query->result_array();			return $result;		}  			}		function get_inventory_frame_manufacturers(){	    $result = array();	    $query = $this->db->query('SELECT manufacturer, id FROM frame_manufacturers WHERE active = TRUE ORDER BY manufacturer asc');		if ($query->num_rows() > 0) {				$result =  $query->result_array();			$result = array_merg