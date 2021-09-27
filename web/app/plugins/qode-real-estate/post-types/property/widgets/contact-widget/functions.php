<?php

if ( ! function_exists( 'qodef_re_register_contact_property_widget' ) ) {
    /**
     * Function that register contact property widget
     */
    function qodef_re_register_contact_property_widget( $widgets ) {
        $widgets[] = 'QodeREContactPropertyWidget';

        return $widgets;
    }

    add_filter( 'bridge_core_filter_register_widgets', 'qodef_re_register_contact_property_widget' );
}