<?php

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

$user_id = get_current_user_id();
$user_mail = get_userdata($user_id);
?>
<div class="profile">
	<?php if (get_user_meta($user_id, 'profile', true)) : ?>
		<img class="my-account-avater" src="<?php echo get_user_meta($user_id, 'profile', true); ?>" alt="">
	<?php else : ?>
		<img class="my-account-avater" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/my-account-avatar.jpeg" alt="">
	<?php endif; ?>
	<p>Hello <?php echo get_user_meta($user_id, 'first_name', true); ?></p>
	<p><?php echo isset($user_mail->data) ? $user_mail->data->user_email : ''; ?></p>
</div>

<?php
/**
 * My Account dashboard.
 *
 * @since 2.6.0
 */
do_action('woocommerce_account_dashboard');

/**
 * Deprecated woocommerce_before_my_account action.
 *
 * @deprecated 2.6.0
 */
do_action('woocommerce_before_my_account');

/**
 * Deprecated woocommerce_after_my_account action.
 *
 * @deprecated 2.6.0
 */
do_action('woocommerce_after_my_account');

/* Omit closing PHP tag at the end of PHP files to avoid "headers already sent" issues. */
