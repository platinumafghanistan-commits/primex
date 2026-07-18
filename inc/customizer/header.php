<?php
/**
 * Customizer: complete header panel.
 *
 * @package Primex
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register header customizer panel, sections, settings, and controls.
 *
 * @param WP_Customize_Manager $wp_customize Customizer manager.
 */
function primex_customize_register_header( WP_Customize_Manager $wp_customize ): void {

	$wp_customize->add_panel(
		'primex_header_panel',
		array(
			'title'       => __( 'Header (Primex)', 'primex' ),
			'description' => __( 'Configure the site header layout, logo, navigation, contact block, CTA, sticky behavior, and mobile menu.', 'primex' ),
			'priority'    => 30,
		)
	);

	$sections = array(
		'primex_header_general'     => __( 'General', 'primex' ),
		'primex_header_logo'        => __( 'Logo', 'primex' ),
		'primex_header_navigation'  => __( 'Navigation', 'primex' ),
		'primex_header_contact'     => __( 'Contact', 'primex' ),
		'primex_header_cta'         => __( 'CTA Button', 'primex' ),
		'primex_header_sticky'      => __( 'Sticky Header', 'primex' ),
		'primex_header_mobile'      => __( 'Mobile', 'primex' ),
		'primex_header_layouts'     => __( 'Layout & Top Bar', 'primex' ),
	);

	foreach ( $sections as $id => $title ) {
		$wp_customize->add_section(
			$id,
			array(
				'title'    => $title,
				'panel'    => 'primex_header_panel',
				'priority' => 10,
			)
		);
	}

	// ----- General ------------------------------------------------------------
	primex_customizer_add_setting(
		$wp_customize,
		'primex_header_enabled',
		array(
			'default'           => true,
			'sanitize_callback' => 'rest_sanitize_boolean',
		),
		array(
			'label'   => __( 'Enable theme header', 'primex' ),
			'section' => 'primex_header_general',
			'type'    => 'checkbox',
		)
	);

	primex_customizer_add_setting(
		$wp_customize,
		'primex_container_width',
		array(
			'default'           => 1280,
			'sanitize_callback' => static function ( $value ) {
				return primex_sanitize_int_range( $value, 960, 1600, 1280 );
			},
		),
		array(
			'label'       => __( 'Container max width (px)', 'primex' ),
			'section'     => 'primex_header_general',
			'type'        => 'number',
			'input_attrs' => array( 'min' => 960, 'max' => 1600, 'step' => 10 ),
		)
	);

	primex_customizer_add_setting(
		$wp_customize,
		'primex_header_height',
		array(
			'default'           => 88,
			'sanitize_callback' => static function ( $value ) {
				return primex_sanitize_int_range( $value, 56, 140, 88 );
			},
		),
		array(
			'label'       => __( 'Header height (px)', 'primex' ),
			'section'     => 'primex_header_general',
			'type'        => 'number',
			'input_attrs' => array( 'min' => 56, 'max' => 140, 'step' => 1 ),
		)
	);

	primex_customizer_add_setting(
		$wp_customize,
		'primex_header_bg',
		array(
			'default'           => '#FFFFFF',
			'sanitize_callback' => 'sanitize_hex_color',
		),
		array(
			'label'   => __( 'Background color', 'primex' ),
			'section' => 'primex_header_general',
			'type'    => 'color',
		)
	);

	primex_customizer_add_setting(
		$wp_customize,
		'primex_header_text_color',
		array(
			'default'           => '#1A1A1A',
			'sanitize_callback' => 'sanitize_hex_color',
		),
		array(
			'label'   => __( 'Text color', 'primex' ),
			'section' => 'primex_header_general',
			'type'    => 'color',
		)
	);

	primex_customizer_add_setting(
		$wp_customize,
		'primex_header_border_width',
		array(
			'default'           => 1,
			'sanitize_callback' => static function ( $value ) {
				return primex_sanitize_int_range( $value, 0, 6, 1 );
			},
		),
		array(
			'label'       => __( 'Border width (px)', 'primex' ),
			'section'     => 'primex_header_general',
			'type'        => 'number',
			'input_attrs' => array( 'min' => 0, 'max' => 6 ),
		)
	);

	primex_customizer_add_setting(
		$wp_customize,
		'primex_header_border_color',
		array(
			'default'           => '#1A1A1A',
			'sanitize_callback' => 'sanitize_hex_color',
		),
		array(
			'label'   => __( 'Border color', 'primex' ),
			'section' => 'primex_header_general',
			'type'    => 'color',
		)
	);

	primex_customizer_add_setting(
		$wp_customize,
		'primex_header_shadow',
		array(
			'default'           => 'default',
			'sanitize_callback' => 'primex_sanitize_shadow_preset',
		),
		array(
			'label'   => __( 'Shadow', 'primex' ),
			'section' => 'primex_header_general',
			'type'    => 'select',
			'choices' => primex_get_shadow_choices(),
		)
	);

	primex_customizer_add_setting(
		$wp_customize,
		'primex_header_blur',
		array(
			'default'           => 0,
			'sanitize_callback' => static function ( $value ) {
				return primex_sanitize_int_range( $value, 0, 24, 0 );
			},
		),
		array(
			'label'       => __( 'Background blur (px)', 'primex' ),
			'section'     => 'primex_header_general',
			'type'        => 'number',
			'input_attrs' => array( 'min' => 0, 'max' => 24 ),
		)
	);

	foreach ( array(
		'primex_header_padding_y'      => __( 'Padding top/bottom (px)', 'primex' ),
		'primex_header_padding_x'      => __( 'Padding left/right (px)', 'primex' ),
		'primex_header_margin_bottom'  => __( 'Margin bottom (px)', 'primex' ),
	) as $key => $label ) {
		primex_customizer_add_setting(
			$wp_customize,
			$key,
			array(
				'default'           => 0,
				'sanitize_callback' => static function ( $value ) {
					return primex_sanitize_int_range( $value, 0, 48, 0 );
				},
			),
			array(
				'label'       => $label,
				'section'     => 'primex_header_general',
				'type'        => 'number',
				'input_attrs' => array( 'min' => 0, 'max' => 48 ),
			)
		);
	}

	// ----- Logo ---------------------------------------------------------------
	primex_customizer_add_setting(
		$wp_customize,
		'primex_logo_sticky',
		array(
			'default'           => 0,
			'sanitize_callback' => 'absint',
		),
		array(
			'label'       => __( 'Sticky logo', 'primex' ),
			'section'     => 'primex_header_logo',
			'type'        => 'media',
			'description' => __( 'Optional logo shown when the header is sticky/shrunk.', 'primex' ),
		)
	);

	primex_customizer_add_setting(
		$wp_customize,
		'primex_logo_dark',
		array(
			'default'           => 0,
			'sanitize_callback' => 'absint',
		),
		array(
			'label'       => __( 'Dark mode logo', 'primex' ),
			'section'     => 'primex_header_logo',
			'type'        => 'media',
			'description' => __( 'Optional logo for dark backgrounds or dark mode.', 'primex' ),
		)
	);

	foreach ( array(
		'primex_logo_width'  => array( 200, 40, 400, __( 'Logo max width (px)', 'primex' ) ),
		'primex_logo_height' => array( 48, 24, 120, __( 'Logo max height (px)', 'primex' ) ),
	) as $key => $meta ) {
		list( $default, $min, $max, $label ) = $meta;
		primex_customizer_add_setting(
			$wp_customize,
			$key,
			array(
				'default'           => $default,
				'sanitize_callback' => static function ( $value ) use ( $min, $max, $default ) {
					return primex_sanitize_int_range( $value, $min, $max, $default );
				},
			),
			array(
				'label'       => $label,
				'section'     => 'primex_header_logo',
				'type'        => 'number',
				'input_attrs' => array( 'min' => $min, 'max' => $max ),
			)
		);
	}

	primex_customizer_add_setting(
		$wp_customize,
		'primex_logo_retina',
		array(
			'default'           => false,
			'sanitize_callback' => 'rest_sanitize_boolean',
		),
		array(
			'label'   => __( 'Optimize logo for retina displays', 'primex' ),
			'section' => 'primex_header_logo',
			'type'    => 'checkbox',
		)
	);

	// ----- Navigation ---------------------------------------------------------
	primex_customizer_add_setting(
		$wp_customize,
		'primex_nav_item_padding_x',
		array(
			'default'           => 12,
			'sanitize_callback' => static function ( $value ) {
				return primex_sanitize_int_range( $value, 0, 32, 12 );
			},
		),
		array(
			'label'   => __( 'Menu item horizontal padding (px)', 'primex' ),
			'section' => 'primex_header_navigation',
			'type'    => 'number',
		)
	);

	primex_customizer_add_setting(
		$wp_customize,
		'primex_nav_item_padding_y',
		array(
			'default'           => 8,
			'sanitize_callback' => static function ( $value ) {
				return primex_sanitize_int_range( $value, 0, 32, 8 );
			},
		),
		array(
			'label'   => __( 'Menu item vertical padding (px)', 'primex' ),
			'section' => 'primex_header_navigation',
			'type'    => 'number',
		)
	);

	primex_customizer_add_setting(
		$wp_customize,
		'primex_nav_hover_style',
		array(
			'default'           => 'color',
			'sanitize_callback' => 'primex_sanitize_nav_hover_style',
		),
		array(
			'label'   => __( 'Hover style', 'primex' ),
			'section' => 'primex_header_navigation',
			'type'    => 'select',
			'choices' => array(
				'color'    => __( 'Color change', 'primex' ),
				'underline'=> __( 'Underline', 'primex' ),
				'background' => __( 'Background pill', 'primex' ),
			),
		)
	);

	primex_customizer_add_setting(
		$wp_customize,
		'primex_nav_dropdown_animation',
		array(
			'default'           => 'fade',
			'sanitize_callback' => 'primex_sanitize_dropdown_animation',
		),
		array(
			'label'   => __( 'Dropdown animation', 'primex' ),
			'section' => 'primex_header_navigation',
			'type'    => 'select',
			'choices' => array(
				'fade' => __( 'Fade', 'primex' ),
				'none' => __( 'None', 'primex' ),
			),
		)
	);

	foreach ( array(
		'primex_nav_active_color'   => __( 'Active item color', 'primex' ),
		'primex_nav_dropdown_bg'    => __( 'Dropdown background', 'primex' ),
		'primex_nav_dropdown_text'  => __( 'Dropdown text color', 'primex' ),
	) as $key => $label ) {
		primex_customizer_add_setting(
			$wp_customize,
			$key,
			array(
				'default'           => '',
				'sanitize_callback' => 'sanitize_hex_color',
			),
			array(
				'label'   => $label,
				'section' => 'primex_header_navigation',
				'type'    => 'color',
			)
		);
	}

	primex_customizer_add_setting(
		$wp_customize,
		'primex_nav_dropdown_duration',
		array(
			'default'           => 200,
			'sanitize_callback' => static function ( $value ) {
				return primex_sanitize_int_range( $value, 0, 800, 200 );
			},
		),
		array(
			'label'   => __( 'Dropdown transition (ms)', 'primex' ),
			'section' => 'primex_header_navigation',
			'type'    => 'number',
		)
	);

	primex_customizer_add_setting(
		$wp_customize,
		'primex_mobile_breakpoint',
		array(
			'default'           => 1024,
			'sanitize_callback' => static function ( $value ) {
				return primex_sanitize_int_range( $value, 768, 1280, 1024 );
			},
		),
		array(
			'label'       => __( 'Mobile breakpoint (px)', 'primex' ),
			'section'     => 'primex_header_navigation',
			'type'        => 'number',
			'description' => __( 'Viewport width at which desktop navigation switches to off-canvas.', 'primex' ),
		)
	);

	// ----- Contact -----------------------------------------------------------
	primex_customizer_add_setting(
		$wp_customize,
		'primex_contact_enabled',
		array(
			'default'           => true,
			'sanitize_callback' => 'rest_sanitize_boolean',
		),
		array(
			'label'   => __( 'Show contact block', 'primex' ),
			'section' => 'primex_header_contact',
			'type'    => 'checkbox',
		)
	);

	primex_customizer_add_setting(
		$wp_customize,
		'primex_contact_title',
		array(
			'default'           => __( 'Have any Questions?', 'primex' ),
			'sanitize_callback' => 'sanitize_text_field',
		),
		array(
			'label'   => __( 'Headline', 'primex' ),
			'section' => 'primex_header_contact',
			'type'    => 'text',
		)
	);

	primex_customizer_add_setting(
		$wp_customize,
		'primex_contact_phone',
		array(
			'default'           => '',
			'sanitize_callback' => 'sanitize_text_field',
		),
		array(
			'label'       => __( 'Phone number', 'primex' ),
			'section'     => 'primex_header_contact',
			'type'        => 'text',
			'description' => __( 'Leave empty to hide the contact block.', 'primex' ),
		)
	);

	primex_customizer_add_setting(
		$wp_customize,
		'primex_contact_icon',
		array(
			'default'           => 'fa-phone',
			'sanitize_callback' => 'sanitize_text_field',
		),
		array(
			'label'       => __( 'Icon class (Font Awesome)', 'primex' ),
			'section'     => 'primex_header_contact',
			'type'        => 'text',
			'description' => __( 'Example: fa-phone. Requires Font Awesome.', 'primex' ),
		)
	);

	foreach ( array(
		'primex_contact_title_color' => __( 'Headline color', 'primex' ),
		'primex_contact_phone_color' => __( 'Phone color', 'primex' ),
		'primex_contact_icon_color'  => __( 'Icon color', 'primex' ),
	) as $key => $label ) {
		primex_customizer_add_setting(
			$wp_customize,
			$key,
			array(
				'default'           => '',
				'sanitize_callback' => 'sanitize_hex_color',
			),
			array(
				'label'   => $label,
				'section' => 'primex_header_contact',
				'type'    => 'color',
			)
		);
	}

	// ----- CTA ----------------------------------------------------------------
	primex_customizer_add_setting(
		$wp_customize,
		'primex_cta_enabled',
		array(
			'default'           => true,
			'sanitize_callback' => 'rest_sanitize_boolean',
		),
		array(
			'label'   => __( 'Show CTA button', 'primex' ),
			'section' => 'primex_header_cta',
			'type'    => 'checkbox',
		)
	);

	primex_customizer_add_setting(
		$wp_customize,
		'primex_cta_text',
		array(
			'default'           => __( 'Get a Quote', 'primex' ),
			'sanitize_callback' => 'sanitize_text_field',
		),
		array(
			'label'   => __( 'Button text', 'primex' ),
			'section' => 'primex_header_cta',
			'type'    => 'text',
		)
	);

	primex_customizer_add_setting(
		$wp_customize,
		'primex_cta_mode',
		array(
			'default'           => 'link',
			'sanitize_callback' => 'primex_sanitize_cta_mode',
		),
		array(
			'label'   => __( 'Button mode', 'primex' ),
			'section' => 'primex_header_cta',
			'type'    => 'select',
			'choices' => array(
				'link'  => __( 'Navigate to URL', 'primex' ),
				'popup' => __( 'Open Elementor popup', 'primex' ),
			),
		)
	);

	primex_customizer_add_setting(
		$wp_customize,
		'primex_cta_url',
		array(
			'default'           => '',
			'sanitize_callback' => 'esc_url_raw',
		),
		array(
			'label'   => __( 'Button URL', 'primex' ),
			'section' => 'primex_header_cta',
			'type'    => 'url',
		)
	);

	primex_customizer_add_setting(
		$wp_customize,
		'primex_cta_popup_id',
		array(
			'default'           => 0,
			'sanitize_callback' => 'absint',
		),
		array(
			'label'       => __( 'Elementor popup ID', 'primex' ),
			'section'     => 'primex_header_cta',
			'type'        => 'number',
			'description' => __( 'Used when Button mode is set to Elementor popup.', 'primex' ),
		)
	);

	primex_customizer_add_setting(
		$wp_customize,
		'primex_cta_target',
		array(
			'default'           => '',
			'sanitize_callback' => 'primex_sanitize_link_target',
		),
		array(
			'label'   => __( 'Link target', 'primex' ),
			'section' => 'primex_header_cta',
			'type'    => 'select',
			'choices' => array(
				''       => __( 'Same window', 'primex' ),
				'_blank' => __( 'New window', 'primex' ),
			),
		)
	);

	$cta_numbers = array(
		'primex_cta_radius'     => array( 8, 0, 48, __( 'Border radius (px)', 'primex' ) ),
		'primex_cta_padding_y'  => array( 12, 4, 32, __( 'Padding vertical (px)', 'primex' ) ),
		'primex_cta_padding_x'  => array( 24, 8, 48, __( 'Padding horizontal (px)', 'primex' ) ),
		'primex_cta_min_width'  => array( 0, 0, 320, __( 'Minimum width (px)', 'primex' ) ),
		'primex_cta_min_height' => array( 44, 32, 72, __( 'Minimum height (px)', 'primex' ) ),
	);

	foreach ( $cta_numbers as $key => $meta ) {
		list( $default, $min, $max, $label ) = $meta;
		primex_customizer_add_setting(
			$wp_customize,
			$key,
			array(
				'default'           => $default,
				'sanitize_callback' => static function ( $value ) use ( $min, $max, $default ) {
					return primex_sanitize_int_range( $value, $min, $max, $default );
				},
			),
			array(
				'label'   => $label,
				'section' => 'primex_header_cta',
				'type'    => 'number',
			)
		);
	}

	foreach ( array(
		'primex_cta_bg'        => __( 'Background', 'primex' ),
		'primex_cta_bg_hover'  => __( 'Hover background', 'primex' ),
		'primex_cta_text_color'=> __( 'Text color', 'primex' ),
	) as $key => $label ) {
		primex_customizer_add_setting(
			$wp_customize,
			$key,
			array(
				'default'           => '',
				'sanitize_callback' => 'sanitize_hex_color',
			),
			array(
				'label'   => $label,
				'section' => 'primex_header_cta',
				'type'    => 'color',
			)
		);
	}

	// ----- Sticky -------------------------------------------------------------
	primex_customizer_add_setting(
		$wp_customize,
		'primex_sticky_header',
		array(
			'default'           => true,
			'sanitize_callback' => 'rest_sanitize_boolean',
		),
		array(
			'label'   => __( 'Enable sticky header', 'primex' ),
			'section' => 'primex_header_sticky',
			'type'    => 'checkbox',
		)
	);

	$sticky_toggles = array(
		'primex_sticky_hide_down' => array( 'label' => __( 'Hide while scrolling down', 'primex' ), 'default' => false ),
		'primex_sticky_reveal_up' => array( 'label' => __( 'Reveal while scrolling up', 'primex' ), 'default' => true ),
		'primex_sticky_shrink'    => array( 'label' => __( 'Shrink while sticky', 'primex' ), 'default' => true ),
	);

	foreach ( $sticky_toggles as $key => $meta ) {
		primex_customizer_add_setting(
			$wp_customize,
			$key,
			array(
				'default'           => $meta['default'],
				'sanitize_callback' => 'rest_sanitize_boolean',
			),
			array(
				'label'   => $meta['label'],
				'section' => 'primex_header_sticky',
				'type'    => 'checkbox',
			)
		);
	}

	foreach ( array(
		'primex_sticky_height'        => array( 72, 48, 120, __( 'Sticky height (px)', 'primex' ) ),
		'primex_sticky_logo_height'   => array( 40, 24, 96, __( 'Sticky logo height (px)', 'primex' ) ),
		'primex_sticky_offset'        => array( 20, 0, 300, __( 'Scroll offset (px)', 'primex' ) ),
		'primex_sticky_transition_ms' => array( 300, 100, 800, __( 'Transition speed (ms)', 'primex' ) ),
	) as $key => $meta ) {
		list( $default, $min, $max, $label ) = $meta;
		primex_customizer_add_setting(
			$wp_customize,
			$key,
			array(
				'default'           => $default,
				'sanitize_callback' => static function ( $value ) use ( $min, $max, $default ) {
					return primex_sanitize_int_range( $value, $min, $max, $default );
				},
			),
			array(
				'label'   => $label,
				'section' => 'primex_header_sticky',
				'type'    => 'number',
			)
		);
	}

	primex_customizer_add_setting(
		$wp_customize,
		'primex_sticky_bg',
		array(
			'default'           => '#FFFFFF',
			'sanitize_callback' => 'sanitize_hex_color',
		),
		array(
			'label'   => __( 'Sticky background', 'primex' ),
			'section' => 'primex_header_sticky',
			'type'    => 'color',
		)
	);

	primex_customizer_add_setting(
		$wp_customize,
		'primex_sticky_shadow',
		array(
			'default'           => 'default',
			'sanitize_callback' => 'primex_sanitize_shadow_preset',
		),
		array(
			'label'   => __( 'Sticky shadow', 'primex' ),
			'section' => 'primex_header_sticky',
			'type'    => 'select',
			'choices' => primex_get_shadow_choices(),
		)
	);

	// ----- Mobile -------------------------------------------------------------
	primex_customizer_add_setting(
		$wp_customize,
		'primex_mobile_enabled',
		array(
			'default'           => true,
			'sanitize_callback' => 'rest_sanitize_boolean',
		),
		array(
			'label'   => __( 'Enable mobile off-canvas menu', 'primex' ),
			'section' => 'primex_header_mobile',
			'type'    => 'checkbox',
		)
	);

	primex_customizer_add_setting(
		$wp_customize,
		'primex_mobile_panel_width',
		array(
			'default'           => 360,
			'sanitize_callback' => static function ( $value ) {
				return primex_sanitize_int_range( $value, 280, 480, 360 );
			},
		),
		array(
			'label'   => __( 'Panel width (px)', 'primex' ),
			'section' => 'primex_header_mobile',
			'type'    => 'number',
		)
	);

	primex_customizer_add_setting(
		$wp_customize,
		'primex_mobile_overlay_color',
		array(
			'default'           => '#000000',
			'sanitize_callback' => 'sanitize_hex_color',
		),
		array(
			'label'   => __( 'Overlay color', 'primex' ),
			'section' => 'primex_header_mobile',
			'type'    => 'color',
		)
	);

	primex_customizer_add_setting(
		$wp_customize,
		'primex_mobile_animation_ms',
		array(
			'default'           => 250,
			'sanitize_callback' => static function ( $value ) {
				return primex_sanitize_int_range( $value, 100, 800, 250 );
			},
		),
		array(
			'label'   => __( 'Animation speed (ms)', 'primex' ),
			'section' => 'primex_header_mobile',
			'type'    => 'number',
		)
	);

	primex_customizer_add_setting(
		$wp_customize,
		'primex_mobile_show_cta',
		array(
			'default'           => true,
			'sanitize_callback' => 'rest_sanitize_boolean',
		),
		array(
			'label'   => __( 'Show CTA in mobile menu', 'primex' ),
			'section' => 'primex_header_mobile',
			'type'    => 'checkbox',
		)
	);

	primex_customizer_add_setting(
		$wp_customize,
		'primex_mobile_show_contact',
		array(
			'default'           => true,
			'sanitize_callback' => 'rest_sanitize_boolean',
		),
		array(
			'label'   => __( 'Show contact in mobile menu', 'primex' ),
			'section' => 'primex_header_mobile',
			'type'    => 'checkbox',
		)
	);

	primex_customizer_add_setting(
		$wp_customize,
		'primex_mobile_show_social',
		array(
			'default'           => false,
			'sanitize_callback' => 'rest_sanitize_boolean',
		),
		array(
			'label'   => __( 'Show social icons in mobile menu', 'primex' ),
			'section' => 'primex_header_mobile',
			'type'    => 'checkbox',
		)
	);

	// ----- Layout & top bar (legacy section migrated) -----------------------
	primex_customizer_add_setting(
		$wp_customize,
		'primex_header_layout',
		array(
			'default'           => 'header-logistics',
			'sanitize_callback' => 'primex_sanitize_header_layout',
		),
		array(
			'label'   => __( 'Header layout', 'primex' ),
			'section' => 'primex_header_layouts',
			'type'    => 'select',
			'choices' => array(
				'header-logistics' => __( 'Logistics (logo | nav | contact + CTA)', 'primex' ),
				'header-1'         => __( 'Standard (logo | nav | search + quote)', 'primex' ),
				'header-2'         => __( 'Transparent (over hero)', 'primex' ),
			),
		)
	);

	primex_customizer_add_setting(
		$wp_customize,
		'primex_show_topbar',
		array(
			'default'           => true,
			'sanitize_callback' => 'rest_sanitize_boolean',
		),
		array(
			'label'   => __( 'Show top bar (contact + socials)', 'primex' ),
			'section' => 'primex_header_layouts',
			'type'    => 'checkbox',
		)
	);

	// Legacy quote controls mapped to CTA for backward compatibility.
	primex_customizer_add_setting(
		$wp_customize,
		'primex_quote_button_text',
		array(
			'default'           => __( 'Get a Quote', 'primex' ),
			'sanitize_callback' => 'sanitize_text_field',
		),
		array(
			'label'       => __( 'Legacy quote button text', 'primex' ),
			'description' => __( 'Deprecated. Use CTA Button section instead.', 'primex' ),
			'section'     => 'primex_header_layouts',
			'type'        => 'text',
		)
	);

	primex_customizer_add_setting(
		$wp_customize,
		'primex_quote_button_url',
		array(
			'default'           => '',
			'sanitize_callback' => 'esc_url_raw',
		),
		array(
			'label'       => __( 'Legacy quote button URL', 'primex' ),
			'description' => __( 'Deprecated. Use CTA Button section instead.', 'primex' ),
			'section'     => 'primex_header_layouts',
			'type'        => 'url',
		)
	);

	$contact_fields = array(
		'primex_topbar_phone'   => __( 'Top bar phone', 'primex' ),
		'primex_topbar_email'   => __( 'Top bar email', 'primex' ),
		'primex_topbar_hours'   => __( 'Top bar working hours', 'primex' ),
		'primex_topbar_address' => __( 'Top bar address', 'primex' ),
	);

	foreach ( $contact_fields as $setting_id => $label ) {
		primex_customizer_add_setting(
			$wp_customize,
			$setting_id,
			array(
				'default'           => '',
				'sanitize_callback' => 'sanitize_text_field',
			),
			array(
				'label'   => $label,
				'section' => 'primex_header_layouts',
				'type'    => 'text',
			)
		);
	}

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial(
			'primex_header_contact',
			array(
				'selector'            => '.primex-header-contact',
				'container_inclusive' => true,
				'render_callback'     => static function () {
					get_template_part( 'template-parts/header/parts/contact' );
				},
			)
		);

		$wp_customize->selective_refresh->add_partial(
			'primex_header_cta',
			array(
				'selector'            => '.primex-header-cta',
				'container_inclusive' => true,
				'render_callback'     => static function () {
					get_template_part( 'template-parts/header/parts/cta-button' );
				},
			)
		);
	}
}
add_action( 'customize_register', 'primex_customize_register_header', 15 );

