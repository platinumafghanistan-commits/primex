<?php
/**
 * Template Name: Elementor Full Width
 * Template Post Type: page
 *
 * Standard Elementor page wrapper: header + footer on, content rendered via
 * the_content() so Elementor's canvas draws the page. Page title is hidden —
 * Elementor pages typically render their own titles.
 *
 * @package Primex
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<main id="primex-content" class="primex-main primex-main--elementor">

	<?php
	while ( have_posts() ) :
		the_post();
		?>
		<article id="post-<?php the_ID(); ?>" <?php post_class( 'primex-elementor-page' ); ?>>
			<div class="primex-elementor-page__content">
				<?php the_content(); ?>
			</div>
		</article>
		<?php
	endwhile;
	?>

</main>

<?php
get_footer();
