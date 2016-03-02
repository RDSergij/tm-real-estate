<?php
/**
 * Blocks/Socials view
 *
 * @package photolab
 */
?>@if(is_array($socials) && count($socials))
	@foreach($socials as $key => $properties)
		<a class="icon icon-xs icon-default fa {{ $properties['icon'] }}" href="{{ $properties['url'] }}"></a>
	@endforeach
@endif
