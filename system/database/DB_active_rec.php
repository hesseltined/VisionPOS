<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 4.3.2 or newer
 *
 * @package		CodeIgniter
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2008 - 2009, EllisLab, Inc.
 * @license		http://codeigniter.com/user_guide/license.html
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * Active Record Class
 *
 * This is the platform-independent base Active Record implementation class.
 *
 * @package		CodeIgniter
 * @subpackage	Drivers
 * @category	Database
 * @author		ExpressionEngine Dev Team
 * @link		http://codeigniter.com/user_guide/database/
 */
class CI_DB_active_record extends CI_DB_driver {

	var $ar_select				= array();
	var $ar_distinct			= FALSE;
	var $ar_from				= array();
	var $ar_join				= array();
	var $ar_where				= array();
	var $ar_like				= array();
	var $ar_groupby				= array();
	var $ar_having				= array();
	var $ar_limit				= FALSE;
	var $ar_offset				= FALSE;
	var $ar_order				= FALSE;
	var $ar_orderby				= array();
	var $ar_set					= array();	
	var $ar_wherein				= array();
	var $ar_aliased_tables		= array();
	var $ar_store_array			= array();
	
	// Active Record Caching variables
	var $ar_caching 			= FALSE;
	var $ar_cache_exists		= array();
	var $ar_cache_select		= array();
	var $ar_cache_from			= array();
	var $ar_cache_join			= array();
	var $ar_cache_where			= array();
	var $ar_cache_like			= array();
	var $ar_cache_groupby		= array();
	var $ar_cache_having		= array();
	var $ar_cache_orderby		= array();
	var $ar_cache_set			= array();	


	// --------------------------------------------------------------------

	/**
	 * Select
	 *
	 * Generates the SELECT portion of the query
	 *
	 * @access	public
	 * @param	string
	 * @return	object
	 */
	function select($select = '*', $escape = NULL)
	{
		// Set the global value if this was sepecified	
		if (is_bool($escape))
		{
			$this->_protect_identifiers = $escape;
		}
		
		if (is_string($select))
		{
			$select = explode(',', $select);
		}

		foreach ($select as $val)
		{
			$val = trim($val);

			if ($val != '')
			{
				$this->ar_select[] = $val;

				if ($this->ar_caching === TRUE)
				{
					$this->ar_cache_select[] = $val;
					$this->ar_cache_exists[] = 'select';
				}
			}
		}
		return $this;
	}

	// --------------------------------------------------------------------

	/**
	 * Select Max
	 *
	 * Generates a SELECT MAX(field) portion of a query
	 *
	 * @access	public
	 * @param	string	the field
	 * @param	string	an alias
	 * @return	object
	 */
	function select_max($select = '', $alias = '')
	{
		return $this->_max_min_avg_sum($select, $alias, 'MAX');
	}
		
	// --------------------------------------------------------------------

	/**
	 * Select Min
	 *
	 * Generates a