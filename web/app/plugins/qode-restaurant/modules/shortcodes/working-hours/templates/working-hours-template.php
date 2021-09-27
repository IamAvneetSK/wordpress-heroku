<div <?php qode_restaurant_class_attribute($holder_classes); ?> <?php qode_restaurant_inline_style($holder_styles); ?>>
	<div class="qode-wh-holder-inner">
		<?php if(is_array($working_hours) && count($working_hours)) : ?>
				<?php if(!empty($title) || !empty($label)) : ?>
					<div class="qode-wh-title-holder">
						<?php if(!empty($title) || !empty($label)) : ?>
							<h3 class="qode-wh-title"><?php echo esc_html($title); ?></h3>
						<?php endif; ?>
						<?php if(!empty($label)) : ?>
							<h6 class="qode-wh-label">
								<?php echo esc_html($label); ?>
								<?php if(!empty($sublabel)) : ?>
									<span><?php echo esc_html($sublabel); ?></span>
								<?php endif; ?>
							</h6>
						<?php endif; ?>

					</div>
				<?php endif; ?>

			<?php foreach($working_hours as $working_hour) : ?>
				<?php if(isset($working_hour['label']) && $working_hour['label'] !== '') : ?>
					<<?php echo esc_attr($items_title_tag); ?> class="qode-wh-item clearfix" <?php qode_restaurant_inline_style($item_styles); ?>>
						<span class="qode-wh-day"><?php echo esc_html($working_hour['label']); ?></span><span class="qode-wh-dots"><span class="qode-wh-dots-inner"></span></span>
						<?php if(isset($working_hour['closed']) && $working_hour['closed'] !== 'yes') { ?>
							<span class="qode-wh-hours">
								<?php if(!empty($working_hour['from'])) : ?>
									<span class="qode-wh-from"><?php echo esc_html($working_hour['from']); ?></span>
								<?php endif; ?>
								<?php if(!empty($working_hour['to'])) : ?>
									<span class="qode-wh-delimiter">-</span>
									<span class="qode-wh-to"><?php echo esc_html($working_hour['to']); ?></span>
								<?php endif; ?>
							</span>
						<?php } else { ?>
							<span class="qode-wh-hours"><span class="qode-wh-closed"><?php esc_html_e('Closed', 'qode-restaurant'); ?></span></span>
						<?php } ?>
					</<?php echo esc_attr($items_title_tag); ?>>
					<?php if(!empty($working_hour['description'])) { ?>
						<h6 class="qode-wh-description"><?php echo esc_html($working_hour['description']); ?></h6>
					<?php } ?>
				<?php endif; ?>
			<?php endforeach; ?>
		<?php else: ?>
		<p><?php esc_html_e('Working hours are not set', 'qode-restaurant'); ?></p>
		<?php endif; ?>
	</div>
</div>