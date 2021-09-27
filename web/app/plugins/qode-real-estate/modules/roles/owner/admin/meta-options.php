<?php

if (! function_exists('qodef_re_owner_meta_options')) {
	function qodef_re_owner_meta_options(){

		$owner_fields = bridge_qode_add_user_fields(
			array(
				'scope' => array('owner'),
				'name'  => 'owner_fields'
			)
		);

		$owner_group = bridge_qode_add_user_group(
			array(
				'name'        => 'owner_group',
				'title'       => esc_html__( 'Owner Info', 'qode-real-estate' ),
				'parent'      => $owner_fields
			)
		);
		
		bridge_qode_add_user_field(
			array(
				'name'        => 'qodef_owner_profile_image',
				'type'        => 'image',
				'label'       => esc_html__( 'Owner Profile Image', 'qode-real-estate' ),
				'parent'      => $owner_group
			)
		);

		bridge_qode_add_user_field(
			array(
				'name'        => 'qodef_owner_telephone',
				'type'        => 'text',
				'label'       => esc_html__( 'Owner Telephone', 'qode-real-estate' ),
				'parent'      => $owner_group
			)
		);

		bridge_qode_add_user_field(
			array(
				'name'        => 'qodef_owner_mobile_phone',
				'type'        => 'text',
				'label'       => esc_html__( 'Owner Mobile Phone', 'qode-real-estate' ),
				'parent'      => $owner_group
			)
		);

		bridge_qode_add_user_field(
			array(
				'name'        => 'qodef_owner_fax_number',
				'type'        => 'text',
				'label'       => esc_html__( 'Owner Fax Number', 'qode-real-estate' ),
				'parent'      => $owner_group
			)
		);

		bridge_qode_add_user_field(
			array(
				'name'        => 'qodef_owner_address',
				'type'        => 'text',
				'label'       => esc_html__( 'Owner Address', 'qode-real-estate' ),
				'parent'      => $owner_group
			)
		);
	}

	add_action( 'bridge_qode_action_custom_user_fields', 'qodef_re_owner_meta_options' );
}