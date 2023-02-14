<?php

/**
 * Gallery module alias for images attached to a post.
 *
 * @since 1.0
 */
FLBuilder::register_module_alias( 'fl-attached-images', array(
	'module'      => 'gallery',
	'name'        => __( 'Attached Images', 'bb-theme-builder' ),
	'description' => __( 'Displays a gallery of images attached to the current post.', 'bb-theme-builder' ),
	'group'       => __( 'Themer Modules', 'bb-theme-builder' ),
	'category'    => __( 'Posts', 'bb-theme-builder' ),
	'enabled'     => FLThemeBuilderLayoutData::current_post_is( 'singular' ),
	'settings'    => array(
		'connections' => array(
			'photos' => (object) array(
				'object'   => 'post',
				'property' => 'attached_images',
				'field'    => 'multiple-photos',
			),
		),
	),
) );
