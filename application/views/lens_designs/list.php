
    
    <br style="clear:both" />
    <br/>
&nbsp;

<div  style="width:80%; margin:auto">

<button id="create-lens-design">Add Lens Design</button>
<table width="100%" border="0 align="center"" id="tbl_designs" class="blue-table-b">
	<thead>
    	<tr>
            <th align="left">Design</th>
            <th align="left">Brand</th>
            <th>Action</th>
        </tr>
    </thead>
    
    <tbody>
    
    	<? foreach($designs->result() as $design): ?>
    	<tr>
            <td><a href="#" class="a-design tooltip" title="Edit" id="<?=$design->id?>"><?=$design->design?></a></td>
            <td><?=$design->brand?></td>
            <td> <a href="#" rel="<?=$design->id?>" design_name="<?=$design->design?>" class="a-delete-design tooltip" title="Delete Design"><img src="<?=site_url("images/icons/delete.png")?>"  /></a> </td>
        </tr>
        <? endforeach; ?>
    </tbody>
</table>
<div align="right">
<div style="margin-left:40px">
	Results Per Page: 
	<select id="select-per-page-inventory">
	<? for ($val = 5; $val<=50; $val+=5): ?>
    	<option value="<?=$val?>" <?=($val == $this->session->userdata("pagination_per_page")) ? "selected" : ""?>><?=$val?></option>
    <? endfor;?>
    </select>
    </div>
	<?=$pages?>
</div>
</div>


