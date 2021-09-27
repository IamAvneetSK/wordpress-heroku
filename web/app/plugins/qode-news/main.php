<?php
/*
Plugin Name: Qode News
Description: Plugin that adds news shortcodes and functionalities
Author: Qode Themes
Version: 3.0.2
*/

require_once 'load.php';

if(!function_exists('qode_news_activation')) {
    /**
     * Triggers when plugin is activated. It calls flush_rewrite_rules
     * and defines qode_news_on_activate action
     */
    function qode_news_activation() {
        do_action('qode_news_on_activate');

        // QodeNews\CPT\PostTypesRegister::getInstance()->register();
        flush_rewrite_rules();
    }

    register_activation_hook(__FILE__, 'qode_news_activation');
}

if(!function_exists('qode_news_text_domain')) {
    /**
     * Loads plugin text domain so it can be used in translation
     */
    function qode_news_text_domain() {
        load_plugin_textdomain('qode-news', false, QODE_NEWS_REL_PATH.'/languages');
    }

    add_action('plugins_loaded', 'qode_news_text_domain');
}

if(!function_exists('qode_news_version_class')) {
	/**
	 * Adds plugins version class to body
	 * @param $classes
	 * @return array
	 */
	function qode_news_version_class($classes) {
		$classes[] = 'qode-news-'.QODE_NEWS_VERSION;
		
		return $classes;
	}
	
	add_filter('body_class', 'qode_news_version_class');
}


if(!function_exists('qode_news_theme_installed')) {
	/**
	 * Checks whether theme is installed or not
	 * @return bool
	 */
	function qode_news_theme_installed() {
		return defined('QODE_ROOT');
	}
}

if(!function_exists('qode_news_is_elementor_installed')) {
	/**
	 * Checks whether theme is installed or not
	 * @return bool
	 */
	function qode_news_is_elementor_installed() {
        return defined('ELEMENTOR_VERSION');
	}
}


if ( ! function_exists( 'qode_news_scripts' ) ) {
	/**
	 * Loads plugin scripts
	 */
	function qode_news_scripts() {
		$array_deps_css = array();
		$array_deps_css_responsive = array();
		$array_deps_js = array();

		if (qode_news_theme_installed()){
			$array_deps_css[] = 'bridge-stylesheet';
			$array_deps_css_responsive[] = 'bridge-responsive';
			$array_deps_js[] = 'bridge-default';
		}

		wp_enqueue_style( 'qode_news_style', plugins_url( QODE_NEWS_REL_PATH . '/assets/css/news-map.min.css' ), $array_deps_css);
		wp_enqueue_style( 'qode_news_responsive_style', plugins_url( QODE_NEWS_REL_PATH . '/assets/css/news-map-responsive.min.css' ), $array_deps_css_responsive);
		wp_enqueue_script( 'qode_news_script', plugins_url( QODE_NEWS_REL_PATH . '/assets/js/news.min.js' ), $array_deps_js, false, true );
	}

	add_action( 'bridge_qode_action_add_styles_before_style_dynamic', 'qode_news_scripts');
}

//create elementor shortcodes group
if( ! function_exists('qode_news_add_elementor_widget_categories') ) {
    function qode_news_add_elementor_widget_categories($elements_manager) {

        if( qode_news_is_elementor_installed() ){
            $elements_manager->add_category(
                'qode-news',
                [
                    'title' => esc_html__('Qode News', 'qode-news'),
                    'icon' => 'fa fa-plug',
                ]
            );
        }

    }

    add_action('elementor/elements/categories_registered', 'qode_news_add_elementor_widget_categories');
};