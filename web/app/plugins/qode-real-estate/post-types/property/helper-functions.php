<?php
//Register meta boxes
if (!function_exists('qodef_re_property_meta_box_functions')) {
    function qodef_re_property_meta_box_functions($post_types) {
        $post_types[] = 'property';

        return $post_types;
    }

    add_filter('bridge_qode_filter_meta_box_post_types_save', 'qodef_re_property_meta_box_functions');
    add_filter('bridge_qode_filter_meta_box_post_types_remove', 'qodef_re_property_meta_box_functions');
}

//Register meta boxes scope
if (!function_exists('qodef_re_property_scope_meta_box_functions')) {
    function qodef_re_property_scope_meta_box_functions($post_types) {
        $post_types[] = 'property';

        return $post_types;
    }

    add_filter('bridge_qode_set_scope_for_meta_boxes', 'qodef_re_property_scope_meta_box_functions');
}

if ( ! function_exists( 'qodef_re_add_property_to_search_types' ) ) {
	function qodef_re_add_property_to_search_types( $post_types ) {
		$post_types['property'] = esc_html__( 'Property', 'qode-real-estate' );
		
		return $post_types;
	}
	
	add_filter( 'bridge_qode_search_post_type_widget_params_post_type', 'qodef_re_add_property_to_search_types' );
}

if (!function_exists('qodef_re_property_enqueue_meta_box_styles')) {
    function qodef_re_property_enqueue_meta_box_styles() {
        global $post;

        if ($post->post_type == 'property') {
            wp_enqueue_style('qodef-jquery-ui', get_template_directory_uri() . '/framework/admin/assets/css/jquery-ui/jquery-ui.css');
        }
    }

    add_action('bridge_qode_enqueue_meta_box_styles', 'qodef_re_property_enqueue_meta_box_styles');
}

if (!function_exists('qodef_re_property_add_social_share_option')) {
    function qodef_re_property_add_social_share_option($container) {
        bridge_qode_add_admin_field(
            array(
                'type'          => 'yesno',
                'name'          => 'enable_social_share_on_property',
                'default_value' => 'no',
                'label'         => esc_html__('Property', 'qode-real-estate'),
                'description'   => esc_html__('Show Social Share for Property Items', 'qode-real-estate'),
                'parent'        => $container
            )
        );
    }

    add_action('bridge_qode_post_types_social_share', 'qodef_re_property_add_social_share_option', 10, 1);
}

//Property rating functions
if (!function_exists('qodef_re_add_property_to_rating')) {
    function qodef_re_add_property_to_rating($post_types) {
        $post_types[] = 'property';

        return $post_types;
    }

    add_filter('qodef_core_filter_rating_post_types', 'qodef_re_add_property_to_rating');
}

//Register property post type
if (!function_exists('qodef_re_register_property_cpt')) {
    function qodef_re_register_property_cpt($cpt_class_name) {
        $cpt_class = array(
            'QodefRE\CPT\Property\PropertyRegister'
        );

        $cpt_class_name = array_merge($cpt_class_name, $cpt_class);

        return $cpt_class_name;
    }

    add_filter('qodef_re_filter_register_custom_post_types', 'qodef_re_register_property_cpt');
}

//Generate archive pages
if (!function_exists('qodef_re_get_holder_params_archive')) {
    /**
     * Function which return holder class and holder inner class for blog pages
     */
    function qodef_re_get_holder_params_archive() {
        $params_list = array();

        $layout = bridge_qode_options()->getOptionValue('real_estate_archive_page_layout');
        if ($layout == 'in-grid') {
            $params_list['holder'] = 'qodef-container';
            $params_list['inner'] = 'qodef-container-inner clearfix';
        } else {
            $params_list['holder'] = 'qodef-full-width';
            $params_list['inner'] = 'qodef-full-width-inner qodef-property-archive-inner';
        }

        /**
         * Available parameters for holder params
         * -holder
         * -inner
         */
        return apply_filters('qodef_re_filter_archive_holder_params', $params_list);
    }
}

