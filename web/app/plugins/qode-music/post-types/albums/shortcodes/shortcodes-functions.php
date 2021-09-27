<?php

if(!function_exists('qode_music_include_albums_shortcodes')) {
	function qode_music_include_albums_shortcodes() {
		include_once QODE_MUSIC_CPT_PATH.'/albums/shortcodes/album.php';
		include_once QODE_MUSIC_CPT_PATH.'/albums/shortcodes/album-player.php';
		include_once QODE_MUSIC_CPT_PATH.'/albums/shortcodes/albums-list.php';
		//include_once QODE_MUSIC_CPT_PATH.'/albums/shortcodes/artists-list.php';
	}
	
	add_action('qode_music_action_include_shortcodes_file', 'qode_music_include_albums_shortcodes');
}

if(!function_exists('qode_music_add_albums_shortcodes')) {
	function qode_music_add_albums_shortcodes($shortcodes_class_name) {
		$shortcodes = array(
			'QodeMusic\CPT\Albums\Shortcodes\Album',
			'QodeMusic\CPT\Albums\Shortcodes\AlbumPlayer',
			'QodeMusic\CPT\Albums\Shortcodes\AlbumsList'			
		);

		//'QodeMusic\CPT\Albums\Shortcodes\ArtistsList'

		$shortcodes_class_name = array_merge($shortcodes_class_name, $shortcodes);

		return $shortcodes_class_name;
	}

	add_filter('qode_music_add_vc_shortcode', 'qode_music_add_albums_shortcodes');
}

if(!function_exists('qode_music_include_elementor_album_shortcode')) {
	function qode_music_include_elementor_album_shortcode() {
		include_once QODE_MUSIC_CPT_PATH.'/albums/shortcodes/elementor-album.php';
	}
	
	add_action('bridge_core_load_elementor_shortcodes_from_plugins', 'qode_music_include_elementor_album_shortcode');
}

if(!function_exists('qode_music_include_elementor_album_player_shortcode')) {
	function qode_music_include_elementor_album_player_shortcode() {
		include_once QODE_MUSIC_CPT_PATH.'/albums/shortcodes/elementor-album-player.php';
	}
	
	add_action('bridge_core_load_elementor_shortcodes_from_plugins', 'qode_music_include_elementor_album_player_shortcode');
}

if(!function_exists('qode_music_include_elementor_albums_list_shortcode')) {
	function qode_music_include_elementor_albums_list_shortcode() {
		include_once QODE_MUSIC_CPT_PATH.'/albums/shortcodes/elementor-albums-list.php';
	}
	
	add_action('bridge_core_load_elementor_shortcodes_from_plugins', 'qode_music_include_elementor_albums_list_shortcode');
}