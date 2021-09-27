<?php

if ( ! function_exists( 'qodef_re_include_property_widgets_loaders' ) ) {
    /**
     * Loads all custom post types by going through all folders that are placed directly in post types folder
     */
    function qodef_re_include_property_widgets_loaders() {
        if ( qodef_re_theme_installed() ) {
            foreach ( glob( QODE_RE_CPT_PATH . '/property/widgets/*/load.php' ) as $widget_load ) {
                include_once $widget_load;
            }
        }
    }

    add_action( 'bridge_qode_action_before_options_map', 'qodef_re_include_property_widgets_loaders', 20); //Priority needs to be bigger than 10 so abstract widget class is loaded first
}