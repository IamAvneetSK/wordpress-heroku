<?php

if(!function_exists('qode_news_register_blog_categories_reactions_widget')) {
	/**
	 * Function that register blog categories and reactions widget
	 */
	function qode_news_register_blog_categories_reactions_widget($widgets) {
		$widgets[] = 'qodeNewsClassBlogCategoriesReactions';
		
		return $widgets;
	}
	
	add_filter('qode_news_filter_register_widgets', 'qode_news_register_blog_categories_reactions_widget');
}