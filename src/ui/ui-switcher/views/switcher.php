<?php
/**
 * Description: Fox ui-elements
 * Author: Osadchyi Serhii
 * Author URI: https://github.com/RDSergij
 *
 * @package ui_switcher_fox
 *
 * @since 0.2.2
 */
?>

<div {{ $attributes }}>
    <input type="radio" name="{{ $name }}" id="{{ $name }}-{{ $value_first['key'] }}" value="{{ $value_first['key'] }}"
          @if( $value_first['key'] == $default )
          checked="checked"
          @endif
      />
    <label class="on" for="{{ $name }}-{{ $value_second['key'] }}"></label>

    <input type="radio" name="{{ $name }}" id="{{ $name }}-{{ $value_second['key'] }}" value="{{ $value_second['key'] }}"
          @if( $value_second['key'] == $default )
          checked="checked"
          @endif
      />
    <label class="off" for="{{ $name }}-{{ $value_first['key'] }}"></label>
</div>
