<?php

class QodeREPropertyTypeSlider extends \Elementor\Widget_Base{
	public function get_name() {
		return 'bridge_property_type_slider';
	}

	public function get_title() {
		return esc_html__( 'Property Type Slider', 'qode-real-estate' );
	}

	public function get_icon() {
		return 'bridge-elementor-custom-icon bridge-elementor-property-type-slider';
	}

	public function get_categories() {
		return [ 'qode-real-estate' ];
	}

	private function get_all_property_types() {
		$formatted_array = array();

		$terms = get_terms( array(
			'taxonomy' => 'property-type',
			'hide_empty' => false,
		) );

		if( is_array( $terms ) && count( $terms ) > 0 ) {
			foreach ( $terms as $term ) {
				$formatted_array[$term->slug] = $term->name;
			}
		}

		return $formatted_array;
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
			'type',
			[
				'label' => esc_html__('Show Only Certain Property Types', 'qode-real-estate'),
				'type' => \Elementor\Controls_Manager::SELECT2,
				'options' => $this->get_all_property_types(),
				'multiple' => true,
			]
		);

		$this->add_control(
			'number_of_visible_items',
			[
				'label' => esc_html__('Number Of Visible Items', 'qode-real-estate'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'1' => esc_html__( 'One', 'qode-real-estate' ),
					'2' => esc_html__( 'Two', 'qode-real-estate' ),
					'3' => esc_html__( 'Three', 'qode-real-estate' ),
					'4' => esc_html__( 'Four', 'qode-real-estate' ),
					'5' => esc_html__( 'Five', 'qode-real-estate' ),
					'6' => esc_html__( 'Six', 'qode-real-estate' ),
				],
				'default' => '3'
			]
		);

		$this->add_control(
			'image_proportions',
			[
				'label' => esc_html__('Image Proportions', 'qode-real-estate'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'description' => esc_html__('Set image proportions for your property type slider.', 'qode-real-estate'),
				'options' => [
					'full' => esc_html__( 'Original', 'qode-real-estate' ),
					'square' => esc_html__( 'Square', 'qode-real-estate' ),
					'landscape' => esc_html__( 'Landscape', 'qode-real-estate' ),
					'portrait' => esc_html__( 'Portrait', 'qode-real-estate' ),
					'thumbnail' => esc_html__( 'Thumbnail', 'qode-real-estate' ),
					'medium' => esc_html__( 'Medium', 'qode-real-estate' ),
					'large' => esc_html__( 'Large', 'qode-real-estate' ),
				],
				'default' => 'full'
			]
		);

		$this->add_control(
			'slider_navigation',
			[
				'label' => esc_html__( 'Enable Slider Navigation Arrows', 'qode-real-estate' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => bridge_qode_get_yes_no_select_array(),
				'default' => 'yes'
			]
		);

		$this->end_controls_section();
	}

	protected function render(){
		$params = $this->get_settings_for_display();

		$args = array(
			'number_of_visible_items' => '4',
			'type'                    => '',
			'image_proportions'       => 'full',
			'slider_navigation'       => 'no',
		);
		$params = shortcode_atts($args, $params);

		if( is_array( $params['type'] ) ) {
			$params['type'] = implode(',', $params['type']);
		}

		/***
		 * @params query_results
		 * @params holder_data
		 */
		$additional_params = array();

		$property_types = $this->getTaxonomyList($params);
		$params['property_types'] = $property_types;

		$params['data_attr'] = $this->getSliderData($params);

		$params['image_proportions'] = $this->getImageSize($params);

		$params['item_layout'] = 'standard';
		$params['this_object'] = $this;

		echo qodef_re_get_cpt_shortcode_module_template_part('property', 'property-type-slider', 'holder', '', $params, $additional_params);
	}

	/**
	 * Generates property image size
	 *
	 * @param $params
	 *
	 * @return string
	 */
	public function getImageSize($params){
		$thumb_size = 'full';

		if ( ! empty( $params['image_proportions']) ) {
			$image_size = $params['image_proportions'];

			switch ( $image_size ) {
				case 'landscape':
					$thumb_size = 'bridge_qode_landscape';
					break;
				case 'portrait':
					$thumb_size = 'bridge_qode_portrait';
					break;
				case 'square':
					$thumb_size = 'bridge_qode_square';
					break;
				case 'thumbnail':
					$thumb_size = 'thumbnail';
					break;
				case 'medium':
					$thumb_size = 'medium';
					break;
				case 'large':
					$thumb_size = 'large';
					break;
				case 'full':
					$thumb_size = 'full';
					break;
			}
		}

		return $thumb_size;
	}

	private function getSliderData($params) {
		$slider_data = array();

		$slider_data['data-number-of-items'] = !empty($params['number_of_visible_items']) ? $params['number_of_visible_items'] : '1';

		$slider_data['data-enable-center'] = 'yes';

		$slider_data['data-slider-padding'] = '100';

		$slider_data['data-enable-navigation'] = ! empty( $params['slider_navigation'] ) ? $params['slider_navigation'] : 'no';

		return $slider_data;
	}

	/**
	 * Generates property types list
	 *
	 *
	 * @return array
	 */
	public function getTaxonomyList($params) {

		if (!empty ($params['type'])) {
			$property_type = array();

			$list_of_types = explode(',', $params['type']);

			foreach ($list_of_types as $type) {
				$tax = get_term_by( 'slug', $type, 'property-type');
				if( !is_wp_error($tax) && $tax) {
					$property_type[] = $tax;
				}
			}
		} else {
			$property_type = qodef_re_get_taxonomy_list('property-type', false, 'obj');
		}

		return $property_type;
	}
}

\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new QodeREPropertyTypeSlider() );
