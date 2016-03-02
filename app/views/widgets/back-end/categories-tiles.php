<?php
/**
 * Admin view
 *
 * @package TM_Categories_Tiles_Widget
 */
?>
<!-- Widget Form -->
<div class="tm-categories-tiles-form-widget">
	<p>
		{{ $title_html }}
	</p>

	<p>
		<label>{{ __( 'Theme', 'blogetti' ) }}</label>
		{{ $theme_html }}
	</p>

	<div class="show-count">
		<label>{{ __( 'Show posts count', 'blogetti' ) }}</label>
		{{ $show_count_html }}
	</div>

	<!--p>
		{{ $margin_html }}
	</p-->

	<div class="categories" count="{{ count( $tiles_items ) }}">
		@if( is_array( $tiles_items ) && count( $tiles_items ) > 0 )
			@foreach( $tiles_items as $key => $tile_item )
			<div class="category-area">
				<i class="fa fa-times delete-category"></i>
				<h3>{{ __( 'Category', 'blogetti' ) }} <span>{{ ($key + 1) }}</span></h3>
				<p>
					{{ $tile_item['category'] }}
				</p>

				<p>
					<label>{{ __( 'Category image', 'blogetti' ) }}</label><br/>
					{{ $tile_item['image'] }}
				</p>

				<div class="upload-image">
					<i class="fa fa-times delete-image-url"></i>
					@if( ! empty( $tile_item['src'] ) )
					<img default_image="{{ $default_image }}" src="{{ $tile_item['src'] }}">
					@else
					<img default_image="{{ $default_image }}" src="{{ $default_image }}">
					@endif
				</div>
			</div>
			@endforeach
		@endif
		<div class="category-new">
			<i class="fa fa-times delete-category"></i>
			<h3>{{ __( 'Category', 'blogetti' ) }} <span></span></h3>
			<p>
				{{ $tile_new['category'] }}
			</p>

			<p>
				<label>{{ __( 'Category image', 'blogetti' ) }}</label><br/>
				{{ $tile_new['image'] }}
			</p>

			<div class="upload-image">
				<i class="fa fa-times delete-image-url"></i>
				<img default_image="{{ $default_image }}" src="{{ $default_image }}">
			</div>
		</div>
		<i class="add-category fa fa-plus-square"> add category</i>
	</div>

	<p>&nbsp;</p>
</div>
<!-- End widget Form -->
