<?php

/**
 * Handles logic for the theme builder admin menu.
 *
 * @since 1.0
 */
final class FLThemeBuilderAdminMenu {

	/**
	 * Initialize hooks.
	 *
	 * @since 1.0
	 * @return void
	 */
	static public function init() {
		add_filter( 'fl_builder_user_templates_admin_menu', __CLASS__ . '::register' );
		add_filter( 'parent_file', __CLASS__ . '::parent_file', 999 );
		add_filter( 'submenu_file', __CLASS__ . '::submenu_file', 999, 2 );
	}

	/**
	 * Adds the theme builder menu items to the templates admin menu.
	 *
	 * @since 1.0
	 * @param array $menu
	 * @return array
	 */
	static public function register( $menu ) {
		$menu[50] = array(
			__( 'Themer Layouts', 'bb-theme-builder' ),
			'edit_posts',
			'edit.php?post_type=fl-theme-layout',
		);

		ksort( $menu );

		return $menu;
	}

	/**
	 * Sets the templates admin menu to the active item.
	 *
	 * @since 1.0
	 * @param string $parent_file
	 * @return string
	 */
	static public function parent_file( $parent_file ) {
		global $pagenow;

		$post_type = isset( $_GET['post_type'] ) ? $_GET['post_type'] : null;
		$screen    = get_current_screen();

		if ( 'edit.php' == $pagenow && 'fl-theme-layout' == $post_type ) {
			$parent_file = 'edit.php?post_type=fl-builder-template';
		} elseif ( 'post.php' == $pagenow && 'fl-theme-layout' == $screen->post_type ) {
			$parent_file = 'edit.php?post_type=fl-builder-template';
		}

		return $parent_file;
	}

	/**
	 * Sets the active menu item for the templates admin submenu.
	 *
	 * @since 1.0
	 * @param string $submenu_file
	 * @param string $parent_file
	 * @return string
	 */
	static public function submenu_file( $submenu_file, $parent_file ) {
		global $pagenow;

		$post_type = isset( $_GET['post_type'] ) ? $_GET['post_type'] : null;
		$screen    = get_current_screen();

		if ( 'edit.php' == $pagenow && 'fl-theme-layout' == $post_type ) {
			$submenu_file = admin_url( 'edit.php?post_type=fl-theme-layout' );
		} elseif ( 'post.php' == $pagenow && 'fl-theme-layout' == $screen->post_type ) {
			$submenu_file = admin_url( 'edit.php?post_type=fl-theme-layout' );
		}

		return $submenu_file;
	}
}

FLThemeBuilderAdminMenu::init();
