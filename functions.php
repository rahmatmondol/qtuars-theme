<?php


function hello_child_enqueue_styles()
{
    $parent_style = 'Hello Elementor'; // Replace with the appropriate parent theme style handle

    // wp_enqueue_style($parent_style, get_template_directory_uri() . '/style.css');
    wp_enqueue_style('child-style', get_stylesheet_directory_uri() . '/style.css');

    wp_enqueue_script('main_script', get_stylesheet_directory_uri() . '/script.js', ['jquery'], false);
    wp_enqueue_script('jquery');
    wp_enqueue_style('bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css');
    wp_enqueue_script('bootstrap-js', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js', ['jquery'], true);
}
add_action('wp_enqueue_scripts', 'hello_child_enqueue_styles');


// add single product form shortcode
include_once('ajax/single_product_form.php');
include_once('shortcode/single_product_form.php');

/**
 * Override checkout fields.
 *
 * Removes unwanted fields and makes certain fields required.
 *
 * @param array $fields The checkout fields.
 * @return array The modified checkout fields.
 */
function custom_override_checkout_fields($fields) {
    // Remove unnecessary fields
    unset($fields['order']['order_comments']);
    unset($fields['billing']['billing_address_2']);
    unset($fields['billing']['billing_address_1']);
    unset($fields['billing']['billing_city']);
    unset($fields['billing']['billing_state']);
    unset($fields['billing']['billing_postcode']);
    unset($fields['additional_fields']);

    $cart = WC()->cart->get_cart();

    if (!empty($cart)) {
        foreach ($cart as $cart_item) {
            $custom_data = $cart_item['variation'] ?? []; // Retrieve custom data
            
            // Map custom data to checkout fields
            if (!empty($custom_data['name'])) {
                $fields['billing']['billing_first_name']['default'] = $custom_data['name'];
            }
            if (!empty($custom_data['email'])) {
                $fields['billing']['billing_email']['default'] = $custom_data['email'];
            }
            if (!empty($custom_data['phone_number'])) {
                $fields['billing']['billing_phone']['default'] = $custom_data['phone_number'];
            }
            if (!empty($custom_data['company_name'])) {
                $fields['billing']['billing_company']['default'] = $custom_data['company_name'];
            }
        }
    }

    // Ensure specific fields are required
    $fields['billing']['billing_last_name']['required'] = true;
    $fields['billing']['billing_country']['required'] = true;

    return $fields;
}
add_filter('woocommerce_checkout_fields', 'custom_override_checkout_fields');



