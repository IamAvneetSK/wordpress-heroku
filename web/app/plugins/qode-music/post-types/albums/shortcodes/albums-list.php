<?php
namespace QodeMusic\CPT\Albums\Shortcodes;

use QodeMusic\Lib;

/**
 * Class AlbumsList
 * @package QodeMusic\CPT\Albums\Shortcodes
 */

class AlbumsList implements Lib\ShortcodeInterface {
	/**
	 * @var string
	 */
	private $base;

	public function __construct() {
		$this->base = 'qode_albums_list';

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
					'name' => esc_html__('Albums List', 'qode-music'),
					'base' => $this->getBase(),
					'category' => esc_html__('by QODE MUSIC', 'qode-music'),
					'icon' => 'icon-wpb-albums extended-custom-icon-qode',
					'allowed_container_element' => 'vc_row',
					'params' => array(
						array(
							'type' => 'dropdown',
							'heading' => esc_html__('Albums List Template', 'qode-music'),
							'param_name' => 'type',
							'value' => array(
								esc_html__('Standard With Space', 'qode-music') => 'standard-with-space',
								//esc_html__('Standard No Space', 'qode-music')   => 'standard-no-space',
								esc_html__('Gallery With Space', 'qode-music')  => 'gallery-with-space',
								esc_html__('Gallery No Space', 'qode-music')    => 'gallery-no-space'
							),
							'admin_label' => true,
							'description' => ''
						),
						array(
							'type' => 'dropdown',
							'heading' => esc_html__('Order By', 'qode-music'),
							'param_name' => 'order_by',
							'value' => array(
								esc_html__('Date', 'qode-music') 		=> 'date',
								esc_html__('Title', 'qode-music') 		=> 'title',
								esc_html__('Menu Order', 'qode-music') => 'menu_order'
							),
							'admin_label' => true,
							'save_always' => true,
							'description' => '',
							'group' => esc_html__('Query and Layout Options', 'qode-music')
						),
						array(
							'type' => 'dropdown',
							'heading' => esc_html__('Order', 'qode-music'),
							'param_name' => 'order',
							'value' => array(
								'ASC' => 'ASC',
								'DESC' => 'DESC',
							),
							'admin_label' => true,
							'save_always' => true,
							'description' => '',
							'group' => esc_html__('Query and Layout Options', 'qode-music')
						),
						array(
							'type' => 'textfield',
							'heading' => esc_html__('One-Label Albums List', 'qode-music'),
							'param_name' => 'label',
							'value' => '',
							'admin_label' => true,
							'description' => esc_html__('Enter one label slug (leave empty for showing all labels)', 'qode-music'),
							'group' => esc_html__('Query and Layout Options', 'qode-music')
						),
						array(
							'type' => 'textfield',
							'heading' => esc_html__('One-Genre Albums List', 'qode-music'),
							'param_name' => 'genre',
							'value' => '',
							'admin_label' => true,
							'description' => esc_html__('Enter one genre slug (leave empty for showing all genres)', 'qode-music'),
							'group' => esc_html__('Query and Layout Options', 'qode-music')
						),
						array(
							'type' => 'textfield',
							'heading' => esc_html__('One-Artist Albums List', 'qode-music'),
							'param_name' => 'artist',
							'value' => '',
							'admin_label' => true,
							'description' => esc_html__('Enter one artist slug (leave empty for showing all artists)', 'qode-music'),
							'group' => esc_html__('Query and Layout Options', 'qode-music')
						),
						array(
							'type' => 'textfield',
							'heading' => esc_html__('Number of Albums Per Page', 'qode-music'),
							'param_name' => 'number',
							'value' => '-1',
							'admin_label' => true,
							'description' => esc_html__('(enter -1 to show all)', 'qode-music'),
							'group' 	  => esc_html__('Query and Layout Options', 'qode-music')
						),
						array(
							'type' => 'dropdown',
							'heading' => esc_html__('Number of Columns', 'qode-music'),
							'param_name' => 'columns',
							'value' => array(
								'' 								=> '',
								esc_html__('Two', 'qode-music') 	=> '2',
								esc_html__('Three', 'qode-music')	=> '3',
								esc_html__('Four', 'qode-music') 	=> '4'
							),
							'admin_label' => true,
							'description' => esc_html__('Default value is Three', 'qode-music'),
							'group' 	  => esc_html__('Query and Layout Options', 'qode-music')
						),
						array(
							'type' => 'textfield',
							'heading' => esc_html__('Show Only Albums with Listed IDs', 'qode-music'),
							'param_name' => 'selected_albums',
							'value' => '',
							'admin_label' => true,
							'description' => esc_html__('Delimit ID numbers by comma (leave empty for all)', 'qode-music'),
							'group' => esc_html__('Query and Layout Options', 'qode-music')
						),
						array(
							'type' => 'dropdown',
							'heading' => esc_html__('Show Load More', 'qode-music'),
							'param_name' => 'show_load_more',
							'value' => array(
								esc_html__('No', 'qode-music') 	=> 'no',
								esc_html__('Yes', 'qode-music') 	=> 'yes'

							),
							'group' => esc_html__('Query and Layout Options', 'qode-music')
						),
						array(
                            'type' => 'textfield' ,
                            'heading' => esc_html__('Load More label','qode-music') ,
                            'param_name' => 'load_more_label' ,
                            'group' => esc_html__('Query and Layout Options', 'qode-music') ,
                            'dependency' => array('element' => 'show_load_more', 'value' => 'yes')
                        ),
						array(
							'type' => 'dropdown',
							'heading' => esc_html__('Show Stores', 'qode-music'),
							'param_name' => 'show_stores',
							'value' => array(
								esc_html__('Yes', 'qode-music') => 'yes',
								esc_html__('No', 'qode-music')  => 'no',
							),
							'description' => '',
							'save_always' => true
	   
						),
						array(
							'type' => 'checkbox',
							'heading' => esc_html__('Choose Stores To Be Shown', 'qode-music'),
							'param_name' => 'stores_list',
							'value' => array(
								esc_html__('iTunes', 'qode-music') => 'itunes',
								esc_html__('Google Play', 'qode-music') => 'google-play',
								esc_html__('Bandcamp', 'qode-music') => 'bandcamp',
								esc_html__('Spotify', 'qode-music') => 'spotify',
								esc_html__('AmazonMP3', 'qode-music') => 'amazonmp3',
								esc_html__('Deezer', 'qode-music') => 'deezer',
							),
							'description' => '',
							'dependency' => Array('element' => 'show_stores', 'value' => array('yes')),
	   
						),
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
			'type' 				=> 'standard-with-space',
			'columns' 			=> '3',
			'order_by'			=> 'date',
			'order' 			=> 'ASC',
			'number' 			=> '-1',
			'label' 			=> '',
			'genre' 			=> '',
			'artist'			=> '',
			'selected_albums' 	=> '',
			'show_load_more' 	=> '',
			'load_more_label'	=> '',
			'show_stores'		=> 'no',
			'stores_list'		=> ''
		);

		$params = shortcode_atts($args, $atts);
		extract($params);
		$query_array = $this->getQueryArray($params);
		$query_results = new \WP_Query($query_array);
		$params['query_results'] = $query_results;

		$classes = $this->getAlbumsClasses($params);
		$data_atts = $this->getDataAtts($params);
		$data_atts .= 'data-max-num-pages = '.$query_results->max_num_pages;

		$html = '';

		$html .= '<div class = "qode-albums-list-holder-outer '.$classes.'" '.$data_atts. '>';

		$html .= '<div class = "qode-albums-list-holder clearfix" >';
		

		if($query_results->have_posts()):
			while ( $query_results->have_posts() ) : $query_results->the_post();

				$params['current_id'] = get_the_ID();
				$params['album_link'] = get_permalink($params['current_id']);
				$params['artist_html'] = $this->getAlbumArtistsHtml($params);

				if($type == 'standard-with-space' || $type == 'standard-no-space' ){
					$html .= qode_music_get_shortcode_module_template_part('albums','templates/standard', '', $params);
				} else {
					$html .= qode_music_get_shortcode_module_template_part('albums','templates/gallery', '', $params);
				}

			endwhile;
		else:

			$html .= '<p>'. esc_html_e( 'Sorry, no albums matched your criteria.', 'qode-music') .'</p>';

		endif;

		$html .= '</div>'; //close qode-albums-list-holder
		if($show_load_more == 'yes'){
			$html .= qode_music_get_shortcode_module_template_part('albums','templates/load-more-template', '', $params);
		}
		wp_reset_postdata();
		$html .= '</div>'; // close qode-albums-list-holder-outer
		return $html;
	}

