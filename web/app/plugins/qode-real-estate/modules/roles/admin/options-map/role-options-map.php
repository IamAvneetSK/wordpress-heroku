<?php

if ( ! function_exists( 'qodef_real_estate_roles_options_map' ) ) {
	function qodef_real_estate_roles_options_map( $panel ) {
		
		bridge_qode_add_admin_field(
			array(
				'name'          => 'real_estate_registration_role_enabled',
				'type'          => 'yesno',
				'default_value' => 'yes',
				'label'         => esc_html__( 'Enable Registration Role', 'qode-real-estate' ),
				'description'   => esc_html__( 'Enable this if you want to allow users to choose role upon registration. Otherwise, default role from WP Settings -> General will be used.', 'qode-real-estate' ),
				'parent'        => $panel,
                'args'          => array(
                    "dependence"             => true,
                    "dependence_hide_on_yes" => "",
                    "dependence_show_on_yes" => "#qodef_role_settings_container"
                )
			)
		);
		
		$role_settings_container = bridge_qode_add_admin_container(
			array(
				'type'       => 'container',
				'name'       => 'role_settings_container',
				'parent'     => $panel,
                'hidden_property' => 'real_estate_registration_role_enabled',
                'hidden_value'    => 'no'
			)
		);
		
		bridge_qode_add_admin_field(
			array(
				'name'          => 'real_estate_enable_owner_role',
				'type'          => 'yesno',
				'default_value' => 'yes',
				'label'         => esc_html__( 'Enable Owner/Buyer Role', 'qode-real-estate' ),
				'parent'        => $role_settings_container
			)
		);
		
		$owner_container = bridge_qode_add_admin_container(
			array(
				'type'       => 'container',
				'name'       => 'owner_container',
				'parent'     => $role_settings_container,
				'dependency' => array(
					'show' => array(
						'real_estate_enable_owner_role' => 'yes'
					)
				)
			)
		);
		
		bridge_qode_add_admin_field(
			array(
				'name'          => 'real_estate_owner_adding_property',
				'type'          => 'yesno',
				'default_value' => 'yes',
				'label'         => esc_html__( 'Enable Adding Property for Owner/Buyer', 'qode-real-estate' ),
				'parent'        => $owner_container
			)
		);
		
		bridge_qode_add_admin_field(
			array(
				'name'          => 'real_estate_enable_agent_role',
				'type'          => 'yesno',
				'default_value' => 'yes',
				'label'         => esc_html__( 'Enable Agent Role', 'qode-real-estate' ),
				'parent'        => $role_settings_container
			)
		);
		
		bridge_qode_add_admin_field(
			array(
				'name'          => 'real_estate_enable_agency_role',
				'type'          => 'yesno',
				'default_value' => 'yes',
				'label'         => esc_html__( 'Enable Agency Role', 'qode-real-estate' ),
				'parent'        => $role_settings_container
			)
		);
		
		bridge_qode_add_admin_field(
			array(
				'name'          => 'real_estate_enable_publish_from_user',
				'type'          => 'yesno',
				'default_value' => 'no',
				'label'         => esc_html__( 'Enable Publishing Properties for Users', 'qode-real-estate' ),
				'parent'        => $role_settings_container
			)
		);
	}
	
	add_action( 'bridge_qode_additional_real_estate_options_map', 'qodef_real_estate_roles_options_map' );
}