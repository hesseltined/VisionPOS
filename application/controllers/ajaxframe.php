<?php
	class Ajaxframe extends Controller 
{

		
	function Ajaxframe()	{
		parent::Controller();   	
	}

	function generate_division()
	{
		$str = array();
		$this->load->model('mframes');
		$manufacturer = $_REQUEST['id'];
		$options = $this->mframes->get_frame_divisions($manufacturer);
		if($options)
		{
			foreach($options as $item)
			{
				$str[] = $item['id']."|||".$item['division'];
			}
			$division = implode("^^^",$str);
			echo $division;
		}
	}
	
	function generate_frame()
	{
		$str = array();
		$this->load->model('mframes');
		$division = $_REQUEST['id'];
		$options = $this->mframes->get_frames($division);
		if($options)
		{
			foreach($options as $item)
			{
				$str[] = $item['id']."|||".$item['name'];
			}
			$division = implode("^^^",$str);
			echo $division;
		}
	}
	
	function generate_color()
	{
		$str = array();
		if($_REQUEST['id']=='')
		{
			echo "";
		}
		else
		{
			$query   = $this->db->query("select * from frame_colors where frame_id= ".$_REQUEST['id']);
			$options = $query->result_array();
			if($options)
			{
				foreach($options as $item)
				{
					$str[] = $item['id']."|||".$item['color'];
				}
				$division = implode("^^^",$str);
				echo $division;
			}
		}
	}
	
	function add_new()
	{
		$i= $_REQUEST['id'];
		$this->load->model('ajaxinventory');
		$this->load->model('mframes');
		$options=$this->ajaxinventory->get_inventory_frame_manufacturers();
		foreach($options as $item)
		{
			$key = $item['id'];
			$option1[$key] = $item['manufacturer'];
		}
		$js1 = 'onChange="get_div(this,\'div'.$i.'\')"';
		$manu_drop = form_dropdown('manufacturer[]', $option1,'',$js1);
		
		
		$options=$this->ajaxinventory->get_frame_color();
		foreach($options as $item)
		{
			$key = $item['id'];
			$option2[$key] = $item['color'];
		}
		$color_drop = form_dropdown('color[]', $option2,'');				
		$js2 = 'id="div'.$i.'" onChange="get_frame(this,\'frame'.$i.'\')"';
		$js3 = 'id="frame'.$i.'" onChange="get_other_frame(this,\'frame'.$i.'\')"';
		
		$content = "<div class='generated_div'><div  class='row'>".$manu_drop."</div>
				   <div  class='row'>".form_dropdown('div[]',array(''=>"- - -"),'',$js2)."</div>
				   <div  class='rowframe' ><div id='pframe".$i."'>".form_dropdown('frame_id[]',array(''=>"- - -"),'',$js3)."</div><div id='oframe".$i."' style='display:none;'><input type='text' name='other[]'><input type='text' name='cost_price[]' id='cost_price1'><input type='text' name='retail_price[]' id='retail_price1'></div></div>
				   <div  class='row'>".$color_drop."<div >".form_dropdown('bridge_size[]', $bridge_values, '' )."</div>
				   <div  class='row'>".form_dropdown('temple_length[]', $temple_length_values, '' )."</div>
				   <div  class='row'>".form_input("quantity[]","","size='5'")."</div></div>";
		echo $content;
	}
	
