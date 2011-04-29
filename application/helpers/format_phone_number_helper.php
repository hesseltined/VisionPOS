<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
* CodeIgniter My Text Helpers
*
* @package    CodeIgniter
* @subpackage    Helpers
* @category    Helpers
* @author    Hermawan Haryanto
* @link    not yet approved
*/

/**
* US Phone Number Formating
*
* Format Integer into US Phone Number
* (xxx) xxx-xxxx
*
* @access    public
* @param    string
* @return    string
*/   
function format_phone_number($number)
	{
	return preg_replace("/^[\+]?[1]?[- ]?[\(]?([2-9][0-8][0-9])[\)]?[- ]?([2-9][0-9]{2})[- ]?([0-9]{4})$/", "(\\1) \\2-\\3", $number);
	} 