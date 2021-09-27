<?php

if ( ! function_exists( 'qode_lms_map_lesson_meta' ) ) {
	function qode_lms_map_lesson_meta() {
		
		$meta_box = bridge_qode_create_meta_box(
			array(
				'scope' => 'lesson',
				'name'  => 'lesson_settings_meta_box',
				'title' => esc_html__( 'Lesson Settings', 'qode-lms' )
			)
		);
		
		bridge_qode_create_meta_box_field(
			array(
				'name'        => 'qode_lesson_description_meta',
				'type'        => 'textarea',
				'label'       => esc_html__( 'Lesson Description', 'qode-lms' ),
				'description' => esc_html__( 'Set duration for lesson', 'qode-lms' ),
				'parent'      => $meta_box,
				'args'        => array(
					'col_width' => 3
				)
			)
		);
		
		bridge_qode_create_meta_box_field(
			array(
				'name'        => 'qode_lesson_duration_meta',
				'type'        => 'text',
				'label'       => esc_html__( 'Lesson Duration', 'qode-lms' ),
				'description' => esc_html__( 'Set duration for lesson', 'qode-lms' ),
				'parent'      => $meta_box,
				'args'        => array(
					'col_width' => 3
				)
			)
		);
		
		bridge_qode_create_meta_box_field(
			array(
				'name'          => 'qode_lesson_duration_parameter_meta',
				'type'          => 'select',
				'label'         => esc_html__( 'Lesson Duration Parameter', 'qode-lms' ),
				'description'   => esc_html__( 'Choose parameter for lesson duration', 'qode-lms' ),
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
				'name'          => 'qode_lesson_free_meta',
				'type'          => 'select',
				'default_value' => '',
				'label'         => esc_html__( 'Free Lesson', 'qode-lms' ),
				'description'   => esc_html__( 'Enabling this option will set lesson to be free', 'qode-lms' ),
				'parent'        => $meta_box,
				'options'       => bridge_qode_get_yes_no_select_array()
			)
		);
		
		bridge_qode_create_meta_box_field( array(
			'name'        => 'qode_lesson_post_message_meta',
			'type'        => 'textarea',
			'label'       => esc_html__( 'Lesson Post Message', 'qode-lms' ),
			'description' => esc_html__( 'Set message that will be displayed after the lesson is completed', 'qode-lms' ),
			'parent'      => $meta_box,
			'args'        => array(
				'col_width' => 3
			)
		) );
		
		bridge_qode_create_meta_box_field(
			array(
				'name'          => 'qode_lesson_type_meta',
				'type'          => 'select',
				'default_value' => '',
				'label'         => esc_html__( 'Lesson Type', 'qode-lms' ),
				'description'   => esc_html__( 'Choose desired lesson type', 'qode-lms' ),
				'parent'        => $meta_box,
				'options'       => array(
					'reading' => esc_html__( 'Reading', 'qode-lms' ),
					'video'   => esc_html__( 'Video', 'qode-lms' ),
					'audio'   => esc_html__( 'Audio', 'qode-lms' )
				),
				'args'          => array(
					'dependence' => true,
					'hide'       => array(
						'reading' => '#qodef_qode_video_container, #qodef_qode_audio_container',
						'video'   => '#qodef_qode_audio_container',
						'audio'   => '#qodef_qode_video_container'
					),
					'show'       => array(
						'reading' => '',
						'video'   => '#qodef_qode_video_container',
						'audio'   => '#qodef_qode_audio_container'
					)
				)
			)
		);
		
		//VIDEO TYPE
		$qode_video_container = bridge_qode_add_admin_container(
			array(
				'parent'          => $meta_box,
				'name'            => 'qode_video_container',
				'hidden_property' => 'qode_lesson_type_meta',
				'hidden_value'    => 'reading'
			)
		);
		
		bridge_qode_create_meta_box_field(
			array(
				'name'          => 'qode_lesson_video_type_meta',
				'type'          => 'select',
				'label'         => esc_html__( 'Video Type', 'qode-lms' ),
				'description'   => esc_html__( 'Choose video type', 'qode-lms' ),
				'parent'        => $qode_video_container,
				'default_value' => 'social_networks',
				'options'       => array(
					'social_networks' => esc_html__( 'Video Service', 'qode-lms' ),
					'self'            => esc_html__( 'Self Hosted', 'qode-lms' )
				),
				'args'          => array(
					'dependence' => true,
					'hide'       => array(
						'social_networks' => '#qodef_qode_video_self_hosted_container',
						'self'            => '#qodef_qode_video_embedded_container'
					),
					'show'       => array(
						'social_networks' => '#qodef_qode_video_embedded_container',
						'self'            => '#qodef_qode_video_self_hosted_container'
					)
				)
			)
		);
		
		$qode_video_embedded_container = bridge_qode_add_admin_container(
			array(
				'parent'          => $qode_video_container,
				'name'            => 'qode_video_embedded_container',
				'hidden_property' => 'qode_lesson_video_type_meta',
				'hidden_value'    => 'self'
			)
		);
		
		$qode_video_self_hosted_container = bridge_qode_add_admin_container(
			array(
				'parent'          => $qode_video_container,
				'name'            => 'qode_video_self_hosted_container',
				'hidden_property' => 'qode_lesson_video_type_meta',
				'hidden_value'    => 'social_networks'
			)
		);
		
		bridge_qode_create_meta_box_field(
			array(
				'name'        => 'qode_lesson_video_link_meta',
				'type'        => 'text',
				'label'       => esc_html__( 'Video URL', 'qode-lms' ),
				'description' => esc_html__( 'Enter Video URL', 'qode-lms' ),
				'parent'      => $qode_video_embedded_container,
			)
		);
		
		bridge_qode_create_meta_box_field(
			array(
				'name'        => 'qode_lesson_video_custom_meta',
				'type'        => 'text',
				'label'       => esc_html__( 'Video MP4', 'qode-lms' ),
				'description' => esc_html__( 'Enter video URL for MP4 format', 'qode-lms' ),
				'parent'      => $qode_video_self_hosted_container,
			)
		);
		
		bridge_qode_create_meta_box_field(
			array(
				'name'        => 'qode_lesson_video_image_meta',
				'type'        => 'image',
				'label'       => esc_html__( 'Video Image', 'qode-lms' ),
				'description' => esc_html__( 'Enter video image', 'qode-lms' ),
				'parent'      => $qode_video_self_hosted_container,
			)
		);
		
		//AUDIO TYPE
		$qode_audio_container = bridge_qode_add_admin_container(
			array(
				'parent'          => $meta_box,
				'name'            => 'qode_audio_container',
				'hidden_property' => 'qode_lesson_type_meta',
				'hidden_value'    => 'reading'
			)
		);
		
		bridge_qode_create_meta_box_field(
			array(
				'name'          => 'qode_lesson_audio_type_meta',
				'type'          => 'select',
				'label'         => esc_html__( 'Audio Type', 'qode-lms' ),
				'description'   => esc_html__( 'Choose audio type', 'qode-lms' ),
				'parent'        => $qode_audio_container,
				'default_value' => 'social_networks',
				'options'       => array(
					'social_networks' => esc_html__( 'Audio Service', 'qode-lms' ),
					'self'            => esc_html__( 'Self Hosted', 'qode-lms' )
				),
				'args'          => array(
					'dependence' => true,
					'hide'       => array(
						'social_networks' => '#qodef_qode_audio_self_hosted_container',
						'self'            => '#qodef_qode_audio_embedded_container'
					),
					'show'       => array(
						'social_networks' => '#qodef_qode_audio_embedded_container',
						'self'            => '#qodef_qode_audio_self_hosted_container'
					)
				)
			)
		);
		
		$qode_audio_embedded_container = bridge_qode_add_admin_container(
			array(
				'parent'          => $qode_audio_container,
				'name'            => 'qode_audio_embedded_container',
				'hidden_property' => 'qode_lesson_audio_type_meta',
				'hidden_value'    => 'self'
			)
		);
		
		$qode_audio_self_hosted_container = bridge_qode_add_admin_container(
			array(
				'parent'          => $qode_audio_container,
				'name'            => 'qode_audio_self_hosted_container',
				'hidden_property' => 'qode_lesson_audio_type_meta',
				'hidden_value'    => 'social_networks'
			)
		);
		
		bridge_qode_create_meta_box_field(
			array(
				'name'        => 'qode_lesson_audio_link_meta',
				'type'        => 'text',
				'label'       => esc_html__( 'Audio URL', 'qode-lms' ),
				'description' => esc_html__( 'Enter audio URL', 'qode-lms' ),
				'parent'      => $qode_audio_embedded_container,
			)
		);
		
		bridge_qode_create_meta_box_field(
			array(
				'name'        => 'qode_lesson_audio_custom_meta',
				'type'        => 'text',
				'label'       => esc_html__( 'Audio Link', 'qode-lms' ),
				'description' => esc_html__( 'Enter audio link', 'qode-lms' ),
				'parent'      => $qode_audio_self_hosted_container,
			)
		);
	}
	
	add_action( 'bridge_qode_action_meta_boxes_map', 'qode_lms_map_lesson_meta', 5 );
}