if (!function_exists('qodef_re_get_archive_property_list')) {
    function qodef_re_get_archive_property_list($qodef_taxonomy_id = '', $qodef_taxonomy_name = '', $qodef_author_id = '', $enable_map_param = '', $enable_filter_param = '', $col_number_param = '') {

        $posts_per_page = 12;
        $number_of_items_option = bridge_qode_options()->getOptionValue('real_estate_archive_items_per_page');
        if (!empty($number_of_items_option)) {
            $posts_per_page = $number_of_items_option;
        }
	
	    $col_number = 2;
        $number_of_columns_option = bridge_qode_options()->getOptionValue('real_estate_archive_number_of_columns');
        if (!empty($number_of_columns_option)) {
            $col_number = $number_of_columns_option;
        }
	
	    if (!empty($col_number_param)) {
		    $col_number = $col_number_param;
	    }

        $col_space = 'medium';
        $space_between_items_option = bridge_qode_options()->getOptionValue('real_estate_archive_space_between_items');
        if (!empty($space_between_items_option)) {
            $col_space = $space_between_items_option;
        }

        $image_size = 'full';
        $image_size_option = bridge_qode_options()->getOptionValue('real_estate_archive_image_size');
        if (!empty($image_size_option)) {
            $image_size = $image_size_option;
        }

        $enable_filter = 'yes';
        $enable_filter_option = bridge_qode_options()->getOptionValue('real_estate_archive_filter');
        if (!empty($enable_filter_option)) {
            $enable_filter = $enable_filter_option;
        }

        if (!empty($enable_filter_param)) {
            $enable_filter = $enable_filter_param;
        }

        $enable_map = 'yes';
        $enable_map_option = bridge_qode_options()->getOptionValue('real_estate_archive_map');
        if (!empty($enable_map_option)) {
            $enable_map = $enable_map_option;
        }

        if (!empty($enable_map_param)) {
            $enable_map = $enable_map_param;
        }

        $enable_load_more = 'no-pagination';
        $enable_load_more_option = bridge_qode_options()->getOptionValue('real_estate_archive_load_more');
        if (!empty($enable_load_more_option)) {
            $enable_load_more = $enable_load_more_option;
        }

        $type = $qodef_taxonomy_name === 'property-type' && !empty($qodef_taxonomy_id) ? $qodef_taxonomy_id : '';
        $feature = $qodef_taxonomy_name === 'property-feature' && !empty($qodef_taxonomy_id) ? $qodef_taxonomy_id : '';
        $status = $qodef_taxonomy_name === 'property-status' && !empty($qodef_taxonomy_id) ? $qodef_taxonomy_id : '';
        $county = $qodef_taxonomy_name === 'property-county' && !empty($qodef_taxonomy_id) ? $qodef_taxonomy_id : '';
        $city = $qodef_taxonomy_name === 'property-city' && !empty($qodef_taxonomy_id) ? $qodef_taxonomy_id : '';
        $neighborhood = $qodef_taxonomy_name === 'property-neighborhood' && !empty($qodef_taxonomy_id) ? $qodef_taxonomy_id : '';
        $tag = $qodef_taxonomy_name === 'property-tag' && !empty($qodef_taxonomy_id) ? $qodef_taxonomy_id : '';
        $author = !empty($qodef_author_id) ? $qodef_author_id : '';

        $shortcode_params = array(
            'number_of_items'       => $posts_per_page,
            'number_of_columns'     => $col_number,
            'space_between_items'   => $col_space,
            'image_proportions'     => $image_size,
            'enable_filter'         => $enable_filter,
            'enable_map'            => $enable_map,
            'pagination_type'       => $enable_load_more,
            'property_type'         => $type,
            'property_features'     => $feature,
            'property_status'       => $status,
            'property_city'         => $city,
            'property_county'       => $county,
            'property_neighborhood' => $neighborhood,
            'property_tag'          => $tag,
            'property_contact'      => $author
        );

        $html = bridge_qode_execute_shortcode('qodef_property_list', $shortcode_params);

        print bridge_qode_get_module_part($html);
    }
}

// Load property shortcodes
if (!function_exists('qodef_re_include_property_shortcodes_file')) {
    /**
     * Loades all shortcodes by going through all folders that are placed directly in shortcodes folder
     */
    function qodef_re_include_property_shortcodes_file() {
        foreach (glob(QODE_RE_CPT_PATH . '/property/shortcodes/*/load.php') as $shortcode_load) {
            include_once $shortcode_load;
        }
    }

    add_action('qodef_re_action_include_shortcodes_file', 'qodef_re_include_property_shortcodes_file');
}

//Property archive functions
if (!function_exists('qodef_re_archive_property_title_display')) {
    /**
     * Function that checks option for property archive title and overrides it with filter
     */
    function qodef_re_archive_property_title_display($show_title_area) {

        if (is_tax('property-type') ||
            is_tax('property-feature') ||
            is_tax('property-status') ||
            is_tax('property-county') ||
            is_tax('property-city') ||
            is_tax('property-neighborhood') ||
            is_tax('property-tag') ||
            qodef_re_real_estate_role_called() ||
            is_search() && isset($_GET['qodef-property-search'])
        ) {
            //Override displaying title based on property option
            $show_title_area_archive = bridge_qode_options()->getOptionValue('show_title_area_property_archive');

            if (!empty($show_title_area_archive)) {
                $show_title_area = $show_title_area_archive === 'yes' ? true : false;
            }
        }

        return $show_title_area;
    }

    add_filter('bridge_qode_show_title_area', 'qodef_re_archive_property_title_display');
}

//Property single functions
if (!function_exists('qodef_re_single_property_title_display')) {
    /**
     * Function that checks option for single property title and overrides it with filter
     */
    function qodef_re_single_property_title_display($show_title_area) {
        if (is_singular('property')) {
            //Override displaying title based on property option
            $show_title_area_meta = bridge_qode_get_meta_field_intersect('show_title_area_property_single');

            if (!empty($show_title_area_meta)) {
                $show_title_area = $show_title_area_meta === 'yes' ? true : false;
            }
        }

        return $show_title_area;
    }

    add_filter('bridge_qode_filter_show_title_area', 'qodef_re_single_property_title_display');
}

