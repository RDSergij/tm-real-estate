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

<div class="tm-real-estate-search-form-widget">

	<p>
		<?php echo $__data['first_block_html'] ?>
	</p>

	<!-- Form -->
	<div id="form">
		<br/>
		<div>
				<?php echo $__data['form_is_html'] ?>
		</div>

		<p>
			<?php echo $__data['form_title_html'] ?>
		</p>
	</div>
	<!-- End form -->

	<!-- Map -->
	<div id="map">
		<br/>
		<div>
			<?php echo $__data['map_is_html'] ?>
		</div>

		<p>
			<?php echo $__data['map_title_html'] ?>
		</p>
	</div>
	<!-- End map -->
	<p>&nbsp;</p>
</div>