<?php
/*
Plugin Name: Qode LMS
Description: Plugin that adds post types for LMS extension
Author: Qode Themes
Version: 3.0.4
*/

require_once 'load.php';

add_action( 'after_setup_theme', array( QodeLMS\CPT\PostTypesRegister::getInstance(), 'register' ) );

if ( ! function_exists( 'qode_lms_activation' ) ) {
	/**
	 * Triggers when plugin is activated. It calls flush_rewrite_rules
	 * and defines qode_lms_on_activate action
	 */
	function qode_lms_activation() {
		do_action( 'qode_lms_on_activate' );
		
		QodeLMS\CPT\PostTypesRegister::getInstance()->register();
		flush_rewrite_rules();
	}
	
	register_activation_hook( __FILE__, 'qode_lms_activation' );
}

if ( ! function_exists( 'qode_lms_text_domain' ) ) {
	/**
	 * Loads plugin text domain so it can be used in translation
	 */
	function qode_lms_text_domain() {
		load_plugin_textdomain( 'qode-lms', false, QODE_LMS_REL_PATH . '/languages' );
	}
	
	add_action( 'plugins_loaded', 'qode_lms_text_domain' );
}

if ( ! function_exists( 'qode_lms_admin_scripts' ) ) {
	/**
	 * Loads plugin scripts
	 */
	function qode_lms_admin_scripts() {
		$screen = get_current_screen();
		
		if ( isset( $screen->id ) && ! empty( $screen->id ) && $screen->id === 'course' ) {
			wp_enqueue_script( 'qode_admin_course_script', plugins_url( QODE_LMS_REL_PATH . '/assets/js/admin/course-sections-admin.js' ), array( 'jquery', 'underscore' ), false, true );
		}
	}
	
	add_action( 'admin_enqueue_scripts', 'qode_lms_admin_scripts' );
}

if ( ! function_exists( 'qode_lms_scripts' ) ) {
	/**
	 * Loads plugin scripts
	 */
	function qode_lms_scripts() {
		$array_deps_css            = array();
		$array_deps_css_responsive = array();
		$array_deps_js             = array();
		
		if ( qode_lms_theme_installed() ) {
			$array_deps_css[]            = 'bridge-stylesheet';
			$array_deps_css_responsive[] = 'bridge-responsive';
			$array_deps_js[]             = 'bridge-default';
		}

		wp_enqueue_style( 'qode_lms_style', plugins_url( QODE_LMS_REL_PATH . '/assets/css/lms.min.css' ), $array_deps_css );
		if ( function_exists('bridge_qode_is_responsive_on') && bridge_qode_is_responsive_on() ) {
			wp_enqueue_style( 'qode_lms_responsive_style', plugins_url( QODE_LMS_REL_PATH . '/assets/css/lms-responsive.min.css' ), $array_deps_css_responsive );
		}
		
		wp_enqueue_script( 'qode_lms_script', plugins_url( QODE_LMS_REL_PATH . '/assets/js/lms.min.js' ), $array_deps_js, false, true );
	}
	
	add_action( 'wp_enqueue_scripts', 'qode_lms_scripts' );
}

if ( ! function_exists( 'qode_lms_style_dynamics_deps' ) ) {
	function qode_lms_style_dynamics_deps( $deps ) {
		$style_dynamic_deps_array   = array();
		$style_dynamic_deps_array[] = 'qode_lms_style';
		
		if ( function_exists('bridge_qode_is_responsive_on') && bridge_qode_is_responsive_on() ) {
			$style_dynamic_deps_array[] = 'qode_lms_responsive_style';
		}
		
		return array_merge( $deps, $style_dynamic_deps_array );
	}
	
	add_filter( 'bridge_qode_action_style_dynamic_deps', 'qode_lms_style_dynamics_deps' );
}

