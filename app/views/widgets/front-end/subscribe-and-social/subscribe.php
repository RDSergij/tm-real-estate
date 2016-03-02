@if( 'true' === $subscribe_is )
	<!-- Subscribe section -->
	<h4>{{ $subscribe_title }}</h4>

	<p>{{ $subscribe_description }}</p>

	<form novalidate>
		<input type="hidden" name="action" value="tm-mailchimp-subscribe">
		<input type="hidden" name="api-key" value="{{ $api_key }}">
		<input type="hidden" name="list-id" value="{{ $list_id }}">
		<div class="form-group ">
			<label data-add-placeholder data-add-icon for="mailform-input-email1">
				<input
					   placeholder="{{ __( 'Your e-mail', 'blogetti' ) }}"
					   type="email"
					   name="email"
					   class="h6-style" />
				<div class="btn-wrap"><button class="btn btn-primary"
						type="submit"><em>{{ $subscribe_button }}</em>
				</button></div>
			</label>
			<div class="msg"><span class="message"></span></div>
			<div class="mfInfo"></div>
		</div>
	</form>
	<!-- End subscribe section -->
@endif
