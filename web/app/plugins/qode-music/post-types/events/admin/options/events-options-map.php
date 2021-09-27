<?php

if ( ! function_exists('qode_music_events_options_map') ) {
	function qode_music_events_options_map() {

		bridge_qode_add_admin_page(array(
			'slug'  => '_events',
			'title' => esc_html__('Events', 'qode-music'),
			'icon'  => 'fa fa-calendar'
		));

		$panel = bridge_qode_add_admin_panel(array(
			'title' => esc_html__('Event', 'qode-music'),
			'name'  => 'panel_event',
			'page'  => '_events'
		));

		bridge_qode_add_admin_field(array(
			'name'          => 'event_comments',
			'type'          => 'yesno',
			'label'         => esc_html__('Show Comments', 'qode-music'),
			'description'   => esc_html__('Enabling this option will show comments on your page.', 'qode-music'),
			'parent'        => $panel,
			'default_value' => 'no'
		));

		bridge_qode_add_admin_field(array(
			'name'          => 'event_pagination',
			'type'          => 'yesno',
			'label'         => esc_html__('Show Pagination', 'qode-music'),
			'description'   => esc_html__('Enabling this option will turn on events pagination functionality.', 'qode-music'),
			'parent'        => $panel,
			'default_value' => 'no',
		));

		bridge_qode_add_admin_field(array(
			'name'        => 'event_single_slug',
			'type'        => 'text',
			'label'       => esc_html__('Event Single Slug','qode-music'),
			'description' => esc_html__('Enter if you wish to use a different Single Project slug (Note: After entering slug, navigate to Settings -> Permalinks and click "Save" in order for changes to take effect)','qode-music'),
			'parent'      => $panel,
			'args'        => array(
				'col_width' => 3
			)
		));

		bridge_qode_add_admin_field(
				array(
					'parent' => $panel,
					'type' => 'textarea',
					'name' => 'music_map_style',
					'default_value' => '',
					'label' => esc_html__('Maps Style', 'qode-music'),
					'description' => esc_html__('Insert map style json', 'qode-music'),
				)
			);

	}

	add_action( 'bridge_qode_action_options_map', 'qode_music_events_options_map', 14);
}