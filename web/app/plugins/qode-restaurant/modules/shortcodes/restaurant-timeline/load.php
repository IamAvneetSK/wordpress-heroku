<?php

include_once QODE_RESTAURANT_SHORTCODES_PATH . '/restaurant-timeline/functions.php';
include_once QODE_RESTAURANT_SHORTCODES_PATH . '/restaurant-timeline/restaurant-timeline.php';

if(!function_exists('qode_restaurant_include_elementor_restaurant_timeline_shortcode')) {
    function qode_restaurant_include_elementor_restaurant_timeline_shortcode() {
        if( qode_restaurant_is_elementor_installed() ) {
            include_once QODE_RESTAURANT_SHORTCODES_PATH . '/restaurant-timeline/elementor-restaurant-timeline.php';
        }
    }

    add_action('bridge_core_load_elementor_shortcodes_from_plugins', 'qode_restaurant_include_elementor_restaurant_timeline_shortcode');
}