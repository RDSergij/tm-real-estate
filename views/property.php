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
<?php 
	$carousel_image_size = apply_filters( 'real_estate_carousel_image_sizes', array(
		'large_size' 		=> 'medium_large',
		'thumbnail_size' 	=> 'thumbnail',
	) );
?>
<?php if ( ! empty( $__data['property'] ) ) : ?>
	<?php $property = $__data['property']; ?>
	<div class="properties">
		<article class="property-item">
			<header class="property-title">
				<h2><?php echo $property->post_title; ?></h2>
			</header>
			<div class="swiper-container gallery-top">
				<?php if ( ! empty( $property->gallery[0][$carousel_image_size['large_size']] ) ) : ?>
					<?php if ( 1 < count( $property->gallery ) ) : ?>
						<div class="swiper-wrapper">
							<?php foreach ( $property->gallery as $image ) : ?>
								<div class="swiper-slide" style="background-image:url(<?php echo $image[$carousel_image_size['large_size']][0] ?>"></div>
							<?php endforeach; ?>
						</div>
						<!-- Add Arrows -->
						<div class="swiper-button-next"><i class="material-icons">keyboard_arrow_right</i></div>
						<div class="swiper-button-prev"><i class="material-icons">keyboard_arrow_left</i></div>
					<?php else : ?>
							<div class="swiper-wrapper">
								<div class="swiper-slide" style="background-image:url(<?php echo $property->gallery['image'][0][$carousel_image_size['large_size']][0] ?>"></div>
							</div>
					<?php endif; ?>
				<?php else : ?>
						<div class="swiper-wrapper">
							<div class="swiper-slide" style="background-image:url(<?php echo wp_get_attachment_url( get_post_thumbnail_id( $property->ID ) ); ?>"></div>
						</div>
				<?php endif; ?>
			</div>
			<?php if ( ! empty( $property->gallery ) && 1 < count( $property->gallery ) ) : ?>
				<div class="swiper-container gallery-thumbs">
					<div class="swiper-wrapper">
						<?php foreach ( $property->gallery as $image ) : ?>
						<div class="swiper-slide" style="background-image:url(<?php echo $image[$carousel_image_size['thumbnail_size']][0] ?>"></div>
						<?php endforeach; ?>
					</div>
			</div>
			<?php endif; ?>

			<div class="property-price">
				<h3><?php echo __( 'Price:', 'tm-real-estate' ) ?> <span class="price"><?php echo $__data['currency_symbol'] ?> <?php echo $property->price; ?></span></h3>
			</div>

			<div class="property-hr"></div>

			<div class="property-content">
				<div class="property-detail">
					<h3><?php echo __( 'Property Description:', 'tm-real-estate' ) ?></h3>
					<?php echo $property->post_content; ?>
				</div>

				<div class="property-hr"></div>

				<h3><?php echo __( 'Quick Summary:', 'tm-real-estate' ) ?></h3>
				<ul class="property-meta">
					<li class="type">
						<strong><?php echo __( 'Property type:', 'tm-real-estate' ) ?></strong> <?php echo esc_attr( $property->type ); ?>
					</li>
					<li class="bathrooms">
						<strong><?php echo __( 'Bathrooms:', 'tm-real-estate' ) ?></strong> <?php echo esc_attr( $property->bathrooms ); ?>
					</li>
					<li class="bedrooms">
						<strong><?php echo __( 'Bedrooms:', 'tm-real-estate' ) ?></strong> <?php echo esc_attr( $property->bedrooms ); ?>
					</li>
					<li class="parking_places">
						<strong><?php echo __( 'Parking place:', 'tm-real-estate' ) ?></strong> <?php echo esc_attr( $property->parking_places ); ?>
					</li>
					<li class="area">
						<strong><?php echo __( 'Area:', 'tm-real-estate' ) ?></strong> <?php echo $property->area; ?> <?php echo __( $__data['area_unit'], 'tm-real-estate' ); ?>
					</li>
					<?php if( ! empty ( $property->types ) ) { ?>
						<li class="type">
							<strong><?php echo __( 'Property type:', 'tm-real-estate' ) ?></strong>
							<?php foreach ( $property->types as $type ) : ?>
								<?php echo $type; ?>
							<?php endforeach; ?>
						</li>
					<?php } ?>
					<?php if( ! empty ( $property->tags ) ) { ?>
						<li class="tag">
							<strong><?php echo __( 'Property tags:', 'tm-real-estate' ) ?></strong>
							<?php foreach ( $property->tags as $tag ) : ?>
								<?php echo $tag; ?>
							<?php endforeach; ?>
						</li>
					<?php } ?>
				</ul>
			</div>

			<div class="property-hr"></div>

			<div class="property-location">
				<h3><?php echo __( 'Map', 'tm-real-estate' ) ?></h3>
				<?php if ( ! empty( $property->address ) ) : ?>
					<div id="locations" data-address="<?php echo esc_attr( $property->address ); ?>"></div>
				<?php endif; ?>
			</div>

			<div class="property-hr"></div>

			<div class="property-agent">
				<h3><?php echo __( 'Contact Agent', 'tm-real-estate' ) ?></h3>

				<?php echo $__data['contact_form'] ?>
			</div>
		</article>

		
		
	</div>

<?php endif; ?>
