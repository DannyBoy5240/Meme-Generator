<?php

/**
 * Handles frontend editing UI logic for the builder.
 *
 * @since 1.0
 */
final class FLThemeBuilderFrontendEdit {

	/**
	 * Initializes hooks.
	 *
	 * @since 1.0
	 * @return void
	 */
	static public function init() {
		// Actions
		add_action( 'wp_enqueue_scripts', __CLASS__ . '::enqueue_scripts', 11 );
		add_action( 'fl_builder_enabled_modules', __CLASS__ . '::enable_modules' );

		// Filters
		add_filter( 'fl_builder_main_menu', __CLASS__ . '::maybe_add_tools_menu_item' );

		// Frontend AJAX
		FLBuilderAJAX::add_action( 'enable_content_building_for_post', __CLASS__ . '::enable_content_building' );
		FLBuilderAJAX::add_action( 'disable_content_building_for_post', __CLASS__ . '::disable_content_building' );
		add_action( 'fl_ajax_before_call_action', __CLASS__ . '::reset_content_building' );
		add_action( 'pre_post_update', __CLASS__ . '::unset_content', 11, 2 );
	}

	/**
	 * Enqueues styles and scripts for the editing UI.
	 *
	 * @since 1.0
	 * @return void
	 */
	static public function enqueue_scripts() {

		global $wp_the_query;

		if ( ! FLBuilderModel::is_builder_active() ) {
			return;
		} elseif ( ! is_object( $wp_the_query ) || ! is_object( $wp_the_query->post ) ) {
			return;
		} elseif ( 'fl-theme-layout' == $wp_the_query->post->post_type ) {
			return;
		}

		$post       = $wp_the_query->post;
		$post_type  = get_post_type_object( $post->post_type );
		$post_label = strtolower( $post_type->labels->singular_name );

		wp_enqueue_style( 'fl-theme-builder-frontend-edit', FL_THEME_BUILDER_URL . 'css/fl-theme-builder-frontend-edit.css', array(), FL_THEME_BUILDER_VERSION );

		wp_enqueue_script( 'fl-theme-builder-frontend-edit', FL_THEME_BUILDER_URL . 'js/fl-theme-builder-frontend-edit.js', array(), FL_THEME_BUILDER_VERSION );

		wp_localize_script( 'fl-theme-builder-frontend-edit', 'FLThemeBuilderConfig', array(
			'adminEditURL' => admin_url( '/post.php?post=' . $post->ID . '&action=edit' ),
			'layouts'      => FLThemeBuilderLayoutData::get_current_page_layouts(),
			'editMode'     => self::get_edit_mode(),
			'strings'      => array(
				/* translators: 1: post type label, 2: custom builder branding */
				'overrideWarning'        => sprintf( _x( 'This %1$s has a Themer layout assigned to it. Would you like %2$s to override the entire layout or only the content for this %1$s?', '%1$s post type label. %2$s custom builder branding.', 'bb-theme-builder' ), $post_label, FLBuilderModel::get_branding() ),
				'overrideWarningContent' => __( 'Edit Content Only', 'bb-theme-builder' ),
				'overrideWarningLayout'  => __( 'Override Layout', 'bb-theme-builder' ),
				'overrideWarningCancel'  => __( 'Cancel', 'bb-theme-builder' ),
			),
		) );
	}

	/**
	 * Makes sure theme builder modules are enabled.
	 *
	 * @since 1.0.1
	 * @param array $modules
	 * @return array
	 */
	static public function enable_modules( $modules ) {
		return array_merge( $modules, FLThemeBuilderLoader::get_loaded_modules() );
	}

	/**
	 * @since 1.4
	 * @return void
	 */
	static public function maybe_add_tools_menu_item( $menu ) {
		global $wp_the_query;

		$layouts = FLThemeBuilderLayoutData::get_current_page_layouts();

		if ( isset( $layouts['singular'] ) && count( $layouts['singular'] ) ) {
			$mode                      = self::get_edit_mode();
			$indicator                 = ! $mode || 'layout' === $mode ? '<span class="menu-event event-showGlobalSettings">&bull;</span>' : '';
			$menu['main']['items'][67] = array(
				'label'     => __( 'Themer Override', 'bb-theme-builder' ) . $indicator,
				'type'      => 'event',
				'eventName' => 'showThemerOverrideSettings',
				'extra'     => 'test',
			);
		}

		return $menu;
	}

	/**
	 * @since 1.4
	 * @return void
	 */
	static public function enable_content_building() {
		$post_data = FLBuilderModel::get_post_data();
		update_post_meta( $post_data['post_id'], '_fl_theme_builder_edit_mode', 'content' );

		// user has just enabled, setup a temp var so we can discard cleanly
		update_post_meta( $post_data['post_id'], '_fl_theme_builder_edit_mode_temp', true );
	}

	/**
	 * @since 1.4
	 * @return void
	 */
	static public function disable_content_building() {
		$post_data = FLBuilderModel::get_post_data();
		update_post_meta( $post_data['post_id'], '_fl_theme_builder_edit_mode', 'layout' );
	}

	/**
	 * @since 1.4
	 */
	static public function reset_content_building( $action ) {

		/**
		 * During discard if _fl_theme_builder_edit_mode_temp is set
		 * we want to reset editing mode
		 */
		if ( 'clear_draft_layout' === $action ) {
			$post_data = FLBuilderModel::get_post_data();
			if ( get_post_meta( $post_data['post_id'], '_fl_theme_builder_edit_mode_temp', true ) ) {
				delete_post_meta( $post_data['post_id'], '_fl_theme_builder_edit_mode_temp' );
				delete_post_meta( $post_data['post_id'], '_fl_theme_builder_edit_mode' );
			}
		}

		/**
		 * During save layout we can remove _fl_theme_builder_edit_mode_temp now.
		 */
		if ( 'save_layout' === $action ) {
			$post_data = FLBuilderModel::get_post_data();
			if ( get_post_meta( $post_data['post_id'], '_fl_theme_builder_edit_mode_temp', true ) ) {
				delete_post_meta( $post_data['post_id'], '_fl_theme_builder_edit_mode_temp' );
			}
		}
	}

	/**
	 * @since 1.4
	 * @return bool
	 */
	static public function get_edit_mode( $post_id = null ) {
		$post_id = $post_id ? $post_id : get_the_ID();
		return get_post_meta( $post_id, '_fl_theme_builder_edit_mode', true );
	}

	/**
	 * @since 1.4
	 * @return bool
	 */
	static public function is_content_building_enabled( $post_id = null ) {
		return 'content' === self::get_edit_mode( $post_id );
	}

	static public function unset_content( $post_id, $new_post ) {
		if ( ! get_post_meta( $post_id, '_fl_builder_enabled', true ) && ! wp_is_post_revision( $post_id ) ) {
			delete_post_meta( $post_id, '_fl_theme_builder_edit_mode', '' );
		}
	}
}

FLThemeBuilderFrontendEdit::init();
