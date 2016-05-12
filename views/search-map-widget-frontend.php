<?php
/**
 * TM Real Estate Search Form Widget
 *
 * @package    TM Real Estate
 * @subpackage View
 * @author     Cherry Team <cherryframework@gmail.com>
 * @copyright  Copyright (c) 2012 - 2016, Cherry Team
 * @link       http://www.cherryframework.com/
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

?>
<?php echo $__data['before_widget']; ?>
<div class="tm-real-estate-search-map-widget">
	<div class="search-form">
		<?php echo $__data['before_title']; ?>
		<?php echo $__data['form_title']; ?>
		<?php echo $__data['after_title']; ?>
		<?php echo $__data['form']; ?>
	</div>

	<div class="map">
		<?php echo $__data['before_title']; ?>
		<?php echo $__data['map_title']; ?>
		<?php echo $__data['after_title']; ?>
		<?php echo $__data['map']; ?>
	</div>
</div>
<?php echo $__data['after_widget']; ?>