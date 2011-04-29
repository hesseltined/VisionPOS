<!--searchbox.php VIEW file -->

<?php if (isset($table)) {	
	echo $table; '<BR />';
	} else {
	echo 'Sorry, no results found.';
	}
?>

<div id="main-form"> <!-- begain main form -->

<form id="client_search_form" method="post" action="<?= site_url('main/search');?>">
    	
        
   <div align="left"><B>Search for?</B></div>
      
	
    <div class="options-box">
		<div>
        <dl>
			<dd class="optoins-title"> <label for="nameonly"><b>Name Only&nbsp;&nbsp;&nbsp;&nbsp;</b></label>
			<input type="checkbox" name="searchoptionsname" id="nameonly" value="nameonly" <?php if (isset($searchoptionsname)) { if ( $searchoptionsname == 'nameonly' ) echo 'checked';} ?> /></dd>
			<dd class="like-value"><label for="namelike">Like</label>
            <dd class="text-value"><b>Or</b></dd>
			<input type="radio" name="namelike" id="namelike" value="like" <?php if (isset($namelike)) { if ( $namelike == 'like' ) echo 'checked'; } ?> />
			<dd class="exact-value"><label for="namelike">Exact</label>
			<input type="radio" name="namelike" id="nameexact" value="exact" <?php if (isset($namelike)) { if ( $namelike == 'exact' ) echo 'checked'; } ?> /></dd>
            </dd>
            
	  </dl>
      </div>
    </div> <!-- end of options-name -->



    <div class="options-box">
		<dl>
			<dd class="optoins-title"><label for="phoneonly"><b>Phone Only</b></label>
			<input type="checkbox" name="searchoptionsphone" id="phoneonly" value="phoneonly" <?php if (isset($searchoptionsphone)) {  if ( $searchoptionsphone == 'phoneonly' ) echo 'checked'; } ?> /></dd>
		</dl>
	</div> <!-- End of options-phone -->



<div class="options-box">
        <dl>
			<dd class="optoins-title"> <label for="addressonly" ><b>Address Only</b></label>
			<input type="checkbox" name="searchoptionsaddress" id="addressonly" value="addressonly" <?php if (isset($searchoptionsaddress)) { if ( $searchoptionsaddress == 'addressonly' ) echo 'checked';} ?> /></dd>
			<dd class="like-value"><label for="addresslike" >Like</label>
            <dd class="text-value"><b>Or</b></dd>
			<input type="radio" name="addresslike" id="addresslike" value="like" <?php if (isset($addresslike)) { if ( $addresslike == 'like' ) echo 'checked'; } ?> />
			<dd class="exact-value"><label for="addresslike">Exact</label>
			<input type="radio" name="addresslike" id="addressexact" value="exact" <?php if (isset($addresslike)) { if ( $addresslike == 'exact' ) echo 'checked'; } ?> /></dd>
		</dl>
	</div> <!-- End of options-address -->



	<div class="options-box">
		<div>
		<dl>
			<dd class="optoins-title"><label for="everything"><b>Everything</b></label>
			<input type="checkbox" name="searchoptionseverything" id="everything" value="everything" <?php if (isset($searchoptionseverything)) {  if ( $searchoptionseverything == 'everything' ) echo 'checked'; } ?> /></dd>
		</dl>
		</div>
	</div> <!-- End of options-everything -->



	<div class="options-box">
		<div>
		<dl>
			<dd class="optoins-title"><label for="includearchived"><b>Include Archived</b></label>
			<input type="checkbox" name="includearchived" id="includearchived" value="includearchived" 
			<?php if (isset($includearchived)) {  if ( $includearchived == 'includearchived' ) echo 'checked'; } ?> /></dd>
			
			<dd class="options-title"><label for="includemas90"><b>Search MAS 90</b></label>
			<input type="checkbox" name="includemas90" id="includemas90" value="includemas90" 
			<?php if (isset($includemas90)) {  if ( $includemas90 == 'includemas90' ) echo 'checked'; } ?> /></dd>
		</dl>
		</div>
	</div> <!-- End of options-archived -->


<BR />

	<div class="search-submit-field">
		<div>
			<div class="search-box"><label for="search_term"></label>
            <input type="text" name="search_term" id="search_term" value="<?php if (isset($search_term) ) { echo $search_term; } ?>" />
			<input type="submit" value="search" id="search_button" /></div>
		</div>
	</div> <!-- End of search-submit-field -->


			</form>
  
</div> <!-- end of main form -->      

<div class="search-instructions">
<p>Enter customers name, address, or phone number to beg