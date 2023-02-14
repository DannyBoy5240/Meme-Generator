<?php

define( 'FL_THEME_BUILDER_POLYLANG_DIR', FL_THEME_BUILDER_DIR . 'extensions/polylang/' );
define( 'FL_THEME_BUILDER_POLYLANG_URL', FL_THEME_BUILDER_URL . 'extensions/polylang/' );

if ( defined( 'POLYLANG_VERSION' ) ) {
	require_once POLYLANG_DIR . '/include/api.php';
	require_once FL_THEME_BUILDER_POLYLANG_DIR . 'classes/class-fl-theme-builder-polylang.php';
}
