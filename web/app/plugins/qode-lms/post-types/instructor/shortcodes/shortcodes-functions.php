<?php

if ( ! function_exists( 'qode_lms_include_instructor_shortcodes' ) ) {
	function qode_lms_include_instructor_shortcodes() {
		include_once QODE_LMS_CPT_PATH . '/instructor/shortcodes/instructor-list.php';
		include_once QODE_LMS_CPT_PATH . '/instructor/shortcodes/instructor.php';
		include_once QODE_LMS_CPT_PATH . '/instructor/shortcodes/instructor-slider.php';
	}
	
	add_action( 'qode_lms_action_include_shortcodes_file', 'qode_lms_include_instructor_shortcodes' );
}

if ( ! function_exists( 'qode_lms_add_instructor_shortcodes' ) ) {
	function qode_lms_add_instructor_shortcodes( $shortcodes_class_name ) {
		$shortcodes = array(
			'QodeLMS\CPT\Shortcodes\Instructor\Instructor',
			'QodeLMS\CPT\Shortcodes\Instructor\InstructorList',
			'QodeLMS\CPT\Shortcodes\Instructor\InstructorSlider'
		);
		
		$shortcodes_class_name = array_merge( $shortcodes_class_name, $shortcodes );
		
		return $shortcodes_class_name;
	}
	
	add_filter( 'qode_lms_filter_add_vc_shortcode', 'qode_lms_add_instructor_shortcodes' );
}

if ( ! function_exists( 'qode_lms_set_instructor_list_icon_class_name_for_vc_shortcodes' ) ) {
	/**
	 * Function that set custom icon class name for instructor shortcodes to set our icon for Visual Composer shortcodes panel
	 */
	function qode_lms_set_instructor_list_icon_class_name_for_vc_shortcodes( $shortcodes_icon_class_array ) {
		$shortcodes_icon_class_array[] = '.icon-wpb-instructor-list';
		$shortcodes_icon_class_array[] = '.icon-wpb-instructor';
		$shortcodes_icon_class_array[] = '.icon-wpb-instructor-slider';
		
		return $shortcodes_icon_class_array;
	}
	
	add_filter( 'qode_lms_filter_add_vc_shortcodes_custom_icon_class', 'qode_lms_set_instructor_list_icon_class_name_for_vc_shortcodes' );
}

if(!function_exists('qode_lms_include_elementor_instructor_shortcodes')) {
    function qode_lms_include_elementor_instructor_shortcodes() {
        foreach (glob(QODE_LMS_CPT_PATH . '/instructor/shortcodes/elementor-*.php') as $shortcode_load) {
            include_once $shortcode_load;
        }
    }

    add_action('bridge_core_load_elementor_shortcodes_from_plugins', 'qode_lms_include_elementor_instructor_shortcodes');
}