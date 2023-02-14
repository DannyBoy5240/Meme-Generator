<?php

/**
 * Handles logic for page data EDD properties.
 *
 * @since 1.1
 */
final class FLPageDataEDD {

	/**
	 * @since 1.1
	 * @return string
	 */
	static public function init() {
		FLPageData::add_group( 'edd', array(
			'label' => __( 'Easy Digital Downloads', 'bb-theme-builder' ),
		) );
	}

	/**
	 * @since 1.1
	 * @return string
	 */
	static public function get_product_title() {
		return get_the_title();
	}

	/**
	 * @since 1.1
	 * @return string
	 */
	static public function get_product_price() {
		$post_id = get_the_ID();

		if ( edd_is_free_download( $post_id ) ) {
			$price = __( 'Free', 'bb-theme-builder' );
		} elseif ( edd_has_variable_prices( $post_id ) ) {
			$low   = edd_currency_filter( edd_format_amount( edd_get_lowest_price_option( $post_id ) ) );
			$high  = edd_currency_filter( edd_format_amount( edd_get_highest_price_option( $post_id ) ) );
			$price = $low . ' &ndash; ' . $high;
		} else {
			$price = edd_currency_filter( edd_format_amount( edd_get_download_price( $post_id ) ) );
		}

		return $price;
	}

	/**
	 * @since 1.1
	 * @return string
	 */
	static public function get_product_content() {
		return apply_filters( 'edd_downloads_content', get_post_field( 'post_content', get_the_ID() ) );
	}

	/**
	 * @since 1.1
	 * @return string
	 */
	static public function get_product_short_description() {
		$excerpt_length = apply_filters( 'excerpt_length', 30 );
		$field          = has_excerpt() ? 'post_excerpt' : 'post_content';

		return apply_filters( 'edd_downloads_excerpt', wp_trim_words( get_post_field( $field, get_the_ID() ), $excerpt_length ) );
	}

	/**
	 * @since 1.1
	 * @return string
	 */
	static public function get_add_to_cart_button() {
		ob_start();
		edd_get_template_part( 'shortcode', 'content-cart-button' );
		return ob_get_clean();
	}

}

FLPageDataEDD::init();
