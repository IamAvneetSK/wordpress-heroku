<?php

include_once QODE_RESTAURANT_SHORTCODES_PATH.'/reservation-form/functions.php';
include_once QODE_RESTAURANT_SHORTCODES_PATH.'/reservation-form/reservation-form.php';

if(!function_exists('qode_restaurant_include_elementor_reservation_form_shortcode')) {
    function qode_restaurant_include_elementor_reservation_form_shortcode() {
        if( qode_restaurant_is_elementor_installed() ) {
            include_once QODE_RESTAURANT_SHORTCODES_PATH . '/reservation-form/elementor-reservation-form.php';
        }
    }

    add_action('bridge_core_load_elementor_shortcodes_from_plugins', 'qode_restaurant_include_elementor_reservation_form_shortcode');
}