<?php

/**
 * EDD support for the theme builder.
 *
 * @since 1.1
 */
final class FLThemeBuilderEDD {

	/**
	 * @since 1.1
	 * @return void
	 */
	static public function init() {
		// Actions
		add_action( 'wp', __CLASS__ . '::load_modules', 1 );

		// Filters
		add_filter( 'edd_delayed_actions', __CLASS__ . '::delayed_actions' );
	}

	/**
	 * Loads the EDD modules.
	 *
	 * @since 1.1
	 * @return void
	 */
	static public function load_modules() {
		FLThemeBuilderLoader::load_modules( FL_THEME_BUILDER_EDD_DIR . 'modules' );
	}

	/**
	 * Define action that needs to be delayed to avoid PHP notice
	 * due to hook dependencies.
	 *
	 * @since 1.2.2
	 * @return array
	 */
	static public function delayed_actions( $actions ) {
		$actions[] = 'view_receipt';
		return $actions;
	}
}

FLThemeBuilderEDD::init();
