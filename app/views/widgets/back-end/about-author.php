<?php
/**
 * Admin view
 *
 * @package TM_Posts_Widget
 */
?>
<!-- Widget Form -->
<div class="tm-about-author-form-widget">
	<p>
		{{ $title_html }}
	</p>

	<p>
		<label for="user_id">{{ __( 'Author', 'blogetti' ) }}</label>
		{{ $users_html }}
	</p>

	<p>
		{{ $url_html }}
	</p>

	<p>
		{{ $text_link_html }}
	</p>

	<p>
		<label>{{ __( 'Custom image', 'blogetti' ) }}</label><br/>
		{{ $upload_html }}
		<span class="delete-avatar-button"
			  @if( ! $is_avatar )
			  style="display: none;"
			  @endif
			  >
			{{ $delete_image_html }}
		</span>
		{{ $image_html }}
	</p>

	<p class="avatar" id="{{ $avatar_id }}">
		<img default_image="{{ $default_image }}" src="{{ $avatar }}">
	</p>

	<p>&nbsp;</p>
</div>
<!-- End widget Form -->
