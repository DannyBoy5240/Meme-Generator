<?php

/**
 * Handles logic for theme layout templates.
 *
 * @since 1.0
 */
final class FLThemeBuilderLayoutTemplates {

	/**
	 * Initializes hooks.
	 *
	 * @since 1.0
	 * @return void
	 */
	static public function init() {
		self::register_templates();

		// Actions
		add_action( 'fl_builder_template_selector_data_type', __CLASS__ . '::template_selector_data_type' );
		add_action( 'fl_builder_after_save_user_template', __CLASS__ . '::after_save_user_template' );

		// Filters
		add_filter( 'fl_builder_template_selector_data', __CLASS__ . '::template_selector_data', 10, 2 );
		add_filter( 'fl_builder_override_apply_template', __CLASS__ . '::override_apply_template', 1, 2 );
	}

	/**
	 * Register theme layout templates.
	 *
	 * @since 1.0
	 * @return void
	 */
	static public function register_templates() {

		$templates = array(
			FL_THEME_BUILDER_DIR . 'data/templates-header.dat',
			FL_THEME_BUILDER_DIR . 'data/templates-footer.dat',
			FL_THEME_BUILDER_DIR . 'data/templates-singular.dat',
			FL_THEME_BUILDER_DIR . 'data/templates-archive.dat',
			FL_THEME_BUILDER_DIR . 'data/templates-404.dat',
		);

		foreach ( $templates as $path ) {
			if ( file_exists( $path ) ) {
				FLBuilder::register_templates( $path );
			}
		}
	}

	/**
	 * Sets the template selector data type for theme templates.
	 *
	 * @since 1.0
	 * @param string $type
	 * @return string
	 */
	static public function template_selector_data_type( $type ) {
		global $post;

		if ( is_object( $post ) && 'fl-theme-layout' == $post->post_type && 'layout' == $type ) {

			$layout_type = get_post_meta( $post->ID, '_fl_theme_layout_type', true );
			$types       = array( 'header', 'footer', 'archive', 'singular', '404' );

			if ( $layout_type && in_array( $layout_type, $types ) ) {
				return $layout_type;
			}
		}

		return $type;
	}

	/**
	 * Filters out templates for plugins that aren't currently
	 * active like WooCommerce.
	 *
	 * @since 1.0
	 * @param array $data
	 * @param string $type
	 * @return void
	 */
	static public function template_selector_data( $data, $type ) {

		if ( ! in_array( $type, array( 'singular', 'archive' ) ) ) {
			return $data;
		}

		$filter = array();

		if ( ! class_exists( 'WooCommerce' ) ) {
			$filter[] = 'Product';
			$filter[] = 'Products';
		}

		if ( ! function_exists( 'bigcommerce' ) ) {
			$filter[] = 'BigCommerce';
		}

		if ( ! defined( 'TRIBE_EVENTS_FILE' ) ) {
			$filter[] = 'Event';
			$filter[] = 'Events';
		}

		if ( ! defined( 'EVENTS_CALENDAR_PRO_FILE' ) ) {
			$filter[] = 'Event Venue';
			$filter[] = 'Event Organizer';
		}

		if ( ! class_exists( 'Easy_Digital_Downloads' ) ) {
			$filter[] = 'Download';
			$filter[] = 'Downloads';
		}

		if ( empty( $filter ) ) {
			return $data;
		}

		foreach ( $data['templates'] as $key => $template ) {
			if ( in_array( $template['name'], $filter ) ) {
				unset( $data['templates'][ $key ] );
			}
		}

		foreach ( $data['categorized'] as $cat_key => $cat_data ) {
			foreach ( $cat_data['templates'] as $key => $template ) {
				if ( in_array( $template['name'], $filter ) ) {
					unset( $data['categorized'][ $cat_key ]['templates'][ $key ] );
				}
			}
		}

		return $data;
	}

	/**
	 * Overrides template data with theme layout template data
	 * when applying a core template.
	 *
	 * @since 1.0
	 * @param bool  $override
	 * @param array $data
	 * @return bool
	 */
	static public function override_apply_template( $override, $data ) {
		global $post;

		if ( is_object( $post ) && 'fl-theme-layout' == $post->post_type ) {

			$layout_type = get_post_meta( $post->ID, '_fl_theme_layout_type', true );
			$types       = array( 'header', 'footer', 'archive', 'singular', '404' );

			if ( $layout_type && in_array( $layout_type, $types ) ) {

				// In BB 2.0 we must return the result instead of a boolean value.
				$result = FLBuilderModel::apply_core_template( $data['index'], $data['append'], $layout_type );

				if ( ! empty( $result ) ) {
					return $result;
				}

				return true;
			}
		}

		return false;
	}

	/**
	 * Saves theme layout post meta along with user templates if
	 * the template being saved is of a theme layout.
	 *
	 * @since 1.0
	 * @param int $post_id
	 * @return void
	 */
	static public function after_save_user_template( $template_id ) {
		global $post;

		if ( is_object( $post ) && 'fl-theme-layout' == $post->post_type ) {

			$layout_type = get_post_meta( $post->ID, '_fl_theme_layout_type', true );

			if ( $layout_type ) {
				update_post_meta( $template_id, '_fl_theme_layout_type', $layout_type );
			}
		}
	}
}

FLThemeBuilderLayoutTemplates::init();
