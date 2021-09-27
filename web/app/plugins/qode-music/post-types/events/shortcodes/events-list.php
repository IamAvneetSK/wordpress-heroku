<?php

namespace QodeMusic\CPT\Events\Shortcodes;

use QodeMusic\Lib;

/**
 * Class EventsList
 * @package QodeMusic\CPT\Events\Shortcodes
 */
class EventsList implements Lib\ShortcodeInterface {
    /**
     * @var string
     */
    private $base;

    public function __construct() {
        $this->base = 'qode_events_list';

        add_action('vc_before_init', array($this, 'vcMap'));
    }

    /**
     * Returns base for shortcode
     * @return string
     */
    public function getBase() {
        return $this->base;
    }

   /**
     * Maps shortcode to Visual Composer
     *
     * @see vc_map()
     */

    public function vcMap() {
        if(function_exists('vc_map')) {

            vc_map( array(
                    'name' => esc_html__('Events List','qode-music') ,
                    'base' => $this->base,
                    'category' => esc_html__('by QODE MUSIC', 'qode-music') ,
                    'icon' => 'icon-wpb-events extended-custom-icon-qode',
                    'allowed_container_element' => 'vc_row',
                    'params' => array(
                        array(
                            'type' => 'dropdown',
                            'heading' => esc_html__('Title Tag', 'qode-music') ,
                            'param_name' => 'title_tag',
                            'value'  => array(
                                ''   => '',
                                'h1' => 'h1',
                                'h2' => 'h2',
                                'h3' => 'h3',
                                'h4' => 'h4',
                                'h5' => 'h5',
                                'h6' => 'h6',
                            ),
                            'admin_label' => true,
                            'description' => '',
                            'group' => esc_html__('Design Options', 'qode-music') ,
                        ),
                        array(
                            'type' => 'textfield',
                            'heading' => esc_html__('Number of Events Per Page', 'qode-music') ,
                            'param_name' => 'number',
                            'value' => '-1',
                            'admin_label' => true,
                            'description' => esc_html__('(enter -1 to show all)', 'qode-music') ,
                            'group' => esc_html__('Query and Layout Options', 'qode-music') ,
                        ),
                        array(
                            'type' => 'dropdown',
                            'heading' => esc_html__('Order By', 'qode-music') ,
                            'param_name' => 'order_by',
                            'value' => array(
                                esc_html__('Start Date','qode-music') => 'start-date',
                                esc_html__('Menu Order','qode-music') => 'menu_order',
                                esc_html__('Title','qode-music') => 'title',
                                esc_html__('Date','qode-music') => 'date'
                            ),
                            'admin_label' => true,
                            'save_always' => true,
                            'description' => '',
                            'group' => esc_html__('Query and Layout Options','qode-music') ,
                        ),
                        array(
                            'type' => 'dropdown',
                            'heading' => esc_html__('Order','qode-music') ,
                            'param_name' => 'order',
                            'value' => array(
                                'ASC' => 'ASC',
                                'DESC' => 'DESC',
                            ),
                            'admin_label' => true,
                            'save_always' => true,
                            'description' => '',
                            'group' => esc_html__('Query and Layout Options','qode-music') ,
                        ),
                        array(
                            'type' => 'dropdown',
                            'heading' => esc_html__('Show Event by Status','qode-music'),
                            'param_name' => 'event_status',
                            'value' => array(
                                esc_html__('All','qode-music')                    => 'all',
                                esc_html__('Current and Upcoming','qode-music')   => 'upcoming',
                                esc_html__('Past','qode-music')                   => 'past',
                            ),
                            'group' => esc_html__('Query and Layout Options','qode-music')
                        ),
                        array(
                            'type' => 'dropdown',
                            'heading' => esc_html__('Show Load More','qode-music') ,
                            'param_name' => 'show_load_more',
                            'value' => array(
                                esc_html__('No','qode-music')  => 'no',
                                esc_html__('Yes','qode-music') => 'yes'

                            ),
                            'group' => esc_html__('Query and Layout Options', 'qode-music')
                        ),
                        array(
                            'type' => 'textfield' ,
                            'heading' => esc_html__('Load More label','qode-music') ,
                            'param_name' => 'load_more_label' ,
                            'group' => esc_html__('Query and Layout Options', 'qode-music') ,
                            'dependency' => array('element' => 'show_load_more', 'value' => 'yes')
                        ),
                        array(
                            'type' => 'colorpicker',
                            'heading' => esc_html__('Date Text Color','qode-music') ,
                            'param_name' => 'text_color',
                            'admin_label' => true,
                            'group' => esc_html__('Design Options','qode-music') ,
                        ),
                        array(
                            'type' => 'colorpicker',
                            'heading' => esc_html__('Border Color','qode-music') ,
                            'param_name' => 'border_color',
                            'admin_label' => true,
                            'group' => esc_html__('Design Options','qode-music') ,
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
     * @return string
     */
    public function render($atts, $content = null) {

        $args = array(
            'order_by'      => 'start-date',
            'order'         => 'ASC',
            'number'        => '-1',
            'event_status'  => 'all',
            'title_tag'     => 'h5',
            'text_color'    => '',
            'border_color'  => '',
            'show_load_more'    => '',
            'load_more_label'   => ''
            );

        $params = shortcode_atts($args, $atts);

        //Extract params for use in method
        extract($params);

		$html = '';

        $query_array = $this->getQueryArray($params);
        $query_results = new \WP_Query($query_array);
        $params['query_results'] = $query_results;

        $data_atts = $this->getDataAtts($params);
        $data_atts .= 'data-max-num-pages = '.$query_results->max_num_pages;

		$params['text_color_style']	= $this->getEventsListTextColor($params);
		$params['border_color_style']	= $this->getEventsListBorderColor($params);
        $classes = $this->getEventsClasses($params);
        

		$html .='<div class="qode-events-list-holder-outer '.$classes.'" '.$data_atts. '>';
		$html .='<div class="qode-events-list-holder clearfix">';
        

        if($query_results->have_posts()):
            while ( $query_results->have_posts() ) : $query_results->the_post();
                $current_id = get_the_ID();
				$params['title'] = get_the_title($current_id);
				$params['date'] = get_post_meta($current_id, 'qode_event_item_date', true);
				$params['link'] = get_post_meta($current_id, 'qode_event_item_link', true);
				$params['target'] = get_post_meta($current_id, 'qode_event_item_target', true);
				$params['tickets_status'] = get_post_meta($current_id, 'qode_event_item_tickets_status', true);

				$html .= qode_music_get_shortcode_module_template_part('events','templates/events-list-template', '', $params);

            endwhile;
        else:
			$html .='<p>' . esc_html__( 'Sorry, no events matched your criteria.','qode-music' ) . '</p>';

        endif;

        $html .='</div>';

        if($show_load_more == 'yes'){
            $html .= qode_music_get_shortcode_module_template_part('events','templates/load-more-template', '', $params);
        }

        wp_reset_postdata();
		
		$html .='</div>';

		return $html;
    }

    /**
     * Generates events list query attribute array
     *
     * @param $params
     *
     * @return array
     */
    public function getQueryArray($params){
        $meta_query = array();
        $order_by = $params['order_by'];

        if ($params['order_by'] == 'start-date'){
            $order_by = 'meta_value';
        }

        $query_array = array(
            'post_type' => 'qode-event',
            'orderby' => $order_by,
            'order' => $params['order'],
            'posts_per_page' => $params['number']
        );

        if ($params['order_by'] == 'start-date'){
            $query_array['meta_key'] = 'qode_event_item_date_and_time'; //here because has to be added to query
        }

        //display date by event status, ex. end date larger then todays date or if it doesn't exist compare start date
        switch ($params['event_status']) {
            case 'upcoming':
                $meta_query = array(
                    'key' => 'qode_event_item_date_and_time',
                    'value' => date("Y-m-d H:i"),
                    'compare' => '>=',
                    'type'    => 'CHAR'
                );
                break;
            case 'past':
                $meta_query = array(
                    'key' => 'qode_event_item_date_and_time',
                    'value' => date("Y-m-d H:i"),
                    'compare' => '<',
                    'type'    => 'CHAR'
                );
                break;
        }

        if (is_array($meta_query) && count($meta_query)){
            $query_array['meta_query'][] = $meta_query;
        }

        $paged = '';
        if(empty($params['next_page'])) {
            if(get_query_var('paged')) {
                $paged = get_query_var('paged');
            } elseif(get_query_var('page')) {
                $paged = get_query_var('page');
            }
        }

        if(!empty($params['next_page'])){
            $query_array['paged'] = $params['next_page'];

        } else{
            $query_array['paged'] = 1;
        }

        return $query_array;
    }
    
    
    private function getEventsListTextColor($params) {

        $text_color = array();

        if ($params['text_color'] !== '') {
            $text_color[] = 'color:' . $params['text_color'];
        }
        return implode(';', $text_color);
    }
    
    private function getEventsListBorderColor($params) {

        $border_color = array();

        if ($params['border_color'] !== '') {
            $border_color[] = 'border-color:' . $params['border_color'];
        }

        return implode(';', $border_color);
    }

    /**
     * Generates datta attributes array
     *
     * @param $params
     *
     * @return array
     */
    public function getDataAtts($params){

        $data_attr = array();
        $data_return_string = '';

        if(get_query_var('paged')) {
            $paged = get_query_var('paged');
        } elseif(get_query_var('page')) {
            $paged = get_query_var('page');
        } else {
            $paged = 1;
        }

        if(!empty($paged)) {
            $data_attr['data-next-page'] = $paged+1;
        }

        if(!empty($params['order_by'])){
            $data_attr['data-order-by'] = $params['order_by'];
        }

        if(!empty($params['order'])){
            $data_attr['data-order'] = $params['order'];
        }

        if(!empty($params['event_status'])){
            $data_attr['data-event-status'] = $params['event_status'];
        }

        if(!empty($params['number'])){
            $data_attr['data-number'] = $params['number'];
        }

        if(!empty($params['title_tag'])){
            $data_attr['data-title-tag'] = $params['title_tag'];
        }

        if(!empty($params['text_color'])){
            $data_attr['data-text-color'] = $params['text_color'];
        }

        if(!empty($params['border_color'])){
            $data_attr['data-border-color'] = $params['border_color'];
        }

        foreach($data_attr as $key => $value) {
            if($key !== '') {
                $data_return_string .= $key . '= "' . esc_attr( $value ) . '" ';
            }
        }
        return $data_return_string;
    }

    /**
     * Generates events classes
     *
     * @param $params
     *
     * @return string
     */
    public function getEventsClasses($params){
        $classes = array();
       
        if($params['show_load_more'] == 'yes') {
            $classes[] = "qode-events-load-more";
        }

        return implode(' ',$classes);

    }

}
