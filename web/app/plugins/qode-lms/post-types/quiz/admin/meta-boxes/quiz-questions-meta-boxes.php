<?php

if ( ! function_exists( 'qode_lms_map_quiz_questions_meta' ) ) {
	function qode_lms_map_quiz_questions_meta() {
		
		$qode_questions = array();
		$questions      = get_posts(
			array(
				'numberposts' => - 1,
				'post_type'   => 'question',
				'post_status' => 'publish'
			)
		);
		foreach ( $questions as $question ) {
			$qode_questions[ $question->ID ] = $question->post_title;
		}
		
		$meta_box = bridge_qode_create_meta_box(
			array(
				'scope' => 'quiz',
				'title' => esc_html__( 'Quiz Questions', 'qode-lms' ),
				'name'  => 'quiz_questions_meta_box'
			)
		);
		
		bridge_qode_add_repeater_field(
		    array(
				'name'        => 'qode_quiz_question_list_meta',
				'parent'      => $meta_box,
				'button_text' => esc_html__( 'Add Question', 'qode-lms' ),
				'fields'      => array(
					array(
						'name'        => 'qode_quiz_question_meta',
						'type'        => 'select',
						'label'       => '',
						'description' => '',
						'parent'      => $meta_box,
						'options'     => $qode_questions,
						'args'        => array(
							'select2'  => true,
							'col_width' => 12
						),
						'th'          => esc_html__( 'Question', 'qode-lms' )
					)
				)
			)
		);
	}
	
	add_action( 'bridge_qode_action_meta_boxes_map', 'qode_lms_map_quiz_questions_meta', 4 );
}