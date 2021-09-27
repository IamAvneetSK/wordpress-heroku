<?php

class QodeMusicElementorAlbumPlayer extends \Elementor\Widget_Base{
	public function get_name() {
		return 'bridge_album_player';
	}
	
	public function get_title() {
		return esc_html__( 'Album Player', 'qode-music' );
	}
	
	public function get_icon() {
		return 'bridge-elementor-custom-icon bridge-elementor-album-player';
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
			'type',
			[
				'label' => esc_html__('Albums List Template', 'qode-music'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'standard' => esc_html__('Standard', 'qode-music'),
					'compact'  => esc_html__('Compact', 'qode-music'),
					'simple'   => esc_html__('Simple', 'qode-music'),
				],
				'default' => 'standard'
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
			'full_width_bg',
			[
				'label' => esc_html__('Content In Grid', 'qode-music'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => bridge_qode_get_yes_no_select_array(false, true),
				'default' => 'no'
			]
		);
		
		$this->add_control(
			'bg_color',
			[
				'label' => esc_html__('Player Background Color', 'qode-music'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'condition' => [
					'skin' => 'transparent'
				]
			]
		);
		
		$this->add_control(
			'play_bg_color',
			[
				'label' => esc_html__('Play Button Background Color', 'qode-music'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'condition' => [
					'skin' => 'transparent'
				]
			]
		);
		
		$this->add_control(
			'nav_bg_color',
			[
				'label' => esc_html__('Navigation Buttons Background Color', 'qode-music'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'condition' => [
					'skin' => 'transparent'
				]
			]
		);
		
		$this->add_control(
			'skin',
			[
				'label' => esc_html__('Skin', 'qode-music'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'light'         => esc_html__('Light', 'qode-music'),
					'dark'          => esc_html__('Dark', 'qode-music'),
					'transparent'   => esc_html__('Transparent', 'qode-music'),
				],
				'default' => 'light'
			]
		);
		
		$this->end_controls_section();
	}
	
	protected function render(){
		$params = $this->get_settings_for_display();
		
		extract($params);
		
		$params['player_styles'] = '';
		$params['play_button_styles'] = '';
		$params['nav_buttons_styles'] = '';
		if($params['skin'] == 'transparent'){
			$params['player_styles'] = $this->getPlayerStyles($params);
			$params['play_button_styles'] = $this->getPlayButtonStyles($params);
			$params['nav_buttons_styles'] = $this->getNavigationButtonsStyles($params);
		}
		
		$params['player_id'] = rand();
		$params['player_classes'] = $this->getPlayerClasses($params);
		$html = '';
		
		$html .= qode_music_get_shortcode_module_template_part('albums','templates/album-player-'.$params['type'].'-template', '', $params);
		
		echo bridge_qode_get_module_part($html);
	}
	
	private function getPlayerStyles($params) {
		
		$player_styles = array();
		
		if ($params['bg_color'] !== '') {
			$player_styles[] = 'background-color:' . $params['bg_color'];
		}
		
		return implode(';', $player_styles);
	}
	
	private function getPlayButtonStyles($params) {
		
		$play_button_styles = array();
		
		if ($params['play_bg_color'] !== '') {
			$play_button_styles[] = 'background-color:' . $params['play_bg_color'];
		}
		
		return implode(';', $play_button_styles);
	}
	
	private function getNavigationButtonsStyles($params) {
		
		$nav_buttons_styles = array();
		
		if ($params['nav_bg_color'] !== '') {
			$nav_buttons_styles[] = 'background-color:' . $params['nav_bg_color'];
		}
		
		return implode(';', $nav_buttons_styles);
	}
	
	private function getAlbums(){
		
		$albums_array = array();
		$args = array(
			'post_type' => 'qode-album',
			'posts_per_page' => '-1'
		);
		
		$query = new \WP_Query($args);
		if($query->have_posts()) :
			while($query->have_posts()) : $query->the_post();
				$albums_array[get_the_ID()] = get_the_title();
			endwhile;
		endif;
		
		return $albums_array;
	}
	
	private function getPlayerClasses($params) {
		
		$player_classes = array();
		$player_classes[] = 'qode-player-'.$params['skin'];
		
		return implode(';', $player_classes);
	}
}

\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new QodeMusicElementorAlbumPlayer() );