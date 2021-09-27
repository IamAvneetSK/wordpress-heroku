<?php

class QodeMusicElementorAlbum extends \Elementor\Widget_Base{
	public function get_name() {
		return 'bridge_album';
	}
	
	public function get_title() {
		return esc_html__( 'Album', 'qode-music' );
	}
	
	public function get_icon() {
		return 'bridge-elementor-custom-icon bridge-elementor-album';
	}
	
	public function get_categories() {
		return [ 'qode-music' ];
	}
	
	protected function _register_controls() {
		
		$this->start_controls_section(
			'general',
			[
				'label' => esc_html__( 'General', 'qode-music' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
		
		$this->add_control(
			'album',
			[
				'label' => esc_html__('Album', 'qode-music'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => $this->getAlbums(),
				'default' => ''
			]
		);
		
		$this->add_control(
			'album_skin',
			[
				'label' => esc_html__('Album Skin', 'qode-music'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
					''        => esc_html__('Default', 'qode-music'),
					'dark'    => esc_html__('Dark', 'qode-music'),
					'light'   => esc_html__('Light', 'qode-music')
				],
				'default' => ''
			]
		);
		
		$this->add_control(
			'title_tag',
			[
				'label' => esc_html__('Title Tag', 'qode-music'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'h2'	=> 'h2',
					'h3'	=> 'h3',
					'h4'	=> 'h4',
					'h5'	=> 'h5',
					'h6'	=> 'h6'
				],
				'default' => 'h3'
			]
		);
		
		$this->end_controls_section();
	}
	
	protected function render(){
		$params = $this->get_settings_for_display();
		
		extract($params);
		
		
		$params['alb_skin'] = $this->getAlbumClasses($params);
		
		$html = '';
		$params['random_id'] = 'qode-album-id-'.rand();
		$params['tracks'] = $this->getTracks($params);
		
		$html .= qode_music_get_shortcode_module_template_part('albums','templates/album-template', '', $params);
		echo bridge_qode_get_module_part($html);
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
		
		return $albums_array;
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
				//var_dump($track_data['length_formatted']);
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

\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new QodeMusicElementorAlbum() );