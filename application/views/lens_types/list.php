    <br style="clear:both" />
    <br/>
&nbsp;

<div  style="width:80%; margin:auto">

<button id="create-lens-type">Add Lens Type</button>
<table id="tbl_types" width="100%" border="0" align="center" class="blue-table-b">
	<thead>
    	<tr>
            <th align="left">Type</th>
            <th>Action</th>
        </tr>
    </thead>
    
    <tbody>
    
    	<? foreach($types->result() as $type): ?>
    	<tr>
        	<td><a href="#" class="a-type" id="<?=$type->id?>"><?=$type->type?></a></td>
            <td> <a href="#" rel="<?=$type->id?>" type_name="<?=$type->type?>" class="a-delete-type tooltip" title="Delete Lense Type"><img src="<?=site_url("images/icons/delete.png")?>"  /></a> </td>
        </tr>
        <? endforeach; ?>
    </tbody>
</table>
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

