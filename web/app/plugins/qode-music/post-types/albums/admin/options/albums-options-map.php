<?php

if ( ! function_exists('qode_music_albums_options_map') ) {
	function qode_music_albums_options_map() {

		bridge_qode_add_admin_page(array(
			'slug'  => '_albums',
			'title' => esc_html__('Albums','qode-music'),
			'icon'  => 'fa fa-music'
		));

		$panel = bridge_qode_add_admin_panel(array(
			'title' => esc_html__('Albums','qode-music'),
			'name'  => 'panel_albums',
			'page'  => '_albums'
		));

		bridge_qode_add_admin_field(
			array(
				'name'			=> 'album_skin',
				'type'			=> 'select',
				'label'			=> esc_html__('Album Skin', 'qode-music'),
				'default_value'	=> 'light',
				'options' => array(
					'light' => esc_html__('Light','qode-music'),
					'dark'		=> esc_html__('Dark','qode-music')
				),
				'parent'      => $panel
			)
		);

		bridge_qode_add_admin_field(
			array(
				'name'			=> 'album_type',
				'type'			=> 'select',
				'label'			=> esc_html__('Album Type', 'qode-music'),
				'default_value'	=> 'comprehensive',
				'options' => array(
					'comprehensive' => esc_html__('Album Comprehensive','qode-music'),
					'minimal'		=> esc_html__('Album Minimal','qode-music'),
					'compact'		=> esc_html__('Album Compact','qode-music')
				),
				'parent'      => $panel
			)
		);

		bridge_qode_add_admin_field(array(
			'name'          => 'album_comments',
			'type'          => 'yesno',
			'label'         => esc_html__('Show Comments','qode-music'),
			'description'   => esc_html__('Enabling this option will show comments on your album.','qode-music'),
			'parent'        => $panel,
			'default_value' => 'no'
		));

		bridge_qode_add_admin_field(array(
			'name'          => 'album_pagination',
			'type'          => 'yesno',
			'label'         => esc_html__('Show Navigation','qode-music'),
			'description'   => esc_html__('Enabling this option will turn on album navigation functionality.','qode-music'),
			'parent'        => $panel,
			'default_value' => 'yes',
		));

	}

	add_action( 'bridge_qode_action_options_map', 'qode_music_albums_options_map', 14);
}
if ( ! function_exists( 'qode_music_add_share_option_to_album_post_type' ) ) {
	function qode_music_add_share_option_to_album_post_type($parent) {

		bridge_qode_add_admin_field(
			array(
				'name'          => 'post_types_names_qode-album',
				'type'          => 'flagcustomposttype',
				'default_value' => '',
				'label'         => esc_html__( 'Album', 'qode-tours' ),
				'description'   => esc_html__( 'Show Social Share for Album Items', 'qode-music' ),
				'args' => array(
					'custom_post_type' => 'qode-album'
				),
				'parent'        => $parent
			)
		);

	}

	add_action( 'bridge_qode_action_option_social_page_map', 'qode_music_add_share_option_to_album_post_type', 10, 1 );
}