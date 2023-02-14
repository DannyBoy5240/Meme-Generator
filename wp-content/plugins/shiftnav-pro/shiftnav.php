<?php
/*
Plugin Name: ShiftNav Pro - Responsive Mobile Menu
Plugin URI: http://shiftnav.io
Description: An off-canvas mobile menu for WordPress with advanced functionality
Author: Chris Mavricos, SevenSpark
Author URI: http://sevenspark.com
Version: 1.7.2
*/

/* Copyright 2014-2023 Chris Mavricos, SevenSpark */

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

define( 'SHIFTNAV_PRO' , true );
//define( 'SHIFTNAV_EXTENDED' , true );

if ( !class_exists( 'ShiftNav' ) ) :

final class ShiftNav {
	/** Singleton *************************************************************/

	private static $instance;
	private static $settings_api;
	private static $skins;
	private static $settings_defaults;
	private static $registered_icons;
	private static $current_instance = 'shiftnav-main';
	private static $is_mobile = null;
	private static $display_now = null;

	private static $support_url;

	public static function instance() {

		if ( ! isset( self::$instance ) ) {
			self::$instance = new ShiftNav;
			self::$instance->setup_constants();
			self::$instance->includes();
			self::$instance->activation_check();
		}
		return self::$instance;
	}

	/**
	 * Setup plugin constants
	 *
	 * @since 1.0
	 * @access private
	 * @uses plugin_dir_path() To generate plugin path
	 * @uses plugin_dir_url() To generate plugin url
	 */
	private function setup_constants() {
		// Plugin version

		if( ! defined( 'SHIFTNAV_VERSION' ) )
			define( 'SHIFTNAV_VERSION', '1.7.2' );

		if( ! defined( 'SHIFTNAV_PRO' ) )
			define( 'SHIFTNAV_PRO', false );

		if( ! defined( 'SHIFTNAV_BASENAME' ) )
			define( 'SHIFTNAV_BASENAME' , plugin_basename( __FILE__ ) );

		if( ! defined( 'SHIFTNAV_BASEDIR' ) ){
			define( 'SHIFTNAV_BASEDIR' , dirname( plugin_basename(__FILE__) ) );
		}

		// Plugin Folder URL
		if( ! defined( 'SHIFTNAV_URL' ) )
			define( 'SHIFTNAV_URL', plugin_dir_url( __FILE__ ) );

		// Plugin Folder Path
		if( ! defined( 'SHIFTNAV_DIR' ) )
			define( 'SHIFTNAV_DIR', plugin_dir_path( __FILE__ ) );

		// Plugin Root File
		if( ! defined( 'SHIFTNAV_FILE' ) )
			define( 'SHIFTNAV_FILE', __FILE__ );

		if( ! defined( 'SHIFTNAV_MENU_ITEM_META_KEY' ) )
			define( 'SHIFTNAV_MENU_ITEM_META_KEY' , '_shiftnav_settings' );

		if( ! defined( 'SHIFTNAV_EXTENDED' ) )
			define( 'SHIFTNAV_EXTENDED', false );

		if( !defined( 'SHIFTNAV_MENU_CONFIGURATIONS' ) )
			define( 'SHIFTNAV_MENU_CONFIGURATIONS' , 'shiftnav_menus' );



		define( 'SHIFTNAV_MENU_STYLES' , '_shiftnav_menu_styles' );

		define( 'SHIFTNAV_GENERATED_STYLE_TRANSIENT' , '_shiftnav_generated_styles' );
		if( ! defined( 'SHIFTNAV_GENERATED_STYLE_TRANSIENT_EXPIRATION' ) )
			define( 'SHIFTNAV_GENERATED_STYLE_TRANSIENT_EXPIRATION' , 30 * DAY_IN_SECONDS );

		//URLS
		define( 'SHIFTNAV_SUPPORT_URL' , 'http://sevenspark.com/help' );


		define( 'SHIFTNAV_PREFIX' , 'shiftnav_' );
	}

	private function includes() {

		require_once SHIFTNAV_DIR . 'includes/ShiftNavWalker.class.php';
		//require_once SHIFTNAV_DIR . 'includes/icons.php';
		require_once SHIFTNAV_DIR . 'includes/functions.php';
		require_once SHIFTNAV_DIR . 'includes/shiftnav.api.php';
		require_once SHIFTNAV_DIR . 'customizer/customizer.php';

		require_once SHIFTNAV_DIR . 'admin/admin.php';

		if( SHIFTNAV_PRO ) require_once SHIFTNAV_DIR . 'pro/shiftnav.pro.php';

	}

	private function activation_check(){

		if( SHIFTNAV_PRO ){
			$last_activated = get_option( 'shiftnav_pro_version' , '0' );
			if( !version_compare( $last_activated , SHIFTNAV_VERSION , '=' ) ){
				do_action( 'shiftnav_update' );
				update_option( 'shiftnav_pro_version' , SHIFTNAV_VERSION );
			}
		}
	}

	public function settings_api(){
		if( self::$settings_api == null ){
			self::$settings_api = new ShiftNav_Settings_API();
		}
		return self::$settings_api;
	}

	public function get_current_instance(){
		return self::$current_instance;
	}

	public function set_current_instance( $instance_id ){
		return self::$current_instance = $instance_id;
	}


