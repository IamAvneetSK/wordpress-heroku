<?php

namespace QodefRE\CPT\Shortcodes\Property;

use QodefRE\Lib;

class PropertyLargeSlider implements Lib\ShortcodeInterface {
    private $base;

    public function __construct() {
        $this->base = 'qodef_property_large_slider';

        add_action( 'vc_before_init', array( $this, 'vcMap' ) );
    }

    public function getBase() {
        return $this->base;
    }

    public function vcMap() {
        if ( function_exists( 'vc_map' ) ) {
            vc_map( array(
                    'name'                      => esc_html__( 'Qode Property Large Slider', 'qode-real-estate' ),
                    'base'                      => $this->getBase(),
                    'category'                  => esc_html__( 'by QODE REAL ESTATE', 'qode-real-estate' ),
                    'icon'                      => 'icon-wpb-property-large-slider extended-custom-re-icon',
                    'allowed_container_element' => 'vc_row',
                    'params'                    => array(
                        array(
                            'type'       => 'textfield',
                            'param_name' => 'slider_height',
                            'heading'    => esc_html__( 'Slider Height', 'qode-real-estate' )
                        ),
                        array(
                            'type'        => 'textfield',
                            'param_name'  => 'number_of_items',
                            'heading'     => esc_html__( 'Number of Properties', 'qode-real-estate' ),
                            'description' => esc_html__( 'Set number of items for your property slider. Enter -1 to show all.', 'qode-real-estate' ),
                            'value'       => '-1'
                        ),
                        array(
                            'type'        => 'dropdown',
                            'param_name'  => 'order_by',
                            'heading'     => esc_html__( 'Order By', 'qode-real-estate' ),
                            'value'       => array_flip( bridge_qode_get_query_order_by_array() ),
                            'save_always' => true
                        ),
                        array(
                            'type'        => 'dropdown',
                            'param_name'  => 'order',
                            'heading'     => esc_html__( 'Order', 'qode-real-estate' ),
                            'value'       => array_flip( bridge_qode_get_query_order_array() ),
                            'save_always' => true
                        ),
                        array(
                            'type'        => 'dropdown',
                            'param_name'  => 'enable_loop',
                            'heading'     => esc_html__( 'Enable Slider Loop', 'qode-real-estate' ),
                            'value'       => array_flip( bridge_qode_get_yes_no_select_array( false, true ) ),
                            'save_always' => true,
                            'group'       => esc_html__( 'Slider Settings', 'qode-real-estate' ),
                            'dependency'  => array( 'element' => 'item_type', 'value' => array( '' ) )
                        ),
                        array(
                            'type'        => 'dropdown',
                            'param_name'  => 'enable_autoplay',
                            'heading'     => esc_html__( 'Enable Slider Autoplay', 'qode-real-estate' ),
                            'value'       => array_flip( bridge_qode_get_yes_no_select_array( false, true ) ),
                            'save_always' => true,
                            'group'       => esc_html__( 'Slider Settings', 'qode-real-estate' )
                        ),
                        array(
                            'type'        => 'textfield',
                            'param_name'  => 'slider_speed',
                            'heading'     => esc_html__( 'Slide Duration', 'qode-real-estate' ),
                            'description' => esc_html__( 'Default value is 5000 (ms)', 'qode-real-estate' ),
                            'group'       => esc_html__( 'Slider Settings', 'qode-real-estate' )
                        ),
                        array(
                            'type'        => 'textfield',
                            'param_name'  => 'slider_speed_animation',
                            'heading'     => esc_html__( 'Slide Animation Duration', 'qode-real-estate' ),
                            'description' => esc_html__( 'Speed of slide animation in milliseconds. Default value is 600.', 'qode-real-estate' ),
                            'group'       => esc_html__( 'Slider Settings', 'qode-real-estate' )
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
            'slider_height' => '577',
            'number_of_columns'         => '1',
            'number_of_items'           => '-1',
            'order_by'                  => 'date',
            'order'                     => 'DESC',
            'enable_loop'               => 'yes',
            'enable_autoplay'		    => 'yes',
            'slider_speed'              => '5000',
            'slider_speed_animation'    => '600'
        );
        $params = shortcode_atts($args, $atts);

        $query_array = qodef_re_generate_query_array($params);
        $query_results = new \WP_Query($query_array);
        $additional_params['query_results'] = $query_results;

        $params['styles'] = $this->getSliderStyle($params);

        $html = qodef_re_get_cpt_shortcode_module_template_part( 'property', 'property-large-slider', 'holder', '', $params, $additional_params);

        return $html;
    }


    private function getSliderStyle($params){
        $styles = array();

        $styles['qodef-item-featured-image'] = array();

        if (!empty($params['slider_height'])) {
            $styles['qodef-item-featured-image'][] = 'height: ' . bridge_qode_filter_px($params['slider_height']) . 'px';
        }

        return $styles;
    }

}