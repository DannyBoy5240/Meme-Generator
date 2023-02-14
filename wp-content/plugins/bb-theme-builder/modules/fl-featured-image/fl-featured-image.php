<?php

/**
 * Photo module alias for the featured image.
 *
 * @since 1.0
 */
FLBuilder::register_module_alias( 'fl-featured-image', array(
	'module'      => 'photo',
	'name'        => __( 'Featured Image', 'bb-theme-builder' ),
	'description' => __( 'Displays the featured image for the current post.', 'bb-theme-builder' ),
	'group'       => __( 'Themer Modules', 'bb-theme-builder' ),
	'category'    => __( 'Posts', 'bb-theme-builder' ),
	'enabled'     => FLThemeBuilderLayoutData::current_post_is( 'singular' ),
	'settings'    => array(
		'connections' => array(
			'photo' => (object) array(
				'object'   => 'post',
				'property' => 'featured_image_url',
				'field'    => 'photo',
				'settings' => (object) array(
					'size' => 'large',
				),
			),
		),
	),
) );
