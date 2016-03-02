@if ( 'none' != $sidebar_name && is_active_sidebar( $sidebar_name ) )
	<div class="{{ $widget_area_class }}">
		<?php dynamic_sidebar( $sidebar_name ) ?>
	</div>
@endif