<?php

if ( ! function_exists( 'qode_lms_map_quiz_meta' ) ) {
	function qode_lms_map_quiz_meta() {
		
		$meta_box = bridge_qode_create_meta_box(
			array(
				'scope' => 'quiz',
				'name'  => 'quiz_settings_meta_box',
				'title' => esc_html__( 'Quiz Settings', 'qode-lms' )
			)
		);
		
		bridge_qode_create_meta_box_field(
			array(
				'name'        => 'qode_quiz_description_meta',
				'type'        => 'textarea',
				'label'       => esc_html__( 'Quiz Description', 'qode-lms' ),
				'description' => esc_html__( 'Set duration for quiz', 'qode-lms' ),
				'parent'      => $meta_box,
				'args'        => array(
					'col_width' => 3
				)
			)
		);
		
		bridge_qode_create_meta_box_field(
			array(
				'name'        => 'qode_quiz_duration_meta',
				'type'        => 'text',
				'label'       => esc_html__( 'Quiz Duration', 'qode-lms' ),
				'description' => esc_html__( 'Set duration for quiz', 'qode-lms' ),
				'parent'      => $meta_box,
				'args'        => array(
					'col_width' => 3
				)
			)
		);
		
		bridge_qode_create_meta_box_field(
			array(
				'name'          => 'qode_quiz_duration_parameter_meta',
				'type'          => 'select',
				'label'         => esc_html__( 'Quiz Duration Parameter', 'qode-lms' ),
				'description'   => esc_html__( 'Choose parameter for quiz duration', 'qode-lms' ),
				'default_value' => 'minutes',
				'parent'        => $meta_box,
				'options'       => array(
					'seconds' => esc_html__( 'Seconds', 'qode-lms' ),
					'minutes' => esc_html__( 'Minutes', 'qode-lms' ),
					'hours'   => esc_html__( 'Hours', 'qode-lms' )
				)
			)
		);
		
		bridge_qode_create_meta_box_field(
			array(
				'name'        => 'qode_quiz_number_retakes_meta',
				'type'        => 'text',
				'label'       => esc_html__( 'Number of Retakes', 'qode-lms' ),
				'description' => esc_html__( 'Set allowed number of quiz retakes.', 'qode-lms' ),
				'parent'      => $meta_box,
				'args'        => array(
					'col_width' => 3
				)
			)
		);
		
		bridge_qode_create_meta_box_field(
			array(
				'name'        => 'qode_quiz_passing_percentage_meta',
				'type'        => 'text',
				'label'       => esc_html__( 'Passing Percentage', 'qode-lms' ),
				'description' => esc_html__( 'Set value required to pass the quiz', 'qode-lms' ),
				'parent'      => $meta_box,
				'args'        => array(
					'col_width' => 3
				)
			)
		);
		
		bridge_qode_create_meta_box_field(
			array(
				'name'        => 'qode_quiz_post_message_meta',
				'type'        => 'textarea',
				'label'       => esc_html__( 'Quiz Post Message', 'qode-lms' ),
				'description' => esc_html__( 'Set message that will be displayed after the quiz is completed', 'qode-lms' ),
				'parent'      => $meta_box,
				'args'        => array(
					'col_width' => 3
				)
			)
		);
	}
	
	add_action( 'bridge_qode_action_meta_boxes_map', 'qode_lms_map_quiz_meta', 5 );
}