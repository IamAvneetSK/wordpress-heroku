<?php

if ( ! function_exists( 'qode_lms_map_course_meta' ) ) {
	function qode_lms_map_course_meta() {

		//Get list of courses;
		$qode_courses = array();
		$courses      = get_posts(
			array(
				'numberposts' => - 1,
				'post_type'   => 'course',
				'post_status' => 'publish'
			)
		);
		foreach ( $courses as $course ) {
			$qode_courses[ $course->ID ] = $course->post_title;
		}
		
		//Get list of instructors;
		$qode_instructors = array();
		$instructors      = get_posts(
			array(
				'numberposts' => - 1,
				'post_type'   => 'instructor',
				'post_status' => 'publish'
			)
		);
		foreach ( $instructors as $instructor ) {
			$qode_instructors[ $instructor->ID ] = $instructor->post_title;
		}
		
		if ( qode_lms_bbpress_plugin_installed() ) {
			//Get list of forums;
			$qode_forums = array();
			$forums      = get_posts(
				array(
					'numberposts'         => - 1,
					'post_type'           => 'forum',
					'post_status'         => 'publish',
					'posts_per_page'      => get_option( '_bbp_forums_per_page', 50 ),
					'ignore_sticky_posts' => true,
					'orderby'             => 'menu_order title',
					'order'               => 'ASC'
				)
			);
			foreach ( $forums as $forum ) {
				$qode_forums[ $forum->ID ] = $forum->post_title;
			}
		}
		
		$meta_box = bridge_qode_create_meta_box(
			array(
				'scope' => 'course',
				'title' => esc_html__( 'Course Settings', 'qode-lms' ),
				'name'  => 'course_settings_meta_box'
			)
		);
		
		bridge_qode_create_meta_box_field(
			array(
				'name'          => 'qode_show_title_area_course_single_meta',
				'type'          => 'select',
				'default_value' => '',
				'label'         => esc_html__( 'Show Title Area', 'qode-lms' ),
				'description'   => esc_html__( 'Enabling this option will show title area on your single course page', 'qode-lms' ),
				'parent'        => $meta_box,
				'options'       => bridge_qode_get_yes_no_select_array()
			)
		);
		
		bridge_qode_create_meta_box_field(
			array(
				'name'        => 'qode_course_instructor_meta',
				'type'        => 'selectblank',
				'label'       => esc_html__( 'Course Instructor', 'qode-lms' ),
				'description' => esc_html__( 'Select instructor for this course', 'qode-lms' ),
				'parent'      => $meta_box,
				'options'     => $qode_instructors,
				'args'        => array(
					'select2' => true
				)
			)
		);
		
		bridge_qode_create_meta_box_field(
			array(
				'name'        => 'qode_course_duration_meta',
				'type'        => 'text',
				'label'       => esc_html__( 'Course Duration', 'qode-lms' ),
				'description' => esc_html__( 'Set duration for course', 'qode-lms' ),
				'parent'      => $meta_box,
				'args'        => array(
					'col_width' => 3
				)
			)
		);
		
		bridge_qode_create_meta_box_field(
			array(
				'name'        => 'qode_course_curriculum_desc_meta',
				'type'        => 'textarea',
				'label'       => esc_html__( 'General Curriculum Description', 'qode-lms' ),
				'description' => esc_html__( 'Set general description of course curriculum', 'qode-lms' ),
				'parent'      => $meta_box,
				'args'        => array(
					'col_width' => 3
				)
			)
		);
		
		bridge_qode_create_meta_box_field(
			array(
				'name'          => 'qode_course_duration_parameter_meta',
				'type'          => 'select',
				'label'         => esc_html__( 'Course Duration Parameter', 'qode-lms' ),
				'description'   => esc_html__( 'Choose parameter for course duration', 'qode-lms' ),
				'default_value' => 'minutes',
				'parent'        => $meta_box,
				'options'       => array(
					''        => esc_html__( 'Default', 'qode-lms' ),
					'minutes' => esc_html__( 'Minutes', 'qode-lms' ),
					'hours'   => esc_html__( 'Hours', 'qode-lms' ),
					'days'    => esc_html__( 'Days', 'qode-lms' ),
					'weeks'   => esc_html__( 'Weeks', 'qode-lms' ),
				)
			)
		);
		
		bridge_qode_create_meta_box_field(
			array(
				'name'        => 'qode_course_maximum_students_meta',
				'type'        => 'text',
				'label'       => esc_html__( 'Maximum Students', 'qode-lms' ),
				'description' => esc_html__( 'Set maximal number of students', 'qode-lms' ),
				'parent'      => $meta_box,
				'args'        => array(
					'col_width' => 3
				)
			)
		);
		
		bridge_qode_create_meta_box_field(
			array(
				'name'        => 'qode_course_retake_number_meta',
				'type'        => 'text',
				'label'       => esc_html__( 'Number of Re-Takes', 'qode-lms' ),
				'description' => esc_html__( 'Set maximal number of retakes', 'qode-lms' ),
				'parent'      => $meta_box,
				'args'        => array(
					'col_width' => 3
				)
			)
		);
		
		bridge_qode_create_meta_box_field(
			array(
				'name'          => 'qode_course_featured_meta',
				'type'          => 'yesno',
				'default_value' => 'no',
				'label'         => esc_html__( 'Featured Course', 'qode-lms' ),
				'description'   => esc_html__( 'Enable this option to set course featured', 'qode-lms' ),
				'parent'        => $meta_box
			)
		);
		
		bridge_qode_create_meta_box_field(
			array(
				'name'        => 'qode_course_prerequired_meta',
				'type'        => 'selectblank',
				'label'       => esc_html__( 'Pre-Required Course', 'qode-lms' ),
				'description' => esc_html__( 'Select course that needs to be completed before attending', 'qode-lms' ),
				'parent'      => $meta_box,
				'options'     => $qode_courses,
				'args'        => array(
					'select2' => true
				)
			)
		);
		
		bridge_qode_create_meta_box_field(
			array(
				'name'        => 'qode_course_passing_percentage_meta',
				'type'        => 'text',
				'label'       => esc_html__( 'Passing Percentage', 'qode-lms' ),
				'description' => esc_html__( 'Set value required to pass the course', 'qode-lms' ),
				'parent'      => $meta_box,
				'args'        => array(
					'col_width' => 3
				)
			)
		);
		
		bridge_qode_create_meta_box_field(
			array(
				'name'          => 'qode_course_free_meta',
				'type'          => 'select',
				'default_value' => '',
				'label'         => esc_html__( 'Free Course', 'qode-lms' ),
				'description'   => esc_html__( 'Enabling this option will set course to be free', 'qode-lms' ),
				'parent'        => $meta_box,
				'options'       => bridge_qode_get_yes_no_select_array( false ),
				'args'          => array(
					'dependence' => true,
					'hide'       => array(
						'no'  => '',
						'yes' => '#qodef_course_price_container'
					),
					'show'       => array(
						'no'  => '#qodef_course_price_container',
						'yes' => ''
					)
				)
			)
		);
		
		$course_price_container = bridge_qode_add_admin_container(
			array(
				'type'            => 'container',
				'name'            => 'course_price_container',
				'parent'          => $meta_box,
				'hidden_property' => 'qode_course_free_meta',
				'hidden_value'   => 'yes'
			)
		);
		
		bridge_qode_create_meta_box_field(
			array(
				'name'        => 'qode_course_price_meta',
				'type'        => 'text',
				'label'       => esc_html__( 'Price', 'qode-lms' ),
				'description' => esc_html__( 'Set price for course', 'qode-lms' ),
				'parent'      => $course_price_container,
				'args'        => array(
					'col_width' => 3
				)
			)
		);
		
		bridge_qode_create_meta_box_field(
			array(
				'name'        => 'qode_course_price_discount_meta',
				'type'        => 'text',
				'label'       => esc_html__( 'Discount', 'qode-lms' ),
				'description' => esc_html__( 'Enter discount value for course', 'qode-lms' ),
				'parent'      => $course_price_container,
				'args'        => array(
					'col_width' => 3
				)
			)
		);
		
		bridge_qode_create_meta_box_field(
			array(
				'name'          => 'qode_course_members_meta',
				'type'          => 'yesno',
				'default_value' => 'yes',
				'label'         => esc_html__( 'Course Members', 'qode-lms' ),
				'description'   => esc_html__( 'Enabling this option will show all members that buy/start this course', 'qode-lms' ),
				'parent'        => $meta_box
			)
		);
		
		if ( qode_lms_bbpress_plugin_installed() ) {
			bridge_qode_create_meta_box_field(
				array(
					'name'        => 'qode_course_forum_meta',
					'type'        => 'selectblank',
					'label'       => esc_html__( 'Course Forum', 'qode-lms' ),
					'description' => esc_html__( 'Select forum for this course', 'qode-lms' ),
					'parent'      => $meta_box,
					'options'     => $qode_forums,
					'args'        => array(
						'select2' => true
					)
				)
			);
		}
		
		$meta_box_curriculum = bridge_qode_create_meta_box(
			array(
				'scope' => 'course',
				'title' => esc_html__( 'Course Curriculum', 'qode-lms' ),
				'name'  => 'course_curriculum_meta_box'
			)
		);
		
		qode_lms_add_meta_box_course_items_field(
			array(
				'name'        => 'qode_course_curriculum',
				'label'       => esc_html__( 'Curriculum', 'qode-lms' ),
				'description' => esc_html__( 'Organize lessons and quizzes into sections.', 'qode-lms' ),
				'parent'      => $meta_box_curriculum
			)
		);
	}
	
	add_action( 'bridge_qode_action_meta_boxes_map', 'qode_lms_map_course_meta' );
}