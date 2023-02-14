<?php

/**
 * @since 1.0
 * @class FLWooProductImagesModule
 */
class FLWooProductImagesModule extends FLBuilderModule {

	/**
	 * @since 1.0
	 * @return void
	 */
	public function __construct() {
		parent::__construct(array(
			'name'            => __( 'Product Images', 'bb-theme-builder' ),
			'description'     => __( 'Displays a gallery of images for the current product.', 'bb-theme-builder' ),
			'group'           => __( 'Themer Modules', 'bb-theme-builder' ),
			'category'        => __( 'WooCommerce', 'bb-theme-builder' ),
			'partial_refresh' => true,
			'dir'             => FL_THEME_BUILDER_DIR . 'extensions/woocommerce/modules/fl-woo-product-images/',
			'url'             => FL_THEME_BUILDER_URL . 'extensions/woocommerce/modules/fl-woo-product-images/',
			'enabled'         => FLThemeBuilderLayoutData::current_post_is( 'singular' ),
		));
	}

	/**
	 * @since 1.4.2
	 * @return string
	 */
	public function get_thumbnail_size() {
		if ( ! empty( $this->settings->thumb_size ) ) {
			return $this->settings->thumb_size;
		}

		$gallery_thumbnail = wc_get_image_size( 'gallery_thumbnail' );
		return array( $gallery_thumbnail['width'], $gallery_thumbnail['height'] );
	}
}

FLBuilder::register_module( 'FLWooProductImagesModule', array(
	'general' => array(
		'title'    => __( 'General', 'bb-theme-builder' ),
		'sections' => array(
			'general' => array(
				'title'  => '',
				'fields' => array(
					'sale_flash' => array(
						'type'    => 'select',
						'label'   => __( 'Sale Flash', 'bb-theme-builder' ),
						'default' => '1',
						'options' => array(
							'1' => __( 'Show', 'bb-theme-builder' ),
							'0' => __( 'Hide', 'bb-theme-builder' ),
						),
					),
					'thumb_size' => array(
						'type'    => 'photo-sizes',
						'label'   => __( 'Thumbnail Size', 'bb-theme-builder' ),
						'default' => 'woocommerce_gallery_thumbnail',
					),
				),
			),
		),
	),
) );
