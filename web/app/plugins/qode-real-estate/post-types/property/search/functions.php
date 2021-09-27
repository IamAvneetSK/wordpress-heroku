<?php
if (!function_exists('qodef_re_property_override_search_template_path')) {
    function qodef_re_property_override_search_template_path($template_path) {

        if (isset($_GET['qodef-property-search'])) {
            $template_path = QODE_RE_CPT_PATH . '/';
        }

        return $template_path;
    }

    add_filter('bridge_qode_filter_edit_module_template_path', 'qodef_re_property_override_search_template_path', 10, 1);
}

if (!function_exists('qodef_re_property_override_search_module')) {
    function qodef_re_property_override_search_module($module) {

        if (isset($_GET['qodef-property-search'])) {
            $module = 'property';
        }

        return $module;
    }

    add_filter('bridge_qode_filter_search_page_module', 'qodef_re_property_override_search_module', 10, 1);
}

if (!function_exists('qodef_re_property_override_search_path')) {
    function qodef_re_property_override_search_path($path) {

        if (isset($_GET['qodef-property-search'])) {
            $path = 'search';
        }

        return $path;
    }

    add_filter('bridge_qode_filter_search_page_path', 'qodef_re_property_override_search_path', 10, 1);
}

if (!function_exists('qodef_re_property_override_search_template')) {
    function qodef_re_property_override_search_template($params) {

        if (is_search() && isset($_GET['qodef-property-search'])) {
            $params['holder'] = 'qodef-full-width';
            $params['inner']  = 'qodef-full-width-inner qodef-property-search-inner';
        }

        return $params;
    }

    add_filter('bridge_qode_filter_search_holder_params', 'qodef_re_property_override_search_template', 10, 1);
}

if (!function_exists('qodef_re_property_override_search_plugin')) {
    function qodef_re_property_override_search_plugin($plugin) {

        if (isset($_GET['qodef-property-search'])) {
            $plugin = true;
        }

        return $plugin;
    }

    add_filter('bridge_qode_filter_search_page_plugin_override', 'qodef_re_property_override_search_plugin', 10, 1);
}

if (!function_exists('qodef_re_property_override_search_params')) {
    function qodef_re_property_override_search_params($params) {

        if (isset($_GET['qodef-property-search'])) {
            $params = array();

            if (isset($_GET['qodef-search-type'])) {
                $params['property_type'] = $_GET['qodef-search-type'];
            }

            if (isset($_GET['qodef-search-city'])) {
                $params['property_city'] = $_GET['qodef-search-city'];
            }

            if (isset($_GET['qodef-search-status'])) {
                $params['property_status'] = $_GET['qodef-search-status'];
            }

            if (isset($_GET['qodef-search-minPrice'])) {
                $params['property_min_price'] = $_GET['qodef-search-minPrice'];
            }

            if (isset($_GET['qodef-search-maxPrice'])) {
                $params['property_max_price'] = $_GET['qodef-search-maxPrice'];
            }

            if (isset($_GET['qodef-search-minSize'])) {
                $params['property_min_size'] = $_GET['qodef-search-minSize'];
            }

            if (isset($_GET['qodef-search-maxSize'])) {
                $params['property_max_size'] = $_GET['qodef-search-maxSize'];
            }

            if (isset($_GET['qodef-search-bedrooms'])) {
                $params['property_bedrooms'] = $_GET['qodef-search-bedrooms'];
            }

            if (isset($_GET['qodef-search-bathrooms'])) {
                $params['property_bathrooms'] = $_GET['qodef-search-bathrooms'];
            }

            if (isset($_GET['qodef-search-features'])) {
                $params['property_features'] = $_GET['qodef-search-features'];
            }
        }

        return $params;
    }

    add_filter('bridge_qode_filter_search_page_params', 'qodef_re_property_override_search_params', 10, 1);
}

if (!function_exists('qodef_re_property_override_search_title')) {
    function qodef_re_property_override_search_title($title) {

        if (isset($_GET['qodef-property-search'])) {
            $title = esc_html__('List of filtered properties', 'select-real-estate');
        }

        return $title;
    }

    add_filter('bridge_qode_filter_title_text', 'qodef_re_property_override_search_title', 10, 1);
}

if (!function_exists('qodef_re_property_override_search_title_display')) {
    /**
     * Function that checks option for property archive title and overrides it with filter
     */
    function qodef_re_property_override_search_title_display($show_title_area) {

        if (isset($_GET['qodef-property-search'])) {
            //Override displaying title based on property option
            $show_title_area_archive = bridge_qode_options()->getOptionValue('show_title_area_property_archive');

            if (!empty($show_title_area_archive)) {
                $show_title_area = $show_title_area_archive === 'yes' ? true : false;
            }
        }

        return $show_title_area;
    }

    add_filter('bridge_qode_filter_show_title_area', 'qodef_re_property_override_search_title_display');
}

if (!function_exists('qodef_re_get_search_page_sc_params')) {
    function qodef_re_get_search_page_sc_params($params) {

        $posts_per_page = bridge_qode_options()->getOptionValue('real_estate_archive_items_per_page');
        $col_number = bridge_qode_options()->getOptionValue('real_estate_archive_number_of_columns');
        $col_space = bridge_qode_options()->getOptionValue('real_estate_archive_space_between_items');
        $image_size = bridge_qode_options()->getOptionValue('real_estate_archive_image_size');
        $enable_filter = bridge_qode_options()->getOptionValue('real_estate_archive_filter');
        $enable_map = bridge_qode_options()->getOptionValue('real_estate_archive_map');
        $enable_load_more = bridge_qode_options()->getOptionValue('real_estate_archive_load_more');

        $posts_per_page = $posts_per_page === '' ? '-1' : $posts_per_page;

        $shortcode_params = array(
            'number_of_items'     => $posts_per_page,
            'number_of_columns'   => $col_number,
            'space_between_items' => $col_space,
            'image_proportions'   => $image_size,
            'enable_filter'       => $enable_filter,
            'enable_map'          => $enable_map,
            'pagination_type'     => $enable_load_more,
            'hide_active_filter'  => 'no',
        );

        $params = array_merge($params, $shortcode_params);

        return $params;
    }
}