if ( ! function_exists( 'qode_lms_version_class' ) ) {
	/**
	 * Adds plugins version class to body
	 *
	 * @param $classes
	 *
	 * @return array
	 */
	function qode_lms_version_class( $classes ) {
		$classes[] = 'qode-lms-' . QODE_LMS_VERSION;
		
		return $classes;
	}
	
	add_filter( 'body_class', 'qode_lms_version_class' );
}

if ( ! function_exists( 'qode_lms_theme_installed' ) ) {
	/**
	 * Checks whether theme is installed or not
	 * @return bool
	 */
	function qode_lms_theme_installed() {
		return defined( 'QODE_ROOT' );
	}
}

if ( ! function_exists( 'qode_lms_is_woocommerce_installed' ) ) {
	/**
	 * Function that checks if woocommerce is installed
	 * @return bool
	 */
	function qode_lms_is_woocommerce_installed() {
		return function_exists( 'is_woocommerce' );
	}
}

if ( ! function_exists( 'qode_lms_is_revolution_slider_installed' ) ) {
	/**
	 * Function that checks if revolution slider is installed
	 * @return bool
	 */
	function qode_lms_is_revolution_slider_installed() {
		return class_exists( 'RevSliderFront' );
	}
}

if ( ! function_exists( 'qode_lms_is_wpml_installed' ) ) {
	/**
	 * Function that checks if wpml is installed
	 * @return bool
	 */
	function qode_lms_is_wpml_installed() {
		return defined( 'ICL_SITEPRESS_VERSION' );
	}
}

if ( ! function_exists( 'qode_lms_bbpress_plugin_installed' ) ) {
	//is BBPress installed?
	function qode_lms_bbpress_plugin_installed() {
		return class_exists( 'bbPress' ) && is_plugin_active( 'bbpress/bbpress.php' );
	}
}

if(!function_exists('qode_lms_is_elementor_installed')) {
    /**
     * Checks whether theme is installed or not
     * @return bool
     */
    function qode_lms_is_elementor_installed() {
        return defined('ELEMENTOR_VERSION');
    }
}

if ( ! function_exists( 'qode_lms_theme_menu' ) ) {
	/**
	 * Function that generates admin menu for lms post types.
	 */
	function qode_lms_theme_menu() {
		if ( qode_lms_theme_installed() ) {
			global $bridge_qode_framework;
			
			$page_hook_suffix = add_menu_page(
				'Qode LMS',       // The value used to populate the browser's title bar when the menu page is active
				'Qode LMS',       // The text of the menu in the administrator's sidebar
				'administrator',  // What roles are able to access the menu
				'qode_lms_menu', // The ID used to bind submenu items to this menu
				'',               // The callback function used to render this menu
				'', // Icon For menu Item
				10                // Position
			);
			
			add_action( 'admin_print_scripts-' . $page_hook_suffix, 'qode_enqueue_admin_scripts' );
			add_action( 'admin_print_styles-' . $page_hook_suffix, 'qode_enqueue_admin_styles' );
		}
	}
	
	add_action( 'admin_menu', 'qode_lms_theme_menu' );
}
if ( ! function_exists( 'qode_lms_add_tribe_events_templates_url' ) ) {
	function qode_lms_add_tribe_events_templates_url( $file, $template  ) {

		$new_file = QODE_LMS_ABS_PATH . '/tribe-events/'.$template;

        if(file_exists( $new_file )) {
            return $new_file;
        } else {
            return $file;
        }

	}

	add_filter( 'tribe_events_template', 'qode_lms_add_tribe_events_templates_url',10, 2 );
}

if( ! function_exists('qode_lms_add_elementor_widget_categories') ) {
    function qode_lms_add_elementor_widget_categories($elements_manager) {

        $elements_manager->add_category(
            'qode-lms',
            [
                'title' => esc_html__('Qode LMS', 'qode-lms'),
                'icon' => 'fa fa-plug',
            ]
        );

    }

    add_action('elementor/elements/categories_registered', 'qode_lms_add_elementor_widget_categories');
};
