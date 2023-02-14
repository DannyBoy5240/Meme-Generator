<?php

/**
 * Server side processing for WordPress rules.
 *
 * @since 0.1
 */
final class BB_Logic_Rules_WordPress {

	/**
	 * Sets up callbacks for conditional logic rules.
	 *
	 * @since  0.1
	 * @return void
	 */
	static public function init() {
		BB_Logic_Rules::register(
			array(
				'wordpress/archive-description'  => __CLASS__ . '::archive_description',
				'wordpress/archive-term-meta'    => __CLASS__ . '::archive_term_meta',
				'wordpress/archive-term'         => __CLASS__ . '::archive_term',
				'wordpress/archive-title'        => __CLASS__ . '::archive_title',
				'wordpress/archive'              => __CLASS__ . '::archive',
				'wordpress/author-bio'           => __CLASS__ . '::author_bio',
				'wordpress/author-login-status'  => __CLASS__ . '::author_logged_in',
				'wordpress/author-meta'          => __CLASS__ . '::author_meta',
				'wordpress/author'               => __CLASS__ . '::author',
				'wordpress/author-role'          => __CLASS__ . '::author_role',
				'wordpress/post-comments-number' => __CLASS__ . '::post_comments_number',
				'wordpress/post-comments-status' => __CLASS__ . '::post_comments_status',
				'wordpress/post-content'         => __CLASS__ . '::post_content',
				'wordpress/post-excerpt'         => __CLASS__ . '::post_excerpt',
				'wordpress/post-featured-image'  => __CLASS__ . '::post_featured_image',
				'wordpress/post-meta'            => __CLASS__ . '::post_meta',
				'wordpress/post-parent'          => __CLASS__ . '::post_parent',
				'wordpress/post-status'          => __CLASS__ . '::post_status',
				'wordpress/post-template'        => __CLASS__ . '::post_template',
				'wordpress/post-term'            => __CLASS__ . '::post_term',
				'wordpress/post-title'           => __CLASS__ . '::post_title',
				'wordpress/post-type'            => __CLASS__ . '::post_type',
				'wordpress/post'                 => __CLASS__ . '::post',
				'wordpress/user-capability'      => __CLASS__ . '::user_capability',
				'wordpress/user-bio'             => __CLASS__ . '::user_bio',
				'wordpress/user-login-status'    => __CLASS__ . '::user_login_status',
				'wordpress/user-meta'            => __CLASS__ . '::user_meta',
				'wordpress/user-role'            => __CLASS__ . '::user_role',
				'wordpress/user-registered'      => __CLASS__ . '::user_registered',
				'wordpress/user'                 => __CLASS__ . '::user',
				'wordpress/conditional-tag'      => __CLASS__ . '::conditional_tag',
				'wordpress/shortcode'            => __CLASS__ . '::shortcode',
			)
		);
	}

	/**
	 * Returns the current post if one exists.
	 *
	 * @since  0.1
	 * @return object|bool
	 */
	static public function get_post() {
		global $post;
		if ( is_object( $post ) ) {
			return $post;
		}
		return false;
	}

	/**
	 * @since 1.4
	 */
	static public function shortcode( $rule ) {
		return BB_Logic_Rules::evaluate_rule( array(
			'value'    => do_shortcode( $rule->key ),
			'operator' => $rule->operator,
			'compare'  => $rule->compare,
		) );
	}

	/**
	 * Archive description rule.
	 *
	 * @since  0.1
	 * @param object $rule
	 * @return object|bool
	 */
	static public function archive_description( $rule ) {
		return BB_Logic_Rules::evaluate_rule( array(
			'value'    => get_the_archive_description(),
			'operator' => $rule->operator,
			'compare'  => $rule->compare,
		) );
	}

	/**
	 * Archive term meta rule.
	 *
	 * @since  0.1
	 * @param object $rule
	 * @return bool
	 */
	static public function archive_term_meta( $rule ) {
		$term_id        = 0;
		$queried_object = get_queried_object();

		if ( is_object( $queried_object ) && isset( $queried_object->term_id ) ) {
			$term_id = $queried_object->term_id;
		}

		return BB_Logic_Rules::evaluate_rule( array(
			'value'    => get_term_meta( $term_id, $rule->key, true ),
			'operator' => $rule->operator,
			'compare'  => $rule->compare,
			'isset'    => metadata_exists( 'term', $term_id, $rule->key ),
		) );
	}

	/**
	 * Archive term rule.
	 *
	 * @since  0.1
	 * @param object $rule
	 * @return bool
	 */
	static public function archive_term( $rule ) {
		if ( 'category' === $rule->taxonomy ) {
			$has_term = is_category( $rule->term );
		} elseif ( 'post_tag' === $rule->taxonomy ) {
			$has_term = is_tag( $rule->term );
		} else {
			$has_term = is_tax( $rule->taxonomy, $rule->term );
		}

		return 'equals' === $rule->operator ? $has_term : ! $has_term;
	}

