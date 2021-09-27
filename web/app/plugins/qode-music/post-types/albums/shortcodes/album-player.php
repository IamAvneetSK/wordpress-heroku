<?php
namespace QodeMusic\CPT\Albums\Shortcodes;

use QodeMusic\Lib;

/**
 * Class AlbumsList
 * @package QodeMusic\CPT\Albums\Shortcodes
 */

class AlbumPlayer implements Lib\ShortcodeInterface {
	/**
	 * @var string
	 */
	private $base;

	public function __construct() {
		$this->base = 'qode_album_player';

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
					'name' => esc_html__('Album Player', 'qode-music'),
					'base' => $this->base,
					'category' => esc_html__('by QODE MUSIC','qode-music'),
					'icon' => 'icon-wpb-album-player extended-custom-icon-qode',
					'allowed_container_element' => 'vc_row',
					'params' => array(
						array(
							'type'			=> 'dropdown',
							'heading'		=> esc_html__('Type','qode-music'),
							'param_name' 	=> 'type',
							'value' => array(
								esc_html__('Standard','qode-music')	=> 'standard',
								esc_html__('Compact','qode-music')	=> 'compact',
								esc_html__('Simple','qode-music')	=> 'simple'
							),
							'admin_label' 	=> true
						),
						array(
							'type'			=> 'dropdown',
							'heading'		=> esc_html__('Album','qode-music'),
							'param_name' 	=> 'album',
							'value' 		=> $this->getAlbums(),
							'admin_label' 	=> true,
							'save_always' 	=> true
						),
						array(
	                        'type'        => 'dropdown',
	                        'heading'     => esc_html__('Content In Grid','qode-music'),
	                        'param_name'  => 'full_width_bg',
	                        'value'       => array(
	                            esc_html__('Yes','qode-music')     => 'yes',
	                            esc_html__('No','qode-music')      => 'no'
	                        ),
	                        'admin_label' => true,
	               			'save_always' => true
	                    ),
						array(
							'type' => 'colorpicker',
							'heading' => esc_html__('Player Background Color','qode-music'),
							'param_name' => 'bg_color',
                            'dependency'  => array('element' => 'skin','value'=> 'transparent'),
						),
						array(
							'type' => 'colorpicker',
							'heading' => esc_html__('Play Button Background Color','qode-music'),
							'param_name' => 'play_bg_color',
                            'dependency'  => array('element' => 'skin','value'=> 'transparent'),
						),
						array(
							'type' => 'colorpicker',
							'heading' => esc_html__('Navigation Buttons Background Color','qode-music'),
							'param_name' => 'nav_bg_color',
                            'dependency'  => array('element' => 'skin','value'=> 'transparent'),
						),
						array(
							'type'			=> 'dropdown',
							'heading'		=> esc_html__('Skin','qode-music'),
							'param_name' 	=> 'skin',
							'value' => array(
								esc_html__('Light','qode-music')	=> 'light',
								esc_html__('Dark','qode-music')   => 'dark',
								esc_html__('Transparent','qode-music')   => 'transparent'
							),
							'admin_label' 	=> true,
							'save_always' 	=> true
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
			'type'			=> 'standard',
			'album'			=> '',
			'full_width_bg'	=> '',
			'bg_color'		=> '',
			'play_bg_color'	=> '', 
			'nav_bg_color'	=> '',
			'skin'			=> 'light'
		);

		$params = shortcode_atts($args, $atts);
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
		return $html;
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

		return  array_flip($albums_array);
	}

	private function getPlayerClasses($params) {

		$player_classes = array();
        $player_classes[] = 'qode-player-'.$params['skin'];

		return implode(';', $player_classes);
	}

}