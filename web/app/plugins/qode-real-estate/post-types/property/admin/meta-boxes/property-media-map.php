<?php
if ( ! function_exists( 'qodef_re_map_property_media_meta' ) ) {
	function qodef_re_map_property_media_meta( $meta_box ) {
		
		$property_media_container = bridge_qode_add_admin_container(
			array(
				'type'   => 'container',
				'name'   => 'property_media_container',
				'parent' => $meta_box
			)
		);
		
		bridge_qode_add_admin_section_title(
			array(
				'title'  => esc_html__( 'Media', 'qode-real-estate' ),
				'name'   => 'property_media_container_title',
				'parent' => $property_media_container
			)
		);
		
		// Gallery Images meta field
		$property_image_gallery = new BridgeQodeMultipleImages( "qodef_property_image_gallery", esc_html__( 'Gallery Images', 'qode-real-estate' ), esc_html__( 'Choose your gallery images', 'qode-real-estate' ) );
		$property_media_container->addChild( "qodef_property_image_gallery", $property_image_gallery );
		
		// Video meta field
		
		bridge_qode_create_meta_box_field(
			array(
				'name'          => 'qodef_property_video_type_meta',
				'type'          => 'select',
				'label'         => esc_html__( 'Video Type', 'qode-real-estate' ),
				'description'   => esc_html__( 'Choose video type', 'qode-real-estate' ),
				'parent'        => $property_media_container,
				'default_value' => 'social_networks',
				'options'       => array(
					'social_networks' => esc_html__( 'Video Service', 'qode-real-estate' ),
					'self'            => esc_html__( 'Self Hosted', 'qode-real-estate' )
				)
			)
		);
		
		$qodef_video_embedded_container = bridge_qode_add_admin_container(
			array(
				'parent' => $property_media_container,
				'name'   => 'qodef_video_embedded_container'
			)
		);
		
		bridge_qode_create_meta_box_field(
			array(
				'name'        => 'qodef_property_video_link_meta',
				'type'        => 'text',
				'label'       => esc_html__( 'Video URL', 'qode-real-estate' ),
				'description' => esc_html__( 'Enter Video URL', 'qode-real-estate' ),
				'parent'      => $qodef_video_embedded_container,
			)
		);
		
		bridge_qode_create_meta_box_field(
			array(
				'name'        => 'qodef_property_video_custom_meta',
				'type'        => 'text',
				'label'       => esc_html__( 'Video MP4', 'qode-real-estate' ),
				'description' => esc_html__( 'Enter video URL for MP4 format', 'qode-real-estate' ),
				'parent'      => $qodef_video_embedded_container,
				'dependency'  => array(
					'show' => array(
						'qodef_property_video_type_meta' => 'self'
					)
				)
			)
		);
		
		bridge_qode_create_meta_box_field(
			array(
				'name'        => 'qodef_property_video_image_meta',
				'type'        => 'image',
				'label'       => esc_html__( 'Video Image', 'qode-real-estate' ),
				'description' => esc_html__( 'Enter video image', 'qode-real-estate' ),
				'parent'      => $qodef_video_embedded_container,
				'dependency'  => array(
					'show' => array(
						'qodef_property_video_type_meta' => 'self'
					)
				)
			)
		);
		
		bridge_qode_create_meta_box_field(
			array(
				'name'   => 'qodef_property_virtual_tour_meta',
				'type'   => 'textarea',
				'label'  => esc_html__( 'Virtual Tour Core', 'qode-real-estate' ),
				'parent' => $property_media_container
			)
		);
		
		bridge_qode_create_meta_box_field(
			array(
				'name'   => 'qodef_property_attachment_meta',
				'type'   => 'file',
				'label'  => esc_html__( 'Attachment', 'qode-real-estate' ),
				'parent' => $property_media_container
			)
		);
	}
	
	add_action( 'qodef_re_action_property_meta_fields', 'qodef_re_map_property_media_meta', 14, 1 );
}