<?php

class QodeREPropertySingle extends \Elementor\Widget_Base{
	public function get_name() {
		return 'bridge_property_single';
	}

	public function get_title() {
		return esc_html__( 'Property Single', 'qode-real-estate' );
	}

	public function get_icon() {
		return 'bridge-elementor-custom-icon bridge-elementor-property-single';
	}

	public function get_categories() {
		return [ 'qode-real-estate' ];
	}

	private function get_all_properties() {
		$formatted_array = array();

		$args = array(
			'post_type' => 'property',
			'post_status' => 'publish',
			'posts_per_page' => -1
		);
		$pages = get_posts($args);

		if( is_array( $pages ) && count( $pages ) > 0 ) {
			foreach ( $pages as $page ) {
				$formatted_array[$page->ID] = $page->post_title;
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
			'property_id',
			[
				'label' => esc_html__('Show Only Property with ID', 'qode-real-estate'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => $this->get_all_properties(),
			]
		);

		$this->end_controls_section();
	}

	protected function render(){
		$params = $this->get_settings_for_display();

		$id = isset($params['property_id']) ? $params['property_id'] : get_the_ID();

		//gallery images
		$gallery_images = get_post_meta($id, 'qodef_property_image_gallery', true);
		$params['image_ids'] = explode(',', $gallery_images);

		//price
		$params['price'] = qodef_re_get_real_estate_item_price($id);

		//full address
		$params['title'] = get_the_title($id);

		//property id meta field
		$property_id_meta = get_post_meta(get_the_ID(), 'qodef_property_id_meta', true);
		$params['property_id_meta'] = !(empty($property_id_meta)) ? $property_id_meta : '';

		//property size
		$params['property_size'] = get_post_meta($id, 'qodef_property_size_meta', true);

		$params['size_label'] = bridge_qode_get_meta_field_intersect('property_size_label', $id);

		//structure - bedrooms
		$structure = get_post_meta($id, 'qodef_property_bedrooms_meta', true);
		if( !empty($structure) ) {
			$structure_label = $structure == 1 ? esc_html__('Bedroom', 'qode-real-estate') : esc_html__('Bedrooms', 'qode-real-estate');
			$structure .= ' '. $structure_label;
		}
		$params['structure'] = $structure;

		//accommodation
		$params['accommodation'] = get_post_meta($id, 'qodef_property_accommodation_meta', true);

		//accommodation
		$params['heating'] = get_post_meta($id, 'qodef_property_heating_meta', true);

		echo qodef_re_get_cpt_shortcode_module_template_part('property', 'property-single', 'property-single', '', $params);
	}
}

\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new QodeREPropertySingle() );