	public function get_skins(){
		return self::$skins;
	}
	public function register_skin( $id , $title , $src ){
		if( self::$skins == null ){
			self::$skins = array();
		}
		self::$skins[$id] = array(
			'title'	=> $title,
			'src'	=> $src,
		);

		wp_register_style( 'shiftnav-'.$id , $src , false , SHIFTNAV_VERSION );
	}

	public function set_defaults( $fields ){

		if( self::$settings_defaults == null ) self::$settings_defaults = array();

		foreach( $fields as $section_id => $ops ){

			self::$settings_defaults[$section_id] = array();

			foreach( $ops as $op ){
				self::$settings_defaults[$section_id][$op['name']] = isset( $op['default'] ) ? $op['default'] : '';
			}
		}

		//shiftp( $this->settings_defaults );

	}

	function get_defaults( $section = null ){
		if( self::$settings_defaults == null ) self::set_defaults( shiftnav_get_settings_fields() );

		if( $section != null && isset( self::$settings_defaults[$section] ) ) return self::$settings_defaults[$section];

		return self::$settings_defaults;
	}

	function get_default( $option , $section ){

		if( self::$settings_defaults == null ) self::set_defaults( shiftnav_get_settings_fields() );

		$default = '';

		//echo "[[$section|$option]]  ";
		if( isset( self::$settings_defaults[$section] ) && isset( self::$settings_defaults[$section][$option] ) ){
			$default = self::$settings_defaults[$section][$option];
		}
		return $default;
	}

	function register_icons( $group , $iconmap ){
		if( !is_array( self::$registered_icons ) ) self::$registered_icons = array();
		self::$registered_icons[$group] = $iconmap;
	}
	function degister_icons( $group ){
		if( is_array( self::$registered_icons ) && isset( self::$registered_icons[$group] ) ){
			unset( self::$registered_icons[$group] );
		}
	}
	function get_registered_icons(){ //$group = '' ){
		return self::$registered_icons;
	}


	static function is_mobile(){
		if( self::$is_mobile === null ){
			self::$is_mobile = apply_filters( 'shiftnav_is_mobile' , wp_is_mobile() );
		}
		return self::$is_mobile;
	}
	function display_now(){

		if( self::$display_now === null ){

			$display = true;

			//Mobile only and this isn't mobile
			if( shiftnav_op( 'mobile_only' , 'general' ) == 'on' && !self::is_mobile() ){
				$display = false;
			}

			self::$display_now = apply_filters( 'shiftnav_display_now' , $display );
		}

		return self::$display_now;

	}

	function get_support_url(){

		if( self::$support_url ){
			return self::$support_url;
		}

		$url = SHIFTNAV_SUPPORT_URL;

		$data = array();


		$data['src']			= 'shiftnav_pro_plugin';
		$data['product_id']		= 6;

		//Site Data
		$data['site_url'] 		= get_site_url();
		$data['version']		= SHIFTNAV_VERSION;
		$data['timezone']		= get_option('timezone_string');

		//Theme Data
		$theme = wp_get_theme();
		//uberp( $theme , 3 );
		$data['theme']			= $theme->get( 'Name' );
		$data['theme_link']		= '<a target="_blank" href="'.$theme->get( 'ThemeURI' ).'">'. $theme->get( 'Name' ). ' v'.$theme->get( 'Version' ).' by ' . $theme->get( 'Author' ).'</a>';
		$data['theme_slug']		= isset( $theme->stylesheet ) ? $theme->stylesheet : '';
		$data['theme_parent']	= $theme->get( 'Template' );

		//User Data
		$current_user = wp_get_current_user();
		if( $current_user ){
			if( $current_user->user_firstname ){
				$data['first_name']		= $current_user->user_firstname;
			}
			if( $current_user->user_firstname ){
				$data['last_name']		= $current_user->user_lastname;
			}
			if( $current_user ){
				$data['email']			= $current_user->user_email;
			}
		}
		//$data['email']			= get_bloginfo( 'admin_email' );


		//License Data
		$license_code = shiftnav_op( 'license_code' , 'updates' , '' );
		if( $license_code ){
			$data['license_code']	= $license_code;
		}

		$query = http_build_query( $data );

		$support_url = "$url?$query";
		self::$support_url = $support_url;

		return $support_url;
	}

}

/*
 * If the class already exists, and we're running ShiftNav Pro,
 * ShiftNav free needs to be deactivated
 */
elseif ( defined( 'SHIFTNAV_PRO' ) && SHIFTNAV_PRO ) :

	function deactivate_shiftnav() {
		if ( is_plugin_active('shiftnav-responsive-mobile-menu/shiftnav-responsive-mobile-menu.php') ) {
			deactivate_plugins('shiftnav-responsive-mobile-menu/shiftnav-responsive-mobile-menu.php');
		}
	}
	add_action( 'admin_init', 'deactivate_shiftnav' );

	//or
	function shiftnav_duplicate_warning(){
		echo '<div class="error"><p><strong>Attempting to disable ShiftNav [Free]</strong>.  Please be sure that the free version of ShiftNav has been disabled in order to use ShiftNav Pro</p></div>';
	}
	add_action( 'admin_notices' , 'shiftnav_duplicate_warning' );


endif; // End if class_exists check

if( !function_exists( '_SHIFTNAV' ) ){
	function _SHIFTNAV() {
		return ShiftNav::instance();
	}
	_SHIFTNAV();
}
