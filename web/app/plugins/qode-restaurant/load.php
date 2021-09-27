<?php

include_once 'const.php';
include_once 'helpers.php';

//load lib
require_once 'lib/shortcode-interface.php';
require_once 'lib/shortcode-loader.php';
require_once 'lib/shortcode-functions.php';

require_once 'modules/widgets/load.php';

//load post-post-types
require_once 'lib/post-type-interface.php';
require_once 'post-types/post-types-functions.php';
require_once 'post-types/post-types-register.php'; //this has to be loaded last

//load admin
if(!function_exists('qode_restaurant_load_admin')) {
    function qode_restaurant_load_admin() {
        require_once 'admin/options/restaurant/map.php';
    }
    add_action('bridge_qode_action_before_options_map', 'qode_restaurant_load_admin');
}

//load custom styles
if(!function_exists('qode_restaurant_load_custom_styles')) {
    function qode_restaurant_load_custom_styles() {
        require_once 'assets/custom-styles/restaurant.php';
    }
    add_action('after_setup_theme','qode_restaurant_load_custom_styles');
}