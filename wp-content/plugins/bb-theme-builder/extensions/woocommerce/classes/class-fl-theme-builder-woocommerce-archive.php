<?php

/**
 * WooCommerce archive support for the theme builder.
 *
 * @since 1.0
 */
final class FLThemeBuilderWooCommerceArchive {

	/**
	 * @since 1.0
	 * @return void
	 */
	static public function init() {
		// Actions
		add_action( 'fl_builder_posts_module_before_posts', __CLASS__ . '::print_notices', 10, 2 );
		add_action( 'fl_builder_posts_module_before_posts', __CLASS__ . '::posts_module_before_posts' );
		add_action( 'fl_builder_posts_module_after_pagination', __CLASS__ . '::posts_module_after_pagination', 10, 2 );
		add_action( 'fl_builder_post_grid_before_image', __CLASS__ . '::post_grid_before_image' );
		add_action( 'fl_builder_post_grid_before_content', __CLASS__ . '::post_grid_before_content' );
		add_action( 'fl_builder_post_grid_after_content', __CLASS__ . '::post_grid_after_content' );
		add_action( 'fl_builder_post_feed_before_image', __CLASS__ . '::post_grid_before_image' );
		add_action( 'fl_builder_post_feed_after_meta', __CLASS__ . '::post_feed_after_meta' );
		add_action( 'fl_builder_post_feed_after_content', __CLASS__ . '::post_feed_after_content' );
		add_action( 'fl_builder_post_gallery_after_meta', __CLASS__ . '::post_gallery_after_meta' );
		add_action( 'fl_theme_builder_before_render_content', __CLASS__ . '::before_render_content' );
		add_action( 'fl_theme_builder_after_render_content', __CLASS__ . '::after_render_content' );
		add_action( 'wp', __CLASS__ . '::remove_woo_hooks_callbacks' );

		// Filters
		add_filter( 'fl_builder_register_settings_form', __CLASS__ . '::post_grid_settings', 10, 2 );
		add_filter( 'fl_builder_render_css', __CLASS__ . '::post_grid_css', 10, 2 );
		add_filter( 'fl_builder_module_attributes', __CLASS__ . '::post_grid_woo', 10, 2 );
	}

	static public function post_grid_woo( $attrs, $module ) {

		if ( $module instanceof FLPostGridModule ) {
			if ( isset( $module->settings->woo_styles_enable ) && 'yes' == $module->settings->woo_styles_enable ) {
				$attrs['class'][] = 'woocommerce woocommerce-page';
			}
		}
		return $attrs;
	}

	/**
	 * Prints WooCommerce notices before post module posts.
	 *
	 * @since 1.0
	 * @param object $settings
	 * @param object $query
	 * @return void
	 */
	static public function print_notices( $settings, $query ) {
		if ( 'product' == $query->query_vars['post_type'] && function_exists( 'wc_print_notices' ) ) {
			wc_print_notices();
		}
	}

	/**
	 * Adds WooCommerce result count and ordering before post
	 * module posts.
	 *
	 * @since 1.0
	 * @param object $settings
	 * @return void
	 */
	static public function posts_module_before_posts( $settings ) {
		$is_woo_product = false;

		if ( empty( $settings->post_type ) ) {
			return;
		}

		if ( is_array( $settings->post_type ) && method_exists( 'FLBuilderUtils', 'post_type_contains' ) ) {
			$is_woo_product = FLBuilderUtils::post_type_contains( 'product', $settings->post_type );
		} else {
			$is_woo_product = 'product' === strval( $settings->post_type );
		}

		if ( $is_woo_product && 'show' === $settings->woo_ordering ) {
			$force = false;
			if ( ! isset( $GLOBALS['woocommerce_loop'] ) ) {
				$GLOBALS['woocommerce_loop']                 = array();
				$GLOBALS['woocommerce_loop']['total']        = 10;
				$GLOBALS['woocommerce_loop']['is_filtered']  = true;
				$GLOBALS['woocommerce_loop']['total']        = $GLOBALS['wp_query']->found_posts;
				$GLOBALS['woocommerce_loop']['total_pages']  = $GLOBALS['wp_query']->max_num_pages;
				$GLOBALS['woocommerce_loop']['per_page']     = $GLOBALS['wp_query']->get( 'posts_per_page' );
				$GLOBALS['woocommerce_loop']['current_page'] = max( 1, $GLOBALS['wp_query']->get( 'paged', 1 ) );
				$force                                       = true;
			}
			echo '<div class="fl-post-module-woo-ordering">';

			woocommerce_result_count();
			woocommerce_catalog_ordering();

			echo '<div class="fl-clear"></div>';
			echo '</div>';
			if ( $force ) {
				unset( $GLOBALS['woocommerce_loop'] );
			}
		}
	}

