<?php echo Form::text( $field['name'], $field['value'], $field['atts'] ) ?>

<?php if ( isset( $field[ 'features' ][ 'info' ] ) ): ?>
	<div class="themosis-field-info">
	    <p><?php echo $field['features']['info'] ?></p>
	</div>
<?php endif; ?>