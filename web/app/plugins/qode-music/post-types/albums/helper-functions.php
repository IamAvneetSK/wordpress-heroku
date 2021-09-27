<?php

if(!function_exists('qode_music_album_meta_box_functions')) {
	function qode_music_album_meta_box_functions($post_types) {
		$post_types[] = 'qode-album';
		
		return $post_types;
	}
	
	add_filter('bridge_qode_filter_meta_box_post_types_save', 'qode_music_album_meta_box_functions');
	add_filter('bridge_qode_filter_meta_box_post_types_remove', 'qode_music_album_meta_box_functions');
}

if(!function_exists('qode_music_register_album_cpt')) {
	function qode_music_register_album_cpt($cpt_class_name) {
		$cpt_class = array(
			'QodeMusic\CPT\Albums\AlbumsRegister'
		);
		
		$cpt_class_name = array_merge($cpt_class_name, $cpt_class);
		
		return $cpt_class_name;
	}
	
	add_filter('qode_music_filter_register_custom_post_types', 'qode_music_register_album_cpt');
}

if(!function_exists('qode_music_single_album')) {
	function qode_music_single_album() {
		$back_to_link = get_post_meta( get_the_ID(), 'qode_album_back_to_link', true );
		//$album_type = qode_music_get_meta_field_intersect('album_type');
		$album_type_single = get_post_meta( get_the_ID(), 'qode_album_type_meta', true );
		$album_type_global = bridge_qode_options()->getOptionValue('album_type');

		$album_type = $album_type_single;

		if($album_type_single == ''){
			$album_type = $album_type_global;
		}

		$album_skin_single = get_post_meta( get_the_ID(), 'qode_album_skin_meta', true );
		$album_skin_global = bridge_qode_options()->getOptionValue('album_skin');

		$album_skin = $album_skin_single;

		if($album_skin_single == ''){
			$album_skin = $album_skin_global;
		}
		
		$store_type = ($album_type == 'comprehensive') ? 'image' : 'text';
		$params = array(
			'album_skin' => $album_skin,
			'back_to_link' => $back_to_link,
			'store_type' => $store_type,
		);

		qode_music_get_cpt_single_module_template_part('templates/single/'. $album_type, 'albums', '', $params);
	}
}

if(!function_exists('qode_music_single_stores_names_and_images')) {
	function qode_music_single_stores_names_and_images($store, $type = '') {

		switch ($store):
			case 'google-play':
				$name = esc_html__('Google Play', 'qode-music');
				break;
			case 'bandcamp':
				$name = esc_html__('Bandcamp', 'qode-music');
				break;
			case 'spotify':
				$name = esc_html__('Spotify', 'qode-music');
				break;
			case 'amazonmp3':
				$name = esc_html__('AmazonMP3', 'qode-music');
				break;
			case 'deezer':
				$name = esc_html__('Deezer', 'qode-music');
				break;
			default:
				$name = esc_html__('iTunes', 'qode-music');
				break;
		endswitch;

		$image = '<img src="'.plugins_url().'/qode-music/post-types/albums/assets/img/stores/'.$store.'.png" alt="'.$name.'" />';

		if($type == 'image') {
			return $image;
		}

		return $name;

	}
}

if(!function_exists('qode_music_album_playlist')){

	function qode_music_album_playlist(){

		if(isset($_POST) && isset($_POST['album_id'])){

			$album_id = $_POST['album_id'];
			$json_data = array();
			$tracks = get_post_meta($album_id, 'qode_album_tracks', true);
			$i = 0;

			$artists   = wp_get_post_terms($album_id, 'qode-album-artist');
			$artists_names = array();

			if(is_array($artists) && count($artists)) :
				foreach($artists as $artist) {
					$artists_names[] = $artist->name;
				}
			endif;

			if($tracks){
				foreach($tracks as $track){

					$track_id	= qode_music_get_attachment_id_from_url($track['qode_album_track_file']);
					$json_data[$i]['unique_id']	= 'qode-unique-track-'.$album_id.'-'.$track_id;
					$json_data[$i]['mp3']	= $track['qode_album_track_file'];

					if($track['qode_album_track_title']){
						$json_data[$i]['title']	= $track['qode_album_track_title'];
					}
					$json_data[$i]['album_name'] = get_the_title($album_id);
					$i++;
				}
				qode_music_ajax_status('success', '', $json_data);
			} else {
				qode_music_ajax_status('error', esc_html__('No tracks Founded.', 'qode-music'), $json_data);
			}
		}

		wp_die();
	}

	add_action('wp_ajax_nopriv_qode_music_album_playlist', 'qode_music_album_playlist');
	add_action( 'wp_ajax_qode_music_album_playlist', 'qode_music_album_playlist' );

}

/**
 * Loads more function for albums.
 *
 */
if(!function_exists('qode_core_albums_ajax_load_more')){

	function qode_core_albums_ajax_load_more(){

		$return_obj = array();
		$shortcode_params = array();

		if (!empty($_POST['type'])) {
			$shortcode_params['type'] = $_POST['type'];
		}
		if (!empty($_POST['columns'])) {
			$shortcode_params['columns'] = $_POST['columns'];
		}
		if (!empty($_POST['orderBy'])) {
			$shortcode_params['order_by'] = $_POST['orderBy'];
		}
		if (!empty($_POST['order'])) {
			$shortcode_params['order'] = $_POST['order'];
		}
		if (!empty($_POST['number'])) {
			$shortcode_params['number'] = $_POST['number'];
		}
		if (!empty($_POST['label'])) {
			$shortcode_params['label'] = $_POST['label'];
		}
		if (!empty($_POST['artist'])) {
			$shortcode_params['artist'] = $_POST['artist'];
		}
		if (!empty($_POST['genre'])) {
			$shortcode_params['genre'] = $_POST['genre'];
		}
		if (!empty($_POST['selectedAlbums'])) {
			$shortcode_params['selected_albums'] = $_POST['selectedAlbums'];
		}
		if (!empty($_POST['showLoadMore'])) {
			$shortcode_params['show_load_more'] = $_POST['showLoadMore'];
		}
		if (!empty($_POST['nextPage'])) {
			$shortcode_params['next_page'] = $_POST['nextPage'];
		}
		if (!empty($_POST['storesList'])) {
			$shortcode_params['show_stores'] = 'yes';
			$shortcode_params['stores_list'] = $_POST['storesList'];
		}

		$html = '';

		$albums_list = new \QodeMusic\CPT\Albums\Shortcodes\AlbumsList();
		$query_array = $albums_list->getQueryArray($shortcode_params);
		$query_results = new \WP_Query($query_array);

		if($query_results->have_posts()):
			while ( $query_results->have_posts() ) : $query_results->the_post();

				$shortcode_params['current_id'] = get_the_ID();
				$shortcode_params['album_link'] = get_permalink(get_the_ID());

				if($shortcode_params['type'] == 'standard-with-space' || $shortcode_params['type'] == 'standard-no-space' ){
					$template = 'templates/standard';
				} else {
					$template = 'templates/gallery';
				}

				$html .= qode_music_get_shortcode_module_template_part('albums', $template, '', $shortcode_params);

			endwhile;
		else:
			$html .= '<p>'. __('Sorry, no posts matched your criteria.', 'qode-music') .'</p>';
		endif;

		$return_obj = array(
			'html' => $html,
		);


		echo json_encode($return_obj); exit;
	}
}

add_action('wp_ajax_nopriv_qode_core_albums_ajax_load_more', 'qode_core_albums_ajax_load_more');
add_action( 'wp_ajax_qode_core_albums_ajax_load_more', 'qode_core_albums_ajax_load_more' );
