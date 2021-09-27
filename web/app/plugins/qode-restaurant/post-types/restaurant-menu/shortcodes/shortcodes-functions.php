<?php

if(!function_exists('qode_restaurant_include_shortcodes')) {
	function qode_restaurant_include_shortcodes() {
		include_once QODE_RESTAURANT_CPT_PATH.'/restaurant-menu/shortcodes/restaurant-menu-list.php';
	}
	
	add_action('qode_restaurant_include_shortcode_files', 'qode_restaurant_include_shortcodes');
}

if(!function_exists('qode_restaurant_add_shortcodes')) {
	function qode_restaurant_add_shortcodes($shortcodes_class_name) {
		$shortcodes = array(
			'QodeRestaurant\CPT\RestaurantMenu\Shortcodes\RestaurantMenuList\RestaurantMenuList'
		);

		$shortcodes_class_name = array_merge($shortcodes_class_name, $shortcodes);

		return $shortcodes_class_name;
	}

	add_filter('qode_restaurant_add_vc_shortcode', 'qode_restaurant_add_shortcodes');
}

if(!function_exists('qode_restaurant_include_elementor_restaurant_menu_shortcode')) {
    function qode_restaurant_include_elementor_restaurant_menu_shortcode() {
        if( qode_restaurant_is_elementor_installed() ) {
            include_once QODE_RESTAURANT_CPT_PATH . '/restaurant-menu/shortcodes/elementor-restaurant-menu-list.php';
        }
    }

    add_action('bridge_core_load_elementor_shortcodes_from_plugins', 'qode_restaurant_include_elementor_restaurant_menu_shortcode');
}