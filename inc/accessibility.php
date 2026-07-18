<?php
/**
 * Accessibility helpers: skip-to-content link and a11y-friendly markup.
 *
 * @package Primex
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Emit the skip-to-content link as the very first body content via wp_body_open.
 *
 * The target (#primex-content) must be the id of the main content container.
 * Header/footer layouts (Phase 2) wrap the main content area with that id.
 */
function primex_skip_link(): void {
	?>
	<a class="primex-skip-link screen-reader-text" href="#primex-content">
		<?php esc_html_e( 'Skip to content', 'primex' ); ?>
	</a>
	<?php
}
add_action( 'wp_body_open', 'primex_skip_link' );

/**
 * Move focus to #primex-content when the skip link is used. Vanilla JS, no
 * jQuery, loaded inline so it works before main.js defers.
 */
function primex_skip_link_focus_script(): void {
	if ( is_admin() ) {
		return;
	}
	?>
	<script>
	(function () {
		document.addEventListener('click', function (event) {
			if (event.target && event.target.matches('.primex-skip-link')) {
				var target = document.getElementById('primex-content');
				if (target) {
					event.preventDefault();
					target.setAttribute('tabindex', '-1');
					target.focus({ preventScroll: true });
					target.addEventListener('blur', function () {
						target.removeAttribute('tabindex');
					}, { once: true });
				}
			}
		});
	})();
	</script>
	<?php
}
add_action( 'wp_footer', 'primex_skip_link_focus_script' );

/**
 * Add aria-label to the default read-more link and to navigation blocks.
 * Specific markup tweaks land with Phase 2 (header/footer); this file holds
 * global a11y behavior.
 */

/**
 * Ensure a category list adds an aria-label so screen reader users know the
 * region's purpose even when the visual heading is elsewhere.
 */
function primex_add_screen_reader_text_class( array $args ): array {
	if ( isset( $args['class'] ) ) {
		$args['class'] .= ' primex-aria-region';
	}
	return $args;
}
