<?php

class Admin extends Controller {



	function Admin()

	{
		parent::Controller();
		
		$loadmyjs['extraHeadContent'] =	'<script type="text/javascript" src="' . base_url() . 'js/function_search.js"></script><script type="text/javascript" src="' . base_url() . 'js/prototype.js"></script><script type="text/javascript" src="' . base_url() . 'js/effects.js"></script><script type="text/javascript" src="' . base_url() . 'js/controls.js"></script>

		<!-- the scriptaculous javascript library is available at http://script.aculo.us/ --></script>';
		$this->load->vars($loadmyjs);		

	
		$this->load->library('Form_validation');

		$this->load->library('DX_Auth');
		$data['navlist'] = $this->mpages->getpages();	
	}

	

	function index()

	{ 
		$data['navlist'] = $this->mpages->getpages();

		$data['title'] = "Admin Section";
		$data['main'] = 'main';
		$this->load->vars($data);

		$this->load->view('template');

	}






}

?>