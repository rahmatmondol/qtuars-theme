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


// Save the phone number
add_action('comment_post', 'save_comment_phone_meta');
function save_comment_phone_meta($comment_id) {
    if (!empty($_POST['phone'])) {
        add_comment_meta($comment_id, 'phone', sanitize_text_field($_POST['phone']));
    }
}

// Display the phone number in the review
add_filter('get_comment_text', 'display_comment_phone_meta');
function display_comment_phone_meta($comment_text) {
    $comment_id = get_comment_ID();
    $phone = get_comment_meta($comment_id, 'phone', true);
    if ($phone) {
        $comment_text .= '<p><strong>' . __('Phone:', 'your-text-domain') . '</strong> ' . esc_html($phone) . '</p>';
    }
    return $comment_text;
}
