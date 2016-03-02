@if( $posttags  = get_the_tags() )
	@foreach ( $posttags as $tag )
		<a href="{{get_tag_link($tag->term_id)}}" class="tag-link h6-style block-style-1">{{ $tag->name }}</a>
	@endforeach
@endif