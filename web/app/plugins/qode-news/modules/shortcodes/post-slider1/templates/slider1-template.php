
<div class="qode-news-item qode-slider1-item <?php echo esc_attr($item_classes);?>" <?php echo $item_data_params; ?>>
	<div class="qode-news-item-image-holder" <?php bridge_qode_inline_style($background_style);?>></div>
	<div class="qode-ni-content">
		<?php if ($content_in_grid == 'yes') { ?>
			<div class="container_inner">
		<?php } ?>
				<div class="qode-ni-content-table" <?php bridge_qode_inline_style($content_style);?>>
					<div class="qode-ni-content-table-cell">
						<?php if ($display_categories == 'yes') { ?>
							<div class="qode-ni-info-top-holder">
								<div class="qode-ni-info qode-ni-info-top">
									<?php echo qode_news_get_shortcode_inner_template_part('post-info/category','',$params);?>
								</div>
							</div>
						<?php } ?>
							<div class="qode-ni-title-holder">
								<?php echo qode_news_get_shortcode_inner_template_part('title','',$params);?>
							</div>
						<?php if ($display_button == 'yes') { ?>
							<div class="qode-news-info-holder">
                                <?php
								echo bridge_core_get_button_v2_html(array(
							        'text' => esc_html__('Read More','qode'),
                                    'link' => get_the_permalink()
                                ));
                                ?>
							</div>
						<?php } ?>
						<?php echo qode_news_get_shortcode_inner_template_part('excerpt','',$params);?>
						<?php echo qode_news_get_shortcode_inner_template_part('post-info/share','',$params);?>
					</div>
				</div>
		<?php if ($content_in_grid == 'yes') { ?>
			</div>
		<?php } ?>
	</div>
</div>