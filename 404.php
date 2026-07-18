<?php
/**
 * 404 template.
 *
 * @package Primex
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<main id="primex-content" class="primex-main primex-main--404">
	<div class="primex-container primex-404">
		<p class="primex-404__code">404</p>
		<h1 class="primex-404__title"><?php esc_html_e( 'Page not found', 'primex' ); ?></h1>
		<p class="primex-404__text"><?php esc_html_e( 'The page you were looking for has been moved or never existed. Try a search, or head back home.', 'primex' ); ?></p>

		<div class="primex-404__actions">
			<a class="primex-button" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Back to home', 'primex' ); ?></a>
		</div>

		<div class="primex-404__search">
			<?php get_search_form(); ?>
		</div>
	</div>
</main>

<?php
get_footer();