/**
 * Helper to register a setting + control pair.
 *
 * @param WP_Customize_Manager $wp_customize Manager.
 * @param string               $id          Setting id.
 * @param array                $setting     Setting args.
 * @param array                $control     Control args.
 */
function primex_customizer_add_setting( WP_Customize_Manager $wp_customize, string $id, array $setting, array $control ): void {
	$setting = wp_parse_args(
		$setting,
		array(
			'transport' => 'refresh',
		)
	);

	$wp_customize->add_setting( $id, $setting );

	$control['settings'] = $id;
	$type                = $control['type'] ?? 'text';

	if ( 'color' === $type ) {
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, $id, $control ) );
		return;
	}

	if ( 'media' === $type ) {
		$wp_customize->add_control( new WP_Customize_Media_Control( $wp_customize, $id, $control ) );
		return;
	}

	$wp_customize->add_control( $id, $control );
}

/**
 * Shadow preset choices.
 *
 * @return array<string, string>
 */
function primex_get_shadow_choices(): array {
	return array(
		'none'    => __( 'None', 'primex' ),
		'sm'      => __( 'Small', 'primex' ),
		'default' => __( 'Default', 'primex' ),
		'lg'      => __( 'Large', 'primex' ),
	);
}

/**
 * Sanitize shadow preset.
 *
 * @param string $value Raw value.
 * @return string
 */
function primex_sanitize_shadow_preset( string $value ): string {
	$allowed = array_keys( primex_get_shadow_choices() );
	return in_array( $value, $allowed, true ) ? $value : 'default';
}

/**
 * Sanitize nav hover style.
 *
 * @param string $value Raw value.
 * @return string
 */
function primex_sanitize_nav_hover_style( string $value ): string {
	$allowed = array( 'color', 'underline', 'background' );
	return in_array( $value, $allowed, true ) ? $value : 'color';
}

/**
 * Sanitize dropdown animation.
 *
 * @param string $value Raw value.
 * @return string
 */
function primex_sanitize_dropdown_animation( string $value ): string {
	return in_array( $value, array( 'fade', 'none' ), true ) ? $value : 'fade';
}

/**
 * Sanitize link target attribute.
 *
 * @param string $value Raw value.
 * @return string
 */
function primex_sanitize_link_target( string $value ): string {
	return '_blank' === $value ? '_blank' : '';
}
