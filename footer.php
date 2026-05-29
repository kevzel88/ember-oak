<?php
/**
 * The template for displaying the footer
 *
 * @package Ember_Oak
 */
?>

	</main><!-- #main -->

	<footer id="colophon" class="site-footer">

		<div class="footer-widgets">
			<div class="footer-container">

				<!-- Column 1: Brand + Tagline + Social -->
				<div class="footer-col footer-col--brand">
					<div class="footer-brand">
						<?php if ( has_custom_logo() ) : ?>
							<div class="footer-logo">
								<?php the_custom_logo(); ?>
							</div>
						<?php else : ?>
							<p class="footer-site-name">
								<?php echo esc_html( get_bloginfo( 'name' ) ); ?>
							</p>
						<?php endif; ?>

						<?php
						$tagline = get_theme_mod( 'ember_oak_footer_tagline', '' );
						if ( $tagline ) :
						?>
							<p class="footer-tagline"><?php echo esc_html( $tagline ); ?></p>
						<?php endif; ?>
					</div><!-- .footer-brand -->

					<div class="footer-social">
						<?php
						$instagram = get_theme_mod( 'ember_oak_social_instagram', '' );
						$facebook  = get_theme_mod( 'ember_oak_social_facebook', '' );
						$twitter   = get_theme_mod( 'ember_oak_social_twitter', '' );
						?>

						<?php if ( $instagram ) : ?>
							<a href="<?php echo esc_url( $instagram ); ?>" class="social-link social-link--instagram" target="_blank" rel="noopener noreferrer" aria-label="<?php esc_attr_e( 'Follow us on Instagram', 'ember-oak' ); ?>">
								<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-hidden="true" focusable="false" width="24" height="24">
									<path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/>
								</svg>
							</a>
						<?php endif; ?>

						<?php if ( $facebook ) : ?>
							<a href="<?php echo esc_url( $facebook ); ?>" class="social-link social-link--facebook" target="_blank" rel="noopener noreferrer" aria-label="<?php esc_attr_e( 'Follow us on Facebook', 'ember-oak' ); ?>">
								<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-hidden="true" focusable="false" width="24" height="24">
									<path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
								</svg>
							</a>
						<?php endif; ?>

						<?php if ( $twitter ) : ?>
							<a href="<?php echo esc_url( $twitter ); ?>" class="social-link social-link--twitter" target="_blank" rel="noopener noreferrer" aria-label="<?php esc_attr_e( 'Follow us on Twitter', 'ember-oak' ); ?>">
								<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-hidden="true" focusable="false" width="24" height="24">
									<path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
								</svg>
							</a>
						<?php endif; ?>
					</div><!-- .footer-social -->
				</div><!-- .footer-col--brand -->

				<!-- Column 2: Footer Navigation -->
				<div class="footer-col footer-col--nav">
					<h3 class="footer-col__heading"><?php esc_html_e( 'Quick Links', 'ember-oak' ); ?></h3>
					<?php
					wp_nav_menu(
						array(
							'theme_location' => 'footer',
							'menu_class'     => 'footer-menu',
							'container'      => false,
							'fallback_cb'    => false,
							'depth'          => 1,
						)
					);
					?>
				</div><!-- .footer-col--nav -->

				<!-- Column 3: Contact Info -->
				<div class="footer-col footer-col--contact">
					<h3 class="footer-col__heading"><?php esc_html_e( 'Contact Us', 'ember-oak' ); ?></h3>

					<ul class="footer-contact-list">
						<?php
						$phone           = get_theme_mod( 'ember_oak_phone', '' );
						$email           = get_theme_mod( 'ember_oak_email', '' );
						$address         = get_theme_mod( 'ember_oak_address', '' );
						$hours_weekday   = get_theme_mod( 'ember_oak_hours_weekday', esc_html__( 'Mon–Fri: 9am – 5pm', 'ember-oak' ) );
						$hours_weekend   = get_theme_mod( 'ember_oak_hours_weekend', esc_html__( 'Sat–Sun: Closed', 'ember-oak' ) );
						?>

						<?php if ( $phone ) : ?>
							<li class="footer-contact-list__item footer-contact-list__item--phone">
								<span class="contact-label"><?php esc_html_e( 'Phone:', 'ember-oak' ); ?></span>
								<a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', $phone ) ); ?>">
									<?php echo esc_html( $phone ); ?>
								</a>
							</li>
						<?php endif; ?>

						<?php if ( $email ) : ?>
							<li class="footer-contact-list__item footer-contact-list__item--email">
								<span class="contact-label"><?php esc_html_e( 'Email:', 'ember-oak' ); ?></span>
								<a href="mailto:<?php echo esc_attr( $email ); ?>">
									<?php echo esc_html( $email ); ?>
								</a>
							</li>
						<?php endif; ?>

						<?php if ( $address ) : ?>
							<li class="footer-contact-list__item footer-contact-list__item--address">
								<span class="contact-label"><?php esc_html_e( 'Address:', 'ember-oak' ); ?></span>
								<address><?php echo esc_html( $address ); ?></address>
							</li>
						<?php endif; ?>

						<?php if ( $hours_weekday ) : ?>
							<li class="footer-contact-list__item footer-contact-list__item--hours">
								<span class="contact-label"><?php esc_html_e( 'Hours:', 'ember-oak' ); ?></span>
								<span><?php echo esc_html( $hours_weekday ); ?></span>
							</li>
						<?php endif; ?>

						<?php if ( $hours_weekend ) : ?>
							<li class="footer-contact-list__item footer-contact-list__item--hours-weekend">
								<span><?php echo esc_html( $hours_weekend ); ?></span>
							</li>
						<?php endif; ?>
					</ul><!-- .footer-contact-list -->
				</div><!-- .footer-col--contact -->

				<!-- Column 4: Email Signup -->
				<div class="footer-col footer-col--signup">
					<h3 class="footer-col__heading"><?php esc_html_e( 'Stay in Touch', 'ember-oak' ); ?></h3>
					<p class="footer-signup__description">
						<?php esc_html_e( 'Subscribe to our newsletter for updates, offers, and news from Ember &amp; Oak.', 'ember-oak' ); ?>
					</p>

					<form name="email_signup" class="footer-signup-form" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" novalidate>
						<input type="hidden" name="action" value="ember_oak_email_signup">
						<?php wp_nonce_field( 'ember_oak_email_signup_nonce', 'ember_oak_nonce' ); ?>

						<div class="footer-signup-form__field">
							<label for="footer-signup-name" class="screen-reader-text">
								<?php esc_html_e( 'Your Name', 'ember-oak' ); ?>
							</label>
							<input
								type="text"
								id="footer-signup-name"
								name="signup_name"
								class="footer-signup-form__input"
								placeholder="<?php esc_attr_e( 'Your Name', 'ember-oak' ); ?>"
								autocomplete="name"
							>
						</div>

						<div class="footer-signup-form__field">
							<label for="footer-signup-email" class="screen-reader-text">
								<?php esc_html_e( 'Your Email Address', 'ember-oak' ); ?>
							</label>
							<input
								type="email"
								id="footer-signup-email"
								name="signup_email"
								class="footer-signup-form__input"
								placeholder="<?php esc_attr_e( 'Your Email Address', 'ember-oak' ); ?>"
								required
								autocomplete="email"
							>
						</div>

						<div class="footer-signup-form__field footer-signup-form__field--consent">
							<label for="footer-signup-consent" class="footer-signup-form__consent-label">
								<input
									type="checkbox"
									id="footer-signup-consent"
									name="signup_consent"
									value="1"
									required
								>
								<?php esc_html_e( 'I agree to receive email updates. Unsubscribe any time.', 'ember-oak' ); ?>
							</label>
						</div>

						<button type="submit" class="footer-signup-form__submit btn btn--primary">
							<?php esc_html_e( 'Subscribe', 'ember-oak' ); ?>
						</button>
					</form><!-- .footer-signup-form -->
				</div><!-- .footer-col--signup -->

			</div><!-- .footer-container -->
		</div><!-- .footer-widgets -->

		<!-- Footer Bottom Bar -->
		<div class="footer-bottom">
			<div class="footer-container">
				<p class="footer-copyright">
					<?php
					printf(
						/* translators: 1: copyright symbol, 2: year, 3: site name */
						esc_html__( '%1$s %2$s %3$s. All rights reserved.', 'ember-oak' ),
						'&copy;',
						esc_html( date_i18n( 'Y' ) ),
						esc_html( get_bloginfo( 'name' ) )
					);
					?>
				</p>
				<p class="footer-powered-by">
					<?php
					printf(
						/* translators: %s: WordPress link */
						esc_html__( 'Powered by %s', 'ember-oak' ),
						'<a href="https://wordpress.org" target="_blank" rel="noopener noreferrer">WordPress</a>'
					);
					?>
				</p>
			</div><!-- .footer-container -->
		</div><!-- .footer-bottom -->

	</footer><!-- #colophon -->

</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
