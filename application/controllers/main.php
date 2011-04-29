<?php
class Main extends Controller 
{

		// Used for registering and changing password form validation
		var $min_username = 3;
		var $max_username = 20;
		var $min_password = 5;
		var $max_password = 20;	
		
	function Main()	{
		parent::Controller();
				
	    $buildheadercontent = '';
		
		$buildheadercontent .= '<link href="' . base_url() . 'css/cssReset.css" rel="stylesheet" type="text/css">';
		$buildheadercontent .= '<link href="' . base_url() . 'css/default.css" rel="stylesheet" type="text/css">';
	
		//take user to the login page when session expires. 
		$buildheadercontent .= '<meta http-equiv="Refresh" content="' . $this->config->item('sess_expiration') . ';url=' . base_url() . 'auth/login">';
		
	    //$buildheadercontent .= '<link href="' . base_url() . 'css/prettyCheckboxes.css" rel="stylesheet" type="text/css">';
		//$buildheadercontent .= '<script type="text/javascript" src="' . base_url() . 'js/jquery-1.3.2.js"></script> ';
		$buildheadercontent .= '<script type="text/javascript" src="' . base_url() . 'js/calendar/calendar.js"></script> ';
		$buildheadercontent .= '<script type="text/javascript" src="' . base_url() . 'js/calendar/lang/calendar-en.js"></script> ';
		$buildheadercontent .= '<script type="text/javascript" src="' . base_url() . 'js/calendar/calendar-setup.js"></script> ';
//		$buildheadercontent .= '<script type="text/javascript" src="' . base_url() . 'js/function_search.js"></script>';
		//$buildheadercontent .= '<script type="text/javascript" src="' . base_url() . 'js/prototype.js"></script> '; @DOUG 16-09-2010 conflict with JQUERY library
//		$buildheadercontent .= '<script type="text/javascript" src="' . base_url() . 'js/effects.js"></script> ';
//		$buildheadercontent .= '<script type="text/javascript" src="' . base_url() . 'js/controls.js"></script> ';
		
		$buildheadercontent .= '<script type="text/javascript" src="' . base_url() . 'js/prettyCheckboxes.js"  charset="utf-8"></script>';
		//$buildheadercontent .= '<!-- the scriptaculous javascript library is available at http://script.aculo.us/ -->'; //</script>;

		//echo '<script type="text/javascript">  var _gaq = _gaq || [];  _gaq.push([''_setAccount'', ''UA-5136386-9'']); _gaq.push([''_trackPageview'']);  (function() {    var ga = document.createElement(''script''); ga.type = ''text/javascript''; ga.async = true;    ga.src = (''https:'' == document.location.protocol ? ''https://ssl'' : ''http://www'') + ''.google-analytics.com/ga.js'';    var s = document.getElementsByTagName ''script'')[0]; s.parentNode.insertBefore(ga, s);  })(); </script>';

		$loadmyjs['extraHeadContent'] =	$buildheadercontent;
		$this->load->vars($loadmyjs);		
		$this->load->library('Form_validation');
		$this->load->library('DX_Auth');
		$this->load->library('Table');
		$this->load->library('Pagination');
		
		$this->load->helper('form');
		$this->load->helper('url');
		
		// $this->config->item('sess_expi