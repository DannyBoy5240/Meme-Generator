<?php

/**
 * Handles logic for page data post properties.
 *
 * @since 1.0
 */
final class FLPageDataPost {

	/**
	 * @since 1.0
	 * @param object $settings
	 * @return string
	 */
	static public function get_excerpt( $settings ) {

		global $post;
		$real_post = $post;
		$filter    = false;
		if ( has_filter( 'the_content', 'FLBuilder::render_content' ) ) {
			remove_filter( 'the_content', 'FLBuilder::render_content' );
			$filter = true;
		}

		add_filter( 'excerpt_length', array( __CLASS__, 'excerpt_length_filter' ), 9999 );
		add_filter( 'excerpt_more', array( __CLASS__, 'excerpt_more_filter' ), 9999 );

		if ( is_single() ) {
			setup_postdata( $post );
			if ( has_excerpt() ) {
				$content = '<p>' . self::wp_trim_words( get_the_excerpt(), $settings->length, $settings->more ) . '</p>';
			} else {
				$content = apply_filters( 'the_excerpt', get_the_excerpt() );
			}
			wp_reset_postdata();
		} else {
			$content = apply_filters( 'the_excerpt', get_the_excerpt() );
		}

		if ( $filter ) {
			add_filter( 'the_content', 'FLBuilder::render_content' );
		}

		remove_filter( 'excerpt_length', array( __CLASS__, 'excerpt_length_filter' ) );
		remove_filter( 'excerpt_more', array( __CLASS__, 'excerpt_more_filter' ) );
		$post = $real_post;
		return $content;
	}

	static public function wp_trim_words( $text, $num_words = 55, $more = null ) {
		if ( null === $more ) {
			$more = __( '&hellip;', 'bb-theme-builder' );
		}

		$original_text = $text;

		/*
		* translators: If your word count is based on single characters (e.g. East Asian characters),
		* enter 'characters_excluding_spaces' or 'characters_including_spaces'. Otherwise, enter 'words'.
		* Do not translate into your own language.
		*/
		if ( strpos( _x( 'words', 'Word count type. Do not translate!', 'bb-theme-builder' ), 'characters' ) === 0 && preg_match( '/^utf\-?8$/i', get_option( 'blog_charset' ) ) ) {
			$text = trim( preg_replace( "/[\n\r\t ]+/", ' ', $text ), ' ' );
			preg_match_all( '/./u', $text, $words_array );
			$words_array = array_slice( $words_array[0], 0, $num_words + 1 );
			$sep         = '';
		} else {
			$words_array = preg_split( "/[\n\r\t ]+/", $text, $num_words + 1, PREG_SPLIT_NO_EMPTY );
			$sep         = ' ';
		}

		if ( count( $words_array ) > $num_words ) {
			array_pop( $words_array );
			$text = implode( $sep, $words_array );
			$text = $text . $more;
		} else {
			$text = implode( $sep, $words_array );
		}

		return $text;
	}

	/**
	 * @since 1.0
	 * @param string $length
	 * @return string
	 */
	static public function excerpt_length_filter( $length ) {
		$settings = FLPageData::get_current_settings();
		return $settings && is_numeric( $settings->length ) ? $settings->length : 55;
	}

	/**
	 * @since 1.0
	 * @param string $more
	 * @return string
	 */
	static public function excerpt_more_filter( $more ) {
		$settings = FLPageData::get_current_settings();
		return $settings && ! empty( $settings->more ) ? $settings->more : '...';
	}

