<?php

if ( ! function_exists( 'qode_lms_course_options_map' ) ) {
	function qode_lms_course_options_map() {
		
		bridge_qode_add_admin_page(
			array(
				'slug'  => '_course',
				'title' => esc_html__( 'Course', 'qode-lms' ),
				'icon'  => 'fa fa-book'
			)
		);
		
		$panel_archive = bridge_qode_add_admin_panel(
			array(
				'title' => esc_html__( 'Course Archive', 'qode-lms' ),
				'name'  => 'panel_course_archive',
				'page'  => '_course'
			)
		);
		
		bridge_qode_add_admin_field(
			array(
				'name'        => 'course_archive_number_of_items',
				'type'        => 'text',
				'label'       => esc_html__( 'Number of Items', 'qode-lms' ),
				'description' => esc_html__( 'Set number of items for your course list on archive pages. Default value is 12', 'qode-lms' ),
				'parent'      => $panel_archive,
				'args'        => array(
					'col_width' => 3
				)
			)
		);
		
		bridge_qode_add_admin_field(
			array(
				'name'          => 'course_archive_number_of_columns',
				'type'          => 'select',
				'label'         => esc_html__( 'Number of Columns', 'qode-lms' ),
				'default_value' => '4',
				'description'   => esc_html__( 'Set number of columns for your course list on archive pages. Default value is 4 columns', 'qode-lms' ),
				'parent'        => $panel_archive,
				'options'       => array(
					'2' => esc_html__( '2 Columns', 'qode-lms' ),
					'3' => esc_html__( '3 Columns', 'qode-lms' ),
					'4' => esc_html__( '4 Columns', 'qode-lms' ),
					'5' => esc_html__( '5 Columns', 'qode-lms' )
				)
			)
		);
		
		bridge_qode_add_admin_field(
			array(
				'name'          => 'course_archive_space_between_items',
				'type'          => 'select',
				'label'         => esc_html__( 'Space Between Items', 'qode-lms' ),
				'default_value' => 'normal',
				'description'   => esc_html__( 'Set space size between course items for your course list on archive pages. Default value is normal', 'qode-lms' ),
				'parent'        => $panel_archive,
				'options'       => bridge_qode_get_space_between_items_array()
			)
		);
		
		bridge_qode_add_admin_field(
			array(
				'name'          => 'course_archive_image_size',
				'type'          => 'select',
				'label'         => esc_html__( 'Image Proportions', 'qode-lms' ),
				'default_value' => 'landscape',
				'description'   => esc_html__( 'Set image proportions for your course list on archive pages. Default value is landscape', 'qode-lms' ),
				'parent'        => $panel_archive,
				'options'       => array(
					'full'      => esc_html__( 'Original', 'qode-lms' ),
					'landscape' => esc_html__( 'Landscape', 'qode-lms' ),
					'portrait'  => esc_html__( 'Portrait', 'qode-lms' ),
					'square'    => esc_html__( 'Square', 'qode-lms' )
				)
			)
		);
		
		$panel = bridge_qode_add_admin_panel(
			array(
				'title' => esc_html__( 'Course Single', 'qode-lms' ),
				'name'  => 'panel_course_single',
				'page'  => '_course'
			)
		);
		
		bridge_qode_add_admin_field(
			array(
				'type'          => 'select',
				'name'          => 'show_title_area_course_single',
				'default_value' => '',
				'label'         => esc_html__( 'Show Title Area', 'qode-lms' ),
				'description'   => esc_html__( 'Enabling this option will show title area on single courses', 'qode-lms' ),
				'parent'        => $panel,
				'options'       => bridge_qode_get_yes_no_select_array(),
				'args'          => array(
					'col_width' => 3
				)
			)
		);
		
		bridge_qode_add_admin_field(
			array(
				'name'          => 'course_single_comments',
				'type'          => 'yesno',
				'label'         => esc_html__( 'Show Comments', 'qode-lms' ),
				'description'   => esc_html__( 'Enabling this option will show comments on your page', 'qode-lms' ),
				'parent'        => $panel,
				'default_value' => 'yes'
			)
		);
		
		bridge_qode_add_admin_field(
			array(
				'name'        => 'course_single_slug',
				'type'        => 'text',
				'label'       => esc_html__( 'Course Single Slug', 'qode-lms' ),
				'description' => esc_html__( 'Enter if you wish to use a different Single Course slug (Note: After entering slug, navigate to Settings -> Permalinks and click "Save" in order for changes to take effect)', 'qode-lms' ),
				'parent'      => $panel,
				'args'        => array(
					'col_width' => 3
				)
			)
		);
	}
	
	add_action( 'bridge_qode_action_options_map', 'qode_lms_course_options_map', 14 );
}