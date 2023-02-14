<?php

/**
 * Polylang support for the theme builder.
 *
 * @since 1.0.4
 */
final class FLThemeBuilderPolylang {

	/**
	 * @since 1.0.4
	 * @return void
	 */
	static public function init() {
		add_filter( 'pll_get_post_types', __CLASS__ . '::filter_post_types' );
		add_filter( 'fl_theme_builder_location_notice_posts', __CLASS__ . '::location_notice_posts' );
		add_filter( 'fl_theme_builder_current_page_layouts', __CLASS__ . '::current_page_layouts' );
	}

	/**
	 * Enables translation for the theme layouts post type.
	 *
	 * @since 1.0.4
	 * @param array $post_types
	 * @return array
	 */
	static public function filter_post_types( $post_types ) {
		$post_types['fl-theme-layout'] = 'fl-theme-layout';
		return $post_types;
	}

	/**
	 * Prevents the duplicate location notice from showing
	 * for translated layouts.
	 *
	 * @since 1.0.4
	 * @param array $posts
	 * @return array
	 */
	static public function location_notice_posts( $posts ) {
		global $post;

		$lang = pll_get_post_language( $post->ID );

		foreach ( $posts as $post_id => $post_title ) {
			if ( pll_get_post_language( $post_id ) !== $lang ) {
				unset( $posts[ $post_id ] );
			}
		}

		return $posts;
	}

	/**
	 * Filters the current page layouts so the correct layout
	 * is rendered for the current language.
	 *
	 * @since 1.0.4
	 * @param array $layouts
	 * @return array
	 */
	static public function current_page_layouts( $layouts ) {
		$current_lang = pll_current_language();
		$default_lang = pll_default_language();
		$default_post = null;

		foreach ( $layouts as $type => $posts ) {

			$default = $posts;

			foreach ( $posts as $key => $post ) {

				// Store the post for the default language as a fallback.
				if ( pll_get_post( $post['id'], $default_lang ) ) {
					$default_post = $post;
				}

				// Unset this post if it's language isn't the current language.
				if ( pll_get_post_language( $post['id'] ) !== $current_lang ) {
					unset( $layouts[ $type ][ $key ] );
				}
			}

			// Fallback to the default language if we don't have any posts.
			if ( $default_post && 0 === count( $layouts[ $type ] ) ) {
				$layouts[ $type ][] = $default_post;
			}
		}

		return $layouts;
	}
}

FLThemeBuilderPolylang::init();
