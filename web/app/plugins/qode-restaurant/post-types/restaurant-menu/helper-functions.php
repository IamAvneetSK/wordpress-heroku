<?php

if(!function_exists('qode_restaurant_album_meta_box_functions')) {
	function qode_restaurant_album_meta_box_functions($post_types) {
		$post_types[] = 'qode-restaurant-menu';

		return $post_types;
	}

	add_filter('bridge_qode_filter_meta_box_post_types_save', 'qode_restaurant_album_meta_box_functions');
	add_filter('bridge_qode_filter_meta_box_post_types_remove', 'qode_restaurant_album_meta_box_functions');
}

if(!function_exists('qode_restaurant_register_restaurant_menu_cpt')) {
	function qode_restaurant_register_restaurant_menu_cpt($cpt_class_name) {
		$cpt_class = array(
			'QodeRestaurant\CPT\RestaurantMenu\RestaurantMenuRegister'
		);
		
		$cpt_class_name = array_merge($cpt_class_name, $cpt_class);
		
		return $cpt_class_name;
	}
	
	add_filter('qode_restaurant_filter_register_custom_post_types', 'qode_restaurant_register_restaurant_menu_cpt');
}


