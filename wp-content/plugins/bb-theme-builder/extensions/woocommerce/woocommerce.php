<?php

define( 'FL_THEME_BUILDER_WOOCOMMERCE_DIR', FL_THEME_BUILDER_DIR . 'extensions/woocommerce/' );
define( 'FL_THEME_BUILDER_WOOCOMMERCE_URL', FL_THEME_BUILDER_URL . 'extensions/woocommerce/' );

if ( class_exists( 'WooCommerce' ) ) {

	require_once FL_THEME_BUILDER_WOOCOMMERCE_DIR . 'classes/class-fl-theme-builder-woocommerce.php';
	require_once FL_THEME_BUILDER_WOOCOMMERCE_DIR . 'classes/class-fl-theme-builder-woocommerce-singular.php';
	require_once FL_THEME_BUILDER_WOOCOMMERCE_DIR . 'classes/class-fl-theme-builder-woocommerce-archive.php';

	add_action( 'fl_page_data_add_properties', function() {
		require_once FL_THEME_BUILDER_WOOCOMMERCE_DIR . 'classes/class-fl-page-data-woocommerce.php';
		require_once FL_THEME_BUILDER_WOOCOMMERCE_DIR . 'includes/page-data-woocommerce.php';
	} );
}
