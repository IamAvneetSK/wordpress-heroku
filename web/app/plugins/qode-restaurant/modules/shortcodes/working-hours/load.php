<?php

include_once QODE_RESTAURANT_SHORTCODES_PATH.'/working-hours/functions.php';
include_once QODE_RESTAURANT_SHORTCODES_PATH.'/working-hours/working-hours.php';

if(!function_exists('qode_restaurant_include_elementor_working_hours_shortcode')) {
    function qode_restaurant_include_elementor_working_hours_shortcode() {
        if( qode_restaurant_is_elementor_installed() ) {
            include_once QODE_RESTAURANT_SHORTCODES_PATH . '/working-hours/elementor-working-hours.php';
        }
    }

    add_action('bridge_core_load_elementor_shortcodes_from_plugins', 'qode_restaurant_include_elementor_working_hours_shortcode');
}