<?php

class QodeREPropertyLargeSlider extends \Elementor\Widget_Base{
	public function get_name() {
		return 'bridge_property_large_slider';
	}

	public function get_title() {
		return esc_html__( 'Property Large Slider', 'qode-real-estate' );
	}

	public function get_icon() {
		return 'bridge-elementor-custom-icon bridge-elementor-property-large-slider';
	}

	public function get_categories() {
		return [ 'qode-real-estate' ];
	}

	protected function _register_controls() {

		$this->start_controls_section(
			'general',
			[
				'label' => esc_html__( 'General', 'qode-real-estate' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'slider_height',
			[
				'label' => esc_html__( 'Slider Height', 'qode-real-estate' ),
				'type' => \Elementor\Controls_Manager::TEXT,
			]
		);

		$this->add_control(
			'number_of_items',
			[
				'label' => esc_html__( 'Number of Properties', 'qode-real-estate' ),
				'description' => esc_html__( 'Set number of items for your property slider. Enter -1 to show all.', 'qode-real-estate' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => '-1'
			]
		);

		$this->add_control(
			'order_by',
			[
				'label' => esc_html__( 'Order By', 'qode-real-estate' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => bridge_qode_get_query_order_by_array(),
			]
		);

		$this->add_control(
			'order',
			[
				'label' => esc_html__( 'Order', 'qode-real-estate' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => bridge_qode_get_query_order_array(),
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'slider_settings',
			[
				'label' => esc_html__( 'Slider Settings', 'qode-real-estate' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'enable_loop',
			[
				'label' => esc_html__( 'Enable Slider Loop', 'qode-real-estate' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => bridge_qode_get_yes_no_select_array( false, true ),
			]
		);

		$this->add_control(
			'enable_autoplay',
			[
				'label' => esc_html__( 'Enable Slider Autoplay', 'qode-real-estate' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => bridge_qode_get_yes_no_select_array( false, true ),
			]
		);

		$this->add_control(
			'slider_speed',
			[
				'label' => esc_html__( 'Slide Duration', 'qode-real-estate' ),
				'description' => esc_html__( 'Default value is 5000 (ms)', 'qode-real-estate' ),
				'type' => \Elementor\Controls_Manager::TEXT,
			]
		);

		$this->add_control(
			'slider_speed_animation',
			[
				'label' => esc_html__( 'Slide Animation Duration', 'qode-real-estate' ),
				'description' => esc_html__( 'Speed of slide animation in milliseconds. Default value is 600.', 'qode-real-estate' ),
				'type' => \Elementor\Controls_Manager::TEXT,
			]
		);

		$this->end_controls_section();
	}

	protected function render(){
		$params = $this->get_settings_for_display();

		$args = array(
			'slider_height' => '577',
			'number_of_columns'         => '1',
			'number_of_items'           => '-1',
			'order_by'                  => 'date',
			'order'                     => 'DESC',
			'enable_loop'               => 'yes',
			'enable_autoplay'		    => 'yes',
			'slider_speed'              => '5000',
			'slider_speed_animation'    => '600'
		);
		$params = shortcode_atts($params, $args);

		$query_array = qodef_re_generate_query_array($params);
		$query_results = new \WP_Query($query_array);
		$additional_params['query_results'] = $query_results;

		$params['styles'] = $this->getSliderStyle($params);

		echo qodef_re_get_cpt_shortcode_module_template_part( 'property', 'property-large-slider', 'holder', '', $params, $additional_params);
	}

	private function getSliderStyle($params){
		$styles = array();

		$styles['qodef-item-featured-image'] = array();

		if (!empty($params['slider_height'])) {
			$styles['qodef-item-featured-image'][] = 'height: ' . bridge_qode_filter_px($params['slider_height']) . 'px';
		}

		return $styles;
	}
}

\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new QodeREPropertyLargeSlider() );
