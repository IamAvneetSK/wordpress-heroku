<div class="qode-news-item qode-video-layout2-item">
	<div class="qode-news-item-inner">
		<div class="qode-news-item-image">
			<?php echo qode_news_get_shortcode_inner_template_part('image','',$params);?>
		</div>
		<div class="qode-ni-content">
			<div class="qode-ni-title-holder">
				<a class="qode-ni-video-button" href="<?php echo esc_url($video_link); ?>" target="_self" data-rel="prettyPhoto[ni_video_pretty_photo_<?php echo esc_attr($rand); ?>]">
					<span class="qode-ni-video-button-play">
						<span class="arrow_triangle-right"></span>
					</span>
				</a>
				<?php echo qode_news_get_shortcode_inner_template_part('title','',$params);?>
			</div>
			<div class="qode-ni-info qode-ni-info-top-right">
				<?php echo qode_news_get_shortcode_inner_template_part('post-info/share','',$params);?>
			</div>
		</div>
	</div>
</div>