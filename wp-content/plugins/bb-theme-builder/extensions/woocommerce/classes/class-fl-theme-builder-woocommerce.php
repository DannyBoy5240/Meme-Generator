<?php

/**
 * WooCommerce support for the theme builder.
 *
 * @since 1.0
 */
final class FLThemeBuilderWooCommerce {

	/**
	 * @since 1.0
	 * @return void
	 */
	static public function init() {
		// As of WooCommerce 3.3.3, if we don't have this, things break.
		add_theme_support( 'woocommerce' );

		// Actions
		add_action( 'wp', __CLASS__ . '::load_modules', 1 );

		// Filters
		add_filter( 'fl_get_wp_widgets_exclude', __CLASS__ . '::filter_wp_widgets_exclude' );

		add_filter( 'fl_builder_loop_query_args', __CLASS__ . '::filter_visibility' );
	}

	/**
	 * Loads the WooCommerce modules.
	 *
	 * @since 1.0
	 * @return void
	 */
	static public function load_modules() {
		FLThemeBuilderLoader::load_modules( FL_THEME_BUILDER_WOOCOMMERCE_DIR . 'modules' );
	}

	/**
	 * Filter out the widgets from the BB content panel
	 * as it must be added to a sidebar to work.
	 *
	 * @since 1.1.1
	 * @param array $exclude
	 * @return array
	 */
	static public function filter_wp_widgets_exclude( $exclude ) {
		$exclude[] = 'WC_Widget_Recently_Viewed';
		return $exclude;
	}

	static public function filter_visibility( $args ) {
		$settings  = $args['settings'];
		$post_type = isset( $settings->post_type ) ? $settings->post_type : false;
		$filter    = false;

		// make sure its a product type.
		if ( is_string( $post_type ) && 'product' === $post_type ) {
			$filter = true;
		}
		// 2.6 this can be an array
		if ( is_array( $post_type ) && in_array( 'product', $post_type ) ) {
			$filter = true;
		}
		if ( $filter && isset( $settings->woo_visible ) && 'hide' === $settings->woo_visible ) {
			$args['tax_query'][] = array(
				array(
					'taxonomy' => 'product_visibility',
					'field'    => 'name',
					'terms'    => 'exclude-from-catalog',
					'operator' => 'NOT IN',
				),
			);
		}
		return $args;
	}
}

FLThemeBuilderWooCommerce::init();
