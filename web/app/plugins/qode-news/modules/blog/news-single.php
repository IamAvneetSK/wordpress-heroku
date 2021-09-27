<?php
extract(bridge_qode_get_blog_single_params());
$post_template = bridge_qode_get_meta_field_intersect('blog_single_type', bridge_qode_get_page_id());
?>
<?php get_header(); ?>
<?php if (have_posts()) : ?>
<?php while (have_posts()) : the_post(); ?>
<?php if(get_post_meta($id, "qode_page_scroll_amount_for_sticky", true)) { ?>
    <script>
        var page_scroll_amount_for_sticky = <?php echo get_post_meta($id, "qode_page_scroll_amount_for_sticky", true); ?>;
    </script>
<?php } ?>
<?php get_template_part( 'title' ); ?>
<?php get_template_part( 'slider' ); ?>
<?php if($single_type == 'image-title-post') : //this post type is full width ?>
<div class="full_width" <?php if($background_color != "") { echo " style='background-color:". $background_color ."'";} ?>>
	<?php if(isset($bridge_qode_options['overlapping_content']) && $bridge_qode_options['overlapping_content'] == 'yes') {?>
    <div class="overlapping_content"><div class="overlapping_content_inner">
			<?php } ?>
            <div class="full_width_inner" <?php bridge_qode_inline_style($content_style_spacing); ?>>
				<?php else : // post type ?>
                <div class="container"<?php if($background_color != "") { echo " style='background-color:". $background_color ."'";} ?>>
					<?php if(isset($bridge_qode_options['overlapping_content']) && $bridge_qode_options['overlapping_content'] == 'yes') {?>
                    <div class="overlapping_content"><div class="overlapping_content_inner">
							<?php } ?>
                            <div class="container_inner default_template_holder" <?php bridge_qode_inline_style($content_style_spacing); ?>>
								<?php endif; // post type end ?>
								<?php if(($sidebar == "default")||($sidebar == "")) : ?>

                                    <?php qode_news_get_blog_single($post_template); ?>

								<?php elseif($sidebar == "1" || $sidebar == "2"): ?>
							<?php if($sidebar == "1") : ?>
                                <div class="two_columns_66_33 background_color_sidebar grid2 clearfix">
                                    <div class="column1">
										<?php elseif($sidebar == "2") : ?>
                                        <div class="two_columns_75_25 background_color_sidebar grid2 clearfix">
                                            <div class="column1">
												<?php endif; ?>
                                                <div class="column_inner">
													<?php qode_news_get_blog_single($post_template); ?>
                                                </div>
                                            </div>
                                            <div class="column2">
												<?php get_sidebar(); ?>
                                            </div>
                                        </div>
										<?php elseif($sidebar == "3" || $sidebar == "4"): ?>
										<?php if($sidebar == "3") : ?>
                                        <div class="two_columns_33_66 background_color_sidebar grid2 clearfix">
                                            <div class="column1">
												<?php get_sidebar(); ?>
                                            </div>
                                            <div class="column2">
												<?php elseif($sidebar == "4") : ?>
                                                <div class="two_columns_25_75 background_color_sidebar grid2 clearfix">
                                                    <div class="column1">
														<?php get_sidebar(); ?>
                                                    </div>
                                                    <div class="column2">
														<?php endif; ?>

                                                        <div class="column_inner">
															<?php qode_news_get_blog_single($post_template); ?>
                                                        </div>
                                                    </div>

                                                </div>
												<?php endif; ?>
                                            </div>
											<?php if(isset($bridge_qode_options['overlapping_content']) && $bridge_qode_options['overlapping_content'] == 'yes') {?>
                                        </div></div>
									<?php } ?>
                                </div>
								<?php endwhile; ?>
								<?php endif; ?>


								<?php get_footer(); ?>