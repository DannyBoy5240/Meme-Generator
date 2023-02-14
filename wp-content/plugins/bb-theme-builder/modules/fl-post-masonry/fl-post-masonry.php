<?php

/**
 * Post module alias for post masonry grids on archive layouts.
 *
 * @since 1.0
 */
FLBuilder::register_module_alias( 'fl-post-masonry', array(
	'module'      => 'post-grid',
	'name'        => __( 'Post Masonry', 'bb-theme-builder' ),
	'description' => __( 'Displays a masonry grid of posts for the current archive.', 'bb-theme-builder' ),
	'group'       => __( 'Themer Modules', 'bb-theme-builder' ),
	'category'    => __( 'Archives', 'bb-theme-builder' ),
	'enabled'     => FLThemeBuilderLayoutData::current_post_is( 'archive' ),
	'settings'    => array(
		'layout'       => 'grid',
		'match_height' => '1',
		'data_source'  => 'main_query',
	),
) );
