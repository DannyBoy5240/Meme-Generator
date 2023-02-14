<?php

/**
 * EDD archive support for the theme builder.
 *
 * @since 1.1
 */
final class FLThemeBuildeEDDArchive {

	/**
	 * @since 1.1
	 * @return void
	 */
	static public function init() {
		// Actions
		add_action( 'fl_builder_post_grid_before_content', __CLASS__ . '::post_grid_before_content' );
		add_action( 'fl_builder_post_grid_after_content', __CLASS__ . '::post_grid_after_content' );
		add_action( 'fl_builder_post_feed_after_meta', __CLASS__ . '::post_feed_after_meta' );
		add_action( 'fl_builder_post_feed_after_content', __CLASS__ . '::post_feed_after_content' );
		add_action( 'fl_builder_post_gallery_after_meta', __CLASS__ . '::post_gallery_after_meta' );

		// Filters
		add_filter( 'fl_builder_register_settings_form', __CLASS__ . '::post_grid_settings', 10, 2 );
		add_filter( 'fl_builder_render_css', __CLASS__ . '::post_grid_css', 10, 2 );

		// Archive templates
		FLBuilder::register_templates( FL_THEME_BUILDER_EDD_DIR . 'data/templates-archive.dat' );
	}

	/**
	 * Adds EDD product info before the grid layout content.
	 *
	 * @since 1.1
	 * @param object $settings
	 * @return void
	 */
	static public function post_grid_before_content( $settings ) {

		// if custom layout then dont do these.
		if ( 'custom' == $settings->post_layout ) {
			return false;
		}

		if ( 'show' == $settings->edd_price ) {
			echo '<div class="edd fl-post-module-edd-meta fl-post-grid-edd-meta">';
			echo FLPageData::get_value( 'post', 'edd_product_price' );
			echo '</div>';
		}

	}

	/**
	 * Adds EDD product info after the grid layout content.
	 *
	 * @since 1.1
	 * @param object $settings
	 * @return void
	 */
	static public function post_grid_after_content( $settings ) {

		// if custom layout then dont do these.
		if ( 'custom' == $settings->post_layout ) {
			return false;
		}

		if ( 'hide' !== $settings->edd_button ) {
			echo '<div class="edd fl-post-module-edd-button fl-post-grid-edd-button">';

			if ( edd_has_variable_prices( get_the_ID() ) && 'show' === $settings->edd_button ) {
				echo '<a href="' . get_permalink() . '" class="button blue edd-submit">' . __( 'Select Options', 'bb-theme-builder' ) . '</a>';
			} else {
				echo FLPageData::get_value( 'post', 'edd_add_to_cart_button' );
			}

			echo '</div>';
		}
	}

	/**
	 * Adds EDD product info after the feed layout meta.
	 *
	 * @since 1.1
	 * @param object $settings
	 * @return void
	 */
	static public function post_feed_after_meta( $settings ) {
		if ( 'show' == $settings->edd_price ) {
			echo '<div class="edd fl-post-module-edd-meta fl-post-feed-edd-meta">';
			echo FLPageData::get_value( 'post', 'edd_product_price' );
			echo '</div>';
		}
	}

	/**
	 * Adds EDD product info after the feed layout content.
	 *
	 * @since 1.1
	 * @param object $settings
	 * @return void
	 */
	static public function post_feed_after_content( $settings ) {
		if ( 'hide' !== $settings->edd_button ) {
			echo '<div class="edd fl-post-module-edd-button fl-post-feed-edd-button">';

			if ( edd_has_variable_prices( get_the_ID() ) && 'show' === $settings->edd_button ) {
				echo '<a href="' . get_permalink() . '" class="button blue edd-submit">' . __( 'Select Options', 'bb-theme-builder' ) . '</a>';
			} else {
				echo FLPageData::get_value( 'post', 'edd_add_to_cart_button' );
			}

			echo '</div>';
		}
	}

