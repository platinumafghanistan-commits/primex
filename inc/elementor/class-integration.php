<?php
/**
 * Elementor integration: Theme Builder locations and kit alignment.
 *
 * @package Primex
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register Elementor Theme Builder locations.
 *
 * @param ElementorPro\Modules\ThemeBuilder\Classes\Locations_Manager $elementor_locations Locations manager.
 */
function primex_elementor_register_locations( $elementor_locations ): void {
	if ( ! method_exists( $elementor_locations, 'register_location' ) ) {
		return;
	}

	$elementor_locations->register_location(
		'header',
		array(
			'label'           => __( 'Header', 'primex' ),
			'multiple'        => false,
			'edit_in_content' => false,
		)
	);

	$elementor_locations->register_location(
		'footer',
		array(
			'label'           => __( 'Footer', 'primex' ),
			'multiple'        => false,
			'edit_in_content' => false,
		)
	);
}
add_action( 'elementor/theme/register_locations', 'primex_elementor_register_locations' );

/**
 * Declare Elementor support flags.
 */
function primex_elementor_theme_support(): void {
	if ( ! did_action( 'elementor/loaded' ) ) {
		return;
	}

	add_theme_support( 'elementor' );

	if ( class_exists( '\ElementorPro\Plugin' ) ) {
		add_theme_support( 'elementor-pro' );
	}
}
add_action( 'after_setup_theme', 'primex_elementor_theme_support', 20 );

/**
 * Map Elementor kit globals to Primex CSS variables when Elementor is active.
 */
function primex_elementor_kit_css_vars(): void {
	if ( ! did_action( 'elementor/loaded' ) || ! class_exists( '\Elementor\Plugin' ) ) {
		return;
	}

	$kit = \Elementor\Plugin::$instance->kits_manager->get_active_kit();
	if ( ! $kit ) {
		return;
	}

	$settings = $kit->get_settings_for_display();
	$vars     = array();

	if ( ! empty( $settings['system_colors'] ) && is_array( $settings['system_colors'] ) ) {
		foreach ( $settings['system_colors'] as $color ) {
			if ( empty( $color['_id'] ) || empty( $color['color'] ) ) {
				continue;
			}
			if ( 'primary' === $color['_id'] ) {
				$vars['--primex-color-primary'] = sanitize_hex_color( $color['color'] );
			}
			if ( 'secondary' === $color['_id'] ) {
				$vars['--primex-color-secondary'] = sanitize_hex_color( $color['color'] );
			}
		}
	}

	if ( empty( $vars ) ) {
		return;
	}

	$rules = array();
	foreach ( $vars as $property => $value ) {
		if ( $value ) {
			$rules[] = $property . ':' . $value;
		}
	}

	if ( $rules ) {
		wp_add_inline_style( 'primex-base', ':root{' . implode( ';', $rules ) . ';}' );
	}
}
add_action( 'wp_enqueue_scripts', 'primex_elementor_kit_css_vars', 30 );

/**
 * Register dynamic tags when Elementor Pro is available.
 */
function primex_elementor_register_dynamic_tags( $dynamic_tags ): void {
	if ( ! class_exists( '\ElementorPro\Modules\DynamicTags\Module' ) ) {
		return;
	}

	require_once PRIMEX_DIR . '/inc/elementor/class-dynamic-tags.php';
	$dynamic_tags->register_group(
		'primex',
		array(
			'title' => __( 'Primex', 'primex' ),
		)
	);

	$dynamic_tags->register( new Primex_Elementor_Tag_Contact_Phone() );
	$dynamic_tags->register( new Primex_Elementor_Tag_Contact_Title() );
	$dynamic_tags->register( new Primex_Elementor_Tag_Cta_Text() );
}
add_action( 'elementor/dynamic_tags/register', 'primex_elementor_register_dynamic_tags' );
