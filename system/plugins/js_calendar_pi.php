<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 4.3.2 or newer
 *
 * @package		CodeIgniter
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2006, EllisLab, Inc.
 * @license		http://codeigniter.com/user_guide/license.html
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/*
Instructions:

Load the plugin using:

 	$this->load->plugin('js_calendar');

Once loaded you'll add the calendar script to the <head> of your page like this:

<?php echo js_calendar_script('my_form');  ?>

The above function will be passed the name of your form.

Then to show the actual calendar you'll do this:

<?php echo js_calendar_write('entry_date', time(), true);?>
<form name="my_form">
<input type="text" name="entry_date" value="" onblur="update_calendar(this.name, this.value);" />
<p><a href="javascript:void(0);" onClick="set_to_time('entry_date', '<?php echo time();?>')" >Today</a></p>
</form>


Note:  The first parameter is the name of the field containing your date, the second parameter contains the "now" time,
and the third tells the calendar whether to highlight the current day or not.

Lastly, you'll need some CSS for your calendar:

.calendar {
	border: 1px #6975A3 solid;
	background-color: transparent;
}
.calheading {
	background-color: #7C8BC0;
	color: #fff;
	font-family: Lucida Grande, Verdana, Geneva, Sans-serif;
	font-size: 11px;
	font-weight: bold;
	text-align: center;
}
.calnavleft {
	background-color: #7C8BC0;
	font-family: Lucida Grande, Verdana, Geneva, Sans-serif;
	font-size: 10px;
	font-weight: bold;
	color: #fff;
	padding: 4px;
	cursor: pointer;
}
.calnavright {
	background-color: #7C8BC0;
	font-family: Lucida Grande, Verdana, Geneva, Sans-serif;
	font-size: 10px;
	font-weight: bold;
	color: #fff;
	text-align:  right;
	padding: 4px;
	cursor: pointer;
}
.caldayheading {
	background-color: #000;
	color: #fff;
	font-family: Lucida Grande, Verdana, Geneva, Sans-serif;
	font-size: 10px;
	text-align: center;
	padding: 6px 2px 6px 2px;
}
.caldaycells{
	color: #000;
	background-color: #D1D7E6;
	font-family: Lucida Grande, Verdana, Geneva, Sans-serif;
	font-size: 11px;
	text-align: center;
	padding: 4px;
	border: 1px #E0E5F1 solid;
	cursor: pointer;
}
.caldaycellhover{
	color: #fff;
	background-color: #B3BCD4;
	font-family: Lucida Grande, Verdana, Geneva, Sans-serif;
	font-size: 11px;
	text-align: center;
	padding: 4px;
	border: 1px #B3BCD4 solid;
	cursor: pointer;
}
.caldayselected{
	background-color: #737FAC;
	color:	#fff;
	font-family: Lucida Grande, Verdana, Geneva, Sans-serif;
	font-size: 11px;
	font-weight: bold;
	text-align: center;
	border: 1px #566188 solid;
	padding: 3px;
	cursor: pointer;
}
.calblanktop {
	background-color: #fff;
	padding: 4px;
}
.calblankbot {
	background-color: #fff;
	padding: 4px;
}


*/

function js_calendar_script($form_name = 'entryform')
{		
$CI =& get_instance();
$CI->load->language('calendar');
ob_start();
?>
<script type="text/javascript">
<!--
var form_name	= "<?php echo $form_name; ?>";
var format		= 'us'; // eu or us
var days		= new Array(
					'<?php echo $CI->lang->line('cal_su');?>', // Sunday, short name
					'<?php echo $CI->lang->line('cal_mo');?>', // Monday, short name
					'<?php echo $CI->lang->line('cal_tu');?>', // Tuesday, short name
					'<?php echo $CI->lang->line('cal_wed');?>', // Wednesday, short name
					'<?php echo $CI->lang->line('cal_thu');?>', // Thursday, short name
					'<?php echo $CI->lang->line('cal_fri');?>', // Friday, short name
					'<?php echo $CI->lang->line('cal_sat');?>' // Saturday, short name
				);
var months		= new Array(
					'<?php echo $CI->lang->line('cal_january');?>',
					'<?php echo $CI->lang->line('cal_february');?>',
					'<?php echo $CI->lang->line('cal_march');?>',
			