<?php

namespace QodefRE\CPT\Shortcodes\Property;

use QodefRE\Lib;

class PropertyTypeSlider implements Lib\ShortcodeInterface
{
    private $base;

    public function __construct() {
        $this->base = 'qodef_property_type_slider';

        add_action('vc_before_init', array($this, 'vcMap'));

        //Property city list filter
        add_filter('vc_autocomplete_qodef_property_type_slider_type_callback', array(&$this, 'portfolioTypeAutocompleteSuggester',), 10, 1); // Get suggestion(find). Must return an array

        //Property city list render
        add_filter('vc_autocomplete_qodef_property_type_slider_type_render', array(&$this, 'portfolioTypeAutocompleteRender',), 10, 1); // Get suggestion(find). Must return an array
    }

    public function getBase() {
        return $this->base;
    }

    public function vcMap() {
        if (function_exists('vc_map')) {
            vc_map(array(
                    'name'                      => esc_html__('Qode Property Type Slider', 'qode-real-estate'),
                    'base'                      => $this->getBase(),
                    'category'                  => esc_html__('by QODE REAL ESTATE', 'qode-real-estate'),
                    'icon'                      => 'icon-wpb-property-type-slider extended-custom-re-icon',
                    'allowed_container_element' => 'vc_row',
                    'params'                    => array(
                        array(
                            'type'        => 'autocomplete',
                            'param_name'  => 'type',
                            'heading'     => esc_html__('Show Only Property Types with Listed Slugs', 'qode-real-estate'),
                            'settings'    => array(
                                'multiple'      => true,
                                'sortable'      => true,
                                'unique_values' => true
                            ),
                            'description' => esc_html__('Delimit slugs by comma (leave empty for all)', 'qode-real-estate')
                        ),
                        array(
                            'type'        => 'dropdown',
                            'param_name'  => 'number_of_visible_items',
                            'heading'     => esc_html__('Number Of Visible Items', 'qode-real-estate'),
                            'value'       => array(
                                esc_html__('One', 'qode-real-estate')   => '1',
                                esc_html__('Two', 'qode-real-estate')   => '2',
                                esc_html__('Three', 'qode-real-estate') => '3',
                                esc_html__('Four', 'qode-real-estate')  => '4',
                                esc_html__('Five', 'qode-real-estate')  => '5',
                                esc_html__('Six', 'qode-real-estate')   => '6'
                            ),
                            'save_always' => true,
                            'group'       => esc_html__('Slider Settings', 'qode-real-estate')
                        ),
                        array(
                            'type'        => 'dropdown',
                            'param_name'  => 'image_proportions',
                            'heading'     => esc_html__('Image Proportions', 'qode-real-estate'),
                            'value'       => array(
                                esc_html__('Original', 'qode-real-estate')  => 'full',
                                esc_html__('Square', 'qode-real-estate')    => 'square',
                                esc_html__('Landscape', 'qode-real-estate') => 'landscape',
                                esc_html__('Portrait', 'qode-real-estate')  => 'portrait',
                                esc_html__('Thumbnail', 'qode-real-estate') => 'thumbnail',
                                esc_html__('Medium', 'qode-real-estate')    => 'medium',
                                esc_html__('Large', 'qode-real-estate')     => 'large'
                            ),
                            'description' => esc_html__('Set image proportions for your property type slider.', 'qode-real-estate'),
                        ),
                        array(
	                        'type'        => 'dropdown',
	                        'param_name'  => 'slider_navigation',
	                        'heading'     => esc_html__( 'Enable Slider Navigation Arrows', 'qode-real-estate' ),
	                        'value'       => array_flip( bridge_qode_get_yes_no_select_array() ),
	                        'save_always' => true
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
            'number_of_visible_items' => '4',
            'type'                    => '',
            'image_proportions'       => 'full',
            'slider_navigation'       => 'no',
        );
        $params = shortcode_atts($args, $atts);

        /***
         * @params query_results
         * @params holder_data
         */
        $additional_params = array();

        $property_types = $this->getTaxonomyList($params);
        $params['property_types'] = $property_types;

        $params['data_attr'] = $this->getSliderData($params);

        $params['image_proportions'] = $this->getImageSize($params);

        $params['item_layout'] = 'standard';
        $params['this_object'] = $this;

        $html = qodef_re_get_cpt_shortcode_module_template_part('property', 'property-type-slider', 'holder', '', $params, $additional_params);

        return $html;
    }

    /**
     * Generates property image size
     *
     * @param $params
     *
     * @return string
     */
    public function getImageSize($params){
        $thumb_size = 'full';

        if ( ! empty( $params['image_proportions']) ) {
            $image_size = $params['image_proportions'];

            switch ( $image_size ) {
                case 'landscape':
                    $thumb_size = 'bridge_qode_landscape';
                    break;
                case 'portrait':
                    $thumb_size = 'bridge_qode_portrait';
                    break;
                case 'square':
                    $thumb_size = 'bridge_qode_square';
                    break;
                case 'thumbnail':
                    $thumb_size = 'thumbnail';
                    break;
                case 'medium':
                    $thumb_size = 'medium';
                    break;
                case 'large':
                    $thumb_size = 'large';
                    break;
                case 'full':
                    $thumb_size = 'full';
                    break;
            }
        }

        return $thumb_size;
    }

    private function getSliderData($params) {
        $slider_data = array();

        $slider_data['data-number-of-items'] = !empty($params['number_of_visible_items']) ? $params['number_of_visible_items'] : '1';

        $slider_data['data-enable-center'] = 'yes';

        $slider_data['data-slider-padding'] = '100';
	
	    $slider_data['data-enable-navigation'] = ! empty( $params['slider_navigation'] ) ? $params['slider_navigation'] : 'no';

        return $slider_data;
    }

    /**
     * Generates property types list
     *
     *
     * @return array
     */
    public function getTaxonomyList($params) {

        if (!empty ($params['type'])) {
            $property_type = array();

            $list_of_types = explode(',', $params['type']);

            foreach ($list_of_types as $type) {
                $tax = get_term_by( 'slug', $type, 'property-type');
                if( !is_wp_error($tax) && $tax) {
                    $property_type[] = $tax;
                }
            }
        } else {
            $property_type = qodef_re_get_taxonomy_list('property-type', false, 'obj');
        }

        return $property_type;
    }

    /**
     * Filter property type
     *
     * @param $query
     *
     * @return array
     */
    public function portfolioTypeAutocompleteSuggester($query) {
        global $wpdb;
        $post_meta_infos = $wpdb->get_results($wpdb->prepare("SELECT a.slug AS slug, a.name AS property_type_title
					FROM {$wpdb->terms} AS a
					LEFT JOIN ( SELECT term_id, taxonomy  FROM {$wpdb->term_taxonomy} ) AS b ON b.term_id = a.term_id
					WHERE b.taxonomy = 'property-type' AND a.name LIKE '%%%s%%'", stripslashes($query)), ARRAY_A);

        $results = array();
        if (is_array($post_meta_infos) && !empty($post_meta_infos)) {
            foreach ($post_meta_infos as $value) {
                $data = array();
                $data['value'] = $value['slug'];
                $data['label'] = ((strlen($value['property_type_title']) > 0) ? esc_html__('Property Type', 'qode-real-estate') . ': ' . $value['property_type_title'] : '');
                $results[] = $data;
            }
        }

        return $results;
    }

    /**
     * Find property type by slug
     * @since 4.4
     *
     * @param $query
     *
     * @return bool|array
     */
    public function portfolioTypeAutocompleteRender($query) {
        $query = trim($query['value']); // get value from requested
        if (!empty($query)) {
            // get portfolio category
            $property_type = get_term_by('slug', $query, 'property-type');
            if (is_object($property_type)) {

                $portfolio_type_slug = $property_type->slug;
                $portfolio_type_title = $property_type->name;

                $portfolio_type_title_display = '';
                if (!empty($portfolio_type_title)) {
                    $portfolio_type_title_display = esc_html__('Property Type', 'qode-real-estate') . ': ' . $portfolio_type_title;
                }

                $data = array();
                $data['value'] = $portfolio_type_slug;
                $data['label'] = $portfolio_type_title_display;

                return !empty($data) ? $data : false;
            }

            return false;
        }

        return false;
    }
}