<?php

if(!function_exists('qode_restaurant_activation')) {
	/**
	 * Triggers when plugin is activated. It calls flush_rewrite_rules
	 * and defines qode_news_on_activate action
	 */
	function qode_restaurant_activation() {
		do_action('qode_restaurant_on_activate');

		// QodeRestaurant\PostTypesRegister::getInstance()->register();
		flush_rewrite_rules();
	}

	register_activation_hook(__FILE__, 'qode_restaurant_activation');
}

if(!function_exists('qode_restaurant_text_domain')) {
	/**
	 * Loads plugin text domain so it can be used in translation
	 */
	function qode_restaurant_text_domain() {
		load_plugin_textdomain('qode-restaurant', false, QODE_RESTAURANT_REL_PATH.'/languages');
	}

	add_action('plugins_loaded', 'qode_restaurant_text_domain');
}

if(!function_exists('qode_restaurant_version_class')) {
    /**
     * Adds plugins version class to body
     * @param $classes
     * @return array
     */
    function qode_restaurant_version_class($classes) {
        $classes[] = 'qode-restaurant-'.QODE_RESTAURANT_VERSION;

        return $classes;
    }

    add_filter('body_class', 'qode_restaurant_version_class');
}

if(!function_exists('qode_restaurant_theme_installed')) {
    /**
     * Checks whether theme is installed or not
     * @return bool
     */
    function qode_restaurant_theme_installed() {
        return defined('QODE_ROOT');
    }
}

if(!function_exists('qode_restaurant_is_elementor_installed')) {
    /**
     * Checks whether theme is installed or not
     * @return bool
     */
    function qode_restaurant_is_elementor_installed() {
        return defined('ELEMENTOR_VERSION');
    }
}

//create elementor shortcodes group
if( ! function_exists('qode_restaurant_add_elementor_widget_categories') ) {
    function qode_restaurant_add_elementor_widget_categories($elements_manager) {

        if( qode_restaurant_is_elementor_installed() ){
            $elements_manager->add_category(
                'qode-restaurant',
                [
                    'title' => esc_html__('Qode Restaurant', 'qode-restaurant'),
                    'icon' => 'fa fa-plug',
                ]
            );
        }

    }

    add_action('elementor/elements/categories_registered', 'qode_restaurant_add_elementor_widget_categories');
};

if(!function_exists('qode_restaurant_get_shortcode_module_template_part')) {
	/**
	 * Loads module template part.
	 *
	 * @param string $shortcode name of the shortcode folder
	 * @param string $template name of the template to load
	 * @param string $slug
	 * @param array $params array of parameters to pass to template
	 * @return html
	 */
	function qode_restaurant_get_shortcode_module_template_part($shortcode,$template, $slug = '', $params = array()) {

		//HTML Content from template
		$html = '';
		$template_path = QODE_RESTAURANT_CPT_PATH.'/'.$shortcode.'/shortcodes';

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

if(!function_exists('qode_restaurant_get_template_part')) {
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
	function qode_restaurant_get_template_part($template, $slug = '', $params = array(), $return = false) {
		//HTML Content from template
		$html = '';
		$template_path = QODE_RESTAURANT_ABS_PATH;

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

if(!function_exists('qode_restaurant_inline_style')) {
	/**
	 * Function that echoes generated style attribute
	 * @param $value string | array attribute value
	 *
	 */
	function qode_restaurant_inline_style($value) {
		echo qode_restaurant_get_inline_style($value);
	}
}

if(!function_exists('qode_restaurant_get_inline_style')) {
	/**
	 * Function that generates style attribute and returns generated string
	 * @param $value string | array value of style attribute
	 * @return string generated style attribute
	 *
	 */
	function qode_restaurant_get_inline_style($value) {
        return qode_restaurant_get_inline_attr($value, 'style', ';');
	}
}

if(!function_exists('qode_restaurant_class_attribute')) {
	/**
	 * Function that echoes class attribute
	 * @param $value string value of class attribute
	 */
	function qode_restaurant_class_attribute($value) {
		echo qode_restaurant_get_class_attribute($value);
	}
}

if(!function_exists('qode_restaurant_get_class_attribute')) {
	/**
	 * Function that returns generated class attribute
	 * @param $value string value of class attribute
	 * @return string generated class attribute
	 */
	function qode_restaurant_get_class_attribute($value) {
		return qode_restaurant_get_inline_attr($value, 'class', ' ');
	}
}

if(!function_exists('qode_restaurant_get_inline_attr')) {
	/**
	 * Function that generates html attribute
	 * @param $value string | array value of html attribute
	 * @param $attr string name of html attribute to generate
	 * @param $glue string glue with which to implode $attr. Used only when $attr is array
	 * @return string generated html attribute
	 */
	function qode_restaurant_get_inline_attr($value, $attr, $glue = '') {
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