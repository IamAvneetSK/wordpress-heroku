<?php
/*
Plugin Name: Qode Real Estate
Description: Plugin that adds post types for Real Estate extension
Author: Qode Themes
Version: 1.1
*/

require_once 'load.php';

add_action( 'after_setup_theme', array( QodefRE\CPT\PostTypesRegister::getInstance(), 'register' ) );

if ( ! function_exists( 'qodef_re_activation' ) ) {
	/**
	 * Triggers when plugin is activated. It calls flush_rewrite_rules
	 * and defines bridge_qode_re_on_activate action
	 */
	function qodef_re_activation() {
		do_action( 'qodef_re_on_activate' );
		
		QodefRE\CPT\PostTypesRegister::getInstance()->register();
		flush_rewrite_rules();
	}
	
	register_activation_hook( __FILE__, 'qodef_re_activation' );
}

if ( ! function_exists( 'qodef_re_text_domain' ) ) {
	/**
	 * Loads plugin text domain so it can be used in translation
	 */
	function qodef_re_text_domain() {
		load_plugin_textdomain( 'qode-real-estate', false, QODE_RE_REL_PATH . '/languages' );
	}
	
	add_action( 'plugins_loaded', 'qodef_re_text_domain' );
}

if ( ! function_exists( 'qodef_re_scripts' ) ) {
	/**
	 * Loads plugin scripts
	 */
	function qodef_re_scripts() {
		$array_deps_css            = array();
		$array_deps_css_responsive = array();
		$array_deps_js             = array();
		
		if ( qodef_re_theme_installed() ) {
			$array_deps_css[]            = 'bridge-stylesheet';
			$array_deps_css_responsive[] = 'bridge-responsive';
			$array_deps_js[]             = 'bridge-default';
			$array_deps_js[]             = 'google_map_api';
		}
		
		wp_enqueue_style( 'qodef-re-style', plugins_url( QODE_RE_REL_PATH . '/assets/css/real-estate.min.css' ), $array_deps_css );

		if ( function_exists( 'bridge_qode_is_responsive_on' ) && bridge_qode_is_responsive_on() ) {
			wp_enqueue_style( 'qodef-re-responsive-style', plugins_url( QODE_RE_REL_PATH . '/assets/css/real-estate-responsive.min.css' ), $array_deps_css_responsive );
		}
		
		wp_enqueue_script( 'jquery-ui-slider' );
		if ( wp_is_mobile() ) {
			wp_enqueue_script( 'jquery-touch-punch' );
		}
		
		wp_enqueue_script( 'qodef-re-script', plugins_url( QODE_RE_REL_PATH . '/assets/js/real-estate.min.js' ), $array_deps_js, false, true );

		// If theme is installed and not WooCommerce include theme select2 script as well as default theme styles for select2
        if( qodef_re_theme_installed() && ! qodef_re_is_woocommerce_installed() ) {
            wp_enqueue_style('select2', QODE_FRAMEWORK_ADMIN_ASSETS_ROOT . '/css/select2.min.css', $array_deps_css);
            wp_enqueue_style("bridge-woocommerce", QODE_ROOT . "/css/woocommerce.min.css");
            wp_enqueue_script( 'select2', QODE_FRAMEWORK_ADMIN_ASSETS_ROOT . '/js/select2.min.js', $array_deps_js, false, true );
        }
	}
	
	add_action( 'wp_enqueue_scripts', 'qodef_re_scripts' );
}

if ( ! function_exists( 'qodef_re_version_class' ) ) {
	/**
	 * Adds plugins version class to body
	 *
	 * @param $classes
	 *
	 * @return array
	 */
	function qodef_re_version_class( $classes ) {
		$classes[] = 'qodef-re-' . QODE_RE_VERSION;
		
		return $classes;
	}
	
	add_filter( 'body_class', 'qodef_re_version_class' );
}

if ( ! function_exists( 'qodef_re_add_maps_extensions' ) ) {
	function qodef_re_add_maps_extensions( $extensions ) {
		$items      = array(
			'geometry',
			'places'
		);

		$extensions = array_unique( array_merge( $extensions, $items ) );
		
		return $extensions;
	}
	
	add_filter( 'bridge_qode_filter_google_maps_extensions_array', 'qodef_re_add_maps_extensions', 10, 1 );
}

if ( ! function_exists( 'qodef_re_enable_maps_in_admin' ) ) {
	/**
	 * Loads plugin text domain so it can be used in translation
	 */
	function qodef_re_enable_maps_in_admin() {
		return true;
	}
	
	add_action( 'bridge_qode_filter_google_maps_in_backend', 'qodef_re_enable_maps_in_admin' );
}

if ( ! function_exists( 'qodef_re_theme_installed' ) ) {
	/**
	 * Checks whether theme is installed or not
	 * @return bool
	 */
	function qodef_re_theme_installed() {
		return defined( 'QODE_ROOT' );
	}
}

if ( ! function_exists( 'qodef_re_is_woocommerce_installed' ) ) {
	/**
	 * Function that checks if woocommerce is installed
	 * @return bool
	 */
	function qodef_re_is_woocommerce_installed() {
		return function_exists( 'is_woocommerce' );
	}
}

if ( ! function_exists( 'qodef_re_is_revolution_slider_installed' ) ) {
	function qodef_re_is_revolution_slider_installed() {
		return class_exists( 'RevSliderFront' );
	}
}

if ( ! function_exists( 'qodef_re_qodef_woocommerce_integration_installed' ) ) {
	//is Qode Woocommerce Integration?
	function qodef_re_qodef_woocommerce_integration_installed() {
		return defined( 'QODE_WOOCOMMERCE_CHECKOUT_INTEGRATION' );
	}
}

if ( ! function_exists( 'qodef_re_qode_membership_installed' ) ) {
	/**
	 * Function that checks if Qode Membership plugin installed
	 * @return bool
	 */
	function qodef_re_qode_membership_installed() {
		return defined( 'QODE_MEMBERSHIP_VERSION' );
	}
}

if ( ! function_exists( 'qodef_re_qodef_core_plugin_installed' ) ) {
	/**
	 * Function that checks if Qode Membership plugin installed
	 * @return bool
	 */
	function qodef_re_qodef_core_plugin_installed() {
		return defined( 'BRIDGE_CORE_VERSION' );
	}
}

if( ! function_exists('qode_re_add_elementor_widget_categories') ) {
	function qode_re_add_elementor_widget_categories($elements_manager) {

		$elements_manager->add_category(
			'qode-real-estate',
			[
				'title' => esc_html__('Qode Real Estate', 'qode-real-estate'),
				'icon' => 'fa fa-plug',
			]
		);

	}

	add_action('elementor/elements/categories_registered', 'qode_re_add_elementor_widget_categories');
};
