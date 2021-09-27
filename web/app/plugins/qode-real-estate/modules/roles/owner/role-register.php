<?php

if(!function_exists('qodef_re_add_user_owner_role')) {
    function qodef_re_add_user_owner_role() {
        $capabilities = array(
            'read' => true,
            'edit_posts' => true,
            'edit_pages' => false,
            'edit_others_posts' => false,
            'create_posts' => true,
            'manage_categories' => false,
            'publish_posts' => true,
            'edit_themes' => false,
            'install_plugins' => false,
            'update_plugin' => false,
            'update_core' => false,
            'upload_files' => false,
            'edit_files' => false,
            'assign_terms' => true
        );
        add_role( 'owner', esc_html__('Owner/Buyer', 'qode-real-estate'), $capabilities);
        update_option('default_role', 'owner');
    }

    add_action('qodef_re_user_role_add', 'qodef_re_add_user_owner_role');
}
if(!function_exists( 'qodef_re_remove_user_owner_role' )) {
    function qodef_re_remove_user_owner_role() {
        remove_role( 'owner' );
        update_option('default_role', 'subscriber');
    }
    add_action('qodef_re_user_role_remove', 'qodef_re_remove_user_owner_role' );
}
