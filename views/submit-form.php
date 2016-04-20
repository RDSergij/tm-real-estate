<?php
/**
 * Submit form View
 *
 * @package    TM Real Estate
 * @subpackage View
 * @author     Cherry Team <cherryframework@gmail.com>
 * @copyright  Copyright (c) 2012 - 2016, Cherry Team
 * @link       http://www.cherryframework.com/
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */
?>

<form class="" action="" method="post" enctype="multipart/form-data" name="" id="property_submit_format">
	<div>
		<label class="label-block" id="property_title_label" for="property_title_input"><?php _e( 'Title', 'tm-real-estate' ); ?></label>
		<input type="text" class ="form-textbox"  id="property_title_input" name="property[title]" value="">
	</div>

	<div>

		<label class="label-block" id="property_price_label" for="property_price_input"><?php _e( 'Price', 'tm-real-estate' ); ?></label>
		<input type="number" class="form-textbox" id="property_price_input" name="property[meta][price]" step="any" min="0" value="">
	</div>
	<div>
		<label class="label-block" id="property_description_label" for="property_description_input"><?php _e( '', 'tm-real-estate' ); ?> Description </label>
		<textarea id="property_description_input" class="form-textarea" name="property[description]" cols="40" rows="6"></textarea>
	</div>
	<div>
		<label class="label-block" id="property_thumb_label" for="property_thumb_label"><?php _e( 'Image', 'tm-real-estate' ); ?></label>
		<input class="form-upload validate[upload]" type="file" id="property_thumb_input" name="thumb" file-accept="jpg, jpeg, png, gif" file-maxsize="1024" file-minsize="0" file-limit="0">
	</div>
	<div>
		<label class="label-block" id="property_status_label" ><?php _e( 'Status', 'tm-real-estate' ); ?></label>
		<input type="radio" class="form-radio" id="property_status_input_1" checked name="property[meta][status]" value="rent">
		<label id="property_status_label_1" for="property_status_input_1" ><?php _e( 'rent', 'tm-real-estate' ); ?></label>
		<input type="radio" class="form-radio" id="property_status_input_2" name="property[meta][status]" value="sale">
		<label id="property_status_label_2" for="property_status_input_2"><?php _e( 'sale', 'tm-real-estate' ); ?></label>
	</div>
	<div>
		<label class="label-block" id="property_type_label" for="property_type_input"><?php _e( 'Type', 'tm-real-estate' ); ?></label>
		<select class="form-dropdown" id="property_type_input" name="property[type]">
			<option disabled selected value="">  </option>
			<?php foreach ( $__data['terms'] as $type ) { ?>
				<optgroup label="<?php echo $type['name']; ?>">
					<?php foreach ( $type['child'] as $child ) { ?>
						<option value="<?php echo $child['term_id']; ?>"><?php echo $child['name']; ?></option>
					<?php } ?>
				</optgroup>
			<?php } ?>
		</select>
	</div>
	<div>
		<label class="label-block" for="location"><?php _e( 'Location', 'tm-real-estate' ); ?></label>
		<select class="form-dropdown" id="location" name="property[location]">
		<?php foreach ( $__data['locations'] as $key => $value ) :?>
			<option value="<?php echo $key; ?>"><?php echo $value; ?></option>
		<?php endforeach; ?>
		</select>
	</div>
	<div>
		<label class="label-block" id="property_bathrooms_label" for="property_bathrooms_input"><?php _e( 'Bathrooms', 'tm-real-estate' ); ?></label>
		<input type="number" id="property_bathrooms_input"  min="0" name="property[meta][bathrooms]" value="">
	</div>
	
	<div>
		<label class="label-block" id="property_bedrooms_label" for="property_bedrooms_input"><?php _e( 'Bedrooms', 'tm-real-estate' ); ?></label>
		<input type="number" id="property_bedrooms_input" name="property[meta][bedrooms]" min="0" value="">
	</div>
	<div>
		<label class="label-block" id="property_area_label" for="property_area_input"><?php _e( 'Area', 'tm-real-estate' ); ?></label>
		<input type="number" id="property_area_input" name="property[meta][area]" min="0" value="">
	</div>
	<div>
		<label class="label-block" id="property_parking_label" for="property_parking_input"><?php _e( 'Parking places', 'tm-real-estate' ); ?></label>
		<input type="number" id="property_parking_input" name="property[meta][parking_places]" min="0" value="">
	</div>
	<div>
		<label class="label-block" id="property_map_label" for="property_map_input"><?php _e( 'Adress', 'tm-real-estate' ) ?></label>
		<input type="text" id="property_map_input" name="property[meta][address]" value="">
	</div>

	<div>
		<label class="label-block" id="property_phone_label" for="property_phone_input"><?php _e( 'Phone', 'tm-real-estate' ) ?></label>
		<input type="text" id="property_phone_input" name="property[meta][phone]" value="" <?php echo $__data['required_for_gests']; ?>>
	</div>

	<?php if ( ! is_user_logged_in() ) : ?>
		<div>
			<label class="label-block" id="property_map_label" for="property_email"><?php _e( 'Your email', 'tm-real-estate' ) ?></label>
			<input type="email" id="property_email" name="property[meta][email]" value="">
		</div>
	<?php endif; ?>
	<div>
		<label class="label-block" id="label_14" for="input_14"><?php _e( 'Gallery', 'tm-real-estate' ); ?></label>
		<span class="btn btn-success fileinput-button">
			<i class="glyphicon glyphicon-plus"></i>
			<span class="btn-success" ><?php _e( 'Add files...', 'tm-real-estate' ); ?></span>
			<!-- The file input field used as target for the file upload widget -->
			<input id="galery" type="file" name="galery[image][]" multiple>
		</span>
	</div>
	<div id="files" class="files" style="margin: 10px; text-align: center;"></div>

	<div>
		<button id="input_2" type="submit" class="form-submit-button"><?php _e( 'Submit', 'tm-real-estate' ); ?></button>
	</div>
</form>
<div class="tm-form-preloader">
	<div class="cssload-loader">
		<div class="cssload-inner cssload-one"></div>
		<div class="cssload-inner cssload-two"></div>
		<div class="cssload-inner cssload-three"></div>
	</div>
</div>
