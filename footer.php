<?php
/**
 * Footer template.
 *
 * Delegates to the selected footer layout (customizer: primex_footer_layout).
 * Elementor Footer Builder (Phase 3) can replace this via the primex_footer
 * action hook.
 *
 * @package Primex
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Render the selected footer layout, unless Elementor Footer Builder takes over
 * (Phase 3).
 */
function primex_render_footer(): void {
	// Phase 3 will call elementor_theme_do_location('footer') here.
	$layout = primex_get_footer_layout();

	if ( ! file_exists( PRIMEX_DIR . '/template-parts/footer/' . $layout . '.php' ) ) {
		$layout = 'footer-1';
	}

	get_template_part( 'template-parts/footer/' . $layout );
}

primex_render_footer();

wp_footer();
?>
</body>
</html>
