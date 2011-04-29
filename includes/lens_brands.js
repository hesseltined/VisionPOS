// JavaScript Document
	$(function() {
		$( "#dialog:ui-dialog" ).dialog( "destroy" );
		
		$( "#create-lens-brand" )
			.button()
			.click(function() {
				
				var data;
				
				$.get( BASE_URL  +  "inventory/lens_brand_info", function (html){
					$("<div></div>").html(html).dialog({
						title: "Add Lens brand",
						buttons: {
									'Save & Add': function (){
										
												save($(this), 'add', true);
																	
										},
									Save: function () {
														
														save($(this),'add',false);
															
													  },
									Close: function (){ $(this).dialog("destroy"); }
								 }	
					});
				});
			});
			
			
			
			
			$(".a-brand").live("click",function () {
				var id = this.id;
				
				$.get(BASE_URL + "inventory/lens_brand_info/" + id, function (html){
					$("<div></div>").html(html).dialog({
						title: "Edit Lens brand",
						buttons: {
									
									Save: function () {
														save($(this),'edit',false);
													  },
									Close: function (){ $(this).dialog("destroy"); }
								 }	
					});
				});
			});
			
			
			$(".a-delete-brand").live("click",function () {
			
				var id = $(this).attr('rel');
				var elem = $(this);
				var brand = $(this).attr("brand_name");
				$("<div>Sure to Delete brand? <br>brand: "+ brand +"</div>").dialog({
						title: "Delete Confirmation",
						buttons: {
								Yes : function () {
										var m_dialog = $(this);
											$.post(BASE_URL + "inventory/lens_brand_delete", {id:id}, function (){
																															elem.parent().parent().fadeOut();
																															m_dialog.dialog("destroy");
																												          });
																														  
												  },
								No  : function () { $(this).dialog("destroy"); }										  
							}
					});
			
			});
			
			function save(m_dialog, m_op, m_add_more)
			{
					var bValid = true;
												bValid = bValid && checkDropdown($("#type_id"),"Type",0);
												bValid = bValid && checkLength( $("#brand-name"), "brand", 3, 30 );
																					
												if(bValid)
												{
															data = $('#form-lens-brand-detail').serialize();
															
															$.post(BASE_URL + "inventory/lens_brand_save",data,function (brand_id){
																
																		if (m_op == 'edit')
																		{
																			window.location.reload();
																			return
																		}
																
																		var template = '<tr><td><a href="#" class="a-brand" id="__ID__">__BRAND__</a></td><td>__TYPE__</td><td> <a href="#" rel="__ID__" brand_name="__BRAND__" class="a-delete-brand tooltip" title="Delete brand"><img src="'+ BASE_URL +'images/icons/delete.png"  /></a> </td></tr>';
																		
																		template = template.replace(/__TYPE__/g, $('#type_id option:selected').text());
																		template = template.replace(/__ID__/g, brand_id);
																		template = template.replace(/__BRAND__/g, $("#brand-name").val());
																		
																		
																		$("#tbl_brands tbody").append(template);
																		$(".tooltip").tipsy({gravity: 's'});
																		
																		
																		if (!m_add_more)
																			m_dialog.dialog("destroy");
																		else
																		{
																			$("#brand-name").val("");
																			$('#brand-name').focus();
																		}
																		
															});
												}	
			}
			
			
			
			
			
	});