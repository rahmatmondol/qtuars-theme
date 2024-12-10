<?php

defined('ABSPATH') || exit;

do_action('woocommerce_before_cart'); ?>


<a class="empty-cart" href="?empty-cart=clearcart">Delete All</a>
<?php
if (isset($_GET['empty-cart']) && $_GET['empty-cart'] == 'clearcart') {
	WC()->cart->empty_cart();
?>
	<script>
		document.location.href = "/cart/";
	</script>
<?php
}
?>
<form class="woocommerce-cart-form" action="<?php echo esc_url(wc_get_cart_url()); ?>" method="post">
	<?php do_action('woocommerce_before_cart_table'); ?>

	<table class="shop_table shop_table_responsive cart woocommerce-cart-form__contents" cellspacing="0">
		<thead>
			<tr>
				<th class="product-remove"><span class="screen-reader-text"><?php esc_html_e('Remove item', 'woocommerce'); ?></span></th>
				<th class="product-thumbnail"><span class="screen-reader-text"><?php esc_html_e('Thumbnail image', 'woocommerce'); ?></span></th>
				<th class="product-name"><?php esc_html_e('Product', 'woocommerce'); ?></th>
				<th class="product-name"><?php esc_html_e('Details', 'woocommerce'); ?></th>
				<th class="product-name"><?php esc_html_e('Total Days', 'woocommerce'); ?></th>
				<th class="product-price"><?php esc_html_e('Total Price', 'woocommerce'); ?></th>
				<th class="product-quantity"><?php esc_html_e('Quantity', 'woocommerce'); ?></th>
				<th class="product-subtotal"><?php esc_html_e('Subtotal', 'woocommerce'); ?></th>
			</tr>
		</thead>
		<tbody>
			<?php do_action('woocommerce_before_cart_contents'); ?>

			<?php
			foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {

				$_product   = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
				$product_id = apply_filters('woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key);
				/**
				 * Filter the product name.
				 *
				 * @since 2.1.0
				 * @param string $product_name Name of the product in the cart.
				 * @param array $cart_item The product in the cart.
				 * @param string $cart_item_key Key for the product in the cart.
				 */
				$product_name = apply_filters('woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key);

				if ($_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters('woocommerce_cart_item_visible', true, $cart_item, $cart_item_key)) {
					$product_permalink = apply_filters('woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink($cart_item) : '', $cart_item, $cart_item_key);
			?>
					<tr class="woocommerce-cart-form__cart-item <?php echo esc_attr(apply_filters('woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key)); ?>">

						<td class="product-remove">
							<?php
							echo apply_filters( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
								'woocommerce_cart_item_remove_link',
								sprintf(
									'<a href="%s" class="remove" aria-label="%s" data-product_id="%s" data-product_sku="%s">&times;</a>',
									esc_url(wc_get_cart_remove_url($cart_item_key)),
									/* translators: %s is the product name */
									esc_attr(sprintf(__('Remove %s from cart', 'woocommerce'), wp_strip_all_tags($product_name))),
									esc_attr($product_id),
									esc_attr($_product->get_sku())
								),
								$cart_item_key
							);
							?>
						</td>

						<td class="product-thumbnail">
							<?php
							$thumbnail = apply_filters('woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key);

							if (!$product_permalink) {
								echo $thumbnail; // PHPCS: XSS ok.
							} else {
								echo $thumbnail; // PHPCS: XSS ok.
							}
							?>
						</td>

						<td class="product-name" data-title="<?php esc_attr_e('Product', 'woocommerce'); ?>">
							<?php
							if (!$product_permalink) {
								echo wp_kses_post($product_name . '&nbsp;');
							} else {
								/**
								 * This filter is documented above.
								 *
								 * @since 2.1.0
								 */
								echo wp_kses_post($product_name . '&nbsp;');
							}

							do_action('woocommerce_after_cart_item_name', $cart_item, $cart_item_key);

							// Meta data.
							echo wc_get_formatted_cart_item_data($cart_item); // PHPCS: XSS ok.

							// Backorder notification.
							if ($_product->backorders_require_notification() && $_product->is_on_backorder($cart_item['quantity'])) {
								echo wp_kses_post(apply_filters('woocommerce_cart_item_backorder_notification', '<p class="backorder_notification">' . esc_html__('Available on backorder', 'woocommerce') . '</p>', $product_id));
							}
							?>
						</td>

						<td class="prodcut-details">
							<?php
							//car price
							$daily_price    = get_post_meta($_product->get_id(), '_per_day_omr', true);
							$insurance      = get_post_meta($_product->get_id(), '_insurance_per_day_omr', true);
							$total_days     = isset($cart_item['variation']['total_days']) ? $cart_item['variation']['total_days'] : '-';
							$insurance = $insurance == '' ? '' : 'Insurace ' . $insurance . '.00.ر.ع' . ' | ';
							$daily_price = $daily_price == '' ? '' : 'Daily Cost ' . $daily_price . '.00.ر.ع';
							echo $insurance;
							echo $daily_price;

							//tent price
							$installation   = get_post_meta($_product->get_id(), '_installation_cost_omr', true);
							$installation   = $installation == '' ? '' : ' Installation Cost ' . $installation . '.00.ر.ع' . ' | ';
							if ($total_days > 20) {
								$total_price = get_post_meta($_product->get_id(), '_20days_omr', true);
								$total_price = $total_price == '' ? '' : 'Daily Cost ' . $total_price . '.00.ر.ع';
							} elseif ($total_days > 11) {
								$total_price = get_post_meta($_product->get_id(), '_11days_omr', true);
								$total_price = $total_price == '' ? '' : 'Daily Cost ' . $total_price . '.00.ر.ع';
							} else {
								$total_price = get_post_meta($_product->get_id(), '_10days_omr', true);
								$total_price = $total_price == '' ? '' : 'Daily Cost ' . $total_price . '.00.ر.ع';
							}
							echo $installation;
							echo $total_price;

							//recovery price
							$recovery = get_post_meta($_product->get_id(), '_recovery_price_omr', true);
							$recovery = $recovery == '' ? '' : 'Daily Cost ' . $recovery . '.00.ر.ع';
							echo $recovery;

							//optional
							$installation = get_post_meta($_product->get_id(), 'installation_cost_omr', true);
							$installation = $installation == '' || $installation == 'na' ? '' : ' Installation Cost ' . $installation . '.00.ر.ع' . ' | ';

							$total_price =  get_post_meta($_product->get_id(), 'per_day_omr', true);
							$total_price = $total_price == '' ? '-' : 'Daily Cost ' . $total_price . '.00.ر.ع';

							echo $installation;
							echo $total_price;
							?>
						</td>

						<td class="perday-price">
							<?php
							$total_days = isset($cart_item['variation']['total_days']) ? $cart_item['variation']['total_days'] : '-';
							echo $total_days;
							?>
						</td>

						<td class="product-price" data-title="<?php esc_attr_e('Price', 'woocommerce'); ?>">
							<?php
							echo apply_filters('woocommerce_cart_item_price', WC()->cart->get_product_price($_product), $cart_item, $cart_item_key); // PHPCS: XSS ok.
							?>
						</td>

						<td class="product-quantity" data-title="<?php esc_attr_e('Quantity', 'woocommerce'); ?>">
							<?php
							if ($_product->is_sold_individually()) {
								$min_quantity = 1;
								$max_quantity = 1;
							} else {
								$min_quantity = 0;
								$max_quantity = $_product->get_max_purchase_quantity();
							}

							$product_quantity = woocommerce_quantity_input(
								array(
									'input_name'   => "cart[{$cart_item_key}][qty]",
									'input_value'  => $cart_item['quantity'],
									'max_value'    => $max_quantity,
									'min_value'    => $min_quantity,
									'product_name' => $product_name,
								),
								$_product,
								false
							);

							echo apply_filters('woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item); // PHPCS: XSS ok.
							?>
						</td>

						<td class="product-subtotal" data-title="<?php esc_attr_e('Subtotal', 'woocommerce'); ?>">
							<?php
							echo apply_filters('woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal($_product, $cart_item['quantity']), $cart_item, $cart_item_key); // PHPCS: XSS ok.
							?>
						</td>
					</tr>
			<?php
				}
			}
			?>

			<?php do_action('woocommerce_cart_contents'); ?>

			<tr>
				<td></td>
				<td></td>
				<td colspan="6" class="actions">

					<?php if (wc_coupons_enabled()) { ?>
						<div class="coupon">
							<label for="coupon_code" class="screen-reader-text"><?php esc_html_e('Coupon:', 'woocommerce'); ?></label> <input type="text" name="coupon_code" class="input-text" id="coupon_code" value="" placeholder="<?php esc_attr_e('Coupon code', 'woocommerce'); ?>" /> <button type="submit" class="button<?php echo esc_attr(wc_wp_theme_get_element_class_name('button') ? ' ' . wc_wp_theme_get_element_class_name('button') : ''); ?>" name="apply_coupon" value="<?php esc_attr_e('Apply coupon', 'woocommerce'); ?>"><?php esc_html_e('Apply coupon', 'woocommerce'); ?></button>
							<?php do_action('woocommerce_cart_coupon'); ?>
						</div>
					<?php } ?>

					<button type="submit" class="button<?php echo esc_attr(wc_wp_theme_get_element_class_name('button') ? ' ' . wc_wp_theme_get_element_class_name('button') : ''); ?>" name="update_cart" value="<?php esc_attr_e('Update cart', 'woocommerce'); ?>"><?php esc_html_e('Update cart', 'woocommerce'); ?></button>

					<?php do_action('woocommerce_cart_actions'); ?>

					<?php wp_nonce_field('woocommerce-cart', 'woocommerce-cart-nonce'); ?>
				</td>
			</tr>

			<?php do_action('woocommerce_after_cart_contents'); ?>
		</tbody>
	</table>
	<?php do_action('woocommerce_after_cart_table'); ?>
</form>
<style>
	.prodcut-details,
	.perday-price {
		border-bottom: 1px solid #eaeaea !important;
		position: relative;
		bottom: -1px;
	}

	
	.woocommerce {
		text-align: right;
		/* box-shadow: -3px 4px 10px 7px #ddddddba; */
		padding: 45px 20px 0px;
		border-radius: 20px;
	}

	.empty-cart {
		background: #333;
		color: #fff !important;
		padding: 10px 20px;
		margin: 0px 0px;
		top: -20px;
		position: relative;
		border-radius: 3px;
	}
</style>
<?php do_action('woocommerce_before_cart_collaterals'); ?>

<div class="cart-collaterals">
	<?php
	/**
	 * Cart collaterals hook.
	 *
	 * @hooked woocommerce_cross_sell_display
	 * @hooked woocommerce_cart_totals - 10
	 */
	do_action('woocommerce_cart_collaterals');
	?>
</div>

<?php do_action('woocommerce_after_cart'); ?>