<?php
if(!function_exists('qodef_re_map_property_address_meta')) {
    function qodef_re_map_property_address_meta($meta_box) {

        $property_address_container = bridge_qode_add_admin_container(array(
            'type'            => 'container',
            'name'            => 'property_address_container',
            'parent'          => $meta_box
        ));

        bridge_qode_add_admin_section_title(array(
            'title'           => esc_html__('Address', 'qode-real-estate'),
            'name'            => 'property_address_container_title',
            'parent'          => $property_address_container
        ));

        bridge_qode_create_meta_box_field(array(
            'name'        => 'qodef_property_full_address_meta',
            'type'        => 'address',
            'label'       => esc_html__('Full Address', 'qode-real-estate'),
            'parent'      => $property_address_container,
            'args'        => array(
                'latitude_field' => 'qodef_property_full_address_latitude',
                'longitude_field' => 'qodef_property_full_address_longitude'
            )
        ));

        bridge_qode_create_meta_box_field(array(
            'name'        => 'qodef_property_full_address_latitude',
            'type'        => 'text',
            'label'       => esc_html__('Latitude', 'qode-real-estate'),
            'parent'      => $property_address_container,
            'args'        => array(
                'col_width' => 3,
                'custom_class' => 'qodef-address-elements',
                'input-data' => array(
                    'data-geo' => 'lat'
                )
            )
        ));

        bridge_qode_create_meta_box_field(array(
            'name'        => 'qodef_property_full_address_longitude',
            'type'        => 'text',
            'label'       => esc_html__('Longitude', 'qode-real-estate'),
            'parent'      => $property_address_container,
            'args'        => array(
                'col_width' => 3,
                'custom_class' => 'qodef-address-elements',
                'input-data' => array(
                    'data-geo' => 'lng'
                )
            )
        ));

        bridge_qode_create_meta_box_field(array(
            'name'        => 'qodef_property_simple_address_meta',
            'type'        => 'text',
            'label'       => esc_html__('Simple Address', 'qode-real-estate'),
            'parent'      => $property_address_container,
            'args'        => array(
                'col_width' => 3
            )
        ));

        bridge_qode_create_meta_box_field(array(
            'name'        => 'qodef_property_zip_code_meta',
            'type'        => 'text',
            'label'       => esc_html__('ZIP Code', 'qode-real-estate'),
            'parent'      => $property_address_container,
            'args'        => array(
                'col_width' => 3
            )
        ));

        bridge_qode_create_meta_box_field(array(
            'name'        => 'qodef_property_address_country_meta',
            'type'        => 'select',
            'label'       => esc_html__('Country', 'qode-real-estate'),
            'parent'      => $property_address_container,
            'options'     => qodef_re_get_countries_list()
        ));
    }

    add_action('qodef_re_action_property_meta_fields', 'qodef_re_map_property_address_meta', 13, 1);
}