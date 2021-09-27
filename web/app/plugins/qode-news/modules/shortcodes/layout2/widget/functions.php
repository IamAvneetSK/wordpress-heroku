<?php

if(!function_exists('qode_news_register_layout2_widget')) {
	/**
	 * Function that register layout2 widget
	 */
	function qode_news_register_layout2_widget($widgets) {
		$widgets[] = 'qodeNewsClassWidgetLayout2';
		
		return $widgets;
	}
	
	add_filter('qode_news_filter_register_widgets', 'qode_news_register_layout2_widget');
}