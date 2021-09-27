<?php

if (!function_exists('qodef_re_set_global_map_variables')) {
    /**
     * Function for setting global map variables
     */
    function qodef_re_set_global_map_variables() {
    	
    	if( qodef_re_theme_installed() ) {
			$global_map_variables = array();
		
			$global_map_variables['mapStyle'] = json_decode(bridge_qode_get_meta_field_intersect('real_estate_map_style'));
			$global_map_variables['scrollable'] = bridge_qode_options()->getOptionValue('real_estate_maps_scrollable') == 'yes' ? true : false;
			$global_map_variables['draggable'] = bridge_qode_options()->getOptionValue('real_estate_maps_draggable') == 'yes' ? true : false;
			$global_map_variables['streetViewControl'] = bridge_qode_options()->getOptionValue('real_estate_maps_street_view_control') == 'yes' ? true : false;
			$global_map_variables['zoomControl'] = bridge_qode_options()->getOptionValue('real_estate_maps_zoom_control') == 'yes' ? true : false;
			$global_map_variables['mapTypeControl'] = bridge_qode_options()->getOptionValue('real_estate_maps_type_control') == 'yes' ? true : false;
		
			$global_map_variables = apply_filters('qodef_re_filter_js_global_map_variables', $global_map_variables);
		
			wp_localize_script('bridge-default', 'qodefMapsVars', array(
				'global' => $global_map_variables
			));
		}
    }

    add_action('wp_enqueue_scripts', 'qodef_re_set_global_map_variables', 20);
}

/* SINGLE PROPERTY MAP FUNCTIONS - START */
if (!function_exists('qodef_re_set_single_property_map_variables')) {
    /**
     * Function for setting single map variables
     * @param $id - id of property
     */
    function qodef_re_set_single_property_map_variables($id = '') {
        $single_map_variables = array();

        $id = isset($id) && !empty($id) ? $id : get_the_ID();
        if ($id !== '') {
            $single_map_variables['currentRealEstate'] = qodef_re_generate_real_estate_map_params($id);
        }

        wp_localize_script('bridge-default', 'qodefSingleMapVars', array(
            'single' => $single_map_variables
        ));
    }
}

if (!function_exists('qodef_re_get_real_estate_item_map')) {
    /**
     * Function that renders map holder for single real_estate item
     *
     * @param $id - id of property loaded
     *
     * @return string
     */
    function qodef_re_get_real_estate_property_map($id) {
        $id = isset($id) && !empty($id) ? $id : get_the_ID();

        qodef_re_set_single_property_map_variables($id);

        $address_params = qodef_re_get_address_params($id);
        $latitude = $address_params['address_lat'];
        $longitude = $address_params['address_long'];


        $html = '<div id="qodef-re-single-map-holder"></div>
				<meta itemprop="latitude" content="' . $latitude . '">
				<meta itemprop="longitude" content="' . $longitude . '">';

        do_action('qodef_re_after_real_estate_map');

        return $html;
    }

}
/* SINGLE PROPERTY MAP FUNCTIONS - END */

/* MULTIPLE PROPERTY MAP FUNCTIONS - START */
if (!function_exists('qodef_re_set_multiple_property_map_variables')) {
    /**
     * Function for setting single map variables
     * @param $query - $query is used just for multiple type. $query is Wp_Query object containing real_estate items which should be presented on map
     * @param $return - whether map object should be returned (for ajax call) or passed to localize script
     *
     * @return array - array with addresses parameters
     */
    function qodef_re_set_multiple_property_map_variables($query = '', $return = false) {
        $multiple_map_variables = array();

        if ($query !== '') {
            if ($query->have_posts()) {
                while ($query->have_posts()) {
                    $query->the_post();
                    $multiple_map_variables['addresses'][] = qodef_re_generate_real_estate_map_params(get_the_ID());
                }
                wp_reset_postdata();
            }
        }

        if ($return) {
            return $multiple_map_variables;
        }

        wp_localize_script('bridge-default', 'qodefMultipleMapVars', array(
            'multiple' => $multiple_map_variables
        ));
    }
}

if (!function_exists('qodef_re_get_real_estate_multiple_map')) {
    /**
     * Function that renders map holder for multiple real_estate item
     *
     * @param $query - $query is used just for multiple type. $query is Wp_Query object containing real_estate items which should be presented on map
     *
     * @return string
     */
    function qodef_re_get_real_estate_multiple_map($query = '') {

        qodef_re_set_multiple_property_map_variables($query);

        $html = '<div id="qodef-re-multiple-map-holder"></div>';

        do_action('qodef_re_after_real_estate_map');

        return $html;

    }

}

