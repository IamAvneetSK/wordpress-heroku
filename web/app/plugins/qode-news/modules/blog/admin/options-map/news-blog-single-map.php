<?php

if ( ! function_exists( 'qode_news_add_single_blog_template' ) ) {
	function qode_news_add_single_blog_template( $single_blog_templates ) {
		$single_blog_templates['news-template'] = 'News Template';

		return $single_blog_templates;
	}

	add_filter( 'bridge_qode_filter_single_blog_templates', 'qode_news_add_single_blog_template' );
}