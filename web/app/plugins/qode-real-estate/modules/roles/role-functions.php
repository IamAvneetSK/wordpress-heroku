<?php

if(!function_exists('qodef_re_include_roles_files')) {
	/**
	 * Loads all roles types by going through all folders that are placed directly in roles folder
	 */
	function qodef_re_include_roles_files() {
		if(qodef_re_theme_installed()) {
			foreach (glob(QODE_RE_MODULE_PATH . '/roles/*/load.php') as $role_load) {
				include_once $role_load;
			}
		}
	}

	add_action('after_setup_theme', 'qodef_re_include_roles_files', 1);
}

if(!function_exists('qodef_re_include_roles_register_files')) {
	/**
	 * Loads all roles types by going through all folders that are placed directly in roles folder
	 */
	function qodef_re_include_roles_register_files() {
		if(qodef_re_theme_installed()) {
			foreach (glob(QODE_RE_MODULE_PATH . '/roles/*/role-register.php') as $role_load) {
				include_once $role_load;
			}
		}
	}

    register_activation_hook(QODE_RE_ABS_PATH . '/main.php', 'qodef_re_include_roles_register_files');
    register_deactivation_hook(QODE_RE_ABS_PATH . '/main.php', 'qodef_re_include_roles_register_files' );
}

if(!function_exists('qodef_re_add_user_roles')) {
    function qodef_re_add_user_roles() {
        do_action('qodef_re_user_role_add');
    }

    register_activation_hook(QODE_RE_ABS_PATH . '/main.php', 'qodef_re_add_user_roles');
}

if(!function_exists( 'qodef_re_remove_user_roles' )) {
    function qodef_re_remove_user_roles() {
        do_action('qodef_re_user_role_remove');
    }
    register_deactivation_hook(QODE_RE_ABS_PATH . '/main.php', 'qodef_re_remove_user_roles' );
}

if(!function_exists('qodef_re_real_estate_role_called')) {
    function qodef_re_real_estate_role_called() {
        $re_role_called = false;
        if(is_author()) {
            $author = get_user_by( 'slug', get_query_var( 'author_name' ) );
            $roles = $author->roles;
            if(in_array('agent', $roles) || in_array('agency', $roles) || in_array('owner', $roles)) {
                $re_role_called = true;
            }
        }

        return $re_role_called;
    }
}

// Load Roles shortcodes
if(!function_exists('qodef_re_include_roles_shortcodes_file')) {
    /**
     * Loades all shortcodes by going through all folders that are placed directly in shortcodes folder
     */
    function qodef_re_include_roles_shortcodes_file() {
        foreach(glob(QODE_RE_MODULE_PATH.'/roles/shortcodes/*/load.php') as $shortcode_load) {
            include_once $shortcode_load;
        }
    }

    add_action('qodef_re_action_include_shortcodes_file', 'qodef_re_include_roles_shortcodes_file');
}

if(!function_exists('qodef_re_user_registration_role_picker')) {
    function qodef_re_user_registration_role_picker() {
        $role_enabled = bridge_qode_options()->getOptionValue('real_estate_registration_role_enabled');
        if($role_enabled) {
            $owner_enabled = bridge_qode_options()->getOptionValue('real_estate_enable_owner_role');
            $agent_enabled = bridge_qode_options()->getOptionValue('real_estate_enable_agent_role');
            $agency_enabled = bridge_qode_options()->getOptionValue('real_estate_enable_agency_role');

            $owner_enabled = !empty($owner_enabled) && $owner_enabled === 'yes';
            $agent_enabled = !empty($agent_enabled) && $agent_enabled === 'yes';
            $agency_enabled = !empty($agency_enabled) && $agency_enabled === 'yes';
            $params = array(
                'owner_enabled' => $owner_enabled,
                'agent_enabled' => $agent_enabled,
                'agency_enabled' => $agency_enabled
            );
            if($owner_enabled || $agency_enabled || $agency_enabled) {
                echo qodef_re_get_module_template_part('roles/templates/role-selector', '', $params);
            }
        }
    }

    add_action('qode_membership_additional_registration_field', 'qodef_re_user_registration_role_picker');
}

if(!function_exists('qodef_re_user_registration_additional_params')) {
    function qodef_re_user_registration_additional_params($additional_params, $login_data) {
        if(isset($login_data) && !empty($login_data)) {
            if(isset($login_data['user_register_role'])) {
                $additional_params['role'] = $login_data['user_register_role'];
            }
        }

        return $additional_params;
    }

    add_filter('qode_membership_additional_registration_params', 'qodef_re_user_registration_additional_params', 10, 2);
}

if(!function_exists('qodef_re_adjust_woo_settings')) {
    function qodef_re_adjust_woo_settings() {
        update_option('woocommerce_enable_guest_checkout', 'no');
    }

    add_action('woocommerce_installed', 'qodef_re_adjust_woo_settings');
}