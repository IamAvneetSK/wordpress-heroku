<?php 
	$price = get_post_meta(get_the_ID(), 'qode_restaurant_menu_item_price', true);
	$label = get_post_meta(get_the_ID(), 'qode_restaurant_menu_item_label', true);
	$description = get_post_meta(get_the_ID(), 'qode_restaurant_menu_item_description', true);
?>
<li class="qode-rml-item clearfix">
	<?php if($show_featured_image === 'yes') : ?>
			<div class="qode-rml-item-image">
				<a href="<?php echo esc_url(wp_get_attachment_url(get_post_thumbnail_id())); ?>" data-rel="prettyPhoto<?php echo esc_attr(the_ID()); ?>">
					<?php the_post_thumbnail('thumbnail'); ?>
				</a>
			</div>
	<?php endif; ?>
	<div class="qode-rml-item-content">
		<div class="qode-rml-top-holder">
			<div class="qode-rml-title-holder">
				<<?php echo esc_attr($restaurant_menu_item_title_tag)?> class="qode-rml-title">
					<?php esc_html(the_title()); ?>
				</<?php echo esc_attr($restaurant_menu_item_title_tag)?>>
			</div>
			<div class="qode-rml-line"></div>

			<?php if(!empty($price)) : ?>
				<div class="qode-rml-price-holder">
					<h5 class="qode-rml-price"><?php echo esc_html($price); ?></h5>
				</div>

			<?php endif; ?>
		</div>
		<div class="qode-rml-bottom-holder clearfix">
			<?php if(!empty($description)) : ?>
			<<?php echo esc_attr($restaurant_menu_item_description_title_tag)?> class="qode-rml-description-holder">
				<?php echo esc_html($description); ?>
			</<?php echo esc_attr($restaurant_menu_item_description_title_tag)?>>
			<?php endif; ?>

			<?php if(!empty($label)) : ?>
				<div class="qode-rml-label-holder">
					<span class="qode-rml-label"><?php echo esc_html($label); ?></span>
				</div>
			<?php endif; ?>
		</div>
	</div>

</li>