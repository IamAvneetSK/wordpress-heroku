<?php

if ( ! function_exists( 'qode_lms_include_custom_post_types_files' ) ) {
	/**
	 * Loads all custom post types by going through all folders that are placed directly in post types folder
	 */
	function qode_lms_include_custom_post_types_files() {
		if ( qode_lms_theme_installed() ) {
			foreach ( glob( QODE_LMS_CPT_PATH . '/*/load.php' ) as $shortcode_load ) {
				include_once $shortcode_load;
			}
		}
	}
	
	add_action( 'after_setup_theme', 'qode_lms_include_custom_post_types_files', 1 );
}

if ( ! function_exists( 'qode_lms_include_custom_post_types_meta_boxes' ) ) {
	/**
	 * Loads all meta boxes functions for custom post types by going through all folders that are placed directly in post types folder
	 */
	function qode_lms_include_custom_post_types_meta_boxes() {
		if ( qode_lms_theme_installed() ) {
			foreach ( glob( QODE_LMS_CPT_PATH . '/*/admin/meta-boxes/*.php' ) as $meta_boxes_map ) {
				include_once $meta_boxes_map;
			}
		}
	}
	
	add_action( 'bridge_qode_action_before_meta_boxes_map', 'qode_lms_include_custom_post_types_meta_boxes' );
}

if ( ! function_exists( 'qode_lms_include_custom_post_types_global_options' ) ) {
	/**
	 * Loads all global otpions functions for custom post types by going through all folders that are placed directly in post types folder
	 */
	function qode_lms_include_custom_post_types_global_options() {
		if ( qode_lms_theme_installed() ) {
			foreach ( glob( QODE_LMS_CPT_PATH . '/*/admin/options/*.php' ) as $global_options ) {
				include_once $global_options;
			}
		}
	}
	
	add_action( 'bridge_qode_action_before_options_map', 'qode_lms_include_custom_post_types_global_options', 1 );
}

if ( ! function_exists( 'qode_lms_include_taxonomy_custom_fields' ) ) {
	/**
	 * Loads all custom fields for taxonomy by going through all folders that are placed directly in post types folder
	 */
	function qode_lms_include_taxonomy_custom_fields() {
		if ( qode_lms_theme_installed() ) {
			foreach ( glob( QODE_LMS_CPT_PATH . '/*/admin/taxonomy-meta-fields/*.php' ) as $global_options ) {
				include_once $global_options;
			}
		}
	}
	
	add_action( 'after_setup_theme', 'qode_lms_include_taxonomy_custom_fields', 1 );
}

if ( ! function_exists( 'qode_lms_enqueue_scripts_for_quiz' ) ) {
	/**
	 * Function that includes all necessary 3rd party scripts for this post type
	 */
	function qode_lms_enqueue_scripts_for_quiz() {
		wp_enqueue_script( 'simple-countdown', QODE_LMS_CPT_URL_PATH . '/quiz/assets/js/plugins/jquery.vtimer.min.js', array( 'jquery' ), false, true );
	}
	
	add_action( 'bridge_qode_action_enqueue_third_party_scripts', 'qode_lms_enqueue_scripts_for_quiz' );
}



if(!function_exists('qode_lms_events_scope_meta_box_functions')) {
    function qode_lms_events_scope_meta_box_functions($post_types) {

        $post_types[] = 'tribe_events';

        return $post_types;
    }
    add_filter('bridge_qode_filter_general_scope_post_types', 'qode_lms_events_scope_meta_box_functions');
    add_filter('bridge_qode_filter_header_scope_post_types', 'qode_lms_events_scope_meta_box_functions');
    add_filter('bridge_qode_filter_title_scope_post_types', 'qode_lms_events_scope_meta_box_functions');
    add_filter('bridge_qode_filter_sidebar_scope_post_types', 'qode_lms_events_scope_meta_box_functions');
}

if(!function_exists('qode_lms_events_meta_box_functions')) {
	function qode_lms_events_meta_box_functions($post_types) {
		$post_types[] = 'tribe_events';

		return $post_types;
	}

	add_filter('bridge_qode_filter_meta_box_post_types_save', 'qode_lms_events_meta_box_functions');
	add_filter('bridge_qode_filter_meta_box_post_types_remove', 'qode_lms_events_meta_box_functions');
}