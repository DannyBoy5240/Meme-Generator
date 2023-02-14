<?php

/**
 * Logic for the theme layouts admin edit screen.
 *
 * @since 1.0
 */
final class FLThemeBuilderLayoutAdminEdit {

	/**
	 * Initialize hooks.
	 *
	 * @since 1.0
	 * @return void
	 */
	static public function init() {
		// Redirect if we're on post-new.php.
		self::redirect();

		// Actions
		add_action( 'save_post', __CLASS__ . '::save' );
		add_action( 'admin_enqueue_scripts', __CLASS__ . '::admin_enqueue_scripts' );
		add_action( 'admin_head', __CLASS__ . '::setup_location_notice' );
		add_action( 'add_meta_boxes', __CLASS__ . '::add_meta_boxes', 1 );

		// Filters
		add_filter( 'fl_builder_render_admin_edit_ui', __CLASS__ . '::remove_builder_edit_ui' );
	}

	/**
	 * Redirects the post-new.php page to the user templates
	 * add new page.
	 *
	 * @since 1.0
	 * @return void
	 */
	static public function redirect() {
		global $pagenow;

		$post_type = isset( $_GET['post_type'] ) ? $_GET['post_type'] : null;
		$args      = $_GET;

		if ( 'post-new.php' == $pagenow && 'fl-theme-layout' == $post_type ) {

			$args['post_type']                = 'fl-builder-template';
			$args['page']                     = 'fl-builder-add-new';
			$args['fl-builder-template-type'] = 'theme-layout';

			wp_redirect( admin_url( '/edit.php?' . http_build_query( $args ) ) );

			exit;
		}
	}

	/**
	 * Enqueues scripts and styles for the theme layout
	 * post type on the WordPress admin edit post screen.
	 *
	 * @since 1.0
	 * @return void
	 */
	static public function admin_enqueue_scripts() {
		global $pagenow;
		global $post;

		$screen  = get_current_screen();
		$version = FL_THEME_BUILDER_VERSION;

		if ( 'post.php' == $pagenow && 'fl-theme-layout' == $screen->post_type ) {

			$object = get_post_type_object( $screen->post_type );

			// Styles
			wp_enqueue_style( 'jquery-tiptip', FL_BUILDER_URL . 'css/jquery.tiptip.css', array(), $version );
			wp_enqueue_style( 'select2', FL_THEME_BUILDER_URL . 'css/select2.min.css', array(), $version );
			wp_enqueue_style( 'fl-theme-builder-layout-admin-edit', FL_THEME_BUILDER_URL . 'css/fl-theme-builder-layout-admin-edit.css', array(), $version );

			// Scripts
			wp_enqueue_script( 'jquery-tiptip', FL_BUILDER_URL . 'js/jquery.tiptip.min.js', array( 'jquery' ), $version );
			wp_enqueue_script( 'select2', FL_THEME_BUILDER_URL . 'js/select2.full.min.js', array( 'jquery' ), $version );
			wp_enqueue_script( 'fl-theme-builder-layout-admin-edit', FL_THEME_BUILDER_URL . 'js/fl-theme-builder-layout-admin-edit.js', array( 'wp-util' ), $version );

			// JS Config
			wp_localize_script( 'fl-theme-builder-layout-admin-edit', 'FLThemeBuilderConfig', array(
				'locations'  => FLThemeBuilderRulesLocation::get_admin_edit_config(),
				'exclusions' => FLThemeBuilderRulesLocation::get_exclusions_admin_edit_config(),
				'nonce'      => wp_create_nonce( 'fl-theme-builder' ),
				'postType'   => $screen->post_type,
				'layoutType' => get_post_meta( $post->ID, '_fl_theme_layout_type', true ),
				'userRules'  => FLThemeBuilderRulesUser::get_saved( $post->ID ),
				'strings'    => array(
					/* translators: %s: post or taxonomy name */
					'allObjects'       => _x( 'All %s', '%s is the post or taxonomy name.', 'bb-theme-builder' ),
					/* translators: 1: post title, 2: post label */
					'alreadySaved'     => _x( 'This location has already been added to the "%1$s" %2$s. Would you like to remove it and add it to this %1$s?', '%1$s is the post title. %2$s is the post type label.', 'bb-theme-builder' ),
					/* translators: %s: post title */
					'assignedTo'       => _x( 'Assigned to %s', '%s stands for post title.', 'bb-theme-builder' ),
					'choose'           => __( 'Choose...', 'bb-theme-builder' ),
					'postTypePlural'   => $object->label,
					'postTypeSingular' => $object->labels->singular_name,
					'search'           => __( 'Search...', 'bb-theme-builder' ),
				),
			) );
		}
	}

