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
	<form>
		<h3><?php echo __( 'Ask an Agent', 'tm-real-estate' ); ?></h3>
		<span class="message"></span>
		<input type="hidden" name="action" value="tm_re_contact_form"/>
		<input type="hidden" name="agent_id" value="<?php echo $__data['agent']->ID; ?>"/>
		<input type="hidden" name="property_id" value="<?php echo $__data['property_id']; ?>"/>
		<?php echo __( 'Your name', 'tm-real-estate' ); ?>
		<input type="text" id="name" name="name" value="" required />

		<?php echo __( 'Your e-mail', 'tm-real-estate' ) ?>
		<input type="email"id="email" name="email" value="" required />

		<?php echo __( 'Your phone', 'tm-real-estate' ) ?>
		<input type="text"id="phone" name="phone" value="" />

		<?php echo __( 'Your message', 'tm-real-estate' ) ?>
		<textarea id="message" name="message" required></textarea>
		<div id="tm-re-contact-form-captcha" ></div>
		<input type="submit"id="submit" class="btn-primary" value="<?php echo __( 'Send', 'tm-real-estate' ); ?>"/>
	</form>
</div>
