<?php

/**
 * Handles logic for rendering theme layouts.
 *
 * @since 1.0
 */
final class FLThemeBuilderLayoutRenderer {

	/**
	 * Initialize hooks.
	 *
	 * @since 1.0
	 * @return void
	 */
	static public function init() {
		// Actions
		add_action( 'after_switch_theme', __CLASS__ . '::delete_all_bundled_scripts' );
		//add_action( 'fl_builder_after_save_layout', __CLASS__ . '::delete_all_bundled_scripts' );
		add_action( 'template_redirect', __CLASS__ . '::disable_content_rendering' );
		add_action( 'template_redirect', __CLASS__ . '::setup_part_hooks' );
		add_action( 'wp_enqueue_scripts', __CLASS__ . '::enqueue_scripts' );
		add_action( 'template_include', __CLASS__ . '::override_template_include', 999 );

		// Filters
		add_filter( 'body_class', __CLASS__ . '::body_class' );
		add_filter( 'fl_builder_render_js', __CLASS__ . '::render_js' );
		add_filter( 'fl_builder_render_css', __CLASS__ . '::render_css' );
		add_filter( 'fl_theme_builder_render_header', __CLASS__ . '::render_header' );
		add_filter( 'fl_theme_builder_render_footer', __CLASS__ . '::render_footer' );
	}

	/**
	 * Setup the hooks for rendering content parts.
	 *
	 * @since 1.0
	 * @return void
	 */
	static public function setup_part_hooks() {
		$parts = FLThemeBuilderLayoutData::get_current_page_layouts( 'part' );

		foreach ( $parts as $part ) {

			if ( $part['hook'] ) {

				add_action( $part['hook'], function() use ( $part ) {

					FLBuilder::render_content_by_id( $part['id'], 'div', array(
						'data-type' => 'part',
					) );

				}, ( $part['order'] ? $part['order'] : 10 ) );
			}
		}
	}

	/**
	 * Adds theme layout body classes if theme layouts
	 * are present.
	 *
	 * @since 1.0
	 * @param array $classes
	 * @return array
	 */
	static public function body_class( $classes ) {

		$layouts     = FLThemeBuilderLayoutData::get_current_page_layouts();
		$layout_slug = '';
		foreach ( $layouts as $key => $data ) {
			foreach ( $data as $layout_info ) {
				$layout_slug = get_post_field( 'post_name', $layout_info['id'] );
			}
			$classes[] = 'fl-theme-builder-' . $key;
			if ( $layout_slug ) {
				$classes[] = 'fl-theme-builder-' . $key . '-' . $layout_slug;
			}
		}

		return $classes;
	}

	/**
	 * Renders the JS for theme builder layouts and adds
	 * it to the cached builder JS layout file.
	 *
	 * @since 1.0
	 * @param string $js
	 * @return string
	 */
	static public function render_js( $js ) {
		$post_id     = FLBuilderModel::get_post_id();
		$layout_type = get_post_meta( $post_id, '_fl_theme_layout_type', true );

		if ( ! $layout_type ) {
			return $js;
		}

		if ( 'header' == $layout_type ) {
			$js .= file_get_contents( FL_THEME_BUILDER_DIR . 'js/fl-theme-builder-header-layout.js' );
		}

		return $js;
	}

	/**
	 * Renders the CSS for theme builder layouts and adds
	 * it to the cached builder CSS layout file.
	 *
	 * @since 1.0
	 * @param string $css
	 * @return string
	 */
	static public function render_css( $css ) {
		$post_id     = FLBuilderModel::get_post_id();
		$layout_type = get_post_meta( $post_id, '_fl_theme_layout_type', true );

		if ( ! $layout_type ) {
			return $css;
		}

		if ( 'header' == $layout_type ) {
			$css .= file_get_contents( FL_THEME_BUILDER_DIR . 'css/fl-theme-builder-header-layout.css' );
		}

		return $css;
	}

	/**
	 * Enqueues styles and scripts for all layouts on the page.
	 *
	 * @since 1.0
	 * @return void
	 */
	static public function enqueue_scripts() {

		if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
			return;
		}

		$layouts = FLThemeBuilderLayoutData::get_current_page_layouts();

		if ( ! count( $layouts ) ) {
			return;
		}

