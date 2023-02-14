<?php

define( 'FL_THEME_BUILDER_EDD_DIR', FL_THEME_BUILDER_DIR . 'extensions/edd/' );
define( 'FL_THEME_BUILDER_EDD_URL', FL_THEME_BUILDER_DIR . 'extensions/edd/' );

if ( class_exists( 'Easy_Digital_Downloads' ) ) {

	require_once FL_THEME_BUILDER_EDD_DIR . 'classes/class-fl-theme-builder-edd.php';
	require_once FL_THEME_BUILDER_EDD_DIR . 'classes/class-fl-theme-builder-edd-singular.php';
	require_once FL_THEME_BUILDER_EDD_DIR . 'classes/class-fl-theme-builder-edd-archive.php';

	add_action( 'fl_page_data_add_properties', function() {
		require_once FL_THEME_BUILDER_EDD_DIR . 'classes/class-fl-page-data-edd.php';
		require_once FL_THEME_BUILDER_EDD_DIR . 'includes/page-data-edd.php';
	} );
}
