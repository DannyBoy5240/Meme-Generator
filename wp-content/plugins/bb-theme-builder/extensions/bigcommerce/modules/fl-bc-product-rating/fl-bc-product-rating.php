<?php

/**
 * @since 1.0
 * @class FLBCProductRatingModule
 */
class FLBCProductRatingModule extends FLBuilderModule {

	/**
	 * @since 1.0
	 * @return void
	 */
	public function __construct() {
		parent::__construct( array(
			'name'            => __( 'Product Rating', 'bb-theme-builder' ),
			'description'     => __( 'Displays the star rating for the current product.', 'bb-theme-builder' ),
			'group'           => __( 'Themer Modules', 'bb-theme-builder' ),
			'category'        => __( 'BigCommerce', 'bb-theme-builder' ),
			'partial_refresh' => true,
			'dir'             => FL_THEME_BUILDER_DIR . 'extensions/bigcommerce/modules/fl-bc-product-rating/',
			'url'             => FL_THEME_BUILDER_URL . 'extensions/bigcommerce/modules/fl-bc-product-rating/',
			'enabled'         => FLThemeBuilderLayoutData::current_post_is( 'singular' ),
		) );
	}
}

FLBuilder::register_module( 'FLBCProductRatingModule', array(
	'general' => array(
		'title'    => __( 'Style', 'bb-theme-builder' ),
		'help'     => __( 'Customize how product ratings are displayed', 'bb-theme-builder' ),
		'sections' => FLThemeBuilderBigCommerceSettings::get( 'ratings' ),
	),
) );
