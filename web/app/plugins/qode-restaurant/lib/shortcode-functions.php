<?php

if(!function_exists('qode_restaurant_include_shortcodes_file')) {
	/**
	 * Loades all shortcodes by going through all folders that are placed directly in shortcodes folder
	 */
	function qode_restaurant_include_shortcodes_file() {
		if(qode_restaurant_theme_installed()) {
			foreach (glob(QODE_RESTAURANT_SHORTCODES_PATH . '/*/load.php') as $shortcode_load) {
				include_once $shortcode_load;
			}
			do_action('qode_restaurant_include_shortcode_files');
		}
	}
	
	add_action('init', 'qode_restaurant_include_shortcodes_file', 6);
}

if(!function_exists('qode_restaurant_load_shortcodes')) {
	function qode_restaurant_load_shortcodes() {
		include_once QODE_RESTAURANT_ABS_PATH.'/lib/shortcode-loader.php';

		QodeRestaurant\Lib\ShortcodeLoader::getInstance()->load();
	}
	
	add_action('init', 'qode_restaurant_load_shortcodes', 7);
}