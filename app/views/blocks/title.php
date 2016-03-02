<?php
/**
 * Blocks/Title view
 *
 * @package photolab
 */
?>@if ( is_category() )
	<h1> {{ single_cat_title('', false) }}</h1>
@elseif ( is_tag() )
	<h1>{{ single_tag_title('', false) }}</h1>
@elseif ( is_author() )
	<h1>{{ sprintf( __( 'Author: %s', 'blogetti' ), '<span class="vcard">' . get_the_author() . '</span>' ) }}</h1>
@elseif ( is_day() )
	<h1>{{ sprintf( __( 'Day: %s', 'blogetti' ), '<span>' . get_the_date() . '</span>' ) }}</h1>
@elseif ( is_month() )
	<h1>{{ sprintf( __( 'Month: %s', 'blogetti' ), '<span>' . get_the_date( _x( 'F Y', 'monthly archives date format', 'blogetti' ) ) . '</span>' ) }}</h1>
@elseif ( is_year() )
	<h1>{{ sprintf( __( 'Year: %s', 'blogetti' ), '<span>' . get_the_date( _x( 'Y', 'yearly archives date format', 'blogetti' ) ) . '</span>' ) }}</h1>
@elseif ( is_tax( 'post_format', 'post-format-aside' ) )
	<h1>{{ __( 'Asides', 'blogetti' ) }}</h1>
@elseif ( is_tax( 'post_format', 'post-format-gallery' ) )
	<h1>{{ __( 'Galleries', 'blogetti') }}</h1>
@elseif ( is_tax( 'post_format', 'post-format-image' ) )
	<h1>{{ __( 'Images', 'blogetti') }}</h1>
@elseif ( is_tax( 'post_format', 'post-format-video' ) ) 
	<h1>{{ __( 'Videos', 'blogetti' ) }}</h1>
@elseif ( is_tax( 'post_format', 'post-format-quote' ) )
	<h1>{{ __( 'Quotes', 'blogetti' ) }}</h1>
@elseif ( is_tax( 'post_format', 'post-format-link' ) )
	<h1>{{ __( 'Links', 'blogetti' ) }}</h1>
@elseif ( is_tax( 'post_format', 'post-format-status' ) )
	<h1>{{ __( 'Statuses', 'blogetti' ) }}</h1>
@elseif ( is_tax( 'post_format', 'post-format-audio' ) )
	<h1>{{ __( 'Audios', 'blogetti' ) }}</h1>
@elseif ( is_tax( 'post_format', 'post-format-chat' ) )
	<h1>{{ __( 'Chats', 'blogetti' ) }}</h1>
@elseif ( is_search() )
	<h1 class="page-title">{{ sprintf( __( 'Search Results for: %s', 'blogetti' ), '<span>' . get_search_query() . '</span>' ) }}</h1>
@elseif ( is_single() )
	<div class="entry-meta">
		@include('blocks/posted-on')
	</div><!-- .entry-meta -->
	{{ the_title( '<h1 class="entry-title">', '</h1>', false ) }}
@elseif ( is_page() )
	{{ the_title( '<h1 class="entry-title">', '</h1>', false ) }}
@elseif ( is_404() )
	<h1 class="entry-title">{{ __( 'Error 404', 'blogetti' ) }}</h1>
@else 
	<h1>{{ __( 'Archives', 'blogetti' ) }}</h1>
@endif
