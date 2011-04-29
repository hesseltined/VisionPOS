<?php

class Msettings extends Model {



	function Msettings()

	{

		parent::Model();

	}



	function sphere_params ()

	{
		$this->db->select('sphere_min AS min, sphere_max AS max, sphere_increment AS increment, sphere_decimals AS decimals, sphere_signed AS signed, sphere_default AS default_value, sphere_blank AS blank');
		$this->db->limit(1);
		$query = $this->db->get('settings');
		if ($query->num_rows() > 0) 
		{
			$sphere = $query->row();
			return $sphere;
		} else {
			return 0;
		}
	}
	
	function cylinder_params ()
	{
		$this->db->select('cylinder_min AS min, cylinder_max AS max, cylinder_increment AS increment, cylinder_decimals AS decimals, cylinder_signed AS signed, sphere_default AS default_value, sphere_blank AS blank');
		$this->db->limit(1);
		$query = $this->db->get('settings');
		if ($query->num_rows() > 0) 
		{
			$cylinder = $query->row();
			return $cylinder;
		} else {
			return 0;
		}
	}
	
	function bridge_params ()
	{
		$this->db->select('bridge_min AS min, bridge_max AS max, bridge_increment AS increment, bridge_decimals AS decimals, bridge_signed AS signed, sphere_default AS default_value, sphere_blank AS blank');
		$this->db->limit(1);
		$query = $this->db->get('settings');
		if ($query->num_rows() > 0) 
		{
			$bridge = $query->row();
			return $bridge;
		} else {
			return 0;
		}
	}

	function add_params ()
	{
		$this->db->select('add_min AS min, add_max AS max, add_increment AS increment, add_decimals AS decimals, add_signed AS signed, add_default AS default_value, add_blank AS blank');
		$this->db->limit(1);
		$query = $this->db->get('settings');
		if ($query->num_rows() > 0) 
		{
			$add = $query->row();
			return $add;
		} else {
			return 0;
		}
	}
	
	function prism_params ()
	{
		$this->db->select('prism_min AS min, prism_max AS max, prism_increment AS increment, prism_decimals AS decimals, prism_signed AS signed, prism_default AS default_value, prism_blank AS blank');
		$this->db->limit(1);
		$query = $this->db->get('settings');
		if ($query->num_rows() > 0) 
		{
			$prism = $query->row();
			return $prism;
		} else {
			return 0;
		}
	}	
		
	function axis_params ()
	{
		$this->db->select('axis_min AS min, axis_max AS max, axis_increment AS increment, axis_decimals AS decimals, axis_signed AS signed, axis_default AS default_value, axis_blank AS blank');
		$this->db->limit(1);
		$query = $this->db->get('settings');
		if ($query->num_rows() > 0) 
		{
			$axis = $query->row();
			return $axis;
		} else {
			return 0;
		}
	}

	function pd_params ()
	{
		$this->db->select('pd_min AS min, pd_max AS max, pd_increment AS increment, pd_decimals AS decimals, pd_signed AS signed, pd_default AS default_value, pd_blank AS blank');
		$this->db->limit(1);
		$query = $this->db->get('settings');
		if ($query->num_rows() > 0) 
		{
			$pd = $query->row();
			return $pd;
		} else {
			return 0;
		}
	}

	function temple_length_params ()
	{
		$this->db->select('temple_length_min AS min, temple_length_max AS max, temple_length_increment AS increment, temple_length_decimals AS decimals, temple_length_signed AS signed, temple_length_default AS default_value, temple_length_blank AS blank');
		$this->db->limit(1);
		$query = $this->db->get('settings');
		if ($query->num_rows() > 0) 
		{
			$temple_length = $query->row();
			return $temple_length;
		} else {
			return 0;
		}
	}
	
	function segment_height_params ()
	{
		$this->db->select('segment_height_min AS min, segment_height_max AS max, segment_height_increment AS increment, segment_height_decimals AS decimals, segment_height_signed AS signed, segment_height_default AS default_value, segment_height_blank AS blank');
		$this->db->limit(1);
		$query = $this->db->get('settings');
		if ($query->num_rows() > 0) 
		{
			$segment_height = $query->row();
			return $segment_height;
		} else {
			return 0;
		}
	}

	function lens_a_params ()
	{
		$this->db->select('lens_a_min AS min, lens_a_max AS max, lens_a_increment AS increment, lens_a_decimals AS decimals, lens_a_signed AS signed, lens_a_default AS default_value, lens_a_blank AS blank');
		$this->db->limit(1);
