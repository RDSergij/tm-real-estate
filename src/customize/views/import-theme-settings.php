<span class="customize-control-title">{{ __( 'Import theme settings and content') }}</span>
<label>
	<input type="radio" value="append_to_existing" name="import_type" checked="checked">
	Append to existing<br>
</label>
<label>
	<input type="radio" value="overwrite" name="import_type">
	Overwrite<br>
</label>
<br>
<button id="import_settings" class="button button-primary">{{ __( 'Import', 'blogetti' ) }}</button>