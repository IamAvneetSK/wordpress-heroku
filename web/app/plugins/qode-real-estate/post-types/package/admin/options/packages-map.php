<?php

if ( ! function_exists( 'qodef_real_estate_packages_options_map' ) ) {

	function qodef_real_estate_packages_options_map() {
		$pages       = get_all_page_ids();
		$pages_array = array();
		foreach ( $pages as $page ) {
			if ( get_post_status( $page ) == 'publish' ) {
				$pages_array[ $page ] = get_the_title( $page );
			}
		}
		
		$panel_packages = bridge_qode_add_admin_panel(
			array(
				'title' => esc_html__( 'Pricing Packages', 'qode-real-estate' ),
				'name'  => 'panel_packages',
				'page'  => '_real_estate'
			)
		);
		
		bridge_qode_add_admin_field(
			array(
				'name'          => 'enable_packages_necessity',
				'type'          => 'yesno',
				'default_value' => 'yes',
				'label'         => esc_html__( 'Enable Pricing Package Necessity for Adding Property', 'qode-real-estate' ),
				'description'   => esc_html__( 'Enable this option in order to make packages necessary for adding property', 'qode-real-estate' ),
				'parent'        => $panel_packages,
                'args'          => array(
                    "dependence"             => true,
                    "dependence_hide_on_yes" => "",
                    "dependence_show_on_yes" => "#qodef_enabled_package"
                )
			)
		);
		
		$enabled_package_container = bridge_qode_add_admin_container(
			array(
				'parent'     => $panel_packages,
				'name'       => 'enabled_package',
                'hidden_property' => 'enable_packages_necessity',
                'hidden_value'    => 'no'
			)
		);
		
		bridge_qode_add_admin_field(
			array(
				'name'        => 'packages_default_page',
				'type'        => 'select',
				'label'       => esc_html__( 'Pricing Packages Page', 'qode-real-estate' ),
				'description' => esc_html__( 'Choose a page to be default for displaying pricing packages. (You should add pricing package shortcode on that page)', 'qode-real-estate' ),
				'parent'      => $enabled_package_container,
				'options'     => $pages_array,
				'args'        => array(
					'select2' => true
				)
			)
		);

        bridge_qode_add_admin_field(
            array(
                'name'          => 'enable_payment_autocomplete',
                'type'          => 'yesno',
                'label'         => esc_html__( 'Payment Autocomplete', 'qode-real-estate' ),
                'parent'        => $enabled_package_container,
                'default_value' => 'no',
                'description'	=> esc_html__('Use this option if your are using non-card payment methods to enable autocomplete of user purchases.','qode-real-estate')
            )
        );
	}
	
	add_action( 'bridge_qode_additional_real_estate_options_map', 'qodef_real_estate_packages_options_map', 14 );
}