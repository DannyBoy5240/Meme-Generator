<?php

/**
 * @since TBD
 * @class FLTheEventsCalendarOrganizerModule
 */
class FLTheEventsCalendarOrganizerModule extends FLBuilderModule {

	/**
	 * @since TBD
	 * @return void
	 */
	public function __construct() {
		parent::__construct(array(
			'name'            => __( 'Event Organizer', 'bb-theme-builder' ),
			'description'     => __( 'Displays the organizer details for the current event.', 'bb-theme-builder' ),
			'group'           => __( 'Themer Modules', 'bb-theme-builder' ),
			'category'        => __( 'The Events Calendar', 'bb-theme-builder' ),
			'partial_refresh' => true,
			'dir'             => FL_THEME_BUILDER_THE_EVENTS_CALENDAR_DIR . 'modules/fl-the-events-calendar-organizer/',
			'url'             => FL_THEME_BUILDER_THE_EVENTS_CALENDAR_URL . 'modules/fl-the-events-calendar-organizer/',
			'enabled'         => FLThemeBuilderLayoutData::current_post_is( 'singular' ),
		));
	}
}

FLBuilder::register_module( 'FLTheEventsCalendarOrganizerModule', array() );
