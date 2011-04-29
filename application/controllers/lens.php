<?php

class Lens extends Controller
{
	/**
	 * Lens Constructor
	 */
	function Lens()
	{
		parent::Controller();
		
		$this->load->library('DX_Auth');
	}
	
	/**
	 * Action index
	 */
	function index()
	{
		if ($this->dx_auth->is_logged_in())
			redirect('/lens/edit', 'refresh');
		else
			redirect('/main/login', 'refresh');
	}
	
	/**
	 * Action edit
	 * Loads the /lens/edit view
	 */
	function edit()
	{
		if ( ! $this->dx_auth->is_logged_in())
		{
			redirect('/main/login', 'refresh');
			return;
		}
		
		$this->load->helper('html');
		
		$data = array();
		$data['extraHeadContent'] = link_tag('css/default.css')
									. '<script type="text/javascript" src="'.base_url().'js/jquery-1.3.2.js"></script>'; 
		$data['title'] = $this->lang->line('system_name');
		$data['main'] = 'lens/edit';
		
		$this->load->vars($data);
		$this->load->view('template');
	}
	
	/**
	 * POST /lens/types
	 */
	function types()
	{
		if ( ! $this->dx_auth->is_logged_in())
			return;
		
		$this->load->model('mlens');
		
		$result = $this->mlens->getTypes();
		
		echo json_encode(array('result' => $result));
	}
	
	/**
	 * POST /lens/brands
	 */
	function brands()
	{
		if ( ! $this->dx_auth->is_logged_in())
			return;
		
		$type_id = isset($_POST['type_id']) && is_numeric($_POST['type_id']) ? (int) $_POST['type_id'] : NULL;
		
		$result = array();
		
		if ($type_id !== NULL)
		{
			$this->load->model('mlens');
			
			$result = $this->mlens->getBrandsByTypeId($type_id);	
		}
		
		echo json_encode(array('result' => $result));
	}
	
	/**
	 * POST /lens/designs
	 */
	function designs()
	{
		if ( ! $this->dx_auth->is_logged_in())
			return;
		
		$brand_id = isset($_POST['brand_id']) && is_numeric($_POST['brand_id']) ? (int) $_POST['brand_id'] : NULL;
		
		$result = array();
		
		if ($brand_id !== NULL)
		{
			$this->load->model('mlens');
			
			$result = $this->mlens->getDesignsByBrandId($brand_id);
		}
		
		echo json_encode(array('result' => $result));
	}
	
	/**
	 * POST /lens/materials
	 */
	function materials()
	{
		if ( ! $this->dx_auth->is_logged_in())
			return;
			
		$design_id = isset($_POST['design_id']) && is_numeric($_POST['design_id']) ? (int) $_POST['design_id'] : NULL;
		$material_id = isset($_POST['material_id']) && is_numeric($_POST['material_id']) ? (int) $_POST['material_id'] : NULL;
		$retail_price = isset($_POST['retail_price']) && is_numeric($_POST['retail_price']) ? (float) $_POST['retail_price'] : NULL;
		$cost_price = isset($_POST['cost_price']) && is_numeric($_POST['cost_price']) ? (float) $_POST['cost_price'] : NULL;
		
		$result = array();
		
		if ($design_id !== NULL)
		{
			$this->load->model('mlens');
			
			$result = $this->mlens->getMaterialsByDesignId($design_id);
		}
		elseif ($material_id !== NULL && $retail_price !== NULL && $cost_price !== NULL)
		{
			$this->load->model('mlens');
			
			$result = $this->mlens->updateMaterialPriceById($material_id, $cost_price, $retail_price);
		}
		elseif ($material_id !== NULL)
		{
			$this->load->model('mlens');
			
			$result = $this->mlens->getMaterialById($material_id);
		}
		
		echo json_encode(array('result' => $result));
	}
}