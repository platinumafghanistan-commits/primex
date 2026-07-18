<?php
/**
 * Header template.
 *
 * Elementor Theme Builder can replace the header via elementor_theme_do_location().
 *
 * @package Primex
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Render the theme header unless Elementor Theme Builder owns the location.
 */
function primex_render_header(): void {
	if ( ! primex_header_enabled() ) {
		return;
	}

	/**
	 * Fires before the header renders.
	 */
	do_action( 'primex_before_header' );

	if ( function_exists( 'elementor_theme_do_location' ) && elementor_theme_do_location( 'header' ) ) {
		do_action( 'primex_after_header' );
		return;
	}

	$layout = primex_get_header_layout();

	if ( ! file_exists( PRIMEX_DIR . '/template-parts/header/' . $layout . '.php' ) ) {
		$layout = 'header-logistics';
	}

	get_template_part( 'template-parts/header/' . $layout );

	do_action( 'primex_after_header' );
}
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<?php primex_render_header(); ?>
