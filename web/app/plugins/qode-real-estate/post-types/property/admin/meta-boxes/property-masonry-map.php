<?php
if(!function_exists('qodef_re_map_property_masonry_meta')) {
    function qodef_re_map_property_masonry_meta($meta_box) {

        $property_masonry_container = bridge_qode_add_admin_container(array(
            'type'            => 'container',
            'name'            => 'property_masonry_container',
            'parent'          => $meta_box
        ));

        bridge_qode_add_admin_section_title(array(
            'title'           => esc_html__('List Shortcode', 'qode-real-estate'),
            'name'            => 'property_masonry_container_title',
            'parent'          => $property_masonry_container
        ));

        bridge_qode_create_meta_box_field(
            array(
                'name'        => 'qodef_property_featured_image_meta',
                'type'        => 'image',
                'label'       => esc_html__( 'Featured Image', 'qode-real-estate' ),
                'description' => esc_html__( 'Choose an image for Property Lists shortcodes', 'qode-real-estate' ),
                'parent'      => $property_masonry_container
            )
        );

        bridge_qode_create_meta_box_field(
            array(
                'name'          => 'qodef_property_masonry_fixed_dimensions_meta',
                'type'          => 'select',
                'label'         => esc_html__( 'Dimensions for Masonry - Image Fixed Proportion', 'qode-real-estate' ),
                'description'   => esc_html__( 'Choose image layout when it appears in Masonry type property lists where image proportion is fixed', 'qode-real-estate' ),
                'default_value' => 'default',
                'parent'        => $property_masonry_container,
                'options'       => array(
                    'default'            => esc_html__( 'Default', 'qode-real-estate' ),
                    'large-width'        => esc_html__( 'Large Width', 'qode-real-estate' ),
                    'large-height'       => esc_html__( 'Large Height', 'qode-real-estate' ),
                    'large-width-height' => esc_html__( 'Large Width/Height', 'qode-real-estate' )
                )
            )
        );

        bridge_qode_create_meta_box_field(
            array(
                'name'          => 'qodef_property_masonry_original_dimensions_meta',
                'type'          => 'select',
                'label'         => esc_html__( 'Dimensions for Masonry - Image Original Proportion', 'qode-real-estate' ),
                'description'   => esc_html__( 'Choose image layout when it appears in Masonry type property lists where image proportion is original', 'qode-real-estate' ),
                'default_value' => 'default',
                'parent'        => $property_masonry_container,
                'options'       => array(
                    'default'     => esc_html__( 'Default', 'qode-real-estate' ),
                    'large-width' => esc_html__( 'Large Width', 'qode-real-estate' )
                )
            )
        );

        bridge_qode_add_admin_section_title(array(
            'title'           => esc_html__('Property List Features', 'qode-real-estate'),
            'name'            => 'property_list_features',
            'parent'          => $property_masonry_container
        ));

        bridge_qode_add_repeater_field(
            array(
                'name'        => 'qodef_property_list_features_meta',
                'parent'      => $property_masonry_container,
                'button_text' => '',
                'fields'      => array_merge(
                    array(
                        array(
                            'type'        => 'image',
                            'name'        => 'image',
                            'label'       => esc_html__('Image', 'qode-real-estate'),
                            'col_width'   => '6'
                        ),
                        array(
                            'type'        => 'text',
                            'name'        => 'value',
                            'label'       => esc_html__('Value', 'qode-real-estate'),
                            'col_width'   => '6'
                        )
                    )
                )
            )
        );
    }

    add_action('qodef_re_action_property_meta_fields', 'qodef_re_map_property_masonry_meta', 17, 1);
}