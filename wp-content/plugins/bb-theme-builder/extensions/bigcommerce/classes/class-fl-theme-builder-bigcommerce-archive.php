<?php

use BigCommerce\Templates\Refinery;


/**
 * BigCommerce archive support for the theme builder
 */
final class FLThemeBuilderBigCommerceArchive {

	static public function init() {
		// Actions
		add_action( 'fl_builder_posts_module_before_posts', __CLASS__ . '::posts_module_before_posts', 10, 2 );
		add_action( 'fl_builder_post_grid_before_image', __CLASS__ . '::post_grid_before_image' );
		add_action( 'fl_builder_post_grid_before_content', __CLASS__ . '::post_grid_before_content' );
		add_action( 'fl_builder_post_grid_after_content', __CLASS__ . '::post_grid_after_content' );
		add_action( 'fl_builder_post_feed_before_image', __CLASS__ . '::post_grid_before_image' );
		add_action( 'fl_builder_post_feed_after_meta', __CLASS__ . '::post_feed_after_meta' );
		add_action( 'fl_builder_post_feed_after_content', __CLASS__ . '::post_feed_after_content' );
		add_action( 'fl_builder_post_gallery_after_meta', __CLASS__ . '::post_gallery_after_meta' );

		// Filters
		add_filter( 'fl_builder_register_settings_form', __CLASS__ . '::post_grid_settings', 11, 2 );
		add_filter( 'fl_builder_render_css', __CLASS__ . '::post_grid_css', 10, 2 );

		FLBuilder::register_templates( FL_THEME_BUILDER_BIGCOMMERCE_DIR . 'data/template-archive.dat' );
	}


	/**
	 * Show "Product Refinery" - for searching/filtering products in posts grid module
	 *
	 * @param $settings
	 * @param $query
	 */
	static public function posts_module_before_posts( $settings, $query ) {

		$post_id = null;
		if ( is_object( $query->current_post ) ) {
			$post_id = $query->current_post->ID;
		}

		if ( 'show' == $settings->bc_refinery ) {
			$component = Refinery::factory( array(
				Refinery::QUERY  => $query,
				Refinery::ACTION => get_permalink( $post_id ),
			) );

			echo '<div class="bc-product-archive__refinery">';
			echo $component->render();
			echo '</div>';
		}

	}


	/**
	 * Adds BigCommerce sales flash to the featured image.
	 *
	 * @since 1.0
	 *
	 * @param object $settings
	 *
	 * @return void
	 */
	static public function post_grid_before_image( $settings ) {
		if ( ! class_exists( 'FLPageDataBigCommerce' ) ) {
			return false;
		}
		$product = FLPageDataBigCommerce::get_product();
		if ( 'show' == $settings->bc_sale_flash && $product->on_sale() ) {
			echo '<div class="bc-product-flag--sale">SALE</div>';
		}
	}


	/**
	 * Display Product Info
	 *
	 * @param $settings
	 * @param $type grid,feed, or gallery
	 * @param $class_suffix
	 *
	 * @return bool
	 */
	static public function show_product_info( $settings, $type, $class_suffix ) {
		if ( ! class_exists( 'FLPageDataBigCommerce' ) ) {
			return false;
		}
		$product = FLPageDataBigCommerce::get_product();

		// if custom layout then dont do these.
		if ( 'custom' == $settings->post_layout ) {
			return false;
		}

		// Open wrapper
		if ( 'show' == $settings->bc_rating || 'show' == $settings->bc_price ) {
			$classes = array(
				sprintf( 'fl-post-module-bc-%s', $class_suffix ),
				sprintf( 'fl-post-%s-bc-%s', $type, $class_suffix ),
			);

			if ( $product->on_sale() ) {
				$classes[] = 'on_sale';
			}

			printf( '<div class="%s">', implode( ' ', $classes ) );
		}

		// Product Brand Name
		if ( 'show' == $settings->bc_brand ) {
			echo FLPageDataBigCommerce::get_product_brand();
		}

		// Product rating
		if ( 'show' == $settings->bc_rating ) {
			echo FLPageDataBigCommerce::get_product_rating_stars_html();
		}

		// Product price
		if ( 'show' == $settings->bc_price ) {
			// Wrap in a div because the default uses a <p>

			echo '<div class="fl-post-module-bc-product-price">';
			echo FLPageDataBigCommerce::get_product_price();
			echo '</div>';
		}

		// Close wrapper
		if ( 'show' == $settings->bc_rating || 'show' == $settings->bc_price ) {
			echo '</div>';
		}
	}

