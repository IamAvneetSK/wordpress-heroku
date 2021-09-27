<?php

if(!function_exists('qode_news_register_layout3_widget')) {
	/**
	 * Function that register layout3 widget
	 */
	function qode_news_register_layout3_widget($widgets) {
		$widgets[] = 'qodeNewsClassWidgetLayout3';
		
		return $widgets;
	}
	
	add_filter('qode_news_filter_register_widgets', 'qode_news_register_layout3_widget');
}