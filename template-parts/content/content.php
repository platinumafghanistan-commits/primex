<?php
/**
 * Default content template. Used by the main loop in index.php.
 *
 * @package Primex
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'primex-entry' ); ?>>

	<header class="primex-entry__header">
		<?php
		if ( is_singular() ) {
			the_title( '<h1 class="primex-entry__title">', '</h1>' );
		} else {
			the_title(
				sprintf( '<h2 class="primex-entry__title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ),
				'</a></h2>'
			);
		}
		?>

		<div class="primex-entry__meta">
			<?php
			printf(
				/* translators: 1: author link, 2: post date. */
				esc_html__( 'By %1$s · %2$s', 'primex' ),
				wp_kses_post( get_the_author_posts_link() ),
				esc_html( get_the_date() )
			);
			?>
		</div>
	</header>

	<?php if ( has_post_thumbnail() && ! is_singular() ) : ?>
		<a class="primex-entry__thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
			<?php the_post_thumbnail( 'primex-card' ); ?>
		</a>
	<?php endif; ?>

	<div class="primex-entry__content">
		<?php
		if ( is_singular() ) {
			the_content();
			wp_link_pages();
		} else {
			the_excerpt();
			printf(
				'<a class="primex-button primex-button--outline" href="%s">%s</a>',
				esc_url( get_permalink() ),
				esc_html__( 'Read more', 'primex' )
			);
		}
		?>
	</div>

</article>
