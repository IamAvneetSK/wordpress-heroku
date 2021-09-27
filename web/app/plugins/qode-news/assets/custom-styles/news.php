<?php

if(!function_exists('qode_news_styles')){
	function qode_news_styles(){
		$first_color = bridge_qode_options()->getOptionValue('first_color');
		if(!empty($first_color)) {

			$background_color_selector = '
			.qode-news-holder .qode-post-info-category a span,
			.qode-news-holder .qode-news-audio-holder .mejs-controls .mejs-time-rail .mejs-time-current,
			.qode-news-holder .qode-self-hosted-video-holder .mejs-controls .mejs-time-rail .mejs-time-current,
			.qode-news-filter-loading .qode-news-filter-loading-table-cell > div,
			.qode-news-pag-loading > div,
			.qode-post-info-hot-trending .qode-news-trending
			';
				$background_color_styles = array();

				$color_selector = '
			.qode-news-holder .qode-news-filter .qode-news-active-filter,
			.qode-news-filter-loading,
			.qode-news-standard-pagination ul li.qode-news-pag-active a,
			.qode-news-pag-loading,
			.qode-news-single-news-template .qode-author-description .qode-author-description-text-holder .qode-author-name a:hover,
			.qode-news-single-news-template .qode-comment-holder .qode-comment-text #cancel-comment-reply-link,
			.qode-news-reactions .qode-news-reaction-term .reacted .qode-rt-name
			';
			$color_styles = array();


			$background_color_styles['background-color'] = $first_color;
			$color_styles['color'] = $first_color;


			echo bridge_qode_dynamic_css($background_color_selector, $background_color_styles);
			echo bridge_qode_dynamic_css($color_selector, $color_styles);
		}
	}

	add_action('bridge_qode_action_style_dynamic', 'qode_news_styles');
}