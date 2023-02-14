<?php

/**
 * Class that handles showing admin advanced options.
 *
 * @since 2.6
 */
final class FLBuilderAdminAdvanced {

	/**
	 * The advanced settings default groups
	 * @since 2.6
	 */
	public static function get_groups() {
		return array(
			'ui'       => array(
				'label' => __( 'Builder UI', 'fl-builder' ),
			),
			'admin'    => array(
				'label' => __( 'WP Admin', 'fl-builder' ),
			),
			'assets'   => array(
				'label' => __( 'Assets', 'fl-builder' ),
			),
			'frontend' => array(
				'label' => __( 'Frontend', 'fl-builder' ),
			),
		);
	}

	/**
	 * Return all advanced settings as an array
	 * @since 2.6
	 */
	static public function get_settings() {
		$settings = array(
			'outline_enabled'        => array(
				'label'    => __( 'Outline Panel', 'fl-builder' ),
				'default'  => 1,
				'callback' => array( __CLASS__, 'disable_outline' ),
				'group'    => 'ui',
				'link'     => 'https://docs.wpbeaverbuilder.com/beaver-builder/getting-started/bb-editor-basics/outline-panel/',
			),
			'inline_editing_enabled' => array(
				'label'    => __( 'Inline Editing', 'fl-builder' ),
				'default'  => 1,
				'callback' => array( __CLASS__, 'disable_inline_edit' ),
				'group'    => 'ui',
				'link'     => 'https://docs.wpbeaverbuilder.com/beaver-builder/getting-started/bb-editor-basics/inline-editing/',
			),
			'notifications_enabled'  => array(
				'label'       => __( 'Notification system', 'fl-builder' ),
				'default'     => 1,
				'callback'    => array( __CLASS__, 'disable_notifications' ),
				'group'       => 'ui',
				'description' => __( 'When disabled you will not receive alerts for new posts on the blog', 'fl-builder' ),
			),
			'lasttab_enabled'        => array(
				'label'       => __( 'Remember last used tab', 'fl-builder' ),
				'default'     => 1,
				'callback'    => array( __CLASS__, 'disable_lastused' ),
				'group'       => 'ui',
				'description' => __( 'The Builder remembers the last tab used in the row/column/module settings window.', 'fl-builder' ),
			),
			'rowshapes_enabled'      => array(
				'label'       => __( 'Custom Row Shapes', 'fl-builder' ),
				'default'     => 1,
				'callback'    => array( __CLASS__, 'disable_rowshapes' ),
				'group'       => 'ui',
				'description' => __( 'When enabled a custom row shapes tab will be added to the Global Settings.', 'fl-builder' ),
			),
			'limitrevisions_enabled' => array(
				'label'       => __( 'Limit WP revisions for layouts', 'fl-builder' ),
				'default'     => 0,
				'callback'    => array( __CLASS__, 'limit_revisions' ),
				'group'       => 'ui',
				'hasdepend'   => true,
				'description' => __( 'WP by default does not limit the amount of revisions.', 'fl-builder' ),
			),
			'limitrevisions_num'     => array(
				'label'       => __( 'Revisions Limit', 'fl-builder' ),
				'default'     => 10,
				'type'        => 'text',
				'depends'     => 'limitrevisions_enabled',
				'group'       => 'ui',
				'description' => __( 'Set to 0 to completely disable revisions for layouts/pages controlled by the builder', 'fl-builder' ),
			),
			'limithistory_enabled'   => array(
				'label'       => __( 'Limit the amount of undo/redo history in Builder UI', 'fl-builder' ),
				'default'     => 0,
				'callback'    => array( __CLASS__, 'limithistory_enabled' ),
				'group'       => 'ui',
				'hasdepend'   => true,
				'description' => __( 'History is limited to 20 by default in the Builder undo/redo UI', 'fl-builder' ),
			),
			'limithistory_num'       => array(
				'label'       => __( 'History Limit', 'fl-builder' ),
				'default'     => 5,
				'type'        => 'text',
				'depends'     => 'limithistory_enabled',
				'group'       => 'ui',
				'description' => __( 'Set to 0 to completely disable undo/redo history', 'fl-builder' ),
			),
			'modsec_enabled'         => array(
				'label'    => __( 'Mod Security fix', 'fl-builder' ),
				'default'  => 0,
				'callback' => array( __CLASS__, 'enable_modsec' ),
				'group'    => 'ui',
				'link'     => 'https://docs.wpbeaverbuilder.com/beaver-builder/troubleshooting/common-issues/403-forbidden-or-blocked-error/',
			),
			'sort_enabled'           => array(
				'label'       => __( 'Allow pages to be sortable', 'fl-builder' ),
				'default'     => 1,
				'callback'    => array( __CLASS__, 'disable_sorting' ),
				'group'       => 'admin',
				'description' => __( 'In WP admin lists of pages, posts, and custom post types in the back end, there is a Builder link in the list of post display filters, which limits the display to items that have Builder layouts.', 'fl-builder' ),
			),
			'duplicate_enabled'      => array(
				'label'    => __( 'Show duplicate action links in WP Admin', 'fl-builder' ),
				'default'  => 1,
				'callback' => array( __CLASS__, 'disable_duplicate' ),
				'group'    => 'admin',
			),
			'duplicatemenu_enabled'  => array(
				'label'    => __( 'Show duplicate action link in WP Admin Bar', 'fl-builder' ),
				'default'  => 0,
				'callback' => array( __CLASS__, 'disable_duplicate_menu' ),
				'group'    => 'admin',
			),
			'google_enabled'         => array(
				'label'       => 'Google Fonts',
				'description' => __( 'When disabled no Google Fonts will be enqueued or available in style options', 'fl-builder' ),
				'default'     => 1,
				'callback'    => array( __CLASS__, 'disable_google' ),
				'group'       => 'assets',
			),
			'awesome_enabled'        => array(
				'label'       => __( 'Font Awesome', 'fl-builder' ),
				'description' => __( 'When disabled Font Awesome will NOT be enqueued, even if modules require it.', 'fl-builder' ),
				'default'     => 1,
				'callback'    => array( __CLASS__, 'disable_awesome' ),
				'group'       => 'assets',
			),
			'gd_crop_enabled'        => array(
				'label'    => __( 'Prefer GD for image cropping', 'fl-builder' ),
				'default'  => 0,
				'callback' => array( __CLASS__, 'enable_gd_crop' ),
				'group'    => 'assets',
			),
			'inline_enabled'         => array(
				'label'       => 'Render CSS/JS assets inline',
				'default'     => 0,
				'callback'    => array( __CLASS__, 'render_inline' ),
				'group'       => 'frontend',
				'description' => __( 'Instead of loading Builder CSS and JavaScript as an asset file, you can render the CSS inline.', 'fl-builder' ),
				'link'        => 'https://docs.wpbeaverbuilder.com/beaver-builder/developer/how-to-tips/load-css-and-javascript-inline/',
			),
			'modules_enabled'        => array(
				'label'       => __( 'Show advanced module usage', 'fl-builder' ),
				'default'     => 0,
				'callback'    => array( __CLASS__, 'modules_enabled' ),
				'group'       => 'admin',
				'description' => __( 'Show detailed module usage on modules tab.', 'fl-builder' ),
				'link'        => 'https://docs.wpbeaverbuilder.com/beaver-builder/developer/tutorials-guides/common-beaver-builder-plugin-filter-examples/#show-which-modules-are-in-use-in-a-website',
			),

			'small_data_enabled'     => array(
				'label'       => __( 'Small Data Mode', 'fl-builder' ),
				'default'     => 0,
				'callback'    => array( __CLASS__, 'small_data_enabled' ),
				'group'       => 'ui',
				'description' => __( 'When enabled, fields that are empty/blank will not be saved to the database.', 'fl-builder' ),
			),
			'node_labels_enabled'    => array(
				'label'       => __( 'Node Labels', 'fl-builder' ),
				'default'     => 1,
				'callback'    => array( __CLASS__, 'node_labels_enabled' ),
				'group'       => 'ui',
				'description' => __( 'Show custom labels for Nodes.', 'fl-builder' ),
			),
			'shortcodes_enabled'     => array(
				'label'    => __( 'Render shortcodes in CSS/JS', 'fl-builder' ),
				'default'  => 0,
				'callback' => array( __CLASS__, 'shortcodes_enabled' ),
				'group'    => 'ui',
				'link'     => 'https://docs.wpbeaverbuilder.com/beaver-builder/advanced-builder-techniques/shortcodes/use-shortcodes-in-tools-menu-css-or-js/',
			),
		);
		if ( FLBuilderModel::is_white_labeled() ) {
			unset( $settings['notifications_enabled'] );
		}
		return $settings;
	}

