<?php

if(!function_exists('qode_news_add_layout3_shortcodes')) {
	function qode_news_add_layout3_shortcodes($shortcodes_class_name) {
		$shortcodes = array(
			'qodeNews\CPT\Shortcodes\Layout3\Layout3'
		);
		
		$shortcodes_class_name = array_merge($shortcodes_class_name, $shortcodes);
		
		return $shortcodes_class_name;
	}
	
	add_filter('qode_news_filter_add_vc_shortcode', 'qode_news_add_layout3_shortcodes');
}
