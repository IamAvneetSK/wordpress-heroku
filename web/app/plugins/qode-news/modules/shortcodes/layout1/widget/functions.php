<?php

if(!function_exists('qode_news_register_layout1_widget')) {
	/**
	 * Function that register layout1 widget
	 */
	function qode_news_register_layout1_widget($widgets) {
		$widgets[] = 'qodeNewsClassWidgetLayout1';
		
		return $widgets;
	}
	
	add_filter('qode_news_filter_register_widgets', 'qode_news_register_layout1_widget');
}