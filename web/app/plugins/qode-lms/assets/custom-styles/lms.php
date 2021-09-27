<?php

if(!function_exists('qode_lms_first_color_styles') && qode_lms_theme_installed()) {
	function qode_lms_first_color_styles() {
		$first_color = bridge_qode_options()->getOptionValue('first_color');
		if(!empty($first_color)){

			$color_selector = ".qode-course-single-holder .qode-course-tabs-wrapper .qode-tabs-nav li a, .qode-course-single-holder .qode-course-tabs-wrapper .qode-course-curriculum .qode-section-name, .qode-course-single-holder .qode-course-tabs-wrapper .qode-course-curriculum .qode-section-elements .qode-section-elements-summary i, .qode-course-single-holder .qode-course-tabs-wrapper .qode-course-curriculum .qode-section-element .qode-element-label, .qode-course-single-holder .qode-course-tabs-wrapper .qode-course-curriculum .qode-section-element .qode-element-title .qode-element-icon, .qode-instructor-single-holder .qode-instructor-single-outer .qode-instructor-single-info-holder .qode-ts-content-holder .qode-tabs .qode-tabs-nav li a, .qode-cl-filter-holder .qode-course-layout-filter, .qode-course-list-holder.qode-cl-minimal article .qode-ci-price-holder, #tribe-events-content-wrapper #tribe-bar-form #tribe-bar-views .tribe-bar-views-list .tribe-bar-views-option.tribe-bar-active a, #tribe-events-content-wrapper #tribe-bar-form #tribe-bar-views .tribe-bar-views-list .tribe-bar-views-option a:hover, #tribe-events-content-wrapper #tribe-events-content .tribe-events-sub-nav .tribe-events-nav-next a:hover, #tribe-events-content-wrapper #tribe-events-content .tribe-events-sub-nav .tribe-events-nav-previous a:hover, #tribe-events-content-wrapper #tribe-events-content table.tribe-events-calendar tbody .tribe-events-tooltip .entry-title, .qode-tribe-events-single .qode-events-single-meta .qode-events-single-navigation-holder .qode-events-single-next-event .qode-events-nav-text .qode-events-nav-label, .qode-tribe-events-single .qode-events-single-meta .qode-events-single-navigation-holder .qode-events-single-prev-event .qode-events-nav-text .qode-events-nav-label, .qode-tribe-events-single .qode-events-single-meta .qode-events-single-meta-item a, .qode-cl-filter-holder .qode-course-layout-filter span:hover, .qode-course-list-holder.qode-cl-standard article:hover .qode-cl-item-inner .qode-cli-text-holder .qode-cli-bottom-info .qode-students-number-holder, .qode-course-features-holder .qode-course-features li .qode-item-icon, .qode-course-single-holder .qode-course-tabs-wrapper .qode-course-curriculum .qode-section-element .qode-element-name:hover, .qode-course-popup .qode-course-popup-items .qode-section-elements-summary i, .qode-course-popup .qode-course-popup-items .qode-section-element .qode-element-title .qode-element-icon, .qode-course-popup .qode-course-popup-items .qode-section-element .qode-element-label, .qode-course-popup .qode-course-popup-items .qode-section-element .qode-element-name:hover, .qode-lesson-single-holder .qode-lms-message";
			$color_styles = array();

			$important_color_selectors = '.qode-course-list-widget .qode-course-list-holder.qode-cl-minimal article .qode-cli-text h5 a:hover';
			$important_color_styles = array();



			$background_selectors = ".qode-instructor-single-holder .qode-instructor-single-outer .qode-instructor-single-info-holder .qode-ts-info-holder .qode-social .qode_icon_shortcode a:hover, .qode-instructor.info-bellow .qode-instructor-social-holder-between .qode_icon_shortcode a:hover, .qode-cl-filter-holder .qode-course-items-order .select2-container--default .select2-selection--single, #tribe-events-content-wrapper #tribe-bar-form .tribe-bar-filters .tribe-bar-submit .tribe-events-button, #tribe-events-content-wrapper #tribe-events-content table.tribe-events-calendar tbody td.tribe-events-has-events div[id*=tribe-events-daynum-], .qode-course-slider-holder .qode-course-list-holder .owl-nav .owl-next, .qode-course-slider-holder .qode-course-list-holder .owl-nav .owl-prev, .qode-instructor-slider-holder .qode-owl-slider .owl-nav .owl-next, .qode-instructor-slider-holder .qode-owl-slider .owl-nav .owl-prev, .qode-tribe-events-single .qode-events-single-date-holder, .qode-instructor.info-hover .qode-instructor-social-holder-between .qode_icon_shortcode a:hover, .qode-events-list-item-title-holder .qode-events-list-item-price.qode-free, .qode-course-popup .qode-popup-heading";
			$background_styles = array();



			$border_selectors = '.qode-cl-filter-holder .qode-course-items-order .select2-container--default .select2-selection--single, #tribe-events-content-wrapper #tribe-bar-form #tribe-bar-views, .qode-instructor.info-bellow .qode-instructor-social-holder-between .qode_icon_shortcode a:hover, .qode-instructor.info-hover .qode-instructor-social-holder-between .qode_icon_shortcode a:hover';
			$border_styles = array();

			$border_transparent_selector = '.qode-course-list-holder.qode-cl-standard article .qode-cli-text-holder .qode-cli-bottom-info, .qode-course-list-holder.qode-cl-standard article .qode-cli-text-holder .qode-cli-text-wrapper, .qode-instructor.simple .qode-instructor-inner, .qode-course-table-holder tbody tr';
            $border_transparent_styles = array();



			$box_shadow_selectors = '#tribe-events-content-wrapper #tribe-bar-form .tribe-bar-filters input[type=text], .qode-tribe-events-single .qode-events-single-date-holder, .qode-instructor.info-hover .qode-instructor-social-holder-between .qode_icon_shortcode a, .qode-instructor.info-bellow .qode-instructor-social-holder-between .qode_icon_shortcode a, .qode-instructor.info-bellow .qode-instructor-image a, .qode-course-list-holder article .qode-cl-item-inner, .qode-course-list-holder article .qode-cl-item-inner, .qode-course-slider-holder .qode-course-list-holder .owl-nav .owl-next, .qode-course-slider-holder .qode-course-list-holder .owl-nav .owl-prev, .qode-instructor.simple .qode-instructor-inner, .qode-instructor.simple .qode-instructor-image a, #tribe-events-content-wrapper #tribe-events-content table.tribe-events-calendar, .qode-instructor-single-holder .qode-instructor-single-outer .qode-instructor-single-info-holder .qode-ts-content-holder .qode-tabs .qode-tab-container';
			$box_shadow_styles = array();

            $box_shadow_hover_selectors = '.qode-course-list-holder.qode-cl-standard article:hover .qode-cl-item-inner, .qode-instructor.info-bellow .qode-instructor-image a:hover, .qode-instructor.simple .qode-instructor-inner:hover';
            $box_shadow_hover_styles = array();


			$color_styles['color'] = $first_color;
            $important_color_styles['color'] = $first_color . '!important';
			$background_styles['background-color'] = $first_color;
			$border_styles['border-color'] = $first_color;
			$border_transparent_styles['border-color'] = 'rgba(' . implode(',', bridge_qode_hex2rgb($first_color)) . ',.1)';
			$box_shadow_styles['box-shadow'] = '3px 4px 8px 0 rgba(' . implode(',', bridge_qode_hex2rgb($first_color)) . ',.1)';
            $box_shadow_styles['-webkit-box-shadow'] = '3px 4px 8px 0 rgba(' . implode(',', bridge_qode_hex2rgb($first_color)) . ',.1)';
            $box_shadow_hover_styles['box-shadow'] = '5px 7px 10px 0 rgba(' . implode(',', bridge_qode_hex2rgb($first_color)) . ',.1)';
            $box_shadow_hover_styles['-webkit-box-shadow'] = '5px 7px 10px 0 rgba(' . implode(',', bridge_qode_hex2rgb($first_color)) . ',.1)';



			echo bridge_qode_dynamic_css($color_selector, $color_styles);
            echo bridge_qode_dynamic_css($important_color_selectors, $important_color_styles);
			echo bridge_qode_dynamic_css($background_selectors, $background_styles);
            echo bridge_qode_dynamic_css($border_selectors, $border_styles);
            echo bridge_qode_dynamic_css($border_transparent_selector, $border_transparent_styles);
            echo bridge_qode_dynamic_css($box_shadow_selectors, $box_shadow_styles);
            echo bridge_qode_dynamic_css($box_shadow_hover_selectors, $box_shadow_hover_styles);

		}
	}

	add_action('bridge_qode_action_style_dynamic', 'qode_lms_first_color_styles');
}