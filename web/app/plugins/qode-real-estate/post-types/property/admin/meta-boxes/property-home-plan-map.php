<?php
if(!function_exists('qodef_re_map_property_home_plans_meta')) {
    function qodef_re_map_property_home_plans_meta($meta_box) {

        $property_home_plans_container = bridge_qode_add_admin_container(array(
            'type'            => 'container',
            'name'            => 'property_home_plans_container',
            'parent'          => $meta_box
        ));

        bridge_qode_add_admin_section_title(array(
            'title'           => esc_html__('Home Plans', 'qode-real-estate'),
            'name'            => 'property_home_plans_container_title',
            'parent'          => $property_home_plans_container
        ));

        bridge_qode_add_repeater_field(
            array(
                'name'        => 'qodef_home_plans_meta',
                'parent'      => $property_home_plans_container,
                'button_text' => '',
                'fields'      => array_merge(
                    array(
                        array(
                            'type'        => 'text',
                            'name'        => 'title',
                            'label'       => esc_html__('Title', 'qode-real-estate'),
                            'col_width'   => '6'
                        ),
                        array(
                            'type'        => 'text',
                            'name'        => 'price',
                            'label'       => esc_html__('Price', 'qode-real-estate'),
                            'col_width'   => '6'
                        ),
                        array(
                            'type'        => 'text',
                            'name'        => 'bedrooms',
                            'label'       => esc_html__('Bedrooms', 'qode-real-estate'),
                            'col_width'   => '6'
                        ),
                        array(
                            'type'        => 'text',
                            'name'        => 'bathrooms',
                            'label'       => esc_html__('Bathrooms', 'qode-real-estate'),
                            'col_width'   => '6'
                        ),
                        array(
                            'type'        => 'text',
                            'name'        => 'size',
                            'label'       => esc_html__('Size', 'qode-real-estate'),
                            'col_width'   => '6'
                        ),
                        array(
                            'type'        => 'image',
                            'name'        => 'image',
                            'label'       => esc_html__('Image', 'qode-real-estate'),
                            'col_width'   => '6'
                        ),
                        array(
                            'type'        => 'textarea',
                            'name'        => 'description',
                            'label'       => esc_html__('Description', 'qode-real-estate'),
                            'col_width'    => '12'
                        ),
                    )
                )
            )
        );
    }

    add_action('qodef_re_action_property_meta_fields', 'qodef_re_map_property_home_plans_meta', 16, 1);
}