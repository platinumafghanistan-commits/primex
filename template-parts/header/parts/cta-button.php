<?php
/**
 * Header partial: CTA button.
 *
 * @package Primex
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$enabled = (bool) get_theme_mod( 'primex_cta_enabled', true );
if ( ! $enabled ) {
	return;
}

$text   = primex_get_cta_text();
$mode   = primex_sanitize_cta_mode( (string) get_theme_mod( 'primex_cta_mode', 'link' ) );
$url    = primex_get_cta_url();
$popup  = absint( get_theme_mod( 'primex_cta_popup_id', 0 ) );
$target = primex_sanitize_link_target( (string) get_theme_mod( 'primex_cta_target', '' ) );

if ( 'link' === $mode && '' === $url ) {
	return;
}
if ( 'popup' === $mode && 0 === $popup ) {
	return;
}

$attrs = array(
	'class' => 'primex-header-cta primex-button',
);

if ( 'link' === $mode ) {
	$attrs['href'] = $url;
	if ( $target ) {
		$attrs['target'] = $target;
		$attrs['rel']    = 'noopener noreferrer';
	}
} else {
	$attrs['href']                      = '#';
	$attrs['data-elementor-open-popup'] = (string) $popup;
	$attrs['role']                      = 'button';
}

$attrs = apply_filters( 'primex_header_cta_attrs', $attrs, $mode );

$attr_string = '';
foreach ( $attrs as $key => $val ) {
	$attr_string .= sprintf( ' %1$s="%2$s"', esc_attr( $key ), esc_attr( (string) $val ) );
}

printf(
	'<a%1$s>%2$s</a>',
	$attr_string,
	esc_html( $text )
);
