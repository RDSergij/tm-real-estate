<?php
/**
 * Mail template
 *
 * @package    TM Real Estate
 * @subpackage View
 * @author     Cherry Team <cherryframework@gmail.com>
 * @copyright  Copyright (c) 2012 - 2016, Cherry Team
 * @link       http://www.cherryframework.com/
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */
?>
<div class="wrap">
	<h3>
		<a href="<?php echo get_permalink( $__data['property_data']->ID ) ?>">
			<?php echo $__data['property_data']->post_title; ?>
		</a>
	</h3>
	<p>
		<?php echo $__data['message_data']['message']; ?>
	</p>
	<p>
		<?php _e( 'Phone', 'tm-real-estate' ); ?> : <?php echo $__data['message_data']['phone']; ?>
	</p>
</div>
