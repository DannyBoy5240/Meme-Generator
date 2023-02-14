<?php

/**
 * WooCommerce support for the theme builder.
 */
final class FLThemeBuilderBigCommerce {

	/**
	 * @return void
	 */
	static public function init() {
		// Actions
		add_action( 'wp', __CLASS__ . '::load_modules', 1 );
		add_action( 'wp_enqueue_scripts', __CLASS__ . '::enqueue_scripts' );
	}

	/**
	 * Loads the BigCommerce modules.
	 *
	 * @return void
	 */
	static public function load_modules() {
		FLThemeBuilderLoader::load_modules( FL_THEME_BUILDER_BIGCOMMERCE_DIR . 'modules' );
	}

	static public function enqueue_scripts() {
		wp_enqueue_style( 'fl-theme-builder-bigcommerce', FL_THEME_BUILDER_BIGCOMMERCE_URL . 'css/fl-theme-builder-bigcommerce.css' );
	}

}

FLThemeBuilderBigCommerce::init();
