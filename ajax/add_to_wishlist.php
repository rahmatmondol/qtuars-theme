<?php
// add car to wishlist
add_action('wp_ajax_qtuars_add_to_wishlist', 'qtuars_add_wishlist_event');
add_action('wp_ajax_nopriv_qtuars_add_to_wishlist', 'qtuars_add_wishlist_event');

/**
 * Handle adding a product to the wishlist via ajax
 *
 * @since 1.0.0
 */
function qtuars_add_wishlist_event() {
    // Validate the product ID from the request
    $product_id = sanitize_text_field($_POST['product_id'] ?? '');

    if (empty($product_id)) {
        echo json_encode(['success' => false, 'message' => 'Product ID is required.']);
        exit;
    }

    // Get the WooCommerce product
    $product = wc_get_product($product_id);

    if (!$product) {
        echo json_encode(['success' => false, 'message' => 'Invalid product.']);
        exit;
    }

    // Handle for logged-in and guest users
    if (is_user_logged_in()) {
        // Logged-in user handling
        $user_id = get_current_user_id();
        $wishlist = get_user_meta($user_id, 'qtuars_wishlist', true) ?: [];

        if (in_array($product_id, $wishlist)) {
            echo json_encode(['success' => false, 'message' => 'Product already in wishlist.']);
            exit;
        }

        $wishlist[] = $product_id;
        update_user_meta($user_id, 'qtuars_wishlist', $wishlist);

    } else {
        // Guest user handling via cookies
        $cookie_name = 'qtuars_wishlist';
        $current_wishlist = isset($_COOKIE[$cookie_name]) ? json_decode(stripslashes($_COOKIE[$cookie_name]), true) : [];

        if (in_array($product_id, $current_wishlist)) {
            echo json_encode(['success' => false, 'message' => 'Product already in wishlist.']);
            exit;
        }

        $current_wishlist[] = $product_id;

        // Update the cookie (expires in 30 days)
        setcookie($cookie_name, json_encode(array_unique($current_wishlist)), time() + 30 * DAY_IN_SECONDS, COOKIEPATH, COOKIE_DOMAIN, is_ssl());
    }

    echo json_encode(['success' => true, 'message' => 'Product added to wishlist.']);
    exit;
}

// get wishlist
add_action('wp_ajax_qtuars_get_wishlist', 'qtuars_get_wishlist_event');
add_action('wp_ajax_nopriv_qtuars_get_wishlist', 'qtuars_get_wishlist_event');

function qtuars_get_wishlist_event() {
    if (is_user_logged_in()) {
        $user_id = get_current_user_id();    
        $wishlist = get_user_meta($user_id, 'qtuars_wishlist', true) ?: [];
    } else {
        $cookie_name = 'qtuars_wishlist';
        $wishlist = isset($_COOKIE[$cookie_name]) ? json_decode(stripslashes($_COOKIE[$cookie_name]), true) : [];
    }

    echo json_encode(['count' => count($wishlist), 'wishlist' => $wishlist]);
    exit;
}

// remove from wishlist
add_action('wp_ajax_qtuars_remove_from_wishlist', 'qtuars_remove_from_wishlist_event');
add_action('wp_ajax_nopriv_qtuars_remove_from_wishlist', 'qtuars_remove_from_wishlist_event');

function qtuars_remove_from_wishlist_event() {
    // Validate the product ID from the request
    $product_id = sanitize_text_field($_POST['product_id'] ?? '');

    if (empty($product_id)) {
        echo json_encode(['success' => false, 'message' => 'Product ID is required.']);
        exit;
    }

    if (is_user_logged_in()) {
        $user_id = get_current_user_id();
        $wishlist = get_user_meta($user_id, 'qtuars_wishlist', true) ?: [];

        if (!in_array($product_id, $wishlist)) {
            echo json_encode(['success' => false, 'message' => 'Product not in wishlist.']);
            exit;
        }

        $wishlist = array_diff($wishlist, [$product_id]);
        update_user_meta($user_id, 'qtuars_wishlist', $wishlist);

    } else {
        $cookie_name = 'qtuars_wishlist';
        $current_wishlist = isset($_COOKIE[$cookie_name]) ? json_decode(stripslashes($_COOKIE[$cookie_name]), true) : [];

        if (!in_array($product_id, $current_wishlist)) {
            echo json_encode(['success' => false, 'message' => 'Product not in wishlist.']);
            exit;
        }

        $current_wishlist = array_diff($current_wishlist, [$product_id]);

        // Update the cookie (expires in 30 days)
        setcookie($cookie_name, json_encode(array_unique($current_wishlist)), time() + 30 * DAY_IN_SECONDS, COOKIEPATH, COOKIE_DOMAIN, is_ssl());
    }

    echo json_encode(['success' => true, 'message' => 'Product removed from wishlist.']);
    exit;
}