	function copy_new()
	{
		$i= $_REQUEST['id'];
		$display1='';
		$this->load->model('mframes');
		$this->load->model('ajaxinventory');
		$options=$this->ajaxinventory->get_inventory_frame_manufacturers();
		$options = array_merge(array("0"=>array("id"=>"Other","manufacturer"=>"Other Mfg")),$options);
		foreach($options as $item)
		{
			$key = $item['id'];
			$option1[$key] = $item['manufacturer'];
		}
		ksort ($option1);
		$js1 = ' id="mfg'.$i.'" onChange="get_div(this,\'div'.$i.'\','.$i.')"';
		$manu_drop = form_dropdown('manufacturer[]', $option1,$_REQUEST['mfg'],$js1);
		$mfg_display = "style='display:none;'";
		if($_REQUEST['mfg']=='Other')
		{
			$mfg_display='';
		}
		
		$js2 = 'id="div'.$i.'" onChange="get_frame('.$i.')"';
		if($_REQUEST['mfg']!='')
		{
			$options = $this->mframes->get_frame_divisions($_REQUEST['mfg']);
			if($options)
			{
				$options = array_merge(array("0"=>array("id"=>"","division"=>"- - - ")),$options);
				foreach($options as $item)
				{
					$key = $item['id'];
					$option2[$key] = $item['division'];
				}
				$div_drop = form_dropdown('div[]', $option2,$_REQUEST['fd'],$js2 );
			}
			else
			{
				$option   = array("Other"=>"Other");
				$option   = array_merge(array(''=>"- - -"),$option);
				$div_drop = form_dropdown('div[]',$option,$_REQUEST['fd'],$js2);
			}
		}
		else
			$div_drop = form_dropdown('div[]',array(''=>"- - -"),'',$js2);
			
		$js3 = 'id="frame'.$i.'" onChange="get_other_frame('.$i.')"';
		if($_REQUEST['fd']!='')
		{
			$options = $this->mframes->get_frames($_REQUEST['fd']);	
			if($options)
			{
				$options = array_merge(array("0"=>array("id"=>"Other","name"=>"Other Frame")),$options);
				$options = array_merge(array("0"=>array("id"=>"","name"=>"- - - ")),$options);
				foreach($options as $item)
				{
					$key = $item['id'];
					$option3[$key] = $item['name'];
				}
				$frame_drop = form_dropdown('frame_id[]',$option3,$_REQUEST['frame1'],$js3);
			}
			else
			{
				$frame_option   = array("Other"=>"Other Frame");
				$frame_option   = array_merge(array(''=>"- - -"),$frame_option);
				$frame_drop = form_dropdown('frame_id[]',$frame_option,$_REQUEST['frame1'],$js3);	
				$display1   = "style='display:none;'";
			}
		}
		else
		{
			$frame_option   = array("Other"=>"Other Frame");
			$frame_option   = array_merge(array(''=>"- - -"),$frame_option);
			$frame_drop = form_dropdown('frame_id[]',$frame_option,$_REQUEST['frame1'],$js3);	
		}
		
		$options=$this->ajaxinventory->get_frame_color($_REQUEST['frame1']);
		$options = array_merge(array("0"=>array("id"=>"Other","color"=>"Other Color")),$options);
		$options = array_merge(array("0"=>array("id"=>"","color"=>"- - - ")),$options);
		foreach($options as $item)
		{
			$key = $item['id'];
			$option4[$key] = $item['color'];
		}
		$color_drop = form_dropdown('color[]', $option4,$_REQUEST['color1'],'id="color'.$i.'" onchange="get_color(\'color'.$i.'\','.$i.')"');		
		
		$display="style='display:none;'";
		if($_REQUEST['frame1']=='Other' || $display1 !='')
			$display='';
			
			
		$this->load->model('msettings');
		$this->load->helper('list_builder');   
		$bridge_params = $this->msettings->bridge_params();
		$bridge_values = inventory_list_builder( $bridge_params );
		
		$temple_length_params = $this->msettings->temple_length_params();
		$temple_length_values = inventory_list_builder($temple_length_params);   
		
		$eye_size_params 	  = $this->msettings->eye_size_params();
		$eye_size_values      = inventory_list_builder($eye_size_params);
		
		$color_display = "style='display:none;'";
		if($_REQUEST['color1']=='Other')
		{
			$color_display='';
		}
		
		$other_div_display = "style='display:none;'";
		if($_REQUEST['fd']=='Other')
		{
			$other_div_display='';
		}
		
		$content = "<div class='generated_div' id='main".$i."' ><div  class='row'>".$manu_drop."
						<div id='mfg".$i."_other_div' ".$mfg_display."><input type='text' name='mfg_other[]' id='mfg_other".$i."' value='".$_REQUEST['mfg_other']."' size='8'></div>
					</div>
				   <div  class='row'>".$div_drop."
						<div id='other_div".$i."' ".$other_div_display." ><input type='text' name='div_other[]' id='div_other".$i."' value='".$_REQUEST['div_other1']."' size='8'></div>
				   </div>
				   <div  class='rowframe' >".$frame_drop."
					<div id='oframe".$i."' ".$display."><input type='text' name='other[]' value='".$_REQUEST['other1']."' id='other".$i."' >
					Wholesale:&nbsp;<input type='text' name='cost_price[]' id='cost_price".$i."' size='5' value='".$_REQUEST['cost_price1']."' >
					Retail:&nbsp;<input type='text' name='retail_price[]' id='retail_price".$i."' size='5' value='".$_REQUEST['retail_price1']."'></div>
				   </div>
				   <div  class='row'>".$color_drop."
					<div id='color".$i."_div' ".$color_display."><input type='text' name='color_other[]' id='color_other".$i."' value='".$_REQUEST['color_other1']."' size='8'></div>
				   </div>
				   <div  class='small_row'>".form_dropdown('bridge_size[]', $bridge_values,$_REQUEST['bridge_size1'],'id=bridge_size'.$i)."</div>
				   <div  class='small_row'>".form_dropdown('temple_length[]', $temple_length_values,$_REQUEST['temple_length1'],'id=temple_length'.$i)."</div>
				   <div  class='small_row'>".form_dropdown('eye_size[]', $eye_size_values,$_REQUEST['eye_size1'], 'id=eye_size'.$i)."</div>
				   
				   <div  class='small_row'>
						<div class='button_row'><a href='javascript:delete_row(\"main".$i."\")'><img src='../images/delete.png' width='25' border='0' alt='add' /></a></div>
						<div class='copy_button_row' id='copy".$i."'><a href='javascript:copy_new(\"copy".$i."\",".$i.")'><img src='../images/add.png' width='25' border='0' alt='add' /></a></div>
				   </div>
				   </div>";
		echo $content;
	}
	
