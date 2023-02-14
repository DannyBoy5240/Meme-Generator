<?php

/**
 * Built-in support for the GeneratePress theme.
 *
 * @since 1.0
 */
final class FLThemeBuilderSupportGeneratePress {

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
		add_action( 'wp_enqueue_scripts', __CLASS__ . '::enqueue_scripts' );
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
				'label' => __( 'Header', 'bb-theme-builder' ),
				'hooks' => array(
					'generate_before_header'         => __( 'Before Header', 'bb-theme-builder' ),
					'generate_before_header_content' => __( 'Before Header Content', 'bb-theme-builder' ),
					'generate_after_header_content'  => __( 'After Header Content', 'bb-theme-builder' ),
					'generate_after_header'          => __( 'After Header', 'bb-theme-builder' ),
				),
			),
			array(
				'label' => __( 'Content', 'bb-theme-builder' ),
				'hooks' => array(
					'generate_before_main_content' => __( 'Before Main Content', 'bb-theme-builder' ),
					'generate_before_content'      => __( 'Before Content', 'bb-theme-builder' ),
					'generate_after_content'       => __( 'After Content', 'bb-theme-builder' ),
					'generate_after_main_content'  => __( 'After Main Content', 'bb-theme-builder' ),
				),
			),
			array(
				'label' => __( 'Footer', 'bb-theme-builder' ),
				'hooks' => array(
					'generate_before_footer'         => __( 'Before Footer', 'bb-theme-builder' ),
					'generate_before_footer_content' => __( 'Before Footer Content', 'bb-theme-builder' ),
					'generate_after_footer_widgets'  => __( 'After Footer Widgets', 'bb-theme-builder' ),
					'generate_after_footer_content'  => __( 'After Footer Content', 'bb-theme-builder' ),
					'wp_footer'                      => __( 'After Footer', 'bb-theme-builder' ),
				),
			),
			array(
				'label' => __( 'Sidebar', 'bb-theme-builder' ),
				'hooks' => array(
					'generate_before_right_sidebar_content' => __( 'Before Right Sidebar Content', 'bb-theme-builder' ),
					'generate_after_right_sidebar_content' => __( 'After Right Sidebar Content', 'bb-theme-builder' ),
					'generate_before_left_sidebar_content' => __( 'Before Left Sidebar Content', 'bb-theme-builder' ),
					'generate_after_left_sidebar_content'  => __( 'After Left Sidebar Content', 'bb-theme-builder' ),
				),
			),
			array(
				'label' => __( 'Posts', 'bb-theme-builder' ),
				'hooks' => array(
					'generate_before_entry_title'  => __( 'Before Title', 'bb-theme-builder' ),
					'generate_after_entry_title'   => __( 'After Title', 'bb-theme-builder' ),
					'generate_after_entry_header'  => __( 'After Title Header', 'bb-theme-builder' ),
					'generate_after_entry_content' => __( 'After Post Content', 'bb-theme-builder' ),
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
			remove_action( 'generate_header', 'generate_construct_header' );
			remove_action( 'generate_after_header', 'generate_add_navigation_after_header', 5 );
			add_action( 'generate_header', 'FLThemeBuilderLayoutRenderer::render_header' );
		}
		if ( ! empty( $footer_ids ) ) {
			remove_action( 'generate_footer', 'generate_construct_footer_widgets', 5 );
			remove_action( 'generate_footer', 'generate_construct_footer' );
			add_action( 'generate_footer', 'FLThemeBuilderLayoutRenderer::render_footer' );
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
			$classes[] = 'full-width-content';
		}

		return $classes;
	}

	/**
	 * Enqueues CSS/JS for GeneratePress theme support.
	 *
	 * @since 1.4.1
	 * @return void
	 */
	static public function enqueue_scripts() {
		$layouts = FLThemeBuilderLayoutData::get_current_page_layouts();

		if ( count( $layouts ) ) {
			wp_enqueue_style( 'fl-theme-builder-generatepress', FL_THEME_BUILDER_THEMES_URL . 'css/generatepress.css', array(), FL_THEME_BUILDER_VERSION );
		}
	}
}

FLThemeBuilderSupportGeneratePress::init();
