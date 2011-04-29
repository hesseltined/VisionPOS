<?php
/**
 * This is used my lens controller
 */
class Mlens extends Model
{
	/**
	 * Returns all active lens types
	 * @return array
	 */
	function getTypes()
	{	
		return $this->db->query('SELECT id, type FROM lens_types WHERE active = 1')
						->result();
	}
	
	/**
	 * Returns all active brands by type id
	 * @param int $type_id
	 * @return array
	 */
	function getBrandsByTypeId($type_id)
	{
		return $this->db->query('SELECT id, brand FROM lens_brands WHERE type_id = ? AND active = 1', array($type_id))
						->result();
	}
	
	/**
	 * Returns all active designs by brand id
	 * @param int $brand_id
	 * @return array
	 */
	function getDesignsByBrandId($brand_id)
	{
		return $this->db->query('SELECT id, design FROM lens_designs WHERE brand_id = ? AND active = 1', array($brand_id))
						->result();
	}
	
	/**
	 * Returns active material by id
	 * @param int $material_id
	 * @return array
	 */
	function getMaterialById($material_id)
	{
		return $this->db->query('SELECT id, design_id, material, retail_price, cost_price FROM lens_materials
								WHERE id = ? AND active = 1 LIMIT 1',
								array($material_id))->result();
	}
	
	/**
	 * Returns all active materials by design id
	 * @param int $design_id
	 * @return array
	 */
	function getMaterialsByDesignId($design_id)
	{
		return $this->db->query('SELECT id, material FROM lens_materials WHERE design_id = ? AND active = 1', array($design_id))
						->result();
	}
	
	/**
	 * Updates a material price by id
	 * @param int $material_id
	 * @param float $cost_price
	 * @param float $retail_price
	 * @return array
	 */
	function updateMaterialPriceById($material_id, $cost_price, $retail_price)
	{	
		$this->db->query('UPDATE lens_materials SET cost_price = ?, retail_price = ? WHERE id = ?',
						 array($cost_price, $retail_price, $material_id));
		return array('affected_rows' => $this->db->affected_rows());
	}
}