if ( ! function_exists( 'qodef_re_show_reviews_form' ) ) {
	function qodef_re_show_reviews_form( $show_form ) {
		
		if ( is_singular( 'property' ) && !is_user_logged_in() ) {
			$show_form = false;
		}
		
		return $show_form;
	}
	
	add_filter( 'bridge_qode_show_comment_form_filter', 'qodef_re_show_reviews_form' );
}

if ( ! function_exists( 'qodef_re_show_comment_list_title' ) ) {
	function qodef_re_show_comment_list_title( $show_title ) {
		
		if ( is_singular( 'property' ) ) {
			$show_title = false;
		}
		
		return $show_title;
	}
	
	add_filter( 'bridge_qode_show_comment_list_title_filter', 'qodef_re_show_comment_list_title' );
}

if ( ! function_exists( 'qodef_re_comment_final_fields' ) ) {
	function qodef_re_comment_final_fields( $args ) {
		if ( is_singular( 'property' ) ) {
			$args['logged_in_as'] = '';
		}
		
		return $args;
	}
	
	add_filter( 'bridge_qode_comment_form_final_fields', 'qodef_re_comment_final_fields', 10, 1 );
}

if ( ! function_exists( 'qodef_re_single_property_content_styles' ) ) {
	function qodef_re_single_property_content_styles() {
		$content_style = array();
		
		$padding_top = bridge_qode_options()->getOptionValue( 'content_top_padding_property_single' );
		if ( $padding_top !== '' ) {
			$content_style['padding-top'] = bridge_qode_filter_px( $padding_top ) . 'px';
		}
		
		$content_selector = array(
			'.single.single-property .qodef-content .qodef-content-inner > .qodef-full-width > .qodef-full-width-inner',
		);
		
		echo bridge_qode_dynamic_css( $content_selector, $content_style );
	}
	
	add_action( 'bridge_qode_style_dynamic', 'qodef_re_single_property_content_styles' );
}

if (!function_exists('qodef_re_single_property_sidebar_display')) {
    /**
     * Function that checks option for single property sidebar and overrides it with filter
     */
    function qodef_re_single_property_sidebar_display($sidebar_layout) {
        if (is_singular('property')) {
            //Override displaying sidebar based on property meta field
            $sidebar_layout_meta = get_post_meta(get_the_ID(), 'qodef_sidebar_layout_meta', true);

            if (empty($sidebar_layout_meta)) {
                $sidebar_layout = bridge_qode_options()->getOptionValue('property_single_sidebar_layout');
            }
        }

        return $sidebar_layout;
    }

    add_filter('bridge_qode_sidebar_layout', 'qodef_re_single_property_sidebar_display');
}

if (!function_exists('qodef_re_single_property_sidebar')) {
    /**
     * Function that checks option for single property sidebar name and overrides it with filter
     */
    function qodef_re_single_property_sidebar() {
        if (is_singular('property')) {
            //Override displaying sidebar based on property meta field
            $sidebar_name = '';
            $sidebar_name_meta = get_post_meta(get_the_ID(), 'qode_choose-sidebar', true);

            if ( empty( $sidebar_name_meta ) ) {
                $sidebar_name = bridge_qode_options()->getOptionValue('property_custom_sidebar_area');
            } else {
                $sidebar_name = $sidebar_name_meta;
            }

            if( empty( $sidebar_name ) ){
                $sidebar_name = 'sidebar';
            }
        }

        if ( is_active_sidebar( $sidebar_name ) ) {
            dynamic_sidebar( $sidebar_name );
        };
    }
}

if (!function_exists('qodef_re_set_single_property_comments_enabled')) {
    function qodef_re_set_single_property_comments_enabled($comments) {
        if (is_singular('property') && bridge_qode_options()->getOptionValue('property_single_comments') == 'yes') {
            $comments = true;
        }

        return $comments;
    }

    add_filter('bridge_qode_post_type_comments', 'qodef_re_set_single_property_comments_enabled', 10, 1);
}

if (!function_exists('qodef_re_get_single_property')) {
    function qodef_re_get_single_property() {
        $item_layout = bridge_qode_get_meta_field_intersect('property_single_layout');
        $sidebar_layout = bridge_qode_options()->getOptionValue('property_single_sidebar_layout');
        $sidebar_layout_class = '';

        if( ! empty( $sidebar_layout ) ) {
            if ($sidebar_layout == '1') {
                $sidebar_layout_class = 'two_columns_66_33';
            } else if ($sidebar_layout == '2') {
                $sidebar_layout_class = 'two_columns_75_25';
            }
        }

        $params = array(
            'item_layout'    => $item_layout,
            'sidebar_layout' => $sidebar_layout,
            'sidebar_layout_class' => $sidebar_layout_class,
        );

        qodef_re_get_cpt_single_module_template_part('templates/single/holder', 'property', '', $params);

    }
}

