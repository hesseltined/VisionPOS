<!-- VIEW->search.php  -->		<div id="clientsearch" >
 <?php if (isset($table)) {	
		echo $table; '<BR />';
		} else {
			echo 'Sorry, no results found.';
			if (isset($button)){
		}
			echo '<p class="search-results"><BR>';
			if (isset($search_results) )
			{
				echo $search_results; 
			}
				echo '</p><BR>';
			}
		
		//link to add new client  - to be displayed on search results page
		echo '<p id="add_client">' . anchor('main/new_client', $this->lang->line('add_new_client') );
	
	?>		
<div id="main-form" >
		 <!-- begain main form -->				
		 <link href="../../css/search.css" rel="stylesheet" media="screen" type="text/css" >
		 <form id="client_search_form" method="post" action="<? site_url('main/search');?>"
		 	<div id="search_for" >
		 		Search for?	
	
		 		<input type="text" name="search_term" id="search_term" value="<?php if (isset($search_term) ) { echo $search_term; } ?>" style="position:relative; left:10px; top:-1px; " />		
		 	</div>
		 	<div id="search_name_options" >	
		 		Name Only
		 		<input type="checkbox" name="searchoptionsname" id="nameonly" value="nameonly" />
		 		<label for="namelike" >Like</label>
		 		Or
		 		<input type="radio" name="namelike" id="namelike" value="like" style="position:relative; top:0px; left:1px; " />
		 		<label for="namelike" >Exact</label>
		 		<input type="radio" name="namelike" id="nameexact" value="exact" />
		 	</div>
		 	<div id="search_phone_options" >
		 		<label for="phoneonly" >Phone Only</label>
		 		<input type="checkbox" name="searchoptionsphone" id="phoneonly" value="phoneonly" />
		 	</div>
		 	<div id="search_address_options" >
		 		<label for="addressonly" >Address Only</label>
		 		<input type="checkbox" name="searchoptionsaddress" id="addressonly" value="addressonly" style="position:relative; left:4px; top:-3px; " />
		 		<label for="addresslike" >Like</label>
		 		Or
		 		<input type="radio" name="addresslike" id="addresslike" value="like" />
		 		<label for="addresslike" >Exact</label>
		 		<input type="radio" name="addresslike" id="addressexact" value="exact" />
		 	</div>
		 	<div id="search_everything_option" >
		 		<label for="everything" >Everything</label>
		 		<input type="checkbox" name="searchoptionseverything" id="everything" value="everything" style="position:relative; left:31px; top:1px; " />
		 	</div>
		 	<div id="search_mas90_options" >
		 		Search MAS 90
		 		<input type="checkbox" name="includemas90" id="includemas90" value="includemas90" />
		 	</div>
		 	<div id="search_everything_option" >
		 		Include Archived<input type="checkbox" name="includearchived" id="includearchived" value="includearchived" />
		 	</div>
		 	<div>
		 		<input type="submit" value="search" id="search_button" style="height:19px; width:180px; " />
		 	</div>
		 	</form>
		 	</div>
		 	</div>
		 	<p></p>
		
		
		 <!-- End of search-submit-field --><?php echo $this->lang->line('search_help_intro');?>
					</div>
					<div class="search-instructions" >
						<?php echo $this->lang->line('search_help_details');?>
					</div>
				</div>
		<!-- <div id="autocomplete_choices" class="autocomplete"></div> -->	
		
		

