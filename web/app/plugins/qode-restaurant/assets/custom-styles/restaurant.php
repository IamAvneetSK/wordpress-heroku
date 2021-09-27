<?php

if(!function_exists('qode_restaurant_styles')){
	function qode_restaurant_styles(){

		$first_color = bridge_qode_options()->getOptionValue('first_color');
		if(!empty($first_color)) {

			$background_color_selector = '
				.qode-restaurant-menu-list .qode-rml-label-holder .qode-rml-label,
				#ui-datepicker-div .ui-datepicker-today
			';
			$background_color_styles = array();

			$color_selector = '
				#ui-datepicker-div .ui-datepicker-current-day:not(.ui-datepicker-today) a
			';
			$color_styles = array();

			$background_color_styles['background-color'] = $first_color;
			$color_styles['color'] = $first_color;

			echo bridge_qode_dynamic_css($background_color_selector, $background_color_styles);
			echo bridge_qode_dynamic_css($color_selector, $color_styles);
		}
	}

	add_action('bridge_qode_action_style_dynamic', 'qode_restaurant_styles');
}