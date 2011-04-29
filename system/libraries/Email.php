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
 * CodeIgniter Email Class
 *
 * Permits email to be sent using Mail, Sendmail, or SMTP.
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Libraries
 * @author		ExpressionEngine Dev Team
 * @link		http://codeigniter.com/user_guide/libraries/email.html
 */
class CI_Email {

	var	$useragent		= "CodeIgniter";
	var	$mailpath		= "/usr/sbin/sendmail";	// Sendmail path
	var	$protocol		= "mail";	// mail/sendmail/smtp
	var	$smtp_host		= "";		// SMTP Server.  Example: mail.earthlink.net
	var	$smtp_user		= "";		// SMTP Username
	var	$smtp_pass		= "";		// SMTP Password
	var	$smtp_port		= "25";		// SMTP Port
	var	$smtp_timeout	= 5;		// SMTP Timeout in seconds
	var	$wordwrap		= TRUE;		// TRUE/FALSE  Turns word-wrap on/off
	var	$wrapchars		= "76";		// Number of characters to wrap at.
	var	$mailtype		= "text";	// text/html  Defines email formatting
	var	$charset		= "utf-8";	// Default char set: iso-8859-1 or us-ascii
	var	$multipart		= "mixed";	// "mixed" (in the body) or "related" (separate)
	var $alt_message	= '';		// Alternative message for HTML emails
	var	$validate		= FALSE;	// TRUE/FALSE.  Enables email validation
	var	$priority		= "3";		// Default priority (1 - 5)
	var	$newline		= "\n";		// Default newline. "\r\n" or "\n" (Use "\r\n" to comply with RFC 822)
	var $crlf			= "\n";		// The RFC 2045 compliant CRLF for quoted-printable is "\r\n".  Apparently some servers,
									// even on the receiving end think they need to muck with CRLFs, so using "\n", while
									// distasteful, is the only thing that seems to work for all environments.
	var $send_multipart	= TRUE;		// TRUE/FALSE - Yahoo does not like multipart alternative, so this is an override.  Set to FALSE for Yahoo.
	var	$bcc_batch_mode	= FALSE;	// TRUE/FALSE  Turns on/off Bcc batch feature
	var	$bcc_batch_size	= 200;		// If bcc_batch_mode = TRUE, sets max number of Bccs in each batch
	var $_safe_mode		= FALSE;
	var	$_subject		= "";
	var	$_body			= "";
	var	$_finalbody		= "";
	var	$_alt_boundary	= "";
	var	$_atc_boundary	= "";
	var	$_header_str	= "";
	var	$_smtp_connect	= "";
	var	$_encoding		= "8bit";
	var $_IP			= FALSE;
	var	$_smtp_auth		= FALSE;
	var $_replyto_flag	= FALSE;
	var	$_debug_msg		= array();
	var	$_recipients	= array();
	var	$_cc_array		= array();
	var	$_bcc_array		= array();
	var	$_headers		= array();
	var	$_attach_name	= array();
	var	$_attach_type	= array();
	var	$_attach_disp	= a