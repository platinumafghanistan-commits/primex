<?php
/**
 * Header helpers: sanitizers, theme-mod accessors, logo rendering.
 *
 * @package Primex
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Sanitize header layout slug.
 *
 * @param string $value Raw value.
 * @return string
 */
function primex_sanitize_header_layout( string $value ): string {
	$allowed = array( 'header-logistics', 'header-1', 'header-2' );
	return in_array( $value, $allowed, true ) ? $value : 'header-logistics';
}

/**
 * Sanitize CTA mode.
 *
 * @param string $value Raw value.
 * @return string
 */
function primex_sanitize_cta_mode( string $value ): string {
	return in_array( $value, array( 'link', 'popup' ), true ) ? $value : 'link';
}

/**
 * Sanitize hex color or empty string.
 *
 * @param string $value Raw value.
 * @return string
 */
function primex_sanitize_hex_color_or_empty( string $value ): string {
	$value = sanitize_hex_color( $value );
	return $value ? $value : '';
}

/**
 * Sanitize positive integer within bounds.
 *
 * @param mixed $value   Raw value.
 * @param int   $min     Minimum.
 * @param int   $max     Maximum.
 * @param int   $default Default fallback.
 * @return int
 */
function primex_sanitize_int_range( $value, int $min, int $max, int $default ): int {
	$value = absint( $value );
	if ( $value < $min || $value > $max ) {
		return $default;
	}
	return $value;
}

/**
 * Get a header theme mod with optional default.
 *
 * @param string $key     Setting key without primex_ prefix for header-scoped keys.
 * @param mixed  $default Default value.
 * @return mixed
 */
function primex_get_header_mod( string $key, $default = '' ) {
	return get_theme_mod( 'primex_' . $key, $default );
}

/**
 * Is the theme header enabled?
 *
 * @return bool
 */
function primex_header_enabled(): bool {
	$enabled = (bool) primex_get_header_mod( 'header_enabled', true );
	return (bool) apply_filters( 'primex_header_enabled', $enabled );
}

/**
 * Resolve active header layout slug.
 *
 * @return string
 */
function primex_get_header_layout(): string {
	$layout = (string) get_theme_mod( 'primex_header_layout', 'header-logistics' );
	return primex_sanitize_header_layout( apply_filters( 'primex_header_layout', $layout ) );
}

/**
 * Should sticky header behavior run?
 *
 * @return bool
 */
function primex_get_sticky_header(): bool {
	return (bool) get_theme_mod( 'primex_sticky_header', true );
}

/**
 * Should the top bar render?
 *
 * @return bool
 */
function primex_show_topbar(): bool {
	return (bool) get_theme_mod( 'primex_show_topbar', true );
}

/**
 * Get CTA text with legacy quote-button fallback.
 *
 * @return string
 */
function primex_get_cta_text(): string {
	$text = (string) get_theme_mod( 'primex_cta_text', '' );
	if ( '' === $text ) {
		$text = (string) get_theme_mod( 'primex_quote_button_text', __( 'Get a Quote', 'primex' ) );
	}
	return sanitize_text_field( $text );
}

/**
 * Get CTA URL with legacy quote-button fallback.
 *
 * @return string
 */
function primex_get_cta_url(): string {
	$url = (string) get_theme_mod( 'primex_cta_url', '' );
	if ( '' === $url ) {
		$url = (string) get_theme_mod( 'primex_quote_button_url', '' );
	}
	return esc_url_raw( $url );
}

/**
 * Get contact phone with legacy top-bar fallback.
 *
 * @return string
 */
function primex_get_contact_phone(): string {
	$phone = sanitize_text_field( (string) get_theme_mod( 'primex_contact_phone', '' ) );
	if ( '' === $phone ) {
		$phone = primex_get_contact( 'phone' );
	}
	return $phone;
}

/**
 * Get contact title.
 *
 * @return string
 */
function primex_get_contact_title(): string {
	$title = sanitize_text_field( (string) get_theme_mod( 'primex_contact_title', '' ) );
	if ( '' === $title ) {
		$title = __( 'Have any Questions?', 'primex' );
	}
	return $title;
}

