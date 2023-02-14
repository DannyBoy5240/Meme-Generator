<?php

/**
 * Handles logic for the theme layout data.
 *
 * @since 1.0
 */
final class FLThemeBuilderLayoutData {

	/**
	 * Cached layout data for the current page indexed by type.
	 *
	 * @since 1.0
	 * @access private
	 * @var array $current_page_layouts
	 */
	static private $current_page_layouts = null;

	/**
	 * Checks to see if the current post is a theme
	 * layout of a certain type.
	 *
	 * @since 1.0
	 * @param string|array $type
	 * @return bool
	 */
	static public function current_post_is( $type = null ) {
		global $post;

		if ( ! $type || 'fl-theme-layout' != get_post_type() ) {
			return false;
		}

		$saved_type = get_post_meta( $post->ID, '_fl_theme_layout_type', true );

		if ( is_array( $type ) ) {
			return in_array( $saved_type, $type );
		} else {
			return $saved_type == $type;
		}
	}

	/**
	 * Checks to see if a layout with the given post ID
	 * is supported by the current theme.
	 *
	 * @since 1.0
	 * @param int $post_id
	 * @return bool
	 */
	static public function is_layout_supported( $post_id ) {
		$type = get_post_meta( $post_id, '_fl_theme_layout_type', true );

		if ( ! $type ) {
			return false;
		} elseif ( 'header' == $type ) {
			return get_theme_support( 'fl-theme-builder-headers' );
		} elseif ( 'footer' == $type ) {
			return get_theme_support( 'fl-theme-builder-footers' );
		} elseif ( 'part' == $type ) {
			return get_theme_support( 'fl-theme-builder-parts' );
		}

		return true;
	}

	/**
	 * Returns the settings for a layout.
	 *
	 * @since 1.0
	 * @param int $post_id
	 * @return array
	 */
	static public function get_settings( $post_id ) {
		$defaults = array(
			'sticky'     => 0,
			'shrink'     => 0,
			'overlay'    => 0,
			'overlay_bg' => 'transparent',
		);

		$settings = get_post_meta( $post_id, '_fl_theme_layout_settings', true );

		if ( ! $settings ) {
			$settings = array();
		}

		return array_merge( $defaults, $settings );
	}

	/**
	 * Returns an array of hook data for theme part layouts.
	 *
	 * @since 1.0
	 * @return array
	 */
	static public function get_part_hooks() {
		return apply_filters( 'fl_theme_builder_part_hooks', array() );
	}

	/**
	 * Returns the post IDs for the current page's header layouts.
	 *
	 * @since 1.0
	 * @return array
	 */
	static public function get_current_page_header_ids() {
		return self::get_current_page_layout_ids( 'header' );
	}

	/**
	 * Returns the post IDs for the current page's content layouts.
	 *
	 * @since 1.0
	 * @return array
	 */
	static public function get_current_page_content_ids() {
		// Return IDs for content if we are editing a layout.
		if ( 'fl-theme-layout' == get_post_type() ) {

			$post_id = get_the_ID();
			$type    = get_post_meta( $post_id, '_fl_theme_layout_type', true );

			if ( in_array( $type, array( 'singular', 'archive', '404', 'part' ) ) ) {
				return self::get_current_page_layout_ids( $type );
			} elseif ( ! FLThemeBuilderLayoutData::is_layout_supported( $post_id ) ) {
				return self::get_current_page_layout_ids( $type );
			}
		}

		// Return IDs for standard WP pages when not editing.
		if ( is_search() || is_archive() || is_home() ) {
			$content = 'archive';
		} elseif ( is_singular() ) {
			$content = 'singular';
		} else {
			$content = '404';
		}

		return self::get_current_page_layout_ids( $content );
	}

	/**
	 * Returns the post IDs for the current
	 * page's footer layouts.
	 *
	 * @since 1.0
	 * @return array
	 */
	static public function get_current_page_footer_ids() {
		return self::get_current_page_layout_ids( 'footer' );
	}

	/**
	 * Returns the post IDs for the current page's
	 * layouts of the specified type.
	 *
	 * @since 1.0
	 * @param string $type
	 * @return array
	 */
	static public function get_current_page_layout_ids( $type = null ) {
		$ids = array();

		if ( $type ) {
			$is_themer_layout            = 'fl-theme-layout' != get_post_type();
			$is_singular                 = 'singular' == $type && is_singular();
			$is_builder_enabled          = FLBuilderModel::is_builder_enabled();
			$is_content_building_enabled = FLThemeBuilderFrontendEdit::is_content_building_enabled();

			// Make the builder still work on standard singular posts/pages?
			if ( $is_themer_layout && $is_singular && $is_builder_enabled && ! $is_content_building_enabled ) {
				return array();
			}

			$layouts = self::get_current_page_layouts( $type );

			foreach ( $layouts as $layout ) {
				$ids[] = $layout['id'];
			}
		} else {

			$all_layouts = self::get_current_page_layouts();

			foreach ( $all_layouts as $layout_type => $layouts ) {
				foreach ( $layouts as $layout ) {
					$ids[] = $layout['id'];
				}
			}
		}

		return $ids;
	}

