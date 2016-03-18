<?php
/**
 * Property View
 *
 * @package    TM Real Estate
 * @subpackage View
 * @author     Cherry Team <cherryframework@gmail.com>
 * @copyright  Copyright (c) 2012 - 2016, Cherry Team
 * @link       http://www.cherryframework.com/
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

?>
<?php if ( is_array( $__data['properties'] ) && count( $__data['properties'] ) ) : ?>

	<div class="properties">
		<?php foreach ( $__data['properties'] as $property ) : ?>
			<?php echo $property ?>
		<?php endforeach; ?>
		<?php if ( is_array( $__data['pagination'] ) && count( $__data['pagination'] ) ) : ?>
			<ul class="pagination">
				<?php foreach ( $__data['pagination'] as $el ) : ?>
					<?php echo $el; ?>
				<?php endforeach; ?>
			</ul>
		<?php endif; ?>
	</div>

<?php endif; ?>