	/**
	 * Adds EDD product info after the gallery layout meta.
	 *
	 * @since 1.1
	 * @param object $settings
	 * @return void
	 */
	static public function post_gallery_after_meta( $settings ) {
		if ( 'show' == $settings->edd_price ) {
			echo '<div class="edd fl-post-module-edd-meta fl-post-feed-edd-meta">';
			echo FLPageData::get_value( 'post', 'edd_product_price' );
			echo '</div>';
		}
	}

	/**
	 * Adds EDD settings to the Posts module.
	 *
	 * @since 1.1
	 * @param array $form
	 * @param string $slug
	 * @return array
	 */
	static public function post_grid_settings( $form, $slug ) {
		if ( 'post-grid' != $slug ) {
			return $form;
		}

		$form['layout']['sections']['edd'] = array(
			'title'  => __( 'Easy Digital Downloads', 'bb-theme-builder' ),
			'fields' => array(
				'edd_price'  => array(
					'type'    => 'select',
					'label'   => __( 'Download Price', 'bb-theme-builder' ),
					'default' => 'hide',
					'options' => array(
						'show' => __( 'Show', 'bb-theme-builder' ),
						'hide' => __( 'Hide', 'bb-theme-builder' ),
					),
				),
				'edd_button' => array(
					'type'    => 'select',
					'label'   => __( 'Cart Button', 'bb-theme-builder' ),
					'default' => 'hide',
					'options' => array(
						'show'          => __( 'Show Default', 'bb-theme-builder' ),
						'show_standard' => __( 'Show Standard', 'bb-theme-builder' ),
						'hide'          => __( 'Hide', 'bb-theme-builder' ),
					),
				),
			),
		);

		$form['style']['sections']['edd'] = array(
			'title'  => __( 'Easy Digital Downloads', 'bb-theme-builder' ),
			'fields' => array(
				'edd_price_color'     => array(
					'type'       => 'color',
					'label'      => __( 'Download Price Text Color', 'bb-theme-builder' ),
					'show_reset' => true,
				),
				'edd_price_font_size' => array(
					'type'        => 'text',
					'label'       => __( 'Download Price Font Size', 'bb-theme-builder' ),
					'default'     => '',
					'maxlength'   => '3',
					'size'        => '4',
					'description' => 'px',
				),
			),
		);

		$form['style']['sections']['edd_button'] = array(
			'title'  => __( 'Easy Digital Downloads Cart Button', 'bb-theme-builder' ),
			'fields' => array(
				'edd_button_bg_color'   => array(
					'type'       => 'color',
					'label'      => __( 'Background Color', 'bb-theme-builder' ),
					'default'    => '',
					'show_reset' => true,
				),
				'edd_button_text_color' => array(
					'type'       => 'color',
					'label'      => __( 'Text Color', 'bb-theme-builder' ),
					'default'    => '',
					'show_reset' => true,
				),
			),
		);

		return $form;
	}

	/**
	 * Renders custom CSS for the post grid module.
	 *
	 * @since 1.1
	 * @param string $css
	 * @param array $nodes
	 * @return string
	 */
	static public function post_grid_css( $css, $nodes ) {
		$global_included = false;

		foreach ( $nodes['modules'] as $module ) {

			if ( ! is_object( $module ) ) {
				continue;
			} elseif ( 'post-grid' != $module->settings->type ) {
				continue;
			} elseif ( ! $global_included ) {
				$global_included = true;
				$css            .= file_get_contents( FL_THEME_BUILDER_EDD_DIR . 'css/fl-theme-builder-post-grid-edd.css' );
			}

			ob_start();
			$id       = $module->node;
			$settings = $module->settings;
			include FL_THEME_BUILDER_EDD_DIR . 'includes/post-grid-edd.css.php';
			$css .= ob_get_clean();
		}

		return $css;
	}
}

FLThemeBuildeEDDArchive::init();
