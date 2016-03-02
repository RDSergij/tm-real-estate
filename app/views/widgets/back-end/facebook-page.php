<?php
/**
 * Admin view
 *
 * @package TM_Facebook_Page_Widget
 */
?>

<div class="tm-facebook-page-form-widget">
	<p>
		{{ $title_html }}
	</p>

	<p>
		{{ $app_id_tooltip_html }}
		{{ $app_id_html }}
	</p>

	<p>
		{{ $page_title_html }}
	</p>

	<p>
		{{ $facebook_url_html }}
	</p>

	<p>
		<label>{{ __( 'Tabs', 'blogetti' ) }}</label>
		{{ $tabs_html }}
	</p>

	<p>
		{{ $width_html }}
	</p>

	<p>
		{{ $height_html }}
	</p>

	<div>
		<label>
		{{ __( 'Small header', 'blogetti' ) }}
		{{ $small_header_html }}
		</label>
	</div>
	<br/>

	<div>
		<label>
		{{ __( 'Adaptive width', 'blogetti' ) }}
		{{ $adaptive_width_html }}
		</label>
	</div>
	<br/>

	<div>
		<label>
		{{ __( 'Hide cover', 'blogetti' ) }}
		{{ $hide_cover_html }}
		</label>
	</div>
	<br/>

	<div>
		<label>
		{{ __( 'Freind`s face', 'blogetti' ) }}
		{{ $freinds_face_html }}
		</label>
	</div>

	<p>&nbsp;</p>
</div>
