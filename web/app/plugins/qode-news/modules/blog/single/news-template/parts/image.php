<?php
$image_size          = isset( $image_size ) ? $image_size : 'full';
$image_meta          = get_post_meta( get_the_ID(), 'qode_blog_list_featured_image_meta', true );
$has_featured        = ! empty( $image_meta ) || has_post_thumbnail();
$blog_list_image_src = ! empty( $image_meta ) && qode_news_blog_item_has_link() ? $image_meta : '';
?>

<?php if ( $has_featured ) { ?>
	<div class="qode-post-image">
		<?php if ( qode_news_blog_item_has_link() ) { ?>
			<a itemprop="url" href="<?php echo get_the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
		<?php } ?>
			<?php if ( ! empty( $blog_list_image_src ) ) { ?>
				<img itemprop="image" class="qode-custom-post-image" src="<?php echo esc_url( $blog_list_image_src ); ?>" alt="<?php esc_html_e( 'Blog List Featured Image', 'qode-news' ); ?>" />
			<?php } else { ?>
				<?php the_post_thumbnail( $image_size ); ?>
			<?php } ?>
		<?php if ( qode_news_blog_item_has_link() ) { ?>
			</a>
		<?php } ?>
		<?php echo qode_news_get_blog_part($blog_single_type.'/parts/post-info/hot-trending','single', '', array('display_hot_trending_icons' => 'yes')); ?>

	</div>
<?php } ?>