<?php
/**
 * Header partial: primary navigation.
 *
 * @package Primex
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<nav class="primex-header__navigation" aria-label="<?php esc_attr_e( 'Primary', 'primex' ); ?>">
	<?php
	wp_nav_menu(
		primex_get_nav_menu_args(
			array(
				'theme_location' => 'primary',
				'menu_id'        => 'primex-primary-menu',
				'menu_class'     => 'primex-menu',
				'depth'          => 0,
			)
		)
	);
	?>
</nav>
