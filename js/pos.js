/* ------------------------------------------------------------------------
	mysample
------------------------------------------------------------------------- */

function checkForOtherDoctor() {
    //var otherDoctorText = document.createTextNode('Other Doctor?');
    
    //return false;
    
    if($('select[id=doctor_id]').val()=='OTHER')			//DOUG 9-14-10 - I changed the value to OTHER to match the array key I changed - This was working until I added the dispencer_id field above this.  Sorry it's broke - The other box is displayed if you go BACK in the browser.  Strange
	{
		$('#otherDoctor').val('');
		$('#otherDoctor').show('slow')
	}
	else
	{
		$('#otherDoctor').val('');
		$('#otherDoctor').hide('slow')
		
	}
}
function remakeReason()
{
	 if($('#order_type').val()!='')
	 {
		if(($('#carrier').val()!='NONE') && ($('#carrier').val()!='DISCOUNT'))  //DOUG 9-14-10 - I changed the value to NONE and DISCOUNT to match the array key I changed in the mlists model - ask if any questions
		{
			alert('Field Insurance ID, D.O.B, Date Filed, Authorization, Diag Code');
			$('#order_type').val('');
			return false;
		}
		else if($('#order_type').val()=='New' || $('#order_type').val()=='')
		{
			$('#allHiddenDiv').show('slow');
		}
		else
		{
			var originalValueTrimmed = $.trim($('select[id=remake_reason]').val());              
			if(originalValueTrimmed!='')
			{
				$('#allHiddenDiv').show();
			} 
		}
		
	 }
	 
	 
	 if($('#order_type').val()=='New' || $('#order_type').val()=='')
		{
			$('#remake_reason_box').hide('slow')
		}
		else
		{
			
			if($('#remake_reason_box').css('display')=='none')
			$('#remake_reason_box').show('slow')
			
		}
/** change lens type ***/
	changeLenseType();
}
function changeLenseType()
{
	if($('select[name=lens_type]').val()=='1')
	{
		$('div[id^=segment_height_]').parent().hide('slow');
	}
	else
	{
		if($('div[id^=segment_height_]').parent().css('display')=='none')
			$('div[id^=segment_height_]').parent().show('slow');
	}
}

function usernameByDispercerId()
{
	$dispencer_id	=	$('input[id=dispencer_id]').val();
$.ajax(
		{
				type:'post',
				data:{"dispencer_id":$dispencer_id},
				url:$sitePath+"order/dispancerUsernameById",
				async: true,
				success:function(response)
				{
					$('#dispancerUsername').html(response);
					
				}
			});	
}

function getFrameDivisionByManufacturerId(val)
{
	document.body.style.opacity='0.65';
	document.body.style.cursor = 'wait';
	var div_id='frame_division';
	$.ajax({
	  url: $sitePath+'ajaxframe/generate_division',
	  type: "POST",
      data: ({id : val}),
	  success: function(data) {
		var div=data.split('^^^');
		$("#"+div_id).html("<option value=''> - - - </option>");
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

function LensType()
{
	document.body.style.opacity='0.65';
	document.body.style.cursor = 'wait';
	
	val	=	$('select[name=lens_type]').val();
	var div_id='frame_name';
	$.ajax({
	  url: $sitePath+'ajaxframe/generate_frame',
	  type: "POST",
      data: ({id : val}),
	  success: function(data) {
		var div=data.split('^^^');		
		$("#"+div_id).html("<option value=''> - - - </option>");
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


function getFrameNameByDivisionId(val)
{
	document.body.style.opacity='0.65';
	document.body.style.cursor = 'wait';
	var div_id='frame_name';
	$.ajax({
	  url: $sitePath+'ajaxframe/generate_frame',
	  type: "POST",
      data: ({id : val}),
	  success: function(data) {
		var div=dat