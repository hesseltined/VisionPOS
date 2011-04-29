<p class="validateTips">All form fields are required.</p>
<form id="form-lens-design-detail">
	<p>
    <label>Brand: </label>
    <select name="brand_id" id="brand_id">
    	<option value="0">Select Brand</option>
        <? foreach($brands->result() as $brand): ?>
        	<option <?=(@$lens_design->brand_id == $brand->id) ? "selected" : ""  ?> value="<?=$brand->id?>"><?=$brand->brand?></option>
        <? endforeach; ?>
    </select>
    </p>
    
    <p>
    	<label>Design:</label>
        <input type="text" name="design" id="design-name" size="30" value="<?=@$lens_design->design?>" />
    </p>
    
    <input type="hidden" name="id" value="<?=$id?>" />
    
</form>