	/**
	 * Archive title rule.
	 *
	 * @since  0.1
	 * @param object $rule
	 * @return object|bool
	 */
	static public function archive_title( $rule ) {
		return BB_Logic_Rules::evaluate_rule( array(
			'value'    => get_the_archive_title(),
			'operator' => $rule->operator,
			'compare'  => $rule->compare,
		) );
	}

	/**
	 * Archive rule.
	 *
	 * @since  0.1
	 * @param object $rule
	 * @return object|bool
	 */
	static public function archive( $rule ) {
		$parts  = explode( '/', $rule->archive );
		$result = false;

		if ( 'general' === $parts[0] ) {
			if ( 'author' === $parts[1] ) {
				$result = is_author();
			} elseif ( 'date' === $parts[1] ) {
				$result = is_date();
			} elseif ( 'search' === $parts[1] ) {
				$result = is_search();
			}
		} elseif ( 'post' === $parts[0] ) {
			if ( 'post' === $parts[1] ) {
				$result = is_home();
			} else {
				$result = is_post_type_archive( $parts[1] );
			}
		} elseif ( 'taxonomy' === $parts[0] ) {
			if ( 'category' === $parts[1] ) {
				$result = is_category();
			} elseif ( 'post_tag' === $parts[1] ) {
				$result = is_tag();
			} else {
				$result = is_tax( $parts[1] );
			}
		}

		return 'equals' === $rule->operator ? $result : ! $result;
	}

	/**
	 * Author bio rule.
	 *
	 * @since  0.1
	 * @param object $rule
	 * @return bool
	 */
	static public function author_bio( $rule ) {
		$post = self::get_post();
		if ( $post ) {
			$bio = get_the_author_meta( 'description', $post->post_author );
			return BB_Logic_Rules::evaluate_rule( array(
				'value'    => $bio ? $bio : '',
				'operator' => $rule->operator,
				'compare'  => $rule->compare,
			) );
		}
		return false;
	}

	/**
	 * Author meta rule.
	 *
	 * @since  0.1
	 * @param object $rule
	 * @return bool
	 */
	static public function author_meta( $rule ) {
		$post = self::get_post();
		if ( $post ) {
			return BB_Logic_Rules::evaluate_rule( array(
				'value'    => get_user_meta( $post->post_author, $rule->key, true ),
				'operator' => $rule->operator,
				'compare'  => $rule->compare,
				'isset'    => metadata_exists( 'user', $post->post_author, $rule->key ),
			) );
		}
		return false;
	}

	/**
	 * Author logged in/out
	 *
	 * @since  0.1
	 * @param object $rule
	 * @return bool
	 */
	static public function author_logged_in( $rule ) {
		$post = self::get_post();
		if ( $post ) {
			$author = $post->post_author;
			return BB_Logic_Rules::evaluate_rule( array(
				'value'    => get_current_user_id() == $author ? 'logged_in' : 'logged_out',
				'operator' => $rule->operator,
				'compare'  => $rule->compare,
			) );
		}
	}

	/**
	 * Author rule.
	 *
	 * @since  0.1
	 * @param object $rule
	 * @return bool
	 */
	static public function author( $rule ) {
		$post = self::get_post();
		if ( $post ) {
			$username = get_the_author_meta( 'user_login', $post->post_author );
			return BB_Logic_Rules::evaluate_rule( array(
				'value'    => $username ? $username : '',
				'operator' => $rule->operator,
				'compare'  => $rule->compare,
			) );
		}
		return false;
	}

	/**
	 * Post comments number rule.
	 *
	 * @since  0.1
	 * @param object $rule
	 * @return bool
	 */
	static public function post_comments_number( $rule ) {
		$post = self::get_post();
		if ( $post ) {
			return BB_Logic_Rules::evaluate_rule( array(
				'value'    => get_comments_number( $post->ID ),
				'operator' => $rule->operator,
				'compare'  => $rule->compare,
			) );
		}
		return false;
	}

	/**
	 * Post comments status rule.
	 *
	 * @since  1.4
	 * @param object $rule
	 * @return bool
	 */
	static public function post_comments_status( $rule ) {
		$post = self::get_post();
		if ( $post ) {
			return BB_Logic_Rules::evaluate_rule( array(
				'value'    => comments_open( $post->ID ),
				'operator' => $rule->operator,
				'compare'  => $rule->compare,
			) );
		}
		return false;
	}

