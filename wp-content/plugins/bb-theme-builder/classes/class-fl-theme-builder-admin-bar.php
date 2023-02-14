<?php

/**
 * Handles admin bar logic for the theme builder.
 *
 * @since 1.0.1
 */
final class FLThemeBuilderAdminBar {

	/**
	 * Initialize admin bar logic.
	 *
	 * @since 1.0.1
	 * @return void
	 */
	static public function init() {
		add_action( 'wp', __CLASS__ . '::setup' );
	}

	/**
	 * Setup hooks.
	 *
	 * @since 1.0.1
	 * @return void
	 */
	static public function setup() {

		if ( is_admin() || ! is_admin_bar_showing() ) {
			return;
		}
		if ( ! FLBuilderUserAccess::current_user_can( 'theme_builder_editing' ) ) {
			return;
		}

		add_action( 'wp_enqueue_scripts', __CLASS__ . '::enqueue_scripts' );

		if ( 'fl-theme-layout' == get_post_type() ) {
			return;
		}

		add_action( 'admin_bar_menu', __CLASS__ . '::add_builder_dropdown', 1000 );
	}

	/**
	 * Enqueues admin bar styles and scripts.
	 *
	 * @since 1.0.1
	 * @return void
	 */
	static public function enqueue_scripts() {

		$layouts = FLThemeBuilderLayoutData::get_current_page_layouts();

		if ( count( $layouts ) ) {
			wp_enqueue_style( 'fl-theme-builder-admin-bar', FL_THEME_BUILDER_URL . 'css/fl-theme-builder-admin-bar.css', array(), FL_THEME_BUILDER_VERSION );
			wp_enqueue_script( 'fl-theme-builder-admin-bar', FL_THEME_BUILDER_URL . 'js/fl-theme-builder-admin-bar.js', array( 'jquery' ), FL_THEME_BUILDER_VERSION );
		}
	}

	/**
	 * Adds the drop down menu for the Page Builder
	 * admin link if the current location has layouts.
	 *
	 * @since 1.0.1
	 * @param object $bar An instance of the WordPress admin bar.
	 * @return void
	 */
	static public function add_builder_dropdown( $bar ) {

		global $wp_the_query;

		$layouts = FLThemeBuilderLayoutData::get_current_page_layouts();
		$parent  = $bar->get_node( 'fl-builder-frontend-edit-link' );

		if ( count( $layouts ) ) {

			if ( ! $parent ) {
				$bar->add_node( array(
					'id'    => 'fl-builder-frontend-edit-link',
					'title' => '<span class="ab-icon"></span>' . FLBuilderModel::get_branding(),
					'href'  => '',
				));
			} else {

				$post_type = get_post_type_object( $wp_the_query->post->post_type );
				$title     = '<span class="fl-builder-ab-title">' . get_the_title( $wp_the_query->post->ID ) . '</span>';
				$tag       = '<span class="fl-builder-ab-tag">' . $post_type->labels->singular_name . '</span>';

				$bar->add_node( array(
					'parent' => 'fl-builder-frontend-edit-link',
					'id'     => 'fl-theme-builder-frontend-edit-link',
					'title'  => $title . $tag,
					'href'   => FLBuilderModel::get_edit_url( $wp_the_query->post->ID ),
				));
			}
		}

		foreach ( $layouts as $type => $data ) {

			if ( ! is_array( $data ) ) {
				continue;
			}

			foreach ( $data as $layout ) {

				$type_text = $type;
				switch ( $type ) {

					case 'header':
						$type_text = __( 'HEADER', 'bb-theme-builder' );
						break;
					case 'footer':
						$type_text = __( 'FOOTER', 'bb-theme-builder' );
						break;
					case 'part':
						$type_text = __( 'PART', 'bb-theme-builder' );
						break;
					case 'archive':
						$type_text = __( 'ARCHIVE', 'bb-theme-builder' );
						break;
					case 'singular':
						$type_text = __( 'SINGULAR', 'bb-theme-builder' );
						break;
				}

				$title = '<span class="fl-builder-ab-title">' . get_the_title( $layout['id'] ) . '</span>';
				$tag   = sprintf( '<span class="fl-builder-ab-tag">%s</span>', $type_text );
				$cog   = sprintf( '<span class="fl-builder-ab-wrench ab-icon dashicons dashicons-admin-generic" title="Open in wp-admin" data-edit="%s"></span>', urlencode( get_edit_post_link( $layout['id'] ) ) );

				$redirect = ( ! is_archive() && ! is_home() ) ? get_permalink() : $_SERVER['REQUEST_URI'];

				$bar->add_node( array(
					'parent' => 'fl-builder-frontend-edit-link',
					'id'     => 'fl-theme-builder-edit-link-' . $layout['id'],
					'title'  => $title . $tag . $cog,
					'href'   => add_query_arg( array( 'r' => urlencode( $redirect ) ), FLBuilderModel::get_edit_url( $layout['id'] ) ),
				));

				if ( 'part' !== $type ) {
					break;
				}
			}
		}
	}
}

FLThemeBuilderAdminBar::init();
