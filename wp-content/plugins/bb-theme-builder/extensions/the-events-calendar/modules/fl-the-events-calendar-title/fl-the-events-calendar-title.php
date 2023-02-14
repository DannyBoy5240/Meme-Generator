<?php

/**
 * Heading module alias for the event title.
 *
 * @since TBD
 */
FLBuilder::register_module_alias( 'fl-the-events-calendar-title', array(
	'module'      => 'heading',
	'name'        => __( 'Event Title', 'bb-theme-builder' ),
	'description' => __( 'Displays the title for an event.', 'bb-theme-builder' ),
	'group'       => __( 'Themer Modules', 'bb-theme-builder' ),
	'category'    => __( 'The Events Calendar', 'bb-theme-builder' ),
	'enabled'     => FLThemeBuilderLayoutData::current_post_is( 'singular' ),
	'settings'    => array(
		'tag'         => 'h1',
		'connections' => array(
			'heading' => (object) array(
				'object'   => 'post',
				'property' => 'title',
				'field'    => 'text',
			),
		),
	),
) );
