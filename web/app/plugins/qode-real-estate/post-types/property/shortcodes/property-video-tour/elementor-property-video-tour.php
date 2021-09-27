<?php

class QodeREPropertyVideoTour extends \Elementor\Widget_Base{
	public function get_name() {
		return 'bridge_property_video_tour';
	}

	public function get_title() {
		return esc_html__( 'Property Video Tour', 'qode-real-estate' );
	}

	public function get_icon() {
		return 'bridge-elementor-custom-icon bridge-elementor-property-video-tour';
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
				'label' => esc_html__('Property ID', 'qode-real-estate'),
				'type' => \Elementor\Controls_Manager::SELECT2,
				'options' => $this->get_all_properties()
			]
		);

		$this->end_controls_section();
	}

	protected function render(){
		$params = $this->get_settings_for_display();

		$id = isset($params['property_id']) ? $params['property_id'] : get_the_ID();

		$params['id'] = $id;
		$params['video_tour_src'] = get_post_meta( $id, 'qodef_property_virtual_tour_meta', true );

		echo qodef_re_get_cpt_shortcode_module_template_part('property', 'property-video-tour', 'property-video-tour', '', $params);
	}
}

\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new QodeREPropertyVideoTour() );
