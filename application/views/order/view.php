<div id="view_order">
<fieldset>
 <?php

	foreach ($orderdata as $order){
	
		if ( $order['invoice_id'] != '' )
		{
			$invoice = anchor( 'invoice/view_invoice/ ' . $order['invoice_id'], 'View Invoice ' . $order['invoice_id'] );
		} else {
			$invoice = '<b>No Invoice Available</b> ';
			$invoice .= anchor('invoice/payment/' . $order['invoice_id'], 'Enter Payment');
		}
?>		
		<div class="order_box" id="order_view" >
			<div class="order_title">
				<h1 class="name_form">View Order</h1>
			</div>
			<div class="subcateg_title">1.</div>
			<div class="info_box">
			     <ul>
				    <li><label for="order_id">Order_id:</label><input type="text" id="order_id" class="field" value="<?=$order['order_id']?>"/></li>
				    <li><label for="client_id">Client_id:</label><input type="text" id="client_id" class="field" value="<?=$order['client_id']?> "/></li>
				    <li>Invoice_id: <?=$invoice?></li>	
				 </ul>
				 <p class="clear">&nbsp;</p>
			</div>
			<div class="subcateg_title ">2.</div>
			<div class="info_box pink">
			    <ul>
				    <li><label for="order_date">Order_date:</label><input type="text" id="order_date" class="field" value="<?=$order['order_date'] ?>"/></li>
				    <li><label for="order_type">Order_type:</label><input type="text" id="order_type" class="field" value="<?=$order['order_type']?>"/></li>
				    <li><label for="insurance_id">Insurance_id:</label><input type="text" id="insurance_id" class="field" value="<?=$order['insurance_id']?>"/></li>
				    <li><label for="tray_num">Tray_num:</label><input type="text" id="tray_num" class="field" value="<?=$order['tray_num']?>"/></li>
				    <li><label for="doctor_id">Doctor_id:</label><input type="text" id="doctor_id" class="field" value="<?=$order['doctor_id']?>"/></li>
				    <li><label for="due_date">Due_date:</label><input type="text" id="due_date" class="field" value="<?=$order['due_date']?>"/></li>
				    <li><label for="complete_date">Complete Date:</label><input type="text" id="complete_date" class="field" value="<?=$order['complete_date']?>"/></li>
				    <li><label for="delivered_date">Delivered Date:</label><input type="text" id="delivered_date" class="field" value="<?=$order['delivered_date']?>"/></li>
				    <li><label for="remake_reason">Remake Reason:</label><input type="text" id="remake_reason" class="field" value="<?=$order['remake_reason']?>"/></li>
				</ul>
				<p class="clear">&nbsp;</p>
			</div>
			<div class="subcateg_title">3.</div>
			<div class="info_box">
				<ul>
				    <li><label for="segment_decentration">Segment Decentration:</label><input type="text" id="segment_decentration" class="field" value="<?=$order['segment_decentration']?>"/></li>
				    <li><label for="segment_height_l">segment_height l:</label><input type="text" id="segment_height_l" class="field" value="<?=$order['segment_height_l']?>"/></li>
				    <li><label for="segment_height_r">segment_height r:</label><input type="text" id="segment_height_r" class="field" value="<?=$order['segment_height_r']?>"/></li>
				    <li><label for="lens_color">Lens Color:</label><input type="text" id="lens_color" class="field" value="<?=$order['lens_color']?>"/></li>
				    <li><label for="lens_size_a">Lens Size A:</label><input type="text" id="lens_size_a" class="field" value="<?=$order['lens_size_a']?>"/></li>
				    <li><label for="lens_size_b">Lens Size B:</label><input type="text" id="lens_size_b" class="field" value="<?=$order['lens_size_b']?>"/></li>
				    <li><label for="lens_size_ed">Lens Size ED:</label><input type="text" id="lens_size_ed" class="field" value="'<?=$order['lens_size_ed']?>"/></li>
				    <li><label for="lens_shape">Lens Shape:</label><input type="text" id="lens_shape" class="field" value="<?=$order['lens_shape']?>"/></li>
				    <li><label for="lens_material">Lens Material:</label><input type="text" id="lens_material" class="field" value="<?=$order['lens_material']?>"/></li>
				    <li><label for="lens_treatment">Lens Treatment:</label><input type="text" id="lens_treatment" class="field" value="<?=$order['lens_treatment']?>"/></li>
				    <l