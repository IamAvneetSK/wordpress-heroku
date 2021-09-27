<?php

if(!function_exists('qode_news_register_video_layout3_widget')) {
	/**
	 * Function that register video layout 2 widget
	 */
	function qode_news_register_video_layout3_widget($widgets) {
		$widgets[] = 'qodeNewsClassWidgetVideoLayout2';
		
		return $widgets;
	}
	
	 add_filter('qode_news_filter_register_widgets', 'qode_news_register_video_layout3_widget');
}