<p class="validateTips">All form fields are required.</p>
<form id="form-lens-brand-detail">
	<p>
    <label>Type: </label>
    <select name="type_id" id="type_id">
    	<option value="0">Select Type</option>
        <? foreach($types->result() as $type): ?>
        	<option <?=(@$lens_brand->type_id == $type->id) ? "selected" : ""  ?> value="<?=$type->id?>"><?=$type->type?></option>
        <? endforeach; ?>
    </select>
    </p>
    
    <p>
    	<label>Brand:</label>
        <input type="text" name="brand" id="brand-name" size="30" value="<?=@$lens_brand->brand?>" />
    </p>
    
    <input type="hidden" name="id" value="<?=$id?>" />
    
</form>