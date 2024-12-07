<?php

/**
 * Add car to cart via ajax
 */
add_action('wp_ajax_qtuars_add_to_cart', 'qtuars_add_cart_event');
add_action('wp_ajax_nopriv_qtuars_add_to_cart', 'qtuars_add_cart_event');

/**
 * Handles adding car to cart event
 *
 * @return void
 */
function qtuars_add_cart_event()
{
    // Validate the data
    $name           = sanitize_text_field($_POST['name'] ?? '');
    $company_name   = sanitize_text_field($_POST['company_name'] ?? '');
    $phone_number   = sanitize_text_field($_POST['phone_number'] ?? '');
    $email          = sanitize_text_field($_POST['email'] ?? '');
    $date           = sanitize_text_field($_POST['date'] ?? '');
    $time           = sanitize_text_field($_POST['time'] ?? '');
    $meeting_point  = sanitize_text_field($_POST['meeting_point'] ?? '');
    $age            = sanitize_text_field($_POST['age'] ?? '');
    $adult          = sanitize_text_field($_POST['adult'] ?? '');
    $child          = sanitize_text_field($_POST['child'] ?? '');
    $product_id     = sanitize_text_field($_POST['product_id'] ?? '');
    $variation_id   = sanitize_text_field($_POST['variation_id'] ?? '');
    $addons         = $_POST['addons'] ?? [];

    
    if (
        empty($name)
        || empty($email)
        || empty($phone_number)
        || empty($date)
        || empty($time)
        || empty($meeting_point)
        || empty($product_id)
    ) {
        echo json_encode(false);
        exit;
    }


    $diver_license      = qtuars_handle_diver_license_image('diver_license');
    $driver_passport    = qtuars_handle_diver_license_image('driver_passport');


    //add cart car
    $args = [];
    if ($name)           $args['name']           = $name;
    if ($company_name)   $args['company_name']   = $company_name;
    if ($phone_number)   $args['phone_number']   = $phone_number;
    if ($email)          $args['email']          = $email;
    if ($date)           $args['date']           = $date;
    if ($time)           $args['time']           = $time;
    if ($meeting_point)  $args['meeting_point']  = $meeting_point;
    if ($age)            $args['age']            = $age;
    if ($adult_age)      $args['adult_age']      = $adult_age;
    if ($child_age)      $args['child_age']      = $child_age;
    if ($diver_license)  $args['diver_license']  = $diver_license;
    if ($driver_passport)$args['driver_passport'] = $driver_passport;


    foreach ($addons as $addon_id) {
        WC()->cart->add_to_cart($addon_id, 1, 0, []);
    }
    

    if ($variation_id) {
        WC()->cart->add_to_cart($product_id, 1, $variation_id, $args);
    } else {
        WC()->cart->add_to_cart($product_id, 1, 0, $args);
    }


    echo json_encode(true);
    exit;
}



/**
 * Check if diver_license has an image and store it in the library
 *
 * @param string $post_name
 * @return int image id
 */
function qtuars_handle_diver_license_image($post_name)
{
    if (empty($_FILES[$post_name]['name'])) {
        return '';
    }

    require_once(ABSPATH . 'wp-admin/includes/file.php');
    $uploaded_file = wp_handle_upload($_FILES[$post_name], array('test_form' => false));

    if (isset($uploaded_file['file'])) {
        $file_name = basename($uploaded_file['file']);
        $file_type = wp_check_filetype($file_name, null);

        $attachment = array(
            'post_mime_type' => $file_type['type'],
            'post_title'     => sanitize_file_name($file_name),
            'post_content'   => '',
            'post_status'    => 'inherit'
        );

        $attach_id = wp_insert_attachment($attachment, $uploaded_file['file']);
        require_once(ABSPATH . 'wp-admin/includes/image.php');
        $attach_data = wp_generate_attachment_metadata($attach_id, $uploaded_file['file']);
        wp_update_attachment_metadata($attach_id, $attach_data);

        return wp_get_attachment_url($attach_id);
    }

    return '';
}
