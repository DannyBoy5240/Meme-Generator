<?php

/**
 * @since 1.0
 * @class FLBCProductImagesModule
 */
class FLBCProductImagesModule extends FLBuilderModule {

	/**
	 * @since 1.0
	 * @return void
	 */
	public function __construct() {
		parent::__construct( array(
			'name'            => __( 'Product Images', 'bb-theme-builder' ),
			'description'     => __( 'Displays a gallery of images for the current product.', 'bb-theme-builder' ),
			'group'           => __( 'Themer Modules', 'bb-theme-builder' ),
			'category'        => __( 'BigCommerce', 'bb-theme-builder' ),
			'partial_refresh' => true,
			'dir'             => FL_THEME_BUILDER_DIR . 'extensions/bigcommerce/modules/fl-bc-product-images/',
			'url'             => FL_THEME_BUILDER_URL . 'extensions/bigcommerce/modules/fl-bc-product-images/',
			'enabled'         => FLThemeBuilderLayoutData::current_post_is( 'singular' ),
		) );
	}
}

FLBuilder::register_module( 'FLBCProductImagesModule', array(
	'general' => array(
		'title'    => __( 'Style', 'bb-theme-builder' ),
		'sections' => array(
			'sale_flash' => array(
				'title'  => __( 'Sale Badge', 'bb-theme-builder' ),
				'help'   => __( 'Display "On Sale" badge above product image', 'bb-theme-builder' ),
				'fields' => FLThemeBuilderBigCommerceSettings::get( 'sale-badge' ),
			),
		),
	),
) );
