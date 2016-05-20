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

	<div class="properties properties-list properties-list_default">
		<?php echo $__data['order_html'] ?>
		<?php foreach ( $__data['properties'] as $property ) : ?>
		<article class="property-item">
			<figure>
				<a href="<?php echo $property->url ?>">
					<img src="<?php echo $property->image; ?>" class="attachment-property-thumb-image" alt="<?php echo esc_attr( $property->post_title ); ?>">
				</a>

				<figcaption class="for-<?php echo esc_attr( $property->status ); ?>"><?php echo ucwords( esc_attr( $property->status ) ); ?></figcaption>
			</figure>

			<div class="property-content">
				<div class="property-title">
					<h5><a href="<?php echo $property->url ?>"><?php echo $property->post_title; ?></a></h5>

					<div class="price">
						<h5><?php echo $__data['currency_symbol'] ?> <?php echo $property->price; ?></h5>
					</div>
				</div>
				<div class="detail">
					<p><?php echo wp_trim_words( $property->post_content, 15 ); ?></p>
				</div>
				<ul class="property-meta">
					<li class="area">
						<small><?php echo $property->area . ' ' . __( $__data['area_unit'], 'tm-real-estate' ); ?></small>
					</li>
					<li class="bedrooms">
						<small><?php echo $property->bedrooms . ' ' . __( 'Bedrooms', 'tm-real-estate' ); ?></small>
					</li>
					<li class="bathrooms">
						<small><?php echo $property->bathrooms . ' ' . __( 'Bathrooms', 'tm-real-estate' ); ; ?></small>
					</li>
				</ul>
				<div class="property-address">
					<small><?php echo $property->address; ?></small>
				</div>
				<a class="btn btn-primary" href="<?php echo $property->url ?>"><?php echo __( 'READ MORE', 'tm-real-estate' ); ?></a>
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
