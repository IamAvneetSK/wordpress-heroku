<?php
if ( !function_exists('qodef_real_estate_dashboard_add_agent_fields') ) {
	function qodef_real_estate_dashboard_add_agent_fields(){

		$add_agent = bridge_qode_add_dashboard_fields(array(
			'name' => 'add_agent',
		));

		$add_agent_form = bridge_qode_add_dashboard_form(array(
			'name' => 'add_agent_form',
			'form_id'   => 'qodef-re-add-agent-form',
			'form_action' => 'qodef_re_add_agent_profile',
			'parent' => $add_agent,
			'button_label' => esc_html__('CREATE AGENT','qode-real-estate'),
			'button_args' => array(
				'data-updating-text' => esc_html__('CREATING AGENT', 'qode-real-estate'),
				'data-updated-text' => esc_html__('AGENT CREATED', 'qode-real-estate'),
			)
		));

		bridge_qode_add_dashboard_field(array(
			'type' => 'text',
			'name' => 'username',
			'label' => esc_html__('Username','qode-real-estate'),
			'parent' => $add_agent_form,
		));

		bridge_qode_add_dashboard_field(array(
			'type' => 'text',
			'name' => 'first_name',
			'label' => esc_html__('First Name','qode-real-estate'),
			'parent' => $add_agent_form,
		));
		
		bridge_qode_add_dashboard_field(array(
			'type' => 'text',
			'name' => 'last_name',
			'label' => esc_html__('Last Name','qode-real-estate'),
			'parent' => $add_agent_form,
		));

		bridge_qode_add_dashboard_field(array(
			'type' => 'text',
			'name' => 'email',
			'label' => esc_html__('Email','qode-real-estate'),
			'parent' => $add_agent_form,
			'args' => array(
				'input_type' => 'email'
			)
		));

		bridge_qode_add_dashboard_field(array(
			'type' => 'text',
			'name' => 'url',
			'label' => esc_html__('Website','qode-real-estate'),
			'parent' => $add_agent_form,
		));

		bridge_qode_add_dashboard_field(array(
			'type' => 'text',
			'name' => 'description',
			'label' => esc_html__('Description','qode-real-estate'),
			'parent' => $add_agent_form,
		));

		bridge_qode_add_dashboard_field(array(
			'type' => 'text',
			'name' => 'password',
			'label' => esc_html__('Password','qode-real-estate'),
			'parent' => $add_agent_form,
			'args' => array(
				'input_type' => 'password'
			)
		));

		bridge_qode_add_dashboard_field(array(
			'type' => 'text',
			'name' => 'password2',
			'label' => esc_html__('Repeat Password','qode-real-estate'),
			'parent' => $add_agent_form,
			'args' => array(
				'input_type' => 'password'
			)
		));

		bridge_qode_add_dashboard_field(array(
			'type' => 'text',
			'name' => 'agency',
			'parent' => $add_agent_form,
			'value' => get_current_user_id(),
			'args' => array(
				'input_type' => 'hidden'
			)
		));

		$add_agent->render();
	}
}
?>
<div class="qodef-membership-dashboard-page qodef-real-estate-dashboard-page">
	<div class="qodef-add-agent-page">
		<h2 class="qodef-real-estate-page-title"><?php esc_html_e('New Agent', 'qode-real-estate'); ?></h2>
		<p><?php esc_html_e('Add new agent for your agency', 'qode-real-estate'); ?></p>
		<div>
			<?php qodef_real_estate_dashboard_add_agent_fields(); ?>
			<?php do_action( 'qode_membership_action_login_ajax_response' ); ?>
		</div>
	</div>
</div>