	/**
	 * Fires the woocommerce_after_shop_loop hook to support
	 * third party plugins.
	 *
	 * @since 1.0.1
	 * @param object $settings
	 * @param object $query
	 * @return void
	 */
	static public function posts_module_after_pagination( $settings, $query = null ) {
		if ( is_object( $query ) && isset( $query->query_vars['post_type'] ) && 'product' == $query->query_vars['post_type'] ) {
			remove_action( 'woocommerce_after_shop_loop', 'woocommerce_pagination' );
			do_action( 'woocommerce_after_shop_loop' );
		}
	}

	/**
	 * Adds WooCommerce sales flash to the featured image.
	 *
	 * @since 1.0
	 * @param object $settings
	 * @return void
	 */
	static public function post_grid_before_image( $settings ) {
		if ( 'show' == $settings->woo_sale_flash ) {
			echo FLPageData::get_value( 'post', 'woocommerce_sale_flash' );
		}
	}

	/**
	 * Adds WooCommerce product info before the grid layout content.
	 *
	 * @since 1.0
	 * @param object $settings
	 * @return void
	 */
	static public function post_grid_before_content( $settings ) {
		global $product;

		// Bail if no product
		if ( ! $product ) {
			return;
		}

		// if custom layout then dont do these.
		if ( 'custom' == $settings->post_layout ) {
			return false;
		}

		// Open wrapper
		if ( 'show' == $settings->woo_rating || 'show' == $settings->woo_price ) {
			echo '<div class="woocommerce fl-post-module-woo-meta fl-post-grid-woo-meta">';
		}

		// Product rating
		if ( 'show' == $settings->woo_rating ) {
			echo FLPageData::get_value( 'post', 'woocommerce_product_rating' );
		}

		// Product price
		if ( 'show' == $settings->woo_price ) {
			echo FLPageData::get_value( 'post', 'woocommerce_product_price' );
		}

		// Close wrapper
		if ( 'show' == $settings->woo_rating || 'show' == $settings->woo_price ) {
			echo '</div>';
		}
	}

	/**
	 * Adds WooCommerce product info after the grid layout content.
	 *
	 * @since 1.0
	 * @param object $settings
	 * @return void
	 */
	static public function post_grid_after_content( $settings ) {
		global $product;

		// Bail if no product
		if ( ! $product ) {
			return;
		}

		// if custom layout then dont do these.
		if ( 'custom' == $settings->post_layout ) {
			return false;
		}

		// Add to Cart Button
		if ( 'show' == $settings->woo_button ) {
			echo '<div class="woocommerce fl-post-module-woo-button fl-post-grid-woo-button">';
			echo FLPageData::get_value( 'post', 'woocommerce_add_to_cart_button' );
			echo '</div>';
		}
	}

	/**
	 * Adds WooCommerce product info after the feed layout meta.
	 *
	 * @since 1.0
	 * @param object $settings
	 * @return void
	 */
	static public function post_feed_after_meta( $settings ) {
		global $product;

		// Bail if no product
		if ( ! $product ) {
			return;
		}

		// Open wrapper
		if ( 'show' == $settings->woo_rating || 'show' == $settings->woo_price ) {
			echo '<div class="woocommerce fl-post-module-woo-meta fl-post-feed-woo-meta">';
		}

		// Product price
		if ( 'show' == $settings->woo_price ) {
			echo FLPageData::get_value( 'post', 'woocommerce_product_price' );
		}

		// Product rating
		if ( 'show' == $settings->woo_rating ) {
			echo FLPageData::get_value( 'post', 'woocommerce_product_rating' );
		}

		// Close wrapper
		if ( 'show' == $settings->woo_rating || 'show' == $settings->woo_price ) {
			echo '</div>';
		}
	}

	/**
	 * Adds WooCommerce product info after the feed layout content.
	 *
	 * @since 1.0
	 * @param object $settings
	 * @return void
	 */
	static public function post_feed_after_content( $settings ) {
		global $product;

		// Bail if no product
		if ( ! $product ) {
			return;
		}

		// Add to Cart Button
		if ( 'show' == $settings->woo_button ) {
			echo '<div class="woocommerce fl-post-module-woo-button fl-post-feed-woo-button">';
			echo FLPageData::get_value( 'post', 'woocommerce_add_to_cart_button' );
			echo '</div>';
		}
	}

