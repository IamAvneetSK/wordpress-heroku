<?php

class QodeRestaurantElementorRestaurantTimeline extends \Elementor\Widget_Base{
    public function get_name() {
        return 'bridge_restaurant_timeline';
    }

    public function get_title() {
        return esc_html__( 'Restaurant Timeline', 'qode-restaurant' );
    }

    public function get_icon() {
        return 'bridge-elementor-custom-icon bridge-elementor-restaurant-timeline';
    }

    public function get_categories() {
        return [ 'qode-restaurant' ];
    }

    protected function _register_controls() {

        $this->start_controls_section(
            'general',
            [
                'label' => esc_html__( 'General', 'qode-restaurant' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'title',
            [
                'label' => esc_html__( 'Title', 'qode-restaurant' ),
                'type' => \Elementor\Controls_Manager::TEXT
            ]
        );

        $repeater->add_control(
            'text',
            [
                'label' => esc_html__( 'Title', 'qode-restaurant' ),
                'type' => \Elementor\Controls_Manager::TEXTAREA
            ]
        );

        $repeater->add_control(
            'image',
            [
                'label' => esc_html__( 'Image', 'qode-restaurant' ),
                'type' => \Elementor\Controls_Manager::MEDIA
            ]
        );

        $this->add_control(
            'restaurant_items',
            [
                'label' => esc_html__( 'Restaurant Timeline Items', 'qode-restaurant' ),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'title_field' => esc_html__('Restaurant Timeline Item'),
            ]
        );

        $this->end_controls_section();
    }

    protected function render(){
        $params = $this->get_settings_for_display();

        foreach ($params['restaurant_items'] as $key => $value){
            $params['restaurant_items'][$key]['image'] = $params['restaurant_items'][$key]['image']['id'];
        }

        echo qode_restaurant_get_template_part('modules/shortcodes/restaurant-timeline/templates/restaurant-timeline-template', '', $params, true);
    }
}

\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new QodeRestaurantElementorRestaurantTimeline() );