<?php

class QodeREPackageList extends \Elementor\Widget_Base{
	public function get_name() {
		return 'bridge_package_list';
	}

	public function get_title() {
		return esc_html__( 'Package List', 'qode-real-estate' );
	}

	public function get_icon() {
		return 'bridge-elementor-custom-icon bridge-elementor-package-list';
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
			'package_category',
			[
				'label' => esc_html__( 'Package Category', 'qode-real-estate' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => qodef_re_get_taxonomy_list('package-category', true),
				'default' => ''
			]
		);

		$this->add_control(
			'number_of_columns',
			[
				'label' => esc_html__( 'Number of Columns', 'qode-real-estate' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'' => esc_html__( 'Default', 'qode-real-estate' ),
					'1' => esc_html__( 'One', 'qode-real-estate' ),
					'2' => esc_html__( 'Two', 'qode-real-estate' ),
					'3' => esc_html__( 'Three', 'qode-real-estate' ),
					'4' => esc_html__( 'Four', 'qode-real-estate' ),
					'5' => esc_html__( 'Five', 'qode-real-estate' ),
				],
				'default' => ''
			]
		);

		$this->add_control(
			'space_between_items',
			[
				'label' => esc_html__( 'Space Between Packages', 'qode-real-estate' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => bridge_qode_get_space_between_items_array(),
			]
		);

		$this->add_control(
			'enable_border',
			[
				'label' => esc_html__( 'Enable Item Border', 'qode-real-estate' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => bridge_qode_get_yes_no_select_array(),
			]
		);

		$this->end_controls_section();
	}

	protected function render(){
		$params = $this->get_settings_for_display();

		$params['item_layout'] = 'standard';

		$query_array                        = $this->getQueryArray( $params );
		$query_results                      = new \WP_Query( $query_array );
		$additional_params['query_results'] = $query_results;

		$additional_params['holder_classes']        = $this->getHolderClasses( $params );
		$additional_params['holder_inner_classes']  = $this->getHolderInnerClasses( $params );

		$params['this_object'] = $this;

		echo qodef_re_get_cpt_shortcode_module_template_part( 'package', 'package-list', 'holder', '', $params, $additional_params );
	}

	public function getQueryArray($params) {
		$query_array = array(
			'post_status' => 'publish',
			'post_type' => 'package',
			'posts_per_page' => -1,
			'meta_key'  => 'qodef_package_price_meta',
			'orderby' => 'meta_value_num',
			'order' => 'ASC'
		);

		// TAXONOMY QUERY VALUES
		if ( ! empty( $params['package_category'] ) ) {
			$tax_query = array();

			if ( ! empty( $params['package_category'] ) ) {
				$tax_query[] = array(
					'taxonomy'  => 'package-category',
					'terms'     => $params['package_category']
				);
			}

			$query_array['tax_query'] = $tax_query;
		}

		return $query_array;
	}

	public function getHolderClasses($params) {
		$classes = array();

		$classes[] = ! empty( $params['space_between_items'] ) ? 'qode-' . $params['space_between_items'] . '-space' : 'qodef-normal-space';
		$classes[] = ! empty( $params['enable_border'] ) && $params['enable_border'] == 'yes' ? 'qodef-with-border' : 'qodef-no-border';

		$number_of_columns = $params['number_of_columns'];
		switch ( $number_of_columns ):
			case '1':
				$classes[] = 'qodef-pckgl-one-column';
				break;
			case '2':
				$classes[] = 'qodef-pckgl-two-columns';
				break;
			case '3':
				$classes[] = 'qodef-pckgl-three-columns';
				break;
			case '4':
				$classes[] = 'qodef-pckgl-four-columns';
				break;
			case '5':
				$classes[] = 'qodef-pckgl-five-columns';
				break;
			default:
				$classes[] = 'qodef-pckgl-three-columns';
				break;
		endswitch;

		return implode( ' ', $classes );
	}

	/**
	 * Generates property holder inner classes
	 *
	 * @param $params
	 *
	 * @return string
	 */
	public function getHolderInnerClasses($params){
		$classes = array();

		$classes[] = 'qode-outer-space';

		return implode(' ', $classes);
	}

	public function getArticleClasses($params) {
		$classes = array();
		$classes[] = 'qode-item-space';
		if(isset($params['featured']) && $params['featured'] == 'yes') {
			$classes[] = 'qodef-featured-package';
		}

		return implode(' ', $classes);
	}
}

\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new QodeREPackageList() );
