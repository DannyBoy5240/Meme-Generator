<?php
/**
 * Plugin Name: TA Custom BB Modules
 * Plugin URI: http://www.floatleft.org
 * Description: Custom beaver builder modules for the Tides Advocacy site
 * Version: 1.0
 * Author: Floatleft, Courtney Miller
 * Author URI: http://www.floatleft.org
 */
define( 'TA_MODULES_DIR', plugin_dir_path( __FILE__ ) );
define( 'TA_MODULES_URL', plugins_url( '/', __FILE__ ) );

/**
 * Custom modules
 */
function fl_load_ta_modules() {
	if ( class_exists( 'FLBuilder' ) ) {
        require_once 'quote/quote.php';
        require_once 'header/header.php';
        require_once 'grid-item/grid-item.php';
        require_once 'text/text.php';
        require_once 'ta-button/ta-button.php';
        require_once 'ta-post-grid/ta-post-grid.php';
        require_once 'ta-post-slider/ta-post-slider.php';
        //require_once 'ccsf-posts/ccsf-posts.php';
        //require_once 'iht-group/iht-group.php';
        
	}
}
add_action( 'init', 'fl_load_ta_modules' );