		// Enqueue layout dependencies.
		foreach ( $layouts as $layout_type => $layout_group ) {

			foreach ( $layout_group as $layout ) {

				if ( 'header' == $layout_type ) {
					wp_enqueue_script( 'imagesloaded' );
					wp_enqueue_script( 'jquery-throttle', FL_THEME_BUILDER_URL . 'js/jquery.throttle.min.js', array( 'jquery' ), FL_THEME_BUILDER_VERSION, true );
				}
			}
		}

		// Enqueue layout styles and scripts.
		$post   = FLThemeBuilderRulesLocation::get_preview_original_post();
		$inline = apply_filters( 'fl_builder_render_assets_inline', false );

		if ( $inline || $post && 'fl-theme-layout' == $post->post_type ) {
			self::enqueue_individual_scripts();
		} else {
			self::enqueue_bundled_scripts();
		}
	}

	/**
	 * Enqueues styles and scripts for all layouts on the page in a single
	 * bundled file. This method will be used when not in the builder for a
	 * theme layout and will cause theme layout assets to be rerenderd to ensure
	 * the proper connections are made for things like the featured image.
	 *
	 * @since 1.0
	 * @access private
	 * @return void
	 */
	static private function enqueue_bundled_scripts() {
		global $wp_scripts;
		global $wp_styles;

		$cache_dir = FLBuilderModel::get_cache_dir();
		$layouts   = FLThemeBuilderLayoutData::get_current_page_layouts();
		$version   = FL_BUILDER_VERSION . '-' . FL_THEME_BUILDER_VERSION;
		$css       = '';
		$js        = '';

		if ( ! count( $layouts ) ) {
			return;
		}

		// Delete invalid bundled cache.
		//	self::delete_bundled_scripts();

		// Get the CSS and JS for the bundles.
		foreach ( $layouts as $layout_type => $layout_group ) {

			foreach ( $layout_group as $layout ) {

				FLBuilderModel::set_post_id( $layout['id'] );
				FLBuilder::enqueue_layout_styles_scripts( true );

				$handle = 'fl-builder-layout-' . $layout['id'];

				if ( isset( $wp_styles->registered[ $handle ] ) ) {

					$path = str_replace( $cache_dir['url'], $cache_dir['path'], $wp_styles->registered[ $handle ]->src );

					if ( file_exists( $path ) ) {
						$css .= file_get_contents( $path );
						wp_dequeue_style( $handle );
					}
				}
				if ( isset( $wp_scripts->registered[ $handle ] ) ) {

					$path = str_replace( $cache_dir['url'], $cache_dir['path'], $wp_scripts->registered[ $handle ]->src );

					if ( file_exists( $path ) ) {
						$js .= file_get_contents( $path );
						wp_dequeue_script( $handle );
					}
				}

				FLBuilderModel::reset_post_id();
			}
		}

		// Build the CSS bundle if not empty.
		if ( ! empty( $css ) ) {

			$key  = md5( $css );
			$path = $cache_dir['path'] . $key . '-layout-bundle.css';
			$url  = $cache_dir['url'] . $key . '-layout-bundle.css';

			if ( ! file_exists( $path ) ) {
				fl_builder_filesystem()->file_put_contents( $path, $css );
			}

			wp_enqueue_style( 'fl-builder-layout-bundle-' . $key, $url, array(), $version );
		}

		// Build the JS bundle if not empty.
		if ( ! empty( $js ) ) {

			$key  = md5( $js );
			$path = $cache_dir['path'] . $key . '-layout-bundle.js';
			$url  = $cache_dir['url'] . $key . '-layout-bundle.js';

			if ( ! file_exists( $path ) ) {
				fl_builder_filesystem()->file_put_contents( $path, $js );
			}

			wp_enqueue_script( 'fl-builder-layout-bundle-' . $key, $url, array( 'jquery' ), $version, true );
		}
	}

	/**
	 * Deletes all of the bundled styles and scripts cache
	 * once a day to purge any files that are no longer valid.
	 *
	 * @since 1.0
	 * @access private
	 * @return void
	 */
	static private function delete_bundled_scripts() {
		$expires = get_option( '_fl_theme_builder_assets_expire', false );

		if ( ! $expires ) {
			update_option( '_fl_theme_builder_assets_expire', self::get_cache_timeout() );
		} elseif ( $expires && $expires < time() ) {
			self::delete_all_bundled_scripts();
		}
	}


	/**
	 * Deletes all of the bundled styles and scripts cache
	 * when a theme layout is saved.
	 *
	 * @since 1.0
	 * @access private
	 * @return void
	 */
	static public function delete_all_bundled_scripts() {
		$cache_dir = FLBuilderModel::get_cache_dir();
		$css       = glob( $cache_dir['path'] . '*-layout-bundle.css' );
		$js        = glob( $cache_dir['path'] . '*-layout-bundle.js' );

		if ( is_array( $css ) ) {
			array_map( 'unlink', $css );
		}
		if ( is_array( $js ) ) {
			array_map( 'unlink', $js );
		}

		//update_option( '_fl_theme_builder_assets_expire', self::get_cache_timeout() );
	}

	/**
	 * @since 1.1.1
	 */
	static public function get_cache_timeout() {
		return apply_filters( 'fl_theme_builder_assets_expire', strtotime( '+30 days' ) );
	}

	/**
	 * Enqueues individual styles and scripts for all layouts on the page
	 * when using the builder to edit a theme layout.
	 *
	 * @since 1.0
	 * @access private
	 * @return void
	 */
	static private function enqueue_individual_scripts() {
		global $post;

		$layouts = FLThemeBuilderLayoutData::get_current_page_layouts();

		if ( ! count( $layouts ) ) {
			return;
		}

		foreach ( $layouts as $layout_type => $layout_group ) {

			foreach ( $layout_group as $layout ) {

				if ( is_object( $post ) && $post->ID == $layout['id'] ) {
					continue;
				}

				FLBuilder::enqueue_layout_styles_scripts_by_id( $layout['id'] );
			}
		}
	}

	/**
	 * Renders an entire page layout with the given ID.
	 *
	 * @since 1.0
	 * @param int $layout_id
	 * @return void
	 */
	static public function render_all( $layout_id ) {
		FLThemeBuilderLayoutData::set_current_page_layout( $layout_id );

		get_header();

		self::render_content();

		get_footer();
	}

	/**
	 * Renders the header for the current page
	 * if one is set.
	 *
	 * @since 1.0
	 * @param string $tag
	 * @return bool
	 */
	static public function render_header( $tag = null ) {
		$ids = FLThemeBuilderLayoutData::get_current_page_header_ids();
		$tag = ! $tag ? 'header' : $tag;

		if ( empty( $ids ) ) {
			return false;
		}

		$layout_id = FLBuilderModel::get_post_id();
		if ( 'fl-theme-layout' == get_post_type() && count( $ids ) > 1 && in_array( $layout_id, $ids ) ) {
			$id = $layout_id;
		} else {
			$id = $ids[0];
		}

		do_action( 'fl_theme_builder_before_render_header', $id );

		$settings = FLThemeBuilderLayoutData::get_settings( $id );

		$attrs = array(
			'data-type'                => 'header',
			'data-sticky'              => $settings['sticky'],
			'data-sticky-on'           => isset( $settings['sticky-on'] ) ? $settings['sticky-on'] : '',
			'data-sticky-breakpoint'   => apply_filters( 'fl_theme_builder_sticky_header_breakpoint', 'medium' ),
			'data-shrink'              => $settings['shrink'],
			'data-overlay'             => $settings['overlay'],
			'data-overlay-bg'          => $settings['overlay_bg'],
			'data-shrink-image-height' => apply_filters( 'fl_theme_builder_shrink_image_height', '50px' ),
			'role'                     => 'banner',
		);

		if ( self::is_schema_enabled() ) {
			$attrs['itemscope'] = 'itemscope';
			$attrs['itemtype']  = 'http://schema.org/WPHeader';
		}

		FLBuilder::render_content_by_id( $id, $tag, $attrs );

		do_action( 'fl_theme_builder_after_render_header', $id );

		return true;
	}

	/**
	 * Overrides the include for theme templates that have
	 * a theme builder layout assigned to them.
	 *
	 * @since 1.0
	 * @param string $template
	 * @return string
	 */
	static public function override_template_include( $template ) {
		$ids = FLThemeBuilderLayoutData::get_current_page_content_ids();

		if ( empty( $ids ) || is_embed() ) {
			return $template;
		} elseif ( is_singular() ) {

			$page_template = get_page_template_slug();

			if ( 'fl-theme-layout' != get_post_type() && $page_template && 'default' != $page_template ) {
				return $template;
			}
		}

		return apply_filters( 'fl_theme_builder_template_include', FL_THEME_BUILDER_DIR . 'includes/content.php', $ids[0] );
	}

	/**
	 * Renders the content for the current page.
	 *
	 * @since 1.0
	 * @return void
	 */
	static public function render_content() {
		$ids = FLThemeBuilderLayoutData::get_current_page_content_ids();

		if ( empty( $ids ) ) {
			return;
		}

		if ( 'fl-theme-layout' == get_post_type() && count( $ids ) > 1 ) {
			$post_id = FLBuilderModel::get_post_id();
		} else {
			$post_id = $ids[0];
		}

		get_header();

		do_action( 'fl_theme_builder_before_render_content', $post_id );

		FLBuilder::render_content_by_id( $post_id, 'div', apply_filters( 'fl_theme_builder_content_attrs', array() ) );

		do_action( 'fl_theme_builder_after_render_content', $post_id );

		get_footer();
	}

	/**
	 * Renders the footer for the current page
	 * if one is set.
	 *
	 * @since 1.0
	 * @param string $tag
	 * @return bool
	 */
	static public function render_footer( $tag = null ) {
		$ids = FLThemeBuilderLayoutData::get_current_page_footer_ids();
		$tag = ! $tag ? 'footer' : $tag;

		if ( empty( $ids ) ) {
			return false;
		}

		$layout_id = FLBuilderModel::get_post_id();
		if ( 'fl-theme-layout' == get_post_type() && count( $ids ) > 1 && in_array( $layout_id, $ids ) ) {
			$id = $layout_id;
		} else {
			$id = $ids[0];
		}

		do_action( 'fl_theme_builder_before_render_footer', $id );

		$attrs = array(
			'data-type' => 'footer',
		);

		if ( self::is_schema_enabled() ) {
			$attrs['itemscope'] = 'itemscope';
			$attrs['itemtype']  = 'http://schema.org/WPFooter';
		}

		FLBuilder::render_content_by_id( $id, $tag, $attrs );

		do_action( 'fl_theme_builder_after_render_footer', $id );

		return true;
	}

	/**
	 * Disables builder content rendering for headers
	 * and footers since those are edited in place.
	 *
	 * @since 1.0
	 * @return void
	 */
	static public function disable_content_rendering() {
		global $post;

		if ( is_object( $post ) ) {

			$header_ids     = FLThemeBuilderLayoutData::get_current_page_header_ids();
			$header_support = get_theme_support( 'fl-theme-builder-headers' );
			$has_header     = $header_support && in_array( $post->ID, $header_ids );
			$footer_ids     = FLThemeBuilderLayoutData::get_current_page_footer_ids();
			$footer_support = get_theme_support( 'fl-theme-builder-footers' );
			$has_footer     = $footer_support && in_array( $post->ID, $footer_ids );

			if ( $has_header || $has_footer ) {
				remove_filter( 'the_content', 'FLBuilder::render_content' );
				add_filter( 'the_content', __CLASS__ . '::override_the_content' );
			}
		}
	}

	/**
	 * Overrides the default editor content for headers
	 * and footers since those are edited in place.
	 *
	 * @since 1.0
	 * @param string $content
	 * @return string
	 */
	static public function override_the_content( $content ) {
		return '<div class="fl-theme-builder-content-placeholder" style="padding: 200px 100px; text-align:center; opacity:0.5;">' . __( 'Content Area', 'bb-theme-builder' ) . '</div>';
	}

	/**
	 * @since 1.3.1
	 */
	static public function is_schema_enabled() {

		/**
		 * Disable all schema.
		 * @see fl_theme_builder_disable_schema
		 */
		if ( false !== apply_filters( 'fl_theme_builder_disable_schema', false ) ) {
			return false;
		} else {
			return true;
		}
	}
}

FLThemeBuilderLayoutRenderer::init();
