<?php
/**
 * Edit account form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-edit-account.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 7.0.1
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_edit_account_form' ); ?>

<style>
	.woocommerce-MyAccount-navigation {
	display: none;
	}
	.woocommerce-MyAccount-content {
	width: 100% !important;
}
</style>

<h2 class="site-heading">
	<img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/edit my account icon.png" alt=""> Edit My Account
</h2>

<form class="woocommerce-EditAccountForm edit-account row" action="" method="post" <?php do_action( 'woocommerce_edit_account_form_tag' ); ?> >

	<div class="row">

		<div class="col-md-6">
			<?php 
				$user_id = get_current_user_id();
				$user_mail = get_userdata($user_id);
			?>
			<div class="profile">
				<?php if (get_user_meta($user_id, 'profile', true)) : ?>
					<img class="my-account-avater" src="<?php echo get_user_meta($user_id, 'profile', true); ?>" alt="">
				<?php else : ?>
					<img class="my-account-avater" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/my-account-avatar.jpeg" alt="">
				<?php endif; ?>
			</div>
			<div class="profile-uploader">
				<label for="profile"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/camera icon.png" alt=""></label>
				<input type="file" name="profile" id="profile" style="display: none;">
			</div>
		</div>
		<br>
		<div class="col-md-6">
			<div class="form-group">
				<label for="account_first_name"><?php esc_html_e( 'First name', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
				<input type="text" class="form-control" name="account_first_name" id="account_first_name" autocomplete="given-name" value="<?php echo esc_attr( $user->first_name ); ?>" />
				<span>*John</span>
			</div>
		</div>

		<div class="col-md-6">
			<div class="form-group">
				<label for="account_last_name"><?php esc_html_e( 'Last name', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
				<input type="text" class="form-control" name="account_last_name" id="account_last_name" autocomplete="family-name" value="<?php echo esc_attr( $user->last_name ); ?>" />
				<span>*Doe</span>
			</div>
		</div>

		<div class="col-md-6">
			<div class="form-group">
				<label for="billing_phone"><?php esc_html_e( 'Contact Number', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
				<input type="tel" class="form-control" name="billing_phone" id="billing_phone"  value="<?php echo esc_attr( $user->billing_phone ); ?>" />
				<span>*+96 123456789</span>
			</div>
		</div>

		<div class="col-md-6">
			<div class="form-group">
				<label for="account_email"><?php esc_html_e( 'Email address', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
				<input type="email" class="form-control" name="account_email" id="account_email" autocomplete="email" value="<?php echo esc_attr( $user->user_email ); ?>" />
				<span>*Johndoe@gmail</span>
			</div>
		</div>

		<div class="col-md-6">
			<div class="form-group">
				<label for="account_email"><?php esc_html_e( 'Gender', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
				<select name="account_gender" id="account_gender" class="form-control">
					<option value="male" <?php selected( $user->account_gender, 'male' ); ?>><?php esc_html_e( 'Male', 'woocommerce' ); ?></option>
					<option value="female" <?php selected( $user->account_gender, 'female' ); ?>><?php esc_html_e( 'Female', 'woocommerce' ); ?></option>
					<option value="other" <?php selected( $user->account_gender, 'other' ); ?>><?php esc_html_e( 'Other', 'woocommerce' ); ?></option>
				</select>
				<span>*Mail</span>
			</div>
		</div> <br>

		<div class="col-md-6 mb-5">
			<div class="form-group">
				<label for="account_age_above_22"><?php esc_html_e('Age Above 22 ?', 'woocommerce'); ?>&nbsp;<span class="required">*</span></label>
				<div class="form-check form-switch">
					<div class="accept-box">
						<label class="form-check-label" for="account_age_above_22">I here by confirm that the driver age is 
					above 22 years</label>
					<input class="form-check-input" type="checkbox" role="switch" id="account_age_above_22" name="account_age_above_22" <?php checked( $user->account_age_above_22, 'on' ); ?>>
					</div>
				</div>
			</div>
		</div>
	</div>
	<hr/>
	<div class="row mt-5">
		<h3 class="document-title">Upload verification Documents</h3>
		<div class="col-4">
			<div class="form-group mt-3">
				<label for="driver_license" class="form-label">Diver's License</label>
				<div class="input-group">
					<div class="custom-file">
						<label class="custom-file-label" for="diver_license">Choose file</label>
						<input type="file" class="custom-file-input" id="diver_license" name="diver_license" accept=".pdf,.jpg,.jpeg,.png" required>
					</div>
				</div>
			</div>
		</div>
		<div class="col-4">
			<div class="form-group mt-3">
				<label for="driver_license" class="form-label">Sailing License</label>
				<div class="input-group">
					<div class="custom-file">
						<label class="custom-file-label" for="driver_passport">Choose file</label>
						<input type="file" class="custom-file-input" id="driver_passport" name="driver_passport" accept=".pdf,.jpg,.jpeg,.png" required>
					</div>
				</div>
			</div>
		</div>
		<br>
		<div class="col-4 ">
			<div class="form-group mt-3">
				<label for="driver_license" class="form-label">ID/ Passport</label>
				<div class="input-group">
					<div class="custom-file">
						<label class="custom-file-label" for="driver_passport">Choose file</label>
						<input type="file" class="custom-file-input" id="driver_passport" name="driver_passport" accept=".pdf,.jpg,.jpeg,.png" required>
					</div>
				</div>
			</div>
		</div>
	</div>
	<hr>
	<div class="row mt-5">
		<h3 class="document-title">Your Payment Methgod <span style="font-size: 14px;">*No Payment selected</span></h3>
		<div class="col-md-12 payment-methods">
			<img id="payment-gpay" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/gpay.png" alt="">
			<img id="payment-paypal" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/paypal.png" alt="">
		</div>
		
	</div>

	<div class="col-md-12 mt-5 text-end">
		<?php wp_nonce_field( 'save_account_details', 'save-account-details-nonce' ); ?>
		<button type="submit" class="save_account_details_btn" name="save_account_details" value="<?php esc_attr_e( 'Save changes', 'woocommerce' ); ?>"><?php esc_html_e( 'Save', 'woocommerce' ); ?></button>
		<input type="hidden" name="action" value="save_account_details" />
	</div>

</form>

