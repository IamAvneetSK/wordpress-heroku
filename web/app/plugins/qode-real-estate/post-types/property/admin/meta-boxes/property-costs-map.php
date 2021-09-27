<?php
if(!function_exists('qodef_re_map_property_costs_meta')) {
    function qodef_re_map_property_costs_meta($meta_box) {

		$property_costs_container = bridge_qode_add_admin_container(array(
		    'type'            => 'container',
		    'name'            => 'property_costs_container',
		    'parent'          => $meta_box
		));

		bridge_qode_add_admin_section_title(array(
		    'title'           => esc_html__('Costs', 'qode-real-estate'),
		    'name'            => 'property_costs_container_title',
		    'parent'          => $property_costs_container
		));
	
	
	    bridge_qode_add_repeater_field(
		    array(
			    'name'        => 'qodef_costs_meta',
			    'parent'      => $property_costs_container,
			    'button_text' => '',
			    'table_layout'=> true,
			    'fields'      => array(
				    array(
					    'type'        => 'select',
					    'name'        => 'icon',
					    'label'       => '',
					    'th'          => esc_html__( 'Icon', 'qode-real-estate' ),
					    'col_width'   => '4',
					    'options'     => qodef_re_get_assets_icon_list(),
					    'args'        => array(
						    'col_width' => 12
					    )
				    ),
				    array(
					    'type'        => 'text',
					    'name'        => 'label',
					    'label'       => '',
					    'th'          => esc_html__( 'Label', 'qode-real-estate' ),
					    'col_width'   => '4'
				    ),
				    array(
					    'type'        => 'text',
					    'name'        => 'value',
					    'label'       => '',
					    'th'          => esc_html__( 'Value', 'qode-real-estate' ),
					    'col_width'   => '4'
				    )
			    )
		    )
	    );
    }

    add_action('qodef_re_action_property_meta_fields', 'qodef_re_map_property_costs_meta', 12, 1);
}