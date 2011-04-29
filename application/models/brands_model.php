<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

    class Brands_model extends Model
    {
        public function Brands_model()
        {
            parent::Model();
        }

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
            $result = $this->db->get("lens_brands");
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
            if ($start >= 0)
                $this->db->limit($limit, $start);

            $this->db->select("lens_brands.brand,
                               lens_types.type,
                               lens_brands.type_id,
                               lens_brands.id");

            $this->db->from("lens_brands");
            $this->db->join("lens_types", "lens_brands.type_id = lens_types.id");
            return $this->db->get();
        }
        /*
         * Returns the lens row given the id
         */
        public function get($id)
        {
             $this->db->select("lens_brands.brand,
                               lens_types.type,
                               lens_brands.type_id,
                               lens_brands.id");

            $this->db->from("lens_brands");
            $this->db->join("lens_types", "lens_brands.type_id = lens_types.id");
            return $this->db->get()->row();
        }
        /*
         * Inserts new lens material row
         * returns the inserted id
         */
        public function insert($data)
        {
            $this->db->insert("lens_brands", $data);
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
            $this->db->update("lens_brands", $data);
        }

        public function delete($id)
        {
            $this->db->where("id", $id);
            $this->db->delete("lens_brands");
        }
        
    }
?>
