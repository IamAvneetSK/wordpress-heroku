<?php

if (!function_exists('qode_music_style') && qode_music_theme_installed()) {
    function qode_music_style()
    {

        if (bridge_qode_options()->getOptionValue('first_color') !== '') {
            echo bridge_qode_dynamic_css('.qode-working-hours-holder .qode-wh-title .qode-wh-title-accent-word,
                                    #ui-datepicker-div .ui-datepicker-current-day:not(.ui-datepicker-today) a, .single-qode-album .qode-album-nav .qode-album-back-btn a:hover, .single-qode-album .qode-album-nav .qode-album-next a:hover, .single-qode-album .qode-album-nav .qode-album-prev a:hover', array(
                'color' => bridge_qode_options()->getOptionValue('first_color')
            ));
            echo bridge_qode_dynamic_css('#ui-datepicker-div .ui-datepicker-today', array(
                'background-color' => bridge_qode_options()->getOptionValue('first_color')
            ));
        }

    }

    add_action('bridge_qode_action_style_dynamic', 'qode_music_style');
}