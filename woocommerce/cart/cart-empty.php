<?php

defined('ABSPATH') || exit;
?>

<div class="woocommerce-cart-emty-page">
	<nav class="woocommerce-breadcrumb">
		<a href="<?php echo site_url(); ?>">Home</a><span>
			<i class="fa fa-angle-right" aria-hidden="true"></i>
		</span>Cart
	</nav>
	<?php do_action('woocommerce_cart_is_empty'); ?>
	<p class="return-to-shop">
		<a class="button wc-backward<?php echo esc_attr(wc_wp_theme_get_element_class_name('button') ? ' ' . wc_wp_theme_get_element_class_name('button') : ''); ?>" href="<?php echo site_url(); ?>/shop">
			<?php
			/**
			 * Filter "Return To Shop" text.
			 *
			 * @since 4.6.0
			 * @param string $default_text Default text.
			 */
			echo esc_html(apply_filters('woocommerce_return_to_shop_text', __('Return to shop', 'woocommerce')));
			?>
		</a>
	</p>
</div>

<style>
	.elementor-35 .elementor-element.elementor-element-d086e0c .woocommerce-breadcrumb {
		display: none;
	}

	.woocommerce-cart-emty-page {
		width: 400px;
		margin: 0 auto;
		margin-top: 0px;
		margin-bottom: 0px;
		margin-top: 0px;
		margin-bottom: 0px;
		box-shadow: 0px 0px 10px 5px #d9d9d9;
		padding: 40px;
		border-radius: 30px;
		margin-top: 60px;
		margin-bottom: 60px;
	}

	.woocommerce-info::before {
		color: #000;
		font-size: 18px;
	}

	.cart-empty.woocommerce-info {
		background-color: #d5d5d5;
		border-radius: 10px;
		padding: 20px 10px 20px 60px;
		text-transform: capitalize;
		font-size: 16px;
	}

	.button.wc-backward {
		background: #373737 !important;
		font-family: "Acumin";
		font-size: 17px !important;
		padding: 17px 20px !important;
		color: #fff !important;
		border-radius: 10px !important;
	}

	.button.wc-backward:hover {
		color: #ddd;
	}
</style>