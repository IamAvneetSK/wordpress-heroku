<?php
if(!function_exists('qodef_re_map_property_meta')) {
    function qodef_re_map_property_meta() {

        $meta_box = bridge_qode_create_meta_box( array(
            'scope' => 'property',
            'title' => esc_html__( 'Property Settings', 'qode-real-estate' ),
            'name'  => 'property_settings_meta_box'
        ) );

        $property_general_container = bridge_qode_add_admin_container(array(
            'type'            => 'container',
            'name'            => 'property_general_container',
            'parent'          => $meta_box
        ));

        bridge_qode_add_admin_section_title(array(
            'title'           => esc_html__('General', 'qode-real-estate'),
            'name'            => 'property_general_container_title',
            'parent'          => $property_general_container
        ));

        bridge_qode_create_meta_box_field(
            array(
                'type'          => 'select',
                'name'          => 'qodef_property_single_layout_meta',
                'default_value' => '',
                'label'         => esc_html__( 'Single Property Layout', 'qode-real-estate' ),
                'description'   => esc_html__( 'Choose default layout for your single property page', 'qode-real-estate' ),
                'parent'        => $property_general_container,
                'options'       => array(
                    ''              => esc_html__( 'Default', 'qode-real-estate' ),
                    'advanced'      => esc_html__( 'Advanced Gallery', 'qode-real-estate' ),
                    'thumbnails'    => esc_html__( 'Gallery with Thumbnails', 'qode-real-estate' )
                )
            )
        );

        bridge_qode_create_meta_box_field(
            array(
                'name'          => 'qodef_show_title_area_property_single_meta',
                'type'          => 'select',
                'default_value' => '',
                'label'         => esc_html__( 'Show Title Area', 'qode-real-estate' ),
                'description'   => esc_html__( 'Enabling this option will show title area on your single property page', 'qode-real-estate' ),
                'parent'        => $property_general_container,
                'options'       => bridge_qode_get_yes_no_select_array()
            )
        );

        do_action('qodef_re_action_property_meta_fields', $meta_box);
    }

    add_action('bridge_qode_action_meta_boxes_map', 'qodef_re_map_property_meta');
}