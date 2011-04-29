function get_div(val,div_id,id)
{
	if(val.value=='Other')
	{
		//alert(id);
		$('#mfg'+id+'_other_div').show();
		$("#"+div_id).html("<option value='Other'>Other</option>");
		get_frame(id);
	}
	else
	{
		
		$('#mfg'+id+'_other_div').hide();
		document.body.style.opacity='0.65';
		document.body.style.cursor = 'wait';
		$.ajax({
		  url: '../ajaxframe/generate_division',
		  type: "POST",
		  data: ({id : val.value}),
		  success: function(data) {
			var div = data.split('^^^');
			$("#"+div_id).html("<option value=''> - - - </option>");
			$("#"+div_id).append("<option value='Other'>Other</option>");
			for(var i=0; i<div.length; i++) 
			{
				if(div[i]!="")
				{
					div_info = div[i].split('|||');
					$("#"+div_id).append("<option value='" + div_info[0] + "'>" + div_info[1] + "</option>");
				}
			}  
			document.body.style.opacity='1';
			document.body.style.cursor = 'auto';
			get_frame(id);
		  }
		});
	}
}


function get_frame(id)
{
	var value = $('#div'+id).val();
	var div_id = 'frame'+id;
	if(value=='Other')
	{
		$('#other_div'+id).show();
		$("#"+div_id).html("<option value=''> - - - </option>");
		$("#"+div_id).append("<option value='Other' selected>Other Frame</option>");
		get_other_frame(id)
	}
	else
	{	
		$('#other_div'+id).hide();
		document.body.style.opacity='0.65';
		document.body.style.cursor = 'wait';
		$.ajax({
		  url: '../ajaxframe/generate_frame',
		  type: "POST",
		  data: ({id : value}),
		  success: function(data) {
			var div=data.split('^^^');		
			$("#"+div_id).html("<option value=''> - - - </option>");
			$("#"+div_id).append("<option value='Other'>Other Frame</option>");
			var check=0;
			if(div.length>0)
			{
				$('#p'+div_id).show();
				$('#o'+div_id).hide();
			}
			for(var i=0; i<div.length; i++) 
			{
				if(div[i]!="")
				{
					check=1;
					div_info = div[i].split('|||');
					$("#"+div_id).append("<option value='" + div_info[0] + "'>" + div_info[1] + "</option>");
				}
			}  
/* 			if(check==0)
			{
				//$("#p"+div_id).html("<input type='text' name='frame_id[]' size='8'>");
				$('#p'+div_id).hide();
				$('#o'+div_id).show();
			} */
			get_other_frame(id)
			document.body.style.opacity='1';
			document.body.style.cursor = 'auto';
		  }
		});
	}
	
}

function get_other_frame(div)
{
	var id     = 'color'+div;
	var div_id = 'frame'+div;
	var value  = $('#'+div_id).val();
	
	if(value=='Other')
	{
	   $('#o'+div_id).show();
	   $("select[id='"+id+"'] option[value='Other']").attr("selected", true);
	}
	else
	{
		$('#o'+div_id).hide();
		$("select[id='"+id+"'] option[value='']").attr("selected", true);
		
		
		var frame_div_id = div_id;
		var value  = $('#'+frame_div_id).val();
		var div_id = id;
		
		$.ajax({
		  url: '../ajaxframe/generate_color',
		  type: "POST",
		  data: ({id : value}),
		  success: function(data) {
			var div=data.split('^^^');		
			$("#"+div_id).html("<option value=''> - - - </option>");
			$("#"+div_id).append("<option value='Other'>Other</option>");
			var check=0;
			for(var i=0; i<div.length; i++) 
			{
				if(div[i]!="")
				{
					div_info = div[i].split('|||');
					$("#"+div_id).append("<option value='" + div_info[0] + "'>" + div_info[1] + "</option>");
				}
			}  
			document.body.style.opacity='1';
			document.body.style.cursor = 'auto';
		  }
		});
	}
	get_color(id,div);
}


function get_color(div_id,id)
{
	var val = $('#'+div_id).val();
	var div = div_id+"_div";
	
	if(val=='Other')
	{
	   $('#'+div).show();
	}
	else
	{
		
		$('#'+div).hide();
	}
}



function add_new()
{
	var id = document.getElementById("id").value;
	id = (id-1)+2 ;
	document.getElementById("id").value = id;
	$.ajax({
	  url: '../ajaxframe/add_new',
	  type: "POST",
      data: ({id : id}),
	  success: function(data) {
		$("#content").append(data);
	  }
	});
}

function copy_new(copy_id,div_id)
{
	var id = document.getElementById("id").value;
	id = (id-1)+2 ;
	document.getElementById("id").value = id;

	mfg = $('#mfg'+div_id).val();
	fd  = $('#div'+div_id).val();
	frame1 = $('#frame'+div_id).val();
	mfg_other = $('#mfg_other'+div_id).val();
	other1 = $('#other'+div_id).val();
	div_other1 = $('#div_other'+div_id).val();
	cost_price1  = $('#cost_price'+div_id).val();
	retail_price1 =  $('#retail_price'+div_id).val();
	other1 = $('#other'+div_id).val();
	color1 = $('#color'+div_id).val();
	color_other1 = $('#color_other'+div_id).val();
	bridge_size1  = $('#bridge_size'+div_id).val();
	temple_length1 =  $('#temple_length'+div_id).val();
	eye_size1 =  $('#eye_size'+div_id).val();

	$.ajax({
	  url: '../ajaxframe/copy_new',
	  type: "POST",
      data: ({id : id,mfg:mfg,fd:fd,frame1:frame1,mfg_other:mfg_other,other1:other1,div_other1:div_other1,cost_price1:cost_price1,retail_price1:retail_price1,color1:color1,color_other1:color_other1,bridge_size1:bridge_size1,temple_length1:temple_length1,eye_size1:eye_size1}),
	  success: function(data) {
		$("#content").append(data);
		$('#'+copy_id).hide();
	  }
	});
}

function delete_row(id)
{
	$('#'+id).remove();
	
	var div_id;
	$('.copy_button_row').each(function(){
		 div_id   = $(this).attr('id');
    });
	$('#'+div_id).show();
}


