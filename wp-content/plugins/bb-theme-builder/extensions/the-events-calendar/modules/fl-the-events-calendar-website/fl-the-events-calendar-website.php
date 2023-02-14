<?php

/**
 * Text Editor module alias for the event website.
 * @since TBD
 */
FLBuilder::register_module_alias( 'fl-the-events-calendar-website', array(
	'module'      => 'rich-text',
	'name'        => __( 'Event Website', 'bb-theme-builder' ),
	'description' => __( 'Displays website for the event', 'bb-theme-builder' ),
	'group'       => __( 'Themer Modules', 'bb-theme-builder' ),
	'category'    => __( 'The Events Calendar', 'bb-theme-builder' ),
	'enabled'     => FLThemeBuilderLayoutData::current_post_is( 'singular' ),
	'settings'    => array(
		'text' => '[wpbb post:the_events_calendar_website_link]',
	),
) );
