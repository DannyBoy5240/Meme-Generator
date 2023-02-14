<?php

/**
 * Main conditional logic class to support the Beaver
 * Themer UI. Handles enqueuing assets and processing
 * display logic for Beaver Themer layouts.
 *
 * @since 0.1
 */
final class BB_Logic_Editor_Beaver_Themer {

	/**
	 * Load Beaver Themer logic on plugins_loaded since it is
	 * loaded on that hook as well.
	 *
	 * @since 0.1
	 * @return void
	 */
	static public function init() {
		add_action( 'plugins_loaded', __CLASS__ . '::load', 11 );
	}

	/**
	 * Setup hooks if the Beaver Themer plugin is active.
	 *
	 * @since 0.1
	 * @return void
	 */
	static public function load() {
		if ( ! class_exists( 'FLThemeBuilder' ) ) {
			return;
		}

		// Actions
		add_action( 'admin_enqueue_scripts', __CLASS__ . '::enqueue_assets', 11 );
		add_action( 'admin_footer', __CLASS__ . '::render_react_root' );
		add_action( 'save_post', __CLASS__ . '::save' );

		// Filters
		add_filter( 'fl_theme_builder_current_page_layouts', __CLASS__ . '::filter_layouts' );
	}

	/**
	 * Returns the rules for a post and handles backwards
	 * compatibility for the old user rules.
	 *
	 * @since 0.1
	 * @param int $post_id
	 * @return array
	 */
	static public function get_rules( $post_id ) {
		$rules      = get_post_meta( $post_id, '_fl_theme_builder_logic', true );
		$user_rules = FLThemeBuilderRulesUser::get_saved( $post_id );
		$new_rules  = array();
		$rules      = is_array( $rules ) ? $rules : array();

		foreach ( $user_rules as $rule ) {
			$parts = explode( ':', $rule );
			if ( 'general' === $parts[0] ) {
				if ( in_array( $parts[1], array( 'logged-in', 'logged-out' ) ) ) {
					$new_rule           = new stdClass;
					$new_rule->type     = 'wordpress/user-login-status';
					$new_rule->operator = 'equals';
					$new_rule->compare  = str_replace( '-', '_', $parts[1] );
					$new_rules[]        = $new_rule;
				} else {
					continue;
				}
			} elseif ( 'role' === $parts[0] ) {
				$new_rule           = new stdClass;
				$new_rule->type     = 'wordpress/user-role';
				$new_rule->operator = 'equals';
				$new_rule->compare  = $parts[1];
				$new_rules[]        = $new_rule;
			}
		}

		if ( ! empty( $new_rules ) ) {
			$rules[] = $new_rules;
		}

		return $rules ? $rules : array();
	}

	/**
	 * Check to see if we're editing a Themer layout.
	 *
	 * @since 0.1
	 * @return void
	 */
	static public function is_admin_edit() {
		global $pagenow;
		global $post;
		$screen = get_current_screen();
		return 'post.php' === $pagenow && 'fl-theme-layout' === $screen->post_type;
	}

	/**
	 * Enqueue assets when the builder UI is active.
	 *
	 * @since 0.1
	 * @return void
	 */
	static public function enqueue_assets() {
		global $post;

		if ( ! is_object( $post ) || ! self::is_admin_edit() ) {
			return;
		}

		// Core Assets
		BB_Logic_Asset_Loader::enqueue( array(
			'wordpress',
			'acf',
			'browser',
		) );

		// Styles
		wp_enqueue_style(
			'bb-logic-editor-beaver-themer',
			BB_LOGIC_URL . 'editors/beaver-themer/build/style.css',
			array( 'bb-logic-core' ),
			BB_LOGIC_VERSION
		);

		// Scripts
		wp_enqueue_script(
			'bb-logic-editor-beaver-themer',
			BB_LOGIC_URL . 'editors/beaver-themer/build/index.js',
			array( 'bb-logic-core' ),
			BB_LOGIC_VERSION,
			true
		);

		// Saved Rules
		wp_localize_script(
			'bb-logic-editor-beaver-themer',
			'BBLogicRules',
			self::get_rules( $post->ID )
		);
		/**
		 * FLBuilderConfig is not available in wp-admin
		 */
		wp_localize_script(
			'bb-logic-core',
			'FLBuilderConfig',
			array( 'logicPermalinks' => get_option( 'permalink_structure' ) ? true : false )
		);
	}

	/**
	 * Renders the react root for rendering the conditional
	 * logic form in the DOM. In the future it would be nice
	 * if we didn't have to do this with jQuery.
	 *
	 * @since 0.1
	 * @return void
	 */
	static public function render_react_root() {
		if ( ! self::is_admin_edit() ) {
			return;
		}

		?>
		<script>
		jQuery( '#fl-theme-builder-settings .inside' ).append( '<div id="bb-logic-root"></div>' )
		</script>
		<?php
	}

	/**
	 * Saves conditional logic settings for themer layouts.
	 *
	 * @since 0.1
	 * @return void
	 */
	static public function save() {
		global $post;

		if ( ! FLBuilderUserAccess::current_user_can( 'theme_builder_editing' ) ) {
			return;
		}
		if ( ! isset( $_POST['fl-theme-builder-nonce'] ) ) {
			return;
		}
		if ( ! wp_verify_nonce( $_POST['fl-theme-builder-nonce'], 'fl-theme-builder' ) ) {
			return;
		}
		if ( ! isset( $_POST['bb-logic-json'] ) ) {
			return;
		}

		$post_id = absint( $_POST['post_ID'] );
		$rules   = json_decode( stripslashes_deep( $_POST['bb-logic-json'] ) );
		update_post_meta( $post_id, '_fl_theme_builder_logic', $rules );

		// Clear old user rules as they are no longer needed.
		FLThemeBuilderRulesUser::update_saved( $post_id, array() );
	}

	/**
	 * Filter out any layouts that have conditional logic
	 * rules with conditions that aren't met.
	 *
	 * @since 0.1
	 * @return void
	 */
	static public function filter_layouts( $layouts ) {
		if ( 'fl-theme-layout' === get_post_type() ) {
			return $layouts;
		}

		foreach ( $layouts as $type => $posts ) {
			foreach ( $posts as $key => $post ) {
				$rules = self::get_rules( $post['id'] );
				if ( is_array( $rules ) && ! BB_Logic_Rules::process_groups( $rules ) ) {
					unset( $layouts[ $type ][ $key ] );
				}
			}
		}

		return $layouts;
	}
}

BB_Logic_Editor_Beaver_Themer::init();
