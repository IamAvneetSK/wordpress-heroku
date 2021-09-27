<?php

include_once QODE_NEWS_SHORTCODES_PATH.'/post-slider1/functions.php';
include_once QODE_NEWS_SHORTCODES_PATH.'/post-slider1/post-slider1.php';

if(!function_exists('qode_news_include_elementor_post_slider1_shortcode')) {
    function qode_news_include_elementor_post_slider1_shortcode() {
        if( qode_news_is_elementor_installed() ) {
            include_once QODE_NEWS_SHORTCODES_PATH . '/post-slider1/elementor-post-slider1.php';
        }
    }

    add_action('bridge_core_load_elementor_shortcodes_from_plugins', 'qode_news_include_elementor_post_slider1_shortcode');
}