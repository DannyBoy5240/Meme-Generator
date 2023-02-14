<?php

/**
 * @class FLBCProductPriceModule
 */
class FLBCProductPriceModule extends FLBuilderModule {

	/**
	 * @return void
	 */
	public function __construct() {
		parent::__construct( array(
			'name'            => __( 'Product Price', 'bb-theme-builder' ),
			'description'     => __( 'Displays the price for the current product.', 'bb-theme-builder' ),
			'group'           => __( 'Themer Modules', 'bb-theme-builder' ),
			'category'        => __( 'BigCommerce', 'bb-theme-builder' ),
			'partial_refresh' => true,
			'dir'             => FL_THEME_BUILDER_DIR . 'extensions/bigcommerce/modules/fl-bc-product-price/',
			'url'             => FL_THEME_BUILDER_URL . 'extensions/bigcommerce/modules/fl-bc-product-price/',
			'enabled'         => FLThemeBuilderLayoutData::current_post_is( 'singular' ),
		) );
	}
}

FLBuilder::register_module( 'FLBCProductPriceModule', array(
	'general' => array(
		'title'    => __( 'Style', 'bb-theme-builder' ),
		'sections' => array(
			'general'        => array(
				'title'  => '',
				'fields' => array(
					'align' => array(
						'type'    => 'select',
						'label'   => __( 'Alignment', 'bb-theme-builder' ),
						'default' => 'left',
						'options' => array(
							'left'   => __( 'Left', 'bb-theme-builder' ),
							'center' => __( 'Center', 'bb-theme-builder' ),
							'right'  => __( 'Right', 'bb-theme-builder' ),
						),
						'preview' => array(
							'type'     => 'css',
							'selector' => '.fl-module-content',
							'property' => 'text-align',
						),
					),
				),
			),
			'original_price' => array(
				'title'  => __( 'Original Price', 'bb-theme-builder' ),
				'help'   => __( 'Product base price before discounts', 'bb-theme-builder' ),
				'fields' => FLThemeBuilderBigCommerceSettings::get( 'price/original' ),
			),
			'sale_price'     => array(
				'title'  => __( 'Sale Price', 'bb-theme-builder' ),
				'fields' => FLThemeBuilderBigCommerceSettings::get( 'price/sale' ),
			),
		),
	),

) );
