<?php wp_editor( $field['value'], $field['atts']['id'], $field['settings'] ); ?>

<?php if ( isset( $field[ 'features' ][ 'info' ] ) ) ?>
	<div class="themosis-field-info">
	    <p><?php echo $field['features']['info'] ?></p>
	</div>
<?php endif; ?>