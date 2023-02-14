<?php

/**
 * @since 1.1
 * @class FLEDDCartButtonModule
 */
class FLEDDCartButtonModule extends FLBuilderModule {

	/**
	 * @since 1.1
	 * @return void
	 */
	public function __construct() {
		parent::__construct(array(
			'name'            => __( 'Add to Cart Button', 'bb-theme-builder' ),
			'description'     => __( 'Displays the cart button for the current download.', 'bb-theme-builder' ),
			'group'           => __( 'Themer Modules', 'bb-theme-builder' ),
			'category'        => __( 'Easy Digital Downloads', 'bb-theme-builder' ),
			'partial_refresh' => true,
			'dir'             => FL_THEME_BUILDER_DIR . 'extensions/edd/modules/fl-edd-cart-button/',
			'url'             => FL_THEME_BUILDER_URL . 'extensions/edd/modules/fl-edd-cart-button/',
			'enabled'         => FLThemeBuilderLayoutData::current_post_is( 'singular' ),
		));
	}
}

FLBuilder::register_module( 'FLEDDCartButtonModule', array(
	'general' => array(
		'title'    => __( 'Style', 'bb-theme-builder' ),
		'sections' => array(
			'general' => array(
				'title'  => '',
				'fields' => array(
					'bg_color'   => array(
						'type'       => 'color',
						'label'      => __( 'Background Color', 'bb-theme-builder' ),
						'show_reset' => true,
					),
					'text_color' => array(
						'type'       => 'color',
						'label'      => __( 'Text Color', 'bb-theme-builder' ),
						'show_reset' => true,
						'preview'    => array(
							'type'     => 'css',
							'selector' => '.fl-module-content .edd-submit',
							'property' => 'color',
						),
					),
				),
			),
		),
	),
) );
