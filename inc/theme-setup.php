<?php
/**
 * Theme setup: feature support, menu locations, image sizes, editor styles.
 *
 * @package Primex
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register theme support, menus, and image sizes.
 *
 * Runs on after_setup_theme so it fires before any content rendering.
 */
function primex_theme_setup(): void {
	/*
	 * Core features.
	 */
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'customize-selective-refresh-widgets' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'align-wide' );
	add_theme_support( 'editor-styles' );
	add_theme_support( 'wp-block-styles' );
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
		'style',
		'script',
		'navigation-widgets',
	) );

	/*
	 * Logo: height (px) and width (px) constraints used by the customizer
	 * control. We keep a wide aspect ratio so horizontal logistics logos fit.
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 48,
			'width'       => 200,
			'flex-height' => true,
			'flex-width'  => true,
			'unlink-homepage-logo' => true,
		)
	);

	/*
	 * WooCommerce: declare gallery + product grid features now so WC picks
	 * them up when active. Full WC styling lands in Phase 6.
	 */
	add_theme_support( 'woocommerce' );
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );

	/*
	 * Editor styles: reflect front-end typography in the block editor.
	 * Elementor reads its own kit (Phase 3), so this targets the block editor.
	 */
	add_editor_style( 'editor-style.css' );

	/*
	 * Image sizes used across card + hero layouts. Names are prefixed to
	 * avoid colliding with plugin sizes.
	 */
	add_image_size( 'primex-card', 600, 400, true );
	add_image_size( 'primex-card-tall', 600, 600, true );
	add_image_size( 'primex-wide', 1320, 600, true );
	add_image_size( 'primex-hero', 1920, 1080, true );

	/*
	 * Menu locations. Header/footer layouts (Phase 2) read from these.
	 */
	register_nav_menus(
		array(
			'primary'   => __( 'Primary Menu', 'primex' ),
			'top-bar'   => __( 'Top Bar Menu', 'primex' ),
			'footer'    => __( 'Footer Menu', 'primex' ),
			'mobile'    => __( 'Mobile Menu', 'primex' ),
			'services'  => __( 'Services Menu', 'primex' ),
		)
	);
}
add_action( 'after_setup_theme', 'primex_theme_setup' );

/**
 * Register widget areas used by the footer and blog sidebar (Phase 7 wires
 * customizer controls to these).
 */
function primex_widgets_init(): void {
	$defaults = array(
		'before_widget' => '<section id="%1$s" class="primex-widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="primex-widget__title">',
		'after_title'   => '</h2>',
	);

	register_sidebar(
		array_merge( $defaults, array(
			'name'        => __( 'Blog Sidebar', 'primex' ),
			'id'          => 'primex-blog-sidebar',
			'description' => __( 'Widgets in the blog sidebar.', 'primex' ),
		) )
	);

	// Footer widget areas (up to 4 columns). Footer layout (Phase 7) consumes these.
	for ( $i = 1; $i <= 4; $i++ ) {
		register_sidebar(
			array_merge( $defaults, array(
				/* translators: %d: footer column number. */
				'name'        => sprintf( __( 'Footer Column %d', 'primex' ), $i ),
				'id'          => 'primex-footer-' . $i,
				'description' => sprintf( __( 'Footer widget column %d.', 'primex' ), $i ),
			) )
		);
	}
}
add_action( 'widgets_init', 'primex_widgets_init' );

/**
 * Add primex image sizes to the size dropdown in the media picker, so editors
 * can pick the optimized crops directly.
 *
 * @param array $sizes Existing size names.
 * @return array
 */
function primex_image_size_names( array $sizes ): array {
	return array_merge( $sizes, array(
		'primex-card'      => __( 'Primex Card (4:3)', 'primex' ),
		'primex-card-tall' => __( 'Primex Card Square', 'primex' ),
		'primex-wide'      => __( 'Primex Wide', 'primex' ),
		'primex-hero'      => __( 'Primex Hero', 'primex' ),
	) );
}
add_filter( 'image_size_names_choose', 'primex_image_size_names' );

/**
 * Set content width so large embeds and images are capped.
 *
 * @global int $content_width
 */
function primex_content_width(): void {
	global $content_width;
	if ( ! isset( $content_width ) ) {
		$content_width = 800;
	}
}
add_action( 'after_setup_theme', 'primex_content_width', 0 );
