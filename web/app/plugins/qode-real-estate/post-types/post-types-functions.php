<?php

if(!function_exists('qodef_re_include_custom_post_types_files')) {
	/**
	 * Loads all custom post types by going through all folders that are placed directly in post types folder
	 */
	function qodef_re_include_custom_post_types_files() {
		if(qodef_re_theme_installed()) {
			foreach (glob(QODE_RE_CPT_PATH . '/*/load.php') as $shortcode_load) {
				include_once $shortcode_load;
			}
		}
	}
	
	add_action('after_setup_theme', 'qodef_re_include_custom_post_types_files', 1);
}

if(!function_exists('qodef_re_include_custom_post_types_meta_boxes')) {
	/**
	 * Loads all meta boxes functions for custom post types by going through all folders that are placed directly in post types folder
	 */
	function qodef_re_include_custom_post_types_meta_boxes() {
		if(qodef_re_theme_installed()) {
			foreach(glob(QODE_RE_CPT_PATH . '/*/admin/meta-boxes/*.php') as $meta_boxes_map) {
				include_once $meta_boxes_map;
			}
		}
	}
	
	add_action('bridge_qode_action_before_meta_boxes_map', 'qodef_re_include_custom_post_types_meta_boxes');
}

if(!function_exists('qodef_re_include_custom_post_types_global_options')) {
	/**
	 * Loads all global otpions functions for custom post types by going through all folders that are placed directly in post types folder
	 */
	function qodef_re_include_custom_post_types_global_options() {
		if(qodef_re_theme_installed()) {
			foreach(glob(QODE_RE_CPT_PATH . '/*/admin/options/*.php') as $global_options) {
				include_once $global_options;
			}
		}
	}
	
	add_action('bridge_qode_action_before_meta_boxes_map', 'qodef_re_include_custom_post_types_global_options', 1);
}