<?php
/**
 * Header facade: CSS variables, body classes, asset conditions.
 *
 * @package Primex
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Primex header subsystem.
 */
final class Primex_Header {

	/**
	 * Boot hooks.
	 */
	public static function init(): void {
		add_filter( 'body_class', array( self::class, 'body_class' ) );
		add_action( 'wp_enqueue_scripts', array( self::class, 'inline_css_vars' ), 25 );
	}

	/**
	 * Build CSS custom properties from Customizer values.
	 *
	 * @return array<string, string>
	 */
	public static function get_css_vars(): array {
		$vars = array(
			'--primex-container'              => primex_sanitize_int_range( get_theme_mod( 'primex_container_width', 1280 ), 960, 1600, 1280 ) . 'px',
			'--primex-header-height'          => primex_sanitize_int_range( get_theme_mod( 'primex_header_height', 88 ), 56, 140, 88 ) . 'px',
			'--primex-header-sticky-height'   => primex_sanitize_int_range( get_theme_mod( 'primex_sticky_height', 72 ), 48, 120, 72 ) . 'px',
			'--primex-header-bg'              => self::color_mod( 'primex_header_bg', '#FFFFFF' ),
			'--primex-header-text'            => self::color_mod( 'primex_header_text_color', '#1A1A1A' ),
			'--primex-header-border-color'    => self::color_mod( 'primex_header_border_color', 'rgba(26,26,26,0.06)' ),
			'--primex-header-border-width'    => primex_sanitize_int_range( get_theme_mod( 'primex_header_border_width', 1 ), 0, 6, 1 ) . 'px',
			'--primex-header-shadow'          => self::shadow_mod( 'primex_header_shadow', 'var(--primex-shadow)' ),
			'--primex-header-blur'            => primex_sanitize_int_range( get_theme_mod( 'primex_header_blur', 0 ), 0, 24, 0 ) . 'px',
			'--primex-header-padding-y'       => primex_sanitize_int_range( get_theme_mod( 'primex_header_padding_y', 0 ), 0, 48, 0 ) . 'px',
			'--primex-header-padding-x'       => primex_sanitize_int_range( get_theme_mod( 'primex_header_padding_x', 0 ), 0, 48, 0 ) . 'px',
			'--primex-header-margin-bottom'   => primex_sanitize_int_range( get_theme_mod( 'primex_header_margin_bottom', 0 ), 0, 48, 0 ) . 'px',
			'--primex-nav-item-padding-x'     => primex_sanitize_int_range( get_theme_mod( 'primex_nav_item_padding_x', 12 ), 0, 32, 12 ) . 'px',
			'--primex-nav-item-padding-y'     => primex_sanitize_int_range( get_theme_mod( 'primex_nav_item_padding_y', 8 ), 0, 32, 8 ) . 'px',
			'--primex-nav-active-color'       => self::color_mod( 'primex_nav_active_color', '#0B5FFF' ),
			'--primex-nav-dropdown-bg'        => self::color_mod( 'primex_nav_dropdown_bg', '#FFFFFF' ),
			'--primex-nav-dropdown-text'      => self::color_mod( 'primex_nav_dropdown_text', '#1A1A1A' ),
			'--primex-nav-dropdown-duration'  => primex_sanitize_int_range( get_theme_mod( 'primex_nav_dropdown_duration', 200 ), 0, 800, 200 ) . 'ms',
			'--primex-contact-title-color'    => self::color_mod( 'primex_contact_title_color', '#6B7280' ),
			'--primex-contact-phone-color'    => self::color_mod( 'primex_contact_phone_color', '#1A1A1A' ),
			'--primex-contact-icon-color'     => self::color_mod( 'primex_contact_icon_color', '#0B5FFF' ),
			'--primex-cta-bg'                 => self::color_mod( 'primex_cta_bg', '#0B5FFF' ),
			'--primex-cta-bg-hover'           => self::color_mod( 'primex_cta_bg_hover', '#1A1A1A' ),
			'--primex-cta-text'               => self::color_mod( 'primex_cta_text_color', '#FFFFFF' ),
			'--primex-cta-radius'             => primex_sanitize_int_range( get_theme_mod( 'primex_cta_radius', 8 ), 0, 48, 8 ) . 'px',
			'--primex-cta-padding-y'          => primex_sanitize_int_range( get_theme_mod( 'primex_cta_padding_y', 12 ), 4, 32, 12 ) . 'px',
			'--primex-cta-padding-x'          => primex_sanitize_int_range( get_theme_mod( 'primex_cta_padding_x', 24 ), 8, 48, 24 ) . 'px',
			'--primex-cta-min-width'          => primex_sanitize_int_range( get_theme_mod( 'primex_cta_min_width', 0 ), 0, 320, 0 ) . 'px',
			'--primex-cta-min-height'         => primex_sanitize_int_range( get_theme_mod( 'primex_cta_min_height', 44 ), 32, 72, 44 ) . 'px',
			'--primex-sticky-transition'      => primex_sanitize_int_range( get_theme_mod( 'primex_sticky_transition_ms', 300 ), 100, 800, 300 ) . 'ms',
			'--primex-sticky-offset'          => primex_sanitize_int_range( get_theme_mod( 'primex_sticky_offset', 20 ), 0, 300, 20 ) . 'px',
			'--primex-sticky-bg'              => self::color_mod( 'primex_sticky_bg', '#FFFFFF' ),
			'--primex-sticky-shadow'          => self::shadow_mod( 'primex_sticky_shadow', 'var(--primex-shadow)' ),
			'--primex-mobile-breakpoint'      => primex_sanitize_int_range( get_theme_mod( 'primex_mobile_breakpoint', 1024 ), 768, 1280, 1024 ) . 'px',
			'--primex-mobile-panel-width'     => primex_sanitize_int_range( get_theme_mod( 'primex_mobile_panel_width', 360 ), 280, 480, 360 ) . 'px',
			'--primex-mobile-overlay'         => self::color_mod( 'primex_mobile_overlay_color', 'rgba(0,0,0,0.5)' ),
			'--primex-mobile-animation'       => primex_sanitize_int_range( get_theme_mod( 'primex_mobile_animation_ms', 250 ), 100, 800, 250 ) . 'ms',
		);

		return apply_filters( 'primex_header_css_vars', $vars );
	}

