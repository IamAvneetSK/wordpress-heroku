<?php
if ( ! function_exists( 'qode_restaurant_register_working_hours_widget' ) ) {
    /**
     * Function that register call to action widget
     */
    function qode_restaurant_register_working_hours_widget( $widgets ) {

        register_widget('QodeRestaurantWorkingHours');

    }

    add_filter( 'widgets_init', 'qode_restaurant_register_working_hours_widget' );
}