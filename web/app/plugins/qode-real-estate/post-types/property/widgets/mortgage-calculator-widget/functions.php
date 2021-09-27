<?php

if ( ! function_exists( 'qodef_re_register_mortgage_calculator_property_widget' ) ) {
    /**
     * Function that register recently viewed property widget
     */
    function qodef_re_register_mortgage_calculator_property_widget( $widgets ) {
        $widgets[] = 'QodeREMortgageCalculatorWidget';

        return $widgets;
    }

    add_filter( 'bridge_core_filter_register_widgets', 'qodef_re_register_mortgage_calculator_property_widget' );
}