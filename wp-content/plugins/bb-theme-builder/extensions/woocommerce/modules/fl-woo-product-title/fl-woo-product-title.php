<?php

/**
 * @since 1.0
 * @class FLWooProductTitleModule
 */
class FLWooProductTitleModule extends FLBuilderModule {

	/**
	 * @since 1.0
	 * @return void
	 */
	public function __construct() {
		parent::__construct(array(
			'name'            => __( 'Product Title', 'bb-theme-builder' ),
			'description'     => __( 'Displays the title for the current product.', 'bb-theme-builder' ),
			'group'           => __( 'Themer Modules', 'bb-theme-builder' ),
			'category'        => __( 'WooCommerce', 'bb-theme-builder' ),
			'partial_refresh' => true,
			'dir'             => FL_THEME_BUILDER_DIR . 'extensions/woocommerce/modules/fl-woo-product-title/',
			'url'             => FL_THEME_BUILDER_URL . 'extensions/woocommerce/modules/fl-woo-product-title/',
			'enabled'         => FLThemeBuilderLayoutData::current_post_is( 'singular' ),
		));
	}
}

FLBuilder::register_module( 'FLWooProductTitleModule', array(
	'general' => array(
		'title'    => __( 'Style', 'bb-theme-builder' ),
		'sections' => array(
			'general' => array(
				'title'  => '',
				'fields' => array(
					'align'      => array(
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
					'font'       => array(
						'type'    => 'font',
						'default' => array(
							'family' => 'Default',
							'weight' => 300,
						),
						'label'   => __( 'Font', 'bb-theme-builder' ),
						'preview' => array(
							'type'     => 'font',
							'selector' => '.fl-module-content .product_title',
						),
					),
					'font_size'  => array(
						'type'        => 'text',
						'label'       => __( 'Font Size', 'bb-theme-builder' ),
						'default'     => '',
						'size'        => '5',
						'description' => 'px',
						'preview'     => array(
							'type'     => 'css',
							'selector' => '.fl-module-content .product_title',
							'property' => 'font-size',
							'unit'     => 'px',
						),
					),
					'text_color' => array(
						'type'       => 'color',
						'label'      => __( 'Text Color', 'bb-theme-builder' ),
						'show_reset' => true,
						'preview'    => array(
							'type'     => 'css',
							'selector' => '.fl-module-content .product_title',
							'property' => 'color',
						),
					),
				),
			),
		),
	),
) );
