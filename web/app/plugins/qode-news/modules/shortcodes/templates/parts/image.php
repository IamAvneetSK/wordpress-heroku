<?php
$image_size = isset($image_size) ? $image_size : 'thumbnail';
$featured_image_meta = get_post_meta(get_the_ID(), 'qode_blog_list_featured_image_meta', true);

$has_featured = !empty($featured_image_meta) || has_post_thumbnail();

$blog_list_image_src = !empty($featured_image_meta) ? $featured_image_meta : '';
?>
<?php if ( $has_featured ) { ?>
	<div class="qode-post-image">
	    <a itemprop="url" href="<?php echo get_the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
        <?php
        if ( $image_size != 'custom' ) {
            if ($blog_list_image_src !== '') { ?>
                <img itemprop="image" class="qode-custom-post-image" src="<?php echo esc_url($blog_list_image_src); ?>"
                     alt="<?php esc_html_e('Blog list featured image', 'qode-news'); ?>"/>
            <?php } else { ?>
                <?php the_post_thumbnail($image_size); ?>
            <?php }
        }elseif ( $custom_image_width != '' && $custom_image_height != '' ) {
			if ( ! empty( $blog_list_image_src ) ) {
				echo bridge_qode_generate_thumbnail( $blog_list_image_src, null, $custom_image_width, $custom_image_height );
			} else {
				echo bridge_qode_generate_thumbnail( get_post_thumbnail_id( get_the_ID() ), null, $custom_image_width, $custom_image_height );
			}
		}?>
	    </a>
	</div>
<?php } ?>