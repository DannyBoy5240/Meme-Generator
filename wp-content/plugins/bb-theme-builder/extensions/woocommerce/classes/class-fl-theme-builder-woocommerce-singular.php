<?php

/**
 * WooCommerce singular support for the theme builder.
 *
 * @since 1.0
 */
final class FLThemeBuilderWooCommerceSingular {

	/**
	 * @since 1.0
	 * @return void
	 */
	static public function init() {
		// Actions
		add_action( 'fl_theme_builder_before_render_content', __CLASS__ . '::before_render_content' );
		add_action( 'fl_theme_builder_after_render_content', __CLASS__ . '::after_render_content' );

		// Filters
		add_filter( 'fl_builder_render_css', __CLASS__ . '::render_css', 10, 4 );
		add_filter( 'body_class', __CLASS__ . '::body_class' );
		add_filter( 'fl_builder_content_classes', __CLASS__ . '::content_class' );
		add_filter( 'fl_builder_is_node_visible', __CLASS__ . '::set_node_visibility', 10, 2 );
		add_filter( 'fl_builder_content_classes', __CLASS__ . '::content_class', 10, 2 );
	}

	/**
	 * Renders custom CSS for singular WooCommerce pages.
	 *
	 * @since 1.0
	 * @param string $css
	 * @param array  $nodes
	 * @param object $settings
	 * @param bool   $global
	 * @return string
	 */
	static public function render_css( $css, $nodes, $settings, $global ) {
		if ( $global && 'product' == get_post_type() ) {
			$css .= file_get_contents( FL_THEME_BUILDER_WOOCOMMERCE_DIR . 'css/fl-theme-builder-woocommerce-singular.css' );
		}

		return $css;
	}

	/**
	 * Adds the WooCommerce body classes to theme layouts that are
	 * set to product locations.
	 *
	 * @since 1.0
	 * @param array $classes
	 * @return array
	 */
	static public function body_class( $classes ) {
		global $post;

		if ( is_singular() && 'fl-theme-layout' == get_post_type() ) {

			$locations   = FLThemeBuilderRulesLocation::get_saved( $post->ID );
			$locations[] = FLThemeBuilderRulesLocation::get_preview_location( $post->ID );
			$is_woo      = false;

			foreach ( $locations as $location ) {

				if ( strstr( $location, 'post:product' ) ) {
					$is_woo = true;
					break;
				} elseif ( strstr( $location, 'archive:product' ) ) {
					$is_woo = true;
					break;
				} elseif ( strstr( $location, 'taxonomy:product_cat' ) ) {
					$is_woo = true;
					break;
				} elseif ( strstr( $location, 'taxonomy:product_tag' ) ) {
					$is_woo = true;
					break;
				}
			}

			if ( $is_woo ) {
				$classes[] = 'woocommerce';
				$classes[] = 'woocommerce-page';
			}
		}

		return $classes;
	}

	/**
	 * Prints notices before a Woo layout and fires the
	 * before single product action.
	 *
	 * @since 1.0
	 * @param string $layout_id
	 * @return void
	 */
	static public function before_render_content( $layout_id ) {
		global $wp_the_query;

		if ( is_object( $wp_the_query->post ) && 'product' == $wp_the_query->post->post_type ) {
			$has_notices_module = self::layout_has_woo_notices_module( $layout_id );

			if ( ! $has_notices_module ) {
				echo self::get_woo_notices();

				if ( function_exists( 'is_product' ) && is_product() ) {
					do_action( 'woocommerce_before_single_product' );
				}
			}
		}
	}

	/**
	 * Checks if the Woo Notices module is instantiated on the Themer Layout.
	 *
	 * @since 1.4
	 * @param string $layout_id
	 * @return boolean
	 */
	static private function layout_has_woo_notices_module( $layout_id ) {
		$data = FLBuilderModel::get_layout_data( 'published', $layout_id );
		foreach ( $data as $node_id => $node ) {
			if ( 'module' === $node->type && 'fl-woo-notices' === $node->settings->type ) {
				return true;
			}
		}
		return false;
	}

	/**
	 * Woo Notices string.
	 *
	 * @since 1.4
	 * @return string
	 */
	static public function get_woo_notices() {
		$html = '';

		if ( wc_notice_count() > 0 ) {
			$html .= '<div class="fl-theme-builder-woo-notices fl-row fl-row-fixed-width">';
			$html .= wc_print_notices( true );
			$html .= '</div>';
		}

		return $html;
	}

	/**
	 * Adds the WooCommerce content class to theme layouts that are
	 * set to product locations.
	 *
	 * @since 1.0
	 * @param string $classes
	 * @param string $layout_type
	 * @return string
	 */
	static public function content_class( $classes, $layout_type = '' ) {
		if ( is_singular() && 'product' == get_post_type() && empty( $layout_type ) ) {
			$classes = join( ' ', wc_get_product_class( $classes ) );
		}

		return $classes;
	}

	/**
	 * Fires the after single product action.
	 *
	 * @since 1.0
	 * @param string $layout_id
	 * @return void
	 */
	static public function after_render_content( $layout_id ) {
		global $wp_the_query, $woocommerce;

		if ( is_object( $wp_the_query->post ) && 'product' == $wp_the_query->post->post_type ) {

			add_action( 'woocommerce_after_single_product', array( $woocommerce->structured_data, 'generate_product_data' ) );

			if ( function_exists( 'is_product' ) && is_product() ) {
				do_action( 'woocommerce_after_single_product' );
			}
		}
	}

	/**
	 * Set the node visibility for WooCommerce Singular Product Layout.
	 *
	 * @since 1.4
	 * @param bool $is_visible
	 * @param object $node
	 * @return bool
	 */
	static public function set_node_visibility( $is_visible, $node ) {
		// Hide Woo Notices Module if there's no Woocommerce notice/message available.
		if ( 'module' === $node->type && 'fl-woo-notices' === $node->slug ) {
			$is_visible = function_exists( 'wc_notice_count' ) && wc_notice_count() > 0;
		}

		return $is_visible;
	}

}

FLThemeBuilderWooCommerceSingular::init();
