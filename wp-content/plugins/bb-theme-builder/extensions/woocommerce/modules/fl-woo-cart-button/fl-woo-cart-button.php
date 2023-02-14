<?php

/**
 * @since 1.0
 * @class FLWooCartButtonModule
 */
class FLWooCartButtonModule extends FLBuilderModule {

	/**
	 * @since 1.0
	 * @return void
	 */
	public function __construct() {
		parent::__construct(array(
			'name'            => __( 'Add to Cart Button', 'bb-theme-builder' ),
			'description'     => __( 'Displays the cart button for the current product.', 'bb-theme-builder' ),
			'group'           => __( 'Themer Modules', 'bb-theme-builder' ),
			'category'        => __( 'WooCommerce', 'bb-theme-builder' ),
			'partial_refresh' => true,
			'dir'             => FL_THEME_BUILDER_DIR . 'extensions/woocommerce/modules/fl-woo-cart-button/',
			'url'             => FL_THEME_BUILDER_URL . 'extensions/woocommerce/modules/fl-woo-cart-button/',
			'enabled'         => FLThemeBuilderLayoutData::current_post_is( 'singular' ),
		));
	}
}

FLBuilder::register_module( 'FLWooCartButtonModule', array(
	'general' => array(
		'title'    => __( 'Style', 'bb-theme-builder' ),
		'sections' => array(
			'general'            => array(
				'title'  => 'Text',
				'fields' => array(
					'text_color'       => array(
						'type'       => 'color',
						'label'      => __( 'Text Color', 'bb-theme-builder' ),
						'show_reset' => true,
						'preview'    => array(
							'type'      => 'css',
							'selector'  => 'button.button',
							'property'  => 'color',
							'important' => true,
						),
					),
					'text_color_hover' => array(
						'type'       => 'color',
						'label'      => __( 'Text Hover Color', 'bb-theme-builder' ),
						'show_reset' => true,
						'preview'    => array(
							'type'      => 'css',
							'selector'  => 'button.button:hover',
							'property'  => 'color',
							'important' => true,
						),
					),
				),
			),
			'background-section' => array(
				'title'  => 'Background',
				'fields' => array(
					'bg_color'       => array(
						'type'       => 'color',
						'label'      => __( 'Background Color', 'bb-theme-builder' ),
						'show_reset' => true,
						'preview'    => array(
							'type' => 'refresh',
						),
					),
					'bg_color_hover' => array(
						'type'       => 'color',
						'label'      => __( 'Background Hover Color', 'bb-theme-builder' ),
						'show_reset' => true,
						'preview'    => array(
							'type'      => 'css',
							'selector'  => 'button.button:hover',
							'property'  => 'background-color',
							'important' => true,
						),
					),
				),
			),
		),
	),
) );
