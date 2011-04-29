<div id="calendar"> 
<?php echo print_r($data);?>

<p>This is where you will schedule client appointments</p>
<p><? echo $this->calendar->generate(date('m'), $data);?></p>
<p><? echo $this->calendar->generate(date('m'), $data);?></p>

</div>