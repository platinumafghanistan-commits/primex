<?php
/**
 * Custom nav menu walker with mega menu, badges, icons, and ARIA.
 *
 * @package Primex
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Walker_Nav_Menu subclass with accessibility add-ons.
 */
class Primex_Menu_Walker extends Walker_Nav_Menu {

	/**
	 * Whether the current item has children.
	 *
	 * @var bool
	 */
	private bool $has_children_now = false;

	/**
	 * Starts the list before the children are traversed.
	 *
	 * @param string   $output Used to append additional content.
	 * @param int      $depth  Depth of menu item.
	 * @param stdClass $args   wp_nav_menu() arguments.
	 */
	public function start_lvl( &$output, $depth = 0, $args = null ): void {
		$indent  = str_repeat( "\t", $depth );
		$classes = array( 'sub-menu' );

		if ( 0 === $depth ) {
			$classes[] = 'primex-submenu';
		}

		$class_names = implode( ' ', array_map( 'sanitize_html_class', $classes ) );
		$output     .= "\n{$indent}<ul class=\"{$class_names}\">\n";
	}

	/**
	 * Starts the element output.
	 *
	 * @param string   $output Used to append additional content.
	 * @param WP_Post  $item   Menu item data object.
	 * @param int      $depth  Depth of menu item.
	 * @param stdClass $args   wp_nav_menu() arguments.
	 * @param int      $id     Current item ID.
	 */
	public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ): void {
		$classes   = empty( $item->classes ) ? array() : (array) $item->classes;
		$classes[] = 'menu-item-' . $item->ID;

		$this->has_children_now = in_array( 'menu-item-has-children', $classes, true );

		if ( 0 === $depth && in_array( 'mega-menu', $classes, true ) ) {
			$classes[] = 'primex-menu__item--mega';
		}

		$class_names = implode( ' ', array_map( 'sanitize_html_class', array_filter( $classes ) ) );

		$output .= '<li class="' . esc_attr( $class_names ) . '">';

		$atts           = array();
		$atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
		$atts['target'] = ! empty( $item->target ) ? $item->target : '';
		$atts['rel']    = ! empty( $item->xfn ) ? $item->xfn : '';
		$atts['href']   = ! empty( $item->url ) ? $item->url : '';

		if ( $this->has_children_now ) {
			$atts['aria-haspopup'] = 'true';
			$atts['aria-expanded'] = 'false';
		}

		$atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args, $depth );

		$attributes = '';
		foreach ( $atts as $attr => $value ) {
			if ( is_scalar( $value ) && '' !== $value ) {
				$attributes .= ' ' . $attr . '="' . esc_attr( (string) $value ) . '"';
			}
		}

		$title = apply_filters( 'the_title', $item->title, $item->ID );
		$title = apply_filters( 'nav_menu_item_title', $title, $item, $args, $depth );

		$icon_html = primex_get_menu_item_icon_html( $item );
		$badge     = primex_get_menu_item_badge_html( $item );

		$item_output  = $args->before ?? '';
		$item_output .= '<a' . $attributes . '>';
		$item_output .= ( $args->link_before ?? '' ) . $icon_html . '<span class="primex-menu__label">' . $title . '</span>' . $badge . ( $args->link_after ?? '' );
		$item_output .= '</a>';
		$item_output .= $args->after ?? '';

		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );

		if ( $this->has_children_now ) {
			$submenu_id = 'primex-submenu-' . $item->ID;
			$output    .= sprintf(
				'<button type="button" class="primex-menu__toggle" aria-expanded="false" aria-controls="%1$s"><span class="screen-reader-text">%2$s</span><svg width="12" height="12" viewBox="0 0 12 12" fill="currentColor" aria-hidden="true"><path d="M6 8L1.5 3.5h9z"/></svg></button>',
				esc_attr( $submenu_id ),
				esc_html__( 'Expand submenu', 'primex' )
			);
		}
	}
}

/**
 * Parse optional icon class from menu item classes (icon-*).
 *
 * @param WP_Post $item Menu item.
 * @return string HTML.
 */
function primex_get_menu_item_icon_html( WP_Post $item ): string {
	foreach ( (array) $item->classes as $class ) {
		if ( 0 === strpos( $class, 'icon-' ) ) {
			$icon = sanitize_html_class( substr( $class, 5 ) );
			if ( $icon ) {
				return '<i class="fa-' . esc_attr( $icon ) . ' primex-menu__icon" aria-hidden="true"></i>';
			}
		}
	}
	return '';
}

/**
 * Parse optional badge from menu item description.
 *
 * @param WP_Post $item Menu item.
 * @return string HTML.
 */
function primex_get_menu_item_badge_html( WP_Post $item ): string {
	$badge = trim( (string) $item->description );
	if ( '' === $badge ) {
		return '';
	}

	return '<span class="primex-menu__badge">' . esc_html( $badge ) . '</span>';
}

/**
 * Add submenu IDs for aria-controls wiring.
 *
 * @param string $nav_menu Nav menu HTML.
 * @return string
 */
function primex_nav_menu_submenu_ids( string $nav_menu ): string {
	return preg_replace_callback(
		'/<ul class="([^"]*sub-menu[^"]*)"/',
		static function ( $matches ) {
			static $index = 0;
			++$index;
			return '<ul id="primex-submenu-auto-' . $index . '" class="' . $matches[1] . '"';
		},
		$nav_menu
	) ?? $nav_menu;
}
add_filter( 'wp_nav_menu', 'primex_nav_menu_submenu_ids' );
