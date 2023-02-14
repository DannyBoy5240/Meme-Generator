<?php
/**
 *
 * This file is to be called from frontend.php.
 * It handles the Add To Cart Form/Button rendering when the Wishlist Plugin is active.
 *
 */

global $wishlists;
$wishlist_button      = do_shortcode( '[wc_wishlists_button]' );
$add_to_cart_wishlist = str_replace( '</form>', $wishlist_button . '</form>', $button );


if ( 'grouped' !== $product->get_type() ) {

	// Simple Product
	if ( $product->is_type( 'simple' ) ) {

		ob_start();
		if ( $product->is_in_stock() ) {
			echo $add_to_cart_wishlist;
		} else {
			$wishlists->add_wishlist_form();
			echo $button;
		}
		echo ob_get_clean();

	} elseif ( $product->is_type( 'variable' ) ) {

		// Variable Product
		ob_start();
		if ( $product->is_in_stock() ) {
			echo $add_to_cart_wishlist;
		} else {
			$before_button = strstr( $button, '</button>', true );
			$after_button  = strstr( $button, '</button>' );

			echo $before_button . '</button>';
			$wishlists->add_to_wishlist_button();
			echo str_replace( '</button>', '', $after_button );
		}

		echo ob_get_clean();

	} else {

		echo $wishlist_button;

	}
} else {

	// Grouped Product
	ob_start();
	$before_form = strstr( $button, '</form>', true );
	echo $before_form;
	echo $wishlists->add_to_wishlist_button();
	echo '</form>';
	echo ob_get_clean();
	$show_waitlist_button = false;

}
