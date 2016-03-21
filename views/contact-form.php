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
	<h4><?php echo __( 'Agent:', 'tm-real-estate' ) . ' ' . $__data['agent']->display_name ?></h4>
	<form>
		<span class="message"></span>
		<input type="hidden" name="action" value="tm_re_contact_form"/>
		<input type="hidden" name="agent_id" value="<?php echo $__data['agent']->ID ?>"/>
		<input type="hidden" name="property_id" value="<?php echo $__data['property_id'] ?>"/>
		<?php echo __( 'Name', 'tm-real-estate' ) ?>
		<input type="text" id="name" name="name" value="" required>
		<?php echo __( 'Email', 'tm-real-estate' ) ?>
		<input type="email"id="email" name="email" value=""/ required>
		<?php echo __( 'Message', 'tm-real-estate' ) ?>
		<textarea id="message" name="message" required></textarea>
		<input type="submit"id="submit" value="<?php echo __( 'Send Message', 'tm-real-estate' ) ?>"/>
	</form>
</div>