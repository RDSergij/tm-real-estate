<?php
/**
 * Blocks/Top menu view
 *
 * @package photolab
 */
?>
<div class="top-panel_container">
	<div class="container-fluid">
		<div class="row vertical-align__center">
		
			<div class="col-xs-12 col-md-6 col-md-5 top-panel_first-col hidden-sm-down">
				{{ $top_menu }}
			</div>

			<div class="col-xs-12 col-md-6 top-panel_second-col align-right hidden-sm-down">
				@if ( '' != $top_panel_disclimer_text )
					<div class="disclaimer hidden-sm-down">
						<em class="h6-style">{{ $top_panel_disclimer_text }}</em>
					</div>
				@endif

				@if ( $top_panel_show_search )
					<div class="search-panel header-panel">
						{{ $search_form_header }}
					</div>
				@endif

				@if (function_exists('icl_object_id'))
					<div class="lang-switcher hidden-sm-down">
						{{ do_action('wpml_add_language_selector') }}
					</div>
				@endif
			</div>
		</div>

		<div class="row vertical-align__center">
			<div class="col-xs-12 hidden-md-up hamburger-container">
				<div class="row vertical-align__center">
					<div class="col-xs-3">
						<div class="hamburger-toggle align-left"><a href="#" id="hamburger-button"><i class="material-icons">menu</i></a></div>
					</div>
					<div class="col-xs-9">
						<div class="search-panel header-panel">
							@if ( $top_panel_show_search )
								{{ $search_form_header }}
							@endif
						</div>
					</div>
				</div>

				<div class="hamburger-area" style="display: none;">
					{{ $main_menu }}
					
					{{ $top_menu }}

					@if ( $socials_show_header )
						{{ $socials }}
					@endif
				</div>
			</div>

		</div>
	</div>
</div>