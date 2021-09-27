<?php

if(!function_exists('qode_music_include_events_shortcodes')) {
	function qode_music_include_events_shortcodes() {
		include_once QODE_MUSIC_CPT_PATH.'/events/shortcodes/events-list.php';
	}
	
	add_action('qode_music_action_include_shortcodes_file', 'qode_music_include_events_shortcodes');
}

if(!function_exists('qode_music_add_events_shortcodes')) {
	function qode_music_add_events_shortcodes($shortcodes_class_name) {
		$shortcodes = array(
			'QodeMusic\CPT\Events\Shortcodes\EventsList'
		);

		$shortcodes_class_name = array_merge($shortcodes_class_name, $shortcodes);

		return $shortcodes_class_name;
	}

	add_filter('qode_music_add_vc_shortcode', 'qode_music_add_events_shortcodes');
}

if(!function_exists('qode_music_include_elementor_events_list_shortcode')) {
	function qode_music_include_elementor_events_list_shortcode() {
		include_once QODE_MUSIC_CPT_PATH.'/events/shortcodes/elementor-events-list.php';
	}
	
	add_action('bridge_core_load_elementor_shortcodes_from_plugins', 'qode_music_include_elementor_events_list_shortcode');
}