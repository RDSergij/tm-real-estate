<form action="" class="search-form">
	
	<label for="keyword"><?php _e( 'Keyword', 'tm-real-estate' ); ?></label>
	<input type="text" name="keyword" id="keyword" placeholder="Any">

	<?php if ( is_array( $__data['property_statuses'] ) && count( $__data['property_statuses'] ) ) : ?>
		<label for="property_status"><?php _e( 'Property status', 'tm-real-estate' ); ?></label>
		<select name="property_status" id="property_status">
			<option value=""><?php _e( 'Any', 'tm-real-estate' ); ?></option>
		<?php foreach ( $__data['property_statuses'] as $value => $name ) : ?>
			<option value="<?php echo $value; ?>"><?php echo __( $name, 'tm-real-estate' ); ?></option>
		<?php endforeach; ?>
		</select>
	<?php endif; ?>

	<?php if ( is_array( $__data['property_types'] ) && count( $__data['property_types'] ) ) : ?>
		<label for="property_type"><?php _e( 'Property type', 'tm-real-estate' ); ?></label>
		<select name="property_type" id="property_type">
			<option value=""><?php _e( 'Any', 'tm-real-estate' ); ?></option>
		<?php foreach ( $__data['property_types'] as $type ) : ?>
			<option value="<?php echo $type->term_id; ?>"><?php echo __( $type->name, 'tm-real-estate' ); ?></option>
		<?php endforeach; ?>
		</select>
	<?php endif; ?>

</form>