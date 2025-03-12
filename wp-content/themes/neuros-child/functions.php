<?php

add_action( 'wp_enqueue_scripts', 'enqueue_theme_styles' );
function enqueue_theme_styles() {
    if (class_exists('WooCommerce')) {
        wp_enqueue_style( 'child-style', get_stylesheet_directory_uri() . '/style.css', array('neuros-theme', 'neuros-style', 'neuros-woocommerce') );
    } else {
        wp_enqueue_style( 'child-style', get_stylesheet_directory_uri() . '/style.css', array('neuros-theme', 'neuros-style') );
    }
}