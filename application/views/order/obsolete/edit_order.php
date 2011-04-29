<html><head>
		<link href="../../css/default.css" rel="stylesheet" media="screen" type="text/css" >
		
	<style type="text/css" media="screen" >
body {
	font-family:helvetica;
}

#navigation {
	list-style-type:none;
	list-style-position:initial;
	list-style-image:initial;
}

#navigation li {
	float:left;
}

#navigation a * {
	display:none;
}

#navigation a, #navigation a .hover {
	height:70px;
	position:relative;
	display:block;
	background-image:url(ExampleResources/FadingNavigation/dragon%2dsprite.jpg);
	background-repeat-x:no-repeat;
	background-repeat-y:no-repeat;
	background-repeat:no-repeat;
	background-attachment:initial;
	background-position:0px 0px;
	background-position-x:0px;
	background-position-y:0px;
	background-origin:initial;
	background-clip:initial;
	background-color:#000000;
}

#navigation a.home {
	background-position:0px 0px;
	background-position-x:0px;
	background-position-y:0px;
	width:102px;
}

#navigation .highlight a.home:hover, #navigation a.home .hover {
	background-position:0px -280px;
	background-position-x:0px;
	background-position-y:-280px;
	width:102px;
}

#navigation a.services {
	background-position:-102px -140px;
	background-position-x:-102px;
	background-position-y:-140px;
	width:115px;
}

#navigation .highlight a.services:hover, #navigation a.services .hover {
	background-position:-102px -280px;
	background-position-x:-102px;
	background-position-y:-280px;
}

#navigation a.portfolio {
	background-position:-217px 0px;
	background-position-x:-217px;
	background-position-y:0px;
	width:120px;
}

#navigation .highlight a.portfolio:hover, #navigation a.portfolio .hover {
	background-position:-218px -280px;
	background-position-x:-218px;
	background-position-y:-280px;
}

#navigation a.about {
	background-position:-337px 0px;
	background-position-x:-337px;
	background-position-y:0px;
	width:100px;
}

#navigation .highlight a.about:hover, #navigation a.about .hover {
	background-position:-339px -280px;
	background-position-x:-339px;
	background-position-y:-280px;
}

#navigation a.contact {
	background-position:-437px 0px;
	background-position-x:-437px;
	background-position-y:0px;
	width:115px;
}

#navigation .highlight a.contact:hover, #navigation a.contact .hover {
	background-position:-440px -280px;
	background-position-x:-440px;
	background-position-y:-280px;
}

</style><script src="../../Libraries/jquery-1.4.2.min.js" type="text/javascript" ></script>
<script type="text/javascript" charset="utf-8" >
    $(function () {
        if ($.browser.msie && $.browser.version < 7) return;
        
        $('#navigation li')
            .removeClass('highlight')
            .find('a')
            .append('<span class="hover" />').each(function () {
                    var $span = $('> span.hover', this).css('opacity', 0);
                    $(this).hover(function () {
                        // on hover
                        $span.stop().fadeTo(500, 1);
                    }, function () {
                        // off hover
                        $span.stop().fadeTo(500, 0);
                    });
                });
                
    });
</script>
</head><body style="left:20px; top:-32px; " onclick="(new Fx.Tween('temple_styles', {duration: 1000, })).start('background-color','#00ff00');" >
		<div id="edit_order" style="position:absolute; left:71px; top:128px; width:740px; height:448px; " >
			<fieldset>
				<legend>
New Order				</legend>

		<? echo  form_open('invoice/edit_order'); ?>	

	<div id="carriers" style="position:absolute; left:151px; top:25px; " >
		<? echo  '<label class="field4" for="carrier">Insurance Carrier<BR>'; ?>
		<? echo  form_dropdown('carriers', $list_carriers ) . '</label>'; ?>
	</div>
	
	<div id="bridges" style="position:absolute; left:232px; top:27px; width:198px; height:22px; " >
		<? echo  '<label class="field4" for="bridge">Bridges<BR>'; ?>
		<? echo  form_dropdown('bridge', $list_bridges ) . '</label>'; ?>				
	<?php echo "Hello World!";?></div>
	
	<div id="discounts" style="position:relative; width:120px; height:24px; left:11px; top:23px; " >
		<? echo  '<lab