<?php

/**
 * Post module support for the theme builder.
 *
 * @since 1.0
 */
final class FLThemeBuilderPostModules {

	/**
	 * @since 1.0
	 * @return void
	 */
	static public function init() {
		// Actions
		add_action( 'wp_enqueue_scripts', __CLASS__ . '::enqueue_scripts' );

		// Filters
		add_filter( 'fl_builder_register_settings_form', __CLASS__ . '::post_grid_settings', 10, 2 );
		add_filter( 'fl_builder_render_css', __CLASS__ . '::post_grid_css', 10, 2 );
		add_filter( 'fl_builder_posts_module_layout_path', __CLASS__ . '::post_grid_layout_path', 10, 3 );
	}

	/**
	 * Enqueues styles and scripts for field connections.
	 *
	 * @since 1.0
	 * @return void
	 */
	static public function enqueue_scripts() {
		$slug = 'fl-theme-builder-post-module-settings';

		if ( FLBuilderModel::is_builder_active() ) {
			wp_enqueue_style( $slug, FL_THEME_BUILDER_URL . 'css/' . $slug . '.css', array(), FL_THEME_BUILDER_VERSION );
			wp_enqueue_script( $slug, FL_THEME_BUILDER_URL . 'js/' . $slug . '.js', array(), FL_THEME_BUILDER_VERSION );
		}
	}

	/**
	 * Adds the custom code settings for custom post
	 * module layouts.
	 *
	 * @since 1.0
	 * @param array  $form
	 * @param string $slug
	 * @return array
	 */
	static public function post_grid_settings( $form, $slug ) {
		if ( 'post-grid' != $slug ) {
			return $form;
		}

		$form['layout']['sections']['general']['fields']['post_layout'] = array(
			'type'    => 'select',
			'label'   => __( 'Post Layout', 'bb-theme-builder' ),
			'default' => 'default',
			'options' => array(
				'default' => __( 'Default', 'bb-theme-builder' ),
				'custom'  => __( 'Custom', 'bb-theme-builder' ),
			),
			'toggle'  => array(
				'custom' => array(
					'fields' => array( 'custom_post_layout', 'woo_styles_enable' ),
				),
			),
		);

		$form['layout']['sections']['general']['fields']['custom_post_layout'] = array(
			'type'         => 'form',
			'label'        => __( 'Custom Post Layout', 'bb-theme-builder' ),
			'form'         => 'custom_post_layout',
			'preview_text' => null,
			'multiple'     => false,
		);

		FLBuilder::register_settings_form( 'custom_post_layout', array(
			'title' => __( 'Custom Post Layout', 'bb-theme-builder' ),
			'tabs'  => array(
				'html' => array(
					'title'    => __( 'HTML', 'bb-theme-builder' ),
					'sections' => array(
						'html' => array(
							'title'  => '',
							'fields' => array(
								'html' => array(
									'type'        => 'code',
									'editor'      => 'html',
									'label'       => '',
									'rows'        => '18',
									'default'     => file_get_contents( FL_THEME_BUILDER_DIR . 'includes/post-grid-default-html.php' ),
									'preview'     => array(
										'type' => 'none',
									),
									'connections' => array( 'html', 'string', 'url', 'color' ),
								),
							),
						),
					),
				),
				'css'  => array(
					'title'    => __( 'CSS', 'bb-theme-builder' ),
					'sections' => array(
						'css' => array(
							'title'  => '',
							'fields' => array(
								'css' => array(
									'type'    => 'code',
									'editor'  => 'css',
									'label'   => '',
									'rows'    => '18',
									'default' => file_get_contents( FL_THEME_BUILDER_DIR . 'includes/post-grid-default-css.php' ),
									'preview' => array(
										'type' => 'none',
									),
								),
							),
						),
					),
				),
			),
		));

		return $form;
	}

	/**
	 * Renders custom CSS for the post grid module.
	 *
	 * @since 1.0
	 * @param string $css
	 * @param array  $nodes
	 * @return string
	 */
	static public function post_grid_css( $css, $nodes ) {

		if ( ! class_exists( 'lessc' ) ) {
			require_once FL_THEME_BUILDER_DIR . 'classes/class-lessc.php';
		}
		foreach ( $nodes['modules'] as $module ) {

			if ( ! is_object( $module ) ) {
				continue;
			} elseif ( 'post-grid' != $module->settings->type ) {
				continue;
			} elseif ( 'custom' != $module->settings->post_layout ) {
				continue;
			}

			try {
				$less    = new lessc;
				$custom  = '.fl-node-' . $module->node . ' { ';
				$custom .= $module->settings->custom_post_layout->css;
				$custom .= ' }';
				if ( method_exists( 'FLBuilder', 'maybe_do_shortcode' ) ) {
					$custom = FLBuilder::maybe_do_shortcode( $custom );
				}
				$css .= @$less->compile( $custom ); // @codingStandardsIgnoreLine
			} catch ( Exception $e ) {
				$css .= $module->settings->custom_post_layout->css;
			}
		}
			return $css;
	}

	/**
	 * Returns a custom path for post module layouts.
	 *
	 * @since 1.0
	 * @param string $path
	 * @param string $layout
	 * @param object $settings
	 * @return string
	 */
	static public function post_grid_layout_path( $path, $layout, $settings ) {
		if ( 'default' == $settings->post_layout ) {
			return $path;
		}

		return FL_THEME_BUILDER_DIR . 'includes/post-grid-frontend.php';
	}
}

FLThemeBuilderPostModules::init();
