<?php


function hello_child_enqueue_styles()
{
    $parent_style = 'Hello Elementor'; // Replace with the appropriate parent theme style handle

    // wp_enqueue_style($parent_style, get_template_directory_uri() . '/style.css');
    wp_enqueue_style('child-style', get_stylesheet_directory_uri() . '/style.css');

    wp_enqueue_script('main_script', get_stylesheet_directory_uri() . '/script.js', ['jquery'], false);
    wp_enqueue_style('bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css');
    wp_enqueue_script('bootstrap-js', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js', ['jquery'], true);
}
add_action('wp_enqueue_scripts', 'hello_child_enqueue_styles');


// add shortcode
include_once('shortcode/single_product_form.php');
