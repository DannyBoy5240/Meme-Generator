<?php

define( 'FL_THEME_BUILDER_BIGCOMMERCE_DIR', FL_THEME_BUILDER_DIR . 'extensions/bigcommerce/' );
define( 'FL_THEME_BUILDER_BIGCOMMERCE_URL', FL_THEME_BUILDER_URL . 'extensions/bigcommerce/' );

if ( class_exists( 'BigCommerce\Plugin' ) ) {

	require_once FL_THEME_BUILDER_BIGCOMMERCE_DIR . 'classes/class-fl-theme-builder-bigcommerce.php';
	require_once FL_THEME_BUILDER_BIGCOMMERCE_DIR . 'classes/class-fl-theme-builder-bigcommerce-singular.php';
	require_once FL_THEME_BUILDER_BIGCOMMERCE_DIR . 'classes/class-fl-theme-builder-bigcommerce-archive.php';
	require_once FL_THEME_BUILDER_BIGCOMMERCE_DIR . 'classes/class-fl-theme-builder-bigcommerce-settings.php';

	add_action( 'fl_page_data_add_properties', function () {
		require_once FL_THEME_BUILDER_BIGCOMMERCE_DIR . 'classes/class-fl-page-data-bigcommerce.php';
		require_once FL_THEME_BUILDER_BIGCOMMERCE_DIR . 'includes/page-data-bigcommerce.php';
	} );
}
