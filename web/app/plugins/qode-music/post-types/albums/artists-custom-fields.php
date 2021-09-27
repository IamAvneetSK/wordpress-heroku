<?php

if (!function_exists('qode_music_artist_fields')) {
	function qode_music_artist_fields() {

		$music_fields = bridge_qode_add_taxonomy_fields(
			array(
				'scope' => 'qode-album-artist',
				'name'  => 'music_artsts'
			)
		);

		bridge_qode_add_taxonomy_field(
			array(
				'name'        => 'artist_order',
				'type'        => 'text',
				'label'       => esc_html__( 'Artist Order', 'qode-music' ),
				'description' => '',
				'parent'      => $music_fields
			)
		);

		bridge_qode_add_taxonomy_field(
			array(
				'name'        => 'artist_stage',
				'type'        => 'text',
				'label'       => esc_html__( 'Artist Stage', 'qode-music' ),
				'description' => '',
				'parent'      => $music_fields
			)
		);

		bridge_qode_add_taxonomy_field(
			array(
				'name'        => 'artist_link',
				'type'        => 'text',
				'label'       => esc_html__( 'Artist Link', 'qode-music' ),
				'description' => '',
				'parent'      => $music_fields
			)
		);

		bridge_qode_add_taxonomy_field(
			array(
				'name'        => 'artist_image',
				'type'        => 'image',
				'label'       => esc_html__( 'Artist Image', 'qode-music' ),
				'description' => '',
				'parent'      => $music_fields
			)
		);
	}
	add_action('bridge_qode_action_custom_taxonomy_fields', 'qode_music_artist_fields');
}