<?php

/**
 * Handles logic for page data WooCommerce properties.
 *
 * @since 1.0
 */
final class FLPageDataWooCommerce {

	/**
	 * @since 1.0
	 * @return string
	 */
	static public function init() {
		FLPageData::add_group( 'woocommerce', array(
			'label' => __( 'WooCommerce', 'bb-theme-builder' ),
		) );
	}

	/**
	 * @since 1.0
	 * @return string
	 */
	static public function get_template_html( $function ) {
		global $product;

		$html     = '';
		$function = apply_filters( "fl_theme_builder_woocommerce_template_html_$function", $function );

		if ( is_object( $product ) && function_exists( $function ) ) {
			ob_start();
			call_user_func( $function );
			$html = ob_get_clean();
		}

		if ( empty( $html ) && ! FLPageData::is_archive() && FLBuilderModel::is_builder_active() ) {
			$html .= '<div class="fl-builder-module-placeholder-message">';
			$html .= $function;
			$html .= '</div>';
		}

		return $html;
	}

	/**
	 * @since 1.0
	 * @return string
	 */
	static public function get_product_title() {
		return self::get_template_html( 'woocommerce_template_single_title' );
	}

	/**
	 * @since 1.0
	 * @return string
	 */
	static public function get_product_rating() {
		$html = '';

		if ( FLPageData::is_archive() ) {
			$html = self::get_template_html( 'woocommerce_template_loop_rating' );
		} else {
			$html = self::get_template_html( 'woocommerce_template_single_rating' );
		}

		return $html;
	}

	/**
	 * @since 1.0
	 * @return string
	 */
	static public function get_product_price() {
		$html = '';

		if ( FLPageData::is_archive() ) {
			$html = self::get_template_html( 'woocommerce_template_loop_price' );
		} else {
			$html = self::get_template_html( 'woocommerce_template_single_price' );
		}

		return $html;
	}

	/**
	 * @since TDB
	 * @return string
	 */
	static public function get_product_description() {
		global $post, $wp_the_query;

		if ( empty( $post ) ) {
			return '';
		}

		$prod_description  = '';
		$show_place_holder = is_object( $wp_the_query->post ) && 'fl-theme-layout' === $wp_the_query->post->post_type && $post->ID === $wp_the_query->post->ID;

		if ( $show_place_holder ) {
			$prod_description = sprintf( '<div class="fl-builder-module-placeholder-message">%s</div>', __( 'Woocommerce Product Description', 'bb-theme-builder' ) );
		} else {
			$prod_description = FLPageDataPost::get_content();
		}
		return $prod_description;
	}

	/**
	 * @since 1.0
	 * @return string
	 */
	static public function get_product_short_description() {
		return self::get_template_html( 'woocommerce_template_single_excerpt' );
	}

	/**
	 * @since 1.0
	 * @return string
	 */
	static public function get_add_to_cart_button() {
		$html = '';

		if ( FLPageData::is_archive() || is_search() ) {
			$html = self::get_template_html( 'woocommerce_template_loop_add_to_cart' );
		} else {
			$html = self::get_template_html( 'woocommerce_template_single_add_to_cart' );
		}

		return $html;
	}

	/**
	 * @since 1.0
	 * @return string
	 */
	static public function get_product_meta() {
		return self::get_template_html( 'woocommerce_template_single_meta' );
	}

	/**
	 * @since 1.3.3
	 * @return string
	 */
	static public function get_product_weight( $settings ) {
		global $product;
		$html = '';

		if ( is_object( $product ) ) {
			if ( $product->has_weight() ) {
				$weight_unit = get_option( 'woocommerce_weight_unit' );

				$html = '<div class="product_meta"><span class="weight_wrapper">';
				if ( 'yes' === $settings->show_prefix ) {
					$html .= '<span class="weight_prefix">' . $settings->prefix . '</span>';
				}
				$html .= '<span class="weight">' . $product->get_weight() . ' ' . $weight_unit . '</span>';
				$html .= '</span></div>';
			}
		}

		return $html;
	}

