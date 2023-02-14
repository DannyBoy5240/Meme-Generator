<?php

/**
 * Handles frontend editing UI logic for theme layouts.
 *
 * @since 1.0
 */
final class FLThemeBuilderLayoutFrontendEdit {

	/**
	 * Initializes hooks.
	 *
	 * @since 1.0
	 * @return void
	 */
	static public function init() {
		// Actions
		add_action( 'wp_enqueue_scripts', __CLASS__ . '::enqueue_scripts', 11 );
	}

	/**
	 * Enqueues styles and scripts for the editing UI.
	 *
	 * @since 1.0
	 * @return void
	 */
	static public function enqueue_scripts() {
		$post = FLThemeBuilderRulesLocation::get_preview_original_post();

		if ( ! $post || 'fl-theme-layout' != $post->post_type ) {
			return;
		}

		wp_enqueue_style( 'fl-theme-builder-layout-frontend-edit', FL_THEME_BUILDER_URL . 'css/fl-theme-builder-layout-frontend-edit.css', array(), FL_THEME_BUILDER_VERSION );

		wp_enqueue_script( 'fl-theme-builder-layout-frontend-edit', FL_THEME_BUILDER_URL . 'js/fl-theme-builder-layout-frontend-edit.js', array(), FL_THEME_BUILDER_VERSION );
	}
}

FLThemeBuilderLayoutFrontendEdit::init();
