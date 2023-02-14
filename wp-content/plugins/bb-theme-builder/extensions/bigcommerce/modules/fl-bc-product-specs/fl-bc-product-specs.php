<?php

/**
 * @since 1.0
 * @class FLBCProductMetaModule
 */
class FLBCProductSpecsModule extends FLBuilderModule {

	/**
	 * @since 1.0
	 * @return void
	 */
	public function __construct() {
		parent::__construct( array(
			'name'            => __( 'Product Specs', 'bb-theme-builder' ),
			'description'     => __( 'Displays the specifications for the current product.', 'bb-theme-builder' ),
			'group'           => __( 'Themer Modules', 'bb-theme-builder' ),
			'category'        => __( 'BigCommerce', 'bb-theme-builder' ),
			'partial_refresh' => true,
			'dir'             => FL_THEME_BUILDER_DIR . 'extensions/bigcommerce/modules/fl-bc-product-specs/',
			'url'             => FL_THEME_BUILDER_URL . 'extensions/bigcommerce/modules/fl-bc-product-specs/',
			'enabled'         => FLThemeBuilderLayoutData::current_post_is( 'singular' ),
		) );
	}
}

FLBuilder::register_module( 'FLBCProductSpecsModule', array(
	'general' => array(
		'title'    => __( 'Style', 'bb-theme-builder' ),
		'sections' => array(
			'general'             => array(
				'title'  => '',
				'fields' => array(
					'align' => array(
						'type'    => 'align',
						'label'   => __( 'Alignment', 'bb-theme-builder' ),
						'default' => 'left',
						'preview' => array(
							'type'     => 'callback',
							'callback' => 'previewProductSpecsAlign',
						),
					),
				),
			),
			'product_specs_title' => array(
				'title'  => __( 'Section Title', 'bb-theme-builder' ),
				'fields' => array(
					'title_text'       => array(
						'type'    => 'typography',
						'label'   => __( 'Section Title Text', 'bb-theme-builder' ),
						'preview' => array(
							'type'     => 'css',
							'selector' => '.fl-module-content .bc-single-product__section-title',
						),
					),
					'title_text_color' => array(
						'type'       => 'color',
						'label'      => __( 'Section Title Text Color', 'bb-theme-builder' ),
						'show_reset' => true,
						'preview'    => array(
							'type'     => 'css',
							'selector' => '.fl-module-content .bc-single-product__section-title',
							'property' => 'color',
						),
					),
				),
			),
			'product_specs_list'  => array(
				'title'  => __( 'Product Specs List', 'bb-theme-builder' ),
				'fields' => array(
					'list_item_text'       => array(
						'type'    => 'typography',
						'label'   => __( 'List Item Text Color', 'bb-theme-builder' ),
						'preview' => array(
							'type'     => 'css',
							'selector' => '.fl-module-content .bc-product__spec-list',
						),
					),
					'list_item_text_color' => array(
						'type'       => 'color',
						'label'      => __( 'List Item Text Color', 'bb-theme-builder' ),
						'show_reset' => true,
						'preview'    => array(
							'type'     => 'css',
							'selector' => '.fl-module-content .bc-product__spec-list',
							'property' => 'color',
						),
					),
				),
			),
		),
	),
) );
