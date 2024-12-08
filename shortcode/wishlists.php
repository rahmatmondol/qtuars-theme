<?php 

// wishlists shortcode
add_shortcode('wishlists', 'qtuars_wishlists_shortcode_function');

function qtuars_wishlists_shortcode_function() {
    $wishlist = array();
    if (is_user_logged_in()) {
        $user_id = get_current_user_id();
        $wishlist = get_user_meta($user_id, 'qtuars_wishlist', true) ?: [];
    } else {
        $cookie_name = 'qtuars_wishlist';
        $wishlist = isset($_COOKIE[$cookie_name]) ? json_decode(stripslashes($_COOKIE[$cookie_name]), true) : [];
    }

    ob_start();
    ?>
    <div class="wishlist mb-5 ">
        <h2 class="page-title mb-4"><i class="fa-regular fa-heart"></i> Wishlists</h2>
        <div class="row">
          <?php foreach ($wishlist as $product_id) :
            $product = wc_get_product($product_id);
            if ($product) :
              $product_title    = $product->get_title();
              $product_image    = $product->get_image('medium');
              $product_price    = $product->get_price_html();
              $product_link     = $product->get_permalink();
              $duration         = $product->get_meta('duration');
              $location         = $product->get_meta('location_name');
              $minimum_age      = $product->get_meta('minimum_age') == '' ? 'N/A' : $product->get_meta('minimum_age');
              ?>
              <div class="col-md-4">
                <div class="wishlist-card">
                    <span class="remove_wishlist"><i class="fa fa-close"></i></span>
                  <?php echo $product_image; ?>
                  <div class="wishlist-body">
                    <h5 class="card-title"><?php echo $product_title; ?></h5>
                    <p class="wishlist-text"> Price: <?php echo $product_price; ?></p>
                    <p class="wishlist-text"> Duration: <?php echo $duration; ?></p>
                    <p class="wishlist-text">Location: <?php echo $location; ?></p>
                    <p class="wishlist-text mb-4"> Minimum Age: <?php echo $minimum_age; ?></p>
                    <a href="<?php echo $product_link; ?>" class="view-product">View Product</a>
                  </div>
                </div>
              </div>
              <?php endif ?>
            <?php endforeach ?>
        </div>
    </div>

    <script>
        jQuery(document).ready(function ($) {
            $('.remove_wishlist').click(function () {
                $.ajax({
                    url: '<?php echo admin_url('admin-ajax.php'); ?>',
                    type: 'POST',
                    data: {
                        action: 'qtuars_remove_from_wishlist',
                        product_id: <?php echo json_encode($product_id); ?>
                    },
                    success: function (response) {
                        location.reload();
                    }
                });
            });
        })
    </script>
    <?php
    return ob_get_clean();
}