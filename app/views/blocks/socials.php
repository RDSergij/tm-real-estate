<?php
/**
 * Blocks/Socials view
 *
 * @package photolab
 */
?>@if(is_array($socials) && count($socials))
<ul class="social-list list-{{ $where }}">
	@foreach($socials as $key => $properties)
		<li class="social-list_item  item-{{ $key }}">
			<a class="icon icon-xs icon-default fa {{ $properties['icon'] }}" href="{{ $properties['url'] }}"></a>
		</li>
	@endforeach
</ul>
@endif
