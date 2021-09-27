<?php

class QodeListingListingBanner extends \Elementor\Widget_Base{
    public function get_name() {
        return 'bridge_listing_banner';
    }

    public function get_title() {
        return esc_html__( 'Listing Banner', 'qode-listing' );
    }

    public function get_icon() {
        return 'bridge-elementor-custom-icon bridge-elementor-listing-banner';
    }

    public function get_categories() {
        return [ 'qode-listing' ];
    }

    protected function _register_controls() {

        $this->start_controls_section(
            'general',
            [
                'label' => esc_html__( 'General', 'qode-listing' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'background_image',
            [
                'label' => esc_html__('Background Image', 'qode-listing'),
                'type' => \Elementor\Controls_Manager::MEDIA,
            ]
        );

        bridge_qode_icon_collections()->getElementorParamsArray($this, '', '', true);

        $this->add_control(
            'number',
            [
                'label' => esc_html__('Number', 'qode-listing'),
                'type' => \Elementor\Controls_Manager::TEXT,
            ]
        );

        $this->add_control(
            'title',
            [
                'label' => esc_html__('Title', 'qode-listing'),
                'type' => \Elementor\Controls_Manager::TEXT,
            ]
        );

        $this->add_control(
            'link',
            [
                'label' => esc_html__('Link', 'qode-listing'),
                'type' => \Elementor\Controls_Manager::TEXT,
            ]
        );

        $this->add_control(
            'link_target',
            [
                'label' => esc_html__('Link Target', 'qode-listing'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    '_blank' => esc_html__('Blank', 'qode-listing'),
                    '_self' => esc_html__('Self', 'qode-listing'),
                ],
                'condition' => [
                    'link!' => ''
                ],
                'default' => '_blank'
            ]
        );

        $this->add_control(
            'skin',
            [
                'label' => esc_html__('Skin', 'qode-listing'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'dark' => esc_html__('Dark', 'qode-listing'),
                    'light' => esc_html__('Light', 'qode-listing'),
                ],
                'default' => 'dark'
            ]
        );

        $this->end_controls_section();
    }

    protected function render(){
        $params = $this->get_settings_for_display();

        $params['icon'] = bridge_qode_icon_collections()->getElementorIconFromIconPack($params);
        if( ! empty( $params['background_image'] ) ){
            $params['background_image'] = $params['background_image']['id'];
        }

        $params['holder_styles'] = $this->getImageStyle($params);
        $params['holder_icon_classes'] = $this->getIconHolderClasses($params);
        $params['holder_classes'] = $this->getHolderClasses($params);
        $params['icon_style'] = $this->getIconHolderStyle($params);

        echo qode_listing_get_shortcode_module_template_part('templates/banner', 'listing-banner', '', $params);
    }

    private function getIconHolderClasses($params) {
        $classes = array('qode-icon-holder', 'qode-icon-circle', 'qode-ls-banner-icon');

        return implode(' ', $classes);
    }
    private function getHolderClasses($params) {
        $classes = array('qode-ls-banner');

        if($params['skin'] != '') {
            $classes[] = 'qode-ls-banner-' . $params['skin'];
        }

        return implode(' ', $classes);
    }
    private function getImageStyle($params) {
        $style = array();

        if($params['background_image']) {

            $image_url = wp_get_attachment_image_src($params['background_image'], 'full');

            $style[] = 'background-image:url(' .$image_url[0] . ')';
        }

        return $style;
    }
    private function getIconHolderStyle($params) {
        $style = array();

        return $style;
    }

}

\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new QodeListingListingBanner() );