<?php
function click_mag_child_enqueue_styles() {

    $parent_style = 'mvp-custom-style';

    wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'fontawesome-child', get_stylesheet_directory_uri() . '/font-awesome/css/font-awesome.css' );
    wp_enqueue_style( 'mvp-custom-child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array( $parent_style ),
        wp_get_theme()->get('Version')
    );
}
add_action( 'wp_enqueue_scripts', 'click_mag_child_enqueue_styles' );
?>