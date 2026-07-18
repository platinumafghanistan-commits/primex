<?php
/**
 * Header template part: logistics layout.
 *
 * Logo left, primary navigation centered, contact + CTA right.
 * Matches premium logistics header proportions (1280px container).
 *
 * @package Primex
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$sticky_attrs = array(
	'data-primex-header'        => '',
	'data-primex-sticky'        => primex_get_sticky_header() ? 'true' : 'false',
	'data-primex-hide-down'     => get_theme_mod( 'primex_sticky_hide_down', false ) ? 'true' : 'false',
	'data-primex-reveal-up'     => get_theme_mod( 'primex_sticky_reveal_up', true ) ? 'true' : 'false',
	'data-primex-shrink'        => get_theme_mod( 'primex_sticky_shrink', true ) ? 'true' : 'false',
	'data-primex-sticky-offset' => (string) primex_sanitize_int_range( get_theme_mod( 'primex_sticky_offset', 20 ), 0, 300, 20 ),
);

$attr_string = '';
foreach ( $sticky_attrs as $key => $val ) {
	$attr_string .= sprintf( ' %s="%s"', esc_attr( $key ), esc_attr( $val ) );
}

$nav_hover = primex_sanitize_nav_hover_style( (string) get_theme_mod( 'primex_nav_hover_style', 'color' ) );
$dropdown  = primex_sanitize_dropdown_animation( (string) get_theme_mod( 'primex_nav_dropdown_animation', 'fade' ) );
?>

<header id="primex-header" class="primex-header primex-header--logistics primex-nav-hover-<?php echo esc_attr( $nav_hover ); ?> primex-dropdown-<?php echo esc_attr( $dropdown ); ?>" role="banner"<?php echo $attr_string; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped above. ?>>

	<?php if ( primex_show_topbar() ) : ?>
		<?php get_template_part( 'template-parts/header/top-bar' ); ?>
	<?php endif; ?>

	<div class="primex-header__sentinel" aria-hidden="true"></div>

	<div class="primex-header__bar">
		<div class="primex-container primex-header__inner">

			<div class="primex-header__brand">
				<?php
				/**
				 * Fires in the header brand/logo zone.
				 */
				do_action( 'primex_header_brand' );
				primex_the_logo( 'desktop' );
				?>
			</div>

			<div class="primex-header__nav">
				<?php
				do_action( 'primex_header_navigation' );
				get_template_part( 'template-parts/header/parts/navigation' );
				?>
			</div>

			<div class="primex-header__actions">
				<?php do_action( 'primex_header_actions' ); ?>

				<div class="primex-header__contact">
					<?php get_template_part( 'template-parts/header/parts/contact' ); ?>
				</div>

				<div class="primex-header__cta primex-header__cta--desktop">
					<?php get_template_part( 'template-parts/header/parts/cta-button' ); ?>
				</div>

				<button type="button" class="primex-header__burger" aria-expanded="false" aria-controls="primex-mobile-menu" data-primex-toggle="mobile-menu" aria-label="<?php esc_attr_e( 'Open menu', 'primex' ); ?>">
					<span class="primex-header__burger-line" aria-hidden="true"></span>
					<span class="primex-header__burger-line" aria-hidden="true"></span>
					<span class="primex-header__burger-line" aria-hidden="true"></span>
				</button>
			</div>

		</div>
	</div>

	<?php if ( (bool) get_theme_mod( 'primex_mobile_enabled', true ) ) : ?>
		<?php get_template_part( 'template-parts/header/mobile-menu' ); ?>
	<?php endif; ?>

</header>
