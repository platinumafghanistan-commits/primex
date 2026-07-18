<?php
/**
 * Custom search form markup. Used by get_search_form() and the header search panel.
 *
 * @package Primex
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<form role="search" method="get" class="primex-search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label for="primex-search-input" class="screen-reader-text"><?php esc_html_e( 'Search for:', 'primex' ); ?></label>
	<input type="search" id="primex-search-input" class="primex-search-form__input" placeholder="<?php esc_attr_e( 'Search…', 'primex' ); ?>" value="<?php echo get_search_query(); ?>" name="s">
	<button type="submit" class="primex-button primex-search-form__submit"><?php esc_html_e( 'Search', 'primex' ); ?></button>
</form>
