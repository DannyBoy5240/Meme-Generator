<?php

define( 'FL_THEME_BUILDER_WPML_DIR', FL_THEME_BUILDER_DIR . 'extensions/wpml/' );
define( 'FL_THEME_BUILDER_WPML_URL', FL_THEME_BUILDER_URL . 'extensions/wpml/' );

if ( defined( 'ICL_SITEPRESS_VERSION' ) ) {
	require_once FL_THEME_BUILDER_WPML_DIR . 'classes/class-fl-theme-builder-wpml.php';
}
