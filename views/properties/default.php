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

	<div class="properties properties-list_default">
		<?php echo $__data['order_html'] ?>
		<?php foreach ( $__data['properties'] as $property ) : ?>
		<article class="property-item">
			<figure>
				<a href="<?php echo $property->url ?>">
					<img src="<?php echo $property->image; ?>" class="attachment-property-thumb-image" alt="<?php echo esc_attr( $property->post_title ); ?>">
				</a>

				<figcaption class="for-<?php echo esc_attr( $property->status ); ?>">For <?php echo ucwords( esc_attr( $property->status ) ); ?></figcaption>
			</figure>

			<ul class="property-meta">
				<li class="type">
					<?php echo esc_attr( $property->type ); ?>
				</li>
				<li class="bathrooms">
					<?php echo $property->bathrooms; ?>
				</li>
				<li class="bedrooms">
					<?php echo $property->bedrooms; ?>
				</li>
				<li class="parking_places">
					<?php echo $property->parking_places; ?>
				</li>
				<li class="area">
					<?php echo $property->area; ?> <?php echo __( $__data['area_unit'], 'tm-real-estate' ); ?>
				</li>
			</ul>

			<div class="property-content">
				<div class="property-title">
					<h4><a href="<?php echo $property->url ?>"><?php echo $property->post_title; ?></a></h4>

					<div class="price">
						<?php echo $__data['currency_symbol'] ?> <?php echo $property->price; ?>
					</div>
				</div>
				<div class="detail">
					<?php echo wp_trim_words( $property->post_content, 55 ); ?>
					<a class="more-details" href="<?php echo $property->url ?>">More Details <i class="fa fa-caret-right"></i></a>
				</div>
			</div>

		</article>
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
