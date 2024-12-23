<?php

defined( 'ABSPATH' ) || exit;

global $product;

if ( ! comments_open() ) {
	return;
}

?>
<div id="reviews" class="woocommerce-Reviews">
	<div id="comments">
		<h2 class="woocommerce-Reviews-title">
			Reviews
			<?php
				$count = $product->get_review_count();
				echo $count;
			?>
		</h2>

		<?php if ( have_comments() ) : ?>
		<ol class="commentlist">
			<?php wp_list_comments( apply_filters( 'woocommerce_product_review_list_args', array( 'callback' => 'woocommerce_comments' ) ) ); ?>
		</ol>

		<?php
			if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) :
				echo '<nav class="woocommerce-pagination">';
				paginate_comments_links(
					apply_filters(
						'woocommerce_comment_pagination_args',
						array(
							'prev_text' => is_rtl() ? '&rarr;' : '&larr;',
							'next_text' => is_rtl() ? '&larr;' : '&rarr;',
							'type'      => 'list',
						)
					)
				);
				echo '</nav>';
			endif;
			?>
		<?php else : ?>
		<p class="woocommerce-noreviews">
			<?php esc_html_e( 'There are no reviews yet.', 'woocommerce' ); ?>
		</p>
		<?php endif; ?>
	</div>

	<?php if ( get_option( 'woocommerce_review_rating_verification_required' ) === 'no' || wc_customer_bought_product( '', get_current_user_id(), $product->get_id() ) ) : ?>
	<div id="review_form_wrapper">
		<div id="review_form">
			<div id="respond" class="comment-respond">
				<span id="reply-title" class="comment-reply-title">Be the first to review “Banana Boat Ride” <small>
						<a rel="nofollow" id="cancel-comment-reply-link" href="/product/banana-boat-ride/#respond"
							style="display:none;">Cancel reply</a>
					</small>
				</span>
				<form action="http://qtours.test/wp-comments-post.php" method="post" id="commentform"
					class="comment-form" novalidate="">
					<p class="comment-notes"><span id="email-notes">Your email address will not be published.</span>
						<span class="required-field-message">Required fields are marked <span class="required">*</span>
						</span>
					</p>
					<div class="comment-form-rating">
						<label for="rating">Your rating&nbsp;<span class="required">*</span>
						</label>
						<select name="rating" id="rating" required="" style="display: none;">
							<option value="">Rate…</option>
							<option value="5">Perfect</option>
							<option value="4">Good</option>
							<option value="3">Average</option>
							<option value="2">Not that bad</option>
							<option value="1">Very poor</option>
						</select>
					</div>

				<?php if ( !is_user_logged_in() ) : ?>

					<p class="comment-form-author">
						<input placeholder="Name*" id="author" name="author" type="text" value="" size="30" required="">
					</p>
					<p class="comment-form-phone">
						<input placeholder="Phone*" id="phone" name="phone" type="text" value="" size="30" required="">
					</p>
					<p class="comment-form-email"><input placeholder="Email*" id="email" name="email" type="email"
							value="" size="30" required="">
					</p>

					<div class="check">
						<span>In contacting us, you consent to receiving important updates and up coming events, via:
						</span>
						<div class="boxes">
							<div class="form-check form-check-inline">
								<input class="form-check-input" type="checkbox" name="wp-comment-cookies-consent"
									id="inlineRadio1" value="email">
								<label class="form-check-label" for="inlineRadio1">Email</label>
							</div>
							<div class="form-check form-check-inline">
								<input class="form-check-input" type="checkbox" name="inlineRadioOptions"
									id="inlineRadio2" value="whatsapp" checked="">
								<label class="form-check-label" for="inlineRadio2">Whatsapp</label>
							</div>
							<div class="form-check form-check-inline form-switch">
								<input class="form-check-input" type="checkbox" role="switch"
									id="flexSwitchCheckChecked" checked="">
								<label class="form-check-label" for="flexSwitchCheckChecked">Untoggle to Deactivate
								</label>
							</div>

						</div>
						
					</div>

				<?php endif; ?>

					<p class="comment-form-comment">
						<textarea id="comment" name="comment" cols="45" rows="8" placeholder="Your Review*" required=""
							style="height: 216px;"></textarea>
					</p>

					<div class="submit-group row">
						<div class="col-md-2">
							<p class="form-submit ">
								<input name="submit" type="submit" id="submit" class="submit d-block d-md-inline-block" value="Submit">
								<input type="hidden" name="comment_post_ID" value="<?php the_ID(); ?>" id="comment_post_ID">
								<input type="hidden" name="comment_parent" id="comment_parent" value="0">
							</p>
						</div>
						<div class="col-md-8">
							<div class="share-tripadvisor ">
								<a href="https://www.tripadvisor.com/Attraction_Review-g1940497-d12356088-Reviews-QTours_om-Muscat_Muscat_Governorate.html" target="_blank" class="share-button d-block d-md-inline-block"> 
									<img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/share.png" alt="">
								</a>
								<span>Simply copy and paste your review and share it on tripadvisor</span>
							</div>
						</div>
					</div>

				</form>
			</div><!-- #respond -->
		</div>
	</div>
	<?php else : ?>
	<p class="woocommerce-verification-required">
		<?php esc_html_e( 'Only logged in customers who have purchased this product may leave a review.', 'woocommerce' ); ?>
	</p>
	<?php endif; ?>



	<div class="clear"></div>
</div>