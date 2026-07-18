<?php
/**
 * Customizer: global theme options.
 *
 * Header settings live in inc/customizer/header.php.
 * Footer + social settings remain here.
 *
 * @package Primex
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once PRIMEX_DIR . '/inc/customizer/header.php';

/**
 * Register footer and social customizer sections.
 *
 * @param WP_Customize_Manager $wp_customize Customizer manager.
 */
function primex_customize_register( WP_Customize_Manager $wp_customize ): void {

	$wp_customize->add_section(
		'primex_footer',
		array(
			'title'    => __( 'Footer (Primex)', 'primex' ),
			'priority' => 31,
		)
	);

	$wp_customize->add_setting(
		'primex_footer_layout',
		array(
			'default'           => 'footer-1',
			'sanitize_callback' => 'primex_sanitize_footer_layout',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		'primex_footer_layout',
		array(
			'label'   => __( 'Footer Layout', 'primex' ),
			'section' => 'primex_footer',
			'type'    => 'select',
			'choices' => array(
				'footer-1' => __( 'Four columns + bottom bar', 'primex' ),
			),
		)
	);

	$wp_customize->add_setting(
		'primex_footer_about_text',
		array(
			'default'           => __( 'Premium logistics and supply-chain solutions, moving your cargo across air, ocean, and road with reliability.', 'primex' ),
			'sanitize_callback' => 'wp_kses_post',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		'primex_footer_about_text',
		array(
			'label'   => __( 'Footer About Text', 'primex' ),
			'section' => 'primex_footer',
			'type'    => 'textarea',
		)
	);

	$wp_customize->add_setting(
		'primex_footer_copyright',
		array(
			'default'           => '',
			'sanitize_callback' => 'wp_kses_post',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		'primex_footer_copyright',
		array(
			'label'       => __( 'Copyright Text', 'primex' ),
			'description' => __( 'Leave empty for the default: © Year Site Name. All rights reserved.', 'primex' ),
			'section'     => 'primex_footer',
			'type'        => 'text',
		)
	);

	$wp_customize->add_section(
		'primex_social',
		array(
			'title'    => __( 'Social Links (Primex)', 'primex' ),
			'priority' => 32,
		)
	);

	$social_networks = array(
		'facebook'  => __( 'Facebook', 'primex' ),
		'twitter'   => __( 'Twitter / X', 'primex' ),
		'linkedin'  => __( 'LinkedIn', 'primex' ),
		'instagram' => __( 'Instagram', 'primex' ),
		'youtube'   => __( 'YouTube', 'primex' ),
	);

	foreach ( $social_networks as $slug => $label ) {
		$wp_customize->add_setting(
			'primex_social_' . $slug,
			array(
				'default'           => '',
				'sanitize_callback' => 'esc_url_raw',
				'transport'         => 'refresh',
			)
		);
		$wp_customize->add_control(
			'primex_social_' . $slug,
			array(
				'label'   => $label,
				'section' => 'primex_social',
				'type'    => 'url',
			)
		);
	}
}
add_action( 'customize_register', 'primex_customize_register' );

/**
 * Sanitize the footer layout choice.
 *
 * @param string $value Raw value.
 * @return string
 */
function primex_sanitize_footer_layout( string $value ): string {
	$allowed = array( 'footer-1' );
	return in_array( $value, $allowed, true ) ? $value : 'footer-1';
}

/**
 * Helper: which footer layout is selected?
 *
 * @return string
 */
function primex_get_footer_layout(): string {
	return primex_sanitize_footer_layout( (string) get_theme_mod( 'primex_footer_layout', 'footer-1' ) );
}

/**
 * Helper: get a top-bar contact field, cleaned for output.
 *
 * @param string $key Option key (without primex_ prefix).
 * @return string
 */
function primex_get_contact( string $key ): string {
	return sanitize_text_field( (string) get_theme_mod( 'primex_topbar_' . $key, '' ) );
}

/**
 * Render social icon links. Used by top bar + footer.
 *
 * @param array $args {
 *     Optional. Wrapper attributes.
 *     @type string $class Wrapper class.
 *     @type string $link_class Anchor class.
 * }
 */
function primex_render_social_links( array $args = array() ): void {
	$args = wp_parse_args(
		$args,
		array(
			'class'      => 'primex-social',
			'link_class' => 'primex-social__link',
		)
	);

	$networks = array(
		'facebook'  => array(
			'label' => __( 'Facebook', 'primex' ),
			'icon'  => '<svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true" focusable="false"><path d="M22 12c0-5.52-4.48-10-10-10S2 6.48 2 12c0 4.84 3.44 8.87 8 9.8V15H8v-3h2V9.5C10 7.57 11.57 6 13.5 6H16v3h-2c-.55 0-1 .45-1 1v2h3v3h-3v6.95c5.05-.5 9-4.76 9-9.95z"/></svg>',
		),
		'twitter'   => array(
			'label' => __( 'Twitter', 'primex' ),
			'icon'  => '<svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true" focusable="false"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>',
		),
		'linkedin'  => array(
			'label' => __( 'LinkedIn', 'primex' ),
			'icon'  => '<svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true" focusable="false"><path d="M19 3a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2zM8.34 17V10.6H6.17V17zm-1.09-7.21a1.26 1.26 0 1 0 0-2.52 1.26 1.26 0 0 0 0 2.52zM18 17v-3.78c0-2.02-1.08-2.96-2.52-2.96a2.17 2.17 0 0 0-1.97 1.08V10.6H11.4V17h2.11v-3.62c0-.34.02-.68.12-.92.27-.68.89-1.38 1.93-1.38 1.36 0 1.9 1.04 1.9 2.56V17z"/></svg>',
		),
		'instagram' => array(
			'label' => __( 'Instagram', 'primex' ),
			'icon'  => '<svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true" focusable="false"><path d="M12 2.16c3.2 0 3.58.01 4.85.07 1.17.05 1.8.25 2.23.41.56.22.96.48 1.38.9.42.42.68.82.9 1.38.16.42.36 1.06.41 2.23.06 1.27.07 1.65.07 4.85s-.01 3.58-.07 4.85c-.05 1.17-.25 1.8-.41 2.23-.22.56-.48.96-.9 1.38-.42.42-.82.68-1.38.9-.42.16-1.06.36-2.23.41-1.27.06-1.65.07-4.85.07s-3.58-.01-4.85-.07c-1.17-.05-1.8-.25-2.23-.41a3.7 3.7 0 0 1-1.38-.9 3.7 3.7 0 0 1-.9-1.38c-.16-.42-.36-1.06-.41-2.23C2.17 15.58 2.16 15.2 2.16 12s.01-3.58.07-4.85c.05-1.17.25-1.8.41-2.23.22-.56.48-.96.9-1.38.42-.42.82-.68 1.38-.9.42-.16 1.06-.36 2.23-.41C8.42 2.17 8.8 2.16 12 2.16zm0 1.8c-3.15 0-3.52.01-4.76.07-1.15.05-1.77.24-2.19.4-.55.22-.94.47-1.35.88-.41.41-.66.8-.88 1.35-.16.42-.35 1.04-.4 2.19-.06 1.24-.07 1.61-.07 4.76s.01 3.52.07 4.76c.05 1.15.24 1.77.4 2.19.22.55.47.94.88 1.35.41.41.8.66 1.35.88.42.16 1.04.35 2.19.4 1.24.06 1.61.07 4.76.07s3.52-.01 4.76-.07c1.15-.05 1.77-.24 2.19-.4.55-.22.94-.47 1.35-.88.41-.41.66-.8.88-1.35.16-.42.35-1.04.4-2.19.06-1.24.07-1.61.07-4.76s-.01-3.52-.07-4.76c-.05-1.15-.24-1.77-.4-2.19a3.6 3.6 0 0 0-.88-1.35 3.6 3.6 0 0 0-1.35-.88c-.42-.16-1.04-.35-2.19-.4-1.24-.06-1.61-.07-4.76-.07zm0 3.06a4.98 4.98 0 1 1 0 9.96 4.98 4.98 0 0 1 0-9.96zm0 8.21a3.23 3.23 0 1 0 0-6.46 3.23 3.23 0 0 0 0 6.46zm6.34-8.41a1.16 1.16 0 1 1-2.32 0 1.16 1.16 0 0 1 2.32 0z"/></svg>',
		),
		'youtube'   => array(
			'label' => __( 'YouTube', 'primex' ),
			'icon'  => '<svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true" focusable="false"><path d="M23.5 6.5a3.02 3.02 0 0 0-2.12-2.12C19.5 3.86 12 3.86 12 3.86s-7.5 0-9.38.52A3.02 3.02 0 0 0 .5 6.5C0 8.38 0 12 0 12s0 3.62.5 5.5a3.02 3.02 0 0 0 2.12 2.12c1.88.52 9.38.52 9.38.52s7.5 0 9.38-.52a3.02 3.02 0 0 0 2.12-2.12C24 15.62 24 12 24 12s0-3.62-.5-5.5zM9.6 15.6V8.4l6.2 3.6z"/></svg>',
		),
	);

	echo '<ul class="' . esc_attr( $args['class'] ) . '">';

	foreach ( $networks as $slug => $data ) {
		$url = get_theme_mod( 'primex_social_' . $slug, '' );
		if ( '' === $url ) {
			continue;
		}

		printf(
			'<li><a class="%1$s" href="%2$s" target="_blank" rel="noopener noreferrer" aria-label="%3$s">%4$s</a></li>',
			esc_attr( $args['link_class'] ),
			esc_url( $url ),
			esc_attr( $data['label'] ),
			$data['icon'] // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- inline SVG, hardcoded.
		);
	}

	echo '</ul>';
}
