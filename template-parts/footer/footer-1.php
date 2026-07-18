<?php
/**
 * Footer template part: footer-1.
 *
 * Dark footer with four widget columns and a bottom bar holding copyright +
 * legal links. About column carries the footer logo (custom logo) and the
 * about blurb from the customizer.
 *
 * @package Primex
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$about_text = wp_kses_post( (string) get_theme_mod( 'primex_footer_about_text', '' ) );
$copyright  = wp_kses_post( (string) get_theme_mod( 'primex_footer_copyright', '' ) );
$phone      = primex_get_contact( 'phone' );
$email      = primex_get_contact( 'email' );
$address    = primex_get_contact( 'address' );
?>

<footer id="primex-footer" class="primex-footer" role="contentinfo">
	<div class="primex-container">

		<div class="primex-footer__grid">

			<div class="primex-footer__col primex-footer__col--about">
				<div class="primex-footer__logo">
					<?php
					if ( has_custom_logo() ) {
						the_custom_logo();
					} else {
						printf(
							'<a href="%1$s" class="primex-footer__brand-link" rel="home"><strong>%2$s</strong></a>',
							esc_url( home_url( '/' ) ),
							esc_html( get_bloginfo( 'name' ) )
						);
					}
					?>
				</div>

				<?php if ( $about_text ) : ?>
					<p class="primex-footer__about"><?php echo $about_text; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped — already wp_kses_post. ?></p>
				<?php endif; ?>

				<?php
				// Social links under the about blurb.
				primex_render_social_links( array(
					'class'      => 'primex-footer__social',
					'link_class' => 'primex-footer__social-link',
				) );
				?>
			</div>

			<?php for ( $i = 2; $i <= 4; $i++ ) : ?>
				<div class="primex-footer__col">
					<?php if ( is_active_sidebar( 'primex-footer-' . $i ) ) : ?>
						<?php dynamic_sidebar( 'primex-footer-' . $i ); ?>
					<?php else : ?>
						<?php // Soft placeholder so the layout doesn't collapse when no widgets are set yet. ?>
						<?php if ( 2 === $i ) : ?>
							<h2 class="primex-widget__title"><?php esc_html_e( 'Quick Links', 'primex' ); ?></h2>
							<?php
							wp_nav_menu( array(
								'theme_location' => 'footer',
								'menu_class'     => 'primex-footer__links',
								'container'      => false,
								'depth'          => 1,
								'fallback_cb'    => false,
							) );
							?>
						<?php elseif ( 3 === $i && ( $phone || $email || $address ) ) : ?>
							<h2 class="primex-widget__title"><?php esc_html_e( 'Contact', 'primex' ); ?></h2>
							<ul class="primex-footer__contact">
								<?php if ( $address ) : ?>
									<li><svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 2a7 7 0 0 0-7 7c0 5.25 7 13 7 13s7-7.75 7-13a7 7 0 0 0-7-7zm0 9.5A2.5 2.5 0 1 1 12 6.5a2.5 2.5 0 0 1 0 5z"/></svg> <?php echo esc_html( $address ); ?></li>
								<?php endif; ?>
								<?php if ( $phone ) : ?>
									<li><svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M20 15.5a12.4 12.4 0 0 1-3.9-.6 1.1 1.1 0 0 0-1.1.26l-2.2 2.2a16.7 16.7 0 0 1-7.3-7.3l2.2-2.2a1.1 1.1 0 0 0 .27-1.12A12.4 12.4 0 0 1 7.4 3a1.1 1.1 0 0 0-1.1-1H3a1.1 1.1 0 0 0-1.1 1.1A18 18 0 0 0 19.9 21a1.1 1.1 0 0 0 1.1-1.1v-3.3a1.1 1.1 0 0 0-1-1.1z"/></svg> <a href="<?php echo esc_url( 'tel:' . preg_replace( '/[^+\d]/', '', $phone ) ); ?>"><?php echo esc_html( $phone ); ?></a></li>
								<?php endif; ?>
								<?php if ( $email ) : ?>
									<li><svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M20 4H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2zm0 4-8 5-8-5V6l8 5 8-5z"/></svg> <a href="<?php echo esc_url( 'mailto:' . $email ); ?>"><?php echo esc_html( $email ); ?></a></li>
								<?php endif; ?>
							</ul>
						<?php elseif ( 4 === $i ) : ?>
							<h2 class="primex-widget__title"><?php esc_html_e( 'Newsletter', 'primex' ); ?></h2>
							<p class="primex-footer__newsletter-text"><?php esc_html_e( 'Subscribe for logistics insights and updates.', 'primex' ); ?></p>
							<form class="primex-footer__newsletter" action="#" method="post">
								<label class="screen-reader-text" for="primex-footer-email"><?php esc_html_e( 'Email address', 'primex' ); ?></label>
								<input type="email" id="primex-footer-email" name="email" placeholder="<?php esc_attr_e( 'Your email', 'primex' ); ?>" required>
								<button type="submit" class="primex-button primex-button--secondary"><?php esc_html_e( 'Subscribe', 'primex' ); ?></button>
							</form>
						<?php endif; ?>
					<?php endif; ?>
				</div>
			<?php endfor; ?>

		</div>

		<div class="primex-footer__bottom">
			<p class="primex-footer__copyright">
				<?php
				if ( $copyright ) {
					echo $copyright; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped — already wp_kses_post.
				} else {
					printf(
						/* translators: 1: current year, 2: site name. */
						esc_html__( '© %1$s %2$s. All rights reserved.', 'primex' ),
						esc_html( gmdate( 'Y' ) ),
						esc_html( get_bloginfo( 'name' ) )
					);
				}
				?>
			</p>
			<nav class="primex-footer__legal" aria-label="<?php esc_attr_e( 'Legal', 'primex' ); ?>">
				<?php
				wp_nav_menu( array(
					'theme_location' => 'footer',
					'menu_class'     => 'primex-footer__legal-list',
					'container'      => false,
					'depth'          => 1,
					'fallback_cb'    => false,
				) );
				?>
			</nav>
		</div>

	</div>
</footer>
