<?php

class Mlens_materials extends Model {



	function Mlens_materials()

	{

		parent::Model();

	}
	
	function get_list_materials(){
	    $result = array();
	    $query = $this->db->query('SELECT * FROM lens_materials WHERE active = TRUE ORDER BY material asc');
		if ($query->num_rows() > 0) {	
			$result =  $query->result_array();
			return $result;
		} 
	}


        /*
         * Returns count/number of lens materials available
         * Param $args = array key value for filtering result
         */
        public function count($args = NULL)
        {
            if (is_array($args))
            {
                foreach ($args as $field => $value)
                {
                    $this->db->where($field, $value);
                }
            }

            $this->db->select("count(*) AS 'total'");
            $result = $this->db->get("lens_materials");
            return $result->row()->total;
        }
        /*
         * Returns lens materials result
         * Param $start = starting index
         * Param $limit = number of rows to return
         * Param $args  = fields to filter
         */
        public function select($start = NULL, $limit = NULL, $args = NULL)
        {
            if (is_array($args))
            {
                foreach ($args as $field => $value)
                {
                    $this->db->where($field, $value);
                }
            }
            if ($start>=0)
                $this->db->limit($limit, $start);

            $this->db->select("lens_designs.design,
                               lens_materials.design_id,
                               lens_materials.id,
                               lens_materials.material,
                               lens_materials.retail_price,
                               lens_materials.cost_price,
                               lens_materials.active");
            $this->db->from("lens_materials");
            $this->db->join("lens_designs", "lens_designs.id = lens_materials.design_id", "left");
            return $this->db->get();
        }
        /*
         * Returns the lens row given the id
         */
        public function get($id)
        {
            $this->db->where("lens_materials.id", $id);
            $this->db->select("lens_designs.design,
                               lens_materials.design_id,
                               lens_materials.id,
                               lens_materials.material,
                               lens_materials.retail_price,
                               lens_materials.cost_price,
                               lens_materials.active");
            $this->db->from("lens_materials");
            $this->db->join("lens_designs", "lens_designs.id = lens_materials.design_id", "left");
            return $this->db->get()->row();
        }
        /*
         * Inserts new lens material row
         * returns the inserted id
         */
        public function insert($data)
        {
            $this->db->insert("lens_materials", $data);
            return $this->db->insert_id();
        }
        /*
         * Updates a lens material row
         * Param $id - the id of the row to update
         * Param $data - the key value array of columns to update
         */
        public function update($id, $data)
        {
            $this->db->where("id", $id);
            $this->db->update("lens_materials", $data);
        }

        public function delete($id)
        {
            $this->db->where("id", $id);
            $this->db->delete("lens_materials");
        }

	function delete_lens_material( $material )
	{
		$data = array(
			'active' => 'FALSE'
		);
		$this->db->where( 'material', $material );
		$result = $this->db->update( 'lens_materials', $data);
		
		return $result;
	}
	
	function add_lens_material ( $material )
	{
		$this->db->where('material', $material );
		$num_rows = $this->db->count_all_results('lens_materials');

		if ( $num_rows < 1 ) 
		{
			$data = array( 
				'material' => $material
			);
			$result = $this->db->insert('lens_materials', $data );
			ret