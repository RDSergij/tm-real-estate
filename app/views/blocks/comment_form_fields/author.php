<?php
/**
 * Blocks/Comment_Form_Fields/Author view
 *
 * @package photolab
 */
?>
<div class="comment-form-author">
	<div class="label">
		<em class="h6-style">
			{{ __( 'Your name', 'blogetti' ) }} <span class="required accent1-color">*</span>
		</em>
	</div>
	<input class="comment-form-input" id="author" name="author" type="text" value="{{ $value }}" size="30"{{ $aria_req }} />
</div>