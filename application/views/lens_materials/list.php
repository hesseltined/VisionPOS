    <br style="clear:both" />
    <br/>
&nbsp;

<div  style="width:80%; margin:auto">

<button id="create-lens-material">Add Lens Material</button>
<table id="tbl-materials" width="100%" border="0" align="center" class="blue-table-b">
	<thead>
    	<tr>
            <th align="left">Design</th> 
            <th align="left">Material</th>
            <th align="left">Retail Price</th>
            <th align="left">Cost Price</th>
            <th></th>
        </tr>
    </thead>
    
    <tbody>
    
    	<? foreach($lenses->result() as $lens): ?>
    	<tr>
        	<td><?=$lens->design?></td>
            <td><a href="#" class="a-material" id="<?=$lens->id?>"><?=$lens->material?></a></td>
            <td><?=$lens->retail_price?></td>
            <td><?=$lens->cost_price?></td>
            <td> <a href="#" rel="<?=$lens->id?>" material_name="<?=$lens->material?>" class="a-delete-material tooltip" title="Delete Material"><img src="<?=site_url("images/icons/delete.png")?>"  /></a> </td>
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

