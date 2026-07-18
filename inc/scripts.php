<?php
/**
 * Front-end + editor asset loading.
 *
 * @package Primex
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Enqueue front-end styles and scripts.
 */
function primex_enqueue_assets(): void {
	wp_enqueue_style(
		'primex-base',
		PRIMEX_URI . '/assets/css/base.css',
		array(),
		PRIMEX_VERSION
	);

	wp_enqueue_style(
		'primex-components',
		PRIMEX_URI . '/assets/css/components.css',
		array( 'primex-base' ),
		PRIMEX_VERSION
	);

	wp_enqueue_style(
		'primex-header',
		PRIMEX_URI . '/assets/css/header.css',
		array( 'primex-base', 'primex-components' ),
		PRIMEX_VERSION
	);

	wp_enqueue_style(
		'primex-footer',
		PRIMEX_URI . '/assets/css/footer.css',
		array( 'primex-base', 'primex-components' ),
		PRIMEX_VERSION
	);

	if ( primex_header_enabled() && primex_should_load_contact_icons() ) {
		wp_enqueue_style(
			'font-awesome-6',
			'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css',
			array(),
			'6.5.2'
		);
	}

	wp_enqueue_script(
		'primex-main',
		PRIMEX_URI . '/assets/js/main.js',
		array(),
		PRIMEX_VERSION,
		array(
			'in_footer' => true,
			'strategy'  => 'defer',
		)
	);

	if ( primex_header_enabled() ) {
		wp_enqueue_script(
			'primex-header',
			PRIMEX_URI . '/assets/js/header.js',
			array(),
			PRIMEX_VERSION,
			array(
				'in_footer' => true,
				'strategy'  => 'defer',
			)
		);

		wp_localize_script(
			'primex-header',
			'Primex',
			array(
				'header'   => Primex_Header::get_js_config(),
				'darkMode' => get_theme_mod( 'primex_dark_mode', 'auto' ),
			)
		);
	} else {
		wp_add_inline_script(
			'primex-main',
			'window.Primex = window.Primex || {}; window.Primex.darkMode = ' . wp_json_encode( get_theme_mod( 'primex_dark_mode', 'auto' ) ) . ';',
			'before'
		);
	}

	$dark_mode = get_theme_mod( 'primex_dark_mode', 'auto' );
	wp_add_inline_script(
		'primex-main',
		'window.Primex = window.Primex || {}; window.Primex.darkMode = window.Primex.darkMode || ' . wp_json_encode( $dark_mode ) . ';',
		'before'
	);
}
add_action( 'wp_enqueue_scripts', 'primex_enqueue_assets' );

/**
 * Determine if Font Awesome should load for header/menu icons.
 *
 * @return bool
 */
function primex_should_load_contact_icons(): bool {
	if ( (bool) get_theme_mod( 'primex_contact_enabled', true ) && '' !== primex_get_contact_phone() ) {
		return true;
	}

	$locations = get_nav_menu_locations();
	if ( empty( $locations['primary'] ) ) {
		return false;
	}

	$menu = wp_get_nav_menu_object( $locations['primary'] );
	if ( ! $menu ) {
		return false;
	}

	$items = wp_get_nav_menu_items( $menu->term_id );
	if ( ! $items ) {
		return false;
	}

	foreach ( $items as $item ) {
		foreach ( (array) $item->classes as $class ) {
			if ( 0 === strpos( $class, 'icon-' ) ) {
				return true;
			}
		}
	}

	return false;
}

/**
 * Reserved hook point for per-block/per-page CSS strategy.
 */
function primex_enqueue_block_styles(): void {
	// Phase 8.
}
add_action( 'wp_enqueue_scripts', 'primex_enqueue_block_styles' );

/**
 * Register the editor stylesheet mirror.
 */
function primex_enqueue_block_editor_assets(): void {
	wp_enqueue_style(
		'primex-editor-tokens',
		PRIMEX_URI . '/assets/css/base.css',
		array(),
		PRIMEX_VERSION
	);
}
add_action( 'enqueue_block_editor_assets', 'primex_enqueue_block_editor_assets' );

/**
 * Preconnect to font origins.
 *
 * @param array  $urls          Resource URLs.
 * @param string $relation_type Relation type.
 * @return array
 */
function primex_resource_hints( array $urls, string $relation_type ): array {
	if ( 'preconnect' === $relation_type ) {
		$urls[] = array( 'href' => 'https://fonts.googleapis.com' );
		$urls[] = array(
			'href'        => 'https://fonts.gstatic.com',
			'crossorigin' => 'anonymous',
		);
	}
	return $urls;
}
add_filter( 'wp_resource_hints', 'primex_resource_hints', 10, 2 );

/**
 * Preload primary font stylesheet.
 */
function primex_preload_fonts(): void {
	$font_url = 'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Manrope:wght@600;700;800&display=swap';
	printf(
		'<link rel="preload" as="style" href="%s" crossorigin>' . "\n",
		esc_url( $font_url )
	);
	printf(
		'<link rel="stylesheet" href="%s" media="print" onload="this.media=\'all\'">' . "\n",
		esc_url( $font_url )
	);
}
add_action( 'wp_head', 'primex_preload_fonts', 5 );
