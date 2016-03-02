<?php
/**
 * Widgets/Front end/Accordion view
 *
 * @package photolab
 */
?>{{ $before_widget }}
@if($title != '')
	{{ $before_title }}{{ apply_filters( 'widget_title', $title ) }}{{ $after_title }}
@endif
@if(count($posts))
	<div class="accordion">
	@foreach ($posts as $p)
		<h3><em>{{ $p->post_title }}</em></h3>
		<div style="display: none;">{{ $p->post_content }}</div>
	@endforeach
	</div>
@endif
{{ $after_widget }}
