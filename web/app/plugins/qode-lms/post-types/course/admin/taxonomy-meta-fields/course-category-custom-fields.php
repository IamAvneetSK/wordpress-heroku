<?php

if ( ! function_exists( 'qode_lms_course_category_fields' ) ) {
	function qode_lms_course_category_fields() {
		
		$course_category_fields = bridge_qode_add_taxonomy_fields(
			array(
				'scope' => 'course-category',
				'name'  => 'course_category'
			)
		);
		
		bridge_qode_add_taxonomy_field(
			array(
				'name'        => 'course_category_icon_pack',
				'type'        => 'icon',
				'label'       => esc_html__( 'Icon Pack', 'qode-lms' ),
				'description' => esc_html__( 'Choose icon from icon pack for taxonomy', 'qode-lms' ),
				'parent'      => $course_category_fields
			)
		);
		
		bridge_qode_add_taxonomy_field(
			array(
				'name'        => 'course_category_image',
				'type'        => 'image',
				'label'       => esc_html__( 'Image', 'qode-lms' ),
				'description' => esc_html__( 'Choose custom image for taxonomy', 'qode-lms' ),
				'parent'      => $course_category_fields
			)
		);

        bridge_qode_add_taxonomy_field(
            array(
                'name'        => 'course_category_color',
                'type'        => 'color',
                'label'       => esc_html__( 'Color', 'qode-lms' ),
                'description' => esc_html__( 'Choose color for taxonomy to be shown on Course List shortcode', 'qode-lms' ),
                'parent'      => $course_category_fields
            )
        );
	}
	
	add_action( 'bridge_qode_action_custom_taxonomy_fields', 'qode_lms_course_category_fields' );
}