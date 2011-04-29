// JavaScript Document
	$(function() {
		$( "#dialog:ui-dialog" ).dialog( "destroy" );
		
		$( "#create-lens-design" )
			.button()
			.click(function() {
				
				var data;
				
				$.get( BASE_URL  +  "inventory/lens_design_info", function (html){
					$("<div></div>").html(html).dialog({
						title: "Add Lens Design",
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
			
			
			
			
			$(".a-design").live("click",function () {
				var id = this.id;
				
				$.get(BASE_URL + "inventory/lens_design_info/" + id, function (html){
					$("<div></div>").html(html).dialog({
						title: "Edit Lens Design",
						buttons: {
									
									Save: function () {
														save($(this),'edit',false);
													  },
									Close: function (){ $(this).dialog("destroy"); }
								 }	
					});
				});
			});
			
			
			$(".a-delete-design").live("click",function () {
			
				var id = $(this).attr('rel');
				var elem = $(this);
				var design = $(this).attr("design_name");
				$("<div>Sure to Delete Design? <br>Design: "+ design +"</div>").dialog({
						title: "Delete Confirmation",
						buttons: {
								Yes : function () {
										var m_dialog = $(this);
											$.post(BASE_URL + "inventory/lens_design_delete", {id:id}, function (){
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
												bValid = bValid && checkDropdown($("#brand_id"),"Brand",0);
												bValid = bValid && checkLength( $("#design-name"), "Design", 3, 30 );
																					
												if(bValid)
												{
															data = $('#form-lens-design-detail').serialize();
															
															$.post(BASE_URL + "inventory/lens_design_save",data,function (design_id){
																
																		if (m_op == 'edit')
																		{
																			window.location.reload();
																			return
																		}
																
																		var template = '<tr><td><a href="#" class="a-design" id="__ID__">__DESIGNNAME__</a></td><td>__BRAND__</td><td> <a href="#" rel="__ID__" design_name="__DESIGNNAME__" class="a-delete-design tooltip" title="Delete Design"><img src="'+ BASE_URL +'images/icons/delete.png"  /></a> </td></tr>';
																		
																		template = template.replace(/__BRAND__/g, $('#brand_id option:selected').text());
																		template = template.replace(/__ID__/g, design_id);
																		template = template.replace(/__DESIGNNAME__/g, $("#design-name").val());
																		
																		
																		$("#tbl_designs tbody").append(template);
																		$(".tooltip").tipsy({gravity: 's'});
																		
																		
																		if (!m_add_more)
																			m_dialog.dialog("destroy");
																		else
																		{
																			$("#design-name").val("");
																			$('#design-name').focus();
																		}
																		
															});
												}	
			}
			
			
			
			
			
	});