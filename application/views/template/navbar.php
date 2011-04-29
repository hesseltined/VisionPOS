<div id="navbar">
	
	<script type="text/javascript">

	
	
	function mainmenu(nameId){

	    
		$("."+nameId+" ul").css({display: "none"}); // Opera Fix
		$("."+nameId).hover(function(){
		$(this).find('ul:first').css({visibility: "visible",display: "none"}).slideDown('slow');
		},function(){
		$(this).find('ul:first').css({visibility: "hidden"});
		});
    }
	
	$(document).ready(function () {	
	
		$('#nav li').hover(
			function () {
				//show its submenu
				$('ul', this).slideDown(100);
	
			}, 
			function () {
				//hide its submenu
				$('ul', this).slideUp(100);			
			}
		);
		
	});
	</script>
	
	<?php 
	
	
		if ( $this->dx_auth->is_logged_in())
	{ 
		$navlist = $this->mpages->getpages();
		if (count($navlist)){ 
			echo '<ul id="nav-better">'; 
			echo '<li> <A HREF="javascript:javascript:history.go(-1)">Back</A></li>';
			foreach ($navlist as $name){ 
			
			if ($name['page_title'] === 'Inventory Menu')  
		 	{ 
				echo '<li>'; 
				echo anchor(  $name['page_name'] ,$name['page_title']); 		 		
				echo'<ul>
						<li>'.anchor('inventory/edit_manufacturers', 'Frame Mfg\'s').'</li>
						<li>'.anchor('inventory/lens_types', 'Lens Types').'</li>
						<li>'.anchor('inventory/lens_brands', 'Lens Brands').'</li>
						<li>'.anchor('inventory/lens_designs', 'Lens Designs').'</li>
						<li>'.anchor('inventory/lens_materials', 'Lens Materials').'</li>
						<li>'.anchor('inventory/edit_lens_treatments', 'Lens Treatments').'</li>
						<li>'.anchor('settings/edit_doctors', 'Edit Doctor\'s list').'</li>
						<li>'.anchor('inventory/store_inventory', 'Store Inventory').'</li>
						
					</ul>';
		 		
			}else if ($name['page_title'] === 'Reports')  {	
				echo '<li>'; 
				echo anchor(  $name['page_name'] ,$name['page_title']); 		 		
		 		echo'<ul>
		 				<li>'.anchor('reports/recall_report', 'Recall Report').'</li>
		 				<li>'.anchor('reports/call_report', 'Call Report').'</li>
		 				<li>'.anchor('reports/mas90report', 'MAS 90 Report').'</li>
						<li>'.anchor('reports/inventory', 'Inventory').'</li>
		 			</ul>';
					
			}else{
			
			echo '<li>'; 
			echo anchor(  $name['page_name'] ,$name['page_title']); 		 		
			}
				
			echo '</li>'; 
			} 
		}
			
		
        if ($this->dx_auth->is_admin()){
					echo '<li>'; ?>
		             <a href="javascript:void(0);" >Admin</a>            
					<ul id="inventorynavigation_admin" >
						<li><?= anchor('main/import_clients', 'Import Clients' );?></li>
						<li><?= anchor('backend/users', 'Manage Users' );?></li>
						<li><?= anchor('backend/roles', 'Manage Roles' );?></li>
						<!-- <li><?= anchor('backend/unactivated_users', 'Account Activation');?></li>  -->
				<!--	<li><?= anchor('backend/uri_permissions', 'Manage Permissions');?></li>  -->
				<!--	<li><?= anchor('backend/custom_permissions', 'Custom Permissions');?></li>  -->
					</ul>
					
				<?php echo '</li>'; 
		}

		
		/*echo '<li><div class="siteidentification">';
		if ( base_url() == 'http://localhost/pilot/')
		{
			echo 'LOCALHOST';
		} elseif ( base_url() == 'http://www.gowhg.com/clientdb/') { 
			echo 'PILOT SITE';
		}
		echo '</div></li>';*/
				
		echo '</ul>'; 
		}
  
		if ( $this->dx_auth->is_logged_in())
	{ ?>
	    <ul id="login_navbar">
			<li class="user_panel"> 
									<?php echo anchor('auth/change_password', 'Change Password');?>
									<?php echo anchor('auth/logout', 'Logout');?>  
			</li>
		</ul>
		<div class="clear">&nbsp;</div>
		<ul id="headerstyle">
			<li class="item">Welcome <?php echo ucfirst($this->dx_auth->get_username() ) ; ?> <!--//DOUG HESSELTINE - Added UCFirst to display lowercase login name properly  -->
			, your security role is <?php echo $this->dx_auth->get_role_name() ?>
			&nbsp &nbsp Store: ( <?php echo $this->session->userdata('storename');?> )</li>
			
			<?php if(!isset($show_searchbox)): ?>
				<li class="item">
				  
					<form id="client_search_form" method="post" action="<?= site_url('main/search');?>">
						<span class="input_field" id="my_search">
							<input type="text" name="search_term" id="search_term" value="<?php if (isset($search_term) ) { echo $search_term; }?>" />
						</span>	
						<button  class="button_grey" type="submit" value="search" id="search_button" name="search_button" >
							<span>search</span>
						</button>
					
					</form>
				</li>
			<?php endif;?>
			<li class="clear">&nbsp;</li>
		</ul>
			<?php } ?> 
		
		 </div>
 	<p class="clear">&nbsp;</p>
