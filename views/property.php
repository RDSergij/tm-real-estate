<?php if ( is_array( $__data['properties'] ) && count( $__data['properties'] ) ): ?>

	<div class="properties">
		<?php foreach ( $__data['properties'] as $property ): ?>
			<?php
			// echo '<pre>';
			// var_dump( $property );
			// echo '</pre>';
			?>
			<article class="property-item">
				<h4><a href="#"><?php echo $property->post_title; ?></a></h4>
				<figure>
					<a href="#">
						<img src="<?php echo $property->image; ?>" class="attachment-property-thumb-image" alt="<?php echo esc_attr( $property->post_title ); ?>">
					</a>

					<figcaption class="for-<?php echo esc_attr( $property->status ); ?>">For <?php echo ucwords( esc_attr( $property->status ) ); ?></figcaption>
				</figure>
				<div class="detail">
					<?php echo wp_trim_words( $property->post_content, 55 ); ?>
					<a class="more-details" href="#">More Details <i class="fa fa-caret-right"></i></a>
				</div>
				<ul class="property-meta">
					<li class="price">
						<?php echo esc_attr( $property->meta['price'][0] ); ?>
					</li>
					<li class="type">
						<?php echo esc_attr( $property->meta['type'][0] ); ?>
					</li>
					<li class="bathrooms">
						<?php echo esc_attr( $property->meta['bathrooms'][0] ); ?>
					</li>
					<li class="bedrooms">
						<?php echo esc_attr( $property->meta['bedrooms'][0] ); ?>
					</li>
					<li class="area">
						<?php echo esc_attr( $property->meta['area'][0] ); ?>
					</li>
				</ul>
			</article>
		<?php endforeach; ?>
	</div>

<?php endif; ?>
	