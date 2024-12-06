<?php 

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
    
