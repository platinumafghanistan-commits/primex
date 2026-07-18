<?php
/**
 * Elementor dynamic tags for header content.
 *
 * @package Primex
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Base Primex dynamic tag.
 */
abstract class Primex_Elementor_Dynamic_Tag_Base extends \Elementor\Core\DynamicTags\Tag {

	/**
	 * Tag group.
	 *
	 * @return array
	 */
	public function get_group(): array {
		return array( 'primex' );
	}

	/**
	 * Tag categories.
	 *
	 * @return array
	 */
	public function get_categories(): array {
		return array( \Elementor\Modules\DynamicTags\Module::TEXT_CATEGORY );
	}
}

/**
 * Contact phone dynamic tag.
 */
class Primex_Elementor_Tag_Contact_Phone extends Primex_Elementor_Dynamic_Tag_Base {

	/**
	 * Tag name.
	 */
	public function get_name(): string {
		return 'primex-contact-phone';
	}

	/**
	 * Tag title.
	 */
	public function get_title(): string {
		return __( 'Primex Contact Phone', 'primex' );
	}

	/**
	 * Render tag output.
	 */
	public function render(): void {
		echo esc_html( primex_get_contact_phone() );
	}
}

/**
 * Contact title dynamic tag.
 */
class Primex_Elementor_Tag_Contact_Title extends Primex_Elementor_Dynamic_Tag_Base {

	/**
	 * Tag name.
	 */
	public function get_name(): string {
		return 'primex-contact-title';
	}

	/**
	 * Tag title.
	 */
	public function get_title(): string {
		return __( 'Primex Contact Title', 'primex' );
	}

	/**
	 * Render tag output.
	 */
	public function render(): void {
		echo esc_html( primex_get_contact_title() );
	}
}

/**
 * CTA text dynamic tag.
 */
class Primex_Elementor_Tag_Cta_Text extends Primex_Elementor_Dynamic_Tag_Base {

	/**
	 * Tag name.
	 */
	public function get_name(): string {
		return 'primex-cta-text';
	}

	/**
	 * Tag title.
	 */
	public function get_title(): string {
		return __( 'Primex CTA Text', 'primex' );
	}

	/**
	 * Render tag output.
	 */
	public function render(): void {
		echo esc_html( primex_get_cta_text() );
	}
}