	/**
	 * @since 1.0
	 * @return string
	 */
	static public function get_content() {
		$is_content_building_enabled = FLThemeBuilderFrontendEdit::is_content_building_enabled();

		if ( $is_content_building_enabled ) {
			remove_filter( 'fl_builder_do_render_content', '__return_false' );
			ob_start();
			FLBuilder::render_content_by_id( FLBuilderModel::get_post_id( true ) );
			$content = ob_get_clean();
			return $content;

		} else {

			$filter = false;
			if ( has_filter( 'the_content', 'FLBuilder::render_content' ) ) {
				remove_filter( 'the_content', 'FLBuilder::render_content' );
				$filter = true;
			}

			if ( is_single() && FLBuilderModel::is_builder_active() && 'product' !== get_post_type() ) {
				global $post;

				$real_post = $post;
				setup_postdata( $post );
				$content = apply_filters( 'the_content', get_the_content() );
				wp_reset_postdata();
				$post = $real_post;

			} else {

				if ( has_filter( 'the_content', '_restore_wpautop_hook' ) && ! has_filter( 'the_content', 'wpautop' ) ) {
					add_filter( 'the_content', 'wpautop' );
				}
				$content = apply_filters( 'the_content', get_the_content() );
			}

			$content .= wp_link_pages( array(
				'before'      => '<div class="page-links">' . __( 'Pages:', 'bb-theme-builder' ),
				'after'       => '</div>',
				'link_before' => '<span class="page-number">',
				'link_after'  => '</span>',
				'echo'        => false,
			) );

			if ( $filter ) {
				add_filter( 'the_content', 'FLBuilder::render_content' );
			}
		}

		return $content;
	}

	/**
	 * @since 1.0
	 * @param object $settings
	 * @return string
	 */
	static public function get_link( $settings ) {
		$href = get_permalink();

		if ( 'title' == $settings->text ) {
			$title = the_title_attribute( array(
				'echo' => false,
			) );
			$text  = get_the_title();
		} else {
			$title = esc_attr( $settings->custom_text );
			$text  = $settings->custom_text;
		}

		return "<a href='{$href}' title='{$title}'>{$text}</a>";
	}

	/**
	 * @since 1.0
	 * @param object $settings
	 * @return string
	 */
	static public function get_date( $settings ) {
		return get_the_date( $settings->format );
	}

	/**
	 * @since 1.0.3
	 * @param object $settings
	 * @return string
	 */
	static public function get_modified_date( $settings ) {

		if ( 'human' == $settings->format ) {
			return human_time_diff( get_the_time( 'U' ) ) . ' ago';
		}
		return get_the_modified_date( $settings->format );
	}

	/**
	 * @since 1.0
	 * @param object $settings
	 * @return string
	 */
	static public function get_featured_image( $settings ) {
		global $post;

		if ( 'tag' == $settings->display ) {

			$class = 'default' == $settings->align ? '' : 'align' . $settings->align;
			$image = get_the_post_thumbnail( $post, $settings->size, array(
				'itemprop' => 'image',
				'class'    => $class,
			) );

			if ( $image && 'yes' == $settings->linked ) {

				$href  = get_the_permalink();
				$title = the_title_attribute( array(
					'echo' => false,
				) );

				return "<a href='{$href}' title='{$title}'>{$image}</a>";
			} else {
				return $image;
			}
		} elseif ( 'url' == $settings->display ) {
			return get_the_post_thumbnail_url( $post, $settings->size );
		} elseif ( 'alt' == $settings->display ) {
			return get_post_meta( get_post_thumbnail_id( $post->ID ), '_wp_attachment_image_alt', true );
		} else {
			if ( get_post_thumbnail_id( $post->ID ) ) {
				$image = get_post( get_post_thumbnail_id( $post->ID ) );
				if ( 'title' == $settings->display ) {
					return $image->post_title;
				} elseif ( 'caption' == $settings->display ) {
					return $image->post_excerpt;
				} elseif ( 'description' == $settings->display ) {
					return $image->post_content;
				}
			}
		}
	}

	/**
	 * @since 1.0
	 * @param object $settings
	 * @return array
	 */
	static public function get_featured_image_url( $settings ) {
		global $post;

		$id  = '';
		$url = '';

		if ( has_post_thumbnail( $post ) ) {
			$id  = get_post_thumbnail_id( $post->ID );
			$url = get_the_post_thumbnail_url( $post, $settings->size );
		} elseif ( isset( $settings->default_img_src ) ) {
			$id  = $settings->default_img;
			$url = $settings->default_img_src;
		}

		return array(
			'id'  => $id,
			'url' => $url,
		);
	}

