
<?php
/**
 * Blocks/Comment_Form_fields/Email view
 *
 * @package photolab
 */
?>
<div class="comment-form-email">
	<div class="label">
		<em class="h6-style">
			{{ __( 'Your e-mail', 'blogetti' ) }} <span class="required accent1-color">*</span>
		</em>
	</div>
	<input class="comment-form-input" id="email" name="email" {{ $type }} value="{{ $value }}" size="30"{{ $aria_req }} />
</div>