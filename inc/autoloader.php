<?php
/**
 * Class autoloader for Primex_* classes.
 *
 * Maps the Primex_ prefix to files under inc/. Sub-namespaces map to
 * subdirectories: Primex_Elementor_Widgets_Hero -> inc/elementor/class-widgets-hero.php.
 * Underscores after the prefix are treated as path separators, and a "class-"
 * prefix is added to the final segment (WP naming convention).
 *
 * @package Primex
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Autoload Primex_* classes on demand.
 *
 * @param string $class_name Fully-qualified class name passed by spl_autoload.
 */
function primex_autoload_class( string $class_name ): void {
	if ( ! str_starts_with( $class_name, 'Primex_' ) ) {
		return;
	}

	// Drop the prefix and split the rest into path segments.
	$relative = substr( $class_name, strlen( 'Primex_' ) );
	$segments = explode( '_', $relative );
	$segments = array_filter( $segments ); // drop empties.

	if ( array() === $segments ) {
		return;
	}

	$last     = array_pop( $segments );
	$segments = array_map( 'strtolower', $segments );

	$file = PRIMEX_DIR . '/inc';
	if ( array() !== $segments ) {
		$file .= '/' . implode( '/', $segments );
	}
	$file .= '/class-' . strtolower( $last ) . '.php';

	if ( file_exists( $file ) ) {
		require_once $file;
	}
}
spl_autoload_register( 'primex_autoload_class' );
