<?php

if (!function_exists('qodef_re_owner_role_approved_filter')){
	function qodef_re_owner_role_approved_filter($approved_roles){

		$owner_approved = bridge_qode_options()->getOptionValue('real_estate_owner_adding_property');

		if ($owner_approved == 'yes') {
			$approved_roles[] = 'owner';
		}		

		return $approved_roles;
	}
	add_filter('qodef_real_estate_role_property_filter','qodef_re_owner_role_approved_filter');
}

if ( ! function_exists( 'qodef_re_add_owner_pages' ) ) {
	function qodef_re_add_owner_pages( $page, $action ) {

		$user = wp_get_current_user();

        if( $action == 'profile' && in_array( 'owner', $user->roles ) ) {
            $owner_params = qodef_re_get_owner_params();
            $page['profile'] = qodef_re_get_module_template_part( 'roles/owner/templates/profile', '', $owner_params);
        }
        else if( $action == 'edit-profile' && in_array( 'owner', $user->roles ) ) {
            $owner_params = qodef_re_get_owner_params();
            $page['profile'] = qodef_re_get_module_template_part( 'roles/owner/templates/edit-profile', '', $owner_params);
        }

		return $page;
	}
	
	add_filter( 'qode_membership_dashboard_pages', 'qodef_re_add_owner_pages', 10, 2 );
}

if ( ! function_exists( 'qodef_re_update_owner_profile' ) ) {
	function qodef_re_update_owner_profile() {

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
					update_user_meta( $user_id, 'first_name', $update_data['first_name'] );
					update_user_meta( $user_id, 'last_name', $update_data['last_name'] );
					update_user_meta( $user_id, 'qodef_owner_telephone', $update_data['qodef_owner_telephone'] );
					update_user_meta( $user_id, 'qodef_owner_mobile_phone', $update_data['qodef_owner_mobile_phone'] );
					update_user_meta( $user_id, 'qodef_owner_fax_number', $update_data['qodef_owner_fax_number'] );
					update_user_meta( $user_id, 'qodef_owner_address', $update_data['qodef_owner_address'] );
					update_user_meta( $user_id, 'description', $update_data['description'] );
					
					//get media values (needed to be in input hidden because of the repeater values) - if empty then media is removed
					$owner_profile_image_db = $update_data['hidden_qodef_owner_profile_image'];
					
					if ($owner_profile_image_db == ''){
						update_user_meta( $user_id, 'qodef_owner_profile_image', '' );
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
								case 'qodef_owner_profile_image':
									update_user_meta( $user_id, 'qodef_owner_profile_image', $attachment_id );
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

	add_action( 'wp_ajax_qodef_re_update_owner_profile', 'qodef_re_update_owner_profile' );
}

if ( ! function_exists( 'qodef_re_get_owner_params' ) ) {
	/**
	 * Returns owner params
	 *
	 */
	function qodef_re_get_owner_params() {
		$params = array();

		$user_id = get_current_user_id();

		$params['first_name']  = get_the_author_meta( 'first_name', $user_id );
		$params['last_name']   = get_the_author_meta( 'last_name', $user_id );
		$params['email']       = get_the_author_meta('email', $user_id);
		$params['website']     = get_the_author_meta('url', $user_id);
		$params['description']  = get_user_meta($user_id, 'description', true);
		$params['qodef_owner_telephone']  = get_user_meta($user_id, 'qodef_owner_telephone', true);
		$params['qodef_owner_mobile_phone']  = get_user_meta($user_id, 'qodef_owner_mobile_phone', true);
		$params['qodef_owner_fax_number']  = get_user_meta($user_id, 'qodef_owner_fax_number', true);
		$params['qodef_owner_address']  = get_user_meta($user_id, 'qodef_owner_address', true);
		$params['qodef_owner_profile_image'] = get_user_meta($user_id, 'qodef_owner_profile_image', true);
		$profile_image			= get_user_meta($user_id, 'social_profile_image', true);
		
		if ( isset($params['qodef_owner_profile_image']) && $params['qodef_owner_profile_image'] !== '' ) {
			$profile_image = wp_get_attachment_image($params['qodef_owner_profile_image'],'thumbnail');
		} elseif ( $profile_image !== '' ) {
			$profile_image = '<img src="' . esc_url( $profile_image ) . '">';
		} else {
			$profile_image = get_avatar( $user_id, 96 );
		}
		$params['profile_image'] = $profile_image;

		return $params;
	}
}

if (! function_exists('qodef_re_get_user_owner_options')){
	function qodef_re_get_user_owner_options(){
		$owners_array = array();

		$owners = get_users(array('role' => 'owner'));

		foreach ($owners as $owner) {
			$owners_array[$owner->ID] = $owner->user_nicename;
		}

		return $owners_array;
	}
}