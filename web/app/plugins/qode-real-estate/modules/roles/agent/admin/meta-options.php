<?php

if (! function_exists('qodef_re_agent_meta_options')) {
	function qodef_re_agent_meta_options(){

		$agent_fields = bridge_qode_add_user_fields(
			array(
				'scope' => array('agent'),
				'name'  => 'agent_fields'
			)
		);

		$agencies_array = qodef_re_get_user_agency_options();

		$agent_group = bridge_qode_add_user_group(
			array(
				'name'        => 'agent_group',
				'title'       => esc_html__( 'Agent Info', 'qode-real-estate' ),
				'parent'      => $agent_fields
			)
		);
		
		bridge_qode_add_user_field(
			array(
				'name'        => 'qodef_belonging_agency',
				'type'        => 'select',
				'label'       => esc_html__( 'Agency', 'qode-real-estate' ),
				'options'     => $agencies_array,
				'parent'      => $agent_group
			)
		);
		
		bridge_qode_add_user_field(
			array(
				'name'        => 'qodef_agent_profile_image',
				'type'        => 'image',
				'label'       => esc_html__( 'Agent Profile Image', 'qode-real-estate' ),
				'parent'      => $agent_group
			)
		);

		bridge_qode_add_user_field(
			array(
				'name'        => 'qodef_agent_position',
				'type'        => 'text',
				'label'       => esc_html__( 'Agent Position', 'qode-real-estate' ),
				'parent'      => $agent_group
			)
		);
		
		bridge_qode_add_user_field(
			array(
				'name'        => 'qodef_agent_licence',
				'type'        => 'text',
				'label'       => esc_html__( 'Agent Licence', 'qode-real-estate' ),
				'parent'      => $agent_group
			)
		);

		bridge_qode_add_user_field(
			array(
				'name'        => 'qodef_agent_telephone',
				'type'        => 'text',
				'label'       => esc_html__( 'Agent Telephone', 'qode-real-estate' ),
				'parent'      => $agent_group
			)
		);

		bridge_qode_add_user_field(
			array(
				'name'        => 'qodef_agent_mobile_phone',
				'type'        => 'text',
				'label'       => esc_html__( 'Agent Mobile Phone', 'qode-real-estate' ),
				'parent'      => $agent_group
			)
		);

		bridge_qode_add_user_field(
			array(
				'name'        => 'qodef_agent_fax_number',
				'type'        => 'text',
				'label'       => esc_html__( 'Agent Fax Number', 'qode-real-estate' ),
				'parent'      => $agent_group
			)
		);

		bridge_qode_add_user_field(
			array(
				'name'        => 'qodef_agent_address',
				'type'        => 'text',
				'label'       => esc_html__( 'Agent Address', 'qode-real-estate' ),
				'parent'      => $agent_group
			)
		);
	}

	add_action( 'bridge_qode_action_custom_user_fields', 'qodef_re_agent_meta_options' );
}