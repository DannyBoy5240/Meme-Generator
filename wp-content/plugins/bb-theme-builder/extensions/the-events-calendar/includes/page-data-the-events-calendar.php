<?php

/**
 * Post Properties
 */

/**
 * Event Date and Time
 */
FLPageData::add_post_property( 'the_events_calendar_date_and_time', array(
	'label'  => __( 'Event Date and Time', 'bb-theme-builder' ),
	'group'  => 'the-events-calendar',
	'type'   => 'string',
	'getter' => 'tribe_events_event_schedule_details',
) );

/**
 * Event Start Date
 */
FLPageData::add_post_property( 'the_events_calendar_start_date', array(
	'label'  => __( 'Event Start Date', 'bb-theme-builder' ),
	'group'  => 'the-events-calendar',
	'type'   => 'string',
	'getter' => 'FLPageDataTheEventsCalendar::start_date',
) );

FLPageData::add_post_property_settings_fields( 'the_events_calendar_start_date', array(
	'format' => array(
		'type'        => 'text',
		'label'       => __( 'Format', 'bb-theme-builder' ),
		'default'     => '',
		'size'        => '5',
		'description' => __( 'Date Format', 'bb-theme-builder' ),
		'placeholder' => 'M d Y',
	),
) );

/**
 * Event Start Time
 */
FLPageData::add_post_property( 'the_events_calendar_start_time', array(
	'label'  => __( 'Event Start Time', 'bb-theme-builder' ),
	'group'  => 'the-events-calendar',
	'type'   => 'string',
	'getter' => 'FLPageDataTheEventsCalendar::start_time',
) );

/**
 * Event End Date
 */
FLPageData::add_post_property( 'the_events_calendar_end_date', array(
	'label'  => __( 'Event End Date', 'bb-theme-builder' ),
	'group'  => 'the-events-calendar',
	'type'   => 'string',
	'getter' => 'FLPageDataTheEventsCalendar::end_date',
) );

FLPageData::add_post_property_settings_fields( 'the_events_calendar_end_date', array(
	'format' => array(
		'type'        => 'text',
		'label'       => __( 'Format', 'bb-theme-builder' ),
		'default'     => '',
		'size'        => '5',
		'description' => __( 'Date Format', 'bb-theme-builder' ),
		'placeholder' => 'M d Y',
	),
) );

/**
 * Event End Time
 */
FLPageData::add_post_property( 'the_events_calendar_end_time', array(
	'label'  => __( 'Event End Time', 'bb-theme-builder' ),
	'group'  => 'the-events-calendar',
	'type'   => 'string',
	'getter' => 'FLPageDataTheEventsCalendar::end_time',
) );

/**
 * Event Cost
 */
FLPageData::add_post_property( 'the_events_calendar_cost', array(
	'label'  => __( 'Event Cost', 'bb-theme-builder' ),
	'group'  => 'the-events-calendar',
	'type'   => 'string',
	'getter' => 'FLPageDataTheEventsCalendar::event_cost',
) );

FLPageData::add_post_property_settings_fields( 'the_events_calendar_cost', array(
	'show_currency' => array(
		'type'    => 'select',
		'label'   => __( 'Show Currency', 'bb-theme-builder' ),
		'default' => '0',
		'options' => array(
			'0' => 'No',
			'1' => 'Yes',
		),
	),
) );

/**
 * Event Website URL
 */
FLPageData::add_post_property( 'the_events_calendar_website_url', array(
	'label'  => __( 'Event Website URL', 'bb-theme-builder' ),
	'group'  => 'the-events-calendar',
	'type'   => 'url',
	'getter' => 'tribe_get_event_website_url',
) );

/**
 * Event Website Link
 */
FLPageData::add_post_property( 'the_events_calendar_website_link', array(
	'label'  => __( 'Event Website Link', 'bb-theme-builder' ),
	'group'  => 'the-events-calendar',
	'type'   => 'string',
	'getter' => 'tribe_get_event_website_link',
) );

/**
 * Event Address
 */
FLPageData::add_post_property( 'the_events_calendar_address', array(
	'label'  => __( 'Event Full Address', 'bb-theme-builder' ),
	'group'  => 'the-events-calendar',
	'type'   => 'string',
	'getter' => 'tribe_get_full_address',
) );

