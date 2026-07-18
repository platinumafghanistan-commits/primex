<?php
/**
 * Template Name: Full Width (no sidebar)
 * Template Post Type: page,primex_service,primex_fleet,primex_team,primex_testimonial
 *
 * Header + footer on, content area spans the full container width (no sidebar).
 *
 * @package Primex
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<main id="primex-content" class="primex-main primex-main--fullwidth">

	<?php
	while ( have_posts() ) :
		the_post();
		?>
		<article id="post-<?php the_ID(); ?>" <?php post_class( 'primex-page primex-container--wide' ); ?>>
			<?php if ( apply_filters( 'primex_show_page_title', true ) ) : ?>
				<header class="primex-page-header primex-container">
					<?php the_title( '<h1 class="primex-page-title">', '</h1>' ); ?>
				</header>
			<?php endif; ?>

			<div class="primex-page__content primex-container--wide">
				<?php
				the_content();
				wp_link_pages();
				?>
			</div>
		</article>
		<?php
	endwhile;
	?>

</main>

<?php
get_footer();
