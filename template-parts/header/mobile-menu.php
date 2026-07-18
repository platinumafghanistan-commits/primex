<?php
/**
 * Header template part: mobile offcanvas menu.
 *
 * @package Primex
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$show_cta     = (bool) get_theme_mod( 'primex_mobile_show_cta', true );
$show_contact = (bool) get_theme_mod( 'primex_mobile_show_contact', true );
$show_social  = (bool) get_theme_mod( 'primex_mobile_show_social', false );
?>

<div id="primex-mobile-menu" class="primex-mobile-menu" hidden>
	<div class="primex-mobile-menu__backdrop" data-primex-close="mobile-menu" tabindex="-1"></div>

	<aside class="primex-mobile-menu__panel" aria-label="<?php esc_attr_e( 'Mobile navigation', 'primex' ); ?>" role="dialog" aria-modal="true">

		<div class="primex-mobile-menu__head">
			<div class="primex-mobile-menu__brand">
				<?php primex_the_logo( 'mobile' ); ?>
			</div>
			<button type="button" class="primex-mobile-menu__close" aria-expanded="true" aria-controls="primex-mobile-menu" aria-label="<?php esc_attr_e( 'Close menu', 'primex' ); ?>" data-primex-toggle="mobile-menu">
				<svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M19 6.4 17.6 5 12 10.6 6.4 5 5 6.4 10.6 12 5 17.6 6.4 19 12 13.4 17.6 19 19 17.6 13.4 12z"/></svg>
			</button>
		</div>

		<nav class="primex-mobile-menu__nav" aria-label="<?php esc_attr_e( 'Mobile', 'primex' ); ?>">
			<?php
			wp_nav_menu(
				primex_get_nav_menu_args(
					array(
						'theme_location' => 'mobile',
						'menu_class'     => 'primex-mobile-menu__list',
						'menu_id'        => 'primex-mobile-menu-list',
						'fallback_cb'    => static function () {
							wp_nav_menu(
								primex_get_nav_menu_args(
									array(
										'theme_location' => 'primary',
										'menu_class'     => 'primex-mobile-menu__list',
										'menu_id'        => 'primex-mobile-menu-list',
									)
								)
							);
						},
					)
				)
			);
			?>
		</nav>

		<?php if ( $show_contact ) : ?>
			<div class="primex-mobile-menu__contact">
				<?php get_template_part( 'template-parts/header/parts/contact' ); ?>
			</div>
		<?php endif; ?>

		<?php if ( $show_cta ) : ?>
			<div class="primex-mobile-menu__actions">
				<?php get_template_part( 'template-parts/header/parts/cta-button' ); ?>
			</div>
		<?php endif; ?>

		<?php if ( $show_social ) : ?>
			<div class="primex-mobile-menu__social">
				<?php primex_render_social_links( array( 'class' => 'primex-mobile-menu__social-list', 'link_class' => 'primex-mobile-menu__social-link' ) ); ?>
			</div>
		<?php endif; ?>

	</aside>
</div>
