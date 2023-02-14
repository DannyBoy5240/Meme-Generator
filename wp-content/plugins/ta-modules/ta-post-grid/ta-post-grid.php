<?php

/**
 * @class FLTAPostGridModule
 */
class FLTAPostGridModule extends FLBuilderModule {

	/**
	 * @method __construct
	 */
	public function __construct() {
		parent::__construct(array(
			'name'          	=> __( 'TA Posts', 'fl-builder' ),
			'description'   	=> __( 'Display a grid of your WordPress posts.', 'fl-builder' ),
      'category'      	=> __( 'TA Modules', 'fl-builder' ),
      'dir'           => TA_MODULES_DIR . 'ta-post-grid/',
      'url'           => TA_MODULES_URL . 'ta-post-grid/',
			'editor_export' 	=> false,
			'partial_refresh'	=> true,
			'icon'				=> 'schedule.svg',
		));
	}

	/**
	 * @method enqueue_scripts
	 */
	public function enqueue_scripts() {
		if ( FLBuilderModel::is_builder_active() || 'columns' == $this->settings->layout ) {
			$this->add_js( 'jquery-imagesloaded' );
		}
		if ( FLBuilderModel::is_builder_active() || 'grid' == $this->settings->layout ) {
			$this->add_js( 'jquery-imagesloaded' );
			$this->add_js( 'jquery-masonry' );

		}
		if ( FLBuilderModel::is_builder_active() || 'gallery' == $this->settings->layout ) {
			$this->add_js( 'fl-gallery-grid' );
		}
		if ( FLBuilderModel::is_builder_active() || 'scroll' == $this->settings->pagination || 'load_more' == $this->settings->pagination ) {
			$this->add_js( 'jquery-infinitescroll' );
		}

		if ( FLBuilderModel::is_builder_active() || $this->settings->show_comments ) {
			$this->add_css( 'font-awesome-5' );
		}

		// Jetpack sharing has settings to enable sharing on posts, post types and pages.
		// If pages are disabled then jetpack will still show the share button in this module
		// but will *not* enqueue its scripts and fonts.
		// This filter forces jetpack to enqueue the sharing scripts.
		add_filter( 'sharing_enqueue_scripts', '__return_true' );
	}

	/**
	 * @since 1.10.7
	 */
	public function update( $settings ) {
		global $wp_rewrite;
		$wp_rewrite->flush_rules( false );
		return $settings;
	}

	/**
	 * Returns the slug for the posts layout.
	 *
	 * @since 1.10
	 * @return string
	 */
	public function get_layout_slug() {
		return 'columns' == $this->settings->layout ? 'grid' : $this->settings->layout;
	}

	/**
	 * Renders the CSS class for each post item.
	 *
	 * @since 1.10
	 * @return void
	 */
	public function render_post_class() {
		$settings   = $this->settings;
		$layout     = $this->get_layout_slug();
		$show_image = has_post_thumbnail() && $settings->show_image;
		$classes    = array( 'fl-post-' . $layout . '-post' );

		if ( $show_image ) {
			if ( 'feed' == $layout ) {
				$classes[] = 'fl-post-feed-image-' . $settings->image_position;
			}
			if ( 'grid' == $layout ) {
				$classes[] = 'fl-post-grid-image-' . $settings->grid_image_position;
			}
			if ( 'columns' == $settings->layout ) {
				$classes[] = 'fl-post-columns-post';
			}
		}

		if ( in_array( $layout, array( 'grid', 'feed' ) ) ) {
			$classes[] = 'fl-post-align-' . $settings->post_align;
		}

		post_class( apply_filters( 'fl_builder_ta_posts_module_classes', $classes, $settings ) );
	}

	/**
	 * Renders the featured image for a post.
	 *
	 * @since 1.10
	 * @param string|array $position
	 * @return void
	 */
	public function render_featured_image( $position = 'above' ) {
		$settings = $this->settings;
		$render   = false;
		$position = ! is_array( $position ) ? array( $position ) : $position;
		$layout   = $this->get_layout_slug();

		if ( has_post_thumbnail() && $settings->show_image ) {

			if ( 'feed' == $settings->layout && in_array( $settings->image_position, $position ) ) {
				$render = true;
			} elseif ( 'columns' == $settings->layout && in_array( $settings->grid_image_position, $position ) ) {
				$render = true;
			} elseif ( 'grid' == $settings->layout && in_array( $settings->grid_image_position, $position ) ) {
				$render = true;
			}

			if ( $render ) {
				include $this->dir . 'includes/featured-image.php';
			}
		}
	}