	/**
	 * @since 1.2.1
	 * @return string
	 */
	static public function get_product_sku( $settings ) {

		global $product;

		if ( is_object( $product ) ) {
			$html = '';

			if ( wc_product_sku_enabled() && ( $product->get_sku() || $product->is_type( 'variable' ) ) ) :

				$html = '<div class="product_meta"><span class="sku_wrapper">';
				if ( '1' == $settings->sku_prefix ) {
					$html .= $settings->prefix_text;
				}
				$html .= '<span class="sku">' . $product->get_sku() . '</span>';
				$html .= '</span></div>';

				return $html;

			endif;
		}
	}

	/**
	 * @since 1.0
	 * @return string
	 */
	static public function get_product_images() {
		$html = '';

		if ( is_singular() ) {
			$html = self::get_template_html( 'woocommerce_show_product_images' );
		}

		return $html;
	}

	/**
	 * @since 1.0
	 * @return string
	 */
	static public function get_sale_flash() {
		$html = '';

		if ( FLPageData::is_archive() ) {
			$html = self::get_template_html( 'woocommerce_show_product_loop_sale_flash' );
		} else {
			$html = self::get_template_html( 'woocommerce_show_product_sale_flash' );
		}

		return $html;
	}

	/**
	 * @since 1.0
	 * @return string
	 */
	static public function get_product_tabs() {
		global $wp_the_query;
		$is_content_building_enabled = FLThemeBuilderFrontendEdit::is_content_building_enabled();
		$is_page_builder_enabled     = FLBuilderModel::is_builder_enabled();
		$post_type                   = empty( $wp_the_query->query_vars['post_type'] ) ? '' : $wp_the_query->query_vars['post_type'];
		$is_editing_themer_layout    = 'fl-theme-layout' === $post_type;

		// Hide WooCommerce Addition Information Tab when viewing a Themer Singular Layout page.
		if ( $is_page_builder_enabled && $is_editing_themer_layout ) {
			add_filter( 'woocommerce_product_tabs', function( $tabs ) {
				if ( ! empty( $tabs['additional_information'] ) ) {
					$tabs['additional_information']['callback'] = '__return_empty_string';
				}
				return $tabs;
			});
		}

		if ( $is_content_building_enabled ) {
			add_filter( 'the_content', 'FLPageDataPost::get_content' );
		}

		$html = self::get_template_html( 'woocommerce_output_product_data_tabs' );

		if ( $is_content_building_enabled ) {
			remove_filter( 'the_content', 'FLPageDataPost::get_content' );
		}

		return $html;
	}

	/**
	 * @since 1.0
	 * @return string
	 */
	static public function get_product_upsells() {
		return self::get_template_html( 'woocommerce_upsell_display' );
	}

	/**
	 * @since 1.0
	 * @return string
	 */
	static public function get_related_products() {
		return self::get_template_html( 'woocommerce_output_related_products' );
	}

	/**
	 * @since 1.0
	 * @return string
	 */
	static public function get_breadcrumb() {
		return self::get_template_html( 'woocommerce_breadcrumb' );
	}

	/**
	 * @since 1.0
	 * @return string
	 */
	static public function get_category_image_url() {
		global $wp_query;

		if ( is_product_category() ) {

			$category = $wp_query->get_queried_object();
			$image_id = get_term_meta( $category->term_id, 'thumbnail_id', true );
			$image    = wp_get_attachment_url( $image_id );

			if ( $image ) {
				return array(
					'id'  => $image_id,
					'url' => $image,
				);
			}
		}

		return '';
	}

	/**
	 * @since 1.0
	 * @return string
	 */
	static public function get_result_count() {
		return self::get_template_html( 'woocommerce_result_count' );
	}

	/**
	 * @since 1.0
	 * @return string
	 */
	static public function get_catalog_ordering() {
		return self::get_template_html( 'woocommerce_catalog_ordering' );
	}

	static public function get_product_attached_images() {
		global $product;
		return null !== $product ? $product->get_gallery_image_ids() : false;
	}
}

FLPageDataWooCommerce::init();
