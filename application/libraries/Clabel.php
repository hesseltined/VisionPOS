<?php

//include_once('class.ezpdf.inc');
//include_once('cezpdf.php');
include_once(APPPATH . 'libraries/cezpdf.php');

class Clabel extends Cezpdf {
//==============================================================================
// This class extends the ezpdf class to specifically create labels
// this specific implementation will be used to create labels for 
// the Cougar implementation for MSBOA
// 
// version 002
//
// Craig Heydenburg Jan 06, 02
// modified April 18, 2002 to make it more modular
//==============================================================================

// declaring some variables - no need to change anything here
var $size; //string, stores page size (e.g. 'letter')
var $orientation; //string, store page orientation (e.g. 'portrait')
var $margin_l; var $margin_r; var $margin_t; var $margin_b; // int, used to store margin vals
var $label=array('width'=>0, 'height'=>0, 'per_row'=>0, 'per_page'=>0, 'type'=>"Av8160", 'textsize'=>10); //array used to store label size and info

// declaring variables with values - change stuff as neccessary
var $ourname="Real Optics Inc.";
var $image=array('width'=>72, 'height'=>0, 'loc'=>"./images/msboa_logo.jpg"); //image used on nametag
var $font_dir="/home/realopt/public_html/clients/fonts/"; // location of fonts - be sure to include the slash at the end
var $header_text=array(1=>'Real Optics Inc.',2=>'Recall Labels',3=>''); // header text - used as three lines
			
## need to recreate the constructor of the Cezpdf because constructors are not inherited

function Clabel($type="Av8160"){
	// the type variable defaults to Avery 8160

	$this->setLabelType($type);
	$this->Cezpdf($this->size,$this->orientation);
  $this->ezSetMargins($this->margin_t,$this->margin_b,$this->margin_l,$this->margin_r); // T,B,L,R

} //end constructor

function setLabelType($type) {
	switch ($type) {
		case "Av8160": // standard three column page of mailing labels
			// Avery 8160
			// these labels are page size: letter and portrait orientation
			// create a new page referring to parent class
			$this->size="letter";
			$this->orientation="portrait";
			// set defaults for the margins
			// top and left margins are set to writing point (FYI: exact label edge is 1/2 inch = 36)
			// bottom and right are adjusted to allow the write point to move freely (this is touchy)
			$this->margin_t=$this->u2px(2/3); // 2/3 of an inch
			$this->margin_b=$this->u2px(1/3);
			$this->margin_l=$this->u2px(3/8);
			$this->margin_r=$this->u2px(2/9);
			// set the labels width & height
			$this->label['width']=$this->u2px(2.75); //width of label = 2 3/4 inches
			$this->label['height']=$this->u2px(1); //height of label = 1 inch
			// set number of lables per row
			$this->label['per_row']=3;
			// set size of text for label
			$this->label['textsize']=10;
			break;
		case "CB7-OC": //nametag - not the actual avery tag number!
			// these labels are actually nametags
			// page size: letter and portrait orientation
			// create a new page referring to the parent class
			$this->size="letter";
			$this->orientation="portrait";
			// set default for the margins
			// top and left to writing point (FYI: exact label edge is 3/4 inch = 54)
			// bottom and right margins are adjusted to allow the write point to move freely (touchy)
			$this->margin_t=$this->u2px(1+7/72);
			$this->margin_b=$this->u2px(10/72);
			$this->margin_l=$this->u2px(3/4);
			$this->margin_r=$this->u2px(2/9);
			// set the labels width & height
			$this->label['width']=$this->u2px(3.5); //width of label = 3 1/2 inches
			$this->label['height']=$this->u2px(2+1/6); //height of label = 2 1/6 inches
			// set number of lables per row
			$this->label['per_row']=2;
			// set number of lables per page
			$this->label['per_page']=8;
			// set size of text for label
			$this->label['textsize']=12;
			break;
		case "sign": //posters
			// these labels are actually signs/posters
			// page size: letter and portrait orientation
			// create a new page referring to the parent class
			$this->size="letter";
			$this->orientation="landscape";
			// set default for the margins
			// top and left to writing point
			// bottom and right margins are adjusted to allow the write point to move freely (touchy)
			$this->margin_t=$this->u2px(1/2);
			$this->margin_b=$this->u2px(1/2);
			$this->margin_l=$this->u2px(1/2);
			$this->margin_r=$this->u2px(1/2);
			// set the labels width & height
			$this->label['width']=$this->u2px(10);
			$this->label['height']=$this->u2px(7+1/2);
			// set number of lables per row
			$this->label['per_row']=1;
			// set number of lables per page
			//$this->label['per_page']=1;
			// set size of text for label
			$this->label['textsize']=36;
			break;
		case "ship": //shipping labels 2" x 4"
			// page size: letter and portrait orientation
			// create a new page referring to the parent class
			$this->size="letter";
			$this->orientation="portrait";
			// set default for the margins
			// top and left to writing point
			// bottom and right margins are adjusted to allow the write point to move freely (touchy)
			$this->margin_t=$this->u2px(1/2);
			$this->margin_b=$this->u2px(1/6);
			$this->margin_l=$this->u2px(3/8);
			$this->margin_r=$this->u2px(1/6);
			// set the labels width & height
			$this->label['width']=$this->u2px(4);
			$this->label['height']=$this->u2px(2);
			// set number of lables per row
			$this->label['per_row']=2;
			// set number of lables per page
			$this->label['per_page']=10;
			// set size of text for label
			$this->label['textsize']=12;
			break;
		// other label types would be listed as new cases here
	} // end switch
	// set type variable
	$this->label['type']=$type;
} // end  setLabelType function

function formatLabel($type, $add_arr, $labelX, $labelY) {
	// $type is the label type, $add_arr is an array containing the label text ('line1', 'line2', etc.)
	switch ($type) {
		case "Av8160": // standard three column page of mailing labels
		/*************************************************************
		* The Av8160 is expecting an array of four values
		* array ('line1'=> first line of address label (typically first and last name)
		*        'line2'=> second line of address label (typically streeet address)
		*        'line3'=> third line of address label (typically PO BOX)
		*        'line4'=> fourth line of address label (typically city,state zip)
		*       )
		* the third line is optional and if it is not present, the class will omit it and
		* move the fourth line up on the label
		**************************************************************/
		
			//convert the four address values into a string with newlines
			$info[0]=$add_arr['line1'];
			$info[0].="\n".$add_arr['line2'];
			if ($add_arr['line3']<>"") {
				$info[0].="\n".$add_arr['line3'];
				$info[1]=4;
			} else {
				$info[1]=3;
			}
			$info[0].="\n".$add_arr['line4'];
			
			$return_height=$info[1]*($this->getFontHeight($this->label['textsize'])); //height of the text block

			// it would be good if we could determine if the length of the text was too long and
			// then do something about it.
	
			// print the dang label finally!
			$this->ezText($info[0], $this->label['textsize'], array('left'=>$labelX)); //, 'leading'=>$height
			// for trouble shooting Y position, uncomment the next line and comment the previous line
			//$this->ezText($this->y.": ".$address, $size, array('left'=>$offset)); //, 'leading'=>$height
			return($return_height);
			break;
		case "CB7-OC": //nametag
		/*************************************************************
		* The CB7-OC is expecting an array of two values
		* array ('line1'=> first line of name tag (typically first and last name)
		*        'line2'=> second line of nametag (typically duty or title or location)
		*       )
		**************************************************************/
		
			// need to set positions
			$x=$labelX+18+$this->margin_l;
			//$y=$labelY-(18+$this->image["height"]+$this->margin_t);
			$y=$labelY-$this->margin_t;
			//$line=array('x1'=>$labelX+91+$this->margin_l, 'y1'=>$labelY-90, 'x2'=>$labelX+234+$this->margin_l, 'y2'=>$labelY-90);
			$line=array('x1'=>$labelX+82+$this->margin_l, 'y1'=>$y, 'x2'=>$labelX+253+$this->margin_l, 'y2'=>$y); //line is 171px long
			
			// add logo
			$this->addJpegFromFile($this->image["loc"],$x, $y, $this->image["width"], $this->image["height"]);
			
			// place horizantal divider line
			$this->setLineStyle(3);
			$this->line($line["x1"],$line["y1"],$line["x2"],$line["y2"]);
			
			// print 'header'
			$this->selectFont($this->font_dir.'Helvetica');
			$this->addText($this->centerText($this->header_text[1],$this->margin_l+$labelX+171,14),$labelY-21,14,$this->header_text[1]);
			$this->addText($this->centerText($this->header_text[2],$this->margin_l+$labelX+171,14),$labelY-43,14,$this->header_text[2]);
			$this->addText($this->centerText($this->header_text[3],$this->margin_l+$labelX+171,14),$labelY-65,14,$this->header_text[3]);
			
			// print name and duty
			$this->selectFont($this->font_dir.'Helvetica-Bold');
			$this->addText($this->centerText($add_arr['line1'],$this->margin_l+$labelX+126,20),$labelY-108,20,$add_arr['line1']);
			$this->addText($this->centerText($add_arr['line2'],$this->margin_l+$labelX+126,14),$labelY-126,14,$add_arr['line2']);
			
			//move writing point back to the top
			$this->ezSetY($labelY);
			break;
		case "sign":
		/*************************************************************
		* The sign is expecting an array of three values
		* array ('line1'=> top line of sign
		*        'line2'=> main line of sign
		*        'line3'=> bottom line of sign
		*       )
		* any of the three lines may be left null if desired
		**************************************************************/		
		
			// print border
			$this->setLineStyle(4);
			$this->setStrokeColor(0,0,0,1);
			$this->rectangle($this->margin_l-18,$this->margin_b-18,$this->u2px(10.5),$this->u2px(8));
			
			// check image height
			if ($this->image["height"]==0) {
				$thisarray=getimagesize($this->image["loc"]);
				$mod=$this->image["width"]/$thisarray[0];
				$this->image["height"]=$mod*$thisarray[1];
			}
			
			// add logos
			$this->addJpegFromFile($this->image["loc"],$this->margin_l, $this->u2px(8.5)-$this->margin_t-$this->image["height"], $this->image["width"], $this->image["height"]); //upper left
			$this->addJpegFromFile($this->image["loc"],$this->margin_l, $this->margin_b, $this->image["width"], $this->image["height"]); //lower left
			$this->addJpegFromFile($this->image["loc"],$this->u2px(11)-$this->margin_r-$this->image["width"], $this->u2px(8.5)-$this->margin_t-$this->image["height"], $this->image["width"], $this->image["height"]); //upper right
			$this->addJpegFromFile($this->image["loc"],$this->u2px(11)-$this->margin_r-$this->image["width"], $this->margin_b, $this->image["width"], $this->image["height"]); //lower right
					
			// print 'header'
			$this->selectFont($this->font_dir.'Helvetica');
			$this->ezSetY($this->u2px(8.1));
			$htext=$this->header_text[1]." ".$this->header_text[2]." ".$this->header_text[3];
			$this->ezText($htext, 18, array('justification'=>'center'));
			
			// print sign text
			$this->selectFont($this->font_dir.'Helvetica-Bold');
			$this->ezSetDy(-($this->getFontHeight(36)-10));
			$this->ezText($add_arr['line1'], 36, array('justification'=>'center'));
			$msize=96;
			$mheight=5.5;
			if ($this->getTextWidth($msize, $add_arr['line2']) >$this->u2px(10)) { // if the text is wider than the page
				if ((count(explode(" ",$add_arr['line2']))>2) or (count(explode(" ",$add_arr['line2']))<2)) {
					// if there is 1 word or more than 2 words, make the text size smaller
					$msize=80;
				} else {
					$add_arr["line2"]=implode("\n",explode(" ",$add_arr['line2']));
					$mheight=6;
				}
			}
			$this->ezSetY($this->u2px($mheight));
			$this->ezText($add_arr['line2'], $msize, array('justification'=>'center'));
			$this->ezSetY($this->margin_b+$this->getFontHeight(36)+10);
			$this->ezText($add_arr['line3'], 36, array('justification'=>'center'));

			break;
		case "ship":
		
		// this case is currently set to do basically nothing!
		
		/*************************************************************
		* The ship is expecting an array of the following values
		* array ('line1'=> 
		*        'line2'=> 
		*        'line3'=> 
		*       )
		* any of the lines may be left null if desired
		**************************************************************/
			
			// check image height
			if ($this->image["height"]==0) {
				$thisarray=getimagesize($this->image["loc"]);
				$mod=$this->image["width"]/$thisarray[0];
				$this->image["height"]=$mod*$thisarray[1];
			}
			
			// add logos
			//$this->addJpegFromFile($this->image["loc"],$this->margin_l, $this->u2px(8.5)-$this->margin_t-$this->image["height"], $this->image["width"], $this->image["height"]); //upper left
					
			// print 'header'
			$this->selectFont($this->font_dir.'Helvetica');
			//$this->ezSetY($this->u2px(8.1));
			$htext=$this->header_text[1]." ".$this->header_text[2]." ".$this->header_text[3];
			//$this->ezText($htext, 18, array('justification'=>'center'));
			
			// print sign text
			$this->selectFont($this->font_dir.'Helvetica-Bold');
			$this->ezSetDy(-($this->getFontHeight(36)-10));
			//$this->ezText($add_arr['line1'], 36, array('justification'=>'center'));
			$this->ezSetY($this->u2px($mheight));
			//$this->ezText($add_arr['line2'], $msize, array('justification'=>'center'));
			$this->ezSetY($this->margin_b+$this->getFontHeight(36)+10);
			//$this->ezText($add_arr['line3'], 36, array('justification'=>'center'));

			break;
		// other label types would be listed as new cases here
	} // end switch
} // end  formatLabelText function

function makeLabel ($labelInfo) {
	// $labelInfo=array(key, array('line1', 'line2', 'line3', 'line4', etc.))

	// add directions to first and last labels
	//array_unshift($labelInfo, array('line1'=>"**Turn off 'Fit To Page' in", 'line2'=>"print dialog before printing.", 'line3'=>"Label Type: ".$this->label['type'], 'line4'=>"__".$this->ourname." Label Printing"));
	$total_labels=count($labelInfo)+1; // find total number of labels to print
	//$labelInfo[]=array('line1'=>"**Turn off 'Fit To Page' in", 'line2'=>"print dialog before printing.", 'line3'=>"Label Type: ".$this->label['type'], 'line4'=>$total_labels." labels printed");

	$count_labels=0; //used to count the labels as they are printed
  
  $offset=0; //used to move write point to next label
  $counter=0; //used to count number of labels in this row

	$this->selectFont($this->font_dir.'Helvetica');

	//move writing pointer down one line to compensate for quirk in the parent class
	$this->ez['topMargin']=(($this->ez['topMargin'])+($this->getFontHeight($this->label['textsize'])));
	
	while (list($key, $add_arr)=each($labelInfo)) {
    $counter++; // count the labels in this row
		$count_labels++; // count the total number of labels
    
		// set text color to red for first and last label
		//if (($count_labels==1) or ($count_labels==$total_labels)) $this->setColor(1,0,0); 

		$returnheight=$this->formatLabel($this->label['type'],$add_arr, $offset, $this->y);
		
		if ($this->currentColour['r']<>0) $this->setColor(0,0,0,1); //return color to black if it isn't

		if ($counter<$this->label['per_row']) {
      $this->ezSetDY($returnheight); //return to current height for next label in row
      $offset+=$this->label['width']; //set offset to next label in row
    } else {
	  	$this->ezSetDY($returnheight); //return to current height for next label in row
	  	if ($count_labels<>$total_labels) $this->ezSetDy(-($this->label['height'])); //move the write point down one label
      $offset=0; // set the write point back to the left margin
      $counter=0; //reset the counter
    }
    
    if (($this->label['per_page']<>0) and ($count_labels%$this->label['per_page']==0)) {
    	// if the label[per_page] setting exists and if this equals that setting then make a new page
    	$this->ezNewPage();
    }
	}

	// send the page to the browser
	$this->ezStream(array('Content-Disposition'=>'RECALL_labels.pdf'));

} // end makeLabel function

function centerText ($text, $center, $size) {
	// function returns the starting x value in order to center text on
	// the provided center point
	// requires: $text - the text being centered
	//           $center - X value upon which the text is to be centered
	//           $size - the size of the text
	return($center-($this->getTextWidth($size,$text)/2));
} // end centerText

function u2px ($value=0,$unit="in") {
	// function returns converted value from any unit to pdf screen units
	// requires: $value - the value to be converted
	//           $unit - the unit that the $value is measured in
	$fuzz=0.00000001; // facilitates rounding
	switch ($unit) {
		case "in": // english inches
			$newvalue=round($value*72+$fuzz);
			return($newvalue);
			break;
		case "cm": // metric centimeters
			$newvalue=round($value*28.3465+$fuzz);
			return($newvalue);
			break;
		case "mm": // metric millimeters
			$newvalue=round($value*2.83465+$fuzz);
			return($newvalue);
			break;
	} // end switch
} //end u2px


} //end class

?>