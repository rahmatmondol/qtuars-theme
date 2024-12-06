<?php

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