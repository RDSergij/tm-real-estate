<?php
/**
 * Admin view
 *
 * @package TM_Subscribe_And_Share_Widget
 */
?>

<div class="tm-subscribe-and-share-widget">
	<!-- Subscribe -->
	<br/>

	<div>
		<label>
			{{ __( 'What first?', 'blogetti' ) }}
			{{ $first_block_html }}
		</label>
	</div>
	<br/>

	<div>
		<label>
			{{ __( 'Show subscribe form', 'blogetti' ) }}
			{{ $subscribe_is_html }}
		</label>
	</div>

	<p>
		{{ $subscribe_title_html }}
	</p>

	<p>
		{{ $subscribe_description_html }}
	</p>

	<p>
		{{ $subscribe_button_html }}
	</p>

	<p>
		{{ $app_key_tooltip_html }}
		{{ $api_key_html }}
	</p>

	<p>
		{{ $list_id_tooltip_html }}
		{{ $list_id_html }}
	</p>

	<p>
		{{ $success_message_html }}
	</p>

	<p>
		{{ $failed_message_html }}
	</p>

	<p>
		{{ $warning_message_html }}
	</p>
	<!-- End subscribe -->

	<!-- Socials -->
	<br/>
	<div>
		<label>
			{{ __( 'Show social buttons', 'blogetti' ) }}
			{{ $social_is_html }}
		</label>
	</div>

	<p>
		{{ $social_title_html }}
	</p>

	<p>
		{{ $social_description_html }}
	</p>
	<div class="socials" count="{{ count( $social_items ) }}">
		@foreach ( $social_items as $index => $social )
		<div class="social-area">
			<i class="fa fa-times delete-social"></i>
			<h4>
				{{ __( 'Social button #', 'blogetti' ) }}<span>{{ $index + 1 }}</span>
			</h4>
			<p>
				{{ $social['service'] }}
			</p>

			<p>
				{{ $social['url'] }}
			</p>
		</div>
		@endforeach
		<div class="social-new">
			<i class="fa fa-times delete-social"></i>
			<h4>
				{{ __( 'Social button #', 'blogetti' ) }}<span></span>
			</h4>
			<p>
				{{ $social_new['service'] }}
			</p>

			<p>
				{{ $social_new['url'] }}
			</p>
		</div>
		<i class="add-social fa fa-plus-square"> add social</i>
	</div>
	<!-- End socials -->
	<p>&nbsp;</p>
</div>