if (!function_exists('qodef_re_get_author_page_property')) {
    function qodef_re_get_author_page_property() {
        $author = get_user_by('slug', get_query_var('author_name'));
        $role = $author->roles[0];
        $params = array(
            'author'         => $author,
            'role'           => $role,
            'holder_params'  => qodef_re_get_holder_params_archive(),
            'sidebar_layout' => 'no-sidebar'
        );

        qodef_re_get_cpt_single_module_template_part('templates/author/holder', 'property', '', $params);

    }
}

if (!function_exists('qodef_re_get_property_enquiry_form_html')) {
    function qodef_re_get_property_enquiry_form_html() {
        if (is_singular('property')) {
            qodef_re_get_cpt_single_module_template_part('templates/single/parts/form', 'property', '', array());
        }
    }

    add_action('wp_footer', 'qodef_re_get_property_enquiry_form_html');
}

if (!function_exists('qodef_re_get_property_single_related_posts')) {
    /**
     * Function for returning property single related posts
     *
     * @param $post_id
     *
     * @return WP_Query
     */
    function qodef_re_get_property_single_related_posts($post_id) {
        //Get types
        $types = wp_get_object_terms($post_id, 'property-type');
        $type_ids = array();
        if ($types) {
            foreach ($types as $type) {
                $type_ids[] = $type->term_id;
            }
        }

        //Get status
        $statuses = wp_get_object_terms($post_id, 'property-status');
        $status_ids = array();
        if ($statuses) {
            foreach ($statuses as $status) {
                $status_ids[] = $status->term_id;
            }
        }

        //Get tags
        $tags = wp_get_object_terms($post_id, 'property-tag');
        $tag_ids = array();
        if ($tags) {
            foreach ($tags as $tag) {
                $tag_ids[] = $tag->term_id;
            }
        }

        if ($type_ids) {
            $related_by_type = qodef_re_get_property_single_related_posts_by_param($post_id, $type_ids, 'property-type');

            if (!empty($related_by_type->posts)) {
                return $related_by_type;
            }
        }

        if ($status_ids) {
            $related_by_status = qodef_re_get_property_single_related_posts_by_param($post_id, $status_ids, 'property-status');

            if (!empty($related_by_status->posts)) {
                return $related_by_status;
            }
        }

        if ($tag_ids) {
            $related_by_tag = qodef_re_get_property_single_related_posts_by_param($post_id, $tag_ids, 'property-tag');

            if (!empty($related_by_tag->posts)) {
                return $related_by_tag;
            }
        }
    }
}

if (!function_exists('qodef_re_get_property_single_related_posts_by_param')) {
    /**
     * @param $post_id - Post ID
     * @param $term_ids - Category or Tag IDs
     * @param $taxonomy
     *
     * @return WP_Query
     */
    function qodef_re_get_property_single_related_posts_by_param($post_id, $term_ids, $taxonomy) {
        $cities = wp_get_object_terms($post_id, 'property-city');
        $city_ids = array();
        if ($cities) {
            foreach ($cities as $city) {
                $city_ids[] = $city->term_id;
            }
        }

        $args = array(
            'post_status'    => 'publish',
            'post__not_in'   => array($post_id),
            'order'          => 'DESC',
            'orderby'        => 'date',
            'posts_per_page' => '4',
            'tax_query'      => array(
                array(
                    'taxonomy' => 'property-city',
                    'field'    => 'term_id',
                    'terms'    => $city_ids,
                ),
                array(
                    'taxonomy' => $taxonomy,
                    'field'    => 'term_id',
                    'terms'    => $term_ids,
                ),
            )
        );

        $related_by_taxonomy = new WP_Query($args);

        return $related_by_taxonomy;
    }
}

if (!function_exists('qodef_re_get_real_estate_item_price')) {
    function qodef_re_get_real_estate_item_price($item_id = '') {
        $item_id = isset($item_id) && !empty($item_id) ? $item_id : get_the_ID();
        $price = get_post_meta($item_id, 'qodef_property_price_meta', true);
        $discount_price = get_post_meta($item_id, 'qodef_property_discount_price_meta', true);

        if (isset($discount_price) && !empty($discount_price)) {
            return $discount_price;
        } else {
            return $price;
        }
    }
}

if (!function_exists('qodef_re_get_real_estate_size_html')) {
    function qodef_re_get_real_estate_size_html($size, $item_id = '') {
        $item_id = isset($item_id) && !empty($item_id) ? $item_id : get_the_ID();
        $size_label = bridge_qode_get_meta_field_intersect('property_size_label', $item_id);
        $size_position = bridge_qode_get_meta_field_intersect('property_size_label_position', $item_id);
        $label_html = $size_html = $html = '';

        $size_html .= '<span class="qodef-property-size-value">';
        $size_html .= $size;
        $size_html .= '</span>';

        if (isset($size_label) && !empty($size_label)) {
            $label_html .= '<span class="qodef-property-size-label">';
            $label_html .= $size_label;
            $label_html .= '</span>';
            if (isset($size_position)) {
                if ($size_position === 'before') {
                    $html .= $label_html;
                    $html .= $size_html;
                } else {
                    $html .= $size_html;
                    $html .= $label_html;
                }
            }
        } else {
            $html = $size_html;
        }

        return $html;
    }
}

