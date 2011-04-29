<?php  
	if ($this->session->flashdata('message'))
	{ 
		echo '<div class="message"> ' . $this->session->flashdata('message') . 'ZZZ</div>'; 
	}  else {
		echo $auth_message;
	}
	redirect('main');
?>
