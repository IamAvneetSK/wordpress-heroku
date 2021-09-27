<?php get_header(); ?>
<?php
global $wp_query;
$id = $wp_query->get_queried_object_id();

if ( get_query_var('paged') ) { $paged = get_query_var('paged'); }
elseif ( get_query_var('page') ) { $paged = get_query_var('page'); }
else { $paged = 1; }

$sidebar = $bridge_qode_options['category_blog_sidebar'];

$blog_hide_comments = "";
if (isset($bridge_qode_options['blog_hide_comments']))
	$blog_hide_comments = $bridge_qode_options['blog_hide_comments'];

if(isset($bridge_qode_options['blog_page_range']) && $bridge_qode_options['blog_page_range'] != ""){
	$blog_page_range = $bridge_qode_options['blog_page_range'];
} else{
	$blog_page_range = $wp_query->max_num_pages;
}

$qode_archive_reaction_params = array();

$qode_taxonomy_id = get_queried_object_id();
$qode_taxonomy = !empty($qode_taxonomy_id) ? get_term_by('id', $qode_taxonomy_id, 'news-reaction') : '';
$qode_taxonomy_slug = !empty($qode_taxonomy) ? $qode_taxonomy->slug : '';

$qode_archive_reaction_params['sort'] = 'reactions';
$qode_archive_reaction_params['reaction'] = $qode_taxonomy_slug;
$qode_archive_reaction_params['column_number'] = 2;
$qode_archive_reaction_params['posts_per_page'] = '6';
$qode_archive_reaction_params['display_pagination'] = 'yes';
$qode_archive_reaction_params['pagination_type'] = 'standard';
$qode_archive_reaction_params['space_between_items'] = 'normal';
$qode_archive_reaction_params['excerpt_length'] = '20';
$qode_archive_reaction_params['image_size'] = 'portfolio-landscape';

?>

<?php if(get_post_meta($id, "qode_page_scroll_amount_for_sticky", true)) { ?>
    <script>
        var page_scroll_amount_for_sticky = <?php echo get_post_meta($id, "qode_page_scroll_amount_for_sticky", true); ?>;
    </script>
<?php } ?>

<?php get_template_part( 'title' ); ?>
<div class="container">
	<?php if(isset($bridge_qode_options['overlapping_content']) && $bridge_qode_options['overlapping_content'] == 'yes') {?>
    <div class="overlapping_content"><div class="overlapping_content_inner">
			<?php } ?>
            <div class="container_inner default_template_holder clearfix">
				<?php if(($sidebar == "default")||($sidebar == "")) : ?>
					<?php
					echo bridge_qode_execute_shortcode('qode_layout1', $qode_archive_reaction_params);
					?>
				<?php elseif($sidebar == "1" || $sidebar == "2"): ?>
                    <div class="<?php if($sidebar == "1"):?>two_columns_66_33<?php elseif($sidebar == "2") : ?>two_columns_75_25<?php endif; ?> background_color_sidebar grid2 clearfix">
                        <div class="column1">
                            <div class="column_inner">
								<?php
								echo bridge_qode_execute_shortcode('qode_layout1', $qode_archive_reaction_params);
								?>
                            </div>
                        </div>
                        <div class="column2">
							<?php get_sidebar(); ?>
                        </div>
                    </div>
				<?php elseif($sidebar == "3" || $sidebar == "4"): ?>
                    <div class="<?php if($sidebar == "3"):?>two_columns_33_66<?php elseif($sidebar == "4") : ?>two_columns_25_75<?php endif; ?> background_color_sidebar grid2 clearfix">
                        <div class="column1">
							<?php get_sidebar(); ?>
                        </div>
                        <div class="column2">
                            <div class="column_inner">
								<?php
								echo bridge_qode_execute_shortcode('qode_layout1', $qode_archive_reaction_params);
								?>
                            </div>
                        </div>
                    </div>
				<?php endif; ?>
            </div>
			<?php if(isset($bridge_qode_options['overlapping_content']) && $bridge_qode_options['overlapping_content'] == 'yes') {?>
        </div></div>
<?php } ?>
</div>
<?php get_footer(); ?>
