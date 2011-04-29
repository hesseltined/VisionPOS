
    
    <br style="clear:both" />
    <br/>
&nbsp;

<div  style="width:80%; margin:auto">

<button id="create-lens-brand">Add Lens Brand</button>
<table width="100%" border="0 align="center"" id="tbl_brands" class="blue-table-b">
	<thead>
    	<tr>
            <th align="left">Brand</th>
            <th align="left">Type</th>
            <th>Action</th>
        </tr>
    </thead>
    
    <tbody>
    
    	<? foreach($brands->result() as $brand): ?>
    	<tr>
            <td><a href="#" class="a-brand tooltip" title="Edit" id="<?=$brand->id?>"><?=$brand->brand?></a></td>
            <td><?=$brand->type?></td>
            <td> <a href="#" rel="<?=$brand->id?>" brand_name="<?=$brand->brand?>" class="a-delete-brand tooltip" title="Delete Brand"><img src="<?=site_url("images/icons/delete.png")?>"  /></a> </td>
        </tr>
        <? endforeach; ?>
    </tbody>
</table>
<div align="right">
	<select id="per-page">
	<? for ($val = 5; $val<=50; $val+=5): ?>
    	<option value="<?=$val?>" <?=($val == $this->session->userdata("pagination_per_page")) ? "checked" : ""?>><?=$val?></option>
    <? endfor;?>
    </select>
	<?=$pages?>
    
</div>
</div>


