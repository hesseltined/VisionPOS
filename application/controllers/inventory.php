<?php
class Inventory extends Controller 
{

		// Used for registering and changing password form validation
		var $min_username = 3;
		var $max_username = 20;
		var $min_password = 5;
		var $max_password = 20;
                
		
	function Inventory()	{
		parent::Controller();
				
	    $buildheadercontent = '';
		
		$buildheadercontent .= '<link href="' . base_url() . 'css/default.css" rel="stylesheet" type="text/css">';
                $buildheadercontent .= '<link href="' . base_url() . 'css/table.css" rel="stylesheet" type="text/css">';
                $buildheadercontent .= '<link href="' . base_url() . 'js/UI/css/redmond/jquery-ui-1.8.11.custom.css" rel="stylesheet" type="text/css">';
	    //$buildheadercontent .= '<link href="' . base_url() . 'css/prettyCheckboxes.css" rel="stylesheet" type="text/css">';
		$buildheadercontent .= '<script type="text/javascript" src="' . base_url() . 'js/calendar/calendar.js"></script> ';
		$buildheadercontent .= '<script type="text/javascript" src="' . base_url() . 'js/calendar/lang/calendar-en.js"></script> ';
		$buildheadercontent .= '<script type="text/javascript" src="' . base_url() . 'js/calendar/calendar-setup.js"></script> ';
//		$buildheadercontent .= '<script type="text/javascript" src="' . base_url() . 'js/function_search.js"></script>';
	
		//$buildheadercontent .= '<script type="text/javascript" src="' . base_url() . 'js/effects.js"></script> ';
		//$buildheadercontent .= '<script type="text/javascript" src="' . base_url() . 'js/controls.js"></script> ';
		//$buildheadercontent .= '<script type="text/javascript" src="' . base_url() . 'js/jquery-1.5.1.min.js"></script> ';
		$buildheadercontent .= '<script type="text/javascript" src="' . base_url() . 'js/prettyCheckboxes.js"  charset="utf-8"></script>';
		$buildheadercontent .= '<script type="text/javascript" src="' . base_url() . 'js/ajax.js"  charset="utf-8"></script>';
                $buildheadercontent .= '<script type="text/javascript" src="' . base_url() . 'js/UI/js/jquery-ui-1.8.11.custom.min.js"  charset="utf-8"></script>';
                $buildheadercontent .= '<script type="text/javascript" src="' . base_url() . 'includes/lens_design.js"  charset="utf-8"></script>';
                $buildheadercontent .= '<script type="text/javascript" src="' . base_url() . 'includes/lens_materials.js"  charset="utf-8"></script>';
                $buildheadercontent .= '<script type="text/javascript" src="' . base_url() . 'includes/lens_types.js"  charset="utf-8"></script>';
                $buildheadercontent .= '<script type="text/javascript" src="' . base_url() . 'includes/lens_brands.js"  charset="utf-8"></script>';
		$buildheadercontent .= '<!-- the scriptaculous javascript library is available at http://script.aculo.us/ -->'; //</script>;

		$loadmyjs['extraHeadContent'] =	$buildheadercontent;
		$this->load->vars($loadmyjs);		
		$this->load->library('Form_validation'