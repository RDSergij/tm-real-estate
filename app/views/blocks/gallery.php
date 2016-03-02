<!-- Owl Carousel -->

<?php if(is_single()) { ?>
	<div class="photolab-gallery owl-carousel popup-gallery">
<?php } else { ?>
	<div class="photolab-gallery owl-carousel">
<?php } ?>

	@foreach( $images as $id => $image )
		@if( ! empty( $image ) )
			<div class="owl-item ">
				
				<?php if(is_single()) { ?>
					<a href="{{ $image->guid }}" class="popup-gallery-link">
						<img src="{{ $image->src }}" alt="{{ $image->post_title }}"/>
					</a>
				<?php } else { ?>
					<img src="{{ $image->src }}" alt="{{ $image->post_title }}"/>
				<?php } ?>
				
			</div>
		@endif
	@endforeach
</div>
<!-- END Owl Carousel -->