/* MULTIPLE PROPERTY MAP FUNCTIONS - START */

/* MAP ITEMS FUNCTIONS START - */
if (!function_exists('qodef_re_marker_info_template')) {
    /**
     * Template with placeholders for marker info window
     *
     * uses underscore templates
     *
     */
    function qodef_re_marker_info_template() {

        $html = '<script type="text/template" class="qodef-info-window-template">
				<div class="qodef-info-window">
					<div class="qodef-info-window-inner">
						<a href="<%= itemUrl %>"></a>
						<% if ( featuredImage ) { %>
							<div class="qodef-info-window-image">
								<img src="<%= featuredImage[0] %>" alt="<%= title %>" width="<%= featuredImage[1] %>" height="<%= featuredImage[2] %>">
							</div>
						<% } %>
						<div class="qodef-info-window-details">
							<h5>
								<%= title %>
							</h5>
							<p><%= address %></p>
						</div>
					</div>
				</div>
			</script>';

        print bridge_qode_get_module_part($html);

    }

    add_action('qodef_re_after_real_estate_map', 'qodef_re_marker_info_template');

}

if (!function_exists('qodef_re_marker_template')) {
    /**
     * Template with placeholders for marker
     */
    function qodef_re_marker_template() {

        $html = '<script type="text/template" class="qodef-marker-template">
				<div class="qodef-map-marker">
					<div class="qodef-map-marker-inner">
					<%= pin %>
						<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
	 viewBox="0 0 31 48" enable-background="new 0 0 31 48" xml:space="preserve">
<path d="M15.5,1.1c-8.3,0-15,6.9-15,15.5c0,2.2,0.4,4.3,1.2,6.1c0.2,0.4,0.4,0.9,0.6,1.3l0.3,0.6l5.9,10.5l6.9,12.4
	l6.9-12.4l5.8-10.5l0.4-0.8c0.2-0.4,0.4-0.8,0.6-1.2c0.8-1.9,1.2-4,1.2-6.1C30.5,8,23.8,1.1,15.5,1.1z M15.5,26.7
	c-5.4,0-9.8-4.6-9.8-10.2s4.4-10.2,9.8-10.2s9.8,4.6,9.8,10.2S20.9,26.7,15.5,26.7z"/>
</svg>
					</div>
				</div>
			</script>';

        print bridge_qode_get_module_part($html);

    }

    add_action('qodef_re_after_real_estate_map', 'qodef_re_marker_template');

}
/* MAP ITEMS FUNCTIONS - END */

/* HELPER FUNCTIONS - START */
if (!function_exists('qodef_re_generate_real_estate_map_params')) {
    function qodef_re_generate_real_estate_map_params($re_item_id) {

        $re_map_params = array();

        //get listing image
        $image_id = get_post_thumbnail_id($re_item_id);
        $image = wp_get_attachment_image_src($image_id);

        //take marker pin
        $marker_pin = bridge_qode_icon_collections()->getIconHTML('icon_pin', 'font_elegant');

        //get address params
        $address_array = qodef_re_get_address_params($re_item_id);

        //Get item location
        if ($address_array['address'] === '' && $address_array['address_lat'] === '' && $address_array['address_long'] === '') {
            $re_map_params['location'] = null;
        } else {
            $re_map_params['location'] = array(
                'address'   => $address_array['address'],
                'latitude'  => $address_array['address_lat'],
                'longitude' => $address_array['address_long']
            );
        }

        $re_map_params['title'] = get_the_title($re_item_id);
        $re_map_params['itemId'] = $re_item_id;
        $re_map_params['markerPin'] = $marker_pin;
        $re_map_params['featuredImage'] = $image;
        $re_map_params['itemUrl'] = get_the_permalink($re_item_id);

        return $re_map_params;

    }
}

if (!function_exists('qodef_re_get_address_params')) {

    /**
     * Function that set up address params
     * @param $id - id of current post
     *
     * @return array
     */

    function qodef_re_get_address_params($id) {

        $address_array = array();
        $address_string = get_post_meta($id, 'qodef_property_full_address_meta', true);
        $address_lat = get_post_meta($id, 'qodef_property_full_address_latitude', true);
        $address_long = get_post_meta($id, 'qodef_property_full_address_longitude', true);

        $address_array['address'] = $address_string !== '' ? $address_string : '';
        $address_array['address_lat'] = $address_lat !== '' ? $address_lat : '';
        $address_array['address_long'] = $address_long !== '' ? $address_long : '';

        return $address_array;

    }

}
/* HELPER FUNCTIONS - END */