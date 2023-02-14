<?php

/**
 * @since 1.1
 * @class FLEDDProductDescriptionModule
 */
class FLEDDProductDescriptionModule extends FLBuilderModule {

	/**
	 * @since 1.1
	 * @return void
	 */
	public function __construct() {
		parent::__construct(array(
			'name'            => __( 'Product Description', 'bb-theme-builder' ),
			'description'     => __( 'Displays the description for the current product.', 'bb-theme-builder' ),
			'group'           => __( 'Themer Modules', 'bb-theme-builder' ),
			'category'        => __( 'Easy Digital Downloads', 'bb-theme-builder' ),
			'partial_refresh' => true,
			'dir'             => FL_THEME_BUILDER_DIR . 'extensions/edd/modules/fl-edd-product-description/',
			'url'             => FL_THEME_BUILDER_URL . 'extensions/edd/modules/fl-edd-product-description/',
			'enabled'         => FLThemeBuilderLayoutData::current_post_is( 'singular' ),
		));
	}
}

FLBuilder::register_module( 'FLEDDProductDescriptionModule', array(
	'general' => array(
		'title'    => __( 'Style', 'bb-theme-builder' ),
		'sections' => array(
			'general' => array(
				'title'  => '',
				'fields' => array(
					'description_type' => array(
						'type'    => 'select',
						'label'   => __( 'Type', 'bb-theme-builder' ),
						'default' => 'short',
						'options' => array(
							'short' => __( 'Short Description', 'bb-theme-builder' ),
							'full'  => __( 'Full Description', 'bb-theme-builder' ),
						),
					),
				),
			),
		),
	),
) );
