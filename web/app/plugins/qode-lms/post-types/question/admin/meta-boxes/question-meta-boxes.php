<?php

if ( ! function_exists( 'qode_lms_map_question_meta' ) ) {
	function qode_lms_map_question_meta() {
		
		$meta_box = bridge_qode_create_meta_box(
			array(
				'scope' => 'question',
				'title' => esc_html__( 'Question Settings', 'qode-lms' ),
				'name'  => 'question_settings_meta_box'
			)
		);
		
		bridge_qode_create_meta_box_field(
			array(
				'name'        => 'qode_question_description_meta',
				'type'        => 'textarea',
				'label'       => esc_html__( 'Question Description', 'qode-lms' ),
				'description' => esc_html__( 'Set duration for question', 'qode-lms' ),
				'parent'      => $meta_box,
				'args'        => array(
					'col_width' => 3
				)
			)
		);
		
		bridge_qode_create_meta_box_field(
			array(
				'name'          => 'qode_question_type_meta',
				'type'          => 'select',
				'label'         => esc_html__( 'Question Type', 'qode-lms' ),
				'description'   => esc_html__( 'Choose type for question', 'qode-lms' ),
				'default_value' => 'multi_choice',
				'parent'        => $meta_box,
				'options'       => array(
					'multi_choice'  => esc_html__( 'Multi Choice', 'qode-lms' ),
					'single_choice' => esc_html__( 'Single Choice', 'qode-lms' ),
					'text'          => esc_html__( 'Text', 'qode-lms' ),
				),
				'args'          => array(
					'dependence'      => true,
					'hide'            => array(
						'multi_choice'  => '#qodef_answers_holder_text_section_container',
						'single_choice' => '#qodef_answers_holder_text_section_container',
						'text'          => '#qodef_answers_holder_choices_section_container'
					),
					'show'            => array(
						'multi_choice'  => '#qodef_answers_holder_choices_section_container',
						'single_choice' => '#qodef_answers_holder_choices_section_container',
						'text'          => '#qodef_answers_holder_text_section_container'
					),
					'use_as_switcher' => true,
					'switch_type'     => 'single_yesno',
					'switch_property' => 'qode_question_answer_true_meta',
					'switch_enabled'  => 'single_choice'
				)
			)
		);
		
		//Choice Type
		$question_answers_single_container = bridge_qode_add_admin_container(
			array(
				'type'            => 'container',
				'name'            => 'answers_holder_choices_section_container',
				'parent'          => $meta_box,
				'hidden_property' => 'qode_question_type_meta',
				'hidden_values'   => array( 'text' )
			)
		);
		
		bridge_qode_add_repeater_field(
			array(
				'name'        => 'qode_answers_list_meta',
				'parent'      => $question_answers_single_container,
				'button_text' => '',
				'fields'      => array(
					array(
						'type'        => 'text',
						'name'        => 'qode_question_answer_title_meta',
						'label'       => '',
						'th'          => esc_html__( 'Answer text', 'qode-lms' )
					),
					array(
						'type'          => 'yesno',
						'name'          => 'qode_question_answer_true_meta',
						'default_value' => 'no',
						'label'         => '',
						'th'            => esc_html__( 'Correct?', 'qode-lms' )
					)
				)
			)
		);
		
		//Text Type
		$question_answers_text_container = bridge_qode_add_admin_container(
			array(
				'type'            => 'container',
				'name'            => 'answers_holder_text_section_container',
				'parent'          => $meta_box,
				'hidden_property' => 'qode_question_type_meta',
				'hidden_values'   => array( 'single_choice', 'multi_choice' )
			)
		);
		
		bridge_qode_create_meta_box_field(
			array(
				'name'        => 'qode_answers_text_meta',
				'type'        => 'textarea',
				'label'       => esc_html__( 'Answer', 'qode-lms' ),
				'parent'      => $question_answers_text_container,
				'args'        => array(
					'col_width' => 3
				)
			)
		);
		
		bridge_qode_create_meta_box_field(
			array(
				'name'        => 'qode_question_mark_meta',
				'type'        => 'text',
				'label'       => esc_html__( 'Question Mark', 'qode-lms' ),
				'description' => esc_html__( 'Set mark that is given for correct answer', 'qode-lms' ),
				'parent'      => $meta_box,
				'args'        => array(
					'col_width' => 3
				)
			)
		);
		
		bridge_qode_create_meta_box_field(
			array(
				'name'        => 'qode_question_hint_meta',
				'type'        => 'textarea',
				'label'       => esc_html__( 'Question Hint', 'qode-lms' ),
				'description' => esc_html__( 'Set Hint that can be displayed to student', 'qode-lms' ),
				'parent'      => $meta_box,
				'args'        => array(
					'col_width' => 3
				)
			)
		);
	}
	
	add_action( 'bridge_qode_action_meta_boxes_map', 'qode_lms_map_question_meta', 5 );
}