<?php
/*
Plugin Name: Qode Woocommerce Checkout Integration
Description: Plugin that adds custom post type to woocommerce checkout
Author: Qode Themes
Version: 2.0.2
*/

include_once 'load.php';

if( !function_exists( 'qodef_load_checkout_plugin' ) ) {
    function qodef_load_checkout_plugin() {
        include_once 'payment/class-wc-product-qodef.php';
        include_once 'payment/class-wc-qodef-data-store-cpt.php';
        include_once 'payment/class-wc-order-item-qodef.php';
        include_once 'payment/class-wc-order-item-qodef-store.php';

        do_action( 'qodef_checkout_plugin_loaded' );
    }

    add_action( 'woocommerce_loaded', 'qodef_load_checkout_plugin' );
}
