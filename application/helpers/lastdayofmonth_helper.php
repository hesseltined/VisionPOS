<?php

// Returns the last day of month passed in or defaults to the current month.   Format is yyyy-mm-dd
function lastDayOfMonth($uts=null)
{
	$dtLastDay = date("Y-n-j", mktime(0, 0, 0, date("m")+1 , date("d")-date("d"), date("Y")));      
    
    return $dtLastDay;
}

?> 