	/**
	 * @since 1.0
	 * @return array
	 */
	static public function get_attached_images() {
		global $post;

		return array_keys( get_attached_media( 'image', $post->ID ) );
	}

	/**
	 * @since 1.0
	 * @param object $settings
	 * @return string
	 */
	static public function get_terms_list( $settings ) {
		global $post;

		if ( isset( $settings->html_list ) && ( 'ul' === $settings->html_list || 'ol' === $settings->html_list ) ) {
			$separator  = $settings->html_list;
			$terms_list = self::get_the_term_list( $post->ID, $settings->taxonomy, "<$separator class='fl-{$settings->taxonomy}'><li>", '</li><li>', "</li></$separator>", $settings->linked, $settings->limit, $settings->display );
		} elseif ( isset( $settings->html_list ) && 'div' === $settings->html_list ) {
			$separator  = $settings->html_list;
			$terms_list = self::get_the_term_list( $post->ID, $settings->taxonomy, "<$separator class='fl-{$settings->taxonomy}'><span>", '</span><span>', "</span></$separator>", $settings->linked, $settings->limit, $settings->display );
		} else {
			$terms_list = self::get_the_term_list( $post->ID, $settings->taxonomy, '', $settings->separator, '', $settings->linked, $settings->limit, $settings->display );
			if ( 'no' === $settings->linked ) {
				$terms_list = strip_tags( $terms_list );
			}
		}
		/**
		 * Modify output of get_terms_list()
		 * @see fl_theme_builder_terms_list
		 * @since 1.3
		 */
		return apply_filters( 'fl_theme_builder_terms_list', $terms_list, $settings );
	}

	/**
	 * @since 1.2.3
	 */
	static public function get_the_term_list( $id, $taxonomy, $before = '', $sep = '', $after = '', $linked = 'yes', $limit = false, $display = 'name' ) {
		$terms = get_the_terms( $id, $taxonomy );

		if ( is_wp_error( $terms ) ) {
			return;
		}

		if ( empty( $terms ) ) {
			return false;
		}

		$links = array();

		if ( $limit && is_numeric( $limit ) ) {
			$terms = array_slice( $terms, 0, $limit );
		}

		$is_events_post_type = 'tribe_events' === get_post_type( $id ) && function_exists( 'tribe_events_get_url' );
		foreach ( $terms as $term ) {
			if ( $is_events_post_type ) {
				$link = tribe_events_get_url( array(
					'tag'          => $term->slug,
					'post_type'    => 'tribe_events',
					'eventDisplay' => 'default',
				) );
			} else {
				$link = get_term_link( $term, $taxonomy );
			}

			if ( is_wp_error( $link ) ) {
				return $link;
			}
			if ( 'no' !== $linked ) {
				$links[] = '<a href="' . esc_url( $link ) . '" rel="tag" class="' . esc_attr( $term->slug ) . '">' . ( 'slug' === $display ? $term->slug : $term->name ) . '</a>';
			} else {
				$links[] = '<span class="' . esc_attr( $term->slug ) . '">' . ( 'slug' === $display ? $term->slug : $term->name ) . '</span>';
			}
		}

		/**
		 * Filters the term links for a given taxonomy.
		 *
		 * The dynamic portion of the filter name, `$taxonomy`, refers
		 * to the taxonomy slug.
		 *
		 * @since 2.5.0
		 *
		 * @param string[] $links An array of term links.
		 */
		$term_links = apply_filters( "term_links-{$taxonomy}", $links ); // phpcs:ignore WordPress.NamingConventions.ValidHookName.UseUnderscores

		return $before . join( $sep, $term_links ) . $after;
	}


