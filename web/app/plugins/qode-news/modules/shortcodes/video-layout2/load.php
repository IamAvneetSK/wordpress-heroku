<?php

include_once QODE_NEWS_SHORTCODES_PATH.'/video-layout2/functions.php';
include_once QODE_NEWS_SHORTCODES_PATH.'/video-layout2/video-layout2.php';

if(!function_exists('qode_news_include_elementor_video_layout2_shortcode')) {
    function qode_news_include_elementor_video_layout2_shortcode() {
        if( qode_news_is_elementor_installed() ) {
            include_once QODE_NEWS_SHORTCODES_PATH . '/video-layout2/elementor-video-layout2.php';
        }
    }

    add_action('bridge_core_load_elementor_shortcodes_from_plugins', 'qode_news_include_elementor_video_layout2_shortcode');
}