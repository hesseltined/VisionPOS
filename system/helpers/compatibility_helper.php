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
 * CodeIgniter Compatibility Helpers
 *
 * This helper contains some functions based on the PEAR PHP_Compat library
 * http://pear.php.net/package/PHP_Compat
 * 
 * The PEAR compat library is a little bloated and the code doesn't harmonize
 * well with CodeIgniter, so those functions have been refactored.
 * We cheat a little and use CI's _exception_handler() to output our own PHP errors
 * so that the behavior fully mimicks the PHP 5 counterparts.  -- Derek Jones
 * 
 * @package		CodeIgniter
 * @subpackage	Helpers
 * @category	Helpers
 * @author		ExpressionEngine Dev Team
 * @link		http://codeigniter.com/user_guide/helpers/compatibility_helper.html
 */

// ------------------------------------------------------------------------

if ( ! defined('PHP_EOL'))
{
	define('PHP_EOL', (DIRECTORY_SEPARATOR == '/') ? "\n" : "\r\n");
} 

// ------------------------------------------------------------------------

/**
 * file_put_contents()
 *
 * Writes a string to a file
 * http://us.php.net/manual/en/function.file_put_contents.php
 * argument 4, $context, not supported
 *
 * @access	public
 * @param	string		file name
 * @param	mixed		data to be written
 * @param	int			flags
 * @return	int			length of written string
 */
if ( ! function_exists('file_put_contents'))
{
	function file_put_contents($filename, $data, $flags = NULL)
	{
		if (is_scalar($data))
		{
			settype($data, 'STRING');
		}

		if ( ! is_string($data) && ! is_array($data) && ! is_resource($data))
		{
			$backtrace = debug_backtrace();
			_exception_handler(E_USER_WARNING, 'file_put_contents(): the 2nd parameter should be either a string or an array', $backtrace[0]['file'], $backtrace[0]['line']);
			return FALSE;
		}

		// read stream if given a stream resource
		if (is_resource($data))
		{
			if (get_resource_type($data) !== 'stream')
			{
				$backtrace = debug_backtrace();
				_exception_handler(E_USER_WARNING, 'file_put_contents(): supplied resource is not a valid stream resource', $backtrace[0]['file'], $backtrace[0]['line']);
				return FALSE;
			}

			$text = '';
			
			while ( ! feof($data))
			{
				$text .= fread($data, 4096);
			}
			
			$data = $text;
			unset($text);
		}
	
		// strings only please!
		if (is_array($data))
		{
			$data = implode('', $data);
		}

		// Set the appropriate mode
		if (($flags & 8) > 0) // 8 = FILE_APPEND flag
		{
			$mode = FOPEN_WRITE_CREATE;
		}
		else
		{
			$mode = FOPEN_WRITE_CREATE_DESTRUCTIVE;
		}
	
		// Check if we're using the include path
		if (($flags & 1) > 0) // 1 = FILE_USE_INCLUDE_PATH flag
		{
			$use_include_path = TRUE;
		}
		else
		{
			$use_include_path = FALSE;
		}
	
		$fp = @fopen($filename, $mode, $use_include_path);
	
		if ($fp === FALSE)
		{
			$backtrace = debug_backtrace();
			_exception_handler(E_USER_WARNING, 'file_put_contents('.htmlentities($filename).') failed to open stream', $backtrace[0]['file'], $backtrace[0]['line']);
			return FALSE;
		}
	
		if (($flags & LOCK_EX) > 0)
		{
			if ( ! flock($fp, LOCK_EX))
			{
				$backtrace = debug_backtrace();
				_exception_handler(E_USER_WARNING, 'file_put_contents('.htmlentities($filename).') unable to acquire an exclusive lock on file', $backtrace[0]['file'], $backtrace[0]['line']);
				return FALSE;
			}
		}
		
		// write it
		if (($written = @fwrite($fp, $data)) === FALSE)
		{
			$backtrace = debug_backtrace();
			_exception_handler(E_USER_WARNING, 'file_put_contents('.htmlentities($filename).') failed to write to '.htmlentities($filename), $backtrace[0]['file'], $backtrace[0]['line']);
		}
	
		// Close the handle
		@fclose($fp);
	
		// Return lengt