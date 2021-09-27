<?php

if(!function_exists('qode_login_dropdown_styles')){
	function qode_login_dropdown_styles(){

		$dropdown_login_style = array();
		$dropdown_login_hover_style = array();
		$dropdown_background_style = array();
		$login_style = array();
		$sticky_login_style = array();

		$header_icon_styles = array();
		$header_icon_hover_styles = array();

		$dropdown_selector = '.header_bottom .qode-login-register-widget.qode-user-logged-in .qode-login-dropdown li a';
		$dropdown_hover_selector = '.header_bottom .qode-login-register-widget.qode-user-logged-in .qode-login-dropdown li a:hover';
		$dropdown_background_selector = '.header_bottom .qode-login-register-widget.qode-user-logged-in .qode-login-dropdown';
		$login_selector = '.header_bottom .qode-login-register-widget.qode-user-logged-in';
		$sticky_login_selector = 'header.sticky .header_bottom .qode-login-register-widget.qode-user-logged-in';

		$header_icons_selector = array(
			'.header_bottom .qode-login-opener',
			'.header_bottom .qode-logged-in-user-icon'
		);
		$header_icons_hover_selector = array(
			'.header_bottom .qode-login-opener:hover',
			'.header_bottom .qode-login-register-widget.qode-user-logged-in:hover .qode-logged-in-user .qode-logged-in-user-inner > span'
		);
		$dropdown_color				= bridge_qode_options()->getOptionValue('dropdown_color');
		$dropdown_hovercolor		= bridge_qode_options()->getOptionValue('dropdown_hovercolor');
		$dropdown_google_fonts		= bridge_qode_options()->getOptionValue('dropdown_google_fonts');
		$dropdown_fontsize			= bridge_qode_options()->getOptionValue('dropdown_fontsize');
		$dropdown_lineheight		= bridge_qode_options()->getOptionValue('dropdown_lineheight');
		$dropdown_fontstyle			= bridge_qode_options()->getOptionValue('dropdown_fontstyle');
		$dropdown_fontweight		= bridge_qode_options()->getOptionValue('dropdown_fontweight');
		$dropdown_texttransform		= bridge_qode_options()->getOptionValue('dropdown_texttransform');
		$dropdown_letterspacing		= bridge_qode_options()->getOptionValue('dropdown_letterspacing');

		$dropdown_background_color	= bridge_qode_options()->getOptionValue('dropdown_background_color');
		$dropdown_background_transparency	= bridge_qode_options()->getOptionValue('dropdown_background_transparency');
		$dropdown_background_border	= bridge_qode_options()->getOptionValue('dropdown_border_around');
		$dropdown_background_border_color	= bridge_qode_options()->getOptionValue('header_separator_color');

		$header_height =  bridge_qode_options()->getOptionValue('header_height');
		$sticky_header_height =  bridge_qode_options()->getOptionValue('header_height_sticky');

		$header_icon_color =  bridge_qode_options()->getOptionValue('header_buttons_color');
		$header_icon_hover_color =  bridge_qode_options()->getOptionValue('header_buttons_hover_color');

		if(bridge_qode_is_font_option_valid($dropdown_google_fonts)){
			$dropdown_login_style['font-family'] = bridge_qode_get_font_option_val($dropdown_google_fonts);
		}

		if(!empty($dropdown_color)) {
			$dropdown_login_style['color'] = $dropdown_color;
		}

		if(!empty($dropdown_hovercolor)) {
			$dropdown_login_hover_style['color'] = $dropdown_hovercolor;
		}
		if(!empty($dropdown_texttransform)) {
			$dropdown_login_style['text-transform'] = $dropdown_texttransform;
		}

		if(!empty($dropdown_fontstyle)) {
			$dropdown_login_style['font-style'] = $dropdown_fontstyle;
		}

		if($dropdown_letterspacing !== '') {
			$dropdown_login_style['letter-spacing'] = bridge_qode_filter_px($dropdown_letterspacing).'px';
		}
		if($dropdown_fontsize !== '') {
			$dropdown_login_style['font-size'] = bridge_qode_filter_px($dropdown_fontsize).'px';
		}
		if($dropdown_lineheight !== '') {
			$dropdown_login_style['line-height'] = bridge_qode_filter_px($dropdown_lineheight).'px';
		}

		if(!empty($dropdown_fontweight)) {
			$dropdown_login_style['font-weight'] = $dropdown_fontweight;
		}

		if(!empty($dropdown_background_color)){
			if(!empty($dropdown_background_transparency)) {
				$dropdown_background_style['background-color'] = bridge_qode_rgba_color($dropdown_background_color, $dropdown_background_transparency);
			} else {
				$dropdown_background_style['background-color'] = $dropdown_background_color;
			}
		}

		if(isset($dropdown_background_border) && $dropdown_background_border == "yes") {
			$dropdown_background_style['border-style'] = 'solid';
			$dropdown_background_style['border-width'] = '1px';

		}

		if(!empty($dropdown_background_border_color)) {
			$dropdown_background_style['border-color'] = $dropdown_background_border_color;
		}


		if(!empty($header_height)){
			$login_style['height'] = bridge_qode_filter_px($header_height).'px';
			echo bridge_qode_dynamic_css($login_selector, $login_style);
		}

		if(!empty($header_icon_color)){
			$header_icon_styles['color'] = $header_icon_color;
			echo bridge_qode_dynamic_css($header_icons_selector, $header_icon_styles);
		}

		if(!empty($header_icon_hover_color)){
			$header_icon_hover_styles['color'] = $header_icon_hover_color;
			echo bridge_qode_dynamic_css($header_icons_hover_selector, $header_icon_hover_styles);
		}

		if(!empty($sticky_header_height)){
			$sticky_login_style['height'] = bridge_qode_filter_px($sticky_header_height).'px';
			echo bridge_qode_dynamic_css($sticky_login_selector, $sticky_login_style);
		}

		if(is_array($dropdown_login_style) && count($dropdown_login_style) > 0) {
			echo bridge_qode_dynamic_css($dropdown_selector, $dropdown_login_style);
		}

		if(is_array($dropdown_login_hover_style) && count($dropdown_login_hover_style) > 0) {
			echo bridge_qode_dynamic_css($dropdown_hover_selector, $dropdown_login_hover_style);
		}

		if(is_array($dropdown_background_style) && count($dropdown_background_style) > 0) {
			echo bridge_qode_dynamic_css($dropdown_background_selector, $dropdown_background_style);
		}
	}

	add_action('bridge_qode_action_style_dynamic', 'qode_login_dropdown_styles');
}
if(!function_exists('qode_membership_first_color_styles')){
	function qode_membership_first_color_styles(){

		$first_color = bridge_qode_options()->getOptionValue('first_color');
		if(!empty($first_color)) {

			$background_color_selector = array(
				'.qode-membership-dashboard-nav-holder ul li.qode-active-dash a',
				'.qode-membership-dashboard-nav-holder ul li:hover a',
			);
			$background_color_styles = array();

			$color_selector = array(
				'.qode-membership-navigation-over-title .qode-membership-dashboard-nav-holder ul li.qode-active-dash .qode-dash-icon',
				'.qode-membership-navigation-over-title .qode-membership-dashboard-nav-holder ul li:hover .qode-dash-icon',
				'.qode-login-register-holder .qode-membership-lr-terms-holder>span>a',
				'.qode-login-register-content ul li.ui-state-active a',
				'.header_bottom .qode-login-register-widget.qode-user-logged-in:hover .qode-logged-in-user .qode-logged-in-user-inner>span',

			);
			$color_styles = array();



			$background_color_styles['background-color'] = $first_color;
			$color_styles['color'] = $first_color;

			echo bridge_qode_dynamic_css($background_color_selector, $background_color_styles);
			echo bridge_qode_dynamic_css($color_selector, $color_styles);
		}
	}

	add_action('bridge_qode_action_style_dynamic', 'qode_membership_first_color_styles');
}