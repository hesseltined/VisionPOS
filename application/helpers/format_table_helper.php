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
function format_table($table)
	{
	$this->load->library('table' $table);
	} 