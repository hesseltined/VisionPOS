<?php

//initiate variable
$authorization_field	= "example";
$dispencer_id_field		= "example";
$insurance_id_field		= "example";
$invoice_employer_field	= "";	
$dob_field				= "example";
$special_instructions_field = '<textarea id="special_instructions" rows="4" cols="108" name="special_instructions"></textarea>';

$current_client= "21245"; //number of client

//doctor where to put it ,on default I put near dispencer

//  missing  Insurance Co.:   ID ->carrier  // i add the field   

//add img just for : shere, cylinder, axis, addition

// add <div id="allHiddenDiv" style="display:block;">  why we need this block of HIDDEN DIV ??

// #frame_name doesn`t work - I don`t know what does the function on jquery

// modify remakeReason() -  need to hide label + drop_down 


?>

<script type="text/javascript">
$sitePath	=	'<?php echo  site_url();?>'
$(document).ready(function(){
	
/********************************/	
/***Albert Add-ins ******************/


	$("#frame_manufacturer,#frame_division,#frame_name,#frame_color").change(function () {
		
		var m_frame = $("#frame_name :selected").val();
		var m_color = $("#frame_color :selected").val();
		
		$.ajax({
					url: "<?=site_url("ajaxframe/ajax_frame_sizes")?>", 
					data: 'frame=' + m_frame + '&color=' + m_color, 
					dataType: "json",
					type: "post",
					jsonp : false,
					success: function (sizes)
					{
						
						$("select[name=eye_size]").html(sizes.eye_sizes);
						$("select[name=bridge_size]").html(sizes.bridge_sizes);
						$("select[name=temple_length]").html(sizes.temple_sizes);
					
					}
			  });
		
	
	});
	
	$("#lens_type").change(function () {
	
		var m_type_id = $(this).val();
		
		$.post("<?=site_url("ajaxframe/ajax_brands")?>", {type_id: m_type_id}, function (options){
		
			$("#lens_brand").html(options);
			$("#lens_brand").trigger("change");
		
		});
	
	});
	
	
	$("#lens_brand").change(function () {
	
		var m_brand_id = $(this).val();
		
		$.post("<?=site_url("ajaxframe/ajax_designs")?>", {brand_id: m_brand_id}, function (options){
		
			$("#lens_designs").html(options);
			$("#lens_designs").trigger("change");
		});
	});
	
	$("#lens_designs").change(function () {
	
		var m_design_id = $(this).val();
		
		$.post("<?=site_url("ajaxframe/ajax_materials")?>", {design_id: m_design_id}, function (options){
		
			$("#lens_materials").html(options);
			$("#lens_materials").trigger("change");
		});
	
	});
	
	$("#lens_materials").change(function () {
		var price = $("#lens_materials option:selected").attr("price");
		$("#lenses_field").val(price);
		calculation();
	
	});


	$("#prism_show a").click(function(){
		$("#prism_hide").show();
		$("#prism_show").hide();
	});

	$("#prism_hide a").click(function(){
		$("#prism_hide").hide();
		$("#prism_show").show();
	});

	$("#patientinfo-show a").click(function(){
		$("#patientinfo-hide").show();
		$("#patientinfo-show").hide();
	});

	$("#patientinfo-hide