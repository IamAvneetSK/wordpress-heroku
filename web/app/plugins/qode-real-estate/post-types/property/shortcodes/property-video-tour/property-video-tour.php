<?php

namespace QodefRE\CPT\Shortcodes\Property;

use QodefRE\Lib;

class PropertyVideoTour implements Lib\ShortcodeInterface
{
    private $base;

    public function __construct() {
        $this->base = 'qodef_property_video_tour';

        add_action('vc_before_init', array($this, 'vcMap'));

        //Property city list filter
        add_filter('vc_autocomplete_qodef_property_video_tour_property_id_callback', array(&$this, 'propertyIdAutocompleteSuggester',), 10, 1); // Get suggestion(find). Must return an array

        //Property city list render
        add_filter('vc_autocomplete_qodef_property_video_tour_id_render', array(&$this, 'propertyIdAutocompleteRender',), 10, 1); // Get suggestion(find). Must return an array
    }

    public function getBase() {
        return $this->base;
    }

    public function vcMap() {
        if (function_exists('vc_map')) {
            vc_map(array(
                    'name'                      => esc_html__('Qode Property Video Tour', 'qode-real-estate'),
                    'base'                      => $this->getBase(),
                    'category'                  => esc_html__('by QODE REAL ESTATE', 'qode-real-estate'),
                    'icon'                      => 'icon-wpb-property-video-tour extended-custom-re-icon',
                    'allowed_container_element' => 'vc_row',
                    'params'                    => array(

                        array(
                            'type'        => 'autocomplete',
                            'param_name'  => 'property_id',
                            'heading'     => esc_html__('Property ID', 'qode-real-estate'),
                            'settings'    => array(
                                'multiple'      => false,
                                'sortable'      => true,
                                'unique_values' => true
                            )
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
            'property_id' => ''
        );

        $params = shortcode_atts($args, $atts);

        $id = isset($params['property_id']) ? $params['property_id'] : get_the_ID();

        $params['id'] = $id;
        $params['video_tour_src'] = get_post_meta( $id, 'qodef_property_virtual_tour_meta', true );

        $html = qodef_re_get_cpt_shortcode_module_template_part('property', 'property-video-tour', 'property-video-tour', '', $params);

        return $html;
    }

    /**
     * Filter properties by ID or Title
     *
     * @param $query
     *
     * @return array
     */
    public function propertyIdAutocompleteSuggester($query) {
        global $wpdb;
        $property_id = (int)$query;
        $post_meta_infos = $wpdb->get_results($wpdb->prepare("SELECT ID AS id, post_title AS title
					FROM {$wpdb->posts}
					WHERE post_type = 'property' AND ( ID = '%d' OR post_title LIKE '%%%s%%' )", $property_id > 0 ? $property_id : -1, stripslashes($query), stripslashes($query)), ARRAY_A);

        $results = array();
        if (is_array($post_meta_infos) && !empty($post_meta_infos)) {
            foreach ($post_meta_infos as $value) {
                $data = array();
                $data['value'] = $value['id'];
                $data['label'] = esc_html__('Id', 'qode-real-estate') . ': ' . $value['id'] . ((strlen($value['title']) > 0) ? ' - ' . esc_html__('Title', 'qode-real-estate') . ': ' . $value['title'] : '');
                $results[] = $data;
            }
        }

        return $results;
    }

    /**
     * Find portfolio by id
     * @since 4.4
     *
     * @param $query
     *
     * @return bool|array
     */
    public function propertyIdAutocompleteRender($query) {
        $query = trim($query['value']); // get value from requested
        if (!empty($query)) {
            // get portfolio
            $property = get_post((int)$query);
            if (!is_wp_error($property)) {

                $property_id = $property->ID;
                $property_title = $property->post_title;

                $property_title_display = '';
                if (!empty($property_title)) {
                    $property_title_display = ' - ' . esc_html__('Title', 'qode-real-estate') . ': ' . $property_title;
                }

                $property_id_display = esc_html__('Id', 'qode-real-estate') . ': ' . $property_id;

                $data = array();
                $data['value'] = $property_id;
                $data['label'] = $property_id_display . $property_title_display;

                return !empty($data) ? $data : false;
            }

            return false;
        }

        return false;
    }
}