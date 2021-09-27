<?php
//Register meta boxes
if ( ! function_exists( 'qode_lms_lesson_meta_box_functions' ) ) {
	function qode_lms_lesson_meta_box_functions( $post_types ) {
		$post_types[] = 'lesson';
		
		return $post_types;
	}
	
	add_filter( 'bridge_qode_filter_meta_box_post_types_save', 'qode_lms_lesson_meta_box_functions' );
	add_filter( 'bridge_qode_filter_meta_box_post_types_remove', 'qode_lms_lesson_meta_box_functions' );
}

//Register meta boxes scope
if ( ! function_exists( 'qode_lms_lesson_scope_meta_box_functions' ) ) {
	function qode_lms_lesson_scope_meta_box_functions( $post_types ) {
		$post_types[] = 'lesson';
		
		return $post_types;
	}
	
	add_filter( 'qode_set_scope_for_meta_boxes', 'qode_lms_lesson_scope_meta_box_functions' );
}

//Register lesson post type
if ( ! function_exists( 'qode_lms_register_lesson_cpt' ) ) {
	function qode_lms_register_lesson_cpt( $cpt_class_name ) {
		$cpt_class = array(
			'QodeLMS\CPT\Lesson\LessonRegister'
		);
		
		$cpt_class_name = array_merge( $cpt_class_name, $cpt_class );
		
		return $cpt_class_name;
	}
	
	add_filter( 'qode_lms_filter_register_custom_post_types', 'qode_lms_register_lesson_cpt' );
}

//Lesson single functions
if ( ! function_exists( 'qode_lms_get_single_lesson' ) ) {
	function qode_lms_get_single_lesson() {
		$params                = array();
		$params['item_id']     = get_the_ID();
		$params['lesson_type'] = get_post_meta( get_the_ID(), 'qode_lesson_type_meta', true );
		
		qode_lms_get_cpt_single_module_template_part( 'templates/single/holder', 'lesson', '', $params );
	}
}