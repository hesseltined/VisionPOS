<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Code Igniter
 *
 * An open source application development framework for PHP 4.3.2 or newer
 *
 * @package		CodeIgniter
 * @author		Rick Ellis
 * @copyright	Copyright (c) 2006, pMachine, Inc.
 * @license		http://www.codeignitor.com/user_guide/license.html
 * @link		http://www.codeigniter.com
 * @since		Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * Code Igniter AJAX Class
 *
 * This class enables you to integrate AJAX into your web apps.
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Libraries
 * @author		Siric
 * @link		http://www.no-link-yet.com
 */

class JavaScript {

	function button_to_function($name,$function=null)
	{
		return '<input type="button" value="'.$name.'" onclick="'.$function.'" />';
	}

	function escape($javascript)
	{
		$javascript=str_replace(array("\r\n","\n","\r"),array("\n"),$javascript);
		$javascript=addslashes($javascript);
		return $javascript;
	}

	function tag($content)
	{
		return '<script type="text/javascript">'.$content.'</script>';
	}

	function link_to_function($name,$function,$html_options=null)
	{
		return '<a href="'.((isset($html_options['href']))?$html_options['href']:'#').'" onclick="'.((isset($html_options['onclick']))?$html_options['onclick'].';':'').$function.'; return false;" /