/**
 * Event Map URL
 */
FLPageData::add_post_property( 'the_events_calendar_map_url', array(
	'label'  => __( 'Event Map URL', 'bb-theme-builder' ),
	'group'  => 'the-events-calendar',
	'type'   => 'url',
	'getter' => 'tribe_get_map_link',
) );

/**
 * Event Map Link
 */
FLPageData::add_post_property( 'the_events_calendar_map_link', array(
	'label'  => __( 'Event Map Link', 'bb-theme-builder' ),
	'group'  => 'the-events-calendar',
	'type'   => 'string',
	'getter' => 'tribe_get_map_link_html',
) );

/**
 * Event Address
 */
FLPageData::add_post_property( 'the_events_calendar_address_first_line', array(
	'label'  => __( 'Event Address', 'bb-theme-builder' ),
	'group'  => 'the-events-calendar',
	'type'   => 'string',
	'getter' => 'tribe_get_address',
) );

/**
 * Event City
 */
FLPageData::add_post_property( 'the_events_calendar_address_city', array(
	'label'  => __( 'Event City', 'bb-theme-builder' ),
	'group'  => 'the-events-calendar',
	'type'   => 'string',
	'getter' => 'tribe_get_city',
) );

/**
 * Event State
 */
FLPageData::add_post_property( 'the_events_calendar_address_state', array(
	'label'  => __( 'Event State', 'bb-theme-builder' ),
	'group'  => 'the-events-calendar',
	'type'   => 'string',
	'getter' => 'tribe_get_state',
) );

/**
 * Event Region
 */
FLPageData::add_post_property( 'the_events_calendar_address_region', array(
	'label'  => __( 'Event Region', 'bb-theme-builder' ),
	'group'  => 'the-events-calendar',
	'type'   => 'string',
	'getter' => 'tribe_get_region',
) );

/**
 * Event Zip
 */
FLPageData::add_post_property( 'the_events_calendar_address_zip', array(
	'label'  => __( 'Event Zip', 'bb-theme-builder' ),
	'group'  => 'the-events-calendar',
	'type'   => 'string',
	'getter' => 'tribe_get_zip',
) );

/**
 * Event Phone
 */
FLPageData::add_post_property( 'the_events_calendar_phone', array(
	'label'  => __( 'Event Phone', 'bb-theme-builder' ),
	'group'  => 'the-events-calendar',
	'type'   => 'string',
	'getter' => 'tribe_get_phone',
) );

/**
 * Event Venue
 */
FLPageData::add_post_property( 'the_events_calendar_venue', array(
	'label'  => __( 'Event Venue', 'bb-theme-builder' ),
	'group'  => 'the-events-calendar',
	'type'   => 'string',
	'getter' => 'tribe_get_venue',
) );

/**
 * Event Venue Content
 */
FLPageData::add_post_property( 'the_events_calendar_venue_content', array(
	'label'  => __( 'Event Venue Content', 'bb-theme-builder' ),
	'group'  => 'the-events-calendar',
	'type'   => 'string',
	'getter' => 'FLPageDataTheEventsCalendar::venue_content',
) );

/**
 * Event Venue URL
 */
FLPageData::add_post_property( 'the_events_calendar_venue_url', array(
	'label'  => __( 'Event Venue URL', 'bb-theme-builder' ),
	'group'  => 'the-events-calendar',
	'type'   => 'url',
	'getter' => 'FLPageDataTheEventsCalendar::venue_url',
) );

/**
 * Event Venue Link
 */
FLPageData::add_post_property( 'the_events_calendar_venue_link', array(
	'label'  => __( 'Event Venue Link', 'bb-theme-builder' ),
	'group'  => 'the-events-calendar',
	'type'   => 'string',
	'getter' => 'tribe_get_venue_link',
) );

/**
 * Event Venue Website URL
 */
FLPageData::add_post_property( 'the_events_calendar_venue_website_url', array(
	'label'  => __( 'Event Venue Website URL', 'bb-theme-builder' ),
	'group'  => 'the-events-calendar',
	'type'   => 'url',
	'getter' => 'tribe_get_venue_website_url',
) );

/**
 * Event Venue Website Link
 */
