<?php
/**
 * Template part: no results found.
 *
 * @package Primex
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<section class="primex-no-results">

	<header class="primex-page-header">
		<h1 class="primex-page-title"><?php esc_html_e( 'Nothing found', 'primex' ); ?></h1>
	</header>

	<div class="primex-page-content">
		<?php
		if ( is_search() ) {
			echo '<p>' . esc_html__( 'Sorry, no results matched your search. Try different keywords.', 'primex' ) . '</p>';
			get_search_form();
		} else {
			echo '<p>' . esc_html__( 'No content available yet. Please check back soon.', 'primex' ) . '</p>';
			get_search_form();
		}
		?>
	</div>

</section>