	/**
	 * Post content rule.
	 *
	 * @since  0.1
	 * @param object $rule
	 * @return bool
	 */
	static public function post_content( $rule ) {
		$post = self::get_post();
		if ( $post ) {
			return BB_Logic_Rules::evaluate_rule( array(
				'value'    => $post->post_content,
				'operator' => $rule->operator,
				'compare'  => $rule->compare,
			) );
		}
		return false;
	}

	/**
	 * Post excerpt rule.
	 *
	 * @since  0.1
	 * @param object $rule
	 * @return bool
	 */
	static public function post_excerpt( $rule ) {
		$post = self::get_post();
		if ( $post ) {
			return BB_Logic_Rules::evaluate_rule( array(
				'value'    => get_the_excerpt( $post ),
				'operator' => $rule->operator,
				'compare'  => $rule->compare,
			) );
		}
		return false;
	}

	/**
	 * Post featured image rule.
	 *
	 * @since  0.1
	 * @param object $rule
	 * @return bool
	 */
	static public function post_featured_image( $rule ) {
		$post = self::get_post();
		if ( $post ) {
			$isset = has_post_thumbnail( $post );
			return 'is_set' === $rule->operator ? $isset : ! $isset;
		}
		return false;
	}

	/**
	 * Post meta rule.
	 *
	 * @since  0.1
	 * @param object $rule
	 * @return bool
	 */
	static public function post_meta( $rule ) {
		$post = self::get_post();
		if ( $post ) {
			return BB_Logic_Rules::evaluate_rule( array(
				'value'    => get_post_meta( $post->ID, $rule->key, true ),
				'operator' => $rule->operator,
				'compare'  => $rule->compare,
				'isset'    => metadata_exists( 'post', $post->ID, $rule->key ),
			) );
		}
		return false;
	}

	/**
	 * Post parent rule.
	 *
	 * @since  0.1
	 * @param object $rule
	 * @return bool
	 */
	static public function post_parent( $rule ) {
		$post = self::get_post();
		if ( $post ) {
			return BB_Logic_Rules::evaluate_rule( array(
				'value'    => $post->post_parent,
				'operator' => $rule->operator,
				'compare'  => absint( $rule->post ),
			) );
		}
		return false;
	}

	/**
	 * Post status rule.
	 *
	 * @since  0.1
	 * @param object $rule
	 * @return bool
	 */
	static public function post_status( $rule ) {
		$post = self::get_post();
		if ( $post ) {
			return BB_Logic_Rules::evaluate_rule( array(
				'value'    => $post->post_status,
				'operator' => $rule->operator,
				'compare'  => $rule->compare,
			) );
		}
		return false;
	}

	/**
	 * Post template rule.
	 *
	 * @since  0.1
	 * @param object $rule
	 * @return bool
	 */
	static public function post_template( $rule ) {
		$post = self::get_post();

		if ( is_home() || is_404() || is_search() || is_archive() ) {
			return true;
		}

		if ( $post ) {
			return BB_Logic_Rules::evaluate_rule( array(
				'value'    => get_page_template_slug( $post->ID ),
				'operator' => $rule->operator,
				'compare'  => $rule->compare,
			) );
		}
		return false;
	}

	/**
	 * Post term rule.
	 *
	 * @since  0.1
	 * @param object $rule
	 * @return bool
	 */
	static public function post_term( $rule ) {
		$post = self::get_post();
		if ( $post ) {
			$has_term = has_term( $rule->term, $rule->taxonomy, $post );
			return 'equals' === $rule->operator ? $has_term : ! $has_term;
		}
		return false;
	}

	/**
	 * Post title rule.
	 *
	 * @since  0.1
	 * @param object $rule
	 * @return bool
	 */
	static public function post_title( $rule ) {
		$post = self::get_post();
		if ( $post ) {
			return BB_Logic_Rules::evaluate_rule( array(
				'value'    => get_the_title( $post ),
				'operator' => $rule->operator,
				'compare'  => $rule->compare,
			) );
		}
		return false;
	}

	/**
	 * Post type rule.
	 *
	 * @since  0.1
	 * @param object $rule
	 * @return bool
	 */
	static public function post_type( $rule ) {
		$post = self::get_post();
		if ( $post ) {
			return BB_Logic_Rules::evaluate_rule( array(
				'value'    => $post->post_type,
				'operator' => $rule->operator,
				'compare'  => $rule->compare,
			) );
		}
		return false;
	}

	/**
	 * Post rule.
	 *
	 * @since  0.1
	 * @param object $rule
	 * @return bool
	 */
	static public function post( $rule ) {
		$post = self::get_post();

		if ( $post ) {
			return BB_Logic_Rules::evaluate_rule( array(
				'value'    => $post->ID,
				'operator' => $rule->operator,
				'compare'  => absint( $rule->post ),
			) );
		}

		if ( 'does_not_equal' === $rule->operator ) {
			return true;
		}

		return false;
	}

