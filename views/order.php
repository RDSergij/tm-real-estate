<?php
/**
 * Order View
 *
 * @package    TM Real Estate
 * @subpackage View
 * @author     Cherry Team <cherryframework@gmail.com>
 * @copyright  Copyright (c) 2012 - 2016, Cherry Team
 * @link       http://www.cherryframework.com/
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

?>
<div class="properties-order">
	<?php echo __( 'Filtered by: ', 'tm-real-estate' ) ?>
	<a href="<?php echo $__data['query_string']; ?>&orderby=price&order=<?php echo $__data['order']; ?>" <?php if ( 'price' == $__data['orderby'] ) : ?> class="active" <?php endif; ?>>
		<?php echo __( 'price', 'tm-real-estate' ); ?>
	</a>
	<a href="<?php echo $__data['query_string']; ?>&orderby=date&order=<?php echo $__data['order']; ?>" <?php if ( 'date' == $__data['orderby'] ) : ?> class="active" <?php endif; ?>>
		<?php echo __( 'date', 'tm-real-estate' ); ?>
	</a>
	
	<a href="<?php echo $__data['query_string']; ?>&order=<?php echo $__data['reverse']; ?>&orderby=<?php echo $__data['orderby']; ?>">
		<img src="<?php echo plugins_url( 'assets/images/arrow-' . $__data['order'] . '.png', dirname( __FILE__ ) ); ?>">
	</a>
</div>
