<?php

// Returns the first day of month passed in or defaults to the current month.   Format is yyyy-mm-dd
function firstDayOfMonth($uts=null)
{
	$dtFirstDay = date("Y-n-j", mktime(0, 0, 0, date("m") , date("d")-date("d")+1, date("Y")));     
    
    return $dtFirstDay;
}

?>