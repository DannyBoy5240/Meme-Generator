<?php

define( 'FL_THEME_BUILDER_THE_EVENTS_CALENDAR_DIR', FL_THEME_BUILDER_DIR . 'extensions/the-events-calendar/' );
define( 'FL_THEME_BUILDER_THE_EVENTS_CALENDAR_URL', FL_THEME_BUILDER_URL . 'extensions/the-events-calendar/' );

if ( defined( 'TRIBE_EVENTS_FILE' ) ) {

	require_once FL_THEME_BUILDER_THE_EVENTS_CALENDAR_DIR . 'classes/class-fl-theme-builder-the-events-calendar.php';
	require_once FL_THEME_BUILDER_THE_EVENTS_CALENDAR_DIR . 'classes/class-fl-theme-builder-the-events-calendar-singular.php';
	require_once FL_THEME_BUILDER_THE_EVENTS_CALENDAR_DIR . 'classes/class-fl-theme-builder-the-events-calendar-archive.php';

	add_action( 'fl_page_data_add_properties', function() {
		require_once FL_THEME_BUILDER_THE_EVENTS_CALENDAR_DIR . 'classes/class-fl-page-data-the-events-calendar.php';
		require_once FL_THEME_BUILDER_THE_EVENTS_CALENDAR_DIR . 'includes/page-data-the-events-calendar.php';
	} );
}
