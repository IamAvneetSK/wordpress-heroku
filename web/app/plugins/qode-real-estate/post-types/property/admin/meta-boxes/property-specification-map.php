<?php
if(!function_exists('qodef_re_map_property_specifictation_meta')) {
    function qodef_re_map_property_specifictation_meta($meta_box) {

        $property_specification_container = bridge_qode_add_admin_container(array(
            'type'            => 'container',
            'name'            => 'property_specification_container',
            'parent'          => $meta_box
        ));

        bridge_qode_add_admin_section_title(array(
            'title'           => esc_html__('Specification', 'qode-real-estate'),
            'name'            => 'property_specification_container_title',
            'parent'          => $property_specification_container
        ));

        bridge_qode_create_meta_box_field(array(
            'name'        => 'qodef_property_id_meta',
            'type'        => 'text',
            'label'       => esc_html__('Property ID', 'qode-real-estate'),
            'parent'      => $property_specification_container,
            'args'        => array(
                'col_width' => 3
            )
        ));

        bridge_qode_create_meta_box_field(array(
            'name'        => 'qodef_property_price_meta',
            'type'        => 'text',
            'label'       => esc_html__('Price', 'qode-real-estate'),
            'description' => esc_html__('Sale or Rent price', 'qode-real-estate'),
            'parent'      => $property_specification_container,
            'args'        => array(
                'col_width' => 3
            )
        ));

        bridge_qode_create_meta_box_field(array(
            'name'        => 'qodef_property_discount_price_meta',
            'type'        => 'text',
            'label'       => esc_html__('Discount Price', 'qode-real-estate'),
            'description' => esc_html__('Sale or rent discount price', 'qode-real-estate'),
            'parent'      => $property_specification_container,
            'args'        => array(
                'col_width' => 3
            )
        ));

        bridge_qode_create_meta_box_field(array(
            'name'        => 'property_price_label_meta',
            'type'        => 'text',
            'label'       => esc_html__('Price Label', 'qode-real-estate'),
            'description' => esc_html__('Text that will be shown next to price value', 'qode-real-estate'),
            'parent'      => $property_specification_container,
            'args'        => array(
                'col_width' => 3
            )
        ));

        bridge_qode_create_meta_box_field(array(
            'name'        => 'property_price_label_position_meta',
            'type'        => 'select',
            'label'       => esc_html__('Price Label Position', 'qode-real-estate'),
            'description' => esc_html__('Chose whether price label will be shown before or after price value', 'qode-real-estate'),
            'parent'      => $property_specification_container,
            'options'     => array(
                ''          => esc_html__( 'Default', 'qode-real-estate' ),
                'before'    => esc_html__( 'Before Price', 'qode-real-estate' ),
                'after'     => esc_html__( 'After Price', 'qode-real-estate' )
            )
        ));

        bridge_qode_create_meta_box_field(array(
            'name'        => 'qodef_property_size_meta',
            'type'        => 'text',
            'label'       => esc_html__('Size', 'qode-real-estate'),
            'description' => esc_html__('Enter property size', 'qode-real-estate'),
            'parent'      => $property_specification_container,
            'args'        => array(
                'col_width' => 3
            )
        ));

        bridge_qode_create_meta_box_field(array(
            'name'        => 'property_size_label_meta',
            'type'        => 'text',
            'label'       => esc_html__('Size Label', 'qode-real-estate'),
            'description' => esc_html__('Text that will be shown next to size value', 'qode-real-estate'),
            'parent'      => $property_specification_container,
            'args'        => array(
                'col_width' => 3
            )
        ));

        bridge_qode_create_meta_box_field(array(
            'name'        => 'property_size_label_position_meta',
            'type'        => 'select',
            'label'       => esc_html__('Size Label Position', 'qode-real-estate'),
            'description' => esc_html__('Chose whether size label will be shown before or after size value', 'qode-real-estate'),
            'parent'      => $property_specification_container,
            'options'     => array(
                ''          => esc_html__( 'Default', 'qode-real-estate' ),
                'before'    => esc_html__( 'Before Value', 'qode-real-estate' ),
                'after'     => esc_html__( 'After Value', 'qode-real-estate' )
            )
        ));

        bridge_qode_create_meta_box_field(array(
            'name'        => 'qodef_property_bedrooms_meta',
            'type'        => 'text',
            'label'       => esc_html__('Bedrooms', 'qode-real-estate'),
            'parent'      => $property_specification_container,
            'args'        => array(
                'col_width' => 3
            )
        ));

        bridge_qode_create_meta_box_field(array(
            'name'        => 'qodef_property_bathrooms_meta',
            'type'        => 'text',
            'label'       => esc_html__('Bathrooms', 'qode-real-estate'),
            'parent'      => $property_specification_container,
            'args'        => array(
                'col_width' => 3
            )
        ));

        bridge_qode_create_meta_box_field(array(
            'name'        => 'qodef_property_floor_meta',
            'type'        => 'text',
            'label'       => esc_html__('Floor', 'qode-real-estate'),
            'parent'      => $property_specification_container,
            'args'        => array(
                'col_width' => 3
            )
        ));

        bridge_qode_create_meta_box_field(array(
            'name'        => 'qodef_property_total_floors_meta',
            'type'        => 'text',
            'label'       => esc_html__('Total Floors', 'qode-real-estate'),
            'parent'      => $property_specification_container,
            'args'        => array(
                'col_width' => 3
            )
        ));

        bridge_qode_create_meta_box_field(array(
            'name'        => 'qodef_property_year_built_meta',
            'type'        => 'text',
            'label'       => esc_html__('Year Built', 'qode-real-estate'),
            'parent'      => $property_specification_container,
            'args'        => array(
                'col_width' => 3
            )
        ));

        bridge_qode_create_meta_box_field(array(
            'name'        => 'qodef_property_heating_meta',
            'type'        => 'text',
            'label'       => esc_html__('Heating', 'qode-real-estate'),
            'parent'      => $property_specification_container,
            'args'        => array(
                'col_width' => 3
            )
        ));

        bridge_qode_create_meta_box_field(array(
            'name'        => 'qodef_property_accommodation_meta',
            'type'        => 'text',
            'label'       => esc_html__('Accommodation', 'qode-real-estate'),
            'parent'      => $property_specification_container,
            'args'        => array(
                'col_width' => 3
            )
        ));

        bridge_qode_add_admin_section_title(array(
            'title'           => esc_html__('Additional Specification', 'qode-real-estate'),
            'name'            => 'property_additional_specification_container_title',
            'parent'          => $property_specification_container
        ));

        bridge_qode_create_meta_box_field(array(
            'name'        => 'qodef_property_ceiling_height_meta',
            'type'        => 'text',
            'label'       => esc_html__('Ceiling Height', 'qode-real-estate'),
            'parent'      => $property_specification_container,
            'args'        => array(
                'col_width' => 3
            )
        ));

        bridge_qode_create_meta_box_field(array(
            'name'        => 'qodef_property_parking_meta',
            'type'        => 'text',
            'label'       => esc_html__('Parking', 'qode-real-estate'),
            'parent'      => $property_specification_container,
            'args'        => array(
                'col_width' => 3
            )
        ));

        bridge_qode_create_meta_box_field(array(
            'name'        => 'qodef_property_from_center_meta',
            'type'        => 'text',
            'label'       => esc_html__('Distance From the Center', 'qode-real-estate'),
            'parent'      => $property_specification_container,
            'args'        => array(
                'col_width' => 3
            )
        ));

        bridge_qode_create_meta_box_field(array(
            'name'        => 'qodef_property_area_size_meta',
            'type'        => 'text',
            'label'       => esc_html__('Area Size', 'qode-real-estate'),
            'parent'      => $property_specification_container,
            'args'        => array(
                'col_width' => 3
            )
        ));

        bridge_qode_create_meta_box_field(array(
            'name'        => 'qodef_property_garages_meta',
            'type'        => 'text',
            'label'       => esc_html__('Garages', 'qode-real-estate'),
            'parent'      => $property_specification_container,
            'args'        => array(
                'col_width' => 3
            )
        ));

        bridge_qode_create_meta_box_field(array(
            'name'        => 'qodef_property_garages_size_meta',
            'type'        => 'text',
            'label'       => esc_html__('Garages Size', 'qode-real-estate'),
            'parent'      => $property_specification_container,
            'args'        => array(
                'col_width' => 3
            )
        ));

        bridge_qode_create_meta_box_field(array(
            'name'        => 'qodef_property_additional_space_meta',
            'type'        => 'text',
            'label'       => esc_html__('Additional Space', 'qode-real-estate'),
            'parent'      => $property_specification_container,
            'args'        => array(
                'col_width' => 3
            )
        ));

        bridge_qode_create_meta_box_field(array(
            'name'        => 'qodef_property_publication_date_meta',
            'type'        => 'date',
            'label'       => esc_html__('Publication Date', 'qode-real-estate'),
            'parent'      => $property_specification_container,
            'args'        => array(
                'col_width' => 3
            )
        ));

        bridge_qode_create_meta_box_field(array(
            'name'        => 'qodef_property_is_featured_meta',
            'type'        => 'select',
            'label'       => esc_html__('Featured Property', 'qode-real-estate'),
            'parent'      => $property_specification_container,
            'options'     => bridge_qode_get_yes_no_select_array()
        ));
    }

    add_action('qodef_re_action_property_meta_fields', 'qodef_re_map_property_specifictation_meta', 10, 1);
}
