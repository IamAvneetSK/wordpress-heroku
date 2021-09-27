<?php

if (!function_exists('qodef_re_agency_role_approved_filter')){
	function qodef_re_agency_role_approved_filter($approved_roles){
		$approved_roles[] = 'agency';

		return $approved_roles;
	}
	add_filter('qodef_real_estate_role_property_filter','qodef_re_agency_role_approved_filter');
}

if ( ! function_exists( 'qodef_re_dashboard_agency_pages' ) ) {
	function qodef_re_dashboard_agency_pages( $navigation, $dashboard_url ) {

		$user = wp_get_current_user();

		if ( in_array( 'agency', $user->roles ) ) {

			//check if agent role exists
			if (wp_roles()->is_role('agent')) {
				$navigation['add-agent'] = array(
					'url'         => esc_url( add_query_arg( array( 'user-action' => 'add-agent' ), $dashboard_url ) ),
					'text'        => esc_html__( 'Add Agent', 'qode-real-estate' ),
					'user_action' => 'add-agent',
					'icon'        => '<span class="lnr lnr-user"></span>'
				);
				$navigation['all-agents'] = array(
					'url'         => esc_url( add_query_arg( array( 'user-action' => 'all-agents' ), $dashboard_url ) ),
					'text'        => esc_html__( 'All Agents', 'qode-real-estate' ),
					'user_action' => 'all-agents',
					'icon'        => '<span class="lnr lnr-users"></span>'
				);
			}
		}
		
		return $navigation;
	}
	
	add_filter( 'qode_membership_dashboard_navigation_pages', 'qodef_re_dashboard_agency_pages', 12, 2 );
}

if ( ! function_exists( 'qodef_re_add_agency_pages' ) ) {
	function qodef_re_add_agency_pages( $page, $action ) {

		$user = wp_get_current_user();

        if( $action == 'profile' && in_array( 'agency', $user->roles ) ) {
            $agency_params = qodef_re_get_agency_params();
            $page = qodef_re_get_module_template_part( 'roles/agency/templates/profile', '', $agency_params);
        }
        else if( $action == 'edit-profile' && in_array( 'agency', $user->roles ) ) {
            $agency_params = qodef_re_get_agency_params();
            $page = qodef_re_get_module_template_part( 'roles/agency/templates/edit-profile', '', $agency_params);
        }
        else if( $action == 'add-agent' && in_array( 'agency', $user->roles ) && wp_roles()->is_role('agent') ) {
            $page = qodef_re_get_module_template_part( 'roles/agency/templates/add-agent', '', array());
        }
        else if( $action == 'all-agents' && in_array( 'agency', $user->roles ) && wp_roles()->is_role('agent') ) {
            $all_agents_params = qodef_re_get_all_agents();
            $page = qodef_re_get_module_template_part( 'roles/agency/templates/all-agents', '', $all_agents_params);
        }

		return $page;
	}
	
	add_filter( 'qode_membership_dashboard_pages', 'qodef_re_add_agency_pages', 10, 2 );
}


if ( ! function_exists( 'qodef_re_add_agent_profile' ) ) {
	function qodef_re_add_agent_profile() {

		if ( empty( $_POST ) || ! isset( $_POST ) ) {
			qodef_re_ajax_status( 'error', esc_html__( 'All fields are empty', 'qode-real-estate' ) );
		} else {
			parse_str( $_POST['data'], $new_user_data );

			$dashboard_url = qode_membership_get_dashboard_page_url();
			$user = wp_get_current_user();

			$nonce_name = 'qodef_validate_'.$new_user_data['qodef_form_name'].'_'.$user->ID;
			$nonce_value = 'qodef_nonce_'.$new_user_data['qodef_form_name'].'_'.$user->ID;

			//Check nonce
			if ( wp_verify_nonce( $new_user_data[$nonce_value], $nonce_name ) ) {

				$user_params = array();

				//Check if username already exists
				if ( username_exists($new_user_data['username']) ){
					qodef_re_ajax_status( 'error', esc_html__( 'This username is taken, please try another.', 'qode-real-estate' ) );
				} else {
					$user_params['user_login'] = $new_user_data['username'];
				}

				//Check password
				if ( ! empty( $new_user_data['password'] ) ) {

					if ( $new_user_data['password'] === $new_user_data['password2'] ) {
						$user_params['user_pass'] = esc_attr( $new_user_data['password'] );
					} else {
						qodef_re_ajax_status( 'error', esc_html__( 'Passwords don\'t match', 'qode-real-estate' ) );
					}

				} else {
					qodef_re_ajax_status( 'error', esc_html__( 'Please enter password', 'qode-real-estate' ) );
				}

				//Check email
				if ( ! empty( $new_user_data['email'] ) && filter_var( $new_user_data['email'], FILTER_VALIDATE_EMAIL ) ) {
					$user_params['user_email'] = esc_attr( $new_user_data['email'] );
				} else {
					qodef_re_ajax_status( 'error', esc_html__( 'Error. Please insert valid email', 'qode-real-estate' ) );
				}

				$user_params['user_url'] = esc_url( $new_user_data['url'] );
				$user_params['first_name'] = esc_attr( $new_user_data['first_name'] );
				$user_params['last_name'] = esc_attr( $new_user_data['last_name'] );
				$user_params['description'] = esc_attr( $new_user_data['description'] );
				$user_params['role'] = 'agent';

				$user_id = wp_insert_user($user_params);
				if ( ! is_wp_error( $user_id ) ) {
					update_user_meta( $user_id, 'qodef_belonging_agency', esc_attr( $new_user_data['agency'] ) );
					qodef_re_ajax_status( 'success', esc_html__( 'Agent successfully added.', 'qode-real-estate' ), NULL, $dashboard_url );
				} else {
					qodef_re_ajax_status( 'error', esc_html__( 'Error.', 'qode-real-estate' ) );
				}				

			} else {
				qodef_re_ajax_status( 'error', esc_html__( 'Error.', 'qode-real-estate' ) );
			}
		}
	}

	add_action( 'wp_ajax_qodef_re_add_agent_profile', 'qodef_re_add_agent_profile' );
}

