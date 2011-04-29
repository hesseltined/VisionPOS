// JavaScript Document

	$(function() {
		
		

			
		$( "#dialog:ui-dialog" ).dialog( "destroy" );
		
		

		$( "#create-lens-material" )
			.button()
			.click(function() {
				
				var data;
				
				$.get(BASE_URL  +  "inventory/lens_material_info", function (html){
					$("<div></div>").html(html).dialog({
						title: "Add Lens Material",
						buttons: {
							
									'Save & Add' : function () {
										
											save_material($(this), 'add',true);
										
										},
									Save: function () {
														
											save_material($(this), 'add',false);			
															
													  },
									Close: function (){ $(this).dialog("destroy"); }
								 }	
					});
				});
			});
			
			
			
			
			$(".a-material").click(function () {
				var id = this.id;
				
				$.get(BASE_URL +  "inventory/lens_material_info/" + id, function (html){
					$("<div></div>").html(html).dialog({
						title: "Edit Lens Material",
						buttons: {
									Save: function () {
														save_material($(this), 'edit',false);
															
													  },
									Close: function (){ $(this).dialog("destroy"); }
								 }	
					});
				});
			});
			
			
			$(".a-delete-material").live("click",function () {
			
				var id = $(this).attr('rel');
				var elem = $(this);
				var material = $(this).attr("material_name");
				$("<div>Sure to Delete Material? <br>Material: "+ material +"</div>").dialog({
						title: "Delete Confirmation",
						buttons: {
								Yes : function () {
										var m_dialog = $(this);
											$.post(BASE_URL + "inventory/lens_material_delete", {id:id}, function (){
																															elem.parent().parent().fadeOut();
																															m_dialog.dialog("destroy");
																												          });
												  },
								No  : function () { $(this).dialog("destroy"); }										  
							}
					});
			
			});
			
			function save_material(m_dialog, m_op, m_add_more)
			{
					var bValid = true;
													
														data = $("#form-lens-material-detail").serialize();
														bValid = bValid && checkDropdown($("#design_id"),"Design",0);
														bValid = bValid && checkLength( $("#material"), "Material", 3, 16 );
														bValid = bValid && checkLength( $("#retail_price"), "Retail Price", 1, 10 );
														bValid = bValid && checkLength( $("#cost_price"), "Cost Price", 1, 10 );
														
														if(bValid)
														{
															data = $('#form-lens-material-detail').serialize();
															
															$.post(BASE_URL + "inventory/lens_material_save",data,function (material_id){
																
																if (m_op == 'edit')
																{
																	window.location.reload();
																	return;
																}
																
																var template = '<tr>' + 
        																	   '<td><a href="#" class="a-design" id="__ID__">__MATERIAL__</a></td>' + 
															                   '<td>__DESIGN__</td>' + 
                                                                               '<td>__RETAIL__</td>' + 
																			   '<td>__COST__</td>' + 
																			   '<td> <a href="#" rel="__ID__" material_name="__MATERIAL__" class="a-delete tooltip" '+ 
																			   'title="Delete Material"><img src="'+ BASE_URL +'images/icons/delete.png"  /></a> </td></tr>';
																			   
																template = template.replace(/__DESIGN__/g, $('#design_id option:selected').text());
																		   template = template.replace(/__ID__/g, material_id);
																		   template = template.replace(/__MATERIAL__/g, $("#material").val());
																		   template = template.replace(/__RETAIL__/g, $("#retail_price").val());
																		   template = template.replace(/__COST__/g, $("#cost_price").val());
																
																$("#tbl-materials tbody").append(template);
																$(".tooltip").tipsy({