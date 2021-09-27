<?php
/*
Plugin Name: Qode Restaurant
Description: Plugin that adds features to our theme
Author: Qode Themes
Version: 3.0.1
*/

include_once 'load.php';

add_action('after_setup_theme', array(QodeRestaurant\CPT\PostTypesRegister::getInstance(), 'register'));

if(!function_exists('qode_restaurant_load_assets')) {
	function qode_restaurant_load_assets() {
		wp_enqueue_style('qode_restaurant_script', plugins_url('/assets/css/qode-restaurant.min.css', __FILE__), array(), '');
		wp_enqueue_style('qode_restaurant_responsive_script', plugins_url('/assets/css/qode-restaurant-responsive.min.css', __FILE__), array(), '');
		wp_enqueue_script('jquery-ui-datepicker');
		$restaurant_dependency = array('jquery');
		if(qode_restaurant_theme_installed()){
			$restaurant_dependency[] = 'bridge-default';
			if(bridge_qode_is_ajax_enabled()) {
				$restaurant_dependency[] = 'bridge-ajax';
			}
		}

		wp_enqueue_script('qode_restaurant_script', plugins_url('/assets/js/qode-restaurant.min.js', __FILE__), $restaurant_dependency, '', true);
	}

	add_action('wp_enqueue_scripts', 'qode_restaurant_load_assets');
}