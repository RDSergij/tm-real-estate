<?php
/**
 * Contact form view
 *
 * @package    TM Real Estate
 * @subpackage View
 * @author     Cherry Team <cherryframework@gmail.com>
 * @copyright  Copyright (c) 2012 - 2016, Cherry Team
 * @link       http://www.cherryframework.com/
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */
?>
<div class="tm-re-contact-form">
	<a href="<?php echo $__data['agent_page']; ?>">
		<img src="<?php echo $__data['photo_url']; ?>">
		<h4><?php echo __( 'Agent:', 'tm-real-estate' ) . ' ' . $__data['agent']->display_name; ?></h4>
	</a>

	<div class="agent-info">
		<p><?php echo __( 'Active', 'tm-real-estate'); ?>: <?php echo $__data['active_cnt']; ?></p>
		<p><?php echo __( 'Finished', 'tm-real-estate'); ?>: <?php echo $__data['finished_cnt']; ?></p>
	</div>

	<?php if( count( $__data['custom_contact'] ) ) : ?>
	<div class="agent-custom-contact">
		<ul>
		<?php foreach( $__data['custom_contact'] as $custom_contact ) : ?>
			<li><?php echo $custom_contact['title']; ?>:<?php echo $custom_contact['value']; ?></li>
		<?php endforeach; ?>
		</ul>
	</div>
	<?php endif; ?>

	<div class="property-hr"></div>

	<form>
		<h3><?php echo __( 'Ask an Agent', 'tm-real-estate' ); ?></h3>
		<span class="message"></span>
		<input type="hidden" name="action" value="tm_re_contact_form"/>
		<input type="hidden" name="agent_id" value="<?php echo $__data['agent']->ID; ?>"/>
		<input type="hidden" name="property_id" value="<?php echo $__data['property_id']; ?>"/>

		<div class="tm-re-contact-form_input">
			<h6><?php echo __( 'Your name', 'tm-real-estate' ); ?><span class="tm-re-contact-form_required">*</span></h6>
			<input type="text" id="name" name="name" value="" placeholder="<?php echo __( 'Enter please your name', 'tm-real-estate' ); ?>" required />
		</div>

		<div class="tm-re-contact-form_input">
			<h6><?php echo __( 'Your e-mail', 'tm-real-estate' ) ?><span class="tm-re-contact-form_required">*</span></h6>
			<input type="email"id="email" name="email" value="" placeholder="<?php echo __( 'Enter please your e-mail', 'tm-real-estate' ); ?>" required />
		</div>

		<div class="tm-re-contact-form_input">
			<h6><?php echo __( 'Your phone', 'tm-real-estate' ) ?><span class="tm-re-contact-form_required">*</span></h6>
			<input type="text"id="phone" name="phone" value="" placeholder="<?php echo __( 'Enter please your phone', 'tm-real-estate' ); ?>" required />
		</div>

		<div class="tm-re-contact-form_input">
			<h6><?php echo __( 'Your message', 'tm-real-estate' ) ?><span class="tm-re-contact-form_required">*</span></h6>
			<textarea id="message" name="message" placeholder="<?php echo __( 'What can we help you with?', 'tm-real-estate' ); ?>"  required></textarea>
		</div>

		<div class="tm-re-contact-form_input">
			<h6></h6>
			<div id="tm-re-contact-form-captcha" ></div>
			<input type="submit"id="submit" class="btn-primary" value="<?php echo __( 'Send', 'tm-real-estate' ); ?>"/>
		</div>
	</form>
</div>
