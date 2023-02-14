<?php

/**
 * Handles logic for the theme layout post type.
 *
 * @since 1.0
 */
final class FLThemeBuilderLayoutPostType {

	/**
	 * Initializes the theme layout post type.
	 *
	 * @since 1.0
	 * @return void
	 */
	static public function init() {
		/* Actions */
		add_action( 'init', __CLASS__ . '::register' );

		/* Filters */
		add_filter( 'template_include', __CLASS__ . '::load_page_template' );
		add_filter( 'fl_builder_post_types', __CLASS__ . '::enable_builder' );
		add_filter( 'fl_builder_admin_settings_post_types', __CLASS__ . '::remove_from_post_type_settings' );
	}

	/**
	 * Registers the theme builder layout post type.
	 *
	 * @since 1.0
	 * @return void
	 */
	static public function register() {
		$can_edit      = FLBuilderUserAccess::current_user_can( 'theme_builder_editing' );
		$builder_admin = FLBuilderUserAccess::current_user_can( 'builder_admin' );

		register_post_type( 'fl-theme-layout', apply_filters( 'fl_theme_builder_layout_register_post_type_args', array(
			'labels'              => array(
				'name'               => _x( 'Themer Layouts', 'Custom post type label.', 'bb-theme-builder' ),
				'singular_name'      => _x( 'Themer Layout', 'Custom post type label.', 'bb-theme-builder' ),
				'menu_name'          => _x( 'Themer Layouts', 'Custom post type label.', 'bb-theme-builder' ),
				'name_admin_bar'     => _x( 'Themer Layout', 'Custom post type label.', 'bb-theme-builder' ),
				'add_new'            => _x( 'Add New', 'Custom post type label.', 'bb-theme-builder' ),
				'add_new_item'       => _x( 'Add New Themer Layout', 'Custom post type label.', 'bb-theme-builder' ),
				'new_item'           => _x( 'New Themer Layout', 'Custom post type label.', 'bb-theme-builder' ),
				'edit_item'          => _x( 'Edit Themer Layout', 'Custom post type label.', 'bb-theme-builder' ),
				'view_item'          => _x( 'View Themer Layout', 'Custom post type label.', 'bb-theme-builder' ),
				'all_items'          => _x( 'All Themer Layouts', 'Custom post type label.', 'bb-theme-builder' ),
				'search_items'       => _x( 'Search Themer Layouts', 'Custom post type label.', 'bb-theme-builder' ),
				'parent_item_colon'  => _x( 'Parent Themer Layout:', 'Custom post type label.', 'bb-theme-builder' ),
				'not_found'          => _x( 'No Themer layouts found.', 'Custom post type label.', 'bb-theme-builder' ),
				'not_found_in_trash' => _x( 'No Themer layouts found in Trash.', 'Custom post type label.', 'bb-theme-builder' ),
			),
			'supports'            => array(
				'title',
				'revisions',
				'thumbnail',
			),
			'taxonomies'          => array(
				'fl-builder-template-category',
			),
			'menu_icon'           => 'dashicons-welcome-widgets-menus',
			'public'              => false,
			'publicly_queryable'  => $can_edit,
			'show_ui'             => $can_edit,
			'show_in_menu'        => false,
			'show_in_nav_menus'   => false,
			'show_in_admin_bar'   => $can_edit && $builder_admin,
			'exclude_from_search' => true,
		) ) );
	}

	/**
	 * Tries to load page.php for a header, footer or part theme layout.
	 *
	 * @since 1.0
	 * @param string $template The current template to be loaded.
	 * @return string
	 */
	static public function load_page_template( $template ) {
		global $post;

		if ( 'string' == gettype( $template ) && is_object( $post ) && 'fl-theme-layout' == $post->post_type ) {

			$type = get_post_meta( $post->ID, '_fl_theme_layout_type', true );

			if ( in_array( $type, array( 'header', 'footer', 'part' ) ) ) {

				$page = locate_template( array( 'page.php' ) );

				if ( ! empty( $page ) ) {
					return $page;
				}
			}
		}

		return $template;
	}

	/**
	 * Enable the builder for the theme layout post type.
	 *
	 * @since 1.0
	 * @param array $post_types
	 * @return array
	 */
	static public function enable_builder( $post_types ) {
		$post_types[] = 'fl-theme-layout';

		return $post_types;
	}

	/**
	 * Remove the theme layout post type from the builder settings.
	 *
	 * @since 1.0
	 * @param array $post_types
	 * @return array
	 */
	static public function remove_from_post_type_settings( $post_types ) {
		if ( isset( $post_types['fl-theme-layout'] ) ) {
			unset( $post_types['fl-theme-layout'] );
		}

		return $post_types;
	}
}

FLThemeBuilderLayoutPostType::init();
