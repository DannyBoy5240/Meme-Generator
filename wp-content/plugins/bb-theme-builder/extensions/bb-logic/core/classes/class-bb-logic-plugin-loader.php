<?php

if ( ! class_exists( 'BB_Logic_Plugin_Loader' ) ) {

	/**
	 * Sets up plugin constants and loads the necessary PHP files.
	 * If the plugin can't be loaded, an admin notice is shown.
	 *
	 * @since 0.1
	 */
	final class BB_Logic_Plugin_Loader {

		/**
		 * Initialize the plugin.
		 *
		 * @since  0.1
		 * @return void
		 */
		static public function init() {
			self::define_constants();

			if ( self::get_loading_error() ) {
				self::admin_notice_hooks();
				return;
			}

			register_activation_hook( BB_LOGIC_FILE, __CLASS__ . '::activate' );

			if ( did_action( 'plugins_loaded' ) ) {
				self::load_files();
			} else {
				add_action( 'plugins_loaded', __CLASS__ . '::load_files' );
			}

			add_filter( 'fl_builder_ui_js_config', __CLASS__ . '::rest_permalinks_type' );
		}


		/**
		 * Define plugin constants.
		 *
		 * @since  0.1
		 * @return void
		 */
		static private function define_constants() {
			define( 'BB_LOGIC_VERSION', '0.1' );
			define( 'BB_LOGIC_FILE', trailingslashit( dirname( dirname( dirname( __FILE__ ) ) ) ) . 'bb-logic.php' );
			define( 'BB_LOGIC_DIR', plugin_dir_path( BB_LOGIC_FILE ) );
			define( 'BB_LOGIC_URL', plugins_url( '/', BB_LOGIC_FILE ) );
		}

		/**
		 * Runs on plugin activation.
		 *
		 * @since 0.1
		 * @return void
		 */
		static public function activate() {
			do_action( 'bb_logic_activate' );
		}

		/**
		 * Load plugin files.
		 *
		 * @since  0.1
		 * @return void
		 */
		static public function load_files() {

			// Core
			self::load_file( 'core/classes/class-bb-logic-asset-loader.php' );
			self::load_file( 'core/classes/class-bb-logic-rules.php' );
			self::load_file( 'core/classes/class-bb-logic-shortcodes.php' );

			// REST
			self::load_file( 'rest/classes/class-bb-logic-rest.php' );

			// Analytics
			self::load_analytics();

			// Editors
			self::load_editors();

			// Rules
			self::load_rules();

			// We're fully loaded, time to hook!
			do_action( 'bb_logic_init' );
		}

		/**
		 * Loads analytics specific logic.
		 *
		 * @since  0.1
		 * @return void
		 */
		static public function load_analytics() {
			foreach ( glob( BB_LOGIC_DIR . 'analytics/*' ) as $path ) {
				$analytics = basename( $path );
				self::load_file( "analytics/$analytics/classes/class-bb-analytics-$analytics.php" );
			}
		}

		/**
		 * Loads editor specific logic.
		 *
		 * @since  0.1
		 * @return void
		 */
		static public function load_editors() {
			foreach ( glob( BB_LOGIC_DIR . 'editors/*' ) as $path ) {
				$editor = basename( $path );
				self::load_file( "editors/$editor/classes/class-bb-logic-editor-$editor.php" );
			}
		}

		/**
		 * Loads rule specific logic.
		 *
		 * @since  0.1
		 * @return void
		 */
		static public function load_rules() {
			foreach ( glob( BB_LOGIC_DIR . 'rules/*' ) as $path ) {
				$rule = basename( $path );
				self::load_file( "rules/$rule/classes/class-bb-logic-rules-$rule.php" );
			}
		}

		/**
		 * Loads a plugin file if it exists.
		 *
		 * @since  0.1
		 * @return void
		 */
		static public function load_file( $path ) {
			if ( file_exists( BB_LOGIC_DIR . $path ) ) {
				require_once BB_LOGIC_DIR . $path;
			}
		}

		/**
		 * Initializes actions for the admin notice if the plugin can't load.
		 *
		 * @since  0.1
		 * @access private
		 * @return void
		 */
		static private function admin_notice_hooks() {
			global $pagenow;

			if ( 'plugins.php' == $pagenow ) {
				add_action( 'admin_notices', __CLASS__ . '::admin_notice' );
				add_action( 'network_admin_notices', __CLASS__ . '::admin_notice' );
			}
		}

		/**
		 * Shows an admin notice if the plugin can't load.
		 *
		 * @since  0.1
		 * @return void
		 */
		static public function admin_notice() {
			if ( ! is_admin() ) {
				return;
			} elseif ( ! is_user_logged_in() ) {
				return;
			} elseif ( ! current_user_can( 'update_core' ) ) {
				return;
			}

			$message = self::get_loading_error();

			if ( $message ) {
				echo '<div class="error">';
				echo '<p>' . sprintf( $message ) . '</p>';
				echo '</div>';
			}
		}

		/**
		 * Returns a plugin loading error if there is one.
		 *
		 * @since  0.1
		 * @return bool|string
		 */
		static private function get_loading_error() {
			$error = false;

			if ( version_compare( phpversion(), '5.4', '<' ) ) {
				$url = 'http://www.wpupdatephp.com/contact-host/';
				/* translators: %s: url */
				$error = sprintf( __( 'Beaver Logic requires PHP 5.4 or above. Please <a href="%s">update your PHP version</a> before continuing.', 'bb-theme-builder' ), $url );
			}

			return $error;
		}

		static public function rest_permalinks_type( $config ) {

			$config['logicPermalinks'] = get_option( 'permalink_structure' ) ? true : false;
			return $config;
		}
	}

	BB_Logic_Plugin_Loader::init();
}
