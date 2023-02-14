<?php

/**
 * The Events Calendar support for the theme builder.
 *
 * @since TBD
 */
final class FLThemeBuilderTheEventsCalendar {

	/**
	 * @since TBD
	 * @return void
	 */
	static public function init() {
		// Actions
		add_action( 'wp', __CLASS__ . '::load_modules', 1 );
	}

	/**
	 * Loads the The Events Calendar modules.
	 *
	 * @since TBD
	 * @return void
	 */
	static public function load_modules() {
		FLThemeBuilderLoader::load_modules( FL_THEME_BUILDER_THE_EVENTS_CALENDAR_DIR . 'modules' );
	}
}

FLThemeBuilderTheEventsCalendar::init();
