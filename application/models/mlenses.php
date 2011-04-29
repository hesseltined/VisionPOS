<?php

class Mlenses extends Model {



	function Mlenses()

	{

		parent::Model();

	}



	function get_lens_price ( $id )

	{
		$this->db->select('retail_price');
		$this->db->where('id', $id );
		$this->db->limit(1);
		$query = $this->db->get('lens_pricing');
		if ($query->num_rows() > 0) 
		{
			$row = $query->row();
			$lens_price = $row->retail_price;
			return $lens_price;
		} else {
			return 'ERROR';
		}		
	}

	function get_lens_id ( $order_id )
	{
		$query = $this->db->query( 'select lp.lens_id FROM lens_pricing lp, orders o WHERE o.order_id = \'' . $order_id . '\' AND o.lens_design = lp.lens_design AND o.lens_material = lp.lens_material AND o.lens_type = lp.lens_type');
		if ($query->num_rows() > 0) 
		{
			$row = $query->row();
			$lens_id = $row->lens_id;
			return $lens_id;
		} else {
			return 'ERROR';
		}		
	}
	
	

}





?>