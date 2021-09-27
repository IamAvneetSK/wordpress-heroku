<?php

if (! function_exists('qodef_re_agency_meta_options')) {
	function qodef_re_agency_meta_options(){

		$agency_fields = bridge_qode_add_user_fields(
			array(
				'scope' => array('agency'),
				'name'  => 'agency_fields'
			)
		);

		$agency_group = bridge_qode_add_user_group(
			array(
				'name'        => 'agency_group',
				'title'       => esc_html__( 'Agency Info', 'qode-real-estate' ),
				'parent'      => $agency_fields
			)
		);
		
		bridge_qode_add_user_field(
			array(
				'name'        => 'qodef_agency_name',
				'type'        => 'text',
				'label'       => esc_html__( 'Agency Name', 'qode-real-estate' ),
				'parent'      => $agency_group
			)
		);
		
		bridge_qode_add_user_field(
			array(
				'name'        => 'qodef_agency_profile_image',
				'type'        => 'image',
				'label'       => esc_html__( 'Agency Profile Image', 'qode-real-estate' ),
				'parent'      => $agency_group
			)
		);
		
		bridge_qode_add_user_field(
			array(
				'name'        => 'qodef_agency_licence',
				'type'        => 'text',
				'label'       => esc_html__( 'Agency Licence', 'qode-real-estate' ),
				'parent'      => $agency_group
			)
		);

		bridge_qode_add_user_field(
			array(
				'name'        => 'qodef_agency_telephone',
				'type'        => 'text',
				'label'       => esc_html__( 'Agency Telephone', 'qode-real-estate' ),
				'parent'      => $agency_group
			)
		);

		bridge_qode_add_user_field(
			array(
				'name'        => 'qodef_agency_mobile_phone',
				'type'        => 'text',
				'label'       => esc_html__( 'Agency Mobile Phone', 'qode-real-estate' ),
				'parent'      => $agency_group
			)
		);

		bridge_qode_add_user_field(
			array(
				'name'        => 'qodef_agency_fax_number',
				'type'        => 'text',
				'label'       => esc_html__( 'Agency Fax Number', 'qode-real-estate' ),
				'parent'      => $agency_group
			)
		);

		bridge_qode_add_user_field(
			array(
				'name'        => 'qodef_agency_address',
				'type'        => 'text',
				'label'       => esc_html__( 'Agency Address', 'qode-real-estate' ),
				'parent'      => $agency_group
			)
		);
	}

	add_action( 'bridge_qode_action_custom_user_fields', 'qodef_re_agency_meta_options' );
}