	/**
	 * @since 1.0
	 * @return array
	 */
	static public function get_taxonomy_options() {
		$taxonomies = get_taxonomies( array(
			'public'  => true,
			'show_ui' => true,
		), 'objects' );
		$result     = array();

		foreach ( $taxonomies as $slug => $data ) {

			if ( stristr( $slug, 'fl-builder' ) ) {
				continue;
			}

			$result[ $slug ] = $data->label;
		}

		return $result;
	}

	/**
	 * @since 1.0
	 * @param object $settings
	 * @return string
	 */
	static public function get_comments_number( $settings ) {
		$zero = isset( $settings->none_text ) ? $settings->none_text : null;
		$one  = isset( $settings->one_text ) ? $settings->one_text : null;
		$more = isset( $settings->more_text ) ? $settings->more_text : null;

		ob_start();

		if ( '1' == $settings->link || 'yes' == $settings->link ) {
			comments_popup_link( $zero, $one, $more );
		} else {
			comments_number( $zero, $one, $more );
		}

		return ob_get_clean();
	}

	/**
	 * @since 1.0
	 * @return string
	 */
	static public function get_comments_url() {
		global $post;

		return get_comments_link( $post->ID );
	}

	/**
	 * @since 1.2.4
	 * @return integer
	 */
	static public function get_author_id() {
		$author_id = get_the_author_meta( 'ID' );

		// If not in loop, try checking author ID from the original wp query.
		if ( ! $author_id ) {
			if ( is_archive() && is_author() ) {
				global $wp_the_query;

				if ( isset( $wp_the_query->queried_object_id ) && $wp_the_query->queried_object_id ) {
					$author_id = $wp_the_query->queried_object_id;
				}
			}
		}

		return $author_id;
	}

	/**
	 * @since 1.0
	 * @param object $settings
	 * @return string
	 */
	static public function get_author_name( $settings ) {
		global $post;
		$name = '';

		if ( ! isset( $post ) ) {
			$user = get_userdata( self::get_author_id() );
		} else {
			$user = get_userdata( $post->post_author );
		}

		if ( ! $user ) {
			return '';
		}

		switch ( $settings->type ) {

			case 'display':
				$name = $user->display_name;
				break;

			case 'first':
				$name = get_user_meta( $user->ID, 'first_name', true );
				break;

			case 'last':
				$name = get_user_meta( $user->ID, 'last_name', true );
				break;

			case 'firstlast':
				$first = get_user_meta( $user->ID, 'first_name', true );
				$last  = get_user_meta( $user->ID, 'last_name', true );
				$name  = $first . ' ' . $last;
				break;

			case 'lastfirst':
				$first = get_user_meta( $user->ID, 'first_name', true );
				$last  = get_user_meta( $user->ID, 'last_name', true );
				$name  = $last . ', ' . $first;
				break;

			case 'nickname':
				$name = $user->nickname;
				break;

			case 'username':
				$name = $user->user_login;
				break;
		}

		if ( $name && 'yes' == $settings->link ) {
			$settings->type = $settings->link_type;
			$name           = '<a href="' . self::get_author_url( $settings ) . '">' . $name . '</a>';
		}

		return $name;
	}

	/**
	 * @since 1.0
	 * @return string
	 */
	static public function get_author_bio() {
		return get_the_author_meta( 'description', self::get_author_id() );
	}

	/**
	 * @since 1.0
	 * @param object $settings
	 * @return string
	 */
	static public function get_author_url( $settings ) {

		$id  = self::get_author_id();
		$url = '';

		if ( 'archive' == $settings->type ) {
			$url = get_author_posts_url( $id );
		} elseif ( 'website' == $settings->type ) {
			$user = get_userdata( $id );
			$url  = $user->user_url;
		}

		return $url;
	}

	/**
	 * @since 1.0
	 * @param object $settings
	 * @return string
	 */
	static public function get_author_profile_picture( $settings ) {
		$size   = ! is_numeric( $settings->size ) ? 512 : $settings->size;
		$avatar = get_avatar( self::get_author_id(), $size );
		if ( '1' == $settings->link || 'yes' == $settings->link ) {
			$settings->type = $settings->link_type;
			$avatar         = '<a href="' . self::get_author_url( $settings ) . '">' . $avatar . '</a>';
		}

		return $avatar;
	}

