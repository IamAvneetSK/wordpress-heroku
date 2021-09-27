<?php
namespace QodeMusic\CPT\Albums\Shortcodes;

use QodeMusic\Lib;

/**
 * Class AlbumsList
 * @package QodeMusic\CPT\Albums\Shortcodes
 */

class Album implements Lib\ShortcodeInterface {
	/**
	 * @var string
	 */
	private $base;

	public function __construct() {
		$this->base = 'qode_album';

		add_action('vc_before_init', array($this, 'vcMap'));
	}

	/**
	 * Returns base for shortcode
	 * @return string
	 */
	public function getBase() {
		return $this->base;
	}

	/**
	 * Maps shortcode to Visual Composer
	 *
	 * @see vc_map
	 */

	public function vcMap() {
		if(function_exists('vc_map')) {

			vc_map( array(
					'name' => esc_html__('Album', 'qode-music'),
					'base' => $this->base,
					'category' => esc_html__('by QODE MUSIC','qode-music'),
					'icon' => 'icon-wpb-album extended-custom-icon-qode',
					'allowed_container_element' => 'vc_row',
					'params' => array(
						array(
							'type'			=> 'dropdown',
							'heading'		=> esc_html__('Album','qode-music'),
							'param_name' 	=> 'album',
							'value' 		=> $this->getAlbums(),
							'admin_label' 	=> true,
							'save_always' 	=> true
						),
						array(
							'type' => 'dropdown',
							'heading' => esc_html__('Album Skin','qode-music'),
							'param_name' => 'album_skin',
							'value' => array(
								esc_html__('Default','qode-music')		=> '',
								esc_html__('Dark','qode-music') 		=> 'dark',
								esc_html__('Light','qode-music') 		=> 'light'
							),
							'admin_label' => true
						),
						array(
							'type' => 'dropdown',
							'heading' => esc_html__('Title Tag','qode-music'),
							'param_name' => 'title_tag',
							'value' => array(
								'' => '',
								'h2'	=> 'h2',
								'h3'	=> 'h3',
								'h4'	=> 'h4',
								'h5'	=> 'h5',
								'h6'	=> 'h6'
							),
							'admin_label' => true
						)
					)
				)
			);
		}
	}

	/**
	 * Renders shortcodes HTML
	 *
	 * @param $atts array of shortcode params
	 * @param $content string shortcode content
	 * @return string
	 */
	public function render($atts, $content = null) {

		$args = array(
			'album'		 => '',
			'album_skin' => '',
			'title_tag'	 => 'h3'
		);

		$params = shortcode_atts($args, $atts);
		extract($params);

		$params['alb_skin'] = $this->getAlbumClasses($params);

		$html = '';
		$params['random_id'] = 'qode-album-id-'.rand();
		$params['tracks'] = $this->getTracks($params);

		$html .= qode_music_get_shortcode_module_template_part('albums','templates/album-template', '', $params);
		return $html;
	}


	private function getAlbums(){

		$albums_array = array();
		$args = array(
			'post_type'			=> 'qode-album',
			'posts_per_page'	=> '-1'
		);

		$query = new \WP_Query($args);
		if($query->have_posts()) :
			while($query->have_posts()) : $query->the_post();
				$albums_array[get_the_ID()] = get_the_title();
			endwhile;
		endif;

		return  array_flip($albums_array);
	}

	private function getTracks($params){

		$tracks_array = array();
		$tracks = get_post_meta($params['album'], 'qode_album_tracks', true);


		$i = 0;
		if($tracks){
			foreach($tracks as $track){
				/*------------------------------------------------------------------------------------------*/
				//if import is executed second time and file does exists in 'uploads' but not in database
				//usercase ex: user empties db, but not 'uploads' folder
				if(qode_music_get_attachment_id_from_url($track) == null){
					$i++;
					continue;
				}
				/*------------------------------------------------------------------------------------------*/
				$track_id = qode_music_get_attachment_id_from_url($track['qode_album_track_file']);
				$track_data = wp_get_attachment_metadata($track_id);
				$tracks_array[$i]['track_file'] 	= $track['qode_album_track_file'];
				$tracks_array[$i]['video_link'] 	= $track['qode_album_track_video_link'];
				$tracks_array[$i]['title'] 			= $track['qode_album_track_title'];
				$tracks_array[$i]['free_download']	= $track['qode_album_track_free_download'];
				$tracks_array[$i]['track_time']		= $track_data['length_formatted'];




				$i++;
			}
		}
		return  $tracks_array;
	}

	private function getAlbumClasses($params) {

		$album_classes = array();

		if ($params['album_skin'] == 'light') {
			$album_classes[] = 'qode-album-light';
		} else if ($params['album_skin'] == 'dark') {
			$album_classes[] = 'qode-album-dark';
		}

		return implode(';', $album_classes);
	}

}