if (!function_exists('qodef_re_get_real_estate_size')) {
    function qodef_re_get_real_estate_size($size, $item_id = '') {
        $item_id = isset($item_id) && !empty($item_id) ? $item_id : get_the_ID();
        $size_label = bridge_qode_get_meta_field_intersect('property_size_label', $item_id);
        $size_position = bridge_qode_get_meta_field_intersect('property_size_label_position', $item_id);
        $label_html = $size_html = $html = '';

        $size_html .= $size;

        if (isset($size_label) && !empty($size_label)) {
            $label_html .= $size_label;
            if (isset($size_position)) {
                if ($size_position === 'before') {
                    $html .= $label_html;
                    $html .= $size_html;
                } else {
                    $html .= $size_html;
                    $html .= $label_html;
                }
            }
        } else {
            $html = $size_html;
        }

        return $html;
    }
}

if (!function_exists('qodef_re_get_real_estate_price_html')) {
    function qodef_re_get_real_estate_price_html($price, $item_id = '') {
        $item_id = isset($item_id) && !empty($item_id) ? $item_id : get_the_ID();
        //var_dump( get_post_meta($item_id,'qodef_property_price_label_meta', true) ); exit;
        $price_label = bridge_qode_get_meta_field_intersect('property_price_label', $item_id);
        $price_position = bridge_qode_get_meta_field_intersect('property_price_label_position', $item_id);
        $label_html = $price_html = $html = '';


        if (!empty($price) || $price == '0') {
            $price = number_format($price, '0', ',', '.');

            $price_html .= '<span class="qodef-property-price-value">';
            $price_html .= $price;
            $price_html .= '</span>';
            if (isset($price_label) && !empty($price_label)) {
                $label_html .= '<span class="qodef-property-price-label">';
                $label_html .= $price_label;
                $label_html .= '</span>';
                if (isset($price_position)) {
                    if ($price_position === 'before') {
                        $html .= $label_html;
                        $html .= $price_html;
                    } else {
                        $html .= $price_html;
                        $html .= $label_html;
                    }
                }
            } else {
                $html = $price_html;
            }
        }

        return $html;
    }
}

if (!function_exists('qodef_re_get_real_estate_price')) {
    function qodef_re_get_real_estate_price($price, $item_id = '') {
        $item_id = isset($item_id) && !empty($item_id) ? $item_id : get_the_ID();
        $price_label = bridge_qode_get_meta_field_intersect('property_price_label', $item_id);
        $price_position = bridge_qode_get_meta_field_intersect('property_price_label_position', $item_id);
        $label_html = $price_html = $html = '';

        $price_html .= $price;

        if (isset($price_label) && !empty($price_label)) {
            $label_html .= $price_label;
            if (isset($price_position)) {
                if ($price_position === 'before') {
                    $html .= $label_html;
                    $html .= $price_html;
                } else {
                    $html .= $price_html;
                    $html .= $label_html;
                }
            }
        } else {
            $html = $price_html;
        }

        return $html;
    }
}

if (!function_exists('qodef_re_get_property_taxonomy')) {
    function qodef_re_get_property_taxonomy($taxonomy, $item_id = '') {
        $item_id = isset($item_id) && !empty($item_id) ? $item_id : get_the_ID();

        if (isset($taxonomy) && !empty($taxonomy)) {
            $taxonomies = wp_get_post_terms($item_id, $taxonomy);
            return $taxonomies;
        }

        return '';
    }
}

