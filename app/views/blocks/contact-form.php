<form id="contact-form" action="#" method="post" class="theme-form">
	<p><em><?php echo __( 'Your email address will not be published. Required fields are marked', 'blogetti' ) ?> <span class="accent1-color">*</span></em></p>
	<p>
		<label class="theme-form_name">
			<em class="h6-style"><?php echo __( 'Your name', 'blogetti' ) ?> <span class="accent1-color">*</span></em>
			<input name="name" value="" size="40" class="theme_form_name-input" required="" type="text"></label>
	</p>
	<p>
		<label class="theme-form_email">
			<em class="h6-style"><?php echo __( 'Your e-mail', 'blogetti' ) ?> <span class="accent1-color">*</span></em>
			<input name="email" value="" size="40" class="theme_form_email-input" required="" type="email"></label>
	</p>
	<p>
		<label class="theme-form_comment">
			<em class="h6-style"><?php echo __( 'Comments', 'blogetti' ) ?> <span class="accent1-color">*</span></em>
			<textarea name="message" cols="40" rows="10" class="theme_form_textarea" required=""></textarea>
		</label>
	</p>
	<p><input value="Send" class="theme-form_submit" type="submit"></p>
</form>