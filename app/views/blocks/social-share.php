<ul class="social-share">
	<li class="facebook">
		<a href="http://www.facebook.com/sharer.php?u={{ get_permalink() }}" target="blank"><i class="fa fa-facebook"></i></a>
	</li>
	<li class="twitter">
		<a href="https://twitter.com/intent/tweet?text={{ get_the_title() }}&url={{ get_permalink() }}" target="blank"><i class="fa fa-twitter"></i></a>
	</li>	
	<li class="google-plus">
		<a href="https://plus.google.com/share?url={{ get_permalink() }}" target="blank"><i class="fa fa-google-plus"></i></a>
	</li>
	<li class="linkedin">
		<a href="https://www.linkedin.com/shareArticle?mini=true&url={{ get_permalink() }}&title={{ get_the_title() }}" target="blank"><i class="fa fa-linkedin"></i></a>
	</li>

	@if( has_post_thumbnail() )  
		<li class="pinterest">
			<a href="https://pinterest.com/pin/create/button/?url={{ get_permalink() }}&media={{ Model_Main::get_post_thumbnail_url( $post = null, $size = 'thumbnail' ) }}&description={{ get_the_excerpt() }}" target="blank"><i class="fa fa-pinterest"></i></a>
		</li>
	@endif

</ul>
