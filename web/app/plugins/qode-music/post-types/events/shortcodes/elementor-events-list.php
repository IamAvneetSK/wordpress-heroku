<?php

class QodeMusicElementorEventsList extends \Elementor\Widget_Base{
	public function get_name() {
		return 'bridge_events_list';
	}
	
	public function get_title() {
		return esc_html__( 'Events List', 'qode-music' );
	}
	
	public function get_icon() {
		return 'bridge-elementor-custom-icon bridge-elementor-events-list';
	}
	
	public function get_categories() {
		return [ 'qode-music' ];
	}
	
	protected function _register_controls() {
		
		$this->start_controls_section(
			'design',
			[
				'label' => esc_html__( 'Design Options', 'qode-music' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
		
		$this->add_control(
			'title_tag',
			[
				'label' => esc_html__('Title Tag', 'qode-music'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'h1'	=> 'h1',
					'h2'	=> 'h2',
					'h3'	=> 'h3',
					'h4'	=> 'h4',
					'h5'	=> 'h5',
					'h6'	=> 'h6'
				],
				'default' => 'h5'
			]
		);
		
		$this->add_control(
			'text_color',
			[
				'label' => esc_html__('Date Text Color', 'qode-music'),
				'type' => \Elementor\Controls_Manager::COLOR
			]
		);
		
		$this->add_control(
			'border_color',
			[
				'label' => esc_html__('Border Color', 'qode-music'),
				'type' => \Elementor\Controls_Manager::COLOR
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
			'number',
			[
				'label' => esc_html__('Number of Events Per Page', 'qode-music'),
				'description' => esc_html__('(enter -1 to show all)', 'qode-music'),
				'type' => \Elementor\Controls_Manager::TEXT
			]
		);
		
		$this->add_control(
			'order_by',
			[
				'label' => esc_html__('Order By', 'qode-music'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'start-date'  => esc_html__('Start Date', 'qode-music'),
					'menu_order'  => esc_html__('Menu Order', 'qode-music'),
					'title'       => esc_html__('Title', 'qode-music'),
					'date'        => esc_html__('Date', 'qode-music'),
				],
				'default' => 'start-date'
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
			'event_status',
			[
				'label' => esc_html__('Show Event by Status', 'qode-music'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'all'       => esc_html__('All', 'qode-music'),
					'upcoming'  => esc_html__('Current and Upcoming', 'qode-music'),
					'past'      => esc_html__('Past', 'qode-music')
				],
				'default' => 'all'
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
		
		$html = '';
		
		$query_array = $this->getQueryArray($params);
		$query_results = new \WP_Query($query_array);
		$params['query_results'] = $query_results;
		
		$data_atts = $this->getDataAtts($params);
		$data_atts .= 'data-max-num-pages = '.$query_results->max_num_pages;
		
		$params['text_color_style']	= $this->getEventsListTextColor($params);
		$params['border_color_style']	= $this->getEventsListBorderColor($params);
		$classes = $this->getEventsClasses($params);
		
		
		$html .='<div class="qode-events-list-holder-outer '.$classes.'" '.$data_atts. '>';
		$html .='<div class="qode-events-list-holder clearfix">';
		
		
		if($query_results->have_posts()):
			while ( $query_results->have_posts() ) : $query_results->the_post();
				$current_id = get_the_ID();
				$params['title'] = get_the_title($current_id);
				$params['date'] = get_post_meta($current_id, 'qode_event_item_date', true);
				$params['link'] = get_post_meta($current_id, 'qode_event_item_link', true);
				$params['target'] = get_post_meta($current_id, 'qode_event_item_target', true);
				$params['tickets_status'] = get_post_meta($current_id, 'qode_event_item_tickets_status', true);
				
				$html .= qode_music_get_shortcode_module_template_part('events','templates/events-list-template', '', $params);
			
			endwhile;
		else:
			$html .='<p>' . esc_html__( 'Sorry, no events matched your criteria.','qode-music' ) . '</p>';
		
		endif;
		
		$html .='</div>';
		
		if($show_load_more == 'yes'){
			$html .= qode_music_get_shortcode_module_template_part('events','templates/load-more-template', '', $params);
		}
		
		wp_reset_postdata();
		
		$html .='</div>';
		
		echo bridge_qode_get_module_part($html);
	}
	
	public function getQueryArray($params){
		$meta_query = array();
		$order_by = $params['order_by'];
		
		if ($params['order_by'] == 'start-date'){
			$order_by = 'meta_value';
		}
		
		$query_array = array(
			'post_type' => 'qode-event',
			'orderby' => $order_by,
			'order' => $params['order'],
			'posts_per_page' => $params['number']
		);
		
		if ($params['order_by'] == 'start-date'){
			$query_array['meta_key'] = 'qode_event_item_date_and_time'; //here because has to be added to query
		}
		
		//display date by event status, ex. end date larger then todays date or if it doesn't exist compare start date
		switch ($params['event_status']) {
			case 'upcoming':
				$meta_query = array(
					'key' => 'qode_event_item_date_and_time',
					'value' => date("Y-m-d H:i"),
					'compare' => '>=',
					'type'    => 'CHAR'
				);
				break;
			case 'past':
				$meta_query = array(
					'key' => 'qode_event_item_date_and_time',
					'value' => date("Y-m-d H:i"),
					'compare' => '<',
					'type'    => 'CHAR'
				);
				break;
		}
		
		if (is_array($meta_query) && count($meta_query)){
			$query_array['meta_query'][] = $meta_query;
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
			
		} else{
			$query_array['paged'] = 1;
		}
		
		return $query_array;
	}
	
	
	private function getEventsListTextColor($params) {
		
		$text_color = array();
		
		if ($params['text_color'] !== '') {
			$text_color[] = 'color:' . $params['text_color'];
		}
		return implode(';', $text_color);
	}
	
	private function getEventsListBorderColor($params) {
		
		$border_color = array();
		
		if ($params['border_color'] !== '') {
			$border_color[] = 'border-color:' . $params['border_color'];
		}
		
		return implode(';', $border_color);
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
		
		if(!empty($params['order_by'])){
			$data_attr['data-order-by'] = $params['order_by'];
		}
		
		if(!empty($params['order'])){
			$data_attr['data-order'] = $params['order'];
		}
		
		if(!empty($params['event_status'])){
			$data_attr['data-event-status'] = $params['event_status'];
		}
		
		if(!empty($params['number'])){
			$data_attr['data-number'] = $params['number'];
		}
		
		if(!empty($params['title_tag'])){
			$data_attr['data-title-tag'] = $params['title_tag'];
		}
		
		if(!empty($params['text_color'])){
			$data_attr['data-text-color'] = $params['text_color'];
		}
		
		if(!empty($params['border_color'])){
			$data_attr['data-border-color'] = $params['border_color'];
		}
		
		foreach($data_attr as $key => $value) {
			if($key !== '') {
				$data_return_string .= $key . '= "' . esc_attr( $value ) . '" ';
			}
		}
		return $data_return_string;
	}
	
	/**
	 * Generates events classes
	 *
	 * @param $params
	 *
	 * @return string
	 */
	public function getEventsClasses($params){
		$classes = array();
		
		if($params['show_load_more'] == 'yes') {
			$classes[] = "qode-events-load-more";
		}
		
		return implode(' ',$classes);
		
	}
}

\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new QodeMusicElementorEventsList() );