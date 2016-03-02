<?php
/**
 * Blocks/Posted on view
 *
 * @package photolab
 */
?><time class="entry-date published" datetime="{{ esc_attr( get_the_date( 'c' ) ) }}"><a href="{{ get_permalink() }}">{{ esc_html( get_the_date() ) }}</a></time>
@if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) 
<time class="updated" datetime="{{ esc_attr( get_the_modified_date( 'c' ) ) }}"><a href="{{ get_permalink() }}">{{ esc_html( get_the_modified_date() ) }}</a></time>
@endif