	function frame_price()
	{
		$this->load->model('ajaxinventory');
		$arr = $this->ajaxinventory->get_frame_price($_REQUEST['id']);
		echo $arr['retail_price']."^^^".$arr['cost_price'];
	}
	
	function coating_price()
	{
		$this->load->model('ajaxinventory');
		$arr = $this->ajaxinventory->get_coating_price($_REQUEST['id']);
		if(count($arr)>0)
			echo $arr['retail_price']."^^^".$arr['cost_price'];		
		else
			echo "0^^^0";
	}

	function lens_price()
	{
		$this->load->model('ajaxinventory');
		$arr = $this->ajaxinventory->get_lens_price($_REQUEST['lens_design_id'],$_REQUEST['lens_material_id']);
		if(count($arr)>0)
			echo $arr['retail_price']."^^^".$arr['cost_price'];		
		else
			echo "0^^^0";	
	}
	
	function treatment_price()
	{
		$this->load->model('ajaxinventory');
		if($_REQUEST['id']=='')
		{
			echo "0^^^0";
		}
		else
		{
			$arr = $this->ajaxinventory->treatment_price($_REQUEST['id']);
			if(count($arr)>0)
				echo $arr['retail_price']."^^^".$arr['cost_price'];		
			else
				echo "0^^^0";	
		}
	}
	
	function get_treatment_price()
	{
		$this->load->model('ajaxinventory');
		$arr = $this->ajaxinventory->get_treatment_price($_REQUEST['id']);
		echo $arr['retail_price'];
	}
	
	function check_frame()
	{
		$this->load->model('ajaxinventory');
		$arr = $this->ajaxinventory->check_frame($_REQUEST['eye_size'],$_REQUEST['bridge_size'],$_REQUEST['color_id'],$_REQUEST['frame_id']);
		if(count($arr)>0)
			echo "1";		
		else
			echo "0";	
	}
	
	function dispencer_name()
	{
		$dispencer_id = $_REQUEST['id'];
		$this->load->model('ajaxinventory');
		$arr = $this->ajaxinventory->dispencer_name($dispencer_id);
		if(isset($arr['username']))
			echo $arr['username'];
		else
			echo "";
	}


        public function ajax_frame_sizes()
        {
            $color = $this->input->post("color");
            $frame = $this->input->post("frame");

            $this->load->model("Minventory","inventory");


            $eye_sizes = $this->inventory->frame_sizes($frame, $color, "eye_size_min");

            $eye_sizes_options = "";
            foreach ($eye_sizes->result() as $es)
            {
                $eye_sizes_options.= "<option value='$es->eye_size_min'>$es->eye_size_min</option>";
            }
            $data['eye_sizes'] = $eye_sizes_options;
            /***********************************************************/

            $bridge_sizes = $this->inventory->frame_sizes($frame, $color, "bridge_size");

            $bridge_sizes_options = "";
            foreach ($bridge_sizes->result() as $bs)
            {
                $bridge_sizes_options.= "<option value='$bs->bridge_size'>$bs->bridge_size</option>";
            }
            $data['bridge_sizes'] = $bridge_sizes_options;
            /***********************************************************/


            $temple_sizes = $this->inventory->frame_sizes($frame, $color, "temple_size");

            $temple_sizes_options = "";
            foreach ($temple_sizes->result() as $ts)
            {
                $temple_sizes_options.= "<option value='$ts->temple_size'>$ts->temple_size</option>";
            }
            $data['temple_sizes'] = $temple_sizes_options;
            /***********************************************************/
            echo json_encode($data);
           // ob_flush();
        }

        public function ajax_brands()
        {
            $type_id = $this->input->post("type_id");

            $this->load->model("brands_model", "brand");

            $items = $this->brand->select(-1,-1,array("type_id" => $type_id));
            $options = "";

            foreach($items->result() as $brand)
            {
                $options .= "<option value='$brand->id'>$brand->brand</option>";
            }
            echo $options;
        }


        public function ajax_designs()
        {
            $this->load->model("mlens_designs", "design");

            $brand_id = $this->input->post("brand_id");

            $items = $this->design->select(-1,-1,array("brand_id" => $brand_id));

            $options = "";

            foreach($items->result() as $design)
            {
                $options .= "<option value='$design->id'>$design->design</option>";
            }
            echo $options;
            
        }

        public function ajax_materials()
        {
            $this->load->model("Mlens_materials", "materials");

            $design_id = $this->input->post("design_id");

            $items = $this->materials->select(-1,-1,array("design_id" => $design_id));

            $options = "";

            foreach($items->result() as $material)
            {
                $options .= "<option price='$material->retail_price' value='$material->id'>$material->material</option>";
            }
            echo $options;
        }
        
}
?>