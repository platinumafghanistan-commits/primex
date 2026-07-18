<?php
/**
 * Header partial: contact block.
 *
 * @package Primex
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$enabled = (bool) get_theme_mod( 'primex_contact_enabled', true );
$phone   = primex_get_contact_phone();
$title   = primex_get_contact_title();

if ( ! $enabled || '' === $phone ) {
	return;
}

$icon_raw  = sanitize_text_field( (string) get_theme_mod( 'primex_contact_icon', 'fa-solid fa-phone' ) );
$icon_class = trim( $icon_raw );
if ( '' === $icon_class ) {
	$icon_class = 'fa-solid fa-phone';
} elseif ( false === strpos( $icon_class, 'fa-' ) ) {
	$icon_class = 'fa-solid fa-' . sanitize_html_class( $icon_class );
}

$output = sprintf(
	'<div class="primex-header-contact"><div class="primex-header-contact__inner"><span class="primex-header-contact__icon-wrap" aria-hidden="true"><i class="%1$s primex-header-contact__icon" aria-hidden="true"></i></span><div class="primex-header-contact__content">',
	esc_attr( $icon_class )
);

if ( $title ) {
	$output .= sprintf(
		'<span class="primex-header-contact__title">%s</span>',
		esc_html( $title )
	);
}

$output .= sprintf(
	'<a class="primex-header-contact__phone" href="%1$s"><span class="primex-header-contact__number">%2$s</span></a></div></div></div>',
	esc_url( primex_build_tel_href( $phone ) ),
	esc_html( $phone )
);

echo apply_filters( 'primex_header_contact_output', $output ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped above.
