<?php

/**
 * WPML support for the theme builder.
 *
 * @since 1.0.4
 */
final class FLThemeBuilderWPML {

	/**
	 * @since 1.0.4
	 * @return void
	 */
	static public function init() {
		// Actions
		add_action( 'wpml_pro_translation_completed', __CLASS__ . '::copy_meta_for_new' );

		// Filters
		add_filter( 'fl_theme_builder_location_notice_posts', __CLASS__ . '::location_notice_posts' );
		add_filter( 'fl_theme_builder_current_page_layouts', __CLASS__ . '::current_page_layouts' );
	}

	/**
	 * Copies Themer post meta for new translations.
	 *
	 * @since 1.0.4
	 * @param int post_id
	 * @return void
	 */
	static public function copy_meta_for_new( $post_id ) {
		global $sitepress;

		$post = get_post( $post_id );

		if ( 'fl-theme-layout' !== $post->post_type ) {
			return;
		}

		$trid             = $sitepress->get_element_trid( $post_id, 'post_fl-theme-layout' );
		$meta             = get_post_custom( $post_id );
		$original_post_id = $sitepress->get_original_element_id_by_trid( $trid );
		$original_meta    = get_post_custom( $original_post_id );

		foreach ( $original_meta as $meta_key => $meta_value ) {
			if ( strstr( $meta_key, '_fl_' ) && ! isset( $meta[ $meta_key ] ) ) {
				update_post_meta( $post_id, $meta_key, maybe_unserialize( $meta_value[0] ) );
			}
		}
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
		global $post, $sitepress;

		$wpml_post    = new WPML_Post_Element( $post->ID, $sitepress );
		$trid         = $sitepress->get_element_trid( $post->ID, 'post_fl-theme-layout' );
		$translations = $sitepress->get_element_translations( $trid, 'post_fl-theme-layout' );

		foreach ( $translations as $lang => $data ) {
			if ( isset( $posts[ $data->element_id ] ) ) {
				unset( $posts[ $data->element_id ] );
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
		global $sitepress;

		$current_lang = $sitepress->get_current_language();
		$default_lang = $sitepress->get_default_language();
		$default_post = null;

		// Loop through the layouts and try to find translations.
		foreach ( $layouts as $type => $posts ) {
			foreach ( $posts as $key => $post ) {
				$wpml_post      = new WPML_Post_Element( $post['id'], $sitepress );
				$wpml_post_lang = $wpml_post->get_language_code();

				// Store the post for the default language as a fallback.
				if ( $default_lang === $wpml_post_lang || empty( $wpml_post_lang ) ) {
					$default_post = $post;
				}

				// Unset this post if it's language isn't the current language.
				if ( $current_lang !== $wpml_post_lang && ! is_null( $wpml_post_lang ) ) {
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

FLThemeBuilderWPML::init();
