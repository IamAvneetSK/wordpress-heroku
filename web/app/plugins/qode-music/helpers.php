<?php

if(!function_exists('qode_music_version_class')) {
    /**
     * Adds plugins version class to body
     * @param $classes
     * @return array
     */
    function qode_music_version_class($classes) {
        $classes[] = 'qode-music-'.QODE_MUSIC_VERSION;

        return $classes;
    }

    add_filter('body_class', 'qode_music_version_class');
}

if(!function_exists('qode_music_theme_installed')) {
    /**
     * Checks whether theme is installed or not
     * @return bool
     */
    function qode_music_theme_installed() {
        return defined('QODE_ROOT');
    }
}
if(!function_exists('qode_music_scope_meta_box_functions')) {
	function qode_music_scope_meta_box_functions($post_types) {
		$post_types[] = 'qode-album';
		$post_types[] = 'qode-event';

		return $post_types;
	}

	add_filter('bridge_qode_filter_general_scope_post_types', 'qode_music_scope_meta_box_functions');
	add_filter('bridge_qode_filter_header_scope_post_types', 'qode_music_scope_meta_box_functions');
	add_filter('bridge_qode_filter_title_scope_post_types', 'qode_music_scope_meta_box_functions');
	//add_filter('bridge_qode_filter_sidebar_scope_post_types', 'qode_music_scope_meta_box_functions');
}
if(!function_exists('qode_music_get_shortcode_module_template_part')) {

	function qode_music_get_shortcode_module_template_part($shortcode,$template, $slug = '', $params = array()) {

		//HTML Content from template
		$html = '';
		$template_path = QODE_MUSIC_CPT_PATH.'/'.$shortcode.'/shortcodes';

		$temp = $template_path.'/'.$template;
		if(is_array($params) && count($params)) {
			extract($params);
		}
		
		$template = '';

		if($temp !== '') {
			$template = $temp.'.php';

			if($slug !== '') {
				$template = "{$temp}-{$slug}.php";
			}
		}
		if($template) {
			ob_start();
			include($template);
			$html = ob_get_clean();
		}

		return $html;
	}
}

if(!function_exists('qode_music_get_cpt_single_module_template_part')) {
	/**
	 * Loads module template part.
	 *
	 * @param string $cpt_name name of the cpt folder
	 * @param string $template name of the template to load
	 * @param string $slug
	 * @param array $params array of parameters to pass to template
	 *
	 * @return html
	 */
	function qode_music_get_cpt_single_module_template_part($template, $cpt_name, $slug = '', $params = array()) {

		//HTML Content from template
		$html = '';
		$template_path = QODE_MUSIC_CPT_PATH.'/'.$cpt_name;

		$temp = $template_path.'/'.$template;

		if(is_array($params) && count($params)) {
			extract($params);
		}

		$template = '';

		if (!empty($temp)) {
			if (!empty($slug)) {
				$template = "{$temp}-{$slug}.php";

				if(!file_exists($template)) {
					$template = $temp.'.php';
				}
			} else {
				$template = $temp.'.php';
			}
		}

		if (!empty($template)) {
			ob_start();
			include($template);
			$html = ob_get_clean();
		}

		print $html;
	}
}

if(!function_exists('qode_music_get_template_part')) {
	/**
	 * Loads template part with parameters. If file with slug parameter added exists it will load that file, else it will load file without slug added.
	 * Child theme friendly function
	 *
	 * @param string $template name of the template to load without extension
	 * @param string $slug
	 * @param array $params array of parameters to pass to template
	 * @param bool $return whether to return it as a string
	 *
	 * @return mixed
	 */
	function qode_music_get_template_part($template, $slug = '', $params = array(), $return = false) {
		//HTML Content from template
		$html = '';
		$template_path = QODE_MUSIC_ABS_PATH;

		$temp = $template_path.'/'.$template;
		if(is_array($params) && count($params)) {
			extract($params);
		}

		$template = '';

		if($temp !== '') {
			$template = $temp.'.php';

			if($slug !== '') {
				$template = "{$temp}-{$slug}.php";
			}
		}

		if($template) {
			if($return) {
				ob_start();
			}

			include($template);

			if($return) {
				$html = ob_get_clean();
			}

		}

		if($return) {
			return $html;
		}
	}
}

if(!function_exists('qode_music_inline_style')) {
	/**
	 * Function that echoes generated style attribute
	 * @param $value string | array attribute value
	 *
	 */
	function qode_music_inline_style($value) {
		echo qode_music_get_inline_style($value);
	}
}

if(!function_exists('qode_music_get_inline_style')) {
	/**
	 * Function that generates style attribute and returns generated string
	 * @param $value string | array value of style attribute
	 * @return string generated style attribute
	 *
	 */
	function qode_music_get_inline_style($value) {
        return qode_music_get_inline_attr($value, 'style', ';');
	}
}

if(!function_exists('qode_music_class_attribute')) {
	/**
	 * Function that echoes class attribute
	 * @param $value string value of class attribute
	 */
	function qode_music_class_attribute($value) {
		echo qode_music_get_class_attribute($value);
	}
}

if(!function_exists('qode_music_get_class_attribute')) {
	/**
	 * Function that returns generated class attribute
	 * @param $value string value of class attribute
	 * @return string generated class attribute
	 */
	function qode_music_get_class_attribute($value) {
		return qode_music_get_inline_attr($value, 'class', ' ');
	}
}

if(!function_exists('qode_music_get_inline_attr')) {
	/**
	 * Function that generates html attribute
	 * @param $value string | array value of html attribute
	 * @param $attr string name of html attribute to generate
	 * @param $glue string glue with which to implode $attr. Used only when $attr is array
	 * @return string generated html attribute
	 */
	function qode_music_get_inline_attr($value, $attr, $glue = '') {
		if(!empty($value)) {

			if(is_array($value) && count($value)) {
				$properties = implode($glue, $value);
			} elseif($value !== '') {
				$properties = $value;
			}

			return $attr.'="'.esc_attr($properties).'"';
		}

		return '';
	}
}
if(!function_exists('qode_music_get_attachment_id_from_url')) {
	/**
	 * Function that retrieves attachment id for passed attachment url
	 *
	 * @param $attachment_url
	 *
	 * @return null|string
	 */
	function qode_music_get_attachment_id_from_url($attachment_url) {
		global $wpdb;
		$attachment_id = '';

		//is attachment url set?
		if($attachment_url !== '') {
			//prepare query

			$query = $wpdb->prepare("SELECT ID FROM {$wpdb->posts} WHERE guid=%s", $attachment_url);

			//get attachment id
			$attachment_id = $wpdb->get_var($query);
		}

		//return id
		return $attachment_id;
	}
}

if ( ! function_exists( 'qode_music_ajax_status' ) ) {

	function qode_music_ajax_status($status, $message, $data = NULL) {

		$response = array (
			'status'	=> $status,
			'message'	=> $message,
			'sdata'		=> $data
		);

		$output = json_encode($response);

		exit($output);

	}

}

if( ! function_exists('qode_music_add_elementor_widget_categories') ) {
    function qode_music_add_elementor_widget_categories($elements_manager) {

        $elements_manager->add_category(
            'qode-music',
            [
                'title' => esc_html__('Qode Music', 'qode-music'),
                'icon' => 'fa fa-plug',
            ]
        );

    }

    add_action('elementor/elements/categories_registered', 'qode_music_add_elementor_widget_categories');
};