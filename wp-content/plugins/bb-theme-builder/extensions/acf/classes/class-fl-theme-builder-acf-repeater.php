<?php

/**
 * ACF repeater and flexible content shortcode
 * support for the theme builder.
 *
 * @since 1.1.2
 */
final class FLThemeBuilderACFRepeater {

	/**
	 * Shortcode tags for ACF repeater fields.
	 *
	 * @since 1.1.2
	 * @var array $repeater_shortcodes
	 */
	static private $repeater_shortcodes = array(
		'wpbb-acf-flex',
		'wpbb-acf-repeater',
	);

	/**
	 * Shortcode tags for ACF repeater field content.
	 *
	 * @since 1.1.2
	 * @var array $content_shortcodes
	 */
	static private $content_shortcodes = array(
		'wpbb',
		'wpbb-if',
		'wpbb-acf-layout',
	);

	/**
	 * All shortcode tags for ACF repeaters.
	 *
	 * @since 1.1.2
	 * @var array $all_shortcodes
	 */
	static private $all_shortcodes = array(
		'wpbb-acf-flex',
		'wpbb-acf-repeater',
		'wpbb',
		'wpbb-if',
		'wpbb-acf-layout',
	);

	/**
	 * @since 1.1.2
	 * @return void
	 */
	static public function init() {
		add_filter( 'fl_builder_before_render_shortcodes', __CLASS__ . '::parse_shortcodes', 1 );
		add_filter( 'fl_theme_builder_custom_post_grid_html', __CLASS__ . '::parse_shortcodes', 1 );

		add_shortcode( 'wpbb-acf-repeater', __CLASS__ . '::parse_shortcode' );
		add_shortcode( 'wpbb-acf-flex', __CLASS__ . '::parse_shortcode' );
		add_shortcode( 'wpbb-acf-layout', __CLASS__ . '::parse_layout_shortcode' );
	}

	/**
	 * Parse the repeater shortcode here instead of
	 * relying on do_shortcode to make sure it's parsed
	 * before other wpbb shortcodes.
	 *
	 * @since 1.1.2
	 * @param string $content
	 * @return string
	 */
	static public function parse_shortcodes( $content ) {
		return FLThemeBuilderFieldConnections::parse_shortcodes(
			$content,
			self::$repeater_shortcodes
		);
	}

	/**
	 * Parses the ACF repeater and flex shortcodes.
	 *
	 * @since 1.1.2
	 * @param array $attrs
	 * @param string $content
	 * @return string
	 */
	static public function parse_shortcode( $attrs, $content = '' ) {
		if ( ! isset( $attrs['name'] ) ) {
			return '';
		}

		// Yoast will throw a fatal error if shortcodes are found in regular wp content.
		if ( ! class_exists( 'FLPageDataACF' ) ) {
			return '';
		}

		$name   = trim( $attrs['name'] );
		$type   = isset( $attrs['type'] ) ? $attrs['type'] : 'post';
		$id     = FLPageDataACF::get_object_id_by_type( $type );
		$parsed = '';

		if ( have_rows( $name, $id ) ) {
			while ( have_rows( $name, $id ) ) {
				the_row();
				$content = self::escape_nested_shortcodes( $content );
				$row     = FLThemeBuilderFieldConnections::parse_shortcodes( $content, self::$all_shortcodes );
				$row     = self::unescape_nested_shortcodes( $row );
				$row     = FLThemeBuilderFieldConnections::parse_shortcodes( $row, self::$repeater_shortcodes );
				$parsed .= $row;
			}
		} else {
			$content = self::escape_nested_shortcodes( $content );
			$row     = FLThemeBuilderFieldConnections::parse_shortcodes( $content, self::$all_shortcodes );
			$row     = self::unescape_nested_shortcodes( $row );
			$row     = FLThemeBuilderFieldConnections::parse_shortcodes( $row, self::$repeater_shortcodes );
			$parsed .= $row;
		}

		return $parsed;
	}

	/**
	 * Parses the ACF layout shortcode for flexible content.
	 *
	 * @since 1.1.2
	 * @param array $attrs
	 * @param string $content
	 * @return string
	 */
	static public function parse_layout_shortcode( $attrs, $content = '' ) {
		if ( ! isset( $attrs['name'] ) || get_row_layout() !== $attrs['name'] ) {
			return '';
		}

		return FLThemeBuilderFieldConnections::parse_shortcodes(
			$content,
			self::$all_shortcodes
		);
	}

	/**
	 * Escapes nested wpbb shortcodes so they are not parsed
	 * when the parent repeater is.
	 *
	 * @since 1.1.2
	 * @param string $content
	 * @return string
	 */
	static public function escape_nested_shortcodes( $content ) {
		$pattern = '/\[wpbb-acf-nested-repeater.*?\][\d\D]*?\[\/wpbb-acf-nested-repeater\]/i';

		preg_match_all( $pattern, $content, $matches );

		foreach ( $matches as $match ) {
			$content = str_replace( $match, str_replace( 'wpbb', 'wpbb-nested', $match ), $content );
		}

		return $content;
	}

	/**
	 * Unescapes nested shortcodes so they can be parsed.
	 *
	 * @since 1.1.2
	 * @param string $content
	 * @return string
	 */
	static public function unescape_nested_shortcodes( $content ) {
		$content = str_replace( 'wpbb-nested', 'wpbb', $content );
		$content = str_replace( 'wpbb-acf-nested-repeater', 'wpbb-acf-repeater', $content );
		return $content;
	}
}

FLThemeBuilderACFRepeater::init();