	/**
	 * Generates albums list query attribute array
	 *
	 * @param $params
	 *
	 * @return array
	 */
	public function getQueryArray($params){

		$query_array = array(
			'post_type' => 'qode-album',
			'orderby' =>$params['order_by'],
			'order' => $params['order'],
			'posts_per_page' => $params['number']
		);

		if(!empty($params['label'])){
			$query_array['qode-album-label'] = $params['label'];
		}

		if(!empty($params['genre'])){
			$query_array['qode-album-genre'] = $params['genre'];
		}

		if(!empty($params['artist'])){
			$query_array['qode-album-artist'] = $params['artist'];
		}

		$albums_ids = null;
		if (!empty($params['selected_albums'])) {
			$albums_ids = explode(',', $params['selected_albums']);
			$query_array['post__in'] = $albums_ids;
		}

		$paged = '';
		if(empty($params['next_page'])) {
			if(get_query_var('paged')) {
				$paged = get_query_var('paged');
			} elseif(get_query_var('page')) {
				$paged = get_query_var('page');
			}
		}

		if(!empty($params['next_page'])){
			$query_array['paged'] = $params['next_page'];

		}else{
			$query_array['paged'] = 1;
		}

		return $query_array;
	}

	/**
	 * Generates albums classes
	 *
	 * @param $params
	 *
	 * @return string
	 */
	public function getAlbumsClasses($params){
		$classes = array();
		$type = $params['type'];
		$columns = $params['columns'];
		switch($type):
			case 'standard-with-space':
			case 'standard-no-space':
				$classes[] = 'qode-alb-standard';
				break;
			case 'gallery-with-space':
			case 'gallery-no-space':
				$classes[] = 'qode-alb-gallery';
				break;
		endswitch;

	    
		switch ($columns):
			case '2':
				$classes[] = 'qode-alb-two-columns';
				break;
			case '3':
				$classes[] = 'qode-alb-three-columns';
				break;
			case '4':
				$classes[] = 'qode-alb-four-columns';
				break;
		endswitch;

		if($type == 'standard-no-space' || $type == 'gallery-no-space' ){
			$classes[] = "qode-album-wide";
		}

		if($params['show_load_more'] == 'yes') {
			$classes[] = "qode-albums-load-more";
		}

		return implode(' ',$classes);

	}
	
