<?php

/**
 * @class FLBCRelatedProductsModule
 */
class FLBCRelatedProductsModule extends FLBuilderModule {

	/**
	 * @return void
	 */
	public function __construct() {
		parent::__construct( array(
			'name'            => __( 'Related Products', 'bb-theme-builder' ),
			'description'     => __( 'Displays related products for the current product.', 'bb-theme-builder' ),
			'group'           => __( 'Themer Modules', 'bb-theme-builder' ),
			'category'        => __( 'BigCommerce', 'bb-theme-builder' ),
			'partial_refresh' => true,
			'dir'             => FL_THEME_BUILDER_DIR . 'extensions/bigcommerce/modules/fl-bc-related-products/',
			'url'             => FL_THEME_BUILDER_URL . 'extensions/bigcommerce/modules/fl-bc-related-products/',
			'enabled'         => FLThemeBuilderLayoutData::current_post_is( 'singular' ),
		) );
	}
}

FLBuilder::register_module( 'FLBCRelatedProductsModule', array(
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
			'section_title'  => array(
				'title'  => __( 'Section Title', 'bb-theme-builder' ),
				'fields' => array(
					'bc_related_products_section_title' => array(
						'type'       => 'typography',
						'label'      => __( 'Title Text', 'bb-theme-builder' ),
						'responsive' => true,
						'preview'    => array(
							'type'     => 'css',
							'selector' => '.fl-module-content .bc-single-product__section-title--related',
						),
					),
					'bc_related_products_section_title_color' => array(
						'type'    => 'color',
						'label'   => __( 'Title Color', 'bb-theme-builder' ),
						'preview' => array(
							'type'     => 'css',
							'selector' => '.fl-module-content .bc-single-product__section-title--related',
							'property' => 'color',
						),
					),

				),
			),
			'sale_badge'     => array(
				'title'  => __( 'Sale Badge', 'bb-theme-builder' ),
				'fields' => FLThemeBuilderBigCommerceSettings::get( 'sale-badge' ),
			),
			'product_title'  => array(
				'title'  => __( 'Product Title', 'bb-theme-builder' ),
				'fields' => array(
					'bc_related_products_title'       => array(
						'type'       => 'typography',
						'label'      => __( 'Title Text', 'bb-theme-builder' ),
						'responsive' => true,
						'preview'    => array(
							'type'     => 'css',
							'selector' => '.fl-module-content .bc-product__title-link',
						),
					),
					'bc_related_products_title_color' => array(
						'type'    => 'color',
						'label'   => __( 'Title Color', 'bb-theme-builder' ),
						'preview' => array(
							'type'     => 'css',
							'selector' => '.fl-module-content .bc-product__title-link',
							'property' => 'color',
						),
					),
				),

			),
			'product_button' => array(
				'title'  => __( 'Add To Cart Button', 'bb-theme-builder' ),
				'fields' => FLThemeBuilderBigCommerceSettings::get( 'cart/button' ),
			),
		),
	),
) );