	/**
	 * Checks to see if a featured image exists for a position.
	 *
	 * @since 1.10
	 * @param string|array $position
	 * @return void
	 */
	public function has_featured_image( $position = 'above' ) {
		$settings = $this->settings;
		$result   = false;
		$position = ! is_array( $position ) ? array( $position ) : $position;

		if ( has_post_thumbnail() && $settings->show_image ) {

			if ( 'feed' == $settings->layout && in_array( $settings->image_position, $position ) ) {
				$result = true;
			} elseif ( 'columns' == $settings->layout && in_array( $settings->grid_image_position, $position ) ) {
				$result = true;
			} elseif ( 'grid' == $settings->layout && in_array( $settings->grid_image_position, $position ) ) {
				$result = true;
			}
		}

		return $result;
	}

	/**
	 * Renders the_content for a post.
	 *
	 * @since 1.10
	 * @return void
	 */
	public function render_content() {
		ob_start();
		the_content();
		$content = ob_get_clean();

		if ( ! empty( $this->settings->content_length ) ) {
			$content = wpautop( wp_trim_words( $content, $this->settings->content_length, '...' ) );
		}

		echo $content;
	}

	/**
	 * Renders the_excerpt for a post.
	 *
	 * @since 1.10
	 * @return void
	 */
	public function render_excerpt() {
		if ( ! empty( $this->settings->content_length ) ) {
			add_filter( 'excerpt_length', array( $this, 'set_custom_excerpt_length' ), 9999 );
		}

		the_excerpt();

		if ( ! empty( $this->settings->content_length ) ) {
			remove_filter( 'excerpt_length', array( $this, 'set_custom_excerpt_length' ), 9999 );
		}
	}

	/**
	 * Renders the excerpt for a post.
	 *
	 * @since 1.10
	 * @return void
	 */
	public function set_custom_excerpt_length( $length ) {
		return $this->settings->content_length;
	}

	/**
	 * Get the terms for the current post.
	 *
	 * @since 1.10.8
	 * @return string|null
	 */
	public function get_post_terms() {
		$post_type = get_post_type();
		$taxonomies = get_object_taxonomies( $post_type, 'objects' );
		$terms_list = array();
		$terms_separator = '<span class="fl-sep-term">' . $this->settings->terms_separator . '</span>';

		if ( ! $taxonomies || empty( $taxonomies ) ) {
			return;
		}

		foreach ( $taxonomies as $name => $tax ) {
			if ( ! $tax->hierarchical ) {
				continue;
			}

			$term_list = get_the_term_list( get_the_ID(), $name, '', $terms_separator, '' );
			if ( ! empty( $term_list ) ) {
				$terms_list[] = $term_list;
			}
		}

		if ( count( $terms_list ) > 0 ) {
			return join( $terms_separator, $terms_list );
		}
	}

	/**
	 * Renders the schema structured data for the current
	 * post in the loop.
	 *
	 * @since 1.7.4
	 * @return void
	 */
	static public function schema_meta() {
		// General Schema Meta
		echo '<meta itemscope itemprop="mainEntityOfPage" itemtype="https://schema.org/WebPage" itemid="' . esc_url( get_permalink() ) . '" content="' . the_title_attribute( array(
			'echo' => false,
		) ) . '" />';
		echo '<meta itemprop="datePublished" content="' . get_the_time( 'Y-m-d' ) . '" />';
		echo '<meta itemprop="dateModified" content="' . get_the_modified_date( 'Y-m-d' ) . '" />';

		// Publisher Schema Meta
		echo '<div itemprop="publisher" itemscope itemtype="https://schema.org/Organization">';
		echo '<meta itemprop="name" content="' . get_bloginfo( 'name' ) . '">';

		if ( class_exists( 'FLTheme' ) && 'image' == FLTheme::get_setting( 'fl-logo-type' ) ) {
			echo '<div itemprop="logo" itemscope itemtype="https://schema.org/ImageObject">';
			echo '<meta itemprop="url" content="' . FLTheme::get_setting( 'fl-logo-image' ) . '">';
			echo '</div>';
		}

		echo '</div>';

		// Author Schema Meta
		echo '<div itemscope itemprop="author" itemtype="https://schema.org/Person">';
		echo '<meta itemprop="url" content="' . get_author_posts_url( get_the_author_meta( 'ID' ) ) . '" />';
		echo '<meta itemprop="name" content="' . get_the_author_meta( 'display_name', get_the_author_meta( 'ID' ) ) . '" />';
		echo '</div>';

		// Image Schema Meta
		if ( has_post_thumbnail() ) {

			$image = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'full' );

			if ( is_array( $image ) ) {
				echo '<div itemscope itemprop="image" itemtype="https://schema.org/ImageObject">';
				echo '<meta itemprop="url" content="' . $image[0] . '" />';
				echo '<meta itemprop="width" content="' . $image[1] . '" />';
				echo '<meta itemprop="height" content="' . $image[2] . '" />';
				echo '</div>';
			}
		}

