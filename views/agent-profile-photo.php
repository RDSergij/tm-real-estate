<?php
/**
 * Agent photo view
 *
 * @package  TM Real Estate
 * @author   Guriev Eugen & Sergyj Osadchij
 * @license  GPL-2.0+
 */
?>
<div id="tm_re_agent_photo_container">

	<table class="form-table">

		<tr>
			<th><label for="tm_re_agent_photo_meta"><?php _e( 'Profile Photo', 'tm-real-estate' ); ?></label></th>
			<td>
				<!-- Outputs the image after save -->
				<div id="current_img">
					<?php if ( ! empty( $__data['upload_url'] ) ) : ?>
						<img src="<?php echo esc_url( $__data['upload_url'] ); ?>" class="agent-photo-img">
						<div class="edit_options uploaded">
							<a class="remove_img"><span>Remove</span></a>
							<a href="<?php echo $__data['upload_edit_url']; ?>" class="edit_img" target="_blank"><span>Edit</span></a>
						</div>
					<?php elseif ( ! empty( $__data['url'] ) ) : ?>
						<img src="<?php echo esc_url( $__data['url'] ); ?>" class="agent-photo-img">
						<div class="edit_options single">
							<a class="remove_img"><span><?php _e( 'Remove', 'tm-real-estate' ); ?></span></a>
						</div>
					<?php else : ?>
						<img src="<?php echo $__data['default_image']; ?>" class="agent-photo-img placeholder">
					<?php endif; ?>
				</div>

				<!-- Hold the value here if this is a WPMU image -->
				<div id="tm_re_agent_photo_upload">
					<input type="hidden" name="tm_re_agent_photo_placeholder_meta" id="tm_re_agent_photo_placeholder_meta" value="<?php echo $__data['default_image']; ?>" class="hidden" />
					<input type="hidden" name="tm_re_agent_photo_upload_meta" id="tm_re_agent_photo_upload_meta" value="<?php echo $__data['photo_id']; ?>" class="hidden" />
					<input type="hidden" name="tm_re_agent_photo_upload_edit_meta" id="tm_re_agent_photo_upload_edit_meta" value="<?php echo esc_url_raw( $__data['upload_edit_url'] ); ?>" class="hidden" />
					<input type='button' class="tm_re_agent_photo_wpmu_button button-primary" value="<?php _e( $__data['btn_text'], 'tm-real-estate' ); ?>" id="uploadimage"/><br />
				</div>
				<!-- Outputs the save button -->
				<span class="description"><?php _e( 'Upload a custom photo.', 'tm-real-estate' ); ?></span>
				<p class="description"><?php _e( 'Update Profile to save your changes.', 'tm-real-estate' ); ?></p>
			</td>
		</tr>

	</table><!-- end form-table -->
</div> <!-- end #tm_re_agent_photo_container -->
