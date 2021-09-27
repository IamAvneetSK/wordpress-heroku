<?php

class QodeREPropertySearch extends \Elementor\Widget_Base{
	public function get_name() {
		return 'bridge_property_search';
	}

	public function get_title() {
		return esc_html__( 'Property Search', 'qode-real-estate' );
	}

	public function get_icon() {
		return 'bridge-elementor-custom-icon bridge-elementor-property-search';
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
			'fullheight',
			[
				'label' => esc_html__( 'Full Height Search', 'qode-real-estate' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => bridge_qode_get_yes_no_select_array( false )
			]
		);

		$this->add_control(
			'subtitle',
			[
				'label' => esc_html__( 'Search subtitle', 'qode-real-estate' ),
				'type' => \Elementor\Controls_Manager::TEXT
			]
		);

		$this->add_control(
			'title',
			[
				'label' => esc_html__( 'Search title', 'qode-real-estate' ),
				'type' => \Elementor\Controls_Manager::TEXT
			]
		);

		$this->add_control(
			'enable_type',
			[
				'label' => esc_html__( 'Enable Type', 'qode-real-estate' ),
				'description' => esc_html__( 'Enable type as parameter for search', 'qode-real-estate' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => bridge_qode_get_yes_no_select_array( false, true )
			]
		);

		$this->add_control(
			'enable_city',
			[
				'label' => esc_html__( 'Enable City', 'qode-real-estate' ),
				'description' => esc_html__( 'Enable city as parameter for search', 'qode-real-estate' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => bridge_qode_get_yes_no_select_array( false, true )
			]
		);

		$this->add_control(
			'enable_status',
			[
				'label' => esc_html__( 'Enable Status', 'qode-real-estate' ),
				'description' => esc_html__( 'Enable status as parameter for search', 'qode-real-estate' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => bridge_qode_get_yes_no_select_array( false, true )
			]
		);

		$this->add_control(
			'skin',
			[
				'label' => esc_html__( 'Skin', 'qode-real-estate' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'' => esc_html__( 'Default', 'qode-real-estate' ),
					'qodef-light-skin' => esc_html__( 'Light', 'qode-real-estate' ),
				],
				'default' => ''
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'button_styles',
			[
				'label' => esc_html__( 'Button Styles', 'qode-real-estate' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'button_text',
			[
				'label' => esc_html__( 'Button Text', 'qode-real-estate' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Search Places', 'qode-real-estate' ),
			]
		);

		$this->add_control(
			'button_type',
			[
				'label' => esc_html__( 'Button Type', 'qode-real-estate' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'solid' => esc_html__( 'Solid', 'qode-real-estate' ),
					'outline' => esc_html__( 'Outline', 'qode-real-estate' ),
				],
				'default' => 'solid',
			]
		);

		$this->add_control(
			'button_size',
			[
				'label' => esc_html__( 'Button Size', 'qode-real-estate' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'' => esc_html__( 'Default', 'qode-real-estate' ),
					'small' => esc_html__( 'Small', 'qode-real-estate' ),
					'medium' => esc_html__( 'Medium', 'qode-real-estate' ),
					'large' => esc_html__( 'Large', 'qode-real-estate' ),
				],
				'default' => '',
			]
		);

		$this->add_control(
			'button_color',
			[
				'label' => esc_html__( 'Button Color', 'qode-real-estate' ),
				'type' => \Elementor\Controls_Manager::COLOR
			]
		);

		$this->add_control(
			'button_hover_color',
			[
				'label' => esc_html__( 'Button Hover Color', 'qode-real-estate' ),
				'type' => \Elementor\Controls_Manager::COLOR
			]
		);

		$this->add_control(
			'button_background_color',
			[
				'label' => esc_html__( 'Button Background Color', 'qode-real-estate' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'condition' => [
					'button_type' => 'solid'
				]
			]
		);

		$this->add_control(
			'button_hover_background_color',
			[
				'label' => esc_html__( 'Button Hover Background Color', 'qode-real-estate' ),
				'type' => \Elementor\Controls_Manager::COLOR,
			]
		);

		$this->add_control(
			'button_border_color',
			[
				'label' => esc_html__( 'Button Border Color', 'qode-real-estate' ),
				'type' => \Elementor\Controls_Manager::COLOR,
			]
		);

		$this->add_control(
			'button_hover_border_color',
			[
				'label' => esc_html__( 'Button Hover Border Color', 'qode-real-estate' ),
				'type' => \Elementor\Controls_Manager::COLOR,
			]
		);

		$this->end_controls_section();
	}

	protected function render(){
		$params = $this->get_settings_for_display();

		$args = array(
			'fullheight'                    => 'no',
			'title'                         => '',
			'subtitle'                      => '',
			'enable_type'                   => 'yes',
			'enable_city'                   => 'yes',
			'enable_status'                 => 'yes',
			'skin'                          => ' ',
			'button_text'                   => 'Search Places',
			'button_type'                   => 'solid',
			'button_size'                   => 'medium',
			'button_color'                  => '',
			'button_hover_color'            => '',
			'button_background_color'       => '',
			'button_hover_background_color' => '',
			'button_border_color'           => '',
			'button_hover_border_color'     => '',
			'selected_category'             => '',
			'selected_instructor'           => '',
			'selected_price'                => ''
		);

		$params = shortcode_atts($params, $args);

		$additional_params = array();

		$additional_params['button_parameters'] = $this->getButtonParameters( $params );
		$additional_params['holder_classes']    = $this->getHolderClasses( $params );
		$additional_params['property_search']   = $this;

		echo qodef_re_get_cpt_shortcode_module_template_part( 'property', 'property-search', 'holder', '', $params, $additional_params );
	}

	private function getHolderClasses( $params ) {
		$classes = array();

		$classes[] = 'qodef-property-search-holder';

		if(isset($params['fullheight']) && $params['fullheight'] === 'yes') {
			$classes[] = 'qodef-search-full-height';
		}

		if(isset($params['enable_type']) && $params['enable_type'] === 'yes') {
			$classes[] = 'qodef-search-type-enabled';
		}

		if(isset($params['enable_city']) && $params['enable_city'] === 'yes') {
			$classes[] = 'qodef-search-city-enabled';
		}

		if(isset($params['enable_status']) && $params['enable_status'] === 'yes') {
			$classes[] = 'qodef-search-status-enabled';
		}

		$classes[] = ! empty( $params['skin'] ) ? $params['skin'] : '';

		return implode(' ', $classes);
	}

	private function getButtonParameters( $params ) {
		$button_params_array = array();

		$button_params_array['html_type'] = 'button';

		if ( ! empty( $params['button_text'] ) ) {
			$button_params_array['text'] = $params['button_text'];
		}

		if ( ! empty( $params['button_type'] ) ) {
			$button_params_array['type'] = $params['button_type'];
		}

		if ( ! empty( $params['button_size'] ) ) {
			$button_params_array['size'] = $params['button_size'];
		}

		if ( ! empty( $params['button_link'] ) ) {
			$button_params_array['link'] = $params['button_link'];
		}

		$button_params_array['target'] = ! empty( $params['button_target'] ) ? $params['button_target'] : '_self';

		if ( ! empty( $params['button_color'] ) ) {
			$button_params_array['color'] = $params['button_color'];
		}

		if ( ! empty( $params['button_hover_color'] ) ) {
			$button_params_array['hover_color'] = $params['button_hover_color'];
		}

		if ( ! empty( $params['button_background_color'] ) ) {
			$button_params_array['background_color'] = $params['button_background_color'];
		}

		if ( ! empty( $params['button_hover_background_color'] ) ) {
			$button_params_array['hover_background_color'] = $params['button_hover_background_color'];
		}

		if ( ! empty( $params['button_border_color'] ) ) {
			$button_params_array['border_color'] = $params['button_border_color'];
		}

		if ( ! empty( $params['button_hover_border_color'] ) ) {
			$button_params_array['hover_border_color'] = $params['button_hover_border_color'];
		}

		return $button_params_array;
	}
}

\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new QodeREPropertySearch() );
