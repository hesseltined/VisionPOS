<?php

/**

* Cpdf

*

* http://www.ros.co.nz/pdf

*

* A PHP class to provide the basic functionality to create a pdf document without

* any requirement for additional modules.

*

* Note that they companion class CezPdf can be used to extend this class and dramatically

* simplify the creation of documents.

*

* IMPORTANT NOTE

* there is no warranty, implied or otherwise with this software.

* 

* LICENCE

* This code has been placed in the Public Domain for all to enjoy.

*

* @author		Wayne Munro <pdf@ros.co.nz>

* @version 	009

* @package	Cpdf

*/

class Cpdf {



/**

* the current number of pdf objects in the document

*/

var $numObj=0;

/**

* this array contains all of the pdf objects, ready for final assembly

*/

var $objects = array();

/**

* the objectId (number within the objects array) of the document catalog

*/

var $catalogId;

/**

* array carrying information about the fonts that the system currently knows about

* used to ensure that a font is not loaded twice, among other things

*/

var $fonts=array(); 

/**

* a record of the current font

*/

var $currentFont='';

/**

* the current base font

*/

var $currentBaseFont='';

/**

* the number of the current font within the font array

*/

var $currentFontNum=0;

/**

* 

*/

var $currentNode;

/**

* object number of the current page

*/

var $currentPage;

/**

* object number of the currently active contents block

*/

var $currentContents;

/**

* number of fonts within the system

*/

var $numFonts=0;

/**

* current colour for fill operations, defaults to inactive value, all three components should be between 0 and 1 inclusive when active

*/

var $currentColour=array('r'=>-1,'g'=>-1,'b'=>-1);

/**

* current colour for stroke operations (lines etc.)

*/

var $currentStrokeColour=array('r'=>-1,'g'=>-1,'b'=>-1);

/**

* current style that lines are drawn in

*/

var $currentLineStyle='';

/**

* an array which is used to save the state of the document, mainly the colours and styles

* it is used to temporarily change to another state, the change back to what it was before

*/

var $stateStack = array();

/**

* number of elements within the state stack

*/

var $nStateStack = 0;

/**

* number of page objects within the document

*/

var $numPages=0;

/**

* object Id storage stack

*/

var $stack=array();

/**

* number of elements within the object Id storage stack

*/

var $nStack=0;

/**

* an array which contains information about the objects which are not firmly attached to pages

* these have been added with the addObject function

*/

var $looseObjects=array();

/**

* array contains infomation about how the loose objects are to be added to the document

*/

var $addLooseObjects=array();

/**

* the objectId of the information object for the document

* this contains authorship, title etc.

*/

var $infoObject=0;

/**

* number of images being tracked within the document

*/

var $numImages=0;

/**

* an array containing options about the document

* it defaults to turning on the compression of the objects

*/

var $options=array('compression'=>1);

/**

* the objectId of the first page of the document

*/

var $firstPageId;

/**

* used to track the last used value of the inter-word spacing, this is so that it is known

* when the spacing is changed.

*/

var $wordSpaceAdjust=0;

/**

* the object Id of the procset object

*/

var $procsetObjectId;

/**

* store the information about the relationship between font families

* this used so that the code knows which font is the bold version of another font, etc.

* the value of this array is initialised in the constuctor function.

*/

var $fontFamilies = array();

/**

* track if the current font is bolded or italicised

*/

var $currentTextState = ''; 

/**

* messages are stored here during processing, these can be selected afterwards to give some useful debug information

*/

var $messages='';

/**

* the ancryption array for the document encryption is stored here

*/

var $arc4='';

/**

* the object Id of the encryption information

*/

var $arc4_objnum=0;

/**

* the file identifier, used to uniquely identify a pdf document

*/

var $fileIdentifier='';

/**

* a flag to say if a document is to be encrypted or not

*/

var $encrypted=0;

/**

* the ancryption key for the encryption of all the document content (structure is not encrypted)

*/

var $encryptionKey='';

/**

* array which forms a stack to keep track of nested callback functions

*/

var $callback = array();

/**

* the number of callback functions in the callback array

*/

var $nCallback = 0;

/**

* store label->id pairs for named destinations, these will be used to replace internal links

* done this way so that destinations can be defined after the location that links to them

*/

var $destinations = array();

/**

* store the stack for the transaction commands, each item in here is a record of the values of all the 

* variables within the class, so that the user can rollback at will (from each 'start' command)

* note that this includes the objects array, so these can be large.

*/

var $checkpoint = '';

/**

* class constructor

* this will start a new document

* @var array array of 4 numbers, defining the bottom left and upper right corner of the page. first two are normally zero.

*/

function Cpdf ($pageSize=array(0,0,612,792)){

  $this->newDocument($pageSize);

  

  // also initialize the font families that are known about already

  $this->setFontFamily('init');

//  $this->fileIdentifier = md5('xxxxxxxx'.time());



}



/**

* Document object methods (internal use only)

*

* There is about one object method for each type of object in the pdf document

* Each function has the same call list ($id,$action,$options).

* $id = the object ID of the object, or what it is to be if it is being created

* $action = a string specifying the action to be performed, though ALL must support:

*           'new' - create the object with the id $id

*           'out' - produce the output for the pdf object

* $options = optional, a string or array containing the various parameters for the object

*

* These, in conjunction with the output function are the ONLY way for output to be produced 

* within the pdf 'file'.

*/



/**

*destination object, used to specify the location for the user to jump to, presently on opening

*/

function o_destination($id,$action,$options=''){

  if ($action!='new'){

    $o =& $this->objects[$id];

  }

  switch($action){

    case 'new':

      $this->objects[$id]=array('t'=>'destination','info'=>array());

      $tmp = '';

      switch ($options['type']){

        case 'XYZ':

        case 'FitR':

          $tmp =  ' '.$options['p3'].$tmp;

        case 'FitH':

        case 'FitV':

        case 'FitBH':

        case 'FitBV':

          $tmp =  ' '.$options['p1'].' '.$options['p2'].$tmp;

        case 'Fit':

        case 'FitB':

          $tmp =  $options['type'].$tmp;

          $this->objects[$id]['info']['string']=$tmp;

          $this->objects[$id]['info']['page']=$options['page'];

      }

      break;

    case 'out':

      $tmp = $o['info'];

      $res="\n".$id." 0 obj\n".'['.$tmp['page'].' 0 R /'.$tmp['string']."]\nendobj\n";

      return $res;

      break;

  }

}



/**

* set the viewer preferences

*/

function o_viewerPreferences($id,$action,$options=''){

  if ($action!='new'){

    $o =& $this->objects[$id];

  }

  switch ($action){

    case 'new':

      $this->objects[$id]=array('t'=>'viewerPreferences','info'=>array());

      break;

    case 'add':

      foreach($options as $k=>$v){

        switch ($k){

          case 'HideToolbar':

          case 'HideMenubar':

          case 'HideWindowUI':

          case 'FitWindow':

          case 'CenterWindow':

          case 'NonFullScreenPageMode':

          case 'Direction':

            $o['info'][$k]=$v;

          break;

        }

      }

      break;

    case 'out':



      $res="\n".$id." 0 obj\n".'<< ';

      foreach($o['info'] as $k=>$v){

        $res.="\n/".$k.' '.$v;

      }

      $res.="\n>>\n";

      return $res;

      break;

  }

}



/**

* define the document catalog, the overall controller for the document

*/

function o_catalog($id,$action,$options=''){

  if ($action!='new'){

    $o =& $this->objects[$id];

  }

  switch ($action){

    case 'new':

      $this->objects[$id]=array('t'=>'catalog','info'=>array());

      $this->catalogId=$id;

      break;

    case 'outlines':

    case 'pages':

    case 'openHere':

      $o['info'][$action]=$options;

      break;

    case 'viewerPreferences':

      if (!isset($o['info']['viewerPreferences'])){

        $this->numObj++;

        $this->o_viewerPreferences($this->numObj,'new');

        $o['info']['viewerPreferences']=$this->numObj;

      }

      $vp = $o['info']['viewerPreferences'];

      $this->o_viewerPreferences($vp,'add',$options);

      break;

    case 'out':

      $res="\n".$id." 0 obj\n".'<< /Type /Catalog';

      foreach($o['info'] as $k=>$v){

        switch($k){

          case 'outlines':

            $res.="\n".'/Outlines '.$v.' 0 R';

            break;

          case 'pages':

            $res.="\n".'/Pages '.$v.' 0 R';

            break;

          case 'viewerPreferences':

            $res.="\n".'/ViewerPreferences '.$o['info']['viewerPreferences'].' 0 R';

            break;

          case 'openHere':

            $res.="\n".'/OpenAction '.$o['info']['openHere'].' 0 R';

            break;

        }

      }

      $res.=" >>\nendobj";

      return $res;

      break;

  }

}



/**

* object which is a parent to the pages in the document

*/

function o_pages($id,$action,$options=''){

  if ($action!='new'){

    $o =& $this->objects[$id];

  }

  switch ($action){

    case 'new':

      $this->objects[$id]=array('t'=>'pages','info'=>array());

      $this->o_catalog($this->catalogId,'pages',$id);

      break;

    case 'page':

      if (!is_array($options)){

        // then it will just be the id of the new page

        $o['info']['pages'][]=$options;

      } else {

        // then it should be an array having 'id','rid','pos', where rid=the page to which this one will be placed relative

        // and pos is either 'before' or 'after', saying where this page will fit.

        if (isset($options['id']) && isset($options['rid']) && isset($options['pos'])){

          $i = array_search($options['rid'],$o['info']['pages']);

          if (isset($o['info']['pages'][$i]) && $o['info']['pages'][$i]==$options['rid']){

            // then there is a match

            // make a space

            switch ($options['pos']){

              case 'before':

                $k = $i;

                break;

              case 'after':

                $k=$i+1;

                break;

              default:

                $k=-1;

                break;

            }

            if ($k>=0){

              for ($j=count($o['info']['pages'])-1;$j>=$k;$j--){

                $o['info']['pages'][$j+1]=$o['info']['pages'][$j];

              }

              $o['info']['pages'][$k]=$options['id'];

            }

          }

        } 

      }

      break;

    case 'procset':

      $o['info']['procset']=$options;

      break;

    case 'mediaBox':

      $o['info']['mediaBox']=$options; // which should be an array of 4 numbers

      break;

    case 'font':

      $o['info']['fonts'][]=array('objNum'=>$options['objNum'],'fontNum'=>$options['fontNum']);

      break;

    case 'xObject':

      $o['info']['xObjects'][]=array('objNum'=>$options['objNum'],'label'=>$options['label']);

      break;

    case 'out':

      if (count($o['info']['pages'])){

        $res="\n".$id." 0 obj\n<< /Type /Pages\n/Kids [";

        foreach($o['info']['pages'] as $k=>$v){

          $res.=$v." 0 R\n";

        }

        $res.="]\n/Count ".count($this->objects[$id]['info']['pages']);

        if ((isset($o['info']['fonts']) && count($o['info']['fonts'])) || isset($o['info']['procset'])){

          $res.="\n/Resources <<";

          if (isset($o['info']['procset'])){

            $res.="\n/ProcSet ".$o['info']['procset']." 0 R";

          }

          if (isset($o['info']['fonts']) && count($o['info']['fonts'])){

            $res.="\n/Font << ";

            foreach($o['info']['fonts'] as $finfo){

              $res.="\n/F".$finfo['fontNum']." ".$finfo['objNum']." 0 R";

            }

            $res.=" >>";

          }

          if (isset($o['info']['xObjects']) && count($o['info']['xObjects'])){

            $res.="\n/XObject << ";

            foreach($o['info']['xObjects'] as $finfo){

              $res.="\n/".$finfo['label']." ".$finfo['objNum']." 0 R";

            }

            $res.=" >>";

          }

          $res.="\n>>";

          if (isset($o['info']['mediaBox'])){

            $tmp=$o['info']['mediaBox'];

            $res.="\n/MediaBox [".sprintf('%.3f',$tmp[0]).' '.sprintf('%.3f',$tmp[1]).' '.sprintf('%.3f',$tmp[2]).' '.sprintf('%.3f',$tmp[3]).']';

          }

        }

        $res.="\n >>\nendobj";

      } else {

        $res="\n".$id." 0 obj\n<< /Type /Pages\n/Count 0\n>>\nendobj";

      }

      return $res;

    break;

  }

}



/**

* define the outlines in the doc, empty for now

*/

function o_outlines($id,$action,$options=''){

  if ($action!='new'){

    $o =& $this->objects[$id];

  }

  switch ($action){

    case 'new':

      $this->objects[$id]=array('t'=>'outlines','info'=>array('outlines'=>array()));

      $this->o_catalog($this->catalogId,'outlines',$id);

      break;

    case 'outline':

      $o['info']['outlines'][]=$options;

      break;

    case 'out':

      if (count($o['info']['outlines'])){

        $res="\n".$id." 0 obj\n<< /Type /Outlines /Kids [";

        foreach($o['info']['outlines'] as $k=>$v){

          $res.=$v." 0 R ";

        }

        $res.="] /Count ".count($o['info']['outlines'])." >>\nendobj";

      } else {

        $res="\n".$id." 0 obj\n<< /Type /Outlines /Count 0 >>\nendobj";

      }

      return $res;

      break;

  }

}



/**

* an object to hold the font description

*/

function o_font($id,$action,$options=''){

  if ($action!='new'){

    $o =& $this->objects[$id];

  }

  switch ($action){

    case 'new':

      $this->objects[$id]=array('t'=>'font','info'=>array('name'=>$options['name'],'SubType'=>'Type1'));

      $fontNum=$this->numFonts;

      $this->objects[$id]['info']['fontNum']=$fontNum;

      // deal with the encoding and the differences

      if (isset($options['differences'])){

        // then we'll need an encoding dictionary

        $this->numObj++;

        $this->o_fontEncoding($this->numObj,'new',$options);

        $this->objects[$id]['info']['encodingDictionary']=$this->numObj;

      } else if (isset($options['encoding'])){

        // we can specify encoding here

        switch($options['encoding']){

          case 'WinAnsiEncoding':

          case 'MacRomanEncoding':

          case 'MacExpertEncoding':

            $this->objects[$id]['info']['encoding']=$options['encoding'];

            break;

          case 'none':

            break;

          default:

            $this->objects[$id]['info']['encoding']='WinAnsiEncoding';

            break;

        }

      } else {

        $this->objects[$id]['info']['encoding']='WinAnsiEncoding';

      }

      // also tell the pages node about the new font

      $this->o_pages($this->currentNode,'font',array('fontNum'=>$fontNum,'objNum'=>$id));

      break;

    case 'add':

      foreach ($options as $k=>$v){

        switch ($k){

          case 'BaseFont':

            $o['info']['name'] = $v;

            break;

          case 'FirstChar':

          case 'LastChar':

          case 'Widths':

          case 'FontDescriptor':

          case 'SubType':

          $this->addMessage('o_font '.$k." : ".$v);

            $o['info'][$k] = $v;

            break;

        }

     }

      break;

    case 'out':

      $res="\n".$id." 0 obj\n<< /Type /Font\n/Subtype /".$o['info']['SubType']."\n";

      $res.="/Name /F".$o['info']['fontNum']."\n";

      $res.="/BaseFont /".$o['info']['name']."\n";

      if (isset($o['info']['encodingDictionary'])){

        // then place a reference to the dictionary

        $res.="/Encoding ".$o['info']['encodingDictionary']." 0 R\n";

      } else if (isset($o['info']['encoding'])){

        // use the specified encoding

        $res.="/Encoding /".$o['info']['encoding']."\n";

      }

      if (isset($o['info']['FirstChar'])){

        $res.="/FirstChar ".$o['info']['FirstChar']."\n";

      }

      if (isset($o['info']['LastChar'])){

        $res.="/LastChar ".$o['info']['LastChar']."\n";

      }

      if (isset($o['info']['Widths'])){

        $res.="/Widths ".$o['info']['Widths']." 0 R\n";

      }

      if (isset($o['info']['FontDescriptor'])){

        $res.="/FontDescriptor ".$o['info']['FontDescriptor']." 0 R\n";

      }

      $res.=">>\nendobj";

      return $res;

      break;

  }

}



/**

* a font descriptor, needed for including additional fonts

*/

function o_fontDescriptor($id,$action,$options=''){

  if ($action!='new'){

    $o =& $this->objects[$id];

  }

  switch ($action){

    case 'new':

      $this->objects[$id]=array('t'=>'fontDescriptor','info'=>$options);

      break;

    case 'out':

      $res="\n".$id." 0 obj\n<< /Type /FontDescriptor\n";

      foreach ($o['info'] as $label => $value){

        switch ($label){

          case 'Ascent':

          case 'CapHeight':

          case 'Descent':

          case 'Flags':

          case 'ItalicAngle':

          case 'StemV':

          case 'AvgWidth':

          case 'Leading':

          case 'MaxWidth':

          case 'MissingWidth':

          case 'StemH':

          case 'XHeight':

          case 'CharSet':

            if (strlen($value)){

              $res.='/'.$label.' '.$value."\n";

            }

            break;

          case 'FontFile':

          case 'FontFile2':

          case 'FontFile3':

            $res.='/'.$label.' '.$value." 0 R\n";

            break;

          case 'FontBBox':

            $res.='/'.$label.' ['.$value[0].' '.$value[1].' '.$value[2].' '.$value[3]."]\n";

            break;

          case 'FontName':

            $res.='/'.$label.' /'.$value."\n";

            break;

        }

      }

      $res.=">>\nendobj";

      return $res;

      break;

  }

}



/**

* the font encoding

*/

function o_fontEncoding($id,$action,$options=''){

  if ($action!='new'){

    $o =& $this->objects[$id];

  }

  switch ($action){

    case 'new':

      // the options array should contain 'differences' and maybe 'encoding'

      $this->objects[$id]=array('t'=>'fontEncoding','info'=>$options);

      break;

    case 'out':

      $res="\n".$id." 0 obj\n<< /Type /Encoding\n";

      if (!isset($o['info']['encoding'])){

        $o['info']['encoding']='WinAnsiEncoding';

      }

      if ($o['info']['encoding']!='none'){

        $res.="/BaseEncoding /".$o['info']['encoding']."\n";

      }

      $res.="/Differences \n[";

      $onum=-100;

      foreach($o['info']['differences'] as $num=>$label){

        if ($num!=$onum+1){

          // we cannot make use of consecutive numbering

          $res.= "\n".$num." /".$label;

        } else {

          $res.= " /".$label;

        }

        $onum=$num;

      }

      $res.="\n]\n>>\nendobj";

      return $res;

      break;

  }

}



/**

* the document procset, solves some problems with printing to old PS printers

*/

function o_procset($id,$action,$options=''){

  if ($action!='new'){

    $o =& $this->objects[$id];

  }

  switch ($action){

    case 'new':

      $this->objects[$id]=array('t'=>'procset','info'=>array('PDF'=>1,'Text'=>1));

      $this->o_pages($this->currentNode,'procset',$id);

      $this->procsetObjectId=$id;

      break;

    case 'add':

      // this is to add new items to the procset list, despite the fact that this is considered

      // obselete, the items are required for printing to some postscript printers

      switch ($options) {

        case 'ImageB':

        case 'ImageC':

        case 'ImageI':

          $o['info'][$options]=1;

          break;

      }

      break;

    case 'out':

      $res="\n".$id." 0 obj\n[";

      foreach ($o['info'] as $label=>$val){

        $res.='/'.$label.' ';

      }

      $res.="]\nendobj";

      return $res;

      break;

  }

}



/**

* define the document information

*/

function o_info($id,$action,$options=''){

  if ($action!='new'){

    $o =& $this->objects[$id];

  }

  switch ($action){

    case 'new':

      $this->infoObject=$id;

      $date='D:'.date('Ymd');

      $this->objects[$id]=array('t'=>'info','info'=>array('Creator'=>'R and OS php pdf writer, http://www.ros.co.nz','CreationDate'=>$date));

      break;

    case 'Title':

    case 'Author':

    case 'Subject':

    case 'Keywords':

    case 'Creator':

    case 'Producer':

    case 'CreationDate':

    case 'ModDate':

    case 'Trapped':

      $o['info'][$action]=$options;

      break;

    case 'out':

      if ($this->encrypted){

        $this->encryptInit($id);

      }

      $res="\n".$id." 0 obj\n<<\n";

      foreach ($o['info']  as $k=>$v){

        $res.='/'.$k.' (';

        if ($this->encrypted){

          $res.=$this->filterText($this->ARC4($v));

        } else {

          $res.=$this->filterText($v);

        }

        $res.=")\n";

      }

      $res.=">>\nendobj";

      return $res;

      break;

  }

}



/**

* an action object, used to link to URLS initially

*/

function o_action($id,$action,$options=''){

  if ($action!='new'){

    $o =& $this->objects[$id];

  }

  switch ($action){

    case 'new':

      if (is_array($options)){

        $this->objects[$id]=array('t'=>'action','info'=>$options,'type'=>$options['type']);

      } else {

        // then assume a URI action

        $this->objects[$id]=array('t'=>'action','info'=>$options,'type'=>'URI');

      }

      break;

    case 'out':

      if ($this->encrypted){

        $this->encryptInit($id);

      }

      $res="\n".$id." 0 obj\n<< /Type /Action";

      switch($o['type']){

        case 'ilink':

          // there will be an 'label' setting, this is the name of the destination

          $res.="\n/S /GoTo\n/D ".$this->destinations[(string)$o['info']['label']]." 0 R";

          break;

        case 'URI':

          $res.="\n/S /URI\n/URI (";

          if ($this->encrypted){

            $res.=$this->filterText($this->ARC4($o['info']));

          } else {

            $res.=$this->filterText($o['info']);

          }

          $res.=")";

          break;

      }

      $res.="\n>>\nendobj";

      return $res;

      break;

  }

}



/**

* an annotation object, this will add an annotation to the current page.

* initially will support just link annotations 

*/

function o_annotation($id,$action,$options=''){

  if ($action!='new'){

    $o =& $this->objects[$id];

  }

  switch ($action){

    case 'new':

      // add the annotation to the current page

      $pageId = $this->currentPage;

      $this->o_page($pageId,'annot',$id);

      // and add the action object which is going to be required

      switch($options['type']){

        case 'link':

          $this->objects[$id]=array('t'=>'annotation','info'=>$options);

          $this->numObj++;

          $this->o_action($this->numObj,'new',$options['url']);

          $this->objects[$id]['info']['actionId']=$this->numObj;

          break;

        case 'ilink':

          // this is to a named internal link

          $label = $options['label'];

          $this->objects[$id]=array('t'=>'annotation','info'=>$options);

          $this->numObj++;

          $this->o_action($this->numObj,'new',array('type'=>'ilink','label'=>$label));

          $this->objects[$id]['info']['actionId']=$this->numObj;

          break;

      }

      break;

    case 'out':

      $res="\n".$id." 0 obj\n<< /Type /Annot";

      switch($o['info']['type']){

        case 'link':

        case 'ilink':

          $res.= "\n/Subtype /Link";

          break;

      }

      $res.="\n/A ".$o['info']['actionId']." 0 R";

      $res.="\n/Border [0 0 0]";

      $res.="\n/H /I";

      $res.="\n/Rect [ ";

      foreach($o['info']['rect'] as $v){

        $res.= sprintf("%.4f ",$v);

      }

      $res.="]";

      $res.="\n>>\nendobj";

      return $res;

      break;

  }

}



/**

* a page object, it also creates a contents object to hold its contents

*/

function o_page($id,$action,$options=''){

  if ($action!='new'){

    $o =& $this->objects[$id];

  }

  switch ($action){

    case 'new':

      $this->numPages++;

      $this->objects[$id]=array('t'=>'page','info'=>array('parent'=>$this->currentNode,'pageNum'=>$this->numPages));

      if (is_array($options)){

        // then this must be a page insertion, array shoudl contain 'rid','pos'=[before|after]

        $options['id']=$id;

        $this->o_pages($this->currentNode,'page',$options);

      } else {

        $this->o_pages($this->currentNode,'page',$id);

      }

      $this->currentPage=$id;

      //make a contents object to go with this page

      $this->numObj++;

      $this->o_contents($this->numObj,'new',$id);

      $this->currentContents=$this->numObj;

      $this->objects[$id]['info']['contents']=array();

      $this->objects[$id]['info']['contents'][]=$this->numObj;

      $match = ($this->numPages%2 ? 'odd' : 'even');

      foreach($this->addLooseObjects as $oId=>$target){

        if ($target=='all' || $match==$target){

          $this->objects[$id]['info']['contents'][]=$oId;

        }

      }

      break;

    case 'content':

      $o['info']['contents'][]=$options;

      break;

    case 'annot':

      // add an annotation to this page

      if (!isset($o['info']['annot'])){

        $o['info']['annot']=array();

      }

      // $options should contain the id of the annotation dictionary

      $o['info']['annot'][]=$options;

      break;

    case 'out':

      $res="\n".$id." 0 obj\n<< /Type /Page";

      $res.="\n/Parent ".$o['info']['parent']." 0 R";

      if (isset($o['info']['annot'])){

        $res.="\n/Annots [";

        foreach($o['info']['annot'] as $aId){

          $res.=" ".$aId." 0 R";

        }

        $res.=" ]";

      }

      $count = count($o['info']['contents']);

      if ($count==1){

        $res.="\n/Contents ".$o['info']['contents'][0]." 0 R";

      } else if ($count>1){

        $res.="\n/Contents [\n";

        foreach ($o['info']['contents'] as $cId){

          $res.=$cId." 0 R\n";

        }

        $res.="]";

      }

      $res.="\n>>\nendobj";

      return $res;

      break;

  }

}



/**

* the contents objects hold all of the content which appears on pages

*/

function o_contents($id,$action,$options=''){

  if ($action!='new'){

    $o =& $this->objects[$id];

  }

  switch ($action){

    case 'new':

      $this->objects[$id]=array('t'=>'contents','c'=>'','info'=>array());

      if (strlen($options) && intval($options)){

        // then this contents is the primary for a page

        $this->objects[$id]['onPage']=$options;

      } else if ($options=='raw'){

        // then this page contains some other type of system object

        $this->objects[$id]['raw']=1;

      }

      break;

    case 'add':

      // add more options to the decleration

      foreach ($options as $k=>$v){

        $o['info'][$k]=$v;

      }

    case 'out':

      $tmp=$o['c'];

      $res= "\n".$id." 0 obj\n";

      if (isset($this->objects[$id]['raw'])){

        $res.=$tmp;

      } else {

        $res.= "<<";

        if (function_exists('gzcompress') && $this->options['compression']){

          // then implement ZLIB based compression on this content stream

          $res.=" /Filter /FlateDecode";

          $tmp = gzcompress($tmp);

        }

        if ($this->encrypted){

          $this->encryptInit($id);

          $tmp = $this->ARC4($tmp);

        }

        foreach($o['info'] as $k=>$v){

          $res .= "\n/".$k.' '.$v;

        }

        $res.="\n/Length ".strlen($tmp)." >>\nstream\n".$tmp."\nendstream";

      }

      $res.="\nendobj\n";

      return $res;

      break;

  }

}



/**

* an image object, will be an XObject in the document, includes description and data

*/

function o_image($id,$action,$options=''){

  if ($action!='new'){

    $o =& $this->objects[$id];

  }

  switch($action){

    case 'new':

      // make the new object

      $this->objects[$id]=array('t'=>'image','data'=>$options['data'],'info'=>array());

      $this->objects[$id]['info']['Type']='/XObject';

      $this->objects[$id]['info']['Subtype']='/Image';

      $this->objects[$id]['info']['Width']=$options['iw'];

      $this->objects[$id]['info']['Height']=$options['ih'];

      if (!isset($options['type']) || $options['type']=='jpg'){

        if (!isset($options['channels'])){

          $options['channels']=3;

        }

        switch($options['channels']){

          case 1:

            $this->objects[$id]['info']['ColorSpace']='/DeviceGray';

            break;

          default:

            $this->objects[$id]['info']['ColorSpace']='/DeviceRGB';

            break;

        }

        $this->objects[$id]['info']['Filter']='/DCTDecode';

        $this->objects[$id]['info']['BitsPerComponent']=8;

      } else if ($options['type']=='png'){

        $this->objects[$id]['info']['Filter']='/FlateDecode';

        $this->objects[$id]['info']['DecodeParms']='<< /Predictor 15 /Colors '.$options['ncolor'].' /Columns '.$options['iw'].' /BitsPerComponent '.$options['bitsPerComponent'].'>>';

        if (strlen($options['pdata'])){

          $tmp = ' [ /Indexed /DeviceRGB '.(strlen($options['pdata'])/3-1).' ';

          $this->numObj++;

          $this->o_contents($this->numObj,'new');

          $this->objects[$this->numObj]['c']=$options['pdata'];

          $tmp.=$this->numObj.' 0 R';

          $tmp .=' ]';

          $this->objects[$id]['info']['ColorSpace'] = $tmp;

          if (isset($options['transparency'])){

            switch($options['transparency']['type']){

              case 'indexed':

                $tmp=' [ '.$options['transparency']['data'].' '.$options['transparency']['data'].'] ';

                $this->objects[$id]['info']['Mask'] = $tmp;

                break;

            }

          }

        } else {

          $this->objects[$id]['info']['ColorSpace']='/'.$options['color'];

        }

        $this->objects[$id]['info']['BitsPerComponent']=$options['bitsPerComponent'];

      }

      // assign it a place in the named resource dictionary as an external object, according to

      // the label passed in with it.

      $this->o_pages($this->currentNode,'xObject',array('label'=>$options['label'],'objNum'=>$id));

      // also make sure that we have the right procset object for it.

      $this->o_procset($this->procsetObjectId,'add','ImageC');

      break;

    case 'out':

      $tmp=$o['data'];

      $res= "\n".$id." 0 obj\n<<";

      foreach($o['info'] as $k=>$v){

        $res.="\n/".$k.' '.$v;

      }

      if ($this->encrypted){

        $this->encryptInit($id);

        $tmp = $this->ARC4($tmp);

      }

      $res.="\n/Length ".strlen($tmp)." >>\nstream\n".$tmp."\nendstream\nendobj\n";

      return $res;

      break;

  }

}



/**

* encryption object.

*/

function o_encryption($id,$action,$options=''){

  if ($action!='new'){

    $o =& $this->objects[$id];

  }

  switch($action){

    case 'new':

      // make the new object

      $this->objects[$id]=array('t'=>'encryption','info'=>$options);

      $this->arc4_objnum=$id;

      // figure out the additional paramaters required

      $pad = chr(0x28).chr(0xBF).chr(0x4E).chr(0x5E).chr(0x4E).chr(0x75).chr(0x8A).chr(0x41).chr(0x64).chr(0x00).chr(0x4E).chr(0x56).chr(0xFF).chr(0xFA).chr(0x01).chr(0x08).chr(0x2E).chr(0x2E).chr(0x00).chr(0xB6).chr(0xD0).chr(0x68).chr(0x3E).chr(0x80).chr(0x2F).chr(0x0C).chr(0xA9).chr(0xFE).chr(0x64).chr(0x53).chr(0x69).chr(0x7A);

      $len = strlen($options['owner']);

      if ($len>32){

        $owner = substr($options['owner'],0,32);

      } else if ($len<32){

        $owner = $options['owner'].substr($pad,0,32-$len);

      } else {

        $owner = $options['owner'];

      }

      $len = strlen($options['user']);

      if ($len>32){

        $user = substr($options['user'],0,32);

      } else if ($len<32){

        $user = $options['user'].substr($pad,0,32-$len);

      } else {

        $user = $options['user'];

      }

      $tmp = $this->md5_16($owner);

      $okey = substr($tmp,0,5);

      $this->ARC4_init($okey);

      $ovalue=$this->ARC4($user);

      $this->objects[$id]['info']['O']=$ovalue;

      // now make the u value, phew.

      $tmp = $this->md5_16($user.$ovalue.chr($options['p']).chr(255).chr(255).chr(255).$this->fileIdentifier);

      $ukey = substr($tmp,0,5);



      $this->ARC4_init($ukey);

      $this->encryptionKey = $ukey;

      $this->encrypted=1;

      $uvalue=$this->ARC4($pad);



      $this->objects[$id]['info']['U']=$uvalue;

      $this->encryptionKey=$ukey;

     

      // initialize the arc4 array

      break;

    case 'out':

      $res= "\n".$id." 0 obj\n<<";

      $res.="\n/Filter /Standard";

      $res.="\n/V 1";

      $res.="\n/R 2";

      $res.="\n/O (".$this->filterText($o['info']['O']).')';

      $res.="\n/U (".$this->filterText($o['info']['U']).')';

      // and the p-value needs to be converted to account for the twos-complement approach

      $o['info']['p'] = (($o['info']['p']^255)+1)*-1;

      $res.="\n/P ".($o['info']['p']);

      $res.="\n>>\nendobj\n";

      

      return $res;

      break;

  }

}

      

/**

* ARC4 functions

* A series of function to implement ARC4 encoding in PHP

*/



/**

* calculate the 16 byte version of the 128 bit md5 digest of the string

*/

function md5_16($string){

  $tmp = md5($string);

  $out='';

  for ($i=0;$i<=30;$i=$i+2){

    $out.=chr(hexdec(substr($tmp,$i,2)));

  }

  return $out;

}



/**

* initialize the encryption for processing a particular object 

*/

function encryptInit($id){

  $tmp = $this->encryptionKey;

  $hex = dechex($id);

  if (strlen($hex)<6){

    $hex = substr('000000',0,6-strlen($hex)).$hex;

  }

  $tmp.= chr(hexdec(substr($hex,4,2))).chr(hexdec(substr($hex,2,2))).chr(hexdec(substr($hex,0,2))).chr(0).chr(0);

  $key = $this->md5_16($tmp);

  $this->ARC4_init(substr($key,0,10));

}



/**

* initialize the ARC4 encryption

*/

function ARC4_init($key=''){

  $this->arc4 = '';

  // setup the control array

  if (strlen($key)==0){

    return;

  }

  $k = '';

  while(strlen($k)<256){

    $k.=$key;

  }

  $k=substr($k,0,256);

  for ($i=0;$i<256;$i++){

    $this->arc4 .= chr($i);

  }

  $j=0;

  for ($i=0;$i<256;$i++){

    $t = $this->arc4[$i];

    $j = ($j + ord($t) + ord($k[$i]))%256;

    $this->arc4[$i]=$this->arc4[$j];

    $this->arc4[$j]=$t;

  }    

}



/**

* ARC4 encrypt a text string

*/

function ARC4($text){

  $len=strlen($text);

  $a=0;

  $b=0;

  $c = $this->arc4;

  $out='';

  for ($i=0;$i<$len;$i++){

    $a = ($a+1)%256;

    $t= $c[$a];

    $b = ($b+ord($t))%256;

    $c[$a]=$c[$b];

    $c[$b]=$t;

    $k = ord($c[(ord($c[$a])+ord($c[$b]))%256]);

    $out.=chr(ord($text[$i]) ^ $k);

  }

  

  return $out;

}



/**

* functions which can be called to adjust or add to the document

*/



/**

* add a link in the document to an external URL

*/

function addLink($url,$x0,$y0,$x1,$y1){

  $this->numObj++;

  $info = array('type'=>'link','url'=>$url,'rect'=>array($x0,$y0,$x1,$y1));

  $this->o_annotation($this->numObj,'new',$info);

}



/**

* add a link in the document to an internal destination (ie. within the document)

*/

function addInternalLink($label,$x0,$y0,$x1,$y1){

  $this->numObj++;

  $info = array('type'=>'ilink','label'=>$label,'rect'=>array($x0,$y0,$x1,$y1));

  $this->o_annotation($this->numObj,'new',$info);

}



/**

* set the encryption of the document

* can be used to turn it on and/or set the passwords which it will have.

* also the functions that the user will have are set here, such as print, modify, add

*/

function setEncryption($userPass='',$ownerPass='',$pc=array()){

  $p=bindec(11000000);



  $options = array(

     'print'=>4

    ,'modify'=>8

    ,'copy'=>16

    ,'add'=>32

  );

  foreach($pc as $k=>$v){

    if ($v && isset($options[$k])){

      $p+=$options[$k];

    } else if (isset($options[$v])){

      $p+=$options[$v];

    }

  }

  // implement encryption on the document

  if ($this->arc4_objnum == 0){

    // then the block does not exist already, add it.

    $this->numObj++;

    if (strlen($ownerPass)==0){

      $ownerPass=$userPass;

    }

    $this->o_encryption($this->numObj,'new',array('user'=>$userPass,'owner'=>$ownerPass,'p'=>$p));

  }

}



/**

* should be used for internal checks, not implemented as yet

*/

function checkAllHere(){

}



/**

* return the pdf stream as a string returned from the function

*/

function output($debug=0){



  if ($debug){

    // turn compression off

    $this->options['compression']=0;

  }



  if ($this->arc4_objnum){

    $this->ARC4_init($this->encryptionKey);

  }



  $this->checkAllHere();



  $xref=array();

  $content="%PDF-1.3\n%âãÏÓ\n";

//  $content="%PDF-1.3\n";

  $pos=strlen($content);

  foreach($this->objects as $k=>$v){

    $tmp='o_'.$v['t'];

    $cont=$this->$tmp($k,'out');

    $content.=$cont;

    $xref[]=$pos;

    $pos+=strlen($cont);

  }

  $content.="\nxref\n0 ".(count($xref)+1)."\n0000000000 65535 f \n";

  foreach($xref as $p){

    $content.=substr('0000000000',0,10-strlen($p)).$p." 00000 n \n";

  }

  $content.="\ntrailer\n  << /Size ".(count($xref)+1)."\n     /Root 1 0 R\n     /Info ".$this->infoObject." 0 R\n";

  // if encryption has been applied to this document then add the marker for this dictionary

  if ($this->arc4_objnum > 0){

    $content .= "/Encrypt ".$this->arc4_objnum." 0 R\n";

  }

  if (strlen($this->fileIdentifier)){

    $content .= "/ID[<".$this->fileIdentifier."><".$this->fileIdentifier.">]\n";

  }

  $content .= "  >>\nstartxref\n".$pos."\n%%EOF\n";

  return $content;

}



/**

* intialize a new document

* if this is called on an existing document results may be unpredictable, but the existing document would be lost at minimum

* this function is called automatically by the constructor function

*

* @access private

*/

function newDocument($pageSize=array(0,0,612,792)){

  $this->numObj=0;

  $this->objects = array();



  $this->numObj++;

  $this->o_catalog($this->numObj,'new');



  $this->numObj++;

  $this->o_outlines($this->numObj,'new');



  $this->numObj++;

  $this->o_pages($this->numObj,'new');



  $this->o_pages($this->numObj,'mediaBox',$pageSize);

  $this->currentNode = 3;



  $this->numObj++;

  $this->o_procset($this->numObj,'new');



  $this->numObj++;

  $this->o_info($this->numObj,'new');



  $this->numObj++;

  $this->o_page($this->numObj,'new');



  // need to store the first page id as there is no way to get it to the user during 

  // startup

  $this->firstPageId = $this->currentContents;

}



/**

* open the font file and return a php structure containing it.

* first check if this one has been done before and saved in a form more suited to php

* note that if a php serialized version does not exist it will try and make one, but will

* require write access to the directory to do it... it is MUCH faster to have these serialized

* files.

*

* @access private

*/

function openFont($font){

  // assume that $font contains both the path and perhaps the extension to the file, split them

  $pos=strrpos($font,'/');

  if ($pos===false){

    $dir = './';

    $name = $font;

  } else {

    $dir=substr($font,0,$pos+1);

    $name=substr($font,$pos+1);

  }



  if (substr($name,-4)=='.afm'){

    $name=substr($name,0,strlen($name)-4);

  }

  $this->addMessage('openFont: '.$font.' - '.$name);

  if (file_exists($dir.'php_'.$name.'.afm')){

    $this->addMessage('openFont: php file exists '.$dir.'php_'.$name.'.afm');

    $tmp = file($dir.'php_'.$name.'.afm');

    $this->fonts[$font]=unserialize($tmp[0]);

    if (!isset($this->fonts[$font]['_version_']) || $this->fonts[$font]['_version_']<1){

      // if the font file is old, then clear it out and prepare for re-creation

      $this->addMessage('openFont: clear out, make way for new version.');

      unset($this->fonts[$font]);

    }

  }

  if (!isset($this->fonts[$font]) && file_exists($dir.$name.'.afm')){

    // then rebuild the php_<font>.afm file from the <font>.afm file

    $this->addMessage('openFont: build php file from '.$dir.$name.'.afm');

    $data = array();

    $file = file($dir.$name.'.afm');

    foreach ($file as $rowA){

      $row=trim($rowA);

      $pos=strpos($row,' ');

      if ($pos){

        // then there must be some keyword

        $key = substr($row,0,$pos);

        switch ($key){

          case 'FontName':

          case 'FullName':

          case 'FamilyName':

          case 'Weight':

          case 'ItalicAngle':

          case 'IsFixedPitch':

          case 'CharacterSet':

          case 'UnderlinePosition':

          case 'UnderlineThickness':

          case 'Version':

          case 'EncodingScheme':

          case 'CapHeight':

          case 'XHeight':

          case 'Ascender':

          case 'Descender':

          case 'StdHW':

          case 'StdVW':

          case 'StartCharMetrics':

            $data[$key]=trim(substr($row,$pos));

            break;

          case 'FontBBox':

            $data[$key]=explode(' ',trim(substr($row,$pos)));

            break;

          case 'C':

            //C 39 ; WX 222 ; N quoteright ; B 53 463 157 718 ;

            $bits=explode(';',trim($row));

            $dtmp=array();

            foreach($bits as $bit){

              $bits2 = explode(' ',trim($bit));

              if (strlen($bits2[0])){

                if (count($bits2)>2){

                  $dtmp[$bits2