	/**
	 * Adds WooCommerce product info after the gallery layout meta.
	 *
	 * @since 1.0
	 * @param object $settings
	 * @return void
	 */
	static public function post_gallery_after_meta( $settings ) {
		global $product;

		// Bail if no product
		if ( ! $product ) {
			return;
		}

		// Open wrapper
		if ( 'show' == $settings->woo_rating || 'show' == $settings->woo_price ) {
			echo '<div class="woocommerce fl-post-module-woo-meta fl-post-gallery-woo-meta">';
		}

		// Product price
		if ( 'show' == $settings->woo_price ) {
			echo FLPageData::get_value( 'post', 'woocommerce_product_price' );
		}

		// Product rating
		if ( 'show' == $settings->woo_rating ) {
			echo FLPageData::get_value( 'post', 'woocommerce_product_rating' );
		}

		// Close wrapper
		if ( 'show' == $settings->woo_rating || 'show' == $settings->woo_price ) {
			echo '</div>';
		}
	}

	/**
	 * Adds WooCommerce settings to the Posts module.
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

		$form['layout']['sections']['woo'] = array(
			'title'  => __( 'WooCommerce', 'bb-theme-builder' ),
			'fields' => array(
				'woo_ordering'   => array(
					'type'    => 'select',
					'label'   => __( 'Product Ordering', 'bb-theme-builder' ),
					'default' => 'hide',
					'options' => array(
						'show' => __( 'Show', 'bb-theme-builder' ),
						'hide' => __( 'Hide', 'bb-theme-builder' ),
					),
				),
				'woo_sale_flash' => array(
					'type'    => 'select',
					'label'   => __( 'Product Sale', 'bb-theme-builder' ),
					'default' => 'hide',
					'options' => array(
						'show' => __( 'Show', 'bb-theme-builder' ),
						'hide' => __( 'Hide', 'bb-theme-builder' ),
					),
				),
				'woo_rating'     => array(
					'type'    => 'select',
					'label'   => __( 'Product Rating', 'bb-theme-builder' ),
					'default' => 'hide',
					'options' => array(
						'show' => __( 'Show', 'bb-theme-builder' ),
						'hide' => __( 'Hide', 'bb-theme-builder' ),
					),
				),
				'woo_price'      => array(
					'type'    => 'select',
					'label'   => __( 'Product Price', 'bb-theme-builder' ),
					'default' => 'hide',
					'options' => array(
						'show' => __( 'Show', 'bb-theme-builder' ),
						'hide' => __( 'Hide', 'bb-theme-builder' ),
					),
				),
				'woo_button'     => array(
					'type'    => 'select',
					'label'   => __( 'Cart Button', 'bb-theme-builder' ),
					'default' => 'hide',
					'options' => array(
						'show' => __( 'Show', 'bb-theme-builder' ),
						'hide' => __( 'Hide', 'bb-theme-builder' ),
					),
				),
				'woo_visible'    => array(
					'type'    => 'select',
					'label'   => __( 'Show Hidden Products', 'bb-theme-builder' ),
					'default' => 'hide',
					'options' => array(
						'show' => __( 'Show', 'bb-theme-builder' ),
						'hide' => __( 'Hide', 'bb-theme-builder' ),
					),
				),

			),
		);

		$form['layout']['sections']['general']['fields']['woo_styles_enable'] = array(
			'type'    => 'select',
			'label'   => __( 'WooCommerce Classes', 'bb-theme-builder' ),
			'help'    => __( 'Add woocommerce and woocommerce-page classes to module wrapper.', 'bb-theme-builder' ),
			'default' => 'no',
			'options' => array(
				'no'  => __( 'No', 'bb-theme-builder' ),
				'yes' => __( 'Yes', 'bb-theme-builder' ),
			),
		);

		$form['style']['sections']['woo_style'] = array(
			'title'  => __( 'WooCommerce', 'bb-theme-builder' ),
			'fields' => array(
				'woo_sale_flash_bg'    => array(
					'type'       => 'color',
					'label'      => __( 'Product Sale Background', 'bb-theme-builder' ),
					'show_reset' => true,
					'preview'    => array(
						'type' => 'refresh',
					),
				),
				'woo_sale_flash_color' => array(
					'type'       => 'color',
					'label'      => __( 'Product Sale Text Color', 'bb-theme-builder' ),
					'show_reset' => true,
					'preview'    => array(
						'type' => 'refresh',
					),
				),
				'woo_rating_fg'        => array(
					'type'       => 'color',
					'label'      => __( 'Product Rating Foreground', 'bb-theme-builder' ),
					'show_reset' => true,
				),
				'woo_rating_bg'        => array(
					'type'       => 'color',
					'label'      => __( 'Product Rating Background', 'bb-theme-builder' ),
					'show_reset' => true,
				),
				'woo_rating_font_size' => array(
					'type'        => 'text',
					'label'       => __( 'Product Rating Font Size', 'bb-theme-builder' ),
					'default'     => '',
					'maxlength'   => '3',
					'size'        => '4',
					'description' => 'px',
				),
				'woo_price_color'      => array(
					'type'       => 'color',
					'label'      => __( 'Product Price Text Color', 'bb-theme-builder' ),
					'show_reset' => true,
				),
				'woo_price_font_size'  => array(
					'type'        => 'text',
					'label'       => __( 'Product Price Font Size', 'bb-theme-builder' ),
					'default'     => '',
					'maxlength'   => '3',
					'size'        => '4',
					'description' => 'px',
				),
			),
		);

		$form['style']['sections']['woo_button'] = array(
			'title'  => __( 'WooCommerce Cart Button', 'bb-theme-builder' ),
			'fields' => array(
				'woo_button_bg_color'         => array(
					'type'       => 'color',
					'label'      => __( 'Background Color', 'bb-theme-builder' ),
					'default'    => '',
					'show_reset' => true,
					'preview'    => array(
						'type' => 'refresh',
					),
				),
				'woo_button_text_color'       => array(
					'type'       => 'color',
					'label'      => __( 'Text Color', 'bb-theme-builder' ),
					'default'    => '',
					'show_reset' => true,
					'preview'    => array(
						'type' => 'refresh',
					),
				),
				'woo_button_hover_bg_color'   => array(
					'type'       => 'color',
					'label'      => __( 'Hover Background Color', 'bb-theme-builder' ),
					'default'    => '',
					'show_reset' => true,
					'preview'    => array(
						'type' => 'refresh',
					),
				),
				'woo_button_hover_text_color' => array(
					'type'       => 'color',
					'label'      => __( 'Hover Text Color', 'bb-theme-builder' ),
					'default'    => '',
					'show_reset' => true,
					'preview'    => array(
						'type' => 'refresh',
					),
				),
			),
		);

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
		$global_included = false;

		foreach ( $nodes['modules'] as $module ) {

			if ( ! is_object( $module ) ) {
				continue;
			} elseif ( 'post-grid' != $module->settings->type ) {
				continue;
			} elseif ( ! $global_included ) {
				$global_included = true;
				$css            .= file_get_contents( FL_THEME_BUILDER_WOOCOMMERCE_DIR . 'css/fl-theme-builder-post-grid-woocommerce.css' );
			}

			ob_start();
			$id       = $module->node;
			$settings = $module->settings;
			include FL_THEME_BUILDER_WOOCOMMERCE_DIR . 'includes/post-grid-woocommerce.css.php';
			$css .= ob_get_clean();
		}

		return $css;
	}

	/**
	 * Add the 'woocommerce_before_shop_loop' action hook.
	 *
	 * @since 1.4
	 * @param string $layout_id
	 * @return void
	 */
	static public function before_render_content( $layout_id ) {
		global $wp_the_query;

		if ( is_object( $wp_the_query->post ) && 'product' === $wp_the_query->post->post_type ) {
			if ( is_shop() || is_product_category() || is_product_tag() ) {
				do_action( 'woocommerce_before_shop_loop' );
			}
		}
	}

	/**
	 * Add the 'woocommerce_after_shop_loop' action hook.
	 *
	 * @since 1.4
	 * @param string $layout_id
	 * @return void
	 */
	static public function after_render_content( $layout_id ) {
		global $wp_the_query;

		if ( is_object( $wp_the_query->post ) && 'product' === $wp_the_query->post->post_type ) {
			if ( is_shop() || is_product_category() || is_product_tag() ) {
				do_action( 'woocommerce_after_shop_loop' );
			}
		}
	}

	/**
	 * Remove default WooCommerce hooks + callbacks that cause issues on the Themer Product Archive layout.
	 *
	 * @since 1.4.2
	 * @method remove_woo_hooks_callbacks
	 * @return void
	 */
	static public function remove_woo_hooks_callbacks() {
		if ( FLThemeBuilder::has_layout( 'archive' ) ) {
			// Remove default WooCommerce Product Sorting.
			remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
			remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );

			// Remove default WooCommerce product pagination.
			remove_action( 'woocommerce_after_shop_loop', 'woocommerce_pagination' );
		}
	}
}

FLThemeBuilderWooCommerceArchive::init();
