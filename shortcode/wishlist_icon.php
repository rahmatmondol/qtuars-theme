<?php 
// wishlist icon
add_shortcode('wishlist_icon', 'qtuars_wishlist_icon_function');
/**
 * Generates a wishlist icon using Font Awesome.
 *
 * @return string HTML string for a heart icon representing the wishlist.
 */
function qtuars_wishlist_icon_function() {
    ob_start();
    ?>
    <div class="wishlist_icon">
        <span id="wishlist_count">0</span>
        <a href="<?php echo site_url(); ?>/wishlist/"><i class="fa-regular fa-heart"></i></a>
    </div>

    <script>
          jQuery(document).ready(function ($) {
            var url = '<?php echo admin_url('admin-ajax.php'); ?>';
            $('#wishlist_count').hide();
            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    action: 'qtuars_get_wishlist'
                },
                success: function (response) {
                    console.log(response);
                    let response_data = JSON.parse(response);
                    let count = response_data.count;
                    if(count > 0){
                        $('#wishlist_count').text(count);
                        $('#wishlist_count').show();
                    }
                  
                }
            });
        });
    </script>
    <?php
    return ob_get_clean();
}