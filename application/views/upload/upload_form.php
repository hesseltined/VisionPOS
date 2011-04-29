<!--  VIEW->upload_form.php   -->

<div class='error_messages'>
<?php 
//	if (isset($error))	
//	{
//		foreach ($errors as $error){
//			echo $error;
//		}
//	}
?>
</div>

<div class='upload_instructions'>

	Select the Clients CSV file you wish to upload  (CSV's only and data must be properly formatted or data corruption may occur.)<BR />
	CSV file headers MUST match list below<br /><br />
	<table>
	<TR><TD>
		<ul class='columnlist'><li>A> firstname</li>
		<li>B> lastname</li>
		<li>C> address</li>
		<li>D> address2</li>
		<li>E> city</li>
		<li>F> state</li>
		<li>G> zip</li>
		<li>H> email</li>
		<li>I> phone</li>
		<li>J> phone2</li>
		<li>K> phone3</li>
		<li>L> examtype</li>
		<li>M> doctor_id</li>
		<li>N> examdate</li>
		<li>O> recalldate</li>
		<li>P> empty</li>
		<li>Q> dob</li>
		<li>R> insurance</li>
		<li>S> insurance_id</li>
		<li>T> notes</li>
		<li>U> EOF</li></ul>
		</TD><TD>
		<ul class='columnspecifics'><li><b>REQUIRED RULES AND GUIDELINES FOR VALID UPLOAD</b></li>
		<li>Header names MUST match exactly</li>
		<li>Columns must be in order listed here, no additional columns</li>
		<li>state must be ONLY two character state code</li>
		<li>dates MUST be formatted yyyy-mm-dd (Using Custom format in Excel)</li>
		<li>LAST column must have value EOF for ALL rows<BR />Copied down from top to the bottom)</li>
		<li>Only one store per CSV file/upload</li>
		</ul>
	</TD></TR>
	</table>
</div>
	
<div class='uploadstoreselector'>
<?php echo form_open_multipart('main/do_upload');

if (isset($content_stores)){
	echo form_dropdown('store_id', $content_stores, $store_id);
}

?>

<input type="file" name="userfile" size="20" />

<input type="submit" value="Upload" />

</form>

<BR></BR>
<?php echo form_open_multipart('main/do_uploadmas90data');?>
Upload MAS90 data
<input type="file" name="userfile" label="test" size="20" />

<input type="submit" value="uploadMAS90Data" />

</form>