<?php

if ( ! function_exists('qodef_real_estate_slug_options_map') ) {

    function qodef_real_estate_slug_options_map() {

        $panel_slug = bridge_qode_add_admin_panel( array(
            'title' => esc_html__('Slug', 'qode-real-estate'),
            'name'  => 'panel_slug',
            'page'  => '_real_estate'
        ) );

        bridge_qode_add_admin_field(
            array(
                'parent'		=> $panel_slug,
                'type'			=> 'text',
                'name'			=> 'property_single_slug',
                'default_value'	=> '',
                'label'			=> esc_html__('Single Property Slug', 'qode-real-estate'),
                'description'   => esc_html__('Enter the slug for single property pages.','qode-real-estate'),
                'args'          => array(
                    'col_width' => 3
                )
            )
        );

        bridge_qode_add_admin_field(
            array(
                'parent'		=> $panel_slug,
                'type'			=> 'text',
                'name'			=> 'property_types_slug',
                'default_value'	=> '',
                'label'			=> esc_html__('Property Type Slug', 'qode-real-estate'),
                'description'   => esc_html__('Enter the slug for property type archive pages.','qode-real-estate'),
                'args'          => array(
                    'col_width' => 3
                )
            )
        );

        bridge_qode_add_admin_field(
            array(
                'parent'		=> $panel_slug,
                'type'			=> 'text',
                'name'			=> 'property_features_slug',
                'default_value'	=> '',
                'label'			=> esc_html__('Property Feature Slug', 'qode-real-estate'),
                'description'   => esc_html__('Enter the slug for property features archive pages.','qode-real-estate'),
                'args'          => array(
                    'col_width' => 3
                )
            )
        );

        bridge_qode_add_admin_field(
            array(
                'parent'		=> $panel_slug,
                'type'			=> 'text',
                'name'			=> 'property_status_slug',
                'default_value'	=> '',
                'label'			=> esc_html__('Property Status Slug', 'qode-real-estate'),
                'description'   => esc_html__('Enter the slug for property status archive pages.','qode-real-estate'),
                'args'          => array(
                    'col_width' => 3
                )
            )
        );

        bridge_qode_add_admin_field(
            array(
                'parent'		=> $panel_slug,
                'type'			=> 'text',
                'name'			=> 'property_county_slug',
                'default_value'	=> '',
                'label'			=> esc_html__('Property County/State Slug', 'qode-real-estate'),
                'description'   => esc_html__('Enter the slug for property county/state archive pages.','qode-real-estate'),
                'args'          => array(
                    'col_width' => 3
                )
            )
        );

        bridge_qode_add_admin_field(
            array(
                'parent'		=> $panel_slug,
                'type'			=> 'text',
                'name'			=> 'property_city_slug',
                'default_value'	=> '',
                'label'			=> esc_html__('Property City Slug', 'qode-real-estate'),
                'description'   => esc_html__('Enter the slug for property city archive pages.','qode-real-estate'),
                'args'          => array(
                    'col_width' => 3
                )
            )
        );

        bridge_qode_add_admin_field(
            array(
                'parent'		=> $panel_slug,
                'type'			=> 'text',
                'name'			=> 'property_neighborhood_slug',
                'default_value'	=> '',
                'label'			=> esc_html__('Property Neighborhood Slug', 'qode-real-estate'),
                'description'   => esc_html__('Enter the slug for property neighborhood archive pages.','qode-real-estate'),
                'args'          => array(
                    'col_width' => 3
                )
            )
        );
    }

    add_action( 'bridge_qode_additional_real_estate_options_map', 'qodef_real_estate_slug_options_map', 10);
}