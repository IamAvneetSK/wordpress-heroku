<?php
$show_related_posts = bridge_qode_options()->getOptionValue('property_single_show_related') == 'yes' ? true : false;

//Get option for number of columns
$number_of_columns = 3;
$number_of_columns_option = bridge_qode_options()->getOptionValue('real_estate_related_posts_number_of_columns');
if(!empty($number_of_columns_option)) {
    $number_of_columns = $number_of_columns_option;
}

//Get option for item space
$space_between_items = 'medium';
$space_between_items_option = bridge_qode_options()->getOptionValue('real_estate_related_posts_space_between_items');
if(!empty($space_between_items_option)) {
    $space_between_items = $space_between_items_option;
}

//Get option for image size
$image_size = 'full';
$image_size_option = bridge_qode_options()->getOptionValue('real_estate_related_posts_image_size');
if(!empty($image_size_option)) {
    $image_size = $image_size_option;
}

//Get related posts
$post_id = get_the_ID();
$related_posts = qodef_re_get_property_single_related_posts($post_id);
$related_posts_array = array();
if ( $related_posts && $related_posts->have_posts() ) :
    while ( $related_posts->have_posts() ) : $related_posts->the_post();
        $related_posts_array[] = get_the_ID();
    endwhile;
endif;
wp_reset_postdata();

$params = array(
    'type'                => 'gallery',
    'number_of_columns'   => $number_of_columns,
    'space_between_items' => $space_between_items,
    'image_proportions'   => $image_size,
    'selected_properties' => implode(',', $related_posts_array),
    'number_of_items'     => 3,
    'floating_price'      => 'yes',
    'content_alignment'   => 'left',
    'title_tag'           => 'h5'
);

$html = bridge_qode_execute_shortcode('qodef_property_list', $params);
?>
<?php if($show_related_posts) { ?>
    <div class="qodef-property-related-posts-holder">
        <div class="qodef-property-related-posts-title">
            <h5><?php esc_html_e("Similar Properties", 'qode-real-estate'); ?></h5>
        </div>
        <div class="qodef-property-related-posts">
            <?php print bridge_qode_get_module_part($html); ?>
        </div>
    </div>
<?php } ?>