/**
 * Build tel: href from a display phone string.
 *
 * @param string $phone Display phone.
 * @return string
 */
function primex_build_tel_href( string $phone ): string {
	return 'tel:' . preg_replace( '/[^+\d]/', '', $phone );
}

/**
 * Output logo markup for a given context.
 *
 * @param string $context desktop|sticky|dark|mobile.
 */
function primex_the_logo( string $context = 'desktop' ): void {
	$context  = in_array( $context, array( 'desktop', 'sticky', 'dark', 'mobile' ), true ) ? $context : 'desktop';
	$logo_id  = 0;
	$is_stuck = 'sticky' === $context || ( function_exists( 'primex_header_is_stuck_context' ) && primex_header_is_stuck_context() );

	if ( 'sticky' === $context ) {
		$logo_id = absint( get_theme_mod( 'primex_logo_sticky', 0 ) );
	} elseif ( 'dark' === $context ) {
		$logo_id = absint( get_theme_mod( 'primex_logo_dark', 0 ) );
	}

	if ( 0 === $logo_id && has_custom_logo() ) {
		$logo_id = absint( get_theme_mod( 'custom_logo', 0 ) );
	}

	$max_width  = primex_sanitize_int_range( get_theme_mod( 'primex_logo_width', 200 ), 40, 400, 200 );
	$max_height = primex_sanitize_int_range( get_theme_mod( 'primex_logo_height', 48 ), 24, 120, 48 );

	if ( $is_stuck ) {
		$sticky_height = primex_sanitize_int_range( get_theme_mod( 'primex_sticky_logo_height', 0 ), 0, 120, 0 );
		if ( $sticky_height > 0 ) {
			$max_height = $sticky_height;
		}
	}

	$classes = array(
		'primex-logo',
		'primex-logo--' . $context,
	);

	if ( $logo_id ) {
		$alt = get_post_meta( $logo_id, '_wp_attachment_image_alt', true );
		if ( '' === $alt ) {
			$alt = get_bloginfo( 'name', 'display' );
		}

		$size = 'full';
		if ( (bool) get_theme_mod( 'primex_logo_retina', false ) ) {
			$size = 'medium_large';
		}

		printf(
			'<a href="%1$s" class="%2$s" rel="home" aria-label="%3$s">%4$s</a>',
			esc_url( home_url( '/' ) ),
			esc_attr( implode( ' ', $classes ) ),
			esc_attr( get_bloginfo( 'name', 'display' ) ),
			wp_get_attachment_image(
				$logo_id,
				$size,
				false,
				array(
					'alt'           => esc_attr( $alt ),
					'class'         => 'primex-logo__image',
					'fetchpriority' => ( 'sticky' === $context ) ? 'high' : 'auto',
					'style'         => sprintf( 'max-width:%1$dpx;max-height:%2$dpx;width:auto;height:auto;', $max_width, $max_height ),
				)
			)
		);
		return;
	}

	printf(
		'<a href="%1$s" class="%2$s primex-logo--text" rel="home"><strong>%3$s</strong></a>',
		esc_url( home_url( '/' ) ),
		esc_attr( implode( ' ', $classes ) ),
		esc_html( get_bloginfo( 'name', 'display' ) )
	);
}

/**
 * Render header CTA button (legacy wrapper kept for selective refresh).
 */
function primex_render_quote_button(): void {
	get_template_part( 'template-parts/header/parts/cta-button' );
}

/**
 * Get wp_nav_menu args shared by desktop and mobile nav.
 *
 * @param array $args Override args.
 * @return array
 */
function primex_get_nav_menu_args( array $args = array() ): array {
	$defaults = array(
		'theme_location' => 'primary',
		'menu_id'        => 'primex-primary-menu',
		'menu_class'     => 'primex-menu',
		'container'      => false,
		'fallback_cb'    => false,
		'depth'          => 0,
		'walker'         => new Primex_Menu_Walker(),
	);

	return apply_filters( 'primex_nav_menu_args', wp_parse_args( $args, $defaults ) );
}
