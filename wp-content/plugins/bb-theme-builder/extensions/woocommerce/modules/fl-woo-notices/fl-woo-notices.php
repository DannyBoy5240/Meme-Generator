<?php

/**
 * @since 1.4
 * @class FLWooNoticesModule
 */
class FLWooNoticesModule extends FLBuilderModule {

	/**
	 * @since 1.4
	 * @return void
	 */
	public function __construct() {
		parent::__construct(array(
			'name'            => __( 'Woo Notices', 'bb-theme-builder' ),
			'description'     => __( 'Displays the WooCommerce Notices.', 'bb-theme-builder' ),
			'group'           => __( 'Themer Modules', 'bb-theme-builder' ),
			'category'        => __( 'WooCommerce', 'bb-theme-builder' ),
			'partial_refresh' => true,
			'dir'             => FL_THEME_BUILDER_DIR . 'extensions/woocommerce/modules/fl-woo-notices/',
			'url'             => FL_THEME_BUILDER_URL . 'extensions/woocommerce/modules/fl-woo-notices/',
			'enabled'         => FLThemeBuilderLayoutData::current_post_is( array( 'singular' ) ),
		));
	}
}

FLBuilder::register_module( 'FLWooNoticesModule', array(
	'general' => array(
		'title'    => __( 'Style', 'bb-theme-builder' ),
		'sections' => array(
			'general' => array(
				'title'  => '',
				'fields' => array(
					'text_color'             => array(
						'type'       => 'color',
						'label'      => __( 'Text Color', 'bb-theme-builder' ),
						'show_reset' => true,
						'preview'    => false,
					),
					'woo_notices_bg_color'   => array(
						'type'       => 'color',
						'label'      => __( 'Background Color', 'bb-theme-builder' ),
						'default'    => '',
						'show_reset' => true,
						'show_alpha' => true,
					),
					'woo_notices_border'     => array(
						'type'       => 'border',
						'label'      => 'Border',
						'responsive' => true,
						'preview'    => false,
					),
					'woo_notices_typography' => array(
						'type'       => 'typography',
						'label'      => 'Typography',
						'responsive' => true,
						'preview'    => false,
					),
				),
			),
		),
	),
) );
