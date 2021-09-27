<?php

if ( ! function_exists('qodef_real_estate_options_map') ) {

	function qodef_real_estate_options_map() {

		bridge_qode_add_admin_page( array(
			'slug'  => '_real_estate',
			'title' =>  esc_html__('Real Estate', 'qode-real-estate'),
			'icon'  => 'fa fa-camera-retro'
		) );

        $panel_general = bridge_qode_add_admin_panel( array(
            'title' => 'General',
            'name'  => 'panel_terms',
            'page'  => '_real_estate'
        ) );

        bridge_qode_add_admin_field(
            array(
                'parent'		=> $panel_general,
                'type'			=> 'text',
                'name'			=> 'real_estate_item_terms_link',
                'default_value'	=> '',
                'label'			=> esc_html__('Terms And Conditions Page URL', 'qode-real-estate'),
                'description'   => esc_html__('Enter the page URL with terms and conditions.','qode-real-estate')
            )
        );

        /***************** Additional Page Layout - start *****************/

        do_action( 'bridge_qode_additional_real_estate_options_map', $panel_general );

        /***************** Additional Page Layout - end *****************/

	}

	add_action( 'bridge_qode_action_options_map', 'qodef_real_estate_options_map', 15);
}