<?php

/**
 * EDD singular support for the theme builder.
 *
 * @since 1.1
 */
final class FLThemeBuilderEDDSingular {

	/**
	 * @since 1.1
	 * @return void
	 */
	static public function init() {
		// Actions
		add_action( 'wp', __CLASS__ . '::unhook_actions', 1 );

		// Filters
		add_filter( 'fl_builder_render_css', __CLASS__ . '::render_css', 10, 4 );
		add_filter( 'body_class', __CLASS__ . '::body_class' );
		add_filter( 'fl_builder_content_classes', __CLASS__ . '::content_class' );
		add_filter( 'fl_theme_builder_content_attrs', __CLASS__ . '::content_attrs' );
	}

	/**
	 * Unhook EDD content actions as they aren't
	 * needed with theme layouts.
	 *
	 * @since 1.1
	 * @return void
	 */
	static public function unhook_actions() {
		if ( is_singular( 'download' ) && FLThemeBuilder::has_layout( 'singular' ) ) {
			remove_all_filters( 'the_content', 'edd_before_download_content' );
			remove_all_filters( 'the_content', 'edd_after_download_content' );
			remove_all_actions( 'edd_before_download_content' );
			remove_all_actions( 'edd_after_download_content' );
		}
	}

	/**
	 * Renders custom CSS for singular EDD pages.
	 *
	 * @since 1.1
	 * @param string $css
	 * @param array $nodes
	 * @param object $settings
	 * @param bool $global
	 * @return string
	 */
	static public function render_css( $css, $nodes, $settings, $global ) {
		if ( $global && 'download' == get_post_type() ) {
			$css .= file_get_contents( FL_THEME_BUILDER_EDD_DIR . 'css/fl-theme-builder-edd-singular.css' );
		}

		return $css;
	}

	/**
	 * Adds the Easy Digital Downloads body classes to theme layouts that are
	 * set to product locations.
	 *
	 * @since 1.1
	 * @param array $classes
	 * @return array
	 */
	static public function body_class( $classes ) {
		global $post;

		if ( is_singular( 'fl-theme-layout' ) ) {

			$locations   = FLThemeBuilderRulesLocation::get_saved( $post->ID );
			$locations[] = FLThemeBuilderRulesLocation::get_preview_location( $post->ID );
			$is_edd      = false;

			foreach ( $locations as $location ) {

				if ( strstr( $location, 'post:download' ) ) {
					$is_edd = true;
					break;
				} elseif ( strstr( $location, 'archive:download' ) ) {
					$is_edd = true;
					break;
				} elseif ( strstr( $location, 'taxonomy:download_category' ) ) {
					$is_edd = true;
					break;
				} elseif ( strstr( $location, 'taxonomy:download_tag' ) ) {
					$is_edd = true;
					break;
				}
			}

			if ( $is_edd ) {
				$classes[] = 'edd';
				$classes[] = 'edd-page';
			}
		}

		return $classes;
	}

	/**
	 * Adds the EDD content class to theme layouts that are
	 * set to product locations.
	 *
	 * @since 1.1
	 * @param string $classes
	 * @return string
	 */
	static public function content_class( $classes ) {
		if ( is_singular( 'download' ) ) {
			$classes .= ' edd-download';
		}

		return $classes;
	}

	/**
	 * Adds the EDD content attributes to theme layouts that are
	 * set to product locations.
	 *
	 * @since 1.1
	 * @param array $attrs
	 * @return array
	 */
	static public function content_attrs( $attrs ) {
		if ( is_singular( 'download' ) ) {
			$attrs['itemtype'] = 'http://schema.org/Product';
		}

		return $attrs;
	}
}

FLThemeBuilderEDDSingular::init();