	/**
	 * Display Add To Cart button
	 *
	 * @param $settings
	 * @param $type grid,feed, or gallery
	 * @param $class_suffix
	 *
	 * @return bool
	 */
	static public function show_add_to_cart( $settings, $type ) {
		if ( ! class_exists( 'FLPageDataBigCommerce' ) ) {
			return false;
		}
		// if custom layout then dont do these.
		if ( 'custom' == $settings->post_layout ) {
			return false;
		}

		// Add to Cart Button
		if ( 'show' === $settings->bc_cart_button ) {
			$format  = '<div class="%s">%s</div>';
			$classes = sprintf( 'fl-post-module-bc-button fl-post-%s-bc-button', $type );

			$show_options = false;

			if ( is_array( $settings->bc_cart_form ) && 'show' == $settings->bc_cart_form['bc_cart_form'] ) {
				$show_options = true;
			} elseif ( is_object( $settings->bc_cart_form ) && 'show' == $settings->bc_cart_form->bc_cart_form ) {
				$show_options = true;
			}

			$button = FLPageDataBigCommerce::get_cart_form( $show_options );
			printf( $format, $classes, $button );
		}
	}

	/**
	 * Add BigCommerce product info before the grid layout content
	 *
	 * @param $settings
	 *
	 */
	static public function post_grid_before_content( $settings ) {
		static::show_product_info( $settings, 'grid', 'meta' );
	}

	/**
	 * Adds BigCommerce product info after the grid layout content.
	 *
	 * @param object $settings
	 *
	 * @return void
	 */
	static public function post_grid_after_content( $settings ) {
		static::show_add_to_cart( $settings, 'grid' );
	}


	/**
	 * Adds BigCommerce product info after the feed layout
	 *
	 * @param $settings
	 */
	static public function post_feed_after_meta( $settings ) {
		static::show_product_info( $settings, 'feed', 'meta' );
	}

	/**
	 * Adds WooCommerce product info after the feed layout content.
	 *
	 * @param $settings
	 */
	static public function post_feed_after_content( $settings ) {
		static::show_add_to_cart( $settings, 'feed' );
	}

	/**
	 * Adds WooCommerce product info after the gallery layout meta.
	 *
	 * @param $settings
	 */
	static public function post_gallery_after_meta( $settings ) {
		static::show_product_info( $settings, 'gallery', 'meta' );
		static::show_add_to_cart( $settings, 'gallery' );
	}


