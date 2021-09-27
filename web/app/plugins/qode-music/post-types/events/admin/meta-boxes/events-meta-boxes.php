<?php
if(qode_music_theme_installed()) {
	if(!function_exists('qode_events_meta_box_map')) {
		function qode_events_meta_box_map() {

			$event_meta_box = bridge_qode_create_meta_box(
				array(
					'scope' => array('qode-event'),
					'title' => esc_html__('Event', 'qode'),
					'name' => 'event_meta'
				)
			);

			bridge_qode_create_meta_box_field(
				array(
					'name'        => 'qode_event_skin',
					'type'        => 'select',
					'label'       => esc_html__('Event Skin', 'qode-music'),
					'description' => '',
					'options' => array(
						'' => esc_html__('Default','qode-music'),
						'dark' => esc_html__('Dark Skin','qode-music'),
						'light'		=> esc_html__('Light Skin','qode-music')
					),
					'parent'      => $event_meta_box
				)
			);

			bridge_qode_create_meta_box_field(
				array(
					'name'        => 'qode_event_item_tickets_status',
					'type'        => 'select',
					'label'       => esc_html__('Tickets Status','qode'),
					'description' => '',
					'options' => array(
						'available' => esc_html__('Available','qode'),
						'free' => esc_html__('Free','qode'),
						'sold' => esc_html__('Sold Out','qode')
					),
					'parent'      => $event_meta_box
				)
			);

			bridge_qode_create_meta_box_field(
				array(
					'name'        => 'qode_event_item_date',
					'type'        => 'date',
					'label'       => esc_html__('Date','qode'),
					'description' => '',
					'parent'      => $event_meta_box,
                    'args'        => array(
                        'formatted_date' => 'yes'
                    )
				)
			);

			bridge_qode_create_meta_box_field(
				array(
					'name'        => 'qode_event_item_time',
					'type'        => 'text',
					'label'       => esc_html__('Time','qode'),
					'description' => esc_html__('Please input the time in a HH:MM format. If you are using a 12 hour time format, please also input AM or PM markers.','qode'),
					'parent'      => $event_meta_box
				)
			);

			bridge_qode_create_meta_box_field(
				array(
					'name'        => 'qode_event_item_location',
					'type'        => 'text',
					'label'       => esc_html__('Location','qode'),
					'description' => '',
					'parent'      => $event_meta_box
				)
			);

			bridge_qode_create_meta_box_field(
				array(
					'name'        => 'qode_event_item_pin',
					'type'        => 'image',
					'label'       => esc_html__('Pin','qode'),
					'description' => esc_html__('Upload Google Map Pin Image','qode'),
					'parent'      => $event_meta_box
				)
			);

			bridge_qode_create_meta_box_field(
				array(
					'name'        => 'qode_event_item_website',
					'type'        => 'text',
					'label'       => esc_html__('Website','qode'),
					'description' => '',
					'parent'      => $event_meta_box
				)
			);

			bridge_qode_create_meta_box_field(
				array(
					'name'        => 'qode_event_item_organized_by',
					'type'        => 'text',
					'label'       => esc_html__('Organized By','qode'),
					'description' => '',
					'parent'      => $event_meta_box
				)
			);

			bridge_qode_create_meta_box_field(
				array(
					'name'        => 'qode_event_item_link',
					'type'        => 'text',
					'label'       => esc_html__('Buy Tickets Link','qode'),
					'description' => esc_html__('Enter the external link where users can buy the tickets','qode'),
					'parent'      => $event_meta_box
				)
			);

			bridge_qode_create_meta_box_field(
				array(
					'name'        => 'qode_event_item_target',
					'type'        => 'selectblank',
					'label'       => esc_html__('Target','qode'),
					'description' => '',
					'parent'      => $event_meta_box,
					'options' => array(
						'_self' => esc_html__('Self','qode'),
						'_blank' => esc_html__('Blank','qode')
					)
				)
			);

			bridge_qode_create_meta_box_field(
				array(
					'name'        => 'qode_event_back_to_link',
					'type'        => 'text',
					'label'       => esc_html__('"Back To" Link','qode'),
					'description' => esc_html__('Choose "Back To" page to link from event single page','qode'),
					'parent'      => $event_meta_box,
				)
			);

		}

		add_action('bridge_qode_action_meta_boxes_map', 'qode_events_meta_box_map');
	}
}