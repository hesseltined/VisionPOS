<!-- VIEW->call_report.php  -->

<?php

			if(isset($_POST['begindate'])) {$begindate = $_POST['begindate'];} 

			if(isset($_POST['enddate'])) {$enddate = $_POST['enddate'];} 

?>



<div id="call_report">



		<p>

			<?php echo form_open('reports/call_report');
			

			echo '<div class="call_report"><label for="begindate">Begin Date </label><input type="text" label="Calendar" name="begindate" id="begindate" value=' . $begindate . '>

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

			

			echo '<div><label for="enddate">End Date </label><input type="text" label="Calendar" name="enddate" id="enddate" value=' . $enddate . '>

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

			
			echo '<p><label class="storeselector"  for="store_id">Store: </label>';
			//if store id was selected before then set the store to that id, else use the users default store ID.
			if (isset($_POST['store_id']))	{ 
				$store_id = $_POST['store_id'];
			} else {
				$store_id = $this->session->userdata('store_id');
			}
			

			
			echo form_dropdown('store_id', $content_stores, $store_id);
			echo '<BR><BR>';

			

			echo '<p><label for="maxrecords">Max. Number of Results: </label>'; 

			$options = array(

								'10' => '10',

								'25' => '25', 

			                  '50'  => '50',

			                  '100'    => '100',

			                  '250'   => '250',

			                  '999999999' => 'All',

			                );	

			echo form_dropdown('maxrecords', $options);

			echo '<p>' . form_submit('submit','Run Report') . '</p>'; 

			echo form_close(); 

			?>

			</p>
			</div>



	<?php if (isset($_POST['maxrecords'])) 

	{

		//echo $this->mclients->calcdate($_POST['maxrecords']) . '<BR>';



	?>

		<p id="reportlink">

		<?php echo '<p>' . anchor_popup('reports/print_call_sheet/' . $_POST['begindate'] . '/' . $_POST['enddate'] . '/' .$_POST['maxrecords'] . '/' .$_POST['store_id'], 'Print Call Sheet') ;

		echo '</p><p>';
		

			if ($callreport) {
				echo '<p>Results Returned: ' . $numresults . '</p>';
				echo $callreport;		

			} else {

				echo 'Sorry, no results returned for your dates selected';

			}

		?> 

		</p>

	<?php 		

 	} ?>

</div>