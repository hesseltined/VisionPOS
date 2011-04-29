<div id="home">
<style>
	.row{
		float:left;
		width:140px;
	}
	
	.small_row{
		float:left;
		width:100px;
	}
	
	.button_row{
		float:left;
		width:35px;
	}
	
	.copy_button_row
	{
		float:left;
		width:35px;
	}
	
	.rowframe{
		float:left;
		width:160px;
	}
	.fullbox{
		float:left;
		width:98%;
		padding-left:5px;
	}
	.generated_div{
		float:left;
		width:100%;
		padding: 5px 0px 5px 0px;
	}
	.fullbox_submit{
		float:left;
		width:98%;
		text-align:center;
		padding:10px;
	}
</style>
		<?=form_open('inventory/add_inventory', 'input')?>
		<div class='fullbox'>
			Store: <?=$store?>
		</div>
		<div class='fullbox'>
			<br />
		</div>
	
		<div class='fullbox'>
			<div class='row'>Frame Mfg</div>	
			<div class='row'>Frame Division</div>		
			<div class='rowframe'>Frame Name</div>		
			<div class='row'>Frame Color</div>		
			<div class='small_row'>Bridge Size</div>	
			<div class='small_row'>Temple</div>
			<div class='small_row'>Eye Size</div>	
		</div>
		<div class='fullbox'>
			<?=$page?>
			<div class='copy_button_row' id='copy1'><a href="javascript:copy_new('copy1','1')"><img src='../images/add.png' width='25' border='0' alt='add' /></a></div>
		</div>
		<div id='content' class='fullbox'></div>
		<input type="hidden" id="id" value="1">
		<div class='fullbox_submit'>
			<?=form_submit('Submit','Submit') ?>
		</div>
	<?=form_close();?>
</div>