<?php

class QodeMusicElementorAlbumsList extends \Elementor\Widget_Base{
	public function get_name() {
		return 'bridge_albums_list';
	}
	
	public function get_title() {
		return esc_html__( 'Albums List', 'qode-music' );
	}
	
	public function get_icon() {
		return 'bridge-elementor-custom-icon bridge-elementor-albums-list';
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
					'standard-with-space' => esc_html__('Standard With Space', 'qode-music'),
					'gallery-with-space'  => esc_html__('Gallery With Space', 'qode-music'),
					'gallery-no-space'    => esc_html__('Gallery No Space', 'qode-music'),
				],
				'default' => 'standard-with-space'
			]
		);
		
		$this->add_control(
			'show_stores',
			[
				'label' => esc_html__('Show Stores', 'qode-music'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => bridge_qode_get_yes_no_select_array(false, true),
				'default' => 'no'
			]
		);
		
		$this->add_control(
			'stores_list',
			[
				'label' => esc_html__('Choose Stores To Be Shown', 'qode-music'),
				'type' => \Elementor\Controls_Manager::SELECT2,
				'multiple' => true,
				'options' => [
					'itunes'       => esc_html__('iTunes', 'qode-music'),
					'google-play'  => esc_html__('Google Play', 'qode-music'),
					'bandcamp'     => esc_html__('Bandcamp', 'qode-music'),
					'spotify'      => esc_html__('Spotify', 'qode-music'),
					'amazonmp3'    => esc_html__('AmazonMP3', 'qode-music'),
					'deezer'       => esc_html__('Deezer', 'qode-music'),
				],
				'condition' => [
					'show_stores' => 'yes'
				]
			]
		);
		
		$this->end_controls_section();
		
		$this->start_controls_section(
			'query',
			[
				'label' => esc_html__( 'Query and Layout Options', 'qode-music' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
		
		$this->add_control(
			'order_by',
			[
				'label' => esc_html__('Order By', 'qode-music'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'date'       => esc_html__('Date', 'qode-music'),
					'title'      => esc_html__('Title', 'qode-music'),
					'menu_order' => esc_html__('Menu Order', 'qode-music'),
				],
				'default' => 'date'
			]
		);
		
		$this->add_control(
			'order',
			[
				'label' => esc_html__('Order', 'qode-music'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'ASC'       => esc_html__('ASC', 'qode-music'),
					'DESC'      => esc_html__('DESC', 'qode-music')
				],
				'default' => 'ASC'
			]
		);
		
		$this->add_control(
			'label',
			[
				'label' => esc_html__('One-Label Albums List', 'qode-music'),
				'description' => esc_html__('Enter one label slug (leave empty for showing all labels', 'qode-music'),
				'type' => \Elementor\Controls_Manager::TEXT
			]
		);
		
		$this->add_control(
			'genre',
			[
				'label' => esc_html__('One-Genre Albums List', 'qode-music'),
				'description' => esc_html__('Enter one genre slug (leave empty for showing all genres', 'qode-music'),
				'type' => \Elementor\Controls_Manager::TEXT
			]
		);
		
		$this->add_control(
			'artist',
			[
				'label' => esc_html__('One-Artist Albums List', 'qode-music'),
				'description' => esc_html__('Enter one artist slug (leave empty for showing all artists', 'qode-music'),
				'type' => \Elementor\Controls_Manager::TEXT
			]
		);
		
		$this->add_control(
			'number',
			[
				'label' => esc_html__('Number of Albums Per Page', 'qode-music'),
				'description' => esc_html__('(enter -1 to show all)', 'qode-music'),
				'type' => \Elementor\Controls_Manager::TEXT
			]
		);
		
		$this->add_control(
			'columns',
			[
				'label' => esc_html__('Number of Columns', 'qode-music'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'2'       => esc_html__('Two', 'qode-music'),
					'3'      => esc_html__('Three', 'qode-music'),
					'4' => esc_html__('Four', 'qode-music'),
				],
				'default' => '3'
			]
		);
		
		$this->add_control(
			'selected_albums',
			[
				'label' => esc_html__('Show Only Albums with Listed IDs', 'qode-music'),
				'description' => esc_html__('Delimit ID numbers by comma (leave empty for all)', 'qode-music'),
				'type' => \Elementor\Controls_Manager::TEXT
			]
		);
		
		$this->add_control(
			'show_load_more',
			[
				'label' => esc_html__('Show Load More', 'qode-music'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => bridge_qode_get_yes_no_select_array(false, true),
				'default' => 'no'
			]
		);
		
		$this->add_control(
			'load_more_label',
			[
				'label' => esc_html__('Load More label', 'qode-music'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'condition' => [
					'show_load_more' => 'yes'
				]
			]
		);
		
		$this->end_controls_section();
	}
	
	protected function render(){
		$params = $this->get_settings_for_display();
		
		extract($params);
		
		if( !empty($params['stores_list']) ) {
			$params['stores_list'] = implode(",", $params['stores_list']);
		}
		
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
		echo bridge_qode_get_module_part($html);
		
		
	}
	
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

\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new QodeMusicElementorAlbumsList() );