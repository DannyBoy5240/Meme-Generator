<?php

/**
 * @since TBD
 * @class FLTheEventsCalendarVenueModule
 */
class FLTheEventsCalendarVenueModule extends FLBuilderModule {

	/**
	 * @since TBD
	 * @return void
	 */
	public function __construct() {
		parent::__construct(array(
			'name'            => __( 'Event Venue', 'bb-theme-builder' ),
			'description'     => __( 'Displays the venue details for the current event.', 'bb-theme-builder' ),
			'group'           => __( 'Themer Modules', 'bb-theme-builder' ),
			'category'        => __( 'The Events Calendar', 'bb-theme-builder' ),
			'partial_refresh' => true,
			'dir'             => FL_THEME_BUILDER_THE_EVENTS_CALENDAR_DIR . 'modules/fl-the-events-calendar-venue/',
			'url'             => FL_THEME_BUILDER_THE_EVENTS_CALENDAR_URL . 'modules/fl-the-events-calendar-venue/',
			'enabled'         => FLThemeBuilderLayoutData::current_post_is( 'singular' ),
		));
	}
}

FLBuilder::register_module( 'FLTheEventsCalendarVenueModule', array() );
