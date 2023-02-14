<?php

/**
 * Post module alias for post galleries on archive layouts.
 *
 * @since 1.0
 */
FLBuilder::register_module_alias( 'fl-post-gallery', array(
	'module'      => 'post-grid',
	'name'        => __( 'Post Gallery', 'bb-theme-builder' ),
	'description' => __( 'Displays a gallery grid of posts for the current archive.', 'bb-theme-builder' ),
	'group'       => __( 'Themer Modules', 'bb-theme-builder' ),
	'category'    => __( 'Archives', 'bb-theme-builder' ),
	'enabled'     => FLThemeBuilderLayoutData::current_post_is( 'archive' ),
	'settings'    => array(
		'layout'      => 'gallery',
		'data_source' => 'main_query',
	),
) );