	static private function disable_sorting() {
		add_filter( 'fl_builder_admin_edit_sort_bb_enabled', '__return_false', 11 );
	}
	static private function disable_outline() {
		add_filter( 'fl_builder_outline_panel_enabled', '__return_false', 11 );
	}
	static private function disable_inline_edit() {
		add_filter( 'fl_inline_editing_enabled', '__return_false', 11 );
	}
	static private function disable_notifications() {
		add_filter( 'fl_disable_notifications', '__return_true', 11 );
	}
	static private function disable_lastused() {
		add_filter( 'fl_remember_settings_tabs_enabled', '__return_false', 11 );
	}
	static private function disable_duplicate() {
		add_filter( 'fl_builder_duplicate_enabled', '__return_false', 11 );
	}
	static private function disable_duplicate_menu() {
		add_filter( 'fl_builder_duplicatemenu_enabled', '__return_true', 11 );
	}
	static private function disable_google() {
		add_filter( 'fl_builder_font_families_google', '__return_empty_array', 11 );
		add_filter( 'fl_enable_google_fonts_enqueue', '__return_false', 11 );
	}
	static private function disable_awesome() {
		if ( ! isset( $_GET['fl_builder'] ) ) {
			add_action( 'wp_enqueue_scripts', function() {
				wp_dequeue_style( 'font-awesome' );
				wp_dequeue_style( 'font-awesome-5' );
				wp_deregister_style( 'font-awesome' );
				wp_deregister_style( 'font-awesome-5' );
			}, 10001 );
		}
	}
	static private function render_inline() {
		add_filter( 'fl_builder_render_assets_inline', '__return_true', 1000 );
	}
	static private function modules_enabled() {
		add_filter( 'is_module_disable_enabled', '__return_true', 11 );
	}

