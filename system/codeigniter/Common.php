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
* Determines if the current version of PHP is greater then the supplied value
*
* Since there are a few places where we conditionally test for PHP > 5
* we'll set a static variable.
*
* @access	public
* @param	string
* @return	bool
*/
function is_php($version = '5.0.0')
{
	static $_is_php;
	$version = (string)$version;
	
	if ( ! isset($_is_php[$version]))
	{
		$_is_php[$version] = (version_compare(PHP_VERSION, $version) < 0) ? FALSE : TRUE;
	}

	return $_is_php[$version];
}

// ------------------------------------------------------------------------

/**
 * Tests for file writability
 *
 * is_writable() returns TRUE on Windows servers when you really can't write to 
 * the file, based on the read-only attribute.  is_writable() is also unreliable
 * on Unix servers if safe_mode is on. 
 *
 * @access	private
 * @return	void
 */
function is_really_writable($file)
{	
	// If we're on a Unix server with safe_mode off we call is_writable
	if (DIRECTORY_SEPARATOR == '/' AND @ini_get("safe_mode") == FALSE)
	{
		return is_writable($file);
	}

	// For windows servers and safe_mode "on" installations we'll actually
	// write a file then read it.  Bah...
	if (is_dir($file))
	{
		$file = rtrim($file, '/').'/'.md5(rand(1,100));

		if (($fp = @fopen($file, FOPEN_WRITE_CREATE)) === FALSE)
		{
			return FALSE;
		}

		fclose($fp);
		@chmod($file, DIR_WRITE_MODE);
		@unlink($file);
		return TRUE;
	}
	elseif (($fp = @fopen($file, FOPEN_WRITE_CREATE)) === FALSE)
	{
		return FALSE;
	}

	fclose($fp);
	return TRUE;
}

// ------------------------------------------------------------------------

/**
* Class registry
*
* This function acts as a singleton.  If the requested class does not
* exist it is instantiated and set to a static variable.  If it has
* previously been instantiated the variable is returned.
*
* @access	public
* @param	string	the class name being requested
* @param	bool	optional flag that lets classes get loaded but not instantiated
* @return	object
*/
function &load_class($class, $instantiate = TRUE)
{
	static $objects = array();

	// Does the class exist?  If so, we're done...
	if (isset($objects[$class]))
	{
		return $objects[$class];
	}

	// If the requested class does not exist in the application/libraries
	// folder we'll load the native class from the system/libraries folder.	
	if (file_exists(APPPATH.'libraries/'.config_item('subclass_prefix').$class.EXT))
	{
		require(BASEPATH.'libraries/'.$class.EXT);
		require(APPPATH.'libraries/'.config_item('subclass_prefix').$class.EXT);
		$is_subclass = TRUE;
	}
	else
	{
		if (file_exists(APPPATH.'libraries/'.$class.EXT))
		{
			require(APPPATH.'libraries/'.$class.EXT);
			$is_subclass = FALSE;
		}
		else
		{
			require(BASEPATH.'libraries/'.$class.EXT);
			$is_subclass = FALSE;
		}
	}

	if ($instantiate == FALSE)
	{
		$objects[$class] = TRUE;
		return $objects[$class];
	}

	if ($is_subclass == TRUE)
	{
		$name = config_item('subclass_prefix').$class;

		$objects[$class] =& instantiate_class(new $name());
		return $objects[$class];
	}

	$name = ($class != 'Controller') ? 'CI_'.$class : $class;

	$objects[$class] =& instantiate_class(new $name());
	return $objects[$class];
}

/**
 * Instantiate Class
 *
 * Returns a new class object by reference, used by load_class() and the DB class.
 * Required to retain PHP 4 compatibility and also not make PHP 5.3 cry.
 *
 * Use: $obj =& instantiate_class(new Foo());
 * 
 * @access	public
 * @param	object
 * @return	object
 */
function &instantiate_class(&$class_object)
{
	return $class_object;
}

/**
* Loads the main config.php file
*
* @acce