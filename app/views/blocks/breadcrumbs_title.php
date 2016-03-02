@if ( is_archive() && !is_tax() && !is_category() && !is_tag() )
	<li class="h4-style item-archive">{{ post_type_archive_title($prefix, false) }}</li>
@elseif ( is_archive() && is_tax() && !is_category() && !is_tag() )
	<li class="h4-style item-archive">{{ $custom_tax_name }}</li>
@elseif ( is_single() )
	@if(!empty($last_category))
		<li class="h4-style item-{{ $post->ID }}">{{ get_the_title() }}</li>
	@elseif(!empty($cat_id))
		<li class="h4-style item-{{ $post->ID }}">{{ get_the_title() }}</li>
	@else 
		<li class="h4-style item-{{ $post->ID }}">{{ get_the_title() }}</li>
	@endif
@elseif ( is_category() ) 
	<li class="h4-style item-cat">{{ single_cat_title('', false) }}</li>
@elseif ( is_page() )
	@if( $post->post_parent )
		<li class="h4-style item-{{ $post->ID }}"> {{ get_the_title() }}</li>
	@else
		<li class="h4-style item-{{ $post->ID }}"> {{ get_the_title() }}</li>
	@endif
@elseif ( is_tag() )
	<li class="h4-style item-tag-{{ $get_term_id }} item-tag-{{ $get_term_slug }}">{{ $get_term_name }}</li>
@elseif ( is_day() )
	<li class="h4-style item-{{ get_the_time('j') }}"> {{ get_the_time('jS') }} {{ get_the_time('M') }} Archives</li>
@elseif ( is_year() )
	<li class="h4-style active-{{ get_the_time('Y') }}">{{ get_the_time('Y') }} Archives</li>
@elseif ( is_author() )
	<li class="h4-style active-{{ $userdata->user_nicename }}">Author: {{ $userdata->display_name }}</li>
@elseif ( get_query_var('paged') )
	<li class="h4-style active-{{ get_query_var('paged') }}">{{ __('Page', 'blogetti') }} {{ get_query_var('paged') }}</li>
@elseif ( is_search() )
	<li class="h4-style active-{{ get_search_query() }}">Search results for: {{ get_search_query() }}</li>
@elseif ( is_404() )
	<li class="h4-style">Error 404</li>
@endif