if (!function_exists('qodef_re_get_property_specification_items')) {
    function qodef_re_get_property_specification_items($item_id = '') {
        $item_id = isset($item_id) && !empty($item_id) ? $item_id : get_the_ID();

        $specification_items = array();

        //Get Bedrooms
        $item = array();
        $item['icon'] = '<img src="' . qodef_re_get_assets_icon_src('icon-bedrooms', 'png') . '" alt="' . esc_attr__('Property bedroom icon', 'qode-real-estate') . '"/>';
        $item['label'] = esc_html__('Bedrooms:', 'qode-real-estate');
        $item['value'] = get_post_meta($item_id, 'qodef_property_bedrooms_meta', true);
        $specification_items[] = $item;

        //Get Bathrooms
        $item = array();
        $item['icon'] = '<img src="' . qodef_re_get_assets_icon_src('icon-bathrooms', 'png') . '" alt="' . esc_attr__('Property bathroom icon', 'qode-real-estate') . '"/>';
        $item['label'] = esc_html__('Bathrooms:', 'qode-real-estate');
        $item['value'] = get_post_meta($item_id, 'qodef_property_bathrooms_meta', true);
        $specification_items[] = $item;

        //Get Property Size
        $item = array();
        $item['icon'] = '<img src="' . qodef_re_get_assets_icon_src('icon-property-size', 'png') . '" alt="' . esc_attr__('Property size icon', 'qode-real-estate') . '"/>';
        $item['label'] = esc_html__('Property size:', 'qode-real-estate');
        $size = get_post_meta($item_id, 'qodef_property_size_meta', true);
        $item['value'] = qodef_re_get_real_estate_size($size);
        $specification_items[] = $item;

        //Get Floor
        $item = array();
        $item['icon'] = '<img src="' . qodef_re_get_assets_icon_src('icon-floor', 'png') . '" alt="' . esc_attr__('Property floor icon', 'qode-real-estate') . '"/>';
        $item['label'] = esc_html__('Floor:', 'qode-real-estate');
        $item['value'] = get_post_meta($item_id, 'qodef_property_floor_meta', true);
        $specification_items[] = $item;

        //Get Total Floors
        $item = array();
        $item['icon'] = '<img src="' . qodef_re_get_assets_icon_src('icon-total-floors', 'png') . '" alt="' . esc_attr__('Property total floors icon', 'qode-real-estate') . '"/>';
        $item['label'] = esc_html__('Total floors:', 'qode-real-estate');
        $item['value'] = get_post_meta($item_id, 'qodef_property_total_floors_meta', true);
        $specification_items[] = $item;

        //Get Year Built
        $item = array();
        $item['icon'] = '<img src="' . qodef_re_get_assets_icon_src('icon-year-built', 'png') . '" alt="' . esc_attr__('Property year built icon', 'qode-real-estate') . '"/>';
        $item['label'] = esc_html__('Year Built:', 'qode-real-estate');
        $item['value'] = get_post_meta($item_id, 'qodef_property_year_built_meta', true);
        $specification_items[] = $item;

        //Get Heating
        $item = array();
        $item['icon'] = '<img src="' . qodef_re_get_assets_icon_src('icon-heating', 'png') . '" alt="' . esc_attr__('Property heating icon', 'qode-real-estate') . '"/>';
        $item['label'] = esc_html__('Heating:', 'qode-real-estate');
        $item['value'] = get_post_meta($item_id, 'qodef_property_heating_meta', true);
        $specification_items[] = $item;

        //Get Accommodation
        $item = array();
        $item['icon'] = '<img src="' . qodef_re_get_assets_icon_src('icon-accommodation', 'png') . '" alt="' . esc_attr__('Property accommodation icon', 'qode-real-estate') . '"/>';
        $item['label'] = esc_html__('Accommodation:', 'qode-real-estate');
        $item['value'] = get_post_meta($item_id, 'qodef_property_accommodation_meta', true);
        $specification_items[] = $item;

        return $specification_items;
    }
}

if (!function_exists('qodef_re_get_property_additional_specification_items')) {
    function qodef_re_get_property_additional_specification_items($item_id = '') {
        $item_id = isset($item_id) && !empty($item_id) ? $item_id : get_the_ID();

        $specification_items = array();

        //Get Ceiling Height
        $item = array();
        $item['icon'] = '<img src="' . qodef_re_get_assets_icon_src('icon-ceiling-height', 'png') . '" alt="' . esc_attr__('Property ceiling height icon', 'qode-real-estate') . '"/>';
        $item['label'] = esc_html__('Ceiling height:', 'qode-real-estate');
        $item['value'] = get_post_meta($item_id, 'qodef_property_ceiling_height_meta', true);
        $specification_items[] = $item;

        //Get Parking
        $item = array();
        $item['icon'] = '<img src="' . qodef_re_get_assets_icon_src('icon-parking', 'png') . '" alt="' . esc_attr__('Property parking icon', 'qode-real-estate') . '"/>';
        $item['label'] = esc_html__('Parking:', 'qode-real-estate');
        $item['value'] = get_post_meta($item_id, 'qodef_property_parking_meta', true);
        $specification_items[] = $item;

        //Get Distance from Center
        $item = array();
        $item['icon'] = '<img src="' . qodef_re_get_assets_icon_src('icon-d-f-center', 'png') . '" alt="' . esc_attr__('Property distance from center icon', 'qode-real-estate') . '"/>';
        $item['label'] = esc_html__('From center:', 'qode-real-estate');
        $item['value'] = get_post_meta($item_id, 'qodef_property_from_center_meta', true);
        $specification_items[] = $item;

        //Get Publication Date
        $item = array();
        $item['icon'] = '<img src="' . qodef_re_get_assets_icon_src('icon-publication-date', 'png') . '" alt="' . esc_attr__('Property publication date', 'qode-real-estate') . '"/>';
        $item['label'] = esc_html__('Publication date:', 'qode-real-estate');
        $item['value'] = get_post_meta($item_id, 'qodef_property_publication_date_meta', true);
        $specification_items[] = $item;

        //Get Area Size
        $item = array();
        $item['icon'] = '<img src="' . qodef_re_get_assets_icon_src('icon-area-size', 'png') . '" alt="' . esc_attr__('Property area size icon', 'qode-real-estate') . '"/>';
        $item['label'] = esc_html__('Area size:', 'qode-real-estate');
        $size = get_post_meta($item_id, 'qodef_property_area_size_meta', true);
        $item['value'] = qodef_re_get_real_estate_size($size);
        $specification_items[] = $item;

        //Get Garages
        $item = array();
        $item['icon'] = '<img src="' . qodef_re_get_assets_icon_src('icon-garages', 'png') . '" alt="' . esc_attr__('Property garages icon', 'qode-real-estate') . '"/>';
        $item['label'] = esc_html__('Garages:', 'qode-real-estate');
        $item['value'] = get_post_meta($item_id, 'qodef_property_garages_meta', true);
        $specification_items[] = $item;

        //Get Garages Size
        $item = array();
        $item['icon'] = '<img src="' . qodef_re_get_assets_icon_src('icon-garages-size', 'png') . '" alt="' . esc_attr__('Property garages size icon', 'qode-real-estate') . '"/>';
        $item['label'] = esc_html__('Garages size:', 'qode-real-estate');
        $size = get_post_meta($item_id, 'qodef_property_garages_size_meta', true);
        $item['value'] = qodef_re_get_real_estate_size($size);
        $specification_items[] = $item;

        //Get Additional Space
        $item = array();
        $item['icon'] = '<img src="' . qodef_re_get_assets_icon_src('icon-additional-space', 'png') . '" alt="' . esc_attr__('Property additional space icon', 'qode-real-estate') . '"/>';
        $item['label'] = esc_html__('Additional space:', 'qode-real-estate');
        $item['value'] = get_post_meta($item_id, 'qodef_property_additional_space_meta', true);
        $specification_items[] = $item;

        return $specification_items;
    }
}

