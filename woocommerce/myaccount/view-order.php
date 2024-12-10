<?php

defined('ABSPATH') || exit;

$notes = $order->get_customer_order_notes();


$order = wc_get_order( $order_id );
if ( ! $order ) {
    return;
}

$show_customer_details = is_user_logged_in() && $order->get_user_id() === get_current_user_id();

?>
<style>
	.myaccount-box {
		width: 100%;
		box-shadow: 0px 0px 10px 10px #ddd;
		border-radius: 30px;
		padding: 30px;
	}

	.woocommerce-MyAccount-navigation,
	.MyAccount-navigation {
		display: none;
	}

	.woocommerce-MyAccount-content {
		width: 70% !important;
		margin: 0 auto;
		float: none !important;
	}

	.site-heading {
		font-family: "Best In Class";
		font-size: 35px;
		text-transform: uppercase;
		color: #373737;
		font-weight: 500;
		position: relative;
		top: -60px;
		left: -47px;
	}

	.woocommerce-order-details__title {
		display: none;
	}

	.brath {
		display: flex;
		justify-content: start;
		align-items: center;
		margin: 40px 0px;
	}

	.brath img {
		width: 31px;
		height: fit-content;
	}

	.brath h2 {
		font-size: 34px;
	}

	.woocommerce {
		margin-top: -110px;
	}

	.woocommerce-order-details {
		max-width: 100% !important;
		box-shadow: 0 0px 10px 10px #ddddddd1;
		border-radius: 30px;
		padding: 30px;
	}

	.woocommerce-order-details table thead tr th {
		background: #54595F !important;
		color: #fff;
		font-size: 22px !important;
	}

	.woocommerce-customer-details {
		display: none;
	}

	.woocommerce-table.woocommerce-table--order-details.shop_table.order_details tr td {
		border-color: #eee;
	}

	.woocommerce-table.woocommerce-table--order-details.shop_table.order_details tfoot tr th {
		border-color: #fff;
		background: #ececec;
	}
</style>
<div class="brath">
	<img class="brath-image" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/order history icon.jpg" alt="">
	<h2>Order History</h2>
	<span>More details</span>
</div>

<div class="view-order-box container">
	<div class="row mb-5">
		<div class="col-md-6">
			<h2 class="order-title">
			<?php
			$items = $order->get_items();
			foreach ( $items as $item ) {
				echo esc_html( $item->get_name() );
			}
			?>
			</h2>
			<div class="product-images">
				<?php
				foreach ($items as $item) {
					$product = $item->get_product();
					$product_image_url = wp_get_attachment_image_url($product->get_image_id(), 'full');
					if ($product_image_url) {
						echo '<img src="' . esc_url($product_image_url) . '" alt="' . esc_attr($item->get_name()) . '" />';
					}
				}
				?>
			</div>
		</div>
		<div class="col-md-6">
			<div class="order-details">
				<ul>
					<li>
						<img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/location.png" alt="">
						Pick-up Location <br>
						<span> 
							<?php
							foreach ($items as $item) {
								$item_meta_data = $item->get_meta_data();
								foreach ($item_meta_data as $meta) {
									if ($meta->key === 'meeting_point') {
										echo esc_html($meta->value);
									}
								}
							}
							?> 
						</span>
					</li>
					<li>
						<img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/calender  icon.png" alt="">
						Date <br>
						<span> 
							<?php
							foreach ($items as $item) {
								$item_meta_data = $item->get_meta_data();
								foreach ($item_meta_data as $meta) {
									if ($meta->key === 'date') {
										echo esc_html($meta->value);
									}
								}
							}
							?> 
						</span>
					</li>
					<li>
						<img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/clock icon.png" alt="">
						Duration <br>
						<span> 
							<?php
							foreach ($items as $item) {
								$product = $item->get_product();
								$duration = get_field('duration', $product->get_id());
								echo esc_html($duration);
							}
							?> 
						</span>
					</li>
					<li>
						<img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/overview icon.png" alt="">
						Overview <br>
						<span> 
							<?php
							foreach ($items as $item) {
								$product = $item->get_product();
								$description = wp_trim_words($product->get_description(), 30);
								echo esc_html($description);
							}
							?> 
						</span>
					</li>
				</ul>
			</div>
		</div>
	</div>
	<hr>
	<div class="row mt-5">
		<div class="col-md-6" style="border-right: 1px solid #d1d1d1;"></div>
		<div class="col-md-6">
			<ul class="show-order-summary pb-5">
				<li>
					<span>Price Paid:</span>
					<span><?php echo $order->get_formatted_order_total(); ?></span>
				</li>
				<li>
					<span>Subtotal:</span>
					<span><?php echo $order->get_subtotal_to_display(); ?></span>
				</li>
				<li>
					<span>Tax total:</span>
					<span><?php echo esc_html($order->get_total_tax()); ?></span>
				</li>
				<li>
					<span>Grand Total:</span>
					<span><?php echo $order->get_formatted_order_total(); ?></span>
				</li>
			</ul>
			<a href="<?php echo esc_url( add_query_arg( array( 'order_again' => $order->get_id() ), wc_get_cart_url() ) ); ?>" class="button wc-forward">
				<?php esc_html_e( 'Book Again', 'woocommerce' ); ?>
			</a>
		</div>
	</div>
	
</div>
