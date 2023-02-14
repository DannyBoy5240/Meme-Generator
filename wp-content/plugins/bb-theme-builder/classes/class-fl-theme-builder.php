<?php

/**
 * Handles base logic for the theme builder.
 *
 * @since 1.0
 */
final class FLThemeBuilder {

	/**
	 * Initializes the theme builder.
	 *
	 * @since 1.0
	 * @return void
	 */
	static public function init() {
		add_action( 'after_setup_theme', __CLASS__ . '::register_user_access_settings' );
		add_action( 'plugins_loaded', __CLASS__ . '::load_plugin_textdomain', 15 );
	}

	/**
	 * Registers the user access settings for the theme builder.
	 *
	 * @since 1.0
	 * @return void
	 */
	static public function register_user_access_settings() {
		FLBuilderUserAccess::register_setting( 'theme_builder_editing', array(
			'default'     => array( 'administrator' ),
			'group'       => __( 'Admin', 'bb-theme-builder' ),
			'label'       => __( 'Themer Layout Editing', 'bb-theme-builder' ),
			'description' => __( 'The selected roles will be able to edit Themer layouts.', 'bb-theme-builder' ),
			'order'       => '110',
		) );
	}

	/**
	 * Load the translation file for current language. Checks the default WordPress
	 * languages folder first and then the languages folder inside the plugin.
	 *
	 * @since 1.0
	 * @return string|bool The translation file path or false if none is found.
	 */
	static public function load_plugin_textdomain() {

		// Traditional WordPress plugin locale filter
		// Uses get_user_locale() which was added in 4.7 so we need to check its available.
		if ( function_exists( 'get_user_locale' ) ) {
			$locale = apply_filters( 'plugin_locale', get_user_locale(), 'bb-theme-builder' );
		} else {
			$locale = apply_filters( 'plugin_locale', get_locale(), 'bb-theme-builder' );
		}

		// Setup paths to current locale file
		$mofile_global = trailingslashit( WP_LANG_DIR ) . 'plugins/bb-theme-builder/' . $locale . '.mo';
		$mofile_local  = trailingslashit( FL_THEME_BUILDER_DIR ) . 'languages/' . $locale . '.mo';

		if ( file_exists( $mofile_global ) ) {
			// Look in global /wp-content/languages/plugins/bb-plugin/ folder
			return load_textdomain( 'bb-theme-builder', $mofile_global );
		} elseif ( file_exists( $mofile_local ) ) {
			// Look in local /wp-content/plugins/bb-plugin/languages/ folder
			return load_textdomain( 'bb-theme-builder', $mofile_local );
		}

		// Nothing found
		return false;
	}

	/**
	 * Checks to see if the current page has a layout
	 * of the specified type.
	 *
	 * @since 1.0
	 * @param string $type
	 * @return bool
	 */
	static public function has_layout( $type = null ) {
		$layouts = FLThemeBuilderLayoutData::get_current_page_layouts( $type );
		return count( $layouts ) ? true : false;
	}
}

FLThemeBuilder::init();
