<?php

if ( ! function_exists( 'qode_lms_instructor_meta_box_functions' ) ) {
	function qode_lms_instructor_meta_box_functions( $post_types ) {
		$post_types[] = 'instructor';
		
		return $post_types;
	}
	
	add_filter( 'bridge_qode_filter_meta_box_post_types_save', 'qode_lms_instructor_meta_box_functions' );
	add_filter( 'bridge_qode_filter_meta_box_post_types_remove', 'qode_lms_instructor_meta_box_functions' );
}

if ( ! function_exists( 'qode_lms_instructor_scope_meta_box_functions' ) ) {
	function qode_lms_instructor_scope_meta_box_functions( $post_types ) {
		$post_types[] = 'instructor';
		
		return $post_types;
	}

    add_filter('bridge_qode_filter_general_scope_post_types', 'qode_lms_instructor_scope_meta_box_functions');
    add_filter('bridge_qode_filter_header_scope_post_types', 'qode_lms_instructor_scope_meta_box_functions');
    add_filter('bridge_qode_filter_title_scope_post_types', 'qode_lms_instructor_scope_meta_box_functions');
    add_filter('bridge_qode_filter_sidebar_scope_post_types', 'qode_lms_instructor_scope_meta_box_functions');
}

if ( ! function_exists( 'qode_lms_instructor_enqueue_meta_box_styles' ) ) {
	function qode_lms_instructor_enqueue_meta_box_styles() {
		global $post;
		
		if ( $post->post_type == 'instructor' ) {
			wp_enqueue_style( 'qode-jquery-ui', get_template_directory_uri() . '/framework/admin/assets/css/jquery-ui/jquery-ui.css' );
		}
	}
	
	add_action( 'qode_enqueue_meta_box_styles', 'qode_lms_instructor_enqueue_meta_box_styles' );
}

if ( ! function_exists( 'qode_lms_register_instructor_cpt' ) ) {
	function qode_lms_register_instructor_cpt( $cpt_class_name ) {
		$cpt_class = array(
			'QodeLMS\CPT\Instructor\InstructorRegister'
		);
		
		$cpt_class_name = array_merge( $cpt_class_name, $cpt_class );
		
		return $cpt_class_name;
	}
	
	add_filter( 'qode_lms_filter_register_custom_post_types', 'qode_lms_register_instructor_cpt' );
}

if ( ! function_exists( 'qode_lms_get_single_instructor' ) ) {
	/**
	 * Loads holder template for doctor single
	 */
	function qode_lms_get_single_instructor() {
		$instructor_id = get_the_ID();
		
		$params = array(
			'sidebar_layout' => bridge_qode_sidebar_layout(),
			'title'          => get_post_meta( $instructor_id, 'qode_instructor_title', true ),
			'vita'           => get_post_meta( $instructor_id, 'qode_instructor_vita', true ),
			'email'          => get_post_meta( $instructor_id, 'qode_instructor_email', true ),
			'resume'         => get_post_meta( $instructor_id, 'qode_instructor_resume', true ),
			'social_icons'   => qode_lms_single_instructor_social_icons( $instructor_id ),
			'courses'        => qode_lms_single_instructor_courses( $instructor_id ),
		);
		
		qode_lms_get_cpt_single_module_template_part( 'templates/single/holder', 'instructor', '', $params );
	}
}

if ( ! function_exists( 'qode_lms_single_instructor_social_icons' ) ) {
	function qode_lms_single_instructor_social_icons( $id ) {
		$social_icons = array();
		
		for ( $i = 1; $i < 6; $i ++ ) {
			$instructor_icon_pack = get_post_meta( $id, 'qode_instructor_social_icon_pack_' . $i, true );
			if ( $instructor_icon_pack !== '' ) {
				$instructor_icon_collection = bridge_qode_icon_collections()->getIconCollection( get_post_meta( $id, 'qode_instructor_social_icon_pack_' . $i, true ) );
				$instructor_social_icon     = get_post_meta( $id, 'qode_instructor_social_icon_pack_' . $i . '_' . $instructor_icon_collection->param, true );
				$instructor_social_link     = get_post_meta( $id, 'qode_instructor_social_icon_' . $i . '_link', true );
				$instructor_social_target   = get_post_meta( $id, 'qode_instructor_social_icon_' . $i . '_target', true );
				
				if ( $instructor_social_icon !== '' ) {
					$instructor_icon_params                                       = array();
					$instructor_icon_params['icon_pack']                          = $instructor_icon_pack;
					$instructor_icon_params[ $instructor_icon_collection->param ] = $instructor_social_icon;
					$instructor_icon_params['link']                               = ! empty( $instructor_social_link ) ? $instructor_social_link : '';
					$instructor_icon_params['target']                             = ! empty( $instructor_social_target ) ? $instructor_social_target : '_self';
					
					$social_icons[] = bridge_qode_execute_shortcode( 'icons', $instructor_icon_params );
				}
			}
		}
		
		return $social_icons;
	}
}

if ( ! function_exists( 'qode_lms_single_instructor_tabs' ) ) {
	/**
	 * Add instructor tabs to single instructor pages.
	 *
	 * @param array $tabs
	 *
	 * @return array
	 */
	function qode_lms_single_instructor_tabs( $tabs = array() ) {	
		// Curriculum tab - shows instructor curriculum
		$tabs['curriculum'] = array(
			'title'    => __( 'Curriculum', 'qode-lms' ),
			'icon'     => '<i class="lnr lnr-bookmark" aria-hidden="true"></i>',
			'priority' => 20,
			'template' => 'content'
		);

		// Course tab - shows instructor courses
		$tabs['courses'] = array(
			'title'    => __( 'Courses', 'qode-lms' ),
			'icon'     => '<i class="lnr lnr-book" aria-hidden="true"></i>',
			'priority' => 10,
			'template' => 'courses'
		);
		
		return $tabs;
	}
	
	add_filter( 'qode_single_instructor_tabs', 'qode_lms_single_instructor_tabs' );
}

if ( ! function_exists( 'qode_lms_single_instructor_courses' ) ) {
	function qode_lms_single_instructor_courses( $id ) {
		
		$args          = array(
			'post_type'  => 'course',
			'meta_key'   => 'qode_course_instructor_meta',
			'orderby'    => 'meta_value_num',
			'order'      => 'ASC',
			'meta_query' => array(
				array(
					'key'     => 'qode_course_instructor_meta',
					'value'   => $id,
					'compare' => '='
				),
			),
		);
		$query         = new WP_Query( $args );
		$courses_array = array();
		if ( $query->have_posts() ):
			while ( $query->have_posts() ) : $query->the_post();
				$courses_array[] = get_the_ID();
			endwhile;
		endif;
		
		wp_reset_postdata();
		
		$course_sc_params                      = array();
		$course_sc_params['type']              = 'gallery';
		$course_sc_params['number_of_columns'] = '3';
		if(count($courses_array) > 0){
		    $course_sc_params['selected_courses']  = implode( ',', $courses_array );
        } else{
            $course_sc_params['selected_courses']  = '-1'; // if instructor has no courses make empty query
        }
		
		return $course_sc_params;
	}
}

if ( ! function_exists( 'qode_lms_get_instructor_category_list' ) ) {
	function qode_lms_get_instructor_category_list( $category = '' ) {
		$number_of_columns = 3;
		
		$params = array(
			'number_of_columns' => $number_of_columns
		);
		
		if ( ! empty( $category ) ) {
			$params['category'] = $category;
		}
		
		$html = bridge_qode_execute_shortcode( 'qode_instructor_list', $params );
		
		print $html;
	}
}