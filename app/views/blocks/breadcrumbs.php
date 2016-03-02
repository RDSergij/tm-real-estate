<?php
/**
 * Breadcrumbs view
 *
 * @package photolab
 */
?>
@if ( count( $items ) )
	<div class="row">
		<div class="col-xs-12">
			<div class="breadcrumbs">
				@if ( $is_show_title )
					<div class="breadcrumbs_page-title h4-style"><em>{{ $last['__LABEL__'] }}</em></div>
				@endif
				<ol class="breadcrumbs_list">			
					@foreach( $items as $item )
						<li><a href="{{ $item['__URL__'] }}">{{ $item['__LABEL__'] }}</a></li>
					@endforeach
					<li class="active">{{ $last['__LABEL__'] }}</li>
				</ol>
			</div>
		</div>
	</div>
@endif
