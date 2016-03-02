<?php
/**
 * Widgets/Front end/Google plus view
 *
 * @package photolab
 */
?>{{ $before_widget }}
@if($title != '')
	{{ $before_title }}{{ apply_filters( 'widget_title', $title ) }}{{ $after_title }}
@endif
@if((int) $page_id > 0)
	<script src="https://apis.google.com/js/platform.js" async defer>
	  {lang: 'ru'}
	</script>
	<div class="g-person" data-href="//plus.google.com/u/0/{{ $page_id }}" data-rel="author"></div>
@else
	<span class="none">Page id not found!</span>
@endif
{{ $after_widget }}
