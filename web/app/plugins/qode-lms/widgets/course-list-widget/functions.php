<?php

if ( ! function_exists( 'qode_lms_register_course_list_widget' ) ) {
	/**
	 * Function that register course list widget
	 */
	function qode_lms_register_course_list_widget( $widgets ) {
		register_widget( 'QodeCourseListWidget' );
	}
	
	add_filter( 'widgets_init', 'qode_lms_register_course_list_widget' );
}