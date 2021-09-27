<div class="qode-news-item qode-video-layout1-item">
	<div class="qode-news-item-inner">
	    <?php if ( $video_type == 'self' ) { ?>
			<div class="qode-ni-content">
				<div class="qode-ni-content-table">
					<div class="qode-ni-info qode-ni-info-top-left">
						<div class="qode-ni-author-image">
							<?php echo qode_news_get_shortcode_inner_template_part('post-info/author-image','',$params);?>
						</div>
						<div class="qode-ni-title-author">
							<?php echo qode_news_get_shortcode_inner_template_part('title','',$params);?>
							<?php echo qode_news_get_shortcode_inner_template_part('post-info/author','',$params);?>
						</div>
					</div>		
					<div class="qode-ni-info qode-ni-info-top-right">
						<?php echo qode_news_get_shortcode_inner_template_part('post-info/share','',$params);?>
					</div>
				</div>
			</div>
		<?php } ?>
		<div class="qode-news-video-holder">
			<?php if($video_type == "youtube") {
				echo wp_oembed_get('https://www.youtube.com/watch?v='.esc_html($video_link));
			 } elseif ($video_type == "vimeo"){
				echo wp_oembed_get('https://vimeo.com/'.esc_html($video_link));
		    } else if ( $video_type == 'self' ) { ?>
		        <div class="qode-self-hosted-video-holder">
		            <div class="qode-video-wrap">
                        <video class="qode-self-hosted-video" poster="<?php echo get_post_meta(get_the_ID(), "video_format_image", true);  ?>" preload="auto">
							<?php if($video_link_webm != "") { ?> <source type="video/webm" src="<?php echo esc_url($video_link_webm);  ?>"> <?php } ?>
							<?php if($video_link_mp4 != "") { ?> <source type="video/mp4" src="<?php echo esc_url($video_link_webm);  ?>"> <?php } ?>
							<?php if($video_link_ogv != "") { ?> <source type="video/ogg" src="<?php echo esc_url($video_link_webm);  ?>"> <?php } ?>
                            <object width="320" height="240" type="application/x-shockwave-flash" data="<?php echo get_template_directory_uri(); ?>/js/flashmediaelement.swf">
                                <param name="movie" value="<?php echo get_template_directory_uri(); ?>/js/flashmediaelement.swf" />
                                <param name="flashvars" value="controls=true&file=<?php echo get_post_meta(get_the_ID(), "video_format_mp4", true);  ?>" />
                                <img itemprop="image" src="<?php echo get_post_meta(get_the_ID(), "video_format_image", true);  ?>" width="1920" height="800" title="No video playback capabilities" alt="Video thumb" />
                            </object>
                        </video>
		            </div>
		        </div>
		    <?php } ?>
		</div>
	</div>
</div>