<?php

if ( ! function_exists( 'qodef_re_map_package_meta' ) ) {
	function qodef_re_map_package_meta() {
		
		$meta_box = bridge_qode_create_meta_box(
			array(
				'scope' => 'package',
				'title' => esc_html__( 'Package Settings', 'qode-real-estate' ),
				'name'  => 'package_settings_meta_box'
			)
		);
		
		$package_general_container = bridge_qode_add_admin_container(
			array(
				'type'   => 'container',
				'name'   => 'package_general_container',
				'parent' => $meta_box
			)
		);
		
		bridge_qode_add_admin_section_title(
			array(
				'title'  => esc_html__( 'General', 'qode-real-estate' ),
				'name'   => 'property_general_container_title',
				'parent' => $package_general_container
			)
		);
		
		bridge_qode_create_meta_box_field(
			array(
				'name'          => 'qodef_package_unlimited_listings_meta',
				'type'          => 'yesno',
				'default_value' => 'no',
				'label'         => esc_html__( 'Unlimited Listings', 'qode-real-estate' ),
				'parent'        => $package_general_container
			)
		);
		
		bridge_qode_create_meta_box_field(
			array(
				'name'       => 'qodef_package_listings_included_meta',
				'type'       => 'text',
				'label'      => esc_html__( 'Number of Listings Included', 'qode-real-estate' ),
				'parent'     => $package_general_container,
				'args'       => array(
					'col_width' => 3
				),
				'dependency' => array(
					'hide' => array(
						'qodef_package_unlimited_listings_meta' => 'yes'
					)
				)
			)
		);
		
		bridge_qode_create_meta_box_field(
			array(
				'name'   => 'qodef_package_featured_listings_included_meta',
				'type'   => 'text',
				'label'  => esc_html__( 'Number of Featured Listings Included', 'qode-real-estate' ),
				'parent' => $package_general_container,
				'args'   => array(
					'col_width' => 3
				)
			)
		);
		
		bridge_qode_create_meta_box_field(
			array(
				'name'   => 'qodef_package_price_meta',
				'type'   => 'text',
				'label'  => esc_html__( 'Package Price', 'qode-real-estate' ),
				'parent' => $package_general_container,
				'args'   => array(
					'col_width' => 3
				)
			)
		);
		
		bridge_qode_create_meta_box_field(
			array(
				'name'          => 'qodef_package_featured_meta',
				'type'          => 'yesno',
				'label'         => esc_html__( 'Featured Package', 'qode-real-estate' ),
				'default_value' => 'no',
				'parent'        => $package_general_container
			)
		);
		
		bridge_qode_create_meta_box_field(
			array(
				'name'        => 'qodef_package_duration_meta',
				'type'        => 'text',
				'default'     => '12',
				'label'       => esc_html__( 'Package Duration (months)', 'qode-real-estate' ),
				'description' => esc_html__( 'Enter how many months the package lasts. Default is 12.', 'qode-real-estate' ),
				'parent'      => $package_general_container,
				'args'        => array(
					'col_width' => 3
				)
			)
		);

        bridge_qode_add_admin_section_title(array(
            'title'           => esc_html__('Package Custom Features', 'qode-real-estate'),
            'name'            => 'package_custom_features',
            'parent'          => $package_general_container
        ));

        bridge_qode_add_repeater_field(
            array(
                'name'        => 'qodef_package_custom_features_meta',
                'parent'      => $package_general_container,
                'button_text' => '',
                'fields'      => array_merge(
                    array(
                        array(
                            'type'        => 'text',
                            'name'        => 'custom_feature_label',
                            'label'       => esc_html__('Custom Feature', 'qode-real-estate'),
                        )
                    )
                )
            )
        );
	}
	
	add_action( 'bridge_qode_action_meta_boxes_map', 'qodef_re_map_package_meta' );
}