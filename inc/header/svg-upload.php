<?php
/**
 * Safe SVG upload support for logos (admin-only).
 *
 * @package Primex
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Allow SVG mime type for users who can upload files.
 *
 * @param array $mimes Allowed mime types.
 * @return array
 */
function primex_allow_svg_upload( array $mimes ): array {
	if ( current_user_can( 'upload_files' ) ) {
		$mimes['svg']  = 'image/svg+xml';
		$mimes['svgz'] = 'image/svg+xml';
	}
	return $mimes;
}
add_filter( 'upload_mimes', 'primex_allow_svg_upload' );

/**
 * Strip dangerous SVG content on upload.
 *
 * @param array $file Uploaded file data.
 * @return array
 */
function primex_sanitize_svg_upload( array $file ): array {
	if ( empty( $file['type'] ) || 'image/svg+xml' !== $file['type'] ) {
		return $file;
	}

	if ( ! current_user_can( 'upload_files' ) ) {
		$file['error'] = __( 'You are not allowed to upload SVG files.', 'primex' );
		return $file;
	}

	$contents = file_get_contents( $file['tmp_name'] ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents
	if ( false === $contents ) {
		$file['error'] = __( 'Unable to read SVG file.', 'primex' );
		return $file;
	}

	$blocked = array( '<script', 'javascript:', 'onload=', 'onclick=', '<foreignObject', 'data:text/html' );
	foreach ( $blocked as $needle ) {
		if ( false !== stripos( $contents, $needle ) ) {
			$file['error'] = __( 'This SVG file contains blocked content and cannot be uploaded.', 'primex' );
			return $file;
		}
	}

	return $file;
}
add_filter( 'wp_handle_upload_prefilter', 'primex_sanitize_svg_upload' );
