<?php

/**
 * Rich text module alias for the event cost.
 *
 * @since TBD
 */
FLBuilder::register_module_alias( 'fl-the-events-calendar-cost', array(
	'module'      => 'rich-text',
	'name'        => __( 'Event Cost', 'bb-theme-builder' ),
	'description' => __( 'Displays the cost for an event.', 'bb-theme-builder' ),
	'group'       => __( 'Themer Modules', 'bb-theme-builder' ),
	'category'    => __( 'The Events Calendar', 'bb-theme-builder' ),
	'enabled'     => FLThemeBuilderLayoutData::current_post_is( 'singular' ),
	'settings'    => array(
		'text' => '[wpbb post:the_events_calendar_cost show_currency="0"]',
	),
) );
