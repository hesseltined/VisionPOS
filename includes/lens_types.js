// JavaScript Document
	$(function() {
		$( "#dialog:ui-dialog" ).dialog( "destroy" );
		
		$( "#create-lens-type" )
			.button()
			.click(function() {
				
				var data;
				
				$.get( BASE_URL  +  "inventory/lens_type_info", function (html){
					$("<div></div>").html(html).dialog({
						title: "Add Lens Type",
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
			
			
			
			
			$(".a-type").live("click",function () {
				var id = this.id;
				
				$.get(BASE_URL + "inventory/lens_type_info/" + id, function (html){
					$("<div></div>").html(html).dialog({
						title: "Edit Lens Type",
						buttons: {
									
									Save: function () {
														save($(this),'edit',false);
													  },
									Close: function (){ $(this).dialog("destroy"); }
								 }	
					});
				});
			});
			
			
			$(".a-delete-type").live("click",function () {
			
				var id = $(this).attr('rel');
				var elem = $(this);
				var type = $(this).attr("type_name");
				$("<div>Sure to Delete Type? <br>Lens Type: "+ type +"</div>").dialog({
						title: "Delete Confirmation",
						buttons: {
								Yes : function () {
										var m_dialog = $(this);
											$.post(BASE_URL + "inventory/lens_type_delete", {id:id}, function (){
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
												
												bValid = bValid && checkLength( $("#type-name"), "Design", 3, 30 );
																					
												if(bValid)
												{
															data = $('#form-lens-type-detail').serialize();
															
															$.post(BASE_URL + "inventory/lens_type_save",data,function (type_id){
																
																		if (m_op == 'edit')
																		{
																			window.location.reload();
																			return
																		}
																
																		var template = '<tr><td><a href="#" class="a-type" id="__ID__">__TYPE__</a></td><td> <a href="#" rel="__ID__" type_name="__TYPE__" class="a-delete-type tooltip" title="Delete Type"><img src="'+ BASE_URL +'images/icons/delete.png"  /></a> </td></tr>';
																		
																		template = template.replace(/__ID__/g, type_id);
																		template = template.replace(/__TYPE__/g, $("#type-name").val());
																		
																		
																		$("#tbl_types tbody").append(template);
																		$(".tooltip").tipsy({gravity: 's'});
																		
																		
																		if (!m_add_more)
																			m_dialog.dialog("destroy");
																		else
																		{
																			$("#type-name").val("");
																			$('#type-name').focus();
																		}
																		
															});
												}	
			}
			
			
			
			
			
	});