	/**
	 * Output inline CSS variables on the header stylesheet.
	 */
	public static function inline_css_vars(): void {
		if ( ! primex_header_enabled() ) {
			return;
		}

		$vars   = self::get_css_vars();
		$rules  = array();
		foreach ( $vars as $property => $value ) {
			$rules[] = $property . ':' . $value;
		}

		$css  = ':root{' . implode( ';', $rules ) . ';}';
		$css .= '@media (max-width:' . esc_attr( $vars['--primex-mobile-breakpoint'] ?? '1024px' ) . '){.primex-header__nav,.primex-header__contact{display:none;}.primex-header__cta--desktop{display:none;}.primex-header__burger{display:flex;}}';

		wp_add_inline_style( 'primex-header', $css );
	}

	/**
	 * Append header state classes to body.
	 *
	 * @param array $classes Body classes.
	 * @return array
	 */
	public static function body_class( array $classes ): array {
		if ( ! primex_header_enabled() ) {
			$classes[] = 'primex-header-disabled';
			return $classes;
		}

		$classes[] = 'primex-header-layout-' . sanitize_html_class( primex_get_header_layout() );

		if ( primex_get_sticky_header() ) {
			$classes[] = 'primex-sticky-enabled';
		}
		if ( (bool) get_theme_mod( 'primex_sticky_hide_down', false ) ) {
			$classes[] = 'primex-sticky-hide-down';
		}
		if ( (bool) get_theme_mod( 'primex_sticky_reveal_up', true ) ) {
			$classes[] = 'primex-sticky-reveal-up';
		}
		if ( (bool) get_theme_mod( 'primex_sticky_shrink', true ) ) {
			$classes[] = 'primex-sticky-shrink';
		}

		return $classes;
	}

	/**
	 * Resolve color theme mod with fallback.
	 *
	 * @param string $key     Mod key.
	 * @param string $default Default color.
	 * @return string
	 */
	private static function color_mod( string $key, string $default ): string {
		$value = get_theme_mod( $key, '' );
		if ( is_string( $value ) && '' !== $value ) {
			$sanitized = sanitize_hex_color( $value );
			if ( $sanitized ) {
				return $sanitized;
			}
			if ( preg_match( '/^rgba?\(/', $value ) ) {
				return $value;
			}
		}
		return $default;
	}

	/**
	 * Resolve shadow preset.
	 *
	 * @param string $key     Mod key.
	 * @param string $default Default shadow.
	 * @return string
	 */
	private static function shadow_mod( string $key, string $default ): string {
		$value = (string) get_theme_mod( $key, 'default' );
		$map   = array(
			'none'    => 'none',
			'sm'      => 'var(--primex-shadow-sm)',
			'default' => 'var(--primex-shadow)',
			'lg'      => 'var(--primex-shadow-lg)',
		);
		return $map[ $value ] ?? $default;
	}

	/**
	 * Localize header behavior config for JS.
	 *
	 * @return array<string, mixed>
	 */
	public static function get_js_config(): array {
		return array(
			'sticky'         => primex_get_sticky_header(),
			'hideDown'       => (bool) get_theme_mod( 'primex_sticky_hide_down', false ),
			'revealUp'       => (bool) get_theme_mod( 'primex_sticky_reveal_up', true ),
			'shrink'         => (bool) get_theme_mod( 'primex_sticky_shrink', true ),
			'offset'         => primex_sanitize_int_range( get_theme_mod( 'primex_sticky_offset', 20 ), 0, 300, 20 ),
			'transition'     => primex_sanitize_int_range( get_theme_mod( 'primex_sticky_transition_ms', 300 ), 100, 800, 300 ),
			'mobileEnabled'  => (bool) get_theme_mod( 'primex_mobile_enabled', true ),
			'showMobileCta'  => (bool) get_theme_mod( 'primex_mobile_show_cta', true ),
			'showMobileContact' => (bool) get_theme_mod( 'primex_mobile_show_contact', true ),
		);
	}
}

Primex_Header::init();
