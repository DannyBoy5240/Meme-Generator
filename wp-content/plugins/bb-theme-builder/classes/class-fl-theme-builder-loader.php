<?php

/**
 * Responsible for setting up theme builder constants, classes and includes.
 *
 * @since 1.0
 */
final class FLThemeBuilderLoader {

	/**
	 * An array of slugs for theme builder modules that
	 * have been loaded.
	 *
	 * @since 1.0.1
	 * @var array $loaded_modules
	 */
	static private $loaded_modules = array();

	/**
	 * Sets up the plugins_loaded action to load the theme builder.
	 *
	 * @since 1.0
	 * @return void
	 */
	static public function init() {
		self::define_constants();

		register_activation_hook( FL_THEME_BUILDER_FILE, __CLASS__ . '::activate' );

		add_action( 'plugins_loaded', __CLASS__ . '::load' );
		add_action( 'fl_builder_activated', __CLASS__ . '::activate' );
	}

	/**
	 * Enables the builder admin when the theme builder is activated.
	 *
	 * @since 1.0
	 * @return void
	 */
	static public function activate() {
		if ( ! class_exists( 'FLBuilderUserAccess' ) ) {
			return;
		}

		// Make sure the builder admin is enabled for the theme builder.
		$ua_settings = FLBuilderUserAccess::get_saved_settings();

		if ( isset( $ua_settings['builder_admin']['administrator'] ) && ! $ua_settings['builder_admin']['administrator'] ) {
			$ua_settings['builder_admin']['administrator'] = 1;
			FLBuilderModel::update_admin_settings_option( '_fl_builder_user_access', $ua_settings, false );
		}

		// Register our CPT early and flush rewrite rules so it doesn't throw a 404.
		register_post_type( 'fl-theme-layout', array() );
		flush_rewrite_rules( false );
	}

	/**
	 * Loads theme builder if the Beaver Builder plugin is active.
	 *
	 * @since 1.0
	 * @return void
	 */
	static public function load() {
		if ( ! self::can_load() ) {
			self::admin_notice_hooks();
			return;
		}

		self::load_files();

		add_action( 'after_setup_theme', __CLASS__ . '::load_admin_files', 11 );
		add_action( 'wp', __CLASS__ . '::load_modules', 1 );
	}

	/**
	 * Define theme builder constants.
	 *
	 * @since 1.0
	 * @access private
	 * @return void
	 */
	static private function define_constants() {
		define( 'FL_THEME_BUILDER_VERSION', '1.4.5' );
		define( 'FL_THEME_BUILDER_FILE', trailingslashit( dirname( dirname( __FILE__ ) ) ) . 'bb-theme-builder.php' );
		define( 'FL_THEME_BUILDER_DIR', plugin_dir_path( FL_THEME_BUILDER_FILE ) );
		define( 'FL_THEME_BUILDER_URL', plugins_url( '/', FL_THEME_BUILDER_FILE ) );
	}

	/**
	 * Loads classes and includes.
	 *
	 * @since 1.0
	 * @access private
	 * @return void
	 */
	static private function load_files() {
		// Classes
		require_once FL_THEME_BUILDER_DIR . 'classes/class-fl-page-data.php';
		require_once FL_THEME_BUILDER_DIR . 'classes/class-fl-theme-builder.php';
		require_once FL_THEME_BUILDER_DIR . 'classes/class-fl-theme-builder-admin-bar.php';
		require_once FL_THEME_BUILDER_DIR . 'classes/class-fl-theme-builder-admin-customize.php';
		require_once FL_THEME_BUILDER_DIR . 'classes/class-fl-theme-builder-field-connections.php';
		require_once FL_THEME_BUILDER_DIR . 'classes/class-fl-theme-builder-frontend-edit.php';
		require_once FL_THEME_BUILDER_DIR . 'classes/class-fl-theme-builder-layout-data.php';
		require_once FL_THEME_BUILDER_DIR . 'classes/class-fl-theme-builder-layout-frontend-edit.php';
		require_once FL_THEME_BUILDER_DIR . 'classes/class-fl-theme-builder-layout-post-type.php';
		require_once FL_THEME_BUILDER_DIR . 'classes/class-fl-theme-builder-layout-renderer.php';
		require_once FL_THEME_BUILDER_DIR . 'classes/class-fl-theme-builder-layout-templates.php';
		require_once FL_THEME_BUILDER_DIR . 'classes/class-fl-theme-builder-post-modules.php';
		require_once FL_THEME_BUILDER_DIR . 'classes/class-fl-theme-builder-rules-location.php';
		require_once FL_THEME_BUILDER_DIR . 'classes/class-fl-theme-builder-rules-user.php';
		require_once FL_THEME_BUILDER_DIR . 'classes/class-fl-theme-builder-logic-i18n.php';

		// Includes
		if ( ! strstr( FL_THEME_BUILDER_VERSION, 'FL_THEME_BUILDER_VERSION' ) ) {
			require_once FL_THEME_BUILDER_DIR . 'includes/updater-config.php';
		}

		// Extensions
		FLBuilderExtensions::init( FL_THEME_BUILDER_DIR . 'extensions/' );
	}

