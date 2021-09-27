<?php

if ( ! function_exists( 'qodef_real_estate_compare_options_map' ) ) {
    function qodef_real_estate_compare_options_map($panel_general) {

        bridge_qode_add_admin_field(
            array(
                'type'          => 'yesno',
                'name'          => 'enable_property_comparing',
                'default_value' => 'no',
                'label'         => esc_html__( 'Enable property comparing', 'qode-real-estate' ),
                'description'   => esc_html__( 'Enabling this option will enable comparison between properties', 'qode-real-estate' ),
                'parent'        => $panel_general,
                'args'          => array(
                    'col_width' => 3,
                    "dependence"             => true,
                    "dependence_hide_on_yes" => "",
                    "dependence_show_on_yes" => "#qodef_qodef_re_compare_single_container"
                )
            )
        );
	
	    $compare_single_container = bridge_qode_add_admin_container(
		    array(
			    'name'            => 'qodef_re_compare_single_container',
			    'parent'          => $panel_general,
                'hidden_property' => 'enable_property_comparing',
                'hidden_value'    => 'no'
		    )
	    );
	
	    bridge_qode_add_admin_field(
		    array(
			    'type'          => 'yesno',
			    'name'          => 'enable_property_comparing_single',
			    'default_value' => 'no',
			    'label'         => esc_html__( 'Compare on Single Property', 'qode-real-estate' ),
			    'description'   => esc_html__( 'Enabling this option will display compare button on single property page', 'qode-real-estate' ),
			    'parent'        => $compare_single_container,
			    'args'          => array(
				    'col_width' => 3
			    )
		    )
	    );
    }

    add_action( 'bridge_qode_additional_real_estate_options_map', 'qodef_real_estate_compare_options_map', 11, 1 );
}