	/**
	 * Adds a hook to display an admin notice if there are
	 * other theme layouts of this type in the same location.
	 *
	 * @since 1.0
	 * @return void
	 */
	static public function setup_location_notice() {
		global $pagenow;
		global $post;

		if ( 'post.php' != $pagenow || ! is_object( $post ) || 'fl-theme-layout' != $post->post_type ) {
			return;
		}

		$layout_type     = get_post_meta( $post->ID, '_fl_theme_layout_type', true );
		$saved_locations = FLThemeBuilderRulesLocation::get_saved( $post->ID );
		$saved_users     = FLThemeBuilderRulesUser::get_saved( $post->ID );
		$all_locations   = FLThemeBuilderRulesLocation::get_all_saved( 'fl-theme-layout' );
		$common          = array();

		if ( 'part' == $layout_type || ! isset( $all_locations[ $layout_type ] ) ) {
			return;
		} else {
			$all_locations = $all_locations[ $layout_type ];
		}

		foreach ( $saved_locations as $saved_location ) {

			if ( ! isset( $all_locations[ $saved_location ] ) ) {
				continue;
			}

			foreach ( $all_locations[ $saved_location ] as $location_post ) {

				if ( $location_post['id'] == $post->ID ) {
					continue;
				} elseif ( 'publish' != get_post_status( $location_post['id'] ) ) {
					continue;
				}

				$post_users = FLThemeBuilderRulesUser::get_saved( $location_post['id'] );

				if ( ! empty( $saved_users ) && ! empty( $post_users ) ) {
					if ( 0 === count( array_intersect( $saved_users, $post_users ) ) ) {
						continue;
					}
				} elseif ( empty( $saved_users ) && ! empty( $post_users ) ) {
					continue;
				} elseif ( ! empty( $saved_users ) && empty( $post_users ) ) {
					continue;
				}

				$common[ $location_post['id'] ] = $location_post['title'];
			}
		}

		$common = apply_filters( 'fl_theme_builder_location_notice_posts', $common );

		if ( ! empty( $common ) ) {

			add_action( 'admin_notices', function() use ( $common ) {

				$posts = array_pop( $common );

				if ( $common ) {
					$posts = implode( ', ', $common ) . ' ' . __( 'and', 'bb-theme-builder' ) . ' ' . $posts;
				}

				$posts = '<strong>' . $posts . '</strong>';

				if ( 0 === count( $common ) ) {
					/* translators: %s: post title */
					$message = sprintf( _x( 'The layout %s is assigned to the same location and may not show.', '% is a post title.', 'bb-theme-builder' ), $posts );
				} else {
					/* translators: %s: post titles */
					$message = sprintf( _x( 'The layouts %s are assigned to the same location and may not show.', '% is post titles.', 'bb-theme-builder' ), $posts );
				}

				echo '<div class="error">';
				echo '<p>' . $message . '</p>';
				echo '</div>';

			} );
		}
	}

	/**
	 * Callback for adding meta boxes to the theme
	 * layout post edit screen.
	 *
	 * @since 1.0
	 * @return void
	 */
	static public function add_meta_boxes() {
		add_meta_box(
			'fl-theme-builder-buttons',
			FLBuilderModel::get_branding(),
			'FLBuilderUserTemplatesAdminEdit::render_buttons_meta_box',
			'fl-theme-layout',
			'normal',
			'high'
		);

		add_meta_box(
			'fl-theme-builder-settings',
			__( 'Themer Layout Settings', 'bb-theme-builder' ),
			__CLASS__ . '::settings_meta_box',
			'fl-theme-layout',
			'normal',
			'high'
		);
	}

	/**
	 * Renders the meta box for theme layout settings.
	 *
	 * @since 1.0
	 * @return void
	 */
	static public function settings_meta_box() {
		global $post;

		$type     = get_post_meta( $post->ID, '_fl_theme_layout_type', true );
		$order    = get_post_meta( $post->ID, '_fl_theme_layout_order', true );
		$hook     = get_post_meta( $post->ID, '_fl_theme_layout_hook', true );
		$settings = FLThemeBuilderLayoutData::get_settings( $post->ID );
		$hooks    = FLThemeBuilderLayoutData::get_part_hooks();

		include FL_THEME_BUILDER_DIR . 'includes/layout-admin-edit-settings.php';

		FLThemeBuilderRulesLocation::render_admin_edit_settings();
		FLThemeBuilderRulesUser::render_admin_edit_settings();
	}

	/**
	 * Prevents the standard builder admin edit UI from rendering.
	 *
	 * @since 1.0
	 * @param bool $render_ui
	 * @return bool
	 */
	static public function remove_builder_edit_ui( $render_ui ) {
		$screen = get_current_screen();

		return 'fl-theme-layout' == $screen->post_type ? false : $render_ui;
	}

	/**
	 * Save settings on the admin edit page.
	 *
	 * @since 1.0
	 * @return void
	 */
	static public function save() {
		if ( ! FLBuilderUserAccess::current_user_can( 'theme_builder_editing' ) ) {
			return;
		}
		if ( ! isset( $_POST['fl-theme-builder-nonce'] ) ) {
			return;
		}
		if ( ! wp_verify_nonce( $_POST['fl-theme-builder-nonce'], 'fl-theme-builder' ) ) {
			return;
		}

		$post_id  = absint( $_POST['post_ID'] );
		$type     = sanitize_text_field( $_POST['fl-theme-layout-type'] );
		$hook     = sanitize_text_field( $_POST['fl-theme-layout-hook'] );
		$order    = absint( $_POST['fl-theme-layout-order'] );
		$settings = array_map( 'sanitize_text_field', $_POST['fl-theme-layout-settings'] );

		update_post_meta( $post_id, '_fl_theme_layout_type', $type );
		update_post_meta( $post_id, '_fl_theme_layout_settings', $settings );

		if ( 'part' === $type ) {
			update_post_meta( $post_id, '_fl_theme_layout_hook', $hook );
			update_post_meta( $post_id, '_fl_theme_layout_order', $order );
		} else {
			delete_post_meta( $post_id, '_fl_theme_layout_hook' );
			delete_post_meta( $post_id, '_fl_theme_layout_order' );
		}

		if ( isset( $_POST['redirect'] ) && ! empty( $_POST['redirect'] ) ) {
			wp_safe_redirect( $_POST['redirect'] );
			exit;
		}
	}
}

FLThemeBuilderLayoutAdminEdit::init();
