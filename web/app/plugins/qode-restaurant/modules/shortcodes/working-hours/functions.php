<?php

if(!function_exists('qode_restaurant_add_workinghours_shortcodes')) {
	function qode_restaurant_add_workinghours_shortcodes($shortcodes_class_name) {
		$shortcodes = array(
			'QodeRestaurant\Shortcodes\WorkingHours\WorkingHours'
		);
		
		$shortcodes_class_name = array_merge($shortcodes_class_name, $shortcodes);
		
		return $shortcodes_class_name;
	}
	
	add_filter('qode_restaurant_add_vc_shortcode', 'qode_restaurant_add_workinghours_shortcodes');
}
