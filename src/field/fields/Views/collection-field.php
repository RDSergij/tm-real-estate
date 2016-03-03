<!-- Collection field -->
<div class="themosis-collection-wrapper" data-type="<?php echo $field['features']['type'] ?>" data-limit="<?php echo $field['features']['limit'] ?>" data-order="1" data-name="<?php echo $field['name'] ?>[]" data-field="collection">
	<script id="themosis-collection-item-template" type="text/template">
		<input type="hidden" name="<?php echo $field['name'] ?>[]" value="<%= value %>" data-field="collection"/>
		<div class="themosis-collection__item">
			<div class="centered">
				<img src="<%= src %>" alt="Collection Item"/>
			</div>
			<div class="filename">
				<div><%= title %></div>
			</div>
			<a class="check" title="Remove" href="#">
				<div class="media-modal-icon"></div>
			</a>
		</div>
	</script>
	<?php
		$show = empty($field['value']) ? '' : 'show';
	?>
	<div class="themosis-collection-container <?php echo $show ?>">
		<!-- Collection -->
		<div class="themosis-collection">
			<ul class="themosis-collection-list">
				<?php if (!empty($field['value']) && is_array($field['value'])): ?>
					<?php foreach($field['value'] as $i => $item): ?>
						<li>
							<?php 
							echo Form::hidden(
								$field['name'].'[]',
								$item,
								['data-field' => 'collection']
							)
							?>
							<div class="themosis-collection__item">
								<?php
									$isFile = false;
									$src = TM_REAL_ESTATE_PATH.'/src/assets/images/themosisFileIcon.png';

									if (wp_attachment_is_image($item))
									{
										$src = wp_get_attachment_image_src($item, '_themosis_media');
										$src = $src[0];
									}
									else
									{
										$src = wp_get_attachment_image_src($item, '_themosis_media', true);
										$src = $src[0];
										$isFile = true;
									}
								?>
								<div class="centered">
									<img src="<?php echo $src ?>" alt="Collection Item" <?php if ($isFile){ echo('class="icon"'); } ?>/>
								</div>
								<div class="filename <?php if ($isFile){ echo('show'); } ?>">
									<div><?php echo get_the_title($item) ?></div>
								</div>
								<a class="check" title="Remove" href="#">
									<div class="media-modal-icon"></div>
								</a>
							</div>
						</li>
					<?php endforeach; ?>
				<?php endif; ?>
			</ul>
		</div>
		<!-- End collection -->
	</div>
	<div class="themosis-collection-buttons">
		<button id="themosis-collection-add" type="button" class="button button-primary <?php if ($field['features']['limit'] && !empty($field['value']) && is_array($field['value']) && $field['features']['limit'] <= count($field['value'])) { echo('disabled'); } ?>"><?php _e('Add'); ?></button>
		<button id="themosis-collection-remove" type="button" class="button button-primary themosis-button-remove"><?php _e('Remove'); ?></button>
	</div>
	<?php if ( isset( $field[ 'features' ][ 'info' ] ) ): ?>
		<div class="themosis-field-info">
			<p><?php echo $field['features']['info'] ?></p>
		</div>
	<?php endif; ?>
</div>
<!-- End collection field -->