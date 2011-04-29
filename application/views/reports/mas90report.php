<!-- VIEW->mas90report.php  -->
<?php
			//if(isset($_POST['begindate'])) {$begindate = $_POST['begindate'];} else
			//	{$begindate = '2009-12-01';}
			if(isset($_POST['enddate'])) {$enddate = $_POST['enddate'];} else
				{$enddate = '2009-12-01';} 
			if(isset($_POST['minamount'])) {$minamount = $_POST['minamount'];} else {$minamount = 250;}
			if(isset($_POST['maxamount'])) {$maxamount = $_POST['maxamount'];} else {$maxamount = 500;}
			if(isset($_POST['zipcodes'])) {$zipcodes = $_POST['zipcodes'];} else {$zipcodes = 'ALL';}
			if ($zipcodes == '' ) { $zipcodes  = 'ALL'; }

?>

<div id="mas90report">

		<p>
			<?php echo form_open('reports/mas90report');
				
			echo '<p>Min Amount: '; 
				$minamtdata = array(
					'name' => 'minamount',
					'value' => $minamount,
					'maxlength' => '10',
					'size' => '10',
					);
			echo form_input($minamtdata);
			echo '&nbsp&nbsp Max Amount: ';
			$maxamtdata = array(
				'name' => 'maxamount',
				'value' => $maxamount,
				'maxlength' => '10',
				'size' => '10',
				);
			echo form_input($maxamtdata);
			
			echo '&nbsp&nbsp <label class="storeselector"  for="store_id">Store: </label>';
			//if store id was selected before then set the store to that id, else use the users default store ID.
			if (isset($_POST['store_id']))	{ 
				$store_id = $_POST['store_id'];
			} else {
				$store_id = $this->session->userdata('store_id');
			}
			echo form_dropdown('store_id', $content_stores, $store_id);
			
			echo '&nbsp&nbsp Zip Code(s): ';
			$zipcodesdata = array(
				'name' => 'zipcodes',
				'value' => $zipcodes,
				'maxlength' => '255',
				'size' => '25',
				);
			echo form_input($zipcodesdata);
//			echo '(ONLY if selecting \'All Stores\')';
			echo '</p>';
			
			echo '<label for="begindate">Begin Date </label><input type="text" label="Calendar" name="begindate" id="begindate" value=' . $begindate . '>
					 <img src="' . base_url() . 'images/44white_shadow-145.png" id="begin_f_trigger_c" style="cursor: pointer; " title="Date selector"
					      onmouseover="this.style.background=\'\';" onmouseout="this.style.background=\'\'" />';
			echo '<script type="text/javascript">
				    Calendar.setup({
				        inputField     :    "begindate",     // id of the input field
				        ifFormat       :    "%Y-%m-%d",      // format of the input field
				        button         :    "begin_f_trigger_c",  // trigger for the calendar (button ID)
				        align          :    "cc",           // alignment (defaults to "Bl")
				        singleClick    :    true,
				        step           :    1                // show all years in drop-down boxes (instead of every other year as default)
				    });
				</script>';
			
			echo '<label for="enddate">End Date </label><input type="text" label="Calendar" name="enddate" id="enddate" value=' . $enddate . '>
					 <img src="' . base_url() . 'images/44white_shadow-145.png" id="end_f_trigger_c" style="cursor: pointer; " title="Date selector"
					      onmouseover="this.style.background=\'\';" onmouseout="this.style.background=\'\'" />';
			echo '<script type="text/javascript">
				    Calendar.setup({
				        inputField     :    "enddate",     // id of the input field
				        ifFormat       :    "%Y-%m-%d",      // format of the input field
				        button         :    "end_f_trigger_c",  // trigger for the calendar (button ID)
				        align          :    "cc",           // alignment (defaults to "Bl")
				        singleClick    :    true,
				        step           :    1                // show all years in drop-down boxes (instead of every other year as default)
				    });
				</script>';
			
			
			echo '<label for="maxrecords">Max. Number of Results: </label>'; 
			$options = array(
								'50' => '50',
								'100' => '100', 
			                  '250'  => '250',
			                  '500'    => '500',
			                  '999999999' => 'All',
			                );	
			echo form_dropdown('maxrecords', $options);
			echo '' . form_submit('submit','Run Report'); 
			echo form_close(); 
			?>
			</p>
			</div>

	<?php 