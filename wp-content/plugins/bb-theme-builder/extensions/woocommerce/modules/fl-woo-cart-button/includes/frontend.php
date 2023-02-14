<?php
global $product;
$render_woo_cart      = true;
$button               = FLPageDataWooCommerce::get_add_to_cart_button();
$show_waitlist_button = true;
if ( class_exists( 'WC_Wishlists_Plugin' ) && ! empty( $button ) && ! empty( $product ) ) {
	include $module->dir . 'includes/wishlist-cart-button.php';
	$render_woo_cart = false;
} elseif ( $render_woo_cart ) {
	echo $button;
	$render_woo_cart = false;
}

// Render the Waitlist Button if Product Type is not 'grouped'.
if ( class_exists( 'WooCommerce_Waitlist_Plugin' ) && $show_waitlist_button ) {
	if ( ! ( empty( $product ) || $product->is_type( 'external' ) || $product->is_type( 'composite' ) || $product->is_type( 'variable' ) ) ) {
		echo do_shortcode( '[woocommerce_waitlist]' );
	}
}

if ( function_exists( 'YITH_YWRAQ_Frontend' ) ) {

	if ( ! empty( $product ) && 'yes' == get_option( 'ywraq_hide_add_to_cart' ) ) {
		YITH_YWRAQ_Frontend()->hide_add_to_cart_single();
	}

	if ( $render_woo_cart ) {
		echo $button;
		$render_woo_cart = false;
	}

	if ( is_object( $product ) ) {
		YITH_YWRAQ_Frontend()->add_button_single_page();
	}
}
