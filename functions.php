<?php


function qtours_enqueue_styles()
{
    $parent_style = 'Hello Elementor'; // Replace with the appropriate parent theme style handle

    // wp_enqueue_style($parent_style, get_template_directory_uri() . '/style.css');
    wp_enqueue_style('child-style', get_stylesheet_directory_uri() . '/style.css');

    wp_enqueue_script('main_script', get_stylesheet_directory_uri() . '/script.js', ['jquery'], false);
    wp_enqueue_style('fontawesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css');
    
    wp_enqueue_script('jquery');
    wp_enqueue_style('bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css');
    wp_enqueue_script('bootstrap-js', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js', ['jquery'], true);
}
add_action('wp_enqueue_scripts', 'qtours_enqueue_styles');


include_once('ajax/single_product_form.php');
include_once('ajax/add_to_wishlist.php');
include_once('shortcode/single_product_form.php');
include_once('shortcode/wishlist_icon.php');
include_once('shortcode/wishlists.php');
include_once('inc/checkout_fileld_filter.php');
include_once('inc/order_table.php');

