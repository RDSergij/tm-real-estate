<?php
/**
 * Map property items View.
 *
 * @package    TM Real Estate
 * @subpackage View
 * @author     Cherry Team <cherryframework@gmail.com>
 * @copyright  Copyright (c) 2012 - 2016, Cherry Team
 * @link       http://www.cherryframework.com/
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */
?>
<h4><?php echo $__data['title']; ?></h4>
<p><?php echo __( 'Price', 'tm-real-estate' ); ?>: <?php echo $__data['price']; ?> <?php echo $__data['currency']; ?></p>
<p><?php echo __( 'Agent', 'tm-real-estate' ); ?>: <?php echo $__data['agent']; ?></p>
<p><?php echo __( 'Address', 'tm-real-estate' ); ?>: <?php echo $__data['address']; ?></p>