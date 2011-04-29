<?php

function prep_pdf_recallreport($orientation = 'portrait')
{
	$CI = & get_instance();
	
	$CI->cezpdf->selectFont(base_url() . '/fonts');	
	
	$all = $CI->cezpdf->openObject();
	$CI->cezpdf->saveState();
	$CI->cezpdf->setStrokeColor(0,0,0,1);
	if($orientation == 'portrait') {
		$CI->cezpdf->ezSetMargins(50,70,50,50);
		$CI->cezpdf->ezStartPageNumbers(500,28,8,'','{PAGENUM}',1);
		$CI->cezpdf->line(20,40,578,40);
		$CI->cezpdf->addText(50,32,8,'Printed on ' . date('m/d/Y h:i:s a'));
		$CI->cezpdf->addText(50,22,8,'Real Optics Inc. Recall Report - http://www.realopticsinc.com/clients');
	}
	else {
		$CI->cezpdf->ezStartPageNumbers(750,28,8,'','{PAGENUM}',1);
		$CI->cezpdf->line(20,40,800,40);
		$CI->cezpdf->addText(50,32,8,'Printed on ' . date('m/d/Y h:i:s a'));
		$CI->cezpdf->addText(50,22,8,'Real Optics Inc. Recall Report - http://www.realopticsinc.com/clients');
	}
	$CI->cezpdf->restoreState();
	$CI->cezpdf->closeObject();
	$CI->cezpdf->addObject($all,'all');
}

function prep_pdf_callreport($orientation = 'landscape')
{
	$CI = & get_instance();
	
	$CI->cezpdf->selectFont(base_url() . '/fonts');	
	
	$all = $CI->cezpdf->openObject();
	$CI->cezpdf->saveState();
	$CI->cezpdf->setStrokeColor(0,0,0,1);
	if($orientation == 'landscape') {
		$CI->cezpdf->ezSetMargins(70,50,50,50);
		$CI->cezpdf->ezStartPageNumbers(500,28,8,'','{PAGENUM}',1);
		$CI->cezpdf->line(20,40,578,40);
		$CI->cezpdf->addText(50,32,8,'Printed on ' . date('m/d/Y h:i:s a'));
		$CI->cezpdf->addText(50,22,8,'Real Optics Inc. Call Report - http://www.realopticsinc.com/clients');
	}
	else {
		$CI->cezpdf->ezStartPageNumbers(750,28,8,'','{PAGENUM}',1);
		$CI->cezpdf->line(20,40,800,40);
		$CI->cezpdf->addText(50,32,8,'Printed on ' . date('m/d/Y h:i:s a'));
		$CI->cezpdf->addText(50,22,8,'Real Optics Inc. Call Report - http://www.realopticsinc.com/clients');
	}
	$CI->cezpdf->restoreState();
	$CI->cezpdf->closeObject();
	$CI->cezpdf->addObject($all,'all');
}

function prep_pdf_invoice( $company_division, $return_policy )
{
	$CI = & get_instance();
	
	$CI->cezpdf->selectFont(base_url() . '/fonts');	
	$all = $CI->cezpdf->openObject();
	$CI->cezpdf->saveState();
	$CI->cezpdf->setStrokeColor(0,0,0,1);
	$CI->cezpdf->ezSetMargins(50,70,50,50);
	$CI->cezpdf->addText(50,120,8, $return_policy); 	
	$CI->cezpdf->line(20,40,578,40);
	$CI->cezpdf->addText(50,32,8,'Printed on ' . date('m/d/Y h:i:s a'));
	$CI->cezpdf->addText(50,22,8, $company_division );
	$CI->cezpdf->restoreState();
	$CI->cezpdf->closeObject();
	$CI->cezpdf->addObject($all,'all');
}

?>