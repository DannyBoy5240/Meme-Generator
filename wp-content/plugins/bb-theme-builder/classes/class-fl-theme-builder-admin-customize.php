<?php

/**
 * Handles Customizer logic for the theme builder.
 *
 * @since 1.0
 */
final class FLThemeBuilderAdminCustomize {

	/**
	 * Initialize hooks.
	 *
	 * @since 1.0
	 * @return void
	 */
	static public function init() {
		add_action( 'customize_controls_enqueue_scripts', __CLASS__ . '::enqueue_scripts' );
		add_action( 'customize_controls_print_footer_scripts', __CLASS__ . '::footer_scripts' );
		add_action( 'wp_footer', __CLASS__ . '::preview_js_config' );
	}

	/**
	 * Enqueues scripts for the Customizer.
	 *
	 * @since 1.0
	 * @return void
	 */
	static public function enqueue_scripts() {
		$slug = 'fl-theme-builder-admin-customize';

		wp_enqueue_style( $slug, FL_THEME_BUILDER_URL . '/css/' . $slug . '.css', array(), FL_THEME_BUILDER_VERSION );
		wp_enqueue_script( $slug, FL_THEME_BUILDER_URL . '/js/' . $slug . '.js', array(), FL_THEME_BUILDER_VERSION, true );
	}

	/**
	 * Renders the Customizer footer scripts.
	 *
	 * @since 1.0
	 * @return void
	 */
	static public function footer_scripts() {
		include FL_THEME_BUILDER_DIR . 'includes/admin-customize-js-templates.php';
	}

	/**
	 * Renders the JS config for the preview iframe.
	 *
	 * @since 1.0
	 * @return void
	 */
	static public function preview_js_config() {
		if ( ! is_customize_preview() ) {
			return;
		}

		include FL_THEME_BUILDER_DIR . 'includes/admin-customize-preview-js-config.php';
	}
}

FLThemeBuilderAdminCustomize::init();
