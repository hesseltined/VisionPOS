<fieldset>
<legend>
Create new invoice from order <? echo $order_id; ?>  for  <? echo $customer_name; ?>
</legend>
				
<? echo  $form_open; ?>	

<p>
<script>
	function check(id)
	{
		var total = parseFloat($('#total').val());
		var id = parseFloat(id.value);
		balance = total-id;		//DOUG 9-16-2010 - Changed + to - to subtract deposit from total rather than add it
		balance = format_number (balance, 2);
		$('#balance').html("$"+balance);
	}
	
	function discount_calculate(id)
	{
	 	var id = parseFloat(id.value);
		var total = parseFloat($('#sub_total').val());
		main_total = total-id;   
		main_total = format_number (main_total, 2);
		$('#total').val(main_total);
		$('#main_total').html("$"+main_total);	

		var id = parseFloat($('#deposit').val());
		balance = main_total-id;		
		balance = format_number (balance, 2);
		$('#balance').html("$"+balance);
	}
	
	function format_number(pnumber,decimals){
	if (isNaN(pnumber)) { return 0};
	if (pnumber=='') { return 0};
	
	var snum = new String(pnumber);
	var sec = snum.split('.');
	var whole = parseFloat(sec[0]);
	var result = '';
	
	if(sec.length > 1){
		var dec = new String(sec[1]);
		dec = String(parseFloat(sec[1])/Math.pow(10,(dec.length - decimals)));
		dec = String(whole + Math.round(parseFloat(dec))/Math.pow(10,decimals));
		var dot = dec.indexOf('.');
		if(dot == -1){
			dec += '.'; 
			dot = dec.indexOf('.');
		}
		while(dec.length <= dot + decimals) { dec += '0'; }
		result = dec;
	} else{
		var dot;
		var dec = new String(whole);
		dec += '.';
		dot = dec.indexOf('.');		
		while(dec.length <= dot + decimals) { dec += '0'; }
		result = dec;
	}	
	return result;
}
</script>
<table>
	<tr>
		<TD width=120></td>
		<TD >Amount</td>
	</tr>
	<tr>
		<td>Lenses</td>
		<td><? echo $lens_price; ?></td>
	</tr>
	<tr>
		<td>Frames</td>
		<td><? echo $frame_price; ?></td>
	</tr>
	<tr>
		<td>Treatments</td>
		<td><? echo $treatments_price; ?></td>
	</tr>
	<tr>
		<td>Coatings</td>
		<td><? echo $coatings_price; ?></td>
	</tr>
	<tr>
		<td>Lab Fee</td>
		<td><? echo $lab_fee; ?></td>
	</tr>
	<tr>
		<td>Discount</td>
		<td><? echo $discount_amount_field; ?></td>
	</tr>
	<tr>
		<td>Subtotal</td>
		<td><? echo $subtotal; ?></td>
	</tr>
	<tr>
		<td>Tax</td>
		<td><? echo $tax; ?> </td>
	</tr>
	<tr>
		<td>TOTAL</td>
		<td id='main_total'><? echo $total; ?></td>
	</tr>
	<tr>
		<td>Deposit</td>
		<td> <? echo $deposit_field ; ?> </td>
	</tr>
	<tr>
		<td>Balance</td>
		<TD id='balance'>$___.__</td>
	</tr>
</table>
</p>

<div id="submit" style="float: left">
	<input type='hidden' id='sub_total' value="<?=$just_total?>" />
	<input type='hidden' id='total' value="<?=$just_total?>" />
	<? echo  form_submit('submit','Submit Invoice'); ?>
	<? echo  form_close(); ?>
</div>

	
	
	
	
	
