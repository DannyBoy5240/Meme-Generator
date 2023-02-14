<?php
/**
 * Post module alias for products on archive layouts.
 *
 * @since 1.0
 */
FLBuilder::register_module_alias( 'fl-bc-products-grid', array(
	'module'      => 'post-grid',
	'name'        => __( 'Products', 'bb-theme-builder' ),
	'description' => __( 'Displays a grid of products for the current archive.', 'bb-theme-builder' ),
	'group'       => __( 'Themer Modules', 'bb-theme-builder' ),
	'category'    => __( 'BigCommerce', 'bb-theme-builder' ),
	'enabled'     => FLThemeBuilderLayoutData::current_post_is( 'archive' ),
	'settings'    => array(
		'layout'       => 'columns',
		'match_height' => '1',
		'data_source'  => 'main_query',
		'post_align'   => 'center',
		'show_author'  => '0',
		'show_date'    => '0',
		'show_content' => '0',
	),
) );
