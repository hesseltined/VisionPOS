<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">


 <head> 
 
 <meta http-equiv="Content-Type" content="text/html;charset=utf-8" >
   <title>  <?php if (isset($title)) { echo $title; } else { echo 'Real Optics Inc. Client Database Home Page';} ?>  </title> 
   <link rel="stylesheet" type="text/css" href="<?=site_url("css/nav.css")?>"  />
   <link rel="stylesheet" type="text/css" href="<?=site_url("Libraries/tipsy/stylesheets/tipsy.css")?>"  />
   <link href="<?=base_url()?>js/UI/css/redmond/jquery-ui-1.8.11.custom.css" rel="stylesheet" type="text/css">
   <script type="text/javascript" src="<?=site_url("js/jquery-1.5.1.min.js")?>"></script>
   
   <script type="text/javascript" src="<?=base_url()?>js/UI/js/jquery-ui-1.8.11.custom.min.js"  charset="utf-8"></script>
   <script type="text/javascript" src="<?=site_url("js/jquery.tablehover.min.js")?>"></script>
   <script type="text/javascript" src="<?=site_url("Libraries/tipsy/jquery.tipsy.js")?>"></script>
   <script type="text/javascript">
   		var BASE_URL = '<?=base_url()?>';
   </script>
   
<?php 
	echo $extraHeadContent; 
?>
	
    

	
</head> 
 
	<body> 
		<div id="wrapper"> 
			<div id="header"> 
				<?php $this->load->view('template/header');?> 
			</div> 
	         
			<div id="nav"> 
				<?php $this->load->view('template/navbar');?> 
			</div> 
			
			<div>
			<?php  
					$message = $this->session->flashdata('flashmessage');
					if ($message <> '')
				    {
				        echo "<div class='message'>Notice: " . $message . "</div >";
				    } 
			?>
			</div>
			         
			<div id="main"> 
				<?php $this->load->view($main); ?>
			</div> 
			         
			<div id="footer"> 
				<?php $this->load->view('template/footer');?> 
			</div> 
		</div> 
        
        <script type="text/javascript" src="<?=site_url("js/functions.js")?>"></script>
	</body> 
</html> 
 