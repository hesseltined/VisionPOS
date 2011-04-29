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
 * CodeIgniter Text Helpers
 *
 * @package		CodeIgniter
 * @subpackage	Helpers
 * @category	Helpers
 * @author		ExpressionEngine Dev Team
 * @link		http://codeigniter.com/user_guide/helpers/text_helper.html
 */

// ------------------------------------------------------------------------

/**
 * Word Limiter
 *
 * Limits a string to X number of words.
 *
 * @access	public
 * @param	string
 * @param	integer
 * @param	string	the end character. Usually an ellipsis
 * @return	string
 */	
if ( ! function_exists('word_limiter'))
{
	function word_limiter($str, $limit = 100, $end_char = '&#8230;')
	{
		if (trim($str) == '')
		{
			return $str;
		}
	
		preg_match('/^\s*+(?:\S++\s*+){1,'.(int) $limit.'}/', $str, $matches);
			
		if (strlen($str) == strlen($matches[0]))
		{
			$end_char = '';
		}
		
		return rtrim($matches[0]).$end_char;
	}
}
	
// ------------------------------------------------------------------------

/**
 * Character Limiter
 *
 * Limits the string based on the character count.  Preserves complete words
 * so the character count may not be exactly as specified.
 *
 * @access	public
 * @param	string
 * @param	integer
 * @param	string	the end character. Usually an ellipsis
 * @return	string
 */	
if ( ! function_exists('character_limiter'))
{
	function character_limiter($str, $n = 500, $end_char = '&#8230;')
	{
		if (strlen($str) < $n)
		{
			return $str;
		}
		
		$str = preg_replace("/\s+/", ' ', str_replace(array("\r\n", "\r", "\n"), ' ', $str));

		if (strlen($str) <= $n)
		{
			return $str;
		}

		$out = "";
		foreach (explode(' ', trim($str)) as $val)
		{
			$out .= $val.' ';
			
			if (strlen($out) >= $n)
			{
				$out = trim($out);
				return (strlen($out) == strlen($str)) ? $out : $out.$end_char;
			}		
		}
	}
}
	
// ------------------------------------------------------------------------

/**
 * High ASCII to Entities
 *
 * Converts High ascii text and MS Word special characters to character entities
 *
 * @access	public
 * @param	string
 * @return	string
 */	
if ( ! function_exists('ascii_to_entities'))
{
	function ascii_to_entities($str)
	{
	   $count	= 1;
	   $out	= '';
	   $temp	= array();
	
	   for ($i = 0, $s = strlen($str); $i < $s; $i++)
	   {
		   $ordinal = ord($str[$i]);
	
		   if ($ordinal < 128)
		   {
				/*
					If the $temp array has a value but we have moved on, then it seems only
					fair that we output that entity and restart $temp before continuing. -Paul
				*/
				if (count($temp) == 1)
				{
					$out  .= '&#'.array_shift($temp).';';
					$count = 1;
				}

				$out .= $str[$i];
		   }
		   else
		   {
			   if (count($temp) == 0)
			   {
				   $count = ($ordinal < 224) ? 2 : 3;
			   }
		
			   $temp[] = $ordinal;
		
			   if (count($temp) == $count)
			   {
				   $number = ($count == 3) ? (($temp['0'] % 16) * 4096) + (($temp['1'] % 64) * 64) + ($temp['2'] % 64) : (($temp['0'] % 32) * 64) + ($temp['1'] % 64);

				   $out .= '&#'.$number.';';
				   $count = 1;
				   $temp = array();
			   }
		   }
	   }

	   return $out;
	}
}
	
// ------------------------------------------------------------------------

/**
 * Entities to ASCII
 *
 * Converts character entities back to ASCII
 *
 * @access	public
 * @param	string
 * @param	bool
 * @return	string
 */	
if ( ! function_exists('entities_to_ascii'))
{
	function entities_to_ascii($str, $all = TRUE)
	{
	   if (preg_match_all('/\&#(\d+)\;/', $str, $matches))
	   {
		   for ($i = 0, $s = count($matches['0']); $i < $s; $i++)
		   {				
			   $digits = $matches['1'][$i];

			   $out = '';

			   if ($digits < 128)
			   {
				   $out .= c