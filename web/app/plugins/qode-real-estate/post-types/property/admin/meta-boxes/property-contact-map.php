<?php

if ( ! function_exists( 'qodef_re_map_property_contact_meta' ) ) {
	function qodef_re_map_property_contact_meta( $meta_box ) {
		
		$property_contact_container = bridge_qode_add_admin_container(
			array(
				'type'   => 'container',
				'name'   => 'property_contact_container',
				'parent' => $meta_box
			)
		);
		
		bridge_qode_add_admin_section_title(
			array(
				'title'  => esc_html__( 'Contact Information', 'qode-real-estate' ),
				'name'   => 'property_contact_container_title',
				'parent' => $property_contact_container
			)
		);
		
		bridge_qode_create_meta_box_field(
			array(
				'name'        => 'qodef_property_contact_info_meta',
				'type'        => 'select',
				'label'       => esc_html__( 'Contact Info to Display', 'qode-real-estate' ),
				'description' => esc_html__( 'Chose what info will be displayed', 'qode-real-estate' ),
				'parent'      => $property_contact_container,
				'options'     => array(
					''       => esc_html__( 'None', 'qode-real-estate' ),
					'agency' => esc_html__( 'Agency Info', 'qode-real-estate' ),
					'agent'  => esc_html__( 'Agent Info', 'qode-real-estate' ),
					'owner'  => esc_html__( 'Owner Info', 'qode-real-estate' )
				),
                'args'    => array(
                    'dependence' => true,
                    'hide'       => array(
                        ''       => '#qodef_property_contact_agency_container, #qodef_property_contact_agent_container, #qodef_property_contact_owner_container',
                        'agency' => '#qodef_property_contact_agent_container, #qodef_property_contact_owner_container',
                        'agent'  => '#qodef_property_contact_agency_container, #qodef_property_contact_owner_container',
                        'owner'  => '#qodef_property_contact_agency_container, #qodef_property_contact_agent_container',
                    ),
                    'show'       => array(
                        ''       => '',
                        'agency'     => '#qodef_property_contact_agency_container',
                        'agent'    => '#qodef_property_contact_agent_container',
                        'owner'    => '#qodef_property_contact_owner_container',
                    )
                )
			)
		);
		
		$property_contact_agency_container = bridge_qode_add_admin_container(
			array(
				'type'       => 'container',
				'name'       => 'property_contact_agency_container',
				'parent'     => $property_contact_container,
                'hidden_property' => 'qodef_property_contact_info_meta',
                'hidden_values'    => array(
                    'agent',
                    'owner'
                )
			)
		);
		
		bridge_qode_create_meta_box_field(
			array(
				'name'        => 'qodef_property_contact_agency_meta',
				'type'        => 'selectblank',
				'label'       => esc_html__( 'Agency', 'qode-real-estate' ),
				'description' => esc_html__( 'Chose agency to be displayed', 'qode-real-estate' ),
				'parent'      => $property_contact_agency_container,
				'options'     => qodef_re_get_user_agency_options(),
			)
		);
		
		$property_contact_agent_container = bridge_qode_add_admin_container(
			array(
				'type'       => 'container',
				'name'       => 'property_contact_agent_container',
				'parent'     => $property_contact_container,
                'hidden_property' => 'qodef_property_contact_info_meta',
                'hidden_values'    => array(
                    'agency',
                    'owner'
                )
			)
		);
		
		bridge_qode_create_meta_box_field(
			array(
				'name'        => 'qodef_property_contact_agent_meta',
				'type'        => 'selectblank',
				'label'       => esc_html__( 'Agent', 'qode-real-estate' ),
				'description' => esc_html__( 'Chose agent to be displayed', 'qode-real-estate' ),
				'parent'      => $property_contact_agent_container,
				'options'     => qodef_re_get_user_agent_options(),
			)
		);
		
		$property_contact_owner_container = bridge_qode_add_admin_container(
			array(
				'type'       => 'container',
				'name'       => 'property_contact_owner_container',
				'parent'     => $property_contact_container,
                'hidden_property' => 'qodef_property_contact_info_meta',
                'hidden_values'    => array(
                    'agency',
                    'agent'
                )
			)
		);
		
		bridge_qode_create_meta_box_field(
			array(
				'name'        => 'qodef_property_contact_owner_meta',
				'type'        => 'selectblank',
				'label'       => esc_html__( 'Owner', 'qode-real-estate' ),
				'description' => esc_html__( 'Chose owner to be displayed', 'qode-real-estate' ),
				'parent'      => $property_contact_owner_container,
				'options'     => qodef_re_get_user_owner_options(),
			)
		);
	}
	
	add_action( 'qodef_re_action_property_meta_fields', 'qodef_re_map_property_contact_meta', 17, 1 );
}