	/**
	 * Loads classes and includes for the admin.
	 *
	 * @since 1.0.1.1
	 * @access private
	 * @return void
	 */
	static public function load_admin_files() {
		if ( ! is_admin() || ! FLBuilderUserAccess::current_user_can( 'theme_builder_editing' ) ) {
			return;
		}

		// Classes
		require_once FL_THEME_BUILDER_DIR . 'classes/class-fl-theme-builder-admin-menu.php';
		require_once FL_THEME_BUILDER_DIR . 'classes/class-fl-theme-builder-admin-settings.php';
		require_once FL_THEME_BUILDER_DIR . 'classes/class-fl-theme-builder-layout-admin-add.php';
		require_once FL_THEME_BUILDER_DIR . 'classes/class-fl-theme-builder-layout-admin-edit.php';
		require_once FL_THEME_BUILDER_DIR . 'classes/class-fl-theme-builder-layout-admin-list.php';
	}

	/**
	 * Loads custom modules.
	 *
	 * @since 1.0
	 * @param string $path
	 * @return void
	 */
	static public function load_modules( $path = null ) {
		$path    = ! $path || is_object( $path ) ? FL_THEME_BUILDER_DIR . 'modules/' : trailingslashit( $path );
		$modules = glob( $path . '*' );

		if ( ! is_array( $modules ) ) {
			return;
		}

		foreach ( $modules as $path ) {
			// Paths to check.
			$slug        = basename( $path );
			$child_path  = get_stylesheet_directory() . '/fl-builder/modules/' . $slug . '/' . $slug . '.php';
			$theme_path  = get_template_directory() . '/fl-builder/modules/' . $slug . '/' . $slug . '.php';
			$themer_path = trailingslashit( $path ) . $slug . '.php';
			$load_path   = null;

			// Check for the module class in a theme or child theme.
			if ( is_child_theme() && file_exists( $child_path ) ) {
				$load_path = $child_path;
			} elseif ( file_exists( $theme_path ) ) {
				$load_path = $theme_path;
			} elseif ( file_exists( $themer_path ) ) {
				$load_path = $themer_path;
			}

			// Load the module if we have a path.
			if ( $load_path && class_exists( 'FLBuilderModule' ) ) {
				self::$loaded_modules[] = $slug;
				require_once $load_path;
			}
		}
	}

	/**
	 * Returns an array of slugs for theme builder modules
	 * that have been loaded.
	 *
	 * @since 1.0.1
	 * @return array
	 */
	static public function get_loaded_modules() {
		return self::$loaded_modules;
	}

	/**
	 * Initializes actions for the admin notice if the builder
	 * isn't active or the lite version is.
	 *
	 * @since 1.0
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
	 * Shows an admin notice if the builder isn't active or
	 * if this is the lite version.
	 *
	 * @since 1.0
	 * @return void
	 */
	static public function admin_notice() {
		$message = null;

		if ( ! is_admin() ) {
			return;
		} elseif ( ! is_user_logged_in() ) {
			return;
		} elseif ( ! current_user_can( 'update_core' ) ) {
			return;
		}

		if ( ! class_exists( 'FLBuilder' ) ) {
			$url = admin_url( 'plugins.php' );
			/* translators: %s: url */
			$message = __( 'The Beaver Builder plugin must be active in order to use Beaver Themer. Please <a href="%s">activate it</a> before continuing.', 'bb-theme-builder' );
		} elseif ( true === FL_BUILDER_LITE ) {
			$url = 'https://www.wpbeaverbuilder.com';
			/* translators: %s: url */
			$message = __( 'Beaver Themer is not compatible with the lite version of Beaver Builder. Please <a href="%s">purchase a premium version</a> before continuing.', 'bb-theme-builder' );
		} elseif ( ( '{FL_BUILDER_VERSION}' != FL_BUILDER_VERSION && version_compare( FL_BUILDER_VERSION, '1.10-alpha.1', '<' ) ) || ! class_exists( 'FLBuilderUserAccess' ) ) {
			$url = admin_url( 'plugins.php' );
			/* translators: %s: url */
			$message = __( 'Beaver Themer is only compatible with Beaver Builder 1.10 and above. Please <a href="%s">update</a> before continuing.', 'bb-theme-builder' );
		} elseif ( version_compare( phpversion(), '5.3', '<' ) ) {
			$url = 'http://www.wpupdatephp.com/contact-host/';
			/* translators: %s: url */
			$message = __( 'Beaver Themer requires PHP 5.3 or above. Please <a href="%s">update your PHP version</a> before continuing.', 'bb-theme-builder' );
		}

		if ( $message ) {
			echo '<div class="error">';
			echo '<p>' . sprintf( $message, $url ) . '</p>';
			echo '</div>';
		}
	}

	/**
	 * Checks to see if the Theme Builder can be loaded.
	 *
	 * @since 1.0
	 * @return bool
	 */
	static private function can_load() {
		if ( ! class_exists( 'FLBuilder' ) ) {
			return false;
		} elseif ( true === FL_BUILDER_LITE ) {
			return false;
		} elseif ( ! class_exists( 'FLBuilderUserAccess' ) ) {
			return false;
		} elseif ( '{FL_BUILDER_VERSION}' != FL_BUILDER_VERSION && version_compare( FL_BUILDER_VERSION, '1.10-alpha.1', '<' ) ) {
			return false;
		} elseif ( version_compare( phpversion(), '5.3', '<' ) ) {
			return false;
		}

		return true;
	}
}

FLThemeBuilderLoader::init();
