<?php

/**
 * Heading module alias for the events back link.
 *
 * @since TBD
 */
FLBuilder::register_module_alias( 'fl-the-events-calendar-back-link', array(
	'module'      => 'heading',
	'name'        => __( 'Events Back Link', 'bb-theme-builder' ),
	'description' => __( 'Displays the link to go back to the event archives.', 'bb-theme-builder' ),
	'group'       => __( 'Themer Modules', 'bb-theme-builder' ),
	'category'    => __( 'The Events Calendar', 'bb-theme-builder' ),
	'enabled'     => FLThemeBuilderLayoutData::current_post_is( 'singular' ),
	'settings'    => array(
		'text' => '[wpbb post:the_events_calendar_back_link]',
	),
) );
