<?php
/**
 * Search form View
 *
 * @package    TM Real Estate
 * @subpackage View
 * @author     Cherry Team <cherryframework@gmail.com>
 * @copyright  Copyright (c) 2012 - 2016, Cherry Team
 * @link       http://www.cherryframework.com/
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */
?>
<form action="<?php echo $__data['action_url'] ?>" class="search-form">

	<input type="hidden" name="show_sorting" value="<?php echo $__data['values']['show_sorting']; ?>">
	<input type="hidden" name="orderby" value="<?php echo $__data['values']['orderby']; ?>">
	<input type="hidden" name="order" value="<?php echo $__data['values']['order']; ?>">

	<label for="keyword"><?php _e( 'Keyword', 'tm-real-estate' ); ?></label>
	<input type="text" name="keyword" id="keyword" placeholder="Any" value="<?php echo $__data['values']['keyword']; ?>">

	<label for="min_price"><?php _e( 'Min Price', 'tm-real-estate' ); ?></label>
	<input type="number" min="0" name="min_price" id="min_price" placeholder="Any" value="<?php echo $__data['values']['min_price']; ?>">

	<label for="max_price"><?php _e( 'Max Price', 'tm-real-estate' ); ?></label>
	<input type="number" min="0" name="max_price" id="max_price" placeholder="Any" value="<?php echo $__data['values']['max_price']; ?>">

	<label for="min_bedrooms"><?php _e( 'Min Bedrooms', 'tm-real-estate' ); ?></label>
	<input type="number" min="0" name="min_bedrooms" id="min_bedrooms" placeholder="Any" value="<?php echo $__data['values']['min_bedrooms']; ?>">

	<label for="min_bedrooms"><?php _e( 'Max Bedrooms', 'tm-real-estate' ); ?></label>
	<input type="number" min="0" name="max_bedrooms" id="max_bedrooms" placeholder="Any" value="<?php echo $__data['values']['max_bedrooms']; ?>">

	<label for="min_bathrooms"><?php _e( 'Min Bathrooms', 'tm-real-estate' ); ?></label>
	<input type="number" min="0" name="min_bathrooms" id="min_bathrooms" placeholder="Any" value="<?php echo $__data['values']['min_bathrooms']; ?>">

	<label for="min_bathrooms"><?php _e( 'Max Bathrooms', 'tm-real-estate' ); ?></label>
	<input type="number" min="0" name="max_bathrooms" id="max_bathrooms" placeholder="Any" value="<?php echo $__data['values']['max_bathrooms']; ?>">

	<label for="min_area"><?php _e( 'Min Area', 'tm-real-estate' ); ?></label>
	<input type="number" min="0" name="min_area" id="min_area" placeholder="Any" value="<?php echo $__data['values']['min_area']; ?>">

	<label for="max_area"><?php _e( 'Max Area', 'tm-real-estate' ); ?></label>
	<input type="number" min="0" name="max_area" id="max_area" placeholder="Any" value="<?php echo $__data['values']['max_area']; ?>">

	<?php if ( is_array( $__data['property_statuses'] ) && count( $__data['property_statuses'] ) ) : ?>
		<label for="property_status"><?php _e( 'Property status', 'tm-real-estate' ); ?></label>
		<select name="property_status" id="property_status">
			<option value=""><?php _e( 'Any', 'tm-real-estate' ); ?></option>
		<?php foreach ( $__data['property_statuses'] as $value => $name ) : ?>
			<option value="<?php echo $value; ?>" <?php echo ( ( $value == $__data['values']['property_status'] ) ? ' selected="selected" ': '' ) ?>>
				<?php echo __( $name, 'tm-real-estate' ); ?>
			</option>
		<?php endforeach; ?>
		</select>
	<?php endif; ?>

	<?php if ( is_array( $__data['property_types'] ) && count( $__data['property_types'] ) ) : ?>
		<label for="property_type"><?php _e( 'Property type', 'tm-real-estate' ); ?></label>
		<select name="property_type" id="property_type">
			<option value=""><?php _e( 'Any', 'tm-real-estate' ); ?></option>
		<?php foreach ( $__data['property_types'] as $type ) : ?>
			<option value="<?php echo $type->term_id; ?>" <?php echo ( ( $type->term_id == $__data['values']['property_type'] ) ? ' selected="selected" ': '' ) ?>>
				<?php echo __( $type->name, 'tm-real-estate' ); ?>
			</option>
		<?php endforeach; ?>
		</select>
	<?php endif; ?>

	<?php if ( is_array( $__data['locations'] ) && count( $__data['locations'] ) ) : ?>
	<label for="location"><?php _e( 'Location', 'tm-real-estate' ); ?></label>
	<select class="form-dropdown" id="location" name="property_location">
		<option value=""><?php _e( 'Any', 'tm-real-estate' ); ?></option>
		<?php foreach ( $__data['locations'] as $key => $value ) :?>
			<option value="<?php echo $key; ?>" <?php echo ( ( $key == $__data['values']['property_location'] ) ? ' selected="selected" ': '' ) ?>>
				<?php echo $value; ?>
			</option>
		<?php endforeach; ?>
	</select>
	<?php endif; ?>

	<button type="submit"><?php _e( 'Search', 'tm-real-estate' ); ?></button>
</form>