	/**
	 * Returns an array of layout IDs of a certain type
	 * for the current page.
	 *
	 * @since 1.0
	 * @param string $type
	 * @return array
	 */
	static public function get_current_page_layouts( $type = null ) {
		if ( ! self::$current_page_layouts ) {

			$layouts    = array();
			$headers    = get_theme_support( 'fl-theme-builder-headers' );
			$footers    = get_theme_support( 'fl-theme-builder-footers' );
			$parts      = get_theme_support( 'fl-theme-builder-parts' );
			$posts      = FLThemeBuilderRulesLocation::get_current_page_posts();
			$post_id    = get_the_ID();
			$post_type  = get_post_type();
			$saved_type = null;

			if ( 'fl-theme-layout' == $post_type ) {

				$saved_type = get_post_meta( $post_id, '_fl_theme_layout_type', true );

				if ( ! isset( $posts[ $post_id ] ) ) {
					// php 5.6 and below we can just add the array to $posts
					if ( version_compare( PHP_VERSION, '7.0.0', '<' ) ) {
						$posts[ $post_id ] = array(
							'id'        => $post_id,
							'locations' => array( 'general:single' ),
						);
					} else {
						// php7 and above we need to merge in the array
						$temp             = array();
						$temp[ $post_id ] = array(
							'id'        => $post_id,
							'locations' => array( 'general:single' ),
						);
						$posts            = array_merge( $temp, $posts );
						unset( $temp );
					}
				}
			}

			foreach ( $posts as $post ) {

				$meta          = get_post_custom( $post['id'] );
				$post['type']  = $meta['_fl_theme_layout_type'][0];
				$post['hook']  = isset( $meta['_fl_theme_layout_hook'] ) ? $meta['_fl_theme_layout_hook'][0] : false;
				$post['order'] = isset( $meta['_fl_theme_layout_order'] ) ? $meta['_fl_theme_layout_order'][0] : false;

				if ( ! $headers && 'header' == $post['type'] ) {
					continue;
				} elseif ( ! $footers && 'footer' == $post['type'] ) {
					continue;
				} elseif ( ! $parts && 'part' == $post['type'] ) {
					continue;
				}

				if ( 'singular' == $post['type'] ) {

					if ( 'fl-theme-layout' == $post_type && $post_id != $post['id'] ) {
						continue;
					}
					if ( in_array( $saved_type, array( 'archive', '404' ) ) ) {
						continue;
					}
				}

				if ( 'fl-theme-layout' == $post_type && $post['id'] == $post_id ) {
					$post['users'] = array();
				}

				if ( ! isset( $layouts[ $post['type'] ] ) ) {
					$layouts[ $post['type'] ] = array();
				}

				$layouts[ $post['type'] ][] = $post;
			}

			foreach ( $layouts as $layout_type => $layout_array ) {
				$layout_location_data = FLThemeBuilderRulesLocation::get_posts_from_array( $layout_array, $layout_type );

				if ( empty( $layout_location_data ) ) {
					unset( $layouts[ $layout_type ] );
					continue;
				}

				$layouts[ $layout_type ] = $layout_location_data;

				$layout_user_data = FLThemeBuilderRulesUser::get_posts_from_array( $layouts[ $layout_type ] );

				if ( empty( $layout_user_data ) ) {
					unset( $layouts[ $layout_type ] );
					continue;
				}

				$layouts[ $layout_type ] = $layout_user_data;

				uasort( $layouts[ $layout_type ], array( 'FLThemeBuilderLayoutData', 'order_layouts' ) );
			}

			self::$current_page_layouts = apply_filters( 'fl_theme_builder_current_page_layouts', $layouts );
		}

		if ( ! $type ) {
			return self::$current_page_layouts;
		} elseif ( isset( self::$current_page_layouts[ $type ] ) ) {
			return self::$current_page_layouts[ $type ];
		}

		return array();
	}

	/**
	 * Sets the current page layout to the one with the
	 * given layout ID.
	 *
	 * @since 1.0
	 * @param int $layout_id
	 * @return void
	 */
	static public function set_current_page_layout( $layout_id ) {
		$type = get_post_meta( $layout_id, '_fl_theme_layout_type', true );

		if ( ! $type ) {
			return;
		}

		self::$current_page_layouts[ $type ] = array(
			array(
				'id'        => $layout_id,
				'type'      => $type,
				'locations' => array( FLThemeBuilderRulesLocation::get_current_page_location() ),
			),
		);

		FLThemeBuilderFieldConnections::connect_all_layout_settings();
	}

	/**
	 * Callback for the uasort function to order layouts.
	 *
	 * @since 1.0
	 * @param int $a The first layout.
	 * @param int $b The second layout.
	 * @return int
	 */
	static public function order_layouts( $a, $b ) {
		return (int) $a['order'] - (int) $b['order'];
	}
}
