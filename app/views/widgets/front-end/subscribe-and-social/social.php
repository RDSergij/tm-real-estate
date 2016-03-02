@if( 'true' === $social_is )
	<!-- Social section -->
	@if (!empty($social_title))
		<h4 class="social-title">{{ $social_title }}</h4>
	@endif
	
	@if (!empty($social_description))
		<p>{{ $social_description }}</p>
	@endif

	<ul class="social-list">
		@if ( ! empty( $social_buttons ) )
		@foreach ( $social_buttons as $social )
		@if( ! empty( $social['url'] ) && ! empty( $social['service'] ) )
		<li><a href="#" class="icon icon-xs icon-default fa fa-{{ strtolower( $social['service'] ) }}"></a></li>
		@endif
		@endforeach
		@endif
	</ul>
	<!-- End social section -->
@endif
