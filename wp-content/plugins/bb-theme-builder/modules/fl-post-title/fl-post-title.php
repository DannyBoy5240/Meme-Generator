<?php

/**
 * Heading module alias for the post title.
 *
 * @since 1.0
 */
FLBuilder::register_module_alias( 'fl-post-title', array(
	'module'      => 'heading',
	'name'        => __( 'Post Title', 'bb-theme-builder' ),
	'description' => __( 'Displays the title for the current post.', 'bb-theme-builder' ),
	'group'       => __( 'Themer Modules', 'bb-theme-builder' ),
	'category'    => __( 'Posts', 'bb-theme-builder' ),
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
