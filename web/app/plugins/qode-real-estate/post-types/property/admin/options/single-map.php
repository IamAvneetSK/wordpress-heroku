<?php

if ( ! function_exists( 'qodef_real_estate_single_options_map' ) ) {
	function qodef_real_estate_single_options_map() {
		
		$panel_single = bridge_qode_add_admin_panel(
			array(
				'title' => esc_html__( 'Single', 'qode-real-estate' ),
				'name'  => 'panel_single',
				'page'  => '_real_estate'
			)
		);

        bridge_qode_add_admin_field(
            array(
                'type'          => 'select',
                'name'          => 'property_single_layout',
                'default_value' => 'advanced',
                'label'         => esc_html__( 'Single Property Layout', 'qode-real-estate' ),
                'description'   => esc_html__( 'Choose default layout for your single property page', 'qode-real-estate' ),
                'parent'        => $panel_single,
                'options'       => array(
                    'advanced' => esc_html__( 'Advanced Gallery', 'qode-real-estate' ),
                    'thumbnails'  => esc_html__( 'Gallery with Thumbnails', 'qode-real-estate' )
                ),
                'args'          => array(
                    'col_width' => 3
                )
            )
        );
		
		bridge_qode_add_admin_field(
			array(
				'type'          => 'select',
				'name'          => 'show_title_area_property_single',
				'default_value' => '',
				'label'         => esc_html__( 'Show Title Area', 'qode-real-estate' ),
				'description'   => esc_html__( 'Enabling this option will show title area on single properties', 'qode-real-estate' ),
				'parent'        => $panel_single,
				'options'       => array(
					''    => esc_html__( 'Default', 'qode-real-estate' ),
					'yes' => esc_html__( 'Yes', 'qode-real-estate' ),
					'no'  => esc_html__( 'No', 'qode-real-estate' )
				),
				'args'          => array(
					'col_width' => 3
				)
			)
		);
		
		bridge_qode_add_admin_field(
			array(
				'type'          => 'text',
				'name'          => 'content_top_padding_property_single',
				'default_value' => '',
				'label'         => esc_html__( 'Content Top Padding for Single Property', 'qode-real-estate' ),
				'description'   => esc_html__( 'Enter top padding for content area for single property page', 'qode-real-estate' ),
				'args'          => array(
					'suffix'    => 'px',
					'col_width' => 3
				),
				'parent'        => $panel_single
			)
		);
		
		bridge_qode_add_admin_field(
			array(
				'name'          => 'property_single_sidebar_layout',
				'type'          => 'select',
				'label'         => esc_html__( 'Sidebar Layout', 'qode-real-estate' ),
				'description'   => esc_html__( 'Choose a sidebar layout for single property page', 'qode-real-estate' ),
				'default_value' => '',
				'parent'        => $panel_single,
				'options'       => array(
				    "default" => esc_html__("No Sidebar", "bridge"),
                    "1" => esc_html__("Sidebar 1/3 right", "bridge"),
                    "2" => esc_html__("Sidebar 1/4 right", "bridge")
                )
			)
		);
		
		$realestator_custom_sidebars = bridge_qode_get_custom_sidebars();
		if ( count( $realestator_custom_sidebars ) > 0 ) {
			bridge_qode_add_admin_field( array(
				'name'        => 'property_custom_sidebar_area',
				'type'        => 'selectblank',
				'label'       => esc_html__( 'Sidebar to Display', 'qode-real-estate' ),
				'description' => esc_html__( 'Choose a sidebar to display on single properties. Default sidebar is "Sidebar"', 'qode-real-estate' ),
				'parent'      => $panel_single,
				'options'     => $realestator_custom_sidebars,
				'args'        => array(
					'select2' => true
				)
			) );
		}
		
		bridge_qode_add_admin_field(
			array(
				'name'          => 'property_single_comments',
				'type'          => 'yesno',
				'default_value' => 'yes',
				'label'         => esc_html__( 'Show Comments', 'qode-real-estate' ),
				'description'   => esc_html__( 'Enabling this option will show comments on your property', 'qode-real-estate' ),
				'parent'        => $panel_single
			)
		);
		
		bridge_qode_add_admin_field(
			array(
				'name'          => 'property_single_show_related',
				'type'          => 'yesno',
				'default_value' => 'yes',
				'label'         => esc_html__( 'Show Related', 'qode-real-estate' ),
				'description'   => esc_html__( 'Enabling this option will show related properties on your property', 'qode-real-estate' ),
				'parent'        => $panel_single,
                'args'          => array(
                    "dependence"             => true,
                    "dependence_hide_on_yes" => "",
                    "dependence_show_on_yes" => "#qodef_property_related_posts_settings_container"
                )
			)
		);
		
		$related_posts_settings_container = bridge_qode_add_admin_container(
			array(
				'type'       => 'container',
				'name'       => 'property_related_posts_settings_container',
				'parent'     => $panel_single,
                'hidden_property' => 'property_single_show_related',
                'hidden_value'    => 'no'
			)
		);
		
		bridge_qode_add_admin_field(
			array(
				'name'          => 'real_estate_related_posts_number_of_columns',
				'type'          => 'select',
				'label'         => esc_html__( 'Number of Columns', 'qode-real-estate' ),
				'default_value' => '3',
				'description'   => esc_html__( 'Set number of columns for your related properties on single property page. Default value is 4 columns', 'qode-real-estate' ),
				'parent'        => $related_posts_settings_container,
				'options'       => array(
					'2' => esc_html__( '2 Columns', 'qode-real-estate' ),
					'3' => esc_html__( '3 Columns', 'qode-real-estate' ),
					'4' => esc_html__( '4 Columns', 'qode-real-estate' ),
					'5' => esc_html__( '5 Columns', 'qode-real-estate' )
				)
			)
		);
		
		bridge_qode_add_admin_field(
			array(
				'name'          => 'real_estate_related_posts_space_between_items',
				'type'          => 'select',
				'label'         => esc_html__( 'Space Between Items', 'qode-real-estate' ),
				'default_value' => 'medium',
				'description'   => esc_html__( 'Set space size between property items for your related properties on single property page. Default value is normal', 'qode-real-estate' ),
				'parent'        => $related_posts_settings_container,
				'options'       => bridge_qode_get_space_between_items_array()
			)
		);
		
		bridge_qode_add_admin_field(
			array(
				'name'          => 'real_estate_related_posts_image_size',
				'type'          => 'select',
				'label'         => esc_html__( 'Image Proportions', 'qode-real-estate' ),
				'default_value' => 'full',
				'description'   => esc_html__( 'Set image proportions for your property items on single property page. Default value is full', 'qode-real-estate' ),
				'parent'        => $related_posts_settings_container,
				'options'       => array(
					'full'      => esc_html__( 'Original', 'qode-real-estate' ),
					'landscape' => esc_html__( 'Landscape', 'qode-real-estate' ),
					'portrait'  => esc_html__( 'Portrait', 'qode-real-estate' ),
					'square'    => esc_html__( 'Square', 'qode-real-estate' )
				)
			)
		);
		
		bridge_qode_add_admin_field(
			array(
				'parent'        => $panel_single,
				'type'          => 'yesno',
				'default_value' => 'yes',
				'name'          => 'real_estate_content_bottom',
				'label'         => esc_html__( 'Enable content bottom area', 'qode-real-estate' )
			)
		);
		
		bridge_qode_add_admin_field(
			array(
				'name'        => 'property_price_label',
				'type'        => 'text',
				'label'       => esc_html__( 'Price Label', 'qode-real-estate' ),
				'description' => esc_html__( 'Text that will be shown next to price value', 'qode-real-estate' ),
				'parent'      => $panel_single,
				'args'        => array(
					'col_width' => 3
				)
			)
		);
		
		bridge_qode_add_admin_field(
			array(
				'name'        => 'property_price_label_position',
				'type'        => 'select',
				'label'       => esc_html__( 'Price Label Position', 'qode-real-estate' ),
				'description' => esc_html__( 'Chose whether price label will be shown before or after price value', 'qode-real-estate' ),
				'parent'      => $panel_single,
				'options'     => array(
					''       => esc_html__( 'Default', 'qode-real-estate' ),
					'before' => esc_html__( 'Before Price', 'qode-real-estate' ),
					'after'  => esc_html__( 'After Price', 'qode-real-estate' )
				)
			)
		);
		
		bridge_qode_add_admin_field(
			array(
				'name'        => 'property_size_label',
				'type'        => 'text',
				'label'       => esc_html__( 'Size Label', 'qode-real-estate' ),
				'description' => esc_html__( 'Text that will be shown next to size value', 'qode-real-estate' ),
				'parent'      => $panel_single,
				'args'        => array(
					'col_width' => 3
				)
			)
		);
		
		bridge_qode_add_admin_field(
			array(
				'name'        => 'property_size_label_position',
				'type'        => 'select',
				'label'       => esc_html__( 'Size Label Position', 'qode-real-estate' ),
				'description' => esc_html__( 'Chose whether size label will be shown before or after size value', 'qode-real-estate' ),
				'parent'      => $panel_single,
				'options'     => array(
					''       => esc_html__( 'Default', 'qode-real-estate' ),
					'before' => esc_html__( 'Before Value', 'qode-real-estate' ),
					'after'  => esc_html__( 'After Value', 'qode-real-estate' )
				)
			)
		);
		
		bridge_qode_add_admin_field(
			array(
				'name'        => 'property_enquiry_button_text',
				'type'        => 'text',
				'label'       => esc_html__( 'Enquiry Button Text', 'qode-real-estate' ),
				'description' => esc_html__( 'Text that will be shown on button for sending enquiry message. Default is Schedule Watching', 'qode-real-estate' ),
				'parent'      => $panel_single,
				'args'        => array(
					'col_width' => 3
				)
			)
		);
		
		bridge_qode_add_admin_field(
			array(
				'name'        => 'property_success_message_text',
				'type'        => 'text',
				'label'       => esc_html__( 'Success Message Text', 'qode-real-estate' ),
				'description' => esc_html__( 'Text that will be shown after sending enquiry message from single property.', 'qode-real-estate' ),
				'parent'      => $panel_single,
				'args'        => array(
					'col_width' => 3
				)
			)
		);
		
		bridge_qode_add_admin_field(
			array(
				'name'        => 'property_fail_message_text',
				'type'        => 'text',
				'label'       => esc_html__( 'Fail Message Text', 'qode-real-estate' ),
				'description' => esc_html__( 'Text that will be shown if sending enquiry message fails.', 'qode-real-estate' ),
				'parent'      => $panel_single,
				'args'        => array(
					'col_width' => 3
				)
			)
		);
	}
	
	add_action( 'bridge_qode_additional_real_estate_options_map', 'qodef_real_estate_single_options_map', 11 );
}