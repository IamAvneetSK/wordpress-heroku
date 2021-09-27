<?php

if ( ! function_exists( 'qode_lms_map_instructor_single_meta' ) ) {
	function qode_lms_map_instructor_single_meta() {
		
		$meta_box = bridge_qode_create_meta_box(
			array(
				'scope' => 'instructor',
				'title' => esc_html__( 'Instructor Info', 'qode-lms' ),
				'name'  => 'instructor_meta'
			)
		);
		
		bridge_qode_create_meta_box_field(
			array(
				'name'        => 'qode_instructor_title',
				'type'        => 'text',
				'label'       => esc_html__( 'Title', 'qode-lms' ),
				'description' => esc_html__( 'The members\'s title', 'qode-lms' ),
				'parent'      => $meta_box
			)
		);
		
		bridge_qode_create_meta_box_field(
			array(
				'name'        => 'qode_instructor_vita',
				'type'        => 'textarea',
				'label'       => esc_html__( 'Brief Vita', 'qode-lms' ),
				'description' => esc_html__( 'The members\'s brief vita', 'qode-lms' ),
				'parent'      => $meta_box
			)
		);
		
		bridge_qode_create_meta_box_field(
			array(
				'name'        => 'qode_instructor_email',
				'type'        => 'text',
				'label'       => esc_html__( 'Email', 'qode-lms' ),
				'description' => esc_html__( 'The members\'s email', 'qode-lms' ),
				'parent'      => $meta_box
			)
		);
		
		bridge_qode_create_meta_box_field(
			array(
				'name'        => 'qode_instructor_resume',
				'type'        => 'file',
				'label'       => esc_html__( 'Resume', 'qode-lms' ),
				'description' => esc_html__( 'Upload members\'s resume', 'qode-lms' ),
				'parent'      => $meta_box
			)
		);
		
		for ( $x = 1; $x < 6; $x ++ ) {
			$social_icon_group = bridge_qode_add_admin_group(
				array(
					'name'   => 'qode_instructor_social_icon_group' . $x,
					'title'  => esc_html__( 'Social Link ', 'qode-lms' ) . $x,
					'parent' => $meta_box
				)
			);
			
			$social_row1 = bridge_qode_add_admin_row(
				array(
					'name'   => 'qode_instructor_social_icon_row1' . $x,
					'parent' => $social_icon_group
				)
			);
			
			BridgeQodeIconCollections::getInstance()->getIconsMetaBoxOrOption(
				array(
					'label'            => esc_html__( 'Icon ', 'qode-lms' ) . $x,
					'parent'           => $social_row1,
					'name'             => 'qode_instructor_social_icon_pack_' . $x,
					'defaul_icon_pack' => '',
					'type'             => 'meta-box',
					'field_type'       => 'simple'
				)
			);
			
			$social_row2 = bridge_qode_add_admin_row(
				array(
					'name'   => 'qode_instructor_social_icon_row2' . $x,
					'parent' => $social_icon_group
				)
			);
			
			bridge_qode_create_meta_box_field(
				array(
					'type'            => 'textsimple',
					'label'           => esc_html__( 'Link', 'qode-lms' ),
					'name'            => 'qode_instructor_social_icon_' . $x . '_link',
					'hidden_property' => 'qode_instructor_social_icon_pack_' . $x,
					'hidden_value'    => '',
					'parent'          => $social_row2
				)
			);
			
			bridge_qode_create_meta_box_field(
				array(
					'type'            => 'selectsimple',
					'label'           => esc_html__( 'Target', 'qode-lms' ),
					'name'            => 'qode_instructor_social_icon_' . $x . '_target',
					'options'         => bridge_qode_get_link_target_array(),
					'hidden_property' => 'qode_instructor_social_icon_' . $x . '_link',
					'hidden_value'    => '',
					'parent'          => $social_row2
				)
			);
		}
	}
	
	add_action( 'bridge_qode_action_meta_boxes_map', 'qode_lms_map_instructor_single_meta', 46 );
}