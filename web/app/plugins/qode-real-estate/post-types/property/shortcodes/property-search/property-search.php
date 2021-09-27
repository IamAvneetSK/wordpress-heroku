<?php

namespace QodefRE\CPT\Shortcodes\Property;

use QodefRE\Lib;

class PropertySearch implements Lib\ShortcodeInterface {
    private $base;

    public function __construct() {
        $this->base = 'qodef_property_search';

        add_action( 'vc_before_init', array( $this, 'vcMap' ) );
    }

    public function getBase() {
        return $this->base;
    }

    public function vcMap() {
        if ( function_exists( 'vc_map' ) ) {
            vc_map( array(
                    'name'                      => esc_html__( 'Qode Property Search', 'qode-real-estate' ),
                    'base'                      => $this->getBase(),
                    'category'                  => esc_html__( 'by QODE REAL ESTATE', 'qode-real-estate' ),
                    'icon'                      => 'icon-wpb-property-search extended-custom-re-icon',
                    'allowed_container_element' => 'vc_row',
                    'params'                    => array(
                        array(
                            'type'        => 'dropdown',
                            'param_name'  => 'fullheight',
                            'heading'     => esc_html__( 'Full Height Search', 'qode-real-estate' ),
                            'value'       => array_flip( bridge_qode_get_yes_no_select_array( false ) ),
                            'save_always' => true,
                        ),
                        array(
                            'type'        => 'textfield',
                            'param_name'  => 'subtitle',
                            'heading'     => esc_html__( 'Search subtitle', 'qode-real-estate' ),
                            'save_always' => true,
                        ),
                        array(
                            'type'        => 'textfield',
                            'param_name'  => 'title',
                            'heading'     => esc_html__( 'Search title', 'qode-real-estate' ),
                            'save_always' => true,
                        ),
                        array(
                            'type'        => 'dropdown',
                            'param_name'  => 'enable_type',
                            'heading'     => esc_html__( 'Enable Type', 'qode-real-estate' ),
                            'description' => esc_html__( 'Enable type as parameter for search', 'qode-real-estate' ),
                            'value'       => array_flip( bridge_qode_get_yes_no_select_array( false, true ) ),
                            'admin_label' => true
                        ),
                        array(
                            'type'        => 'dropdown',
                            'param_name'  => 'enable_city',
                            'heading'     => esc_html__( 'Enable City', 'qode-real-estate' ),
                            'description' => esc_html__( 'Enable city as parameter for search', 'qode-real-estate' ),
                            'value'       => array_flip( bridge_qode_get_yes_no_select_array( false, true ) ),
                            'admin_label' => true
                        ),
                        array(
                            'type'        => 'dropdown',
                            'param_name'  => 'enable_status',
                            'heading'     => esc_html__( 'Enable Status', 'qode-real-estate' ),
                            'description' => esc_html__( 'Enable status as parameter for search', 'qode-real-estate' ),
                            'value'       => array_flip( bridge_qode_get_yes_no_select_array( false, true ) ),
                            'admin_label' => true
                        ),
                        array(
                            'type'       => 'dropdown',
                            'param_name' => 'skin',
                            'heading'    => esc_html__( 'Skin', 'qode-real-estate' ),
                            'value'      => array(
                                esc_html__( 'Default', 'qode-real-estate' ) => '',
                                esc_html__( 'Light', 'qode-real-estate' )   => 'qodef-light-skin',
                            ),
                            'save_always' => true
                        ),
                        array(
                            'type'        => 'textfield',
                            'param_name'  => 'button_text',
                            'heading'     => esc_html__( 'Button Text', 'qode-real-estate' ),
                            'value'       => esc_html__( 'Search Places', 'qode-real-estate' ),
                            'save_always' => true,
                            'group'       => esc_html__( 'Button Style', 'qode-real-estate' )
                        ),
                        array(
                            'type'        => 'dropdown',
                            'param_name'  => 'button_type',
                            'heading'     => esc_html__( 'Button Type', 'qode-real-estate' ),
                            'value'       => array(
                                esc_html__( 'Solid', 'qode-real-estate' )   => 'solid',
                                esc_html__( 'Outline', 'qode-real-estate' ) => 'outline'
                            ),
                            'save_always' => true,
                            'group'       => esc_html__( 'Button Style', 'qode-real-estate' )
                        ),
                        array(
                            'type'        => 'dropdown',
                            'param_name'  => 'button_size',
                            'heading'     => esc_html__( 'Button Size', 'qode-real-estate' ),
                            'value'       => array(
                                esc_html__( 'Default', 'qode-real-estate' ) => '',
                                esc_html__( 'Small', 'qode-real-estate' )   => 'small',
                                esc_html__( 'Medium', 'qode-real-estate' )  => 'medium',
                                esc_html__( 'Large', 'qode-real-estate' )   => 'large'
                            ),
                            'save_always' => true,
                            'dependency'  => array( 'element' => 'button_type', 'value'   => array( 'solid', 'outline' ) ),
                            'group'       => esc_html__( 'Button Style', 'qode-real-estate' )
                        ),
                        array(
                            'type'       => 'colorpicker',
                            'param_name' => 'button_color',
                            'heading'    => esc_html__( 'Button Color', 'qode-real-estate' ),
                            'group'      => esc_html__( 'Button Style', 'qode-real-estate' )
                        ),
                        array(
                            'type'       => 'colorpicker',
                            'param_name' => 'button_hover_color',
                            'heading'    => esc_html__( 'Button Hover Color', 'qode-real-estate' ),
                            'group'      => esc_html__( 'Button Style', 'qode-real-estate' )
                        ),
                        array(
                            'type'       => 'colorpicker',
                            'param_name' => 'button_background_color',
                            'heading'    => esc_html__( 'Button Background Color', 'qode-real-estate' ),
                            'dependency' => array( 'element' => 'button_type', 'value' => array( 'solid' ) ),
                            'group'      => esc_html__( 'Button Style', 'qode-real-estate' )
                        ),
                        array(
                            'type'       => 'colorpicker',
                            'param_name' => 'button_hover_background_color',
                            'heading'    => esc_html__( 'Button Hover Background Color', 'qode-real-estate' ),
                            'group'      => esc_html__( 'Button Style', 'qode-real-estate' )
                        ),
                        array(
                            'type'       => 'colorpicker',
                            'param_name' => 'button_border_color',
                            'heading'    => esc_html__( 'Button Border Color', 'qode-real-estate' ),
                            'group'      => esc_html__( 'Button Style', 'qode-real-estate' )
                        ),
                        array(
                            'type'       => 'colorpicker',
                            'param_name' => 'button_hover_border_color',
                            'heading'    => esc_html__( 'Button Hover Border Color', 'qode-real-estate' ),
                            'group'      => esc_html__( 'Button Style', 'qode-real-estate' )
                        ),
                    )
                )
            );
        }
    }

    /**
     * Renders shortcodes HTML
     *
     * @param $atts array of shortcode params
     * @param $content string shortcode content
     *
     * @return string
     */
    public function render($atts, $content = null) {
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
        
        $params = shortcode_atts($args, $atts);

        $additional_params = array();

        $additional_params['button_parameters'] = $this->getButtonParameters( $params );
        $additional_params['holder_classes']    = $this->getHolderClasses( $params );
        $additional_params['property_search']   = $this;

        $html = qodef_re_get_cpt_shortcode_module_template_part( 'property', 'property-search', 'holder', '', $params, $additional_params );

        return $html;
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