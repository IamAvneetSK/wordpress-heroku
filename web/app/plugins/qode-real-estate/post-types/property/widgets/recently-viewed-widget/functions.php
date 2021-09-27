<?php

if ( ! function_exists( 'qodef_re_register_recently_viewed_property_widget' ) ) {
    /**
     * Function that register recently viewed property widget
     */
    function qodef_re_register_recently_viewed_property_widget( $widgets ) {
        $widgets[] = 'QodeRERecentlyViewedPropertyWidget';

        return $widgets;
    }

    add_filter( 'bridge_core_filter_register_widgets', 'qodef_re_register_recently_viewed_property_widget' );
}