<?php

class Minventory extends Model {



	function Minventory()

	{

		parent::Model();

	}
	
	function get_store_inventory( $store_id ){
	    $result = array();
	    $this->db->select('frames.frame_mfg as frame_mfg, frames.frame_division as frame_division, frames.frame_name as frame_name, inventory.frame_id as frame_id, inventory.store_id, inventory.quantity as quantity');
	    $this->db->where('store_id', $store_id);
	    $this->db->join('frames', 'frames.frame_id = inventory.frame_id', 'left');
	    $query = $this->db->get('inventory','','1');
		if ($query->num_rows() > 0) {	
			$result =  $query->result_array();
			//echo print_r($result);
			return $result;

		} 
	}

        public function report()
        {
            $sql = "  SELECT mfg.manufacturer, fd.division, f.name, color.color, fi.eye_size_min, fi.bridge_size, fi.temple_size, f.cost_price, f.retail_price, stores.name AS store_name
                      FROM frames f, frame_inventory fi, frame_manufacturers mfg, frame_divisions fd, frame_colors color, stores
                      WHERE f.id = fi.id
                      AND f.division_id = fd.id
                      AND fd.manufacturer_id = mfg.id
                      AND color.id = fi.color_id
                      AND stores.store_id = fi.store_id
                      AND fi.active = TRUE
                      ORDER BY manufacturer, division, store_name;";
            return $this->db->query($sql);
        }

        public function frame_sizes($frame_id, $color_id, $size)
        {
            $this->db->select($size);
            $this->db->distinct();
            $this->db->where("frame_id", $frame_id);
            $this->db->where("color_id", $color_id);

            return $this->db->get("frame_inventory");
        }
	

	
	
}
?>