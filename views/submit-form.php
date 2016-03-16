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
		<?php foreach ( $__data as $type ) { ?>
			<optgroup label="<?php echo $type['name']; ?>">
				<?php foreach ( $type['child'] as $child ) { ?>
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
	<span class="btn btn-success fileinput-button">
		<i class="glyphicon glyphicon-plus"></i>
		<span>Add files...</span>
		<!-- The file input field used as target for the file upload widget -->
		<input id="galery" type="file" name="galery[image][]" multiple>
	</span>

	<div id="files" class="files" style="margin: 10px; text-align: center;"></div>

	<button id="input_2" type="submit" class="form-submit-button">Submit</button>

</form>

<script>
	/*jslint unparam: true, regexp: true */
	/*global window, $ */
	var filesData = []
	var filesCount = 0;
	jQuery(function ($) {
		'use strict';

		// Change this to the location of your server-side upload handler:
		var url = window.location.hostname === 'blueimp.github.io';
		$('#galery').fileupload({
			filesCount: 0,
			url: url,
			dataType: 'json',
			autoUpload: false,
			acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i,
			maxFileSize: 999000,
			// Enable image resizing, except for Android and Opera,
			// which actually support image resizing, but fail to
			// send Blob objects via XHR requests:
			disableImageResize: /Android(?!.*Chrome)|Opera/
					.test(window.navigator.userAgent),
			previewMaxWidth: 100,
			previewMaxHeight: 100,
			previewCrop: true
		}).on('fileuploadadd', function (e, data) {
			data.context = $('<div class="col-xs-6 col-sm-2">').appendTo('#files');

			$.each(data.files, function (index, file) {
				var node = $('<p class="text-center"/>')
						.append($('<span/>').text(file.name))
						.append($('<input type="text" name="property[meta][gallery][title][' + filesCount + ']"/><span class="close" data-index="' + filesCount + '" ></span>'));
				filesData[filesCount] = file;
				filesCount++;

				if (!index) {
					node.append('<br>')
				}
				node.appendTo(data.context);
			});
		}).on('fileuploadprocessalways', function (e, data) {
			var index = data.index,
					file = data.files[index],
					node = $(data.context.children()[index]);
			if (file.preview) {
				node
						.prepend('<br>')
						.prepend(file.preview);
			}
			if (file.error) {
				node
						.append('<br>')
						.append($('<span class="text-danger"/>').text(file.error));
			}
			if (index + 1 === data.files.length) {
				data.context.find('button')
						.text('Upload')
						.prop('disabled', !!data.files.error);
			}
		});

	}(jQuery));
	jQuery(document).on('click', 'span.close', function () {
		filesData.splice($(this).data('index'), 1);
		jQuery(this).parent().parent().remove();
	})
</script>
<script>
	jQuery('#property_submit_format').on('submit', function (event) {
		formData = new FormData(this);
		if ( filesCount ) {
			for( var i = 0; i < filesCount; i ++ ) {
				formData.append('gallery[' + i + ']', filesData[ i ] );
			}
		}
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
