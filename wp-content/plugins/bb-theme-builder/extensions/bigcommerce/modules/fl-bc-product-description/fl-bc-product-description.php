<?php

/**
 * @since 1.0
 * @class FLBCProductDescriptionModule
 */
class FLBCProductDescriptionModule extends FLBuilderModule {

	/**
	 * @since 1.0
	 * @return void
	 */
	public function __construct() {
		parent::__construct( array(
			'name'            => __( 'Product Description', 'bb-theme-builder' ),
			'description'     => __( 'Displays the description for the current product.', 'bb-theme-builder' ),
			'group'           => __( 'Themer Modules', 'bb-theme-builder' ),
			'category'        => __( 'BigCommerce', 'bb-theme-builder' ),
			'partial_refresh' => true,
			'dir'             => FL_THEME_BUILDER_DIR . 'extensions/bigcommerce/modules/fl-bc-product-description/',
			'url'             => FL_THEME_BUILDER_URL . 'extensions/bigcommerce/modules/fl-bc-product-description/',
			'enabled'         => FLThemeBuilderLayoutData::current_post_is( 'singular' ),
		) );
	}
}

FLBuilder::register_module( 'FLBCProductDescriptionModule', array(
	'general' => array(
		'title'    => __( 'Style', 'bb-theme-builder' ),
		'sections' => array(
			'general' => array(
				'title'  => '',
				'fields' => array(
					'description_text'       => array(
						'type'       => 'typography',
						'label'      => __( 'Description Text', 'bb-theme-builder' ),
						'responsive' => true,
						'preview'    => array(
							'type'     => 'css',
							'selector' => '.fl-module-content .bc-product__description',
						),
					),
					'description_text_color' => array(
						'type'       => 'color',
						'label'      => __( 'Description Text Color', 'bb-theme-builder' ),
						'show_reset' => true,
						'preview'    => array(
							'type'     => 'css',
							'selector' => '.fl-module-content .bc-product__description',
							'property' => 'color',
						),
					),
				),
			),
		),
	),
) );
