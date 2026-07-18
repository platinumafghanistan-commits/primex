<?php
/**
 * The fallback template.
 *
 * Used by the template hierarchy when no more-specific template matches.
 * Renders a simple post loop. Elementor pages render via their own templates
 * (Phase 3+); this is the safety net for non-Elementor content.
 *
 * @package Primex
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<main id="primex-content" class="primex-main">
	<div class="primex-container">

		<?php if ( have_posts() ) : ?>

			<header class="primex-page-header">
				<?php
				if ( is_home() && ! is_front_page() ) {
					single_post_title( '<h1 class="primex-page-title">', '</h1>' );
				} elseif ( is_archive() ) {
					the_archive_title( '<h1 class="primex-page-title">', '</h1>' );
					the_archive_description( '<div class="primex-archive-description">', '</div>' );
				}
				?>
			</header>

			<div class="primex-loop">
				<?php
				while ( have_posts() ) :
					the_post();
					get_template_part( 'template-parts/content/content', get_post_type() ?: 'search' );
				endwhile;

				the_posts_pagination( array(
					'prev_text'          => esc_html__( 'Previous', 'primex' ),
					'next_text'          => esc_html__( 'Next', 'primex' ),
					'class'              => 'primex-pagination',
					'before_page_number' => '<span class="screen-reader-text">' . esc_html__( 'Page', 'primex' ) . ' </span>',
				) );
				?>

			</div>

		<?php else : ?>

			<?php get_template_part( 'template-parts/content/content', 'none' ); ?>

		<?php endif; ?>

	</div>
</main>

<?php
get_footer();
