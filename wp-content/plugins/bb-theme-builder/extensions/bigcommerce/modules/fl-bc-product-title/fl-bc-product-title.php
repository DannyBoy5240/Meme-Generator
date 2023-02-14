<?php

/**
 * @class FLBCProductTitleModule
 */
class FLBCProductTitleModule extends FLBuilderModule {

	/**
	 * @return void
	 */
	public function __construct() {
		parent::__construct( array(
			'name'            => __( 'Product Title', 'bb-theme-builder' ),
			'description'     => __( 'Displays the title for the current product.', 'bb-theme-builder' ),
			'group'           => __( 'Themer Modules', 'bb-theme-builder' ),
			'category'        => __( 'BigCommerce', 'bb-theme-builder' ),
			'partial_refresh' => true,
			'dir'             => FL_THEME_BUILDER_DIR . 'extensions/bigcommerce/modules/fl-bc-product-title/',
			'url'             => FL_THEME_BUILDER_URL . 'extensions/bigcommerce/modules/fl-bc-product-title/',
			'enabled'         => FLThemeBuilderLayoutData::current_post_is( 'singular' ),
		) );
	}
}

FLBuilder::register_module( 'FLBCProductTitleModule', array(
	'general' => array(
		'title'    => __( 'Style', 'bb-theme-builder' ),
		'sections' => array(
			'general' => array(
				'title'  => '',
				'fields' => array(
					'title_text'       => array(
						'type'    => 'typography',
						'label'   => __( 'Title Text', 'bb-theme-builder' ),
						'preview' => array(
							'type'     => 'css',
							'selector' => '.fl-module-content .bc-product__title',
						),
					),
					'title_text_color' => array(
						'type'       => 'color',
						'label'      => __( 'Title Text Color', 'bb-theme-builder' ),
						'show_reset' => true,
						'preview'    => array(
							'type'     => 'css',
							'selector' => '.fl-module-content .bc-product__title',
							'property' => 'color',
						),
					),
				),
			),
		),
	),
) );
