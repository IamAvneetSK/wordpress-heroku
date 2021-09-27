<?php

if ( ! function_exists( 'qode_lms_include_portfolio_shortcodes' ) ) {
	function qode_lms_include_portfolio_shortcodes() {
		include_once QODE_LMS_CPT_PATH . '/course/shortcodes/course-features.php';
		include_once QODE_LMS_CPT_PATH . '/course/shortcodes/course-list.php';
		include_once QODE_LMS_CPT_PATH . '/course/shortcodes/course-search.php';
		include_once QODE_LMS_CPT_PATH . '/course/shortcodes/course-slider.php';
		include_once QODE_LMS_CPT_PATH . '/course/shortcodes/course-table.php';
	}
	
	add_action( 'qode_lms_action_include_shortcodes_file', 'qode_lms_include_portfolio_shortcodes' );
}

if ( ! function_exists( 'qode_lms_add_portfolio_shortcodes' ) ) {
	function qode_lms_add_portfolio_shortcodes( $shortcodes_class_name ) {
		$shortcodes = array(
			'QodeLMS\CPT\Shortcodes\Course\CourseFeatures',
			'QodeLMS\CPT\Shortcodes\Course\CourseList',
			'QodeLMS\CPT\Shortcodes\Course\CourseSearch',
			'QodeLMS\CPT\Shortcodes\Course\CourseSlider',
			'QodeLMS\CPT\Shortcodes\Course\CourseTable'
		);
		
		$shortcodes_class_name = array_merge( $shortcodes_class_name, $shortcodes );
		
		return $shortcodes_class_name;
	}
	
	add_filter( 'qode_lms_filter_add_vc_shortcode', 'qode_lms_add_portfolio_shortcodes' );
}

if ( ! function_exists( 'qode_lms_set_course_icon_class_name_for_vc_shortcodes' ) ) {
	/**
	 * Function that set custom icon class name for portfolio list shortcodes to set our icon for Visual Composer shortcodes panel
	 */
	function qode_lms_set_course_icon_class_name_for_vc_shortcodes( $shortcodes_icon_class_array ) {
		$shortcodes_icon_class_array[] = '.icon-wpb-course-features';
		$shortcodes_icon_class_array[] = '.icon-wpb-course-list';
		$shortcodes_icon_class_array[] = '.icon-wpb-course-search';
		$shortcodes_icon_class_array[] = '.icon-wpb-course-slider';
		$shortcodes_icon_class_array[] = '.icon-wpb-course-table';
		
		return $shortcodes_icon_class_array;
	}
	
	add_filter( 'qode_lms_filter_add_vc_shortcodes_custom_icon_class', 'qode_lms_set_course_icon_class_name_for_vc_shortcodes' );
}

if(!function_exists('qode_lms_include_elementor_course_shortcodes')) {
    function qode_lms_include_elementor_course_shortcodes() {
        foreach (glob(QODE_LMS_CPT_PATH . '/course/shortcodes/elementor-*.php') as $shortcode_load) {
            include_once $shortcode_load;
        }
    }

    add_action('bridge_core_load_elementor_shortcodes_from_plugins', 'qode_lms_include_elementor_course_shortcodes');
}