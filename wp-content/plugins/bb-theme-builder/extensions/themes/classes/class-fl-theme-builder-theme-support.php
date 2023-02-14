<?php

/**
 * Handles basic logic for theme support.
 *
 * @since 1.0
 */
final class FLThemeBuilderThemeSupport {

	/**
	 * Initialize hooks.
	 *
	 * @since 1.0
	 * @return void
	 */
	static public function init() {
		add_action( 'after_setup_theme', __CLASS__ . '::load' );
	}

	/**
	 * Loads theme support if we have a supported theme.
	 *
	 * @since 1.0
	 * @return void
	 */
	static public function load() {
		$slug = false;

		if ( defined( 'FL_THEME_VERSION' ) ) {
			$slug = 'bb-theme';
		} elseif ( function_exists( 'genesis' ) ) {
			$slug = 'genesis';
		} elseif ( defined( 'GENERATE_VERSION' ) ) {
			$slug = 'generatepress';
		} elseif ( function_exists( 'storefront_is_woocommerce_activated' ) ) {
			$slug = 'storefront';
		}

		if ( $slug ) {
			require_once FL_THEME_BUILDER_THEMES_DIR . "classes/class-fl-theme-builder-support-$slug.php";
		}
	}
}

FLThemeBuilderThemeSupport::init();
