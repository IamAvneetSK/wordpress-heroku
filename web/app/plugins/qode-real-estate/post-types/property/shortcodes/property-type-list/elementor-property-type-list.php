<?php

class QodeREPropertyTypeList extends \Elementor\Widget_Base{
	public function get_name() {
		return 'bridge_property_type_list';
	}

	public function get_title() {
		return esc_html__( 'Property Type List', 'qode-real-estate' );
	}

	public function get_icon() {
		return 'bridge-elementor-custom-icon bridge-elementor-property-type-list';
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
			'skin',
			[
				'label' => esc_html__('Skin', 'qode-real-estate'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'' => esc_html__( 'Default', 'qode-real-estate' ),
					'qodef-light-skin' => esc_html__( 'Light', 'qode-real-estate' ),
				],
				'default' => ''
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

		$this->end_controls_section();
	}

	protected function render(){
		$params = $this->get_settings_for_display();

		$args = array(
			'type'                      => '',
			'skin'                      => '',
			'active_element'            => '',
			'used_for_search'           => false
		);
		$params = shortcode_atts($args, $params);

		if( is_array( $params['type'] ) ) {
			$params['type'] = implode(',', $params['type']);
		}

		$additional_params = array();

		$property_types           = $this->getTaxonomyList($params);
		$params['property_types'] = $property_types;

		$params['holder_classes']        = $this->getHolderClasses( $params );

		$params['item_layout'] = 'standard';
		$params['this_object'] = $this;

		echo qodef_re_get_cpt_shortcode_module_template_part( 'property', 'property-type-list', 'holder', '', $params, $additional_params );
	}

	/**
	 * Generates property types list
	 *
	 *
	 * @return array
	 */
	public function getTaxonomyList($params){

		if(!empty ($params['type'])) {
			$property_type = array();

			$list_of_types = explode(',',$params['type'] );

			foreach($list_of_types as $type){
				$tax = get_term_by( 'slug', $type, 'property-type');
				//$property_type[] = $tax;
				//var_dump($tax);
				if( !is_wp_error($tax) && $tax) {
					$property_type[] = $tax;
				}
			}
		} else {
			$property_type = qodef_re_get_taxonomy_list('property-type', false, 'obj');
		}

		return $property_type;
	}

	/**
	 * Generates property holder classes
	 *
	 * @param $params
	 *
	 * @return string
	 */
	public function getHolderClasses( $params ) {
		$classes = array();
		$classes[] = ! empty( $params['skin'] ) ? $params['skin'] : '';

		return implode( ' ', $classes );
	}
}

\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new QodeREPropertyTypeList() );
