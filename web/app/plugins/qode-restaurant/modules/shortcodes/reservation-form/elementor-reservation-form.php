<?php

class QodeRestaurantElementorReservationForm extends \Elementor\Widget_Base{
    public function get_name() {
        return 'bridge_reservation_form';
    }

    public function get_title() {
        return esc_html__( 'Reservation Form', 'qode-restaurant' );
    }

    public function get_icon() {
        return 'bridge-elementor-custom-icon bridge-elementor-reservation-form';
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

        $this->add_control(
            'open_table_id',
            [
                'label' => esc_html__('OpenTable ID', 'qode-restaurant'),
                'type' => \Elementor\Controls_Manager::TEXT
            ]
        );

        $this->add_control(
            'skin',
            [
                'label' => esc_html__('Skin', 'qode-restaurant'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'dark' => esc_html__('Dark', 'qode-restaurant'),
                    'light' => esc_html__('Light', 'qode-restaurant'),
                ],
                'default' => 'dark'
            ]
        );

        $this->end_controls_section();
    }

    protected function render(){
        $params = $this->get_settings_for_display();

        $params['holderClasses'] = $this->getHolderClasses($params);
        $params['button_classes'] = $this->geButtonClasses($params);

        echo qode_restaurant_get_template_part('modules/shortcodes/reservation-form/templates/reservation-form', '', $params, true);
    }

    protected function getHolderClasses($params) {
        $classes = array('qode-rf-holder');

        if($params['skin'] === 'light') {
            $classes[] = 'qode-rf-light';
        }

        return $classes;
    }

    protected function geButtonClasses($params) {
        $classes = array();

        if($params['skin'] === 'light') {
            $classes[] = 'white';
        }

        return implode(' ', $classes);
    }

}

\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new QodeRestaurantElementorReservationForm() );