<?php
/**
 * Blocks/Comment_Form_fields/URL view
 *
 * @package photolab
 */
?>
<div class="comment-form-url">
	<div class="label">
		<em class="h6-style">
			{{ __( 'Your website', 'blogetti' ) }} <span class="required accent1-color">*</span>
		</em>
	</div>
	<input class="comment-form-input" id="url" name="url" {{ $type }} value="{{ $value }}" size="30" />
</div>