	/**
	 * Generates datta attributes array
	 *
	 * @param $params
	 *
	 * @return array
	 */
	public function getDataAtts($params){

		$data_attr = array();
		$data_return_string = '';

		if(get_query_var('paged')) {
			$paged = get_query_var('paged');
		} elseif(get_query_var('page')) {
			$paged = get_query_var('page');
		} else {
			$paged = 1;
		}

		if(!empty($paged)) {
			$data_attr['data-next-page'] = $paged+1;
		}

		if(!empty($params['type'])){
			$data_attr['data-type'] = $params['type'];
		}
		if(!empty($params['columns'])){
			$data_attr['data-columns'] = $params['columns'];
		}
		if(!empty($params['order_by'])){
			$data_attr['data-order-by'] = $params['order_by'];
		}
		if(!empty($params['order'])){
			$data_attr['data-order'] = $params['order'];
		}
		if(!empty($params['number'])){
			$data_attr['data-number'] = $params['number'];
		}
		if(!empty($params['label'])){
			$data_attr['data-label'] = $params['label'];
		}
		if(!empty($params['genre'])){
			$data_attr['data-genre'] = $params['genre'];
		}
		if(!empty($params['artist'])){
			$data_attr['data-artist'] = $params['artist'];
		}
		if(!empty($params['selected_albums'])){
			$data_attr['data-selected-albums'] = $params['selected_albums'];
		}
		if(!empty($params['show_stores']) && $params['show_stores'] == 'yes'){
			$data_attr['data-stores-list'] = $params['stores_list'];
		}

		foreach($data_attr as $key => $value) {
			if($key !== '') {
				$data_return_string .= $key . '= "' . esc_attr( $value ) . '" ';
			}
		}
		return $data_return_string;
	}


	/**
	 * Generates album artists html based on id
	 *
	 * @param $params
	 *
	 * @return html
	 */
	public function getAlbumArtistsHtml($params){
		$id = $params['current_id'];

		$artists = wp_get_post_terms($id, 'qode-album-artist');
		$artist_html = '<div class="qode-alb-artists-holder">';
		$k = 1;
		foreach ($artists as $art) {
			$artist_html .= '<h4>'.$art->name.'</h4>';
			if (count($artists) != $k) {
				$artist_html .= ' / ';
			}
			$k++;
		}
		$artist_html .= '</div>';
		return $artist_html;
	}
}