<?php
/**
 * Primex functions and definitions.
 *
 * Bootstrap file. Constants, version guards, autoloader, and module includes.
 * No business logic belongs here — each concern lives in its own file under inc/.
 *
 * @package Primex
 * @since   1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Direct access denied.
}

/**
 * Theme constants.
 */
define( 'PRIMEX_VERSION', '1.0.0' );
define( 'PRIMEX_DIR', get_template_directory() );
define( 'PRIMEX_URI', get_template_directory_uri() );
define( 'PRIMEX_MIN_PHP', '8.2' );

/**
 * PHP version guard.
 *
 * If the site runs an older PHP version, load nothing else and surface an admin
 * notice so the site owner can act. Returning early keeps the theme from
 * crashing on PHP 8.2-only syntax it might otherwise load.
 */
if ( version_compare( PHP_VERSION, PRIMEX_MIN_PHP, '<' ) ) {
	add_action( 'admin_notices', 'primex_php_version_notice' );
	return;
}

/**
 * Admin notice for insufficient PHP version.
 */
function primex_php_version_notice(): void {
	printf(
		'<div class="notice notice-error"><p>%s</p></div>',
		wp_kses(
			sprintf(
				/* translators: 1: theme name, 2: required PHP version, 3: current PHP version. */
				__( 'The <strong>%1$s</strong> theme requires PHP %2$s or higher. You are running PHP %3$s. Please upgrade PHP to use this theme.', 'primex' ),
				'Primex',
				esc_html( PRIMEX_MIN_PHP ),
				esc_html( PHP_VERSION )
			),
			array( 'strong' => array() )
		)
	);
}

/**
 * Autoloader for Primex_* classes (file-map under inc/ and inc/*).
 */
require_once PRIMEX_DIR . '/inc/autoloader.php';

/**
 * Core modules. Each file registers its own hooks on load.
 */
$primex_modules = array(
	'theme-setup.php',
	'header/helpers.php',
	'header/class-header.php',
	'header/svg-upload.php',
	'customizer.php',
	'menu-walker.php',
	'scripts.php',
	'accessibility.php',
	'elementor/class-integration.php',
);

foreach ( $primex_modules as $primex_module ) {
	require_once PRIMEX_DIR . '/inc/' . $primex_module;
}

/**
 * Load translated strings for the theme.
 *
 * Hooked late so it runs after WordPress core loads its own textdomain.
 */
function primex_setup_textdomain(): void {
	load_theme_textdomain( 'primex', PRIMEX_DIR . '/languages' );
}
add_action( 'after_setup_theme', 'primex_setup_textdomain' );