	/**
	 * User capability rule.
	 *
	 * @since  0.1
	 * @param object $rule
	 * @return bool
	 */
	static public function user_capability( $rule ) {
		$user    = wp_get_current_user();
		$has_cap = current_user_can( $rule->compare );
		return BB_Logic_Rules::evaluate_rule( array(
			'value'    => $has_cap ? $rule->compare : '',
			'operator' => $rule->operator,
			'compare'  => $rule->compare,
		) );
	}

	/**
	 * User bio rule.
	 *
	 * @since  0.1
	 * @param object $rule
	 * @return bool
	 */
	static public function user_bio( $rule ) {
		$user = wp_get_current_user();
		$bio  = get_user_meta( $user->ID, 'description', true );
		return BB_Logic_Rules::evaluate_rule( array(
			'value'    => $bio ? $bio : '',
			'operator' => $rule->operator,
			'compare'  => $rule->compare,
		) );
	}

	/**
	 * User login status rule.
	 *
	 * @since  0.1
	 * @param object $rule
	 * @return bool
	 */
	static public function user_login_status( $rule ) {
		return BB_Logic_Rules::evaluate_rule( array(
			'value'    => is_user_logged_in() ? 'logged_in' : 'logged_out',
			'operator' => $rule->operator,
			'compare'  => $rule->compare,
		) );
	}

	/**
	 * User meta rule.
	 *
	 * @since  0.1
	 * @param object $rule
	 * @return bool
	 */
	static public function user_meta( $rule ) {
		$user = wp_get_current_user();
		$meta = get_user_meta( $user->ID, $rule->key, true );
		return BB_Logic_Rules::evaluate_rule( array(
			'value'    => $meta ? $meta : '',
			'operator' => $rule->operator,
			'compare'  => $rule->compare,
			'isset'    => metadata_exists( 'user', $user->ID, $rule->key ),
		) );
	}

	/**
	 * User role rule.
	 *
	 * @since  0.1
	 * @param object $rule
	 * @return bool
	 */
	static public function user_role( $rule ) {
		$user  = wp_get_current_user();
		$value = in_array( $rule->compare, (array) $user->roles ) ? $rule->compare : '';
		return BB_Logic_Rules::evaluate_rule( array(
			'value'    => $value,
			'operator' => $rule->operator,
			'compare'  => $rule->compare,
		) );
	}

	/**
	 * Author role rule.
	 *
	 * @since  0.1
	 * @param object $rule
	 * @return bool
	 */
	static public function author_role( $rule ) {
		$post = self::get_post();
		if ( $post ) {
			$author_id = $post->post_author;
			$user      = get_user_by( 'ID', $author_id );
			$value     = in_array( $rule->compare, (array) $user->roles ) ? $rule->compare : '';
			return BB_Logic_Rules::evaluate_rule( array(
				'value'    => $value,
				'operator' => $rule->operator,
				'compare'  => $rule->compare,
			) );
		}
	}

	/**
	 * User signup date rule.
	 *
	 * @since  0.1
	 * @param object $rule
	 * @return bool
	 */
	static public function user_registered( $rule ) {
		$user = wp_get_current_user();
		return BB_Logic_Rules::evaluate_date_rule(
			$rule,
			$user->user_registered
		);
	}

	/**
	 * User rule.
	 *
	 * @since  0.1
	 * @param object $rule
	 * @return bool
	 */
	static public function user( $rule ) {
		$user = wp_get_current_user();
		return BB_Logic_Rules::evaluate_rule( array(
			'value'    => $user->user_login ? $user->user_login : '',
			'operator' => $rule->operator,
			'compare'  => $rule->compare,
		) );
	}

	/**
	 * Conditional Tag rule.
	 *
	 * @since  1.0
	 * @param object $rule
	 * @return bool
	 */
	static public function conditional_tag( $rule ) {
		$value = '';

		if ( 'is_404' === $rule->compare ) {
			$value = is_404();
		} elseif ( 'is_home' === $rule->compare ) {
			$value = is_home();
		} elseif ( 'is_front_page' === $rule->compare ) {
			$value = is_front_page();
		} elseif ( 'is_tax' === $rule->compare ) {
			$value = is_tax();
		} elseif ( 'is_search' === $rule->compare ) {
			$value = is_search();
		}

		return BB_Logic_Rules::evaluate_rule( array(
			'value'    => $value,
			'operator' => $rule->operator,
			'compare'  => true,
		) );
	}
}

BB_Logic_Rules_WordPress::init();