	/**
	 * @since 1.0
	 * @param object $settings
	 * @return string
	 */
	static public function get_author_profile_picture_url( $settings ) {

		$author = self::get_author_id();

		// if not in loop use global $post to find author ID
		if ( ! $author ) {
			global $post;
			$author = $post->post_author;
		}
		// We get the url like this because not all custom avatar plugins filter get_avatar_url.
		$size   = ! is_numeric( $settings->size ) ? 512 : $settings->size;
		$avatar = get_avatar( $author, $size, $settings->default_img_src );

		preg_match_all( '/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $avatar, $matches, PREG_SET_ORDER );
		$url = ! empty( $matches ) && isset( $matches[0][1] ) ? $matches[0][1] : '';

		if ( ! $url && isset( $settings->default_img_src ) ) {
			$url = $settings->default_img_src;
		}

		return $url;
	}

	/**
	 * @since 1.0
	 * @param object $settings
	 * @return string
	 */
	static public function get_author_meta( $settings ) {

		if ( empty( $settings->key ) ) {
			return '';
		}

		$value = get_user_meta( self::get_author_id(), $settings->key, true );
		if ( ! $value ) {
			$value = get_the_author_meta( $settings->key, self::get_author_id() );
		}

		return $value;
	}

	/**
	 * @since 1.0
	 * @param object $settings
	 * @return string
	 */
	static public function get_custom_field( $settings ) {
		global $post;

		if ( empty( $settings->key ) ) {
			return '';
		}
		$meta = get_post_meta( $post->ID, $settings->key, true );

		// expression support
		if ( isset( $settings->value ) && '' !== $settings->value && isset( $settings->exp ) && '' !== $settings->exp ) {
			switch ( $settings->exp ) {
				case 'less':
					return ( intval( $meta ) < intval( $settings->value ) ) ? $meta : '';
					break;

				case 'lessequals':
					return ( intval( $meta ) <= intval( $settings->value ) ) ? $meta : '';
					break;

				case 'greater':
					return ( intval( $meta ) > intval( $settings->value ) ) ? $meta : '';
					break;

				case 'greaterequals':
					return ( intval( $meta ) >= intval( $settings->value ) ) ? $meta : '';
					break;

				case 'equals':
					return ( $meta === $settings->value ) ? $meta : '';
					break;

				case 'notequals':
					return ( $meta !== $settings->value ) ? $meta : '';
					break;

				default:
					break;
			}
		}

		if ( isset( $settings->value ) && '' !== $settings->value ) {
			return ( $settings->value == $meta ) ? $meta : '';
		}
		return $meta;
	}

	/**
	* @return string
	*/
	static public function get_id() {
		global $post;
		return (string) $post->ID;
	}

	/**
	* @return string
	*/
	static public function get_parent( $settings ) {
		global $post;
		$parent_id = $post->post_parent;

		if ( 0 === $parent_id ) {
			return;
		}
		$parent = get_post( $parent_id );

		if ( ! $parent ) {
			return;
		}

		if ( 'url' == $settings->display ) {
			return get_the_permalink( $parent );
		} elseif ( 'featured_image' == $settings->display ) {

			if ( isset( $settings->size ) ) {
				return get_the_post_thumbnail_url( $parent_id, $settings->size );
			} else {
				return get_the_post_thumbnail_url( $parent_id );
			}
		} elseif ( 'content' == $settings->display ) {
			return apply_filters( 'fl_theme_builder_parent_post_content', $parent->post_content );
		} elseif ( 'title' == $settings->display ) {
			return get_the_title( $parent );
		} else {
			return (string) $parent_id;
		}
	}

	/**
	* @return string
	*/
	static public function get_slug() {
		global $post;
		return $post->post_name;
	}
}
