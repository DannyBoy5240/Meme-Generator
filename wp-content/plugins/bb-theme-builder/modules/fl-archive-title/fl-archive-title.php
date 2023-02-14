<?php

/**
 * Heading module alias for the archive title.
 *
 * @since 1.0
 */
FLBuilder::register_module_alias( 'fl-archive-title', array(
	'module'      => 'heading',
	'name'        => __( 'Archive Title', 'bb-theme-builder' ),
	'description' => __( 'Displays the title for the current archive.', 'bb-theme-builder' ),
	'group'       => __( 'Themer Modules', 'bb-theme-builder' ),
	'category'    => __( 'Archives', 'bb-theme-builder' ),
	'enabled'     => FLThemeBuilderLayoutData::current_post_is( 'archive' ),
	'settings'    => array(
		'tag'         => 'h1',
		'connections' => array(
			'heading' => (object) array(
				'object'   => 'archive',
				'property' => 'title',
				'field'    => 'text',
			),
		),
	),
) );
