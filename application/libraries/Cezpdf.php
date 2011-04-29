<?php



include_once(APPPATH . 'libraries/class.pdf.php');



class Cezpdf extends Cpdf {

//==============================================================================

// this class will take the basic interaction facilities of the Cpdf class

// and make more useful functions so that the user does not have to 

// know all the ins and outs of pdf presentation to produce something pretty.

//

// IMPORTANT NOTE

// there is no warranty, implied or otherwise with this software.

// 

// version 009 (versioning is linked to class.pdf.php)

//

// released under a public domain licence.

//

// Wayne Munro, R&OS Ltd, http://www.ros.co.nz/pdf

//==============================================================================



var $ez=array('fontSize'=>10); // used for storing most of the page configuration parameters

var $y; // this is the current vertical positon on the page of the writing point, very important

var $ezPages=array(); // keep an array of the ids of the pages, making it easy to go back and add page numbers etc.

var $ezPageCount=0;



// ------------------------------------------------------------------------------



function Cezpdf($paper='letter',$orientation='portrait'){

	// Assuming that people don't want to specify the paper size using the absolute coordinates

	// allow a couple of options:

	// orientation can be 'portrait' or 'landscape'

	// or, to actually set the coordinates, then pass an array in as the first parameter.

	// the defaults are as shown.

	// 

	// -------------------------

	// 2002-07-24 - Nicola Asuni (info@tecnick.com):

	// Added new page formats (45 standard ISO paper formats and 4 american common formats)

	// paper cordinates are calculated in this way: (inches * 72) where 1 inch = 2.54 cm

	// 

	// Now you may also pass a 2 values array containing the page width and height in centimeters

	// -------------------------



	if (!is_array($paper)){

		switch (strtoupper($paper)){

			case '4A0': {$size = array(0,0,4767.87,6740.79); break;}

			case '2A0': {$size = array(0,0,3370.39,4767.87); break;}

			case 'A0': {$size = array(0,0,2383.94,3370.39); break;}

			case 'A1': {$size = array(0,0,1683.78,2383.94); break;}

			case 'A2': {$size = array(0,0,1190.55,1683.78); break;}

			case 'A3': {$size = array(0,0,841.89,1190.55); break;}

			case 'A4': default: {$size = array(0,0,595.28,841.89); break;}

			case 'A5': {$size = array(0,0,419.53,595.28); break;}

			case 'A6': {$size = array(0,0,297.64,419.53); break;}

			case 'A7': {$size = array(0,0,209.76,297.64); break;}

			case 'A8': {$size = array(0,0,147.40,209.76); break;}

			case 'A9': {$size = array(0,0,104.88,147.40); break;}

			case 'A10': {$size = array(0,0,73.70,104.88); break;}

			case 'B0': {$size = array(0,0,2834.65,4008.19); break;}

			case 'B1': {$size = array(0,0,2004.09,2834.65); break;}

			case 'B2': {$size = array(0,0,1417.32,2004.09); break