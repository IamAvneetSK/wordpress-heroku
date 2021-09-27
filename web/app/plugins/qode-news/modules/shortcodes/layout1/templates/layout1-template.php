<div class="qode-news-item qode-layout1-item">
	<?php if (has_post_thumbnail() && $display_image == 'yes') { ?>
	<div class="qode-news-item-image-holder">
		<?php echo qode_news_get_shortcode_inner_template_part('image','',$params);?>
        <div class="qode-news-image-info-holder-left">
			<?php echo qode_news_get_shortcode_inner_template_part('post-info/hot-trending','',$params);?>
        </div>
        <div class="qode-news-image-info-holder-right">
			<?php echo qode_news_get_shortcode_inner_template_part('post-info/share','',$params);?>
		</div>
	</div>
    <?php } ?>
	<div class="qode-ni-content">
        <?php echo qode_news_get_shortcode_inner_template_part('post-info/category','',$params);?>
		<?php echo qode_news_get_shortcode_inner_template_part('title','',$params);?>
		<?php echo qode_news_get_shortcode_inner_template_part('excerpt','',$params);?>
		<?php echo qode_news_get_shortcode_inner_template_part('post-info/date','',$params);?>
        <?php echo qode_news_get_shortcode_inner_template_part('post-info/author','',$params);?>
	</div>
</div>