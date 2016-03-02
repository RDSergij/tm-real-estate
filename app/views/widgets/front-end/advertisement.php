<?php
/**
 * Widgets/Front end/Advertisement view
 *
 * @package photolab
 */
?>{{ $before_widget }}
<div class="banner">
    <div class="banner-img invert">
        @if(trim($image) != '')
            <img src="{{ $image }}" alt="image" width="370" height="208">
        @else
        	<span class="none">Image not found!</span>
        @endif
        <a href="{{ $url }}">
            <div class="banner-overlay">
                @if( $title != '' )
    			{{ $before_title }}{{ apply_filters( 'widget_title', $title ) }}{{ $after_title }}
                @endif
    			@if( $description != '' )
    			<p>{{ $description }}</p>
    			@endif
            </div>
        </a>
    </div>
</div>
{{ $after_widget }}
