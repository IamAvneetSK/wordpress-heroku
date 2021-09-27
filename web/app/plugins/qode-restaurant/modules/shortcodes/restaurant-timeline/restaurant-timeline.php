<?php
namespace QodeRestaurant\Shortcodes\RestaurantTimeline;

use QodeRestaurant\Lib\ShortcodeInterface;

class RestaurantTimeline implements ShortcodeInterface {
    private $base;

    function __construct() {
        $this->base = 'qode_restaurant_timeline';

        add_action( 'vc_before_init', array( $this, 'vcMap' ) );
    }

    public function getBase() {
        return $this->base;
    }

    public function vcMap() {
        if ( function_exists( 'vc_map' ) ) {
            vc_map(
                array(
                    'name'     => esc_html__( 'Restaurant Timeline', 'qode-restaurant' ),
                    'base'     => $this->base,
                    'icon'     => 'icon-wpb-restaurant-timeline extended-custom-icon-qode',
                    'category' => esc_html__( 'by QODE RESTAURANT', 'qode-restaurant' ),
                    'params'   => array(

                        array(
                            'type' => 'param_group',
                            'heading' => esc_html__( 'Restaurant Items', 'qode-restaurant' ),
                            'param_name' => 'restaurant_items',
                            'value' => '',
                            'params' => array(
                                array(
                                    'type'        => 'textfield',
                                    'param_name'  => 'title',
                                    'heading'     => esc_html__( 'Title', 'qode-restaurant' ),
                                    'save_always' => true,
                                    'admin_label' => true
                                ),
                                array(
                                    'type'       => 'textarea',
                                    'param_name' => 'text',
                                    'heading'    => esc_html__( 'Text', 'qode-restaurant' )
                                ),
								array(
									'type'       => 'attach_image',
									'param_name' => 'image',
									'heading'    => esc_html__( 'Image', 'qode-restaurant' )
								),
                            )
                        ),
                    )
                )
            );
        }
    }

    public function render( $atts, $content = null ) {
        $default_atts   = array(
            'restaurant_items'        => ''
        );
        $params = shortcode_atts( $default_atts, $atts );

        $params['restaurant_items'] = json_decode(urldecode($params['restaurant_items']), true);

		return qode_restaurant_get_template_part('modules/shortcodes/restaurant-timeline/templates/restaurant-timeline-template', '', $params, true);

        return $html;
    }


   


}