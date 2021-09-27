<?php
if ( !function_exists('qodef_real_estate_dashboard_edit_agency_fields') ) {
	function qodef_real_estate_dashboard_edit_agency_fields($params){

		extract($params);

		$edit_agency = bridge_qode_add_dashboard_fields(array(
			'name' => 'add_agent',
		));

		$edit_agency_form = bridge_qode_add_dashboard_form(array(
			'name' => 'edit_agency_form',
			'form_id'   => 'qodef-re-update-agency-profile-form',
			'form_action' => 'qodef_re_update_agency_profile',
			'parent' => $edit_agency,
			'button_label' => esc_html__('UPDATE PROFILE','qode-real-estate'),
			'button_args' => array(
				'data-updating-text' => esc_html__('UPDATING PROFILE', 'qode-real-estate'),
				'data-updated-text' => esc_html__('PROFILE UPDATED', 'qode-real-estate'),
			)
		));

		bridge_qode_add_dashboard_field(array(
			'type' => 'text',
			'name' => 'qodef_agency_name',
			'label' => esc_html__('Agency Name','qode-real-estate'),
			'parent' => $edit_agency_form,
			'value' => $qodef_agency_name
		));
		
		bridge_qode_add_dashboard_field(array(
			'type' => 'image',
			'name' => 'qodef_agency_profile_image',
			'label' => esc_html__('Agency Profile Image','qode-real-estate'),
			'parent' => $edit_agency_form,
			'value' => $qodef_agency_profile_image
		));

		bridge_qode_add_dashboard_field(array(
			'type' => 'text',
			'name' => 'qodef_agency_licence',
			'label' => esc_html__('Agency Licence','qode-real-estate'),
			'parent' => $edit_agency_form,
			'value' => $qodef_agency_licence
		));
		
		bridge_qode_add_dashboard_field(array(
			'type' => 'text',
			'name' => 'email',
			'label' => esc_html__('Email','qode-real-estate'),
			'parent' => $edit_agency_form,
			'value' => $email,
			'args' => array(
				'input_type' => 'email'
			)
		));

		bridge_qode_add_dashboard_field(array(
			'type' => 'text',
			'name' => 'url',
			'label' => esc_html__('Website','qode-real-estate'),
			'parent' => $edit_agency_form,
			'value' => $website
		));

		bridge_qode_add_dashboard_field(array(
			'type' => 'text',
			'name' => 'qodef_agency_telephone',
			'label' => esc_html__('Telephone','qode-real-estate'),
			'parent' => $edit_agency_form,
			'value' => $qodef_agency_telephone
		));

		bridge_qode_add_dashboard_field(array(
			'type' => 'text',
			'name' => 'qodef_agency_mobile_phone',
			'label' => esc_html__('Mobile Phone','qode-real-estate'),
			'parent' => $edit_agency_form,
			'value' => $qodef_agency_mobile_phone
		));

		bridge_qode_add_dashboard_field(array(
			'type' => 'text',
			'name' => 'qodef_agency_fax_number',
			'label' => esc_html__('Fax Number','qode-real-estate'),
			'parent' => $edit_agency_form,
			'value' => $qodef_agency_fax_number
		));

		bridge_qode_add_dashboard_field(array(
			'type' => 'text',
			'name' => 'qodef_agency_address',
			'label' => esc_html__('Address','qode-real-estate'),
			'parent' => $edit_agency_form,
			'value' => $qodef_agency_address
		));

		bridge_qode_add_dashboard_field(array(
			'type' => 'text',
			'name' => 'description',
			'label' => esc_html__('Description','qode-real-estate'),
			'parent' => $edit_agency_form,
			'value' => $description
		));

		bridge_qode_add_dashboard_field(array(
			'type' => 'text',
			'name' => 'password',
			'label' => esc_html__('Password','qode-real-estate'),
			'parent' => $edit_agency_form,
			'args' => array(
				'input_type' => 'password'
			)
		));

		bridge_qode_add_dashboard_field(array(
			'type' => 'text',
			'name' => 'password2',
			'label' => esc_html__('Repeat Password','qode-real-estate'),
			'parent' => $edit_agency_form,
			'args' => array(
				'input_type' => 'password'
			)
		));

		$edit_agency->render();
	}
} ?>
<div class="qodef-membership-dashboard-page qodef-real-estate-dashboard-page">
	<div class="qodef-edit-profile">
		<h2><?php esc_html_e('Edit Profile', 'qode-real-estate'); ?></h2>
		<p><?php esc_html_e('Update your profile now', 'qode-real-estate'); ?></p>
		<div>
			<?php qodef_real_estate_dashboard_edit_agency_fields($params); ?>
			<?php do_action( 'qode_membership_action_login_ajax_response' ); ?>
		</div>
	</div>
</div>