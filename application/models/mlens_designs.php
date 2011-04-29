<?php

class Mlens_designs extends Model {



	function Mlens_designs()

	{

		parent::Model();

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
            $result = $this->db->get("lens_designs");
            return $result->row()->total;
        }
        /*
         * Returns lens designs resultset
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

           

            if ($start >= 0 )
                $this->db->limit($limit, $start);

            $this->db->select("lens_designs.design,
                               lens_brands.brand,
                               lens_designs.brand_id,
                               lens_designs.id");
            
            $this->db->from("lens_designs");
            $this->db->join("lens_brands", "lens_designs.brand_id = lens_brands.id");
            return $this->db->get();
        }
        /*
         * Returns the lens row given the id
         */
        public function get($id)
        {
            $this->db->where("lens_designs.id", $id);
            $this->db->select("lens_designs.design,
                               lens_brands.brand,
                               lens_designs.brand_id,
                               lens_designs.id");

            $this->db->from("lens_designs");
            $this->db->join("lens_brands", "lens_designs.brand_id = lens_brands.id");
            return $this->db->get()->row();
        }
        /*
         * Inserts new lens material row
         * returns the inserted id
         */
        public function insert($data)
        {
            $this->db->insert("lens_designs", $data);
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
            $this->db->update("lens_designs", $data);
        }

        public function delete($id)
        {
            $this->db->where("id", $id);
            $this->db->delete("lens_designs");
        }
       






	function get_list_designs(){
	    $result = array();
	    $query = $this->db->query('SELECT * FROM lens_designs WHERE active = TRUE ORDER BY design asc');
		if ($query->num_rows() > 0) {	
			$result =  $query->result_array();
			return $result;
		} 
	}
	
	function delete_lens_design( $design )
	{
		$data = array(
			'active' => 'FALSE'
		);
		$this->db->where( 'design', $design );
		$result = $this->db->update( 'lens_designs', $data);
		
		return $result;
	}
	
	function add_lens_design ( $design )
	{
		$this->db->where('design', $design );
		$num_rows = $this->db->count_all_results('lens_designs');

		if ( $num_rows < 1 ) 
		{
			$data = array( 
				'design' => $design
			);
			$result = $this->db->insert('lens_designs', $data );
			return $result;
		}  		
	}

	
	
}
?>