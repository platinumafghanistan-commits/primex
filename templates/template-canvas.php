<?php
/**
 * Template Name: Elementor Canvas
 * Template Post Type: page,post,primex_service,primex_fleet,primex_team,primex_testimonial
 *
 * Blank canvas with no header/footer. Used for Elementor popup-style pages,
 * landing sections, and any layout that needs full control over the viewport.
 *
 * @package Primex
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class( 'primex-canvas' ); ?>>
<?php wp_body_open(); ?>

	<?php
	while ( have_posts() ) :
		the_post();
		the_content();
	endwhile;
	?>

<?php wp_footer(); ?>
</body>
</html>
