<?php

/**
 * Built-in support for the Genesis theme.
 *
 * @since 1.0
 */
final class FLThemeBuilderSupportGenesis {

	/**
	 * Setup support for the theme.
	 *
	 * @since 1.0
	 * @return void
	 */
	static public function init() {
		add_theme_support( 'fl-theme-builder-headers' );
		add_theme_support( 'fl-theme-builder-footers' );
		add_theme_support( 'fl-theme-builder-parts' );

		add_filter( 'fl_theme_builder_part_hooks', __CLASS__ . '::register_part_hooks' );
		add_filter( 'theme_fl-theme-layout_templates', __CLASS__ . '::register_php_templates' );
		add_filter( 'body_class', __CLASS__ . '::body_class' );

		add_action( 'wp', __CLASS__ . '::setup_headers_and_footers' );
	}

	/**
	 * Registers hooks for theme parts.
	 *
	 * @since 1.0
	 * @return void
	 */
	static public function register_part_hooks() {
		return array(
			array(
				'label' => __( 'Page', 'bb-theme-builder' ),
				'hooks' => array(
					'genesis_before' => __( 'Page Open', 'bb-theme-builder' ),
					'genesis_after'  => __( 'Page Close', 'bb-theme-builder' ),
				),
			),
			array(
				'label' => __( 'Header', 'bb-theme-builder' ),
				'hooks' => array(
					'genesis_before_header' => __( 'Before Header', 'bb-theme-builder' ),
					'genesis_header_right'  => __( 'Header Right', 'bb-theme-builder' ),
					'genesis_after_header'  => __( 'After Header', 'bb-theme-builder' ),
				),
			),
			array(
				'label' => __( 'Content', 'bb-theme-builder' ),
				'hooks' => array(
					'genesis_before_content' => __( 'Before Content', 'bb-theme-builder' ),
					'genesis_after_content'  => __( 'After Content', 'bb-theme-builder' ),
				),
			),
			array(
				'label' => __( 'Footer', 'bb-theme-builder' ),
				'hooks' => array(
					'genesis_before_footer' => __( 'Before Footer', 'bb-theme-builder' ),
					'genesis_after_footer'  => __( 'After Footer', 'bb-theme-builder' ),
				),
			),
			array(
				'label' => __( 'Sidebar', 'bb-theme-builder' ),
				'hooks' => array(
					'genesis_before_sidebar_widget_area' => __( 'Before Sidebar', 'bb-theme-builder' ),
					'genesis_after_sidebar_widget_area'  => __( 'After Sidebar', 'bb-theme-builder' ),
				),
			),
			array(
				'label' => __( 'Posts', 'bb-theme-builder' ),
				'hooks' => array(
					'genesis_before_loop'   => __( 'Before Loop', 'bb-theme-builder' ),
					'genesis_before_entry'  => __( 'Before Post', 'bb-theme-builder' ),
					'genesis_entry_header'  => __( 'Post Header', 'bb-theme-builder' ),
					'genesis_entry_content' => __( 'Post Content', 'bb-theme-builder' ),
					'genesis_entry_footer'  => __( 'Post Footer', 'bb-theme-builder' ),
					'genesis_after_entry'   => __( 'After Post', 'bb-theme-builder' ),
					'genesis_after_loop'    => __( 'After Loop', 'bb-theme-builder' ),
				),
			),
		);
	}

	/**
	 * Setup headers and footers.
	 *
	 * @since 1.0
	 * @return void
	 */
	static public function setup_headers_and_footers() {
		$header_ids = FLThemeBuilderLayoutData::get_current_page_header_ids();
		$footer_ids = FLThemeBuilderLayoutData::get_current_page_footer_ids();

		if ( ! empty( $header_ids ) ) {
			remove_action( 'genesis_header', 'genesis_header_markup_open', 5 );
			remove_action( 'genesis_header', 'genesis_do_header' );
			remove_action( 'genesis_header', 'genesis_header_markup_close', 15 );
			add_action( 'genesis_header', 'FLThemeBuilderLayoutRenderer::render_header' );
		}
		if ( ! empty( $footer_ids ) ) {
			remove_action( 'genesis_footer', 'genesis_footer_markup_open', 5 );
			remove_action( 'genesis_footer', 'genesis_do_footer' );
			remove_action( 'genesis_footer', 'genesis_footer_markup_close', 15 );
			add_action( 'genesis_footer', 'FLThemeBuilderLayoutRenderer::render_footer' );
		}
	}

	/**
	 * Registers custom PHP templates for theme layouts.
	 *
	 * @since 1.0.1
	 * @param array $templates
	 * @return array
	 */
	static public function register_php_templates( $templates ) {

		if ( FLThemeBuilderLayoutData::current_post_is( array( 'singular', 'archive', '404' ) ) ) {
			$templates = array_merge( $templates, array(
				'fl-theme-layout-full-width.php' => __( 'Full Width', 'bb-theme-builder' ),
			) );
		}

		return $templates;
	}

	/**
	 * Sets the full width body class if the full width page
	 * template has been selected for this theme layout.
	 *
	 * @since 1.0.1
	 * @param array $classes
	 * @return array
	 */
	static public function body_class( $classes ) {

		$ids = FLThemeBuilderLayoutData::get_current_page_content_ids();

		if ( ! empty( $ids ) && 'fl-theme-layout-full-width.php' == get_page_template_slug( $ids[0] ) ) {
			$classes[] = 'fl-theme-builder-full-width';
			wp_enqueue_style( 'fl-theme-builder-genesis', FL_THEME_BUILDER_THEMES_URL . 'css/genesis.css', array(), FL_THEME_BUILDER_VERSION );
		}

		return $classes;
	}
}

FLThemeBuilderSupportGenesis::init();