if (!function_exists('qodef_re_get_property_features')) {
    function qodef_re_get_property_features($item_id = '') {
        $item_id = isset($item_id) && !empty($item_id) ? $item_id : get_the_ID();
        $formatted_features = array();

        $features = get_terms(array(
            'taxonomy'   => 'property-feature',
            'hide_empty' => false
        ));
        $active_features = qodef_re_get_property_taxonomy('property-feature', $item_id);
        if (!empty($features) && count($features) && is_array($active_features) && count($active_features)) {
            foreach ($features as $feature) {
                $formatted = array();
                $formatted['status'] = in_array($feature, $active_features) ? 'active' : 'inactive';
                $formatted['name'] = $feature->name;
                $formatted_features[] = $formatted;
            }
        }
        return $formatted_features;

    }
}

if (!function_exists('qodef_re_get_property_contact_user')) {
    function qodef_re_get_property_contact_user($id = '') {
        if ($id === '') {
            $id = get_the_ID();
        }

        $assocciated_user_type = get_post_meta($id, 'qodef_property_contact_info_meta', true);
        $assocciated_user_id = get_post_meta($id, 'qodef_property_contact_' . $assocciated_user_type . '_meta', true);
        $user = get_user_by('id', $assocciated_user_id);

        return $user;
    }
}

//Ajax functions
if (!function_exists('qodef_re_send_property_enquiry')) {

    function qodef_re_send_property_enquiry() {
        if (empty($_POST) || !isset($_POST) || !isset($_POST['data'])) {
            qodef_re_ajax_status('error', esc_html__('All fields are empty', 'qode-real-estate'));
        } else {
            $email_data = $_POST['data'];
            $nonce = $email_data['nonce'];

            if (wp_verify_nonce($nonce, 'qodef_re_validate_property_item_enquiry')) {

                $error = false;
                $responseMessage = '';

                //Validate
                if ($email_data['name']) {
                    $name = esc_html($email_data['name']);
                } else {
                    $error = true;
                    $responseMessage = esc_html__('Please insert valid name', 'qode-real-estate');
                }

                if ($email_data['email']) {
                    $email = esc_html($email_data['email']);
                } else {
                    $error = true;
                    $responseMessage = esc_html__('Please insert valid email', 'qode-real-estate');
                }

                if ($email_data['message']) {
                    $message = esc_html($email_data['message']);
                } else {
                    $error = true;
                    $responseMessage = esc_html__('Please fix your message content', 'qode-real-estate');
                }

                //Send Mail and response
                if ($error) {

                    qodef_re_ajax_status('error', $responseMessage);

                } else {

                    //Get post id from request
                    $post_id = $email_data['itemId'];
                    //Get email address
                    $contact_user = qodef_re_get_property_contact_user($post_id);
                    $mail_to = $contact_user->user_email;
                    $post_title = get_the_title($post_id);
	
	                $headers = array(
		                'From: ' . $name . ' <' . $email . '>',
		                'Reply-To: ' . $name . ' <' . $email . '>',
	                );

                    $additional_emails = array();

                    $additional_emails[] = $mail_to;
                    $headers[] = 'Bcc: ' . implode(',', $additional_emails);

                    $messageTemplate = esc_html__('From', 'qode-real-estate') . ': ' . $name . "\r\n";
                    $messageTemplate .= esc_html__('Message', 'qode-real-estate') . ': ' . $message . "\r\n\n";
                    $messageTemplate .= esc_html__('Message sent via enquiry form on', 'qode-real-estate') . ' ' . get_bloginfo('name') . ' - ' . esc_url(home_url('/'));
                    
                    $messageSubject = esc_html__('New Enquiry Form', 'qode-real-estate');

                    if( ! empty( $post_title ) ){
                    	$messageSubject .= esc_html__(' regarding property', 'qode-real-estate') . $post_title;
                    }

                    $mail_sent = wp_mail(
                        $mail_to, //Mail To
	                    $messageSubject, //Subject
                        $messageTemplate, //Message
                        $headers //Additional Headers
                    );

                    if ($mail_sent) {
                        $success_message = bridge_qode_options()->getOptionValue('property_success_message_text');
                        $success_message = $success_message !== '' ? $success_message : esc_html__('Thank you for sending message. You will be contacted soon.', 'qode-real-estate');
                        $responseMessage = $success_message;
                        qodef_re_ajax_status('success', $responseMessage);
                    } else {
                        $fail_message = bridge_qode_options()->getOptionValue('property_fail_message_text');
                        $fail_message = $fail_message !== '' ? $fail_message : esc_html__('An error occurred during message sending. Please try again.', 'qode-real-estate');
                        $responseMessage = $fail_message;
                        qodef_re_ajax_status('error', $responseMessage);
                    }
                }

            } else {
                qodef_re_ajax_status('error', esc_html__('Bad form data sent', 'qode-real-estate'));
            }
        }
    }

    add_action('wp_ajax_nopriv_qodef_re_send_property_enquiry', 'qodef_re_send_property_enquiry');
    add_action('wp_ajax_qodef_re_send_property_enquiry', 'qodef_re_send_property_enquiry');
}

