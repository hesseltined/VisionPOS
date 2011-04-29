
	
	
	
<!-- VIEW-> client_input.php  -->		<div id="client_input" >
  <?php 
 	foreach($clientdata as $client){
 		$hidden = array('client_id' => $this->uri->segment(3));
		echo form_open('main/' . $addoreditpage, '',$hidden); 


	$this->load->view('client_input_fields');		
	}
?>		</div>
	

