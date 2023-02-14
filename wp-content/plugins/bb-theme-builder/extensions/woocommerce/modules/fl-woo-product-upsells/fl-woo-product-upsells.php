<?php

/**
 * @since 1.0
 * @class FLWooProductUpsellsModule
 */
class FLWooProductUpsellsModule extends FLBuilderModule {

	/**
	 * @since 1.0
	 * @return void
	 */
	public function __construct() {
		parent::__construct(array(
			'name'            => __( 'Product Upsells', 'bb-theme-builder' ),
			'description'     => __( 'Displays upsells for the current product.', 'bb-theme-builder' ),
			'group'           => __( 'Themer Modules', 'bb-theme-builder' ),
			'category'        => __( 'WooCommerce', 'bb-theme-builder' ),
			'partial_refresh' => true,
			'dir'             => FL_THEME_BUILDER_DIR . 'extensions/woocommerce/modules/fl-woo-product-upsells/',
			'url'             => FL_THEME_BUILDER_URL . 'extensions/woocommerce/modules/fl-woo-product-upsells/',
			'enabled'         => FLThemeBuilderLayoutData::current_post_is( 'singular' ),
		));
	}
}

FLBuilder::register_module( 'FLWooProductUpsellsModule', array(
	'general_tab' => array(
		'title'    => __( 'General', 'bb-theme-builder' ),
		'sections' => array(
			'general' => array(
				'title'  => '',
				'fields' => array(
					'show_add_to_cart' => array(
						'type'    => 'select',
						'label'   => __( 'Show Add To Cart Button(s)', 'bb-theme-builder' ),
						'default' => 'yes',
						'options' => array(
							'yes' => __( 'Yes', 'bb-theme-builder' ),
							'no'  => __( 'No', 'bb-theme-builder' ),
						),
					),
				),
			),
		),
	),
	'style_tab'   => array(
		'title'    => __( 'Style', 'bb-theme-builder' ),
		'sections' => array(
			'style' => array(
				'title'  => '',
				'fields' => array(
					'heading_text_color' => array(
						'type'       => 'color',
						'label'      => __( 'Heading Text Color', 'bb-theme-builder' ),
						'show_reset' => true,
						'preview'    => array(
							'type'     => 'css',
							'selector' => '.fl-module-content .upsells > h2',
							'property' => 'color',
						),
					),
					'heading_bg_color'   => array(
						'type'       => 'color',
						'label'      => __( 'Heading Background Color', 'bb-theme-builder' ),
						'show_reset' => true,
						'preview'    => array(
							'type'     => 'css',
							'selector' => '.fl-module-content .upsells > h2',
							'property' => 'background-color',
						),
					),
				),
			),
		),
	),
) );
