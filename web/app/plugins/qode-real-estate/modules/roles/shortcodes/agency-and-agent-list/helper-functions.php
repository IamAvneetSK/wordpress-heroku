<?php
if(!function_exists('qodef_re_agency_and_agent_list_shortcode_helper')) {
    function qodef_re_agency_and_agent_list_shortcode_helper($shortcodes_class_name) {
        $shortcodes = array(
            'QodefRE\CPT\Shortcodes\AgencyAndAgentList\AgencyAndAgentList'
        );

        $shortcodes_class_name = array_merge($shortcodes_class_name, $shortcodes);

        return $shortcodes_class_name;
    }

    add_filter('qodef_re_filter_add_vc_shortcode', 'qodef_re_agency_and_agent_list_shortcode_helper');
}

if( !function_exists('qodef_re_set_agency_and_agent_list_icon_class_name_for_vc_shortcodes') ) {
    /**
     * Function that set custom icon class name for agency and agent list shortcode to set our icon for Visual Composer shortcodes panel
     */
    function qodef_re_set_agency_and_agent_list_icon_class_name_for_vc_shortcodes($shortcodes_icon_class_array) {
        $shortcodes_icon_class_array[] = '.icon-wpb-agency-and-agent-list';

        return $shortcodes_icon_class_array;
    }

    add_filter('qodef_re_filter_add_vc_shortcodes_custom_icon_class', 'qodef_re_set_agency_and_agent_list_icon_class_name_for_vc_shortcodes');
}