	static private function small_data_enabled() {
		add_filter( 'fl_builder_enable_small_data_mode', '__return_true', 12 );
	}

	static private function enable_gd_crop() {
		add_filter( 'wp_image_editors', function() {
			return  array( 'WP_Image_Editor_GD', 'WP_Image_Editor_Imagick' );
		}, 100 );
	}
	static private function disable_rowshapes() {
		add_filter( 'fl_builder_register_settings_form', function( $form, $id ) {
			if ( 'global' == $id && isset( $form['tabs']['shapes'] ) ) {
				unset( $form['tabs']['shapes'] );
			}
			return $form;
		}, 11, 2 );
	}

	static private function limit_revisions() {
		add_filter( 'wp_revisions_to_keep', function( $num, $post ) {
			$enabled = get_post_meta( $post->ID, '_fl_builder_enabled', true );
			if ( $enabled ) {
				return (int) get_option( '_fl_builder_limitrevisions_num', 11 ) + 1;
			}
			return $num;
		}, 10, 2 );
	}

	static private function limithistory_enabled() {
		add_filter( 'fl_history_states_max', function() {
			return (int) get_option( '_fl_builder_limithistory_num', 5 );
		} );
	}

	static private function enable_modsec() {
		add_filter( 'fl_is_modsec_fix_enabled', '__return_true', 11 );
	}

	static private function node_labels_enabled() {
		add_filter( 'fl_node_labels_disabled', '__return_true' );
	}

	static private function shortcodes_enabled() {
		add_filter( 'fl_enable_shortcode_css_js', '__return_true' );
	}

	/**
	 * @since 2.6
	 */
	static public function init() {
		self::register_settings();
		add_action( 'after_setup_theme', __CLASS__ . '::register_user_access_settings' );
		add_action( 'wp_ajax_fl_advanced_submit', array( __CLASS__, 'advanced_submit' ) );
		self::init_hooks();
	}

	static public function advanced_submit() {
		if ( isset( $_POST['action'] ) && wp_verify_nonce( $_POST['_wpnonce'], 'advanced' ) ) {
			$setting = $_POST['setting'];
			if ( ! isset( $_POST['type'] ) ) {
					$value = 'true' === $_POST['value'] ? '1' : '0';
			} else {
				$value = (int) $_POST['value'];
			}
			update_option( "_fl_builder_{$setting}", $value );
			wp_send_json_success();
		} else {
			wp_send_json_error();
		}
	}

	/**
	 * Register the new user level to view options
	 * @since 2.6
	 */
	static public function register_user_access_settings() {
		FLBuilderUserAccess::register_setting( 'fl_builder_advanced_options', array(
			'default'     => array( 'administrator' ),
			'group'       => __( 'Admin', 'fl-builder' ),
			'label'       => __( 'Advanced Settings', 'fl-builder' ),
			'description' => __( 'The selected roles will be able to access the Advanced Settings. Note: user roles without the <code>manage_options</code> capability cannot access these settings.', 'fl-builder' ),
			'order'       => '110',
		) );
	}

	/**
	 * @since 2.6
	 */
	static private function init_hooks() {
		foreach ( self::get_settings() as $key => $setting ) {
			$option = get_option( "_fl_builder_{$key}", $setting['default'] );
			if ( $option != $setting['default'] && isset( $setting['callback'] ) ) {
				call_user_func( $setting['callback'] );
			}
		}
	}

	/**
	 * Register the new settings
	 * @since 2.6
	 */
	static private function register_settings() {
		foreach ( self::get_settings() as $key => $setting ) {
			FLBuilderAdminSettings::register_setting( '_fl_builder_' . $key );
		}
	}

}

FLBuilderAdminAdvanced::init();
