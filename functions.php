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


// Add custom columns to the Orders table in the My Account page.
add_filter('woocommerce_my_account_my_orders_columns', 'custom_my_account_orders_columns');
function custom_my_account_orders_columns($columns) {
    return [
        'order-number'   => __('Order Number', 'woocommerce'),
        'order-date'     => __('Order Date', 'woocommerce'),
        'order-details'  => __('Order Details', 'woocommerce'),
        'order-location' => __('Location', 'woocommerce'),
        'order-payment'  => __('Payment Method', 'woocommerce'),
    ];
}

// Populate the Order Number column.
add_action('woocommerce_my_account_my_orders_column_order-number', 'custom_order_number_column');
function custom_order_number_column($order) {
    echo '<a href="' . esc_url($order->get_view_order_url()) . '">' . esc_html($order->get_order_number()) . '</a>';
}

// Populate the Order Date column.
add_action('woocommerce_my_account_my_orders_column_order-date', 'custom_order_date_column');
function custom_order_date_column($order) {
    echo esc_html(wc_format_datetime($order->get_date_created()));
}

// Populate the Order Details column with product names and prices.
add_action('woocommerce_my_account_my_orders_column_order-details', 'custom_order_details_column');
function custom_order_details_column($order) {
    $items = $order->get_items();
    echo '<ul>';
    foreach ($items as $item_id => $item) {
        $product_name = $item->get_name();
        $product_total = $order->get_formatted_line_subtotal($item);
        echo '<li>' . esc_html($product_name) . '</li>';
        echo wp_kses_post($product_total);
    }
    echo '</ul>';
    echo '<a href="' . esc_url($order->get_view_order_url()) . '">' . __('View Details', 'woocommerce') . '</a>';
}

// Populate the Order Location column with the billing country and address.
add_action('woocommerce_my_account_my_orders_column_order-location', 'custom_order_location_column');
function custom_order_location_column($order) {
    $billing_country = $order->get_billing_country();
    $billing_address = $order->get_billing_address_1();
    if ($billing_country || $billing_address) {
        echo esc_html($billing_address . ', ' . $billing_country);
    } else {
        echo __('N/A', 'woocommerce');
    }
}

// Populate the Payment Method column.
add_action('woocommerce_my_account_my_orders_column_order-payment', 'custom_order_payment_column');
function custom_order_payment_column($order) {
    echo esc_html($order->get_payment_method_title());
}
    