if ( ! function_exists( 'qodef_re_update_agency_profile' ) ) {
	function qodef_re_update_agency_profile() {

		if ( empty( $_POST ) || ! isset( $_POST ) ) {
			qodef_re_ajax_status( 'error', esc_html__( 'All fields are empty', 'qode-real-estate' ) );
		} else {
			$dashboard_url = qode_membership_get_dashboard_page_url();
			parse_str( $_POST['data'], $update_data );

			$user_id = get_current_user_id();

			$nonce_name = 'qodef_validate_'.$update_data['qodef_form_name'].'_'.$user_id;
			$nonce_value = 'qodef_nonce_'.$update_data['qodef_form_name'].'_'.$user_id;

			//Check nonce
			if ( wp_verify_nonce( $update_data[$nonce_value], $nonce_name ) ) {

				if ( $user_id ) {

					//Update password
					if ( ! empty( $update_data['password'] ) ) {
						if ( $update_data['password'] === $update_data['password2'] ) {
							wp_update_user( array(
								'ID'        => $user_id,
								'user_pass' => esc_attr( $update_data['password'] )
							) );
						} else {
							qodef_re_ajax_status( 'error', esc_html__( 'Passwords don\'t match', 'qode-real-estate' ) );
						}
					}

					//Update email
					if ( ! empty( $update_data['email'] ) && filter_var( $update_data['email'], FILTER_VALIDATE_EMAIL ) ) {
						wp_update_user( array( 'ID' => $user_id, 'user_email' => esc_attr( $update_data['email'] ) ) );
					} else {
						qodef_re_ajax_status( 'error', esc_html__( 'Error. Please insert valid email', 'qode-real-estate' ) );
					}

					//Update Website
					wp_update_user( array( 'ID' => $user_id, 'user_url' => esc_url( $update_data['url'] ) ) );

					//Update user meta
					update_user_meta( $user_id, 'qodef_agency_name', $update_data['qodef_agency_name'] );
					update_user_meta( $user_id, 'qodef_agency_licence', $update_data['qodef_agency_licence'] );
					update_user_meta( $user_id, 'qodef_agency_telephone', $update_data['qodef_agency_telephone'] );
					update_user_meta( $user_id, 'qodef_agency_mobile_phone', $update_data['qodef_agency_mobile_phone'] );
					update_user_meta( $user_id, 'qodef_agency_fax_number', $update_data['qodef_agency_fax_number'] );
					update_user_meta( $user_id, 'qodef_agency_address', $update_data['qodef_agency_address'] );
					update_user_meta( $user_id, 'description', $update_data['description'] );
					
					//get media values (needed to be in input hidden because of the repeater values) - if empty then media is removed
					$agency_profile_image_db = $update_data['hidden_qodef_agency_profile_image'];
					
					if ($agency_profile_image_db == ''){
						update_user_meta( $user_id, 'qodef_agency_profile_image', '' );
					}
					
					foreach ($_FILES as $key => $value) {
						if (stripos($key,'_qodef_reg_')) {
							$lastLetterPos = stripos($key,'_qodef_reg_');
							$name = substr($key, 0, $lastLetterPos);
						}
						
						if ($value['name'] == 'qodef-dummy-file.txt'){
							$attachment_id = '';
							$attachment_url = '';
							continue;
						} else {
							$attachment_id = media_handle_upload( $key, 0 );
							$attachment_url = wp_get_attachment_url($attachment_id);
						}
						
						if ( is_wp_error( $attachment_id ) ) {
							qodef_re_ajax_status( 'error', esc_html__( 'Media not uploaded, please try again.', 'qode-real-estate' ) );
						} else {
							switch ($name) {
								case 'qodef_agency_profile_image':
									update_user_meta( $user_id, 'qodef_agency_profile_image', $attachment_id );
									break;
							}
						}
					}

					qodef_re_ajax_status( 'success', esc_html__( 'Your profile is updated', 'qode-real-estate' ), NULL, $dashboard_url );

				} else {
					qodef_re_ajax_status( 'error', esc_html__( 'You are unauthorized to perform this action.', 'qode-real-estate' ) );
				}			

			} else {
				qodef_re_ajax_status( 'error', esc_html__( 'Error.', 'qode-real-estate' ) );
			}
		}
	}

	add_action( 'wp_ajax_qodef_re_update_agency_profile', 'qodef_re_update_agency_profile' );
}

