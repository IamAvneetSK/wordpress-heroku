<?php

include_once QODE_NEWS_SHORTCODES_PATH.'/layout1/functions.php';
include_once QODE_NEWS_SHORTCODES_PATH.'/layout1/layout1.php';

if(!function_exists('qode_news_include_elementor_layout1_shortcode')) {
    function qode_news_include_elementor_layout1_shortcode() {
        if( qode_news_is_elementor_installed() ) {
            include_once QODE_NEWS_SHORTCODES_PATH . '/layout1/elementor-layout1.php';
        }
    }

    add_action('bridge_core_load_elementor_shortcodes_from_plugins', 'qode_news_include_elementor_layout1_shortcode');
}