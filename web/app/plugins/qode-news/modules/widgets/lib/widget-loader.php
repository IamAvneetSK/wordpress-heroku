<?php

if ( ! function_exists( 'qode_news_load_widgets' ) ) {
	/**
	 * Loades all widgets by going through all folders that are placed directly in widgets folder
	 * and loads load.php file in each. Hooks to qode_after_options_map action
	 */
	function qode_news_load_widgets() {
		
		foreach ( glob( QODE_NEWS_SHORTCODES_PATH . '/*/widget/load.php' ) as $widget_load ) {
			include_once $widget_load;
		}

		foreach ( glob( QODE_NEWS_WIDGETS_PATH . '/*/load.php' ) as $widget_load ) {
			include_once $widget_load;
		}
	}
	
	add_action( 'bridge_qode_action_before_options_map', 'qode_news_load_widgets', 25);
}

if (!function_exists('qode_news_register_widgets')) {
	function qode_news_register_widgets() {
		$widgets = apply_filters('qode_news_filter_register_widgets', $widgets = array());

		foreach ($widgets as $widget) {
			register_widget($widget);
		}
	}
	
	add_action('widgets_init', 'qode_news_register_widgets');
}