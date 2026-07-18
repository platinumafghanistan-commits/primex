<?php
/**
 * Header template part: header-1 (standard solid).
 *
 * Logo left, primary nav center, search toggle + Quote button right.
 * Includes a mobile hamburger that opens the offcanvas menu.
 *
 * @package Primex
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<header id="primex-header" class="primex-header" role="banner" data-primex-header data-primex-sticky="<?php echo primex_get_sticky_header() ? 'true' : 'false'; ?>">

	<?php if ( primex_show_topbar() ) : ?>
		<?php get_template_part( 'template-parts/header/top-bar' ); ?>
	<?php endif; ?>

	<div class="primex-header__bar">
		<div class="primex-container primex-header__inner">

			<div class="primex-header__brand">
				<?php
				if ( has_custom_logo() ) {
					the_custom_logo();
				} else {
					printf(
						'<a href="%1$s" class="primex-header__brand-link" rel="home"><strong>%2$s</strong></a>',
						esc_url( home_url( '/' ) ),
						esc_html( get_bloginfo( 'name' ) )
					);
				}
				?>
			</div>

			<nav class="primex-header__nav" aria-label="<?php esc_attr_e( 'Primary', 'primex' ); ?>">
				<?php
				wp_nav_menu( array(
					'theme_location' => 'primary',
					'menu_id'        => 'primex-primary-menu',
					'menu_class'     => 'primex-menu',
					'container'      => false,
					'fallback_cb'    => false,
					'depth'          => 3,
					'walker'         => new Primex_Menu_Walker(),
				) );
				?>
			</nav>

			<div class="primex-header__actions">
				<button type="button" class="primex-header__search-toggle" aria-expanded="false" aria-controls="primex-search-panel" data-primex-toggle="search">
					<span class="screen-reader-text"><?php esc_html_e( 'Search', 'primex' ); ?></span>
					<svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M15.5 14h-.79l-.28-.27a6.5 6.5 0 1 0-.7.7l.27.28v.79l5 4.99L20.49 19zm-6 0A4.5 4.5 0 1 1 14 9.5 4.49 4.49 0 0 1 9.5 14z"/></svg>
				</button>

				<?php primex_render_quote_button(); ?>

				<button type="button" class="primex-header__burger" aria-expanded="false" aria-controls="primex-mobile-menu" data-primex-toggle="mobile-menu" aria-label="<?php esc_attr_e( 'Open menu', 'primex' ); ?>">
					<span></span><span></span><span></span>
				</button>
			</div>

		</div>
	</div>

	<div id="primex-search-panel" class="primex-search-panel" hidden>
		<div class="primex-container">
			<?php get_search_form(); ?>
		</div>
	</div>

	<?php get_template_part( 'template-parts/header/mobile-menu' ); ?>

</header>
