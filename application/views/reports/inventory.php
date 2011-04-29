    <br style="clear:both" />
    <br/>
&nbsp;

<div  style="width:80%; margin:auto">

<h3>Inventory Report</h3>
<div align="right">
	<a href="<?=site_url("reports/inventory_to_csv")?>" class="tooltip" title="Export to CSV"><img src="<?=site_url("images/icons/page_white_excel.png")?>" /></a>
</div>

<table id="tbl-materials" width="100%" border="0" align="center" class="blue-table-b">
	<thead>
    	<tr>
            <th align="left">Manufacturer</th> 
            <th align="left">Division</th>
            <th align="left">Name</th>
            <th align="left">Color</th>
            <th align="left">Eye Size</th>
            <th align="left">Bridge Size</th>
            <th align="left">Temple Size</th>
            <th align="left">Cost Price</th>
            <th align="left">Retail Price</th>
            <th align="left">Store Name</th>
        </tr>
    </thead>
    
    <tbody>
    
    	<? foreach($inventory->result() as $item): ?>
    	<tr>
        	<td><?=$item->manufacturer?></td>
            <td><?=$item->division?></td>
            <td><?=$item->name?></td>
            <td><?=$item->color?></td>
            <td><?=$item->eye_size_min?></td>
            <td><?=$item->bridge_size?></td>
            <td><?=$item->temple_size?></td>
            <td><?=$item->cost_price?></td>
            <td><?=$item->retail_price?></td>
            <td><?=$item->store_name?></td>
        </tr>
        <? endforeach; ?>
    </tbody>
</table>

</div>

