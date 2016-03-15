<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<form class="" action="" method="post" enctype="multipart/form-data" name="" id="property_submit_format">

	<label class="" id="property_title_label" for="property_title_input"> Title </label>
	<input type="text" class=" form-textbox" data-type="input-textbox" id="property_title_input" name="property[title]" size="20" value="">

	<label class="" id="property_price_label" for="property_price_input"> Price </label>
	<input type="text" class=" form-textbox" data-type="input-textbox" id="property_price_input" name="property[meta][price]" size="20" value="">

	<label class="" id="property_description_label" for="property_description_input"> Description </label>
	<textarea id="property_description_input" class="form-textarea" name="property[description]" cols="40" rows="6"></textarea>

	<label class="" id="property_thumb_label" for="property_thumb_label"> Image </label>
	<input class="form-upload validate[upload]" type="file" id="property_thumb_input" name="thumb" file-accept="jpg, jpeg, png, gif" file-maxsize="1024" file-minsize="0" file-limit="0">

	<label class="" id="property_status_label" > Status </label>
	<input type="radio" class="form-radio" id="property_status_input_1" checked name="property[meta][status]" value="1">
	<label id="property_status_label_1" for="property_status_input_1" >rent</label>
	<input type="radio" class="form-radio" id="property_status_input_2" name="property[meta][status]" value="2">
	<label id="property_status_label_2" for="property_status_input_2">sale</label>
 
	<label class="" id="property_type_label" for="property_type_input"> Type </label>
	<select class="form-dropdown" style="width:150px" id="property_type_input" name="property[type]">
	<option disabled selected value="">  </option>
	<?php foreach ($__data as $type) { ?>
		<optgroup label="<?php echo $type['name']; ?>">
			<?php foreach ($type['child'] as $child) { ?>
				<option value="<?php echo $child['term_id']; ?>"><?php echo $child['name']; ?></option>
			<?php } ?>
		</optgroup>
	<?php } ?>
	</select>
	<label class="" id="property_bathrooms_label" for="property_bathrooms_input"> Bathrooms </label>
	<input type="number" id="property_bathrooms_input"  min="0" max="10" name="property[meta][bathrooms]" value="">

	<label class="" id="property_bedrooms_label" for="property_bedrooms_input"> Bedrooms </label>
	<input type="number" id="property_bedrooms_input" name="property[meta][bedrooms]" min="0" max="10" value="">

	<label class="" id="property_area_label" for="property_area_input"> Area </label>
	<input type="number" id="property_area_input" name="property[meta][area]" min="0" max="10" value="">

	<label class="" id="property_parking_label" for="property_parking_input"> Parking places </label>
	<input type="number" id="property_parking_input" name="property[meta][parking]" min="0" max="10" value="">

	<label class="" id="property_map_label" for="property_map_input"> Google map link </label>
	<input type="url" id="property_map_input" name="property[meta][map]" value="">

	<label class="form-label form-label-left form-label-auto" id="label_14" for="input_14"> Gallery </label>
	<input class="form-upload validate[upload]" type="file" id="input_14" name="gallerys[image][]" file-accept="pdf, doc, docx, xls, xlsx, csv, txt, rtf, html, zip, mp3, wma, mpg, flv, avi, jpg, jpeg, png, gif" file-maxsize="1024" file-minsize="0" file-limit="0">

	<button id="input_2" type="submit" class="form-submit-button">Submit</button>

</form>
 
<script>
	jQuery('#property_submit_format').on('submit', function(event){
		formData = new FormData(this);
		event.preventDefault();
		jQuery.ajax({
			url: form_url.url + '?action=submit_form',
			processData: false,
			contentType: false,
			method: "POST",
			dataType: "html",
			data: formData,
			
		});
	})
</script>