		// Comment Schema Meta
		echo '<div itemprop="interactionStatistic" itemscope itemtype="https://schema.org/InteractionCounter">';
		echo '<meta itemprop="interactionType" content="https://schema.org/CommentAction" />';
		echo '<meta itemprop="userInteractionCount" content="' . wp_count_comments( get_the_ID() )->approved . '" />';
		echo '</div>';
	}

	/**
	 * Renders the schema itemtype for the current
	 * post in the loop.
	 *
	 * @since 1.7.4
	 * @return void
	 */
	static public function schema_itemtype() {
		global $post;

		if ( ! is_object( $post ) || ! isset( $post->post_type ) || 'post' != $post->post_type ) {
			echo 'https://schema.org/CreativeWork';
		} else {
			echo 'https://schema.org/BlogPosting';
		}
	}
}

/**
 * Register the module and its form settings.
 */
FLBuilder::register_module('FLTAPostGridModule', array(
	'layout'        => array(
		'title'         => __( 'Layout', 'fl-builder' ),
		'sections'      => array(
			'general'       => array(
				'title'         => '',
				'fields'        => array(
					'layout'        => array(
						'type'          => 'select',
						'label'         => __( 'Layout', 'fl-builder' ),
						'default'       => 'grid',
						'options'       => array(
							'columns'       => __( 'Columns', 'fl-builder' ),
							'grid'          => __( 'Masonry', 'fl-builder' ),
							'gallery'       => __( 'Gallery', 'fl-builder' ),
							'feed'          => __( 'List', 'fl-builder' ),
						),
						'toggle'        => array(
							'columns'       => array(
								'sections'      => array( 'posts', 'image', 'content', 'post_style', 'text_style' ),
								'fields'        => array( 'match_height', 'post_columns', 'post_spacing', 'post_padding', 'grid_image_position', 'grid_image_spacing', 'show_author', 'show_comments_grid', 'info_separator', 'show_terms' ),
							),
							'grid'          => array(
								'sections'      => array( 'posts', 'image', 'content', 'post_style', 'text_style' ),
								'fields'        => array( 'match_height', 'post_width', 'post_spacing', 'post_padding', 'grid_image_position', 'grid_image_spacing', 'show_author', 'show_comments_grid', 'info_separator', 'show_terms' ),
							),
							'gallery'		=> array(
								'sections'      => array( 'gallery_general', 'overlay_style', 'icons' ),
							),
							'feed'          => array(
								'sections'      => array( 'posts', 'image', 'content', 'post_style', 'text_style' ),
								'fields'        => array( 'feed_post_spacing', 'feed_post_padding', 'image_position', 'image_spacing', 'image_width', 'show_author', 'show_comments', 'info_separator', 'show_terms', 'content_type' ),
							),
						),
					),
				),
			),
			'posts'         => array(
				'title'         => __( 'Posts', 'fl-builder' ),
				'fields'        => array(
					'match_height'  => array(
						'type'          => 'select',
						'label'         => __( 'Equal Heights', 'fl-builder' ),
						'default'       => '0',
						'options'       => array(
							'1'             => __( 'Yes', 'fl-builder' ),
							'0'             => __( 'No', 'fl-builder' ),
						),
					),
					'post_width'    => array(
						'type'          => 'text',
						'label'         => __( 'Post Width', 'fl-builder' ),
						'default'       => '300',
						'maxlength'     => '3',
						'size'          => '4',
						'description'   => 'px',
					),
					'post_columns'  => array(
						'type'          => 'unit',
						'label'         => __( 'Columns', 'fl-builder' ),
						'responsive'  => array(
							'default' 	  => array(
								'default'    => '3',
								'medium'     => '2',
								'responsive' => '1',
							),
						),
					),
					'post_spacing' => array(
						'type'          => 'text',
						'label'         => __( 'Post Spacing', 'fl-builder' ),
						'default'       => '60',
						'maxlength'     => '3',
						'size'          => '4',
						'description'   => 'px',
					),
					'feed_post_spacing' => array(
						'type'          => 'text',
						'label'         => __( 'Post Spacing', 'fl-builder' ),
						'default'       => '40',
						'maxlength'     => '3',
						'size'          => '4',
						'description'   => 'px',
					),
					'post_padding' => array(
						'type'          => 'text',
						'label'         => __( 'Post Padding', 'fl-builder' ),
						'default'       => '20',
						'maxlength'     => '3',
						'size'          => '4',
						'description'   => 'px',
						'preview'       => array(
							'type'			=> 'css',
							'selector'		=> '.fl-post-grid-text',
							'property'		=> 'padding',
							'unit'			=> 'px',
						),
					),
					'feed_post_padding' => array(
						'type'          => 'text',
						'label'         => __( 'Post Padding', 'fl-builder' ),
						'default'       => '0',
						'maxlength'     => '3',
						'size'          => '4',
						'description'   => 'px',
					),
					'post_align'    => array(
						'type'          => 'select',
						'label'         => __( 'Post Alignment', 'fl-builder' ),
						'default'       => 'default',
						'options'       => array(
							'default'       => __( 'Default', 'fl-builder' ),
							'left'          => __( 'Left', 'fl-builder' ),
							'center'        => __( 'Center', 'fl-builder' ),
							'right'         => __( 'Right', 'fl-builder' ),
						),
					),
				),
			),
			'image'        => array(
				'title'         => __( 'Featured Image', 'fl-builder' ),
				'fields'        => array(
					'show_image'    => array(
						'type'          => 'select',
						'label'         => __( 'Image', 'fl-builder' ),
						'default'       => '0',
						'options'       => array(
							'1'             => __( 'Show', 'fl-builder' ),
							'0'             => __( 'Hide', 'fl-builder' ),
						),
					),
					'grid_image_position' => array(
						'type'          => 'select',
						'label'         => __( 'Image Position', 'fl-builder' ),
						'default'       => 'above-title',
						'options'       => array(
							'above-title'   => __( 'Above Title', 'fl-builder' ),
							'above'         => __( 'Above Content', 'fl-builder' ),
						),
					),
					'image_position' => array(
						'type'          => 'select',
						'label'         => __( 'Image Position', 'fl-builder' ),
						'default'       => 'above',
						'options'       => array(
							'above-title'			=> __( 'Above Title', 'fl-builder' ),
							'above'					=> __( 'Above Content', 'fl-builder' ),
							'beside'				=> __( 'Left', 'fl-builder' ),
							'beside-content'		=> __( 'Left Content', 'fl-builder' ),
							'beside-right'			=> __( 'Right', 'fl-builder' ),
							'beside-content-right'	=> __( 'Right Content', 'fl-builder' ),
						),
					),
					'image_size'    => array(
						'type'          => 'photo-sizes',
						'label'         => __( 'Image Size', 'fl-builder' ),
						'default'       => 'medium',
					),
					'grid_image_spacing' => array(
						'type'          => 'text',
						'label'         => __( 'Image Spacing', 'fl-builder' ),
						'default'       => '0',
						'maxlength'     => '3',
						'size'          => '4',
						'description'   => 'px',
					),
					'image_spacing' => array(
						'type'          => 'text',
						'label'         => __( 'Image Spacing', 'fl-builder' ),
						'default'       => '0',
						'maxlength'     => '3',
						'size'          => '4',
						'description'   => 'px',
					),
					'image_width'   => array(
						'type'          => 'text',
						'label'         => __( 'Image Width', 'fl-builder' ),
						'default'       => '33',
						'maxlength'     => '3',
						'size'          => '4',
						'description'   => '%',
					),
				),
			),
			'info'          => array(
				'title'         => __( 'Post Info', 'fl-builder' ),
				'fields'        => array(
					'show_author'   => array(
						'type'          => 'select',
						'label'         => __( 'Author', 'fl-builder' ),
						'default'       => '0',
						'options'       => array(
							'1'             => __( 'Show', 'fl-builder' ),
							'0'             => __( 'Hide', 'fl-builder' ),
						),
					),
					'show_date'     => array(
						'type'          => 'select',
						'label'         => __( 'Date', 'fl-builder' ),
						'default'       => '0',
						'options'       => array(
							'1'             => __( 'Show', 'fl-builder' ),
							'0'             => __( 'Hide', 'fl-builder' ),
						),
						'toggle'        => array(
							'1'             => array(
								'fields'        => array( 'date_format' ),
							),
						),
					),
					'date_format'   => array(
						'type'          => 'select',
						'label'         => __( 'Date Format', 'fl-builder' ),
						'default'       => 'default',
						'options'       => array(
							'default'		=> __( 'Default', 'fl-builder' ),
							'M j, Y'        => date( 'M j, Y' ),
							'F j, Y'        => date( 'F j, Y' ),
							'm/d/Y'         => date( 'm/d/Y' ),
							'm-d-Y'         => date( 'm-d-Y' ),
							'd M Y'         => date( 'd M Y' ),
							'd F Y'         => date( 'd F Y' ),
							'Y-m-d'         => date( 'Y-m-d' ),
							'Y/m/d'         => date( 'Y/m/d' ),
						),
					),
					'show_comments' => array(
						'type'          => 'select',
						'label'         => __( 'Comments', 'fl-builder' ),
						'default'       => '0',
						'options'       => array(
							'1'             => __( 'Show', 'fl-builder' ),
							'0'             => __( 'Hide', 'fl-builder' ),
						),
					),
					'show_comments_grid' => array(
						'type'          => 'select',
						'label'         => __( 'Comments', 'fl-builder' ),
						'default'       => '0',
						'options'       => array(
							'1'             => __( 'Show', 'fl-builder' ),
							'0'             => __( 'Hide', 'fl-builder' ),
						),
					),
					'info_separator' => array(
						'type'          => 'text',
						'label'         => __( 'Separator', 'fl-builder' ),
						'default'       => ' | ',
						'size'          => '4',
						'preview'       => array(
							'type'			=> 'text',
							'selector'		=> '.fl-sep',
						),
					),
					'show_terms'        => array(
						'type'          => 'select',
						'label'         => __( 'Terms', 'fl-builder' ),
						'default'       => '0',
						'options'       => array(
							'1'             => __( 'Show', 'fl-builder' ),
							'0'             => __( 'Hide', 'fl-builder' ),
						),
						'toggle'        => array(
							'1'             => array(
								'fields'        => array( 'terms_separator', 'terms_list_label' ),
							),
						),
					),
					'terms_list_label' => array(
						'type'          => 'text',
						'label'         => __( 'Terms Label', 'fl-builder' ),
						'default'       => __( 'Posted in ', 'fl-builder' ),
						'preview'       => array(
							'type'			=> 'text',
							'selector'		=> '.fl-terms-label',
						),
					),
					'terms_separator' => array(
						'type'          => 'text',
						'label'         => __( 'Terms Separator', 'fl-builder' ),
						'default'       => ', ',
						'size'          => '4',
						'preview'       => array(
							'type'			=> 'text',
							'selector'		=> '.fl-sep-term',
						),
					),
				),
			),
			'content'       => array(
				'title'         => __( 'Content', 'fl-builder' ),
				'fields'        => array(
          'link_content'   => array(
						'type'          => 'select',
						'label'         => __( 'Link to Content', 'fl-builder' ),
						'default'       => '1',
						'options'       => array(
							'1'             => __( 'Yes', 'fl-builder' ),
							'0'             => __( 'No', 'fl-builder' ),
						),
					),
					'show_content'  => array(
						'type'          => 'select',
						'label'         => __( 'Content', 'fl-builder' ),
						'default'       => '1',
						'options'       => array(
							'1'             => __( 'Show', 'fl-builder' ),
							'0'             => __( 'Hide', 'fl-builder' ),
						),
					),
					'content_type'  => array(
						'type'          => 'select',
						'label'         => __( 'Content Type', 'fl-builder' ),
						'default'       => 'excerpt',
						'options'       => array(
							'excerpt'        => __( 'Excerpt', 'fl-builder' ),
							'full'           => __( 'Full Text', 'fl-builder' ),
						),
					),
					'content_length' => array(
						'type'          => 'text',
						'label'         => __( 'Content Length', 'fl-builder' ),
						'default'       => '',
						'size'          => '4',
						'description'   => __( 'words', 'fl-builder' ),
					),
					'show_more_link' => array(
						'type'          => 'select',
						'label'         => __( 'More Link', 'fl-builder' ),
						'default'       => '0',
						'options'       => array(
							'1'             => __( 'Show', 'fl-builder' ),
							'0'             => __( 'Hide', 'fl-builder' ),
						),
						'toggle'        => array(
							'1'             => array(
								'fields'        => array( 'more_link_text' ),
							),
						),
					),
					'more_link_text' => array(
						'type'          => 'text',
						'label'         => __( 'More Link Text', 'fl-builder' ),
						'default'       => __( 'Read More', 'fl-builder' ),
					),
				),
			),
		),
	),
	'style'         => array(
		'title'         => __( 'Style', 'fl-builder' ),
		'sections'      => array(
			'post_style'    => array(
				'title'         => __( 'Posts', 'fl-builder' ),
				'fields'        => array(
					'bg_color'      => array(
						'type'          => 'color',
						'label'         => __( 'Post Background Color', 'fl-builder' ),
						'show_reset'    => true,
					),
					'bg_opacity'    => array(
						'type'          => 'text',
						'label'         => __( 'Post Background Opacity', 'fl-builder' ),
						'default'       => '100',
						'maxlength'     => '3',
						'size'          => '4',
						'description'   => '%',
					),
					'border_type'   => array(
						'type'          => 'select',
						'label'         => __( 'Post Border Type', 'fl-builder' ),
						'default'       => 'default',
						'options'       => array(
							'default'       => _x( 'Default', 'Border type.', 'fl-builder' ),
							'none'          => _x( 'None', 'Border type.', 'fl-builder' ),
							'solid'         => _x( 'Solid', 'Border type.', 'fl-builder' ),
							'dashed'        => _x( 'Dashed', 'Border type.', 'fl-builder' ),
							'dotted'        => _x( 'Dotted', 'Border type.', 'fl-builder' ),
							'double'        => _x( 'Double', 'Border type.', 'fl-builder' ),
						),
						'toggle'        => array(
							'solid'         => array(
								'fields'        => array( 'border_color', 'border_size' ),
							),
							'dashed'        => array(
								'fields'        => array( 'border_color', 'border_size' ),
							),
							'dotted'        => array(
								'fields'        => array( 'border_color', 'border_size' ),
							),
							'double'        => array(
								'fields'        => array( 'border_color', 'border_size' ),
							),
						),
					),
					'border_color'  => array(
						'type'          => 'color',
						'label'         => __( 'Post Border Color', 'fl-builder' ),
						'show_reset'    => true,
					),
					'border_size'  => array(
						'type'          => 'text',
						'label'         => __( 'Post Border Size', 'fl-builder' ),
						'default'       => '1',
						'maxlength'     => '3',
						'size'          => '4',
						'description'   => 'px',
					),
				),
			),
			'text_style'    => array(
				'title'         => __( 'Text', 'fl-builder' ),
				'fields'        => array(
					'title_color'   => array(
						'type'          => 'color',
						'label'         => __( 'Title Color', 'fl-builder' ),
						'show_reset'    => true,
					),
					'title_font_size' => array(
						'type'          => 'text',
						'label'         => __( 'Title Font Size', 'fl-builder' ),
						'default'       => '',
						'maxlength'     => '3',
						'size'          => '4',
						'description'   => 'px',
					),
					'info_color'    => array(
						'type'          => 'color',
						'label'         => __( 'Post Info Color', 'fl-builder' ),
						'show_reset'    => true,
					),
					'info_font_size' => array(
						'type'          => 'text',
						'label'         => __( 'Post Info Font Size', 'fl-builder' ),
						'default'       => '',
						'maxlength'     => '3',
						'size'          => '4',
						'description'   => 'px',
					),
					'content_color' => array(
						'type'          => 'color',
						'label'         => __( 'Content Color', 'fl-builder' ),
						'show_reset'    => true,
					),
					'content_font_size' => array(
						'type'          => 'text',
						'label'         => __( 'Content Font Size', 'fl-builder' ),
						'default'       => '',
						'maxlength'     => '3',
						'size'          => '4',
						'description'   => 'px',
					),
					'link_color'    => array(
						'type'          => 'color',
						'label'         => __( 'Link Color', 'fl-builder' ),
						'show_reset'    => true,
					),
					'link_hover_color' => array(
						'type'          => 'color',
						'label'         => __( 'Link Hover Color', 'fl-builder' ),
						'show_reset'    => true,
					),
				),
			),
			'gallery_general'          => array(
				'title'         => '',
				'fields'        => array(
					'hover_transition'   => array(
						'type'          => 'select',
						'label'         => __( 'Hover Transition', 'fl-builder' ),
						'default'       => 'fade',
						'options'       => array(
							'fade'			=> __( 'Fade', 'fl-builder' ),
							'slide-up'     	=> __( 'Slide Up', 'fl-builder' ),
							'slide-down'   	=> __( 'Slide Down', 'fl-builder' ),
							'scale-up'   	=> __( 'Scale Up', 'fl-builder' ),
							'scale-down'   	=> __( 'Scale Down', 'fl-builder' ),
						),
					),
				),
			),
			'overlay_style' => array(
				'title'         => __( 'Overlay Colors', 'fl-builder' ),
				'fields'        => array(
					'text_color'    => array(
						'type'          => 'color',
						'label'         => __( 'Overlay Text Color', 'fl-builder' ),
						'default'       => 'ffffff',
						'show_reset'    => true,
					),
					'text_bg_color' => array(
						'type'          => 'color',
						'label'         => __( 'Overlay Background Color', 'fl-builder' ),
						'default'       => '333333',
						'help'          => __( 'The color applies to the overlay behind text over the background selections.', 'fl-builder' ),
						'show_reset'    => true,
					),
					'text_bg_opacity' => array(
						'type'          => 'text',
						'label'         => __( 'Overlay Background Opacity', 'fl-builder' ),
						'default'       => '50',
						'maxlength'     => '3',
						'size'          => '4',
						'description'   => '%',
					),
				),
			),
			'icons'          => array(
				'title'         => __( 'Icons', 'fl-builder' ),
				'fields'        => array(
					'has_icon'   => array(
						'type'          => 'select',
						'label'         => __( 'Use Icon for Posts', 'fl-builder' ),
						'default'       => 'no',
						'options'       => array(
							'yes'			=> __( 'Yes', 'fl-builder' ),
							'no' 	      	=> __( 'No', 'fl-builder' ),
						),
						'toggle'		=> array(
							'yes'			=> array(
								'fields'		=> array( 'icon', 'icon_position', 'icon_color', 'icon_size' ),
							),
						),
					),
					'icon'  => array(
						'type'          => 'icon',
						'label'         => __( 'Post Icon', 'fl-builder' ),
					),
					'icon_position'   => array(
						'type'          => 'select',
						'label'         => __( 'Post Icon Position', 'fl-builder' ),
						'default'       => 'above',
						'options'       => array(
							'above'			=> __( 'Above Text', 'fl-builder' ),
							'below'       	=> __( 'Below Text', 'fl-builder' ),
						),
					),
					'icon_size'  => array(
						'type'          => 'text',
						'label'         => __( 'Post Icon Size', 'fl-builder' ),
						'default'       => '24',
						'maxlength'     => '3',
						'size'          => '4',
						'description'   => 'px',
					),
					'icon_color' => array(
						'type'          => 'color',
						'label'         => __( 'Post Icon Color', 'fl-builder' ),
						'show_reset'    => true,
					),
				),
			),
		),
	),
	'content'   => array(
		'title'         => __( 'Content', 'fl-builder' ),
		'file'          => FL_BUILDER_DIR . 'includes/loop-settings.php',
	),
	'pagination' => array(
		'title'      => __( 'Pagination', 'fl-builder' ),
		'sections'   => array(
			'pagination'   => array(
				'title'         => __( 'Pagination', 'fl-builder' ),
				'fields'        => array(
					'pagination'     => array(
						'type'          => 'select',
						'label'         => __( 'Pagination Style', 'fl-builder' ),
						'default'       => 'numbers',
						'options'       => array(
							'numbers'       => __( 'Numbers', 'fl-builder' ),
							'scroll'        => __( 'Scroll', 'fl-builder' ),
							'load_more'     => __( 'Load More Button', 'fl-builder' ),
							'none'          => _x( 'None', 'Pagination style.', 'fl-builder' ),
						),
						'toggle' 		=> array(
							'load_more' 	=> array(
								'sections' 		=> array( 'load_more_general' ),
							),
						),
					),
					'posts_per_page' => array(
						'type'          => 'text',
						'label'         => __( 'Posts Per Page', 'fl-builder' ),
						'default'       => '10',
						'size'          => '4',
					),
					'no_results_message' => array(
						'type' 				=> 'text',
						'label'				=> __( 'No Results Message', 'fl-builder' ),
						'default'			=> __( "Sorry, we couldn't find any posts. Please try a different search.", 'fl-builder' ),
					),
					'show_search'    => array(
						'type'          => 'select',
						'label'         => __( 'Show Search', 'fl-builder' ),
						'default'       => '1',
						'options'       => array(
							'1'             => __( 'Show', 'fl-builder' ),
							'0'             => __( 'Hide', 'fl-builder' ),
						),
						'help'          => __( 'Shows the search form if no posts are found.' ),
					),
				),
			),
			'load_more_general' => array(
				'title'         => __( 'Load More Button', 'fl-builder' ),
				'fields'        => array(
					'more_btn_text' => array(
						'type'          => 'text',
						'label'         => __( 'Button Text', 'fl-builder' ),
						'default'       => __( 'Load More', 'fl-builder' ),
					),
					'more_btn_icon'      => array(
						'type'          => 'icon',
						'label'         => __( 'Button Icon', 'fl-builder' ),
						'show_remove'   => true,
					),
					'more_btn_icon_position' => array(
						'type'          => 'select',
						'label'         => __( 'Icon Position', 'fl-builder' ),
						'default'       => 'before',
						'options'       => array(
							'before'        => __( 'Before Text', 'fl-builder' ),
							'after'         => __( 'After Text', 'fl-builder' ),
						),
					),
					'more_btn_icon_animation' => array(
						'type'          => 'select',
						'label'         => __( 'Icon Visibility', 'fl-builder' ),
						'default'       => 'disable',
						'options'       => array(
							'disable'        => __( 'Always Visible', 'fl-builder' ),
							'enable'         => __( 'Fade In On Hover', 'fl-builder' ),
						),
					),
					'more_btn_bg_color'  => array(
						'type'          => 'color',
						'label'         => __( 'Background Color', 'fl-builder' ),
						'default'       => '',
						'show_reset'    => true,
					),
					'more_btn_bg_hover_color' => array(
						'type'          => 'color',
						'label'         => __( 'Background Hover Color', 'fl-builder' ),
						'default'       => '',
						'show_reset'    => true,
						'preview'       => array(
							'type'          => 'none',
						),
					),
					'more_btn_text_color' => array(
						'type'          => 'color',
						'label'         => __( 'Text Color', 'fl-builder' ),
						'default'       => '',
						'show_reset'    => true,
					),
					'more_btn_text_hover_color' => array(
						'type'          => 'color',
						'label'         => __( 'Text Hover Color', 'fl-builder' ),
						'default'       => '',
						'show_reset'    => true,
						'preview'       => array(
							'type'          => 'none',
						),
					),
					'more_btn_font_size' => array(
						'type'          => 'text',
						'label'         => __( 'Font Size', 'fl-builder' ),
						'default'       => '14',
						'maxlength'     => '3',
						'size'          => '4',
						'description'   => 'px',
					),
					'more_btn_padding'   => array(
						'type'          => 'text',
						'label'         => __( 'Padding', 'fl-builder' ),
						'default'       => '10',
						'maxlength'     => '3',
						'size'          => '4',
						'description'   => 'px',
					),
					'more_btn_border_radius' => array(
						'type'          => 'text',
						'label'         => __( 'Round Corners', 'fl-builder' ),
						'default'       => '4',
						'maxlength'     => '3',
						'size'          => '4',
						'description'   => 'px',
					),
					'more_btn_width'	 => array(
						'type'		  => 'select',
						'label'		  => __( 'Width', 'fl-builder' ),
						'default'		  => 'auto',
						'options'		  => array(
							'auto'		   => _x( 'Auto', 'Width.', 'fl-builder' ),
							'full'		   => __( 'Full Width', 'fl-builder' ),
						),
					),
				),
			),
		),
	),
));
