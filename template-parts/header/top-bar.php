<?php
/**
 * Header template part: top bar.
 *
 * Thin strip above the main header with contact info on the left and social
 * links on the right. Hidden when the customizer toggle is off.
 *
 * @package Primex
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$phone   = primex_get_contact( 'phone' );
$email   = primex_get_contact( 'email' );
$hours   = primex_get_contact( 'hours' );
$address = primex_get_contact( 'address' );

// Don't render anything if all fields + socials are empty.
$has_contact   = ( $phone || $email || $hours || $address );
$socials_count = 0;
foreach ( array( 'facebook', 'twitter', 'linkedin', 'instagram', 'youtube' ) as $net ) {
	if ( get_theme_mod( 'primex_social_' . $net, '' ) ) {
		$socials_count++;
	}
}

if ( ! $has_contact && $socials_count < 1 ) {
	return;
}
?>

<div class="primex-topbar">
	<div class="primex-container primex-topbar__inner">

		<ul class="primex-topbar__contact">
			<?php if ( $phone ) : ?>
				<li>
					<a href="<?php echo esc_url( 'tel:' . preg_replace( '/[^+\d]/', '', $phone ) ); ?>">
						<svg class="primex-topbar__icon" width="14" height="14" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M20 15.5a12.4 12.4 0 0 1-3.9-.6 1.1 1.1 0 0 0-1.1.26l-2.2 2.2a16.7 16.7 0 0 1-7.3-7.3l2.2-2.2a1.1 1.1 0 0 0 .27-1.12A12.4 12.4 0 0 1 7.4 3a1.1 1.1 0 0 0-1.1-1H3a1.1 1.1 0 0 0-1.1 1.1A18 18 0 0 0 19.9 21a1.1 1.1 0 0 0 1.1-1.1v-3.3a1.1 1.1 0 0 0-1-1.1z"/></svg>
						<?php echo esc_html( $phone ); ?>
					</a>
				</li>
			<?php endif; ?>
			<?php if ( $email ) : ?>
				<li>
					<a href="<?php echo esc_url( 'mailto:' . $email ); ?>">
						<svg class="primex-topbar__icon" width="14" height="14" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M20 4H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2zm0 4-8 5-8-5V6l8 5 8-5z"/></svg>
						<?php echo esc_html( $email ); ?>
					</a>
				</li>
			<?php endif; ?>
			<?php if ( $hours ) : ?>
				<li>
					<svg class="primex-topbar__icon" width="14" height="14" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 2a10 10 0 1 0 0 20 10 10 0 0 0 0-20zm0 18a8 8 0 1 1 0-16 8 8 0 0 1 0 16zm1-13h-2v6l5 3 1-1.7-4-2.3z"/></svg>
					<?php echo esc_html( $hours ); ?>
				</li>
			<?php endif; ?>
		</ul>

		<?php if ( $socials_count > 0 ) : ?>
			<?php primex_render_social_links( array( 'class' => 'primex-topbar__social', 'link_class' => 'primex-topbar__social-link' ) ); ?>
		<?php endif; ?>

	</div>
</div>
