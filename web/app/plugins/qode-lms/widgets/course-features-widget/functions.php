<?php

if ( ! function_exists( 'qode_lms_register_course_features_widget' ) ) {
	/**
	 * Function that register course features widget
	 */
	function qode_lms_register_course_features_widget( $widgets ) {
		register_widget( 'QodeCourseFeaturesWidget' );
	}
	
	add_filter( 'widgets_init', 'qode_lms_register_course_features_widget' );
}