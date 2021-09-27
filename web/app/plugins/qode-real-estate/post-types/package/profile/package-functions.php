<?php

if ( ! function_exists( 'qodef_re_add_package_profile_navigation_item' ) ) {
    function qodef_re_add_package_profile_navigation_item( $navigation, $dashboard_url ) {

        $navigation['user-packages'] = array(
            'url'         => esc_url( add_query_arg( array( 'user-action' => 'user-packages' ), $dashboard_url ) ),
            'text'        => esc_html__( 'My Packages', 'qode-real-estate' ),
            'user_action' => 'user-packages',
            'icon'          => '<span class="lnr lnr-briefcase"></span>'
        );

        return $navigation;
    }

    add_filter( 'qode_membership_dashboard_navigation_pages', 'qodef_re_add_package_profile_navigation_item', 10, 2 );
}

if ( ! function_exists( 'qodef_re_add_package_profile_navigation_pages' ) ) {
    function qodef_re_add_package_profile_navigation_pages( $pages, $action ) {

        if( $action == 'user-packages' ) {
            $package_params = array();
            $user_packages = qodef_re_get_user_packages_list();
            $package_url = qodef_re_get_pricing_packages_page();
            $package_params['user_packages'] = $user_packages;
            $package_params['package_url'] = $package_url;
            $pages['user-packages'] = qodef_re_cpt_single_module_template_part('profile/templates/user-packages', 'package', '', $package_params);
        }

        return $pages;
    }

    add_filter( 'qode_membership_dashboard_pages', 'qodef_re_add_package_profile_navigation_pages', 10, 2 );
}