<?php

//Creats a list used in drop down from min to max with an increment.  4th attrib is # of decimals for formatting the number.  5th attrib is TRUE/FALSE for signed or not.  (signed will add a + to any positive numbers;

function list_builder( $params ) {

	$array = array();
	$mylist = array();
	
	if ( $params->blank ) $array[] = ''; 
	
	for($i = $params->min; $i <= $params->max; $i=$i+$params->increment )
	{
		$array[] = $i;
	}
	
	foreach ($array as $item) {
		if ( is_numeric($item) ) $item = number_format( $item , $params->decimals );
		if ( $params->signed && $item > 0 ) $item = '+' . $item; 
		$mylist[] = $item;
	}
	
	return $mylist;
	
}


function inventory_list_builder( $params ) {

	$array = array();
	$mylist = array();
	
	if ( $params->blank ) $array[] = ''; 
	
	for($i = $params->min; $i <= $params->max; $i=$i+$params->increment )
	{
		$array[$i] = $i;
	}
	
	return $array;
	
}

?>