if (!function_exists('qodef_re_get_property_terms_list')) {
    function qodef_re_get_property_terms_list($term) {
        $term_list = array();

        $terms = get_terms(array(
            'taxonomy'   => $term,
            'hide_empty' => false,
        ));

        foreach ($terms as $term) {
            $term_item = array();

            $term_item['id'] = $term->term_id;
            $term_item['name'] = $term->name;
            $term_item['slug'] = $term->slug;

            $term_list[] = $term_item;
        }

        return $term_list;
    }
}


if (!function_exists('qodef_re_get_property_terms_list_dashboard')) {
    function qodef_re_get_property_terms_list_dashboard($term, $id_as_key = true) {
        $term_list = array();

        $terms = get_terms(array(
            'taxonomy'   => $term,
            'hide_empty' => false,
        ));

        foreach ($terms as $term) {
            if ($id_as_key) {
                $term_list[$term->term_id] = $term->name;
            } else {
                $term_list[$term->slug] = $term->name;
            }
        }

        return $term_list;
    }
}

if (!function_exists('qodef_re_generate_query_array')) {
    function qodef_re_generate_query_array($params) {
        $query_array = array(
            'post_status'    => 'publish',
            'post_type'      => 'property',
            'posts_per_page' => $params['number_of_items'],
            'orderby'        => $params['order_by'],
            'order'          => $params['order']
        );

        $property_ids = null;
        if (!empty($params['selected_properties'])) {
            $property_ids = explode(',', $params['selected_properties']);
            $query_array['post__in'] = $property_ids;
        }

        // TAXONOMY QUERY VALUES
        if (!empty($params['property_type']) || !empty($params['property_status']) || !empty($params['property_city']) || !empty($params['property_features']) || !empty($params['property_county']) || !empty($params['property_neighborhood']) || !empty($params['property_tag'])) {
            $tax_query = array();

            if (!empty($params['property_type'])) {
                $tax_query[] = array(
                    'taxonomy' => 'property-type',
                    'terms'    => $params['property_type']
                );
            }

            if (!empty($params['property_status'])) {
                $tax_query[] = array(
                    'taxonomy' => 'property-status',
                    'terms'    => $params['property_status']
                );
            }

            if (!empty($params['property_city'])) {
                $tax_query[] = array(
                    'taxonomy' => 'property-city',
                    'terms'    => $params['property_city']
                );
            }

            if (!empty($params['property_features'])) {
                $tax_query[] = array(
                    'taxonomy' => 'property-feature',
                    'terms'    => $params['property_features']
                );
            }

            if (!empty($params['property_county'])) {
                $tax_query[] = array(
                    'taxonomy' => 'property-county',
                    'terms'    => $params['property_county']
                );
            }

            if (!empty($params['property_neighborhood'])) {
                $tax_query[] = array(
                    'taxonomy' => 'property-neighborhood',
                    'terms'    => $params['property_neighborhood']
                );
            }

            if (!empty($params['property_tag'])) {
                $tax_query[] = array(
                    'taxonomy' => 'property-tag',
                    'terms'    => $params['property_tag']
                );
            }


            $query_array['tax_query'] = $tax_query;
        }

        return $query_array;
    }
}

if ( ! function_exists( 'qode_re_add_share_option_to_album_post_type' ) ) {
    function qode_re_add_share_option_to_album_post_type($parent) {

        bridge_qode_add_admin_field(
            array(
                'name'          => 'post_types_names_property',
                'type'          => 'flagcustomposttype',
                'default_value' => '',
                'label'         => esc_html__( 'Property Item', 'qode-real-estate' ),
                'description'   => esc_html__( 'Show Social Share for Property Items', 'qode-real-estate' ),
                'args' => array(
                    'custom_post_type' => 'property'
                ),
                'parent'        => $parent
            )
        );

    }

    add_action( 'bridge_qode_action_option_social_page_map', 'qode_re_add_share_option_to_album_post_type', 10, 1 );
}
