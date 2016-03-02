<?php
/**
 * Frontend view
 *
 * @package TM_Subscribe_And_Share_Widget
 */
?>
{{ $before_widget }}
<!-- Widget -->
<div class="tm-subscribe-and-share-widget text-center inset-3">
	@foreach( $blocks as $file => $name )
		@include( $folder_path .'/' . $file )
	@endforeach
</div>
<!-- End widget -->
{{ $after_widget }}
