<?php

class FLBCCartFormModule extends FLBuilderModule {
	public function __construct() {
		parent::__construct( array(
			'name'            => __( 'Add To Cart Form', 'bb-theme-builder' ),
			'description'     => __( 'Displays the quantity input and "Add To Cart" button for the current product.', 'bb-theme-builder' ),
			'group'           => __( 'Themer Modules', 'bb-theme-builder' ),
			'category'        => __( 'BigCommerce', 'bb-theme-builder' ),
			'partial_refresh' => true,
			'dir'             => FL_THEME_BUILDER_DIR . 'extensions/bigcommerce/modules/fl-bc-cart-form/',
			'url'             => FL_THEME_BUILDER_URL . 'extensions/bigcommerce/modules/fl-bc-cart-form/',
			'enabled'         => FLThemeBuilderLayoutData::current_post_is( 'singular' ),
		) );
	}
}

FLBuilder::register_module( 'FLBCCartFormModule',
	array(
		'general' => array(
			'title'    => __( 'Style', 'bb-theme-builder' ),
			'sections' => array(
				'align'       => array(
					'title'  => __( 'Cart Form Alignment', 'bb-theme-builder' ),
					'fields' => array(
						'cart_align' => array(
							'type'    => 'align',
							'label'   => 'Cart Form Align',
							'default' => 'left',
							'preview' => array(
								'type' => 'refresh',
							),
						),
					),
				),
				'cart_button' => array(
					'title'  => __( 'Add To Cart Button', 'bb-theme-builder' ),
					'help'   => __( 'Display Add to Cart button', 'bb-theme-builder' ),
					'fields' => FLThemeBuilderBigCommerceSettings::get( 'cart/button' ),
				),
				'cart_form'   => array(
					'title'  => __( 'Product Options Form', 'bb-theme-builder' ),
					'help'   => __( 'Display product options and variations for checkout', 'bb-theme-builder' ),
					'fields' => FLThemeBuilderBigCommerceSettings::get( 'cart/form' ),
				),
			),
		),
	)
);

