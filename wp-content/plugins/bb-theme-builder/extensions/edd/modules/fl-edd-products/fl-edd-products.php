<?php

/**
 * Post module alias for products on archive layouts.
 *
 * @since 1.1
 */
FLBuilder::register_module_alias( 'fl-edd-products', array(
	'module'      => 'post-grid',
	'name'        => __( 'Products', 'bb-theme-builder' ),
	'description' => __( 'Displays a grid of products for the current archive.', 'bb-theme-builder' ),
	'group'       => __( 'Themer Modules', 'bb-theme-builder' ),
	'category'    => __( 'Easy Digital Downloads', 'bb-theme-builder' ),
	'enabled'     => FLThemeBuilderLayoutData::current_post_is( 'archive' ),
	'settings'    => array(
		'layout'              => 'columns',
		'data_source'         => 'main_query',
		'show_author'         => '0',
		'show_date'           => '0',
		'show_more_link'      => '0',
		'edd_price'           => 'show',
		'edd_price_font_size' => '17',
		'edd_button'          => 'show',
	),
) );
