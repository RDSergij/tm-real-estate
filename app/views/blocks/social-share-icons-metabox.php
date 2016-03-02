<?php
/**
 * Blocks/Social sahre icon metabox view
 *
 * @package photolab
 */
?><label for="{{ $name }}"> {{ __( 'Is show social share icons on page?', 'blogetti' ) }}: </label>
<input type="checkbox" {{ $checked }} name="{{ $name }}" id="{{ $name }}">