if (! function_exists('qodef_re_get_all_agents')) {
	function qodef_re_get_all_agents() {
		$params = array();
		$agency_id = get_current_user_id();

		//check if agent role exists
		if (wp_roles()->is_role('agent')) {

			$query_args = array(
				'role' => 'agent',
				'meta_key' => 'qodef_belonging_agency',
				'meta_value' => $agency_id
			);

			$agents_query = get_users($query_args);

			foreach ($agents_query as $agent) {
				$agent_params = array();
				$agent_data = $agent->data;

				$agent_params['id'] = $agent_data->ID;
				$agent_params['name'] = $agent_data->display_name;
				$agent_params['email'] = $agent_data->user_email;
				$agent_params['telephone'] = get_user_meta($agent_data->ID, 'qodef_agent_telephone', true);
				$agent_params['mobile'] = get_user_meta($agent_data->ID, 'qodef_agent_mobile_phone', true);
				$agent_params['address'] = get_user_meta($agent_data->ID, 'qodef_agent_address', true);
				$agent_params['position'] = get_user_meta($agent_data->ID, 'qodef_agent_position', true);

				$params['agents'][] = $agent_params;
			}
		}

		return $params;
	}
}

if ( ! function_exists( 'qodef_re_get_agency_params' ) ) {
	/**
	 * Returns agency params
	 *
	 */
	function qodef_re_get_agency_params() {
		$params = array();

		$user_id = get_current_user_id();

		$params['qodef_agency_name']  = get_user_meta($user_id, 'qodef_agency_name', true);
		$params['qodef_agency_licence']  = get_user_meta($user_id, 'qodef_agency_licence', true);
		$params['email']       = get_the_author_meta('email', $user_id);
		$params['website']     = get_the_author_meta('url', $user_id);
		$params['description']  = get_user_meta($user_id, 'description', true);
		$params['qodef_agency_telephone']  = get_user_meta($user_id, 'qodef_agency_telephone', true);
		$params['qodef_agency_mobile_phone']  = get_user_meta($user_id, 'qodef_agency_mobile_phone', true);
		$params['qodef_agency_fax_number']  = get_user_meta($user_id, 'qodef_agency_fax_number', true);
		$params['qodef_agency_address']  = get_user_meta($user_id, 'qodef_agency_address', true);
		$params['qodef_agency_profile_image'] = get_user_meta($user_id, 'qodef_agency_profile_image', true);
		$profile_image			= get_user_meta($user_id, 'social_profile_image', true);
		
		if ( isset($params['qodef_agency_profile_image']) && $params['qodef_agency_profile_image'] !== '' ) {
			$profile_image = wp_get_attachment_image($params['qodef_agency_profile_image'],'thumbnail');
		} elseif ( $profile_image !== '' ) {
			$profile_image = '<img src="' . esc_url( $profile_image ) . '">';
		} else {
			$profile_image = get_avatar( $user_id, 96 );
		}
		$params['profile_image'] = $profile_image;

		return $params;
	}
}

if (! function_exists('qodef_re_get_user_agency_options')){
	function qodef_re_get_user_agency_options(){
		$agencies_array = array();

		$agencies = get_users(array('role' => 'agency'));

		foreach ($agencies as $agency) {
			$agencies_array[$agency->ID] = $agency->user_nicename;
		}

		return $agencies_array;
	}
}