	/**
	 * @param $form
	 * @param $slug
	 *
	 * @return mixed
	 * @throws Exception
	 */
	static public function post_grid_settings( $form, $slug ) {
		if ( 'post-grid' !== $slug ) {
			return $form;
		}

		if ( isset( $form['layout']['sections']['info'] ) ) {
			$form['layout']['sections']['info']['show_author']['default']   = false;
			$form['layout']['sections']['info']['show_comments']['default'] = false;
		}

		// disable BigCommerce tab if custom layout is selected.
		$form['layout']['sections']['general']['fields']['post_layout']['toggle']['default'] = array(
			'tabs' => array( 'bigcommerce' ),
		);

		FLBuilder::register_settings_form( 'bc_product_ratings_form',
			array(
				'title' => __( 'Product Ratings', 'bb-theme-builder' ),
				'tabs'  => array(
					'general' => array(
						'label'    => __( 'Style', 'bb-theme-builder' ),
						'sections' => FLThemeBuilderBigCommerceSettings::get( 'ratings' ),
					),
				),
			)
		);

		FLBuilder::register_settings_form( 'bc_product_price_form',
			array(
				'title' => __( 'Product Price', 'bb-theme-builder' ),
				'tabs'  => array(
					'general' => array(
						'title'    => '',
						'sections' => array(
							'original_price' => array(
								'title'  => __( 'Original Price', 'bb-theme-builder' ),
								'fields' => FLThemeBuilderBigCommerceSettings::get( 'price/original' ),
							),
							'sale_price'     => array(
								'title'  => __( 'Sale Price', 'bb-theme-builder' ),
								'fields' => FLThemeBuilderBigCommerceSettings::get( 'price/sale' ),
							),
						),
					),
				),
			)
		);

		FLBuilder::register_settings_form( 'bc_product_cart_form',
			array(
				'title' => __( 'Add To Cart Form', 'bb-theme-builder' ),
				'tabs'  => array(
					'button'          => array(
						'title'    => __( 'Cart Button', 'bb-theme-builder' ),
						'sections' => array(
							'general' => array(
								'title'  => '',
								'fields' => FLThemeBuilderBigCommerceSettings::get( 'cart/button' ),
							),
						),
					),
					'product_options' => array(
						'title'    => __( 'Product Options Form', 'bb-theme-builder' ),
						'sections' => array(
							'general' => array(
								'title'  => '',
								'fields' => FLThemeBuilderBigCommerceSettings::get( 'cart/form',
									array(
										'bc_cart_form' => array(
											'type'    => 'select',
											'label'   => __( 'Product Options', 'bb-theme-builder' ),
											'default' => 'hide',
											'options' => array(
												'show' => __( 'Show', 'bb-theme-builder' ),
												'hide' => __( 'Hide', 'bb-theme-builder' ),
											),
											'toggle'  => array(
												'show' => array(
													'fields' => array( 'bc_form_typography', 'bc_form_text_color' ),
												),
											),
										),
									)
								),
							),
						),
					),
				),
			)
		);

		$form['bigcommerce'] = array(
			'title'    => __( 'BigCommerce', 'bb-theme-builder' ),
			'sections' => array(
				'refinery'    => array(
					'title'  => __( 'Refinery', 'bb-theme-builder' ),
					'fields' => FLThemeBuilderBigCommerceSettings::get( 'refinery' ),
				),
				'sale'        => array(
					'title'  => __( 'Sale Display', 'bb-theme-builder' ),
					'fields' => FLThemeBuilderBigCommerceSettings::get( 'sale-badge',
						array(
							'bc_sale_flash' => array(
								'type'    => 'select',
								'label'   => __( 'Product Sale', 'bb-theme-builder' ),
								'help'    => __( 'Show a "SALE" badge when a product is marked as on sale.', 'bb-theme-builder' ),
								'default' => 'show',
								'options' => array(
									'show' => __( 'Show', 'bb-theme-builder' ),
									'hide' => __( 'Hide', 'bb-theme-builder' ),
								),
								'toggle'  => array(
									'show' => array(
										'fields' => array(
											'bc_sale_background_color',
											'bc_sale_text_color',
										),
									),
								),
							),
						)
					),
				),
				'brand'       => array(
					'title'  => __( 'Product Brand', 'bb-theme-builder' ),
					'fields' => array(
						'bc_brand'            => array(
							'type'    => 'select',
							'label'   => __( 'Show Product Brand?', 'bb-theme-builder' ),
							'default' => 'show',
							'options' => array(
								'show' => __( 'Show', 'bb-theme-builder' ),
								'hide' => __( 'Hide', 'bb-theme-builder' ),
							),
							'toggle'  => array(
								'show' => array(
									'fields' => array( 'bc_brand_text', 'bc_brand_text_color' ),
								),
							),
						),
						'bc_brand_text'       => array(
							'type'       => 'typography',
							'label'      => __( 'Brand Text', 'bb-theme-builder' ),
							'responsive' => true,
							'preview'    => array(
								'type'     => 'css',
								'selector' => '.fl-module-content .bc-product__brand',
							),
						),
						'bc_brand_text_color' => array(
							'type'       => 'color',
							'label'      => __( 'Brand Text Color', 'bb-theme-builder' ),
							'show_reset' => true,
							'preview'    => array(
								'type'     => 'css',
								'selector' => '.fl-module-content .bc-product__brand',
								'property' => 'color',
							),
						),
					),
				),
				'rating'      => array(
					'title'  => __( 'Product Rating', 'bb-theme-builder' ),
					'fields' => array(
						'bc_rating'      => array(
							'type'    => 'select',
							'label'   => __( 'Show Product Rating', 'bb-theme-builder' ),
							'default' => 'show',
							'options' => array(
								'show' => __( 'Show', 'bb-theme-builder' ),
								'hide' => __( 'Hide', 'bb-theme-builder' ),
							),
							'toggle'  => array(
								'hide' => array(),
								'show' => array(
									'fields' => array(
										'bc_rating_form',
									),
								),
							),
						),
						'bc_rating_form' => array(
							'type'  => 'form',
							'label' => __( 'Product Ratings Style', 'bb-theme-builder' ),
							'form'  => 'bc_product_ratings_form',
						),
					),
				),
				'price'       => array(
					'title'  => __( 'Product Price', 'bb-theme-builder' ),
					'fields' => array(
						'bc_price'      => array(
							'type'    => 'select',
							'label'   => __( 'Product Price', 'bb-theme-builder' ),
							'default' => 'show',
							'options' => array(
								'show' => __( 'Show', 'bb-theme-builder' ),
								'hide' => __( 'Hide', 'bb-theme-builder' ),
							),
							'toggle'  => array(
								'show' => array(
									'fields' => array( 'bc_price_form' ),
								),
							),
						),
						'bc_price_form' => array(
							'type'  => 'form',
							'label' => __( 'Product Price Styles', 'bb-theme-builder' ),
							'form'  => 'bc_product_price_form',
						),
					),
				),

				'cart_button' => array(
					'title'  => __( 'Add To Cart Button', 'bb-theme-builder' ),
					'fields' => array(
						'bc_cart_button' => array(
							'type'    => 'select',
							'label'   => __( 'Add To Cart Button', 'bb-theme-builder' ),
							'default' => 'show',
							'options' => array(
								'show' => __( 'Show', 'bb-theme-builder' ),
								'hide' => __( 'Hide', 'bb-theme-builder' ),
							),
							'toggle'  => array(
								'show' => array(
									'fields' => array(
										'bc_cart_form',
									),
								),
							),
						),
						'bc_cart_form'   => array(
							'type'  => 'form',
							'label' => __( 'Cart Form', 'bb-theme-builder' ),
							'form'  => 'bc_product_cart_form',
						),
					),
				),
			),
		);
		return $form;
	}


	/**
	 * Renders custom CSS for the post grid module.
	 *
	 * @param string $css
	 * @param array $nodes
	 *
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
				$css            .= file_get_contents( FL_THEME_BUILDER_BIGCOMMERCE_DIR . 'css/fl-theme-builder-post-grid-bigcommerce.css' );
			}

			ob_start();
			$id       = $module->node;
			$settings = $module->settings;

			$settings->bc_rating_form->bc_link_typography = json_decode( json_encode( $settings->bc_rating_form->bc_link_typography ), true );
			$settings->bc_price_form                      = json_decode( json_encode( $settings->bc_price_form ), true );
			$settings->bc_cart_form                       = json_decode( json_encode( $settings->bc_cart_form ), true );

			include FL_THEME_BUILDER_BIGCOMMERCE_DIR . 'includes/post-grid-bigcommerce.css.php';

			$css .= ob_get_clean();
		}

		return $css;
	}
}

FLThemeBuilderBigCommerceArchive::init();
