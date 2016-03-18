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
	<h4><?php $__data['agent']->data->display_name ?></h4>
	<form>
		<input type="hidden" name="action" value="tm-re-contact-form"/>
		<input type="text" id="name" name="name" value=""/>
		<input type="text"id="email" name="email" value=""/>
		<textarea id="message" name="message" ></textarea>
		<span class="captcha">

		</span>
		<input type="submit"id="submit" value="<?php echo __( 'Send Message', 'tm-real-estate' ) ?>"/>
	</form>
</div>