FLPageData::add_post_property( 'the_events_calendar_venue_website_link', array(
	'label'  => __( 'Event Venue Website Link', 'bb-theme-builder' ),
	'group'  => 'the-events-calendar',
	'type'   => 'string',
	'getter' => 'tribe_get_venue_website_link',
) );

/**
 * Event Organizer
 */
FLPageData::add_post_property( 'the_events_calendar_organizer', array(
	'label'  => __( 'Event Organizer', 'bb-theme-builder' ),
	'group'  => 'the-events-calendar',
	'type'   => 'string',
	'getter' => 'tribe_get_organizer',
) );

/**
 * Event Organizer Content
 */
FLPageData::add_post_property( 'the_events_calendar_organizer_content', array(
	'label'  => __( 'Event Organizer Content', 'bb-theme-builder' ),
	'group'  => 'the-events-calendar',
	'type'   => 'string',
	'getter' => 'FLPageDataTheEventsCalendar::organizer_content',
) );

/**
 * Event Organizer URL
 */
FLPageData::add_post_property( 'the_events_calendar_organizer_url', array(
	'label'  => __( 'Event Organizer URL', 'bb-theme-builder' ),
	'group'  => 'the-events-calendar',
	'type'   => 'url',
	'getter' => 'FLPageDataTheEventsCalendar::organizer_url',
) );

/**
 * Event Organizer Link
 */
FLPageData::add_post_property( 'the_events_calendar_organizer_link', array(
	'label'  => __( 'Event Organizer Link', 'bb-theme-builder' ),
	'group'  => 'the-events-calendar',
	'type'   => 'string',
	'getter' => 'tribe_get_organizer_link',
) );

/**
 * Event Organizer Website URL
 */
FLPageData::add_post_property( 'the_events_calendar_organizer_website_url', array(
	'label'  => __( 'Event Organizer Website URL', 'bb-theme-builder' ),
	'group'  => 'the-events-calendar',
	'type'   => 'url',
	'getter' => 'tribe_get_organizer_website_url',
) );

/**
 * Event Organizer Website Link
 */
FLPageData::add_post_property( 'the_events_calendar_organizer_website_link', array(
	'label'  => __( 'Event Organizer Website Link', 'bb-theme-builder' ),
	'group'  => 'the-events-calendar',
	'type'   => 'string',
	'getter' => 'tribe_get_organizer_website_link',
) );

/**
 * Event Organizer Phone
 */
FLPageData::add_post_property( 'the_events_calendar_organizer_phone', array(
	'label'  => __( 'Event Organizer Phone', 'bb-theme-builder' ),
	'group'  => 'the-events-calendar',
	'type'   => 'string',
	'getter' => 'tribe_get_organizer_phone',
) );

/**
 * Event Organizer Email
 */
FLPageData::add_post_property( 'the_events_calendar_organizer_email', array(
	'label'  => __( 'Event Organizer Email', 'bb-theme-builder' ),
	'group'  => 'the-events-calendar',
	'type'   => 'string',
	'getter' => 'tribe_get_organizer_email',
) );

/**
 * Event Field
 */
if ( class_exists( 'Tribe__Events__Pro__Main' ) ) {

	FLPageData::add_post_property( 'the_events_calendar_field', array(
		'label'  => __( 'Event Field', 'bb-theme-builder' ),
		'group'  => 'the-events-calendar',
		'type'   => 'string',
		'getter' => 'FLPageDataTheEventsCalendar::field',
	) );

	FLPageData::add_post_property_settings_fields( 'the_events_calendar_field', array(
		'name' => array(
			'type'  => 'text',
			'label' => __( 'Field Name', 'bb-theme-builder' ),
		),
	) );
}

/**
 * Events Back Link
 */
FLPageData::add_post_property( 'the_events_calendar_back_link', array(
	'label'  => __( 'Events Back Link', 'bb-theme-builder' ),
	'group'  => 'the-events-calendar',
	'type'   => 'string',
	'getter' => 'FLPageDataTheEventsCalendar::back_link',
) );

/**
 * Events Back URL
 */
FLPageData::add_post_property( 'the_events_calendar_back_url', array(
	'label'  => __( 'Events Back URL', 'bb-theme-builder' ),
	'group'  => 'the-events-calendar',
	'type'   => 'url',
	'getter' => 'tribe_get_events_link',
) );
