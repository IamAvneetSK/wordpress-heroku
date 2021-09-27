<?php

if(!function_exists('qode_music_include_shortcodes_file')) {
	/**
	 * Loades all shortcodes by going through all folders that are placed directly in shortcodes folder
	 */
	function qode_music_include_shortcodes_file() {
		foreach(glob(QODE_MUSIC_SHORTCODES_PATH.'/*/load.php') as $shortcode_load) {
			include_once $shortcode_load;
		}
		do_action('qode_music_action_include_shortcodes_file');
	}
	
	add_action('init', 'qode_music_include_shortcodes_file', 6);
}

if(!function_exists('qode_music_load_shortcodes')) {
	function qode_music_load_shortcodes() {
		include_once QODE_MUSIC_ABS_PATH.'/lib/shortcode-loader.php';
		
		QodeMusic\Lib\ShortcodeLoader::getInstance()->load();
	}
	
	add_action('init', 'qode_music_load_shortcodes', 7);
}