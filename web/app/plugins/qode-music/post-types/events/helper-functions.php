<?php

if(!function_exists('qode_music_events_meta_box_functions')) {
	function qode_music_events_meta_box_functions($post_types) {
		$post_types[] = 'qode-event';
		
		return $post_types;
	}
	
	add_filter('bridge_qode_filter_meta_box_post_types_save', 'qode_music_events_meta_box_functions');
	add_filter('bridge_qode_filter_meta_box_post_types_remove', 'qode_music_events_meta_box_functions');
}

if(!function_exists('qode_music_register_events_cpt')) {
	function qode_music_register_events_cpt($cpt_class_name) {
		$cpt_class = array(
			'QodeMusic\CPT\Events\EventsRegister'
		);
		
		$cpt_class_name = array_merge($cpt_class_name, $cpt_class);
		
		return $cpt_class_name;
	}
	
	add_filter('qode_music_filter_register_custom_post_types', 'qode_music_register_events_cpt');
}

if(!function_exists('qode_music_single_event')) {
	function qode_music_single_event() {
		$current_id = get_the_ID();
		$skin = get_post_meta($current_id, 'qode_event_skin', true);
		$location = get_post_meta($current_id, 'qode_event_item_location', true);
		$pin = get_post_meta($current_id, 'qode_event_item_pin', true);
		$link = get_post_meta($current_id, 'qode_event_item_link', true);
		$target = get_post_meta($current_id, 'qode_event_item_target', true);
		$tickes_status = get_post_meta($current_id, 'qode_event_item_tickets_status', true);
		$date = get_post_meta($current_id, 'qode_event_item_date', true);
		$time = get_post_meta($current_id, 'qode_event_item_time', true);
		$website = get_post_meta($current_id, 'qode_event_item_website', true);
		$organized_by = get_post_meta($current_id, 'qode_event_item_organized_by', true);
		$back_to_link = get_post_meta( $current_id, 'qode_event_back_to_link', true );

		$holder_class = 'qode-event-single-holder';

		switch ($skin) {
			case 'light':
				$holder_class .= ' qode-event-single-light';
				break;
			
			case 'dark':
				$holder_class .= ' qode-event-single-dark';
				break;

			default:
				break;
		}

		$params = array(
			'holder_class'  => $holder_class,
			'location'  => $location,
			'pin' => $pin,
			'link' => $link,
			'target' => $target,
			'tickets_status' => $tickes_status,
			'date' => $date,
			'time' => $time,
			'website' => $website,
			'organized_by' => $organized_by,
			'back_to_link' => $back_to_link
		);

		qode_music_get_cpt_single_module_template_part('templates/single/holder', 'events', '', $params);
	}
}

/**
 * Loads more function for events.
 *
 */

if(!function_exists('qode_core_events_ajax_load_more')){

	function qode_core_events_ajax_load_more(){

		$return_obj = array();
		$shortcode_params = array();

		if (!empty($_POST['orderBy'])) {
			$shortcode_params['order_by'] = $_POST['orderBy'];
		}
		if (!empty($_POST['order'])) {
			$shortcode_params['order'] = $_POST['order'];
		}
		if (!empty($_POST['number'])) {
			$shortcode_params['number'] = $_POST['number'];
		}
		if (!empty($_POST['showLoadMore'])) {
			$shortcode_params['show_load_more'] = $_POST['showLoadMore'];
		}
		if (!empty($_POST['nextPage'])) {
			$shortcode_params['next_page'] = $_POST['nextPage'];
		}
		if (!empty($_POST['titleTag'])) {
			$shortcode_params['title_tag'] = $_POST['titleTag'];
		}
		if (!empty($_POST['buttonSkin'])) {
			$shortcode_params['button_skin'] = $_POST['buttonSkin'];
		}
		if (!empty($_POST['textColor'])) {
			$shortcode_params['text_color_style'] = 'color:' . $_POST['textColor'];
		}
		if (!empty($_POST['borderColor'])) {
			$shortcode_params['border_color_style'] = 'border-color:' . $_POST['borderColor'];
		}

		if ( $_POST['buttonShape'] == 'rounded') {
			$shortcode_params['border_radius'] = 'yes';
        } else {
			$shortcode_params['border_radius'] = 'no';
        }

		$html = '';

		$events_list = new \QodeMusic\CPT\Events\Shortcodes\EventsList();
		$query_array = $events_list->getQueryArray($shortcode_params);
		$query_results = new \WP_Query($query_array);

		if($query_results->have_posts()):
			while ( $query_results->have_posts() ) : $query_results->the_post();

				$shortcode_params['current_id'] = get_the_ID();
				$shortcode_params['event_link'] = get_permalink(get_the_ID());
				$shortcode_params['title'] = get_the_title($shortcode_params['current_id']);
				$shortcode_params['date'] = get_post_meta($shortcode_params['current_id'], 'qode_event_item_date', true);
				$shortcode_params['link'] = get_post_meta($shortcode_params['current_id'], 'qode_event_item_link', true);
				$shortcode_params['target'] = get_post_meta($shortcode_params['current_id'], 'qode_event_item_target', true);
				$shortcode_params['tickets_status'] = get_post_meta($shortcode_params['current_id'], 'qode_event_item_tickets_status', true);

				$html .= qode_music_get_shortcode_module_template_part('events','templates/events-list-template', '', $shortcode_params);

			endwhile;
		else:
			$html .='<p>' . esc_html__( 'Sorry, no events matched your criteria.','qode' ) . '</p>';
		endif;

		$return_obj = array(
			'html' => $html,
		);


		echo json_encode($return_obj); exit;
	}
}

add_action('wp_ajax_nopriv_qode_core_events_ajax_load_more', 'qode_core_events_ajax_load_more');
add_action( 'wp_ajax_qode_core_events_ajax_load_more', 'qode_core_events_ajax_load_more' );


//Function that creates date_time meta field in proper format for sorting Events in Events List shortcode

if(!function_exists('qode_music_event_date_and_time_meta_save')){
	function qode_music_event_date_and_time_meta_save(){
		// date and time for event

		$current_id = get_the_ID();
		$date = get_post_meta($current_id, 'qode_event_item_date', true);
		$time = get_post_meta($current_id, 'qode_event_item_time', true);

		if(get_post_type($current_id) == 'qode-event' && $date != '' && $time != '') {

			$date_time = date_i18n( 'Y-m-d' , strtotime( $date ) ).' '.date_i18n( 'H:i' , strtotime( $time ) );

			update_post_meta( $current_id,  'qode_event_item_date_and_time', $date_time );
		} else {
			delete_post_meta( $current_id,  'qode_event_item_date_and_time');
		}

		$date_time_meta = get_post_meta( get_the_ID(), 'qode_event_item_date_and_time', true );
	}
}

add_action( 'save_post', 'qode_music_event_date_and_time_meta_save');