<?php
/**
 * Header partial: logo (template wrapper).
 *
 * @package Primex
 *
 * @param array $args {
 *     @type string $context Logo context: desktop, sticky, dark, mobile.
 * }
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$context = isset( $args['context'] ) ? (string) $args['context'] : 'desktop';
primex_the_logo( $context );
