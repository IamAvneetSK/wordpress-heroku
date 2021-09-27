<?php

if ( ! function_exists( 'qode_lms_register_course_categories_widget' ) ) {
	/**
	 * Function that register course list widget
	 */
	function qode_lms_register_course_categories_widget( $widgets ) {
		register_widget( 'QodeCourseCategoriesWidget' );
	}
	
	add_filter( 'widgets_init', 'qode_lms_register_course_categories_widget' );
}