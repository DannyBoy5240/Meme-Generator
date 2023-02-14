<?php
if ( ! class_exists( 'FLTaxonomyTermsWalker' ) ) {
	/**
	 * Walks through each taxonomy term to build JSON data.
	 * Used in FLThemeBuilderRulesLocation::get_taxonomy_terms() below.
	 *
	 * @since 1.4
	 */
	class FLTaxonomyTermsWalker extends Walker_Category {
		/**
		 * Starts the element output.
		 *
		 * @since 1.4
		 *
		 * @param string  $output (passed by reference) Used to create a JSON element out of the $item (WP Term) object.
		 * @param WP_Term $item  WP Term data object.
		 * @param int     $depth  Depth of category in reference to parents.
		 * @param array   $args   An array of arguments. Unused here. See wp_list_categories().
		 * @param int     $id    ID of the current category. Unused here.
		 */
		function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
			$mdash   = str_repeat( '&mdash; ', $depth );
			$output .= '{'
				. '"id": ' . $item->term_id . ','
				. '"name": "' . wp_slash( esc_attr( $item->name ) ) . '",'
				. '"label": "' . $mdash . wp_slash( esc_attr( $item->name ) ) . '",'
				. '"depth": ' . $depth
				. '},';
		}
	}
}

if ( ! class_exists( 'FLPageWalker' ) ) {
	/**
	 * Walks through each page (or hierarchical post type) to build JSON data.
	 * Used in FLThemeBuilderRulesLocation::get_post_type_posts() below.
	 *
	 * @since 1.4
	 */
	class FLPageWalker extends Walker_Page {
		/**
		 * Starts the element output.
		 *
		 * @param string  $output       (passed by reference) Used to create a JSON element out of the $page (WP_Post) object.
		 * @param WP_Post $page         Page data object.
		 * @param int     $depth        Optional. Depth of page. Used for padding. Default 0.
		 * @param array   $args         Optional. Array of arguments. Default empty array.
		 * @param int     $current_page Optional. Page ID. Default 0.
		 */
		function start_el( &$output, $page, $depth = 0, $args = array(), $current_page = 0 ) {
			$mdash   = str_repeat( '&mdash; ', $depth );
			$output .= '{'
				. '"id": ' . $page->ID . ','
				. '"name": "' . wp_slash( esc_attr( $page->post_title ) ) . '",'
				. '"label": "' . $mdash . wp_slash( esc_attr( $page->post_title ) ) . '",'
				. '"depth": ' . $depth
				. '},';
		}
		public function end_el( &$output, $page, $depth = 0, $args = array() ) {
			$output .= '';
		}
		function start_lvl( &$output, $depth = 0, $args = array() ) {
			$output .= '';
		}
		function end_lvl( &$output, $depth = 0, $args = array() ) {
			$output .= '';
		}
	}
}

/**
 * Handles location rule logic for the theme builder.
 *
 * @since 1.0
 */
final class FLThemeBuilderRulesLocation {

	/**
	 * Cached location for the current page.
	 *
	 * @since 1.0
	 * @access private
	 * @var array $current_page_location
	 */
	static private $current_page_location = null;

	/**
	 * Cached array of post ids that have their
	 * location set to the current page.
	 *
	 * @since 1.0
	 * @access private
	 * @var array $current_page_posts
	 */
	static private $current_page_posts = null;

	/**
	 * Cached data for all possible locations.
	 *
	 * @since 1.0
	 * @access private
	 * @var array $locations
	 */
	static private $locations = null;

	/**
	 * An array of args that will be used for preview queries.
	 *
	 * @since 1.0
	 * @access private
	 * @var array $preview_args
	 */
	static private $preview_args = null;

	/**
	 * An instance of WP_Query used for previewing archive and
	 * post data in theme layouts.
	 *
	 * @since 1.0
	 * @access private
	 * @var object $preview_query
	 */
	static private $preview_query = null;

	/**
	 * Cache expensive db queries
	 *
	 * @since 1.0.4
	 * @access private
	 * @var array $query_cache
	 */
	static private $query_cache = array();

	/**
	 * Initializes hooks.
	 *
	 * @since 1.0
	 * @return void
	 */
	static public function init() {
		add_action( 'save_post', __CLASS__ . '::admin_edit_save' );
		add_action( 'wp_ajax_fl_theme_builder_get_location_terms', __CLASS__ . '::ajax_get_terms' );
		add_action( 'wp_ajax_fl_theme_builder_get_location_parent_terms', __CLASS__ . '::ajax_get_terms' );
		add_action( 'wp_ajax_fl_theme_builder_get_location_posts', __CLASS__ . '::ajax_get_posts' );
		add_action( 'wp', __CLASS__ . '::init_preview_query', 1 );
		add_action( 'fl_builder_after_ui_bar_title', __CLASS__ . '::render_ui_preview_selector' );

		FLBuilderAJAX::add_action( 'update_preview_location', __CLASS__ . '::ajax_update_preview_location' );
		FLBuilderAJAX::add_action( 'get_preview_posts', __CLASS__ . '::ajax_get_preview_posts' );
		FLBuilderAJAX::add_action( 'get_preview_terms', __CLASS__ . '::ajax_get_preview_terms' );
	}

	/**
	 * Returns the location for the current page.
	 *
	 * @since 1.0
	 * @return array
	 */
	static public function get_current_page_location() {
		global $wp_query;
		global $post;

		if ( ! did_action( 'wp' ) && strpos( $_SERVER['REQUEST_URI'], 'legacy-widget-preview' ) === false ) {
			_doing_it_wrong( __CLASS__ . '::get_current_page_location', __( 'Must be called on or after the wp action.', 'bb-theme-builder' ), '1.0' );
		}

		if ( null != self::$current_page_location ) {
			return self::$current_page_location;
		}

		$location       = null;
		$object         = null;
		$queried_object = get_queried_object();

		// Get the location string.
		if ( is_home() ) {
			$location = 'archive:post';
		} elseif ( is_author() ) {
			$location = 'general:author';
		} elseif ( is_date() ) {
			$location = 'general:date';
		} elseif ( is_search() ) {
			$location = 'general:search';
		} elseif ( is_404() ) {
			$location = 'general:404';
		} elseif ( is_category() ) {

			$location = 'taxonomy:category';

			if ( is_object( $queried_object ) ) {
				$object = $location . ':' . $queried_object->term_id;
			}
		} elseif ( is_tag() ) {

			$location = 'taxonomy:post_tag';

			if ( is_object( $queried_object ) ) {
				$object = $location . ':' . $queried_object->term_id;
			}
		} elseif ( is_tax() ) {

			$location = 'taxonomy:' . get_query_var( 'taxonomy' );

			if ( is_object( $queried_object ) ) {
				$location = 'taxonomy:' . $queried_object->taxonomy;
				$object   = $location . ':' . $queried_object->term_id;
			}
		} elseif ( is_post_type_archive() ) {
			$location = 'archive:' . $wp_query->get( 'post_type' );
		} elseif ( is_singular() ) {

			$location = 'post:' . $post->post_type;

			if ( is_object( $queried_object ) ) {
				$object = $location . ':' . $queried_object->ID;
			}
		}

		self::$current_page_location = array(
			'location' => $location,
			'object'   => $object,
		);

		return self::$current_page_location;
	}

	/**
	 * Returns an array of post ids that have their
	 * location set to the current page.
	 *
	 * @since 1.0
	 * @access private
	 * @return array
	 */
	static public function get_current_page_posts() {
		global $wpdb;

		if ( self::$current_page_posts ) {
			return self::$current_page_posts;
		} else {
			self::$current_page_posts = array();
		}

		$data       = self::get_current_page_location();
		$location   = esc_sql( $data['location'] );
		$meta_query = "pm.meta_value LIKE '%\"{$location}\"%' OR pm.meta_value LIKE '%\"general:site\"%'";
		$query      = "SELECT p.ID, pm.meta_value FROM {$wpdb->postmeta} as pm
					   INNER JOIN {$wpdb->posts} as p ON pm.post_id = p.ID
					   WHERE pm.meta_key = '_fl_theme_builder_locations'
					   AND p.post_type = 'fl-theme-layout'
					   AND p.post_status = 'publish'";

		if ( $data['object'] ) {
			$object      = esc_sql( $data['object'] );
			$meta_query .= " OR pm.meta_value LIKE '%\"{$object}\"%'";
		}
		if ( is_archive() || is_home() || is_search() ) {
			$meta_query .= " OR pm.meta_value LIKE '%\"general:archive\"%'";
		}
		if ( is_singular() ) {
			$meta_query .= " OR pm.meta_value RLIKE '\"{$location}:post:.*\"'";
			$meta_query .= " OR pm.meta_value RLIKE '\"{$location}:ancestor:.*\"'";
			$meta_query .= " OR pm.meta_value RLIKE '\"{$location}:taxonomy:.*\"'";
			$meta_query .= " OR pm.meta_value RLIKE '\"{$location}:tax_parent:.*\"'";
			$meta_query .= " OR pm.meta_value LIKE '%\"general:single\"%'";
		}

		// cache query
		$query = $query . ' AND (' . $meta_query . ')';
		$hash  = md5( $query );
		if ( ! isset( self::$query_cache[ $hash ] ) ) {
			// @codingStandardsIgnoreStart
			self::$query_cache[$hash] = $wpdb->get_results( $query );
			// @codingStandardsIgnoreEnd
		}

		foreach ( self::$query_cache[ $hash ] as $post ) {
			self::$current_page_posts[ $post->ID ] = array(
				'id'        => $post->ID,
				'locations' => unserialize( $post->meta_value ),
			);
		}

		self::exclude_current_page_posts();
		return self::$current_page_posts;
	}

	/**
	 * Excludes posts from the current page if they have
	 * any matching exclusion rules.
	 *
	 * @since 1.0
	 * @access private
	 */
	static private function exclude_current_page_posts() {

		$post_id  = get_the_ID();
		$location = self::get_current_page_location();

		foreach ( self::$current_page_posts as $i => $post ) {

			$exclusions = self::get_saved_exclusions( $post['id'] );
			$exclude    = false;

			if ( empty( $exclusions ) ) {
				continue;
			} elseif ( 'general:404' == $location['location'] && in_array( 'general:404', $exclusions ) ) {
				$exclude = '404' != get_post_meta( $post['id'], '_fl_theme_layout_type', true );
			} elseif ( $location['object'] && in_array( $location['object'], $exclusions ) ) {
				$exclude = true;
			} elseif ( in_array( $location['location'], $exclusions ) ) {
				$exclude = true;
			} else {
				foreach ( $exclusions as $exclusion ) {
					if ( is_archive() || is_home() ) {
						if ( 'general:archive' == $exclusion ) {
							$exclude = true;
						}
					} elseif ( is_singular() ) {
						if ( 'general:single' == $exclusion ) {
							$exclude = true;
						} elseif ( strstr( $exclusion, ':taxonomy:' ) ) {
							$parts = explode( ':', $exclusion );
							if ( 4 === count( $parts ) && has_term( '', $parts[3] ) || 5 === count( $parts ) && has_term( $parts[4], $parts[3] ) ) {
								$exclude = true;
							}
						} elseif ( stristr( $exclusion, ':post:' ) ) {
							$parts = explode( ':', $exclusion );
							if ( 5 === count( $parts ) && wp_get_post_parent_id( $post_id ) == $parts[4] ) {
								$exclude = true;
							}
						} elseif ( stristr( $exclusion, ':ancestor:' ) ) {
							$parts = explode( ':', $exclusion );
							if ( 5 === count( $parts ) ) {
								$ancestors = get_post_ancestors( $post_id );
								if ( is_array( $ancestors ) && in_array( $parts[4], $ancestors ) ) {
									$exclude = true;
								}
							}
						}
					}
				}
			}

			if ( $exclude ) {
				unset( self::$current_page_posts[ $i ] );
			}
		}
	}

	/**
	 * Returns the posts from a posts array based
	 * on the current page location.
	 *
	 * @since 1.0
	 * @param array $array
	 * @param string $type
	 * @return array
	 */
	static public function get_posts_from_array( $array, $type ) {
		$location = self::get_current_page_location();
		$post_id  = get_the_ID();
		$posts    = array();
		$is_part  = 'part' == $type;

		if ( count( $array ) > 0 ) {

			// Check for a location object layout.
			if ( $location['object'] ) {
				foreach ( $array as $post ) {
					if ( in_array( $location['object'], $post['locations'] ) ) {
						$posts[] = $post;
					}
				}
			}

			// Check for a singular layout by parent or ancestor.
			if ( ( empty( $posts ) || $is_part ) && is_singular() ) {
				foreach ( $array as $post ) {
					foreach ( $post['locations'] as $post_location ) {
						if ( stristr( $post_location, ':post:' ) ) {
							$parts = explode( ':', $post_location );
							if ( 5 === count( $parts ) && wp_get_post_parent_id( $post_id ) == $parts[4] && get_post_type( wp_get_post_parent_id( $post_id ) ) == $parts[3] ) {
								$posts[] = $post;
							}
						} elseif ( stristr( $post_location, ':ancestor:' ) ) {
							$parts = explode( ':', $post_location );
							if ( 5 === count( $parts ) ) {
								$ancestors = get_post_ancestors( $post_id );
								if ( is_array( $ancestors ) && in_array( $parts[4], $ancestors ) ) {
									$posts[] = $post;
								}
							}
						}
					}
				}
			}

			// Check for a singular layout by taxonomy.
			if ( ( empty( $posts ) || $is_part ) && is_singular() ) {
				foreach ( $array as $post ) {
					foreach ( $post['locations'] as $post_location ) {
						if ( stristr( $post_location, ':taxonomy:' ) ) {
							$parts = explode( ':', $post_location );
							if ( 4 === count( $parts ) && has_term( '', $parts[3] ) ) {
								$posts[] = $post;
							} elseif ( 5 === count( $parts ) && has_term( $parts[4], $parts[3] ) ) {
								$posts[] = $post;
							}
						}
					}
				}
			}

			// Check for a singular layout by parent taxonomy.
			if ( ( empty( $posts ) || $is_part ) && is_singular() ) {

				foreach ( $array as $post ) {
					foreach ( $post['locations'] as $post_location ) {
						if ( stristr( $post_location, ':tax_parent:' ) ) {
							$parts = explode( ':', $post_location );
							$terms = get_the_terms( $post_id, $parts[3] );
							if ( $terms ) {
								$parent_terms = array();
								foreach ( $terms as $term ) {
									$parent_terms[] = $term->parent;
								}
								if ( 5 === count( $parts ) && in_array( $parts[4], $parent_terms ) ) {
									$posts[] = $post;
								}
							}
						}
					}
				}
			}

			// Check for a location layout such as all pages.
			if ( empty( $posts ) || $is_part ) {
				foreach ( $array as $post ) {
					if ( in_array( $location['location'], $post['locations'] ) ) {
						$posts[] = $post;
					}
				}
			}

			// Check for an all archives layout.
			if ( ( empty( $posts ) || $is_part ) && ( is_archive() || is_home() || is_search() ) ) {
				foreach ( $array as $post ) {
					if ( in_array( 'general:archive', $post['locations'] ) ) {
						$posts[] = $post;
					}
				}
			}

			// Check for an all singular layout.
			if ( ( empty( $posts ) || $is_part ) && is_singular() ) {
				foreach ( $array as $post ) {
					if ( in_array( 'general:single', $post['locations'] ) ) {
						$posts[] = $post;
					}
				}
			}

			// Finally, check for a site wide layout.
			if ( empty( $posts ) || $is_part ) {
				foreach ( $array as $post ) {
					if ( in_array( 'general:site', $post['locations'] ) ) {
						$posts[] = $post;
					}
				}
			}
		}

		// make sure two of same type and location are not being edited.
		if ( 'post:fl-theme-layout' === $location['location'] && isset( $_GET['builder'] ) ) {
			$id = str_replace( $location['location'] . ':', '', $location['object'] );
			if ( is_numeric( $id ) && count( $posts ) > 1 && $posts[0]['id'] !== $id ) {
				// loop through posts and move to top if not.
				foreach ( $posts as $k => $post ) {
					if ( $post['id'] === $id ) {
						unset( $posts[ $k ] );
						array_unshift( $posts, $post );
					}
				}
			}
		}

		// if we are editing the header or footer there should be just one location post
		if ( isset( $posts[0] ) && count( $posts ) > 1 && isset( $_GET['builder'] ) ) {
			if ( 'header' === $posts[0]['type'] || 'footer' === $posts[0]['type'] ) {
				$posts = array_slice( $posts, 0, 1 );
			}
		}
		return $posts;
	}

	/**
	 * Returns an array of all of the saved locations
	 * for a post type.
	 *
	 * @since 1.0
	 * @param string $post_type
	 * @return array
	 */
	static public function get_all_saved( $post_type = null ) {
		global $wpdb;
		global $post;

		$locations = array();
		$post_type = $post_type ? $post_type : $post->post_type;

		$results = $wpdb->get_results( $wpdb->prepare(
			"SELECT * FROM {$wpdb->postmeta} as pm
			INNER JOIN {$wpdb->posts} as p ON pm.post_id = p.ID
			WHERE pm.meta_key = '_fl_theme_builder_locations'
			AND p.post_type = %s",
		$post_type ) );

		foreach ( $results as $row ) {

			$row_locations = unserialize( $row->meta_value );

			foreach ( $row_locations as $row_location ) {

				$layout_type = get_post_meta( $row->ID, '_fl_theme_layout_type', true );

				if ( ! isset( $locations[ $layout_type ] ) ) {
					$locations[ $layout_type ] = array();
				}
				if ( ! isset( $locations[ $layout_type ][ $row_location ] ) ) {
					$locations[ $layout_type ][ $row_location ] = array();
				}

				$locations[ $layout_type ][ $row_location ][] = array(
					'id'    => $row->ID,
					'title' => $row->post_title,
				);
			}
		}

		return $locations;
	}

	/**
	 * Returns the location data for a post.
	 *
	 * @since 1.0
	 * @param int $post_id
	 * @param bool $sorted
	 * @return array
	 */
	static public function get_saved( $post_id, $sorted = false ) {
		$saved = get_post_meta( $post_id, '_fl_theme_builder_locations', true );
		$saved = ! $saved ? array() : $saved;
		$saved = ! $sorted ? $saved : self::sort_saved( $saved );
		$saved = self::clean_saved_locations( $saved );

		return $saved;
	}

	/**
	 * Sorts saved location data by type.
	 *
	 * @since 1.0
	 * @param array $saved
	 * @return array
	 */
	static public function sort_saved( $saved ) {
		$all    = self::get_all();
		$sorted = array();

		if ( ! empty( $saved ) ) {
			foreach ( $all['by_post_type'] as $data ) {
				foreach ( $data['locations'] as $location ) {

					$location_string = $location['type'] . ':' . $location['id'];

					if ( in_array( $location_string, $saved ) && ! in_array( $location_string, $sorted ) ) {
						$sorted[] = $location_string;
					}

					$matches = preg_grep( "/$location_string:[0-9]+/", $saved );

					if ( ! empty( $matches ) ) {
						foreach ( $matches as $match ) {
							if ( ! in_array( $match, $sorted ) ) {
								$sorted[] = $match;
							}
						}
					}
				}
			}
		}

		return $sorted;
	}

	/**
	 * Returns alphabetically ordered location data for a post.
	 *
	 * @since 1.0
	 * @param int $post_id
	 * @return array
	 */
	static public function get_ordered_saved( $post_id ) {
		$saved_locations = self::get_saved( $post_id );
		$ordered         = array();

		foreach ( $saved_locations as $saved_location ) {

			$label = self::get_saved_label( $saved_location );

			if ( $label ) {
				$ordered[ $label ] = $saved_location;
			}
		}

		ksort( $ordered );

		return $ordered;
	}

	/**
	 * Returns the label for a saved location.
	 *
	 * @since 1.0
	 * @param string $saved_location
	 * @param bool   $objects_only
	 * @return string|bool
	 */
	static public function get_saved_label( $saved_location, $objects_only = false ) {
		$locations      = self::get_all();
		$saved_location = explode( ':', $saved_location );

		if ( count( $saved_location ) >= 4 ) {
			$location     = 'post';
			$sub_location = $saved_location[2];
			$object_type  = $saved_location[1] . ':' . $saved_location[2] . ':' . $saved_location[3];
			$object_id    = isset( $saved_location[4] ) ? $saved_location[4] : null;
		} else {
			$location     = $saved_location[0];
			$sub_location = null;
			$object_type  = $saved_location[1];
			$object_id    = isset( $saved_location[2] ) ? $saved_location[2] : null;
		}

		if ( ! isset( $locations['by_template_type'][ $location ][ $object_type ] ) ) {
			return false;
		}

		$label = $locations['by_template_type'][ $location ][ $object_type ]['label'];

		if ( ( 'taxonomy' == $location || 'taxonomy' == $sub_location ) && $object_id ) {

			$term = get_term( $object_id );

			if ( ! is_object( $term ) || is_wp_error( $term ) ) {
				return false;
			}

			if ( ! $objects_only ) {
				$label .= ': ' . $term->name;
			} else {
				$label = $term->name;
			}
		} elseif ( ( 'post' == $location || 'post' == $sub_location ) && $object_id ) {

			$post = get_post( $object_id );

			if ( ! is_object( $post ) ) {
				return false;
			}

			if ( ! $objects_only ) {
				$label .= ': ' . $post->post_title;
			} else {
				$label = $post->post_title;
			}
		}

		return $label;
	}

	/**
	 * Updates the location data for a post.
	 *
	 * @since 1.0
	 * @param int   $post_id
	 * @param array $locations
	 * @return void
	 */
	static public function update_saved( $post_id, $locations ) {
		return update_post_meta( $post_id, '_fl_theme_builder_locations', $locations );
	}

	/**
	 * Returns the location exclusion data for a post.
	 *
	 * @since 1.0
	 * @param int $post_id
	 * @param bool $sorted
	 * @return array
	 */
	static public function get_saved_exclusions( $post_id, $sorted = false ) {
		$saved = get_post_meta( $post_id, '_fl_theme_builder_exclusions', true );
		$saved = ! $saved ? array() : $saved;
		$saved = ! $sorted ? $saved : self::sort_saved( $saved );
		$saved = self::clean_saved_locations( $saved );

		return $saved;
	}

	/**
	 * Clean the location data and remove if no longer exists from database.
	 *
	 * @since 1.2.1
	 * @param array $locations
	 * @return array
	 */
	static public function clean_saved_locations( $locations ) {
		$cleaned_locations = array();

		foreach ( $locations as $data ) {
			$location = explode( ':', $data );

			// Check for specific location by post ID or term ID.
			if ( 0 === (int) end( $location ) ) {
				$cleaned_locations[] = $data;
				continue;
			}

			if ( count( $location ) >= 4 ) {
				$location[0] = $location[2];
				$location[1] = $location[3];
				$location[2] = (int) $location[4];
			}

			if ( 'taxonomy' == $location[0] || 'tax_parent' == $location[0] ) {
				$id          = is_numeric( $location[2] ) ? intval( $location[2] ) : $location[2];
				$term_exists = term_exists( $id, $location[1] );
				if ( 0 === $term_exists || null === $term_exists ) {
					continue;
				}
			} elseif ( isset( $location[2] ) ) {
				$post_status = get_post_status( $location[2] );
				if ( false === $post_status || 'trash' === $post_status ) {
					continue;
				}
			}

			$cleaned_locations[] = $data;
		}

		return $cleaned_locations;
	}

	/**
	 * Updates the location exclusion data for a post.
	 *
	 * @since 1.0
	 * @param int   $post_id
	 * @param array $exclusions
	 * @return void
	 */
	static public function update_saved_exclusions( $post_id, $exclusions ) {
		return update_post_meta( $post_id, '_fl_theme_builder_exclusions', $exclusions );
	}

	/**
	 * Returns all possible locations sorted by
	 * post type and template type.
	 *
	 * @since 1.0
	 * @return array
	 */
	static public function get_all() {
		// Return cached data?
		if ( self::$locations ) {
			return self::$locations;
		}

		// Sorted by post type.
		$by_post_type = array(
			'general' => array(
				'label'     => __( 'General', 'bb-theme-builder' ),
				'locations' => array(
					'site'    => array(
						'id'    => 'site',
						'label' => esc_html__( 'Entire Site', 'bb-theme-builder' ),
						'type'  => 'general',
					),
					'single'  => array(
						'id'    => 'single',
						'label' => esc_html__( 'All Singular', 'bb-theme-builder' ),
						'type'  => 'general',
					),
					'archive' => array(
						'id'    => 'archive',
						'label' => esc_html__( 'All Archives', 'bb-theme-builder' ),
						'type'  => 'general',
					),
					'author'  => array(
						'id'    => 'author',
						'label' => esc_html__( 'Author Archives', 'bb-theme-builder' ),
						'type'  => 'general',
					),
					'date'    => array(
						'id'    => 'date',
						'label' => esc_html__( 'Date Archives', 'bb-theme-builder' ),
						'type'  => 'general',
					),
					'search'  => array(
						'id'    => 'search',
						'label' => esc_html__( 'Search Results', 'bb-theme-builder' ),
						'type'  => 'general',
					),
					'404'     => array(
						'id'    => '404',
						'label' => esc_html__( '404 Page', 'bb-theme-builder' ),
						'type'  => 'general',
					),
				),
			),
		);

		// Sorted by location type.
		$by_template_type = array(
			'general'  => $by_post_type['general']['locations'],
			'post'     => array(),
			'archive'  => array(),
			'taxonomy' => array(),
		);

		// Add the post types.
		$post_types = get_post_types( array(
			'public' => true,
		), 'objects' );

		foreach ( $post_types as $post_type_slug => $post_type ) {

			if ( in_array( $post_type_slug, array( 'fl-builder-template', 'fl-theme-layout' ) ) ) {
				continue;
			}

			$post_type_object = get_post_type_object( $post_type_slug );
			$counts           = wp_count_posts( $post_type_slug );
			$count            = $counts->publish + $counts->future + $counts->draft + $counts->pending + $counts->private;

			// Add the post type.
			$by_template_type['post'][ $post_type_slug ] = array(
				'id'    => $post_type_slug,
				'label' => esc_html( $post_type->labels->singular_name ),
				'type'  => 'post',
				'count' => $count,
			);

			$by_post_type[ $post_type_slug ] = array(
				'label'     => esc_html( $post_type->labels->name ),
				'locations' => array(
					$post_type_slug => $by_template_type['post'][ $post_type_slug ],
				),
			);

			// Add the parent and ancestor option for hierarchical post types.
			if ( $post_type_object->hierarchical ) {
				$by_template_type['post'][ $post_type_slug . ':post:' . $post_type_slug ]                     =
				$by_post_type[ $post_type_slug ]['locations'][ $post_type_slug . ':post:' . $post_type_slug ] = array( // @codingStandardsIgnoreLine
					'id'    => $post_type_slug . ':post:' . $post_type_slug,
					/* translators: %s: singular post type name */
					'label' => sprintf( esc_html_x( '%s Parent', '%s is a singular post type name', 'bb-theme-builder' ), $post_type->labels->singular_name ),
					'type'  => 'post',
					'count' => $count,
				);

				$by_template_type['post'][ $post_type_slug . ':ancestor:' . $post_type_slug ]                     =
				$by_post_type[ $post_type_slug ]['locations'][ $post_type_slug . ':ancestor:' . $post_type_slug ] = array( // @codingStandardsIgnoreLine
					'id'    => $post_type_slug . ':ancestor:' . $post_type_slug,
					/* translators: %s: singular post type name */
					'label' => sprintf( esc_html_x( '%s Ancestor', '%s is a singular post type name', 'bb-theme-builder' ), $post_type->labels->singular_name ),
					'type'  => 'post',
					'count' => $count,
				);
			}

			// Add the post type archive.
			$by_post_type[ $post_type_slug . '_archive' ] = array(
				/* translators: %s: singular post type name */
				'label'     => sprintf( esc_html_x( '%s Archives', '%s is a singular post type name', 'bb-theme-builder' ), $post_type->labels->singular_name ),
				'locations' => array(),
			);

			if ( 'post' == $post_type_slug || ! empty( $post_type_object->has_archive ) ) {

				$by_template_type['archive'][ $post_type_slug ] = array(
					'id'    => $post_type_slug,
					/* translators: %s: singular post type name */
					'label' => sprintf( esc_html_x( '%s Archive', '%s is a singular post type name', 'bb-theme-builder' ), $post_type->labels->singular_name ),
					'type'  => 'archive',
				);

				$by_post_type[ $post_type_slug . '_archive' ]['locations'][ $post_type_slug . '_archive' ] = $by_template_type['archive'][ $post_type_slug ];
			}

			// Add the taxonomies for the post type.
			$taxonomies = get_object_taxonomies( $post_type_slug, 'objects' );

			foreach ( $taxonomies as $taxonomy_slug => $taxonomy ) {

				$public = $taxonomy->public && $taxonomy->show_ui;

				if ( 'post_format' == $taxonomy_slug ) {
					continue;
				} elseif ( ! apply_filters( 'fl_theme_builder_show_taxonomy', $public, $taxonomy ) ) {
					continue;
				}

				$label = esc_html( str_replace( array(
					$post_type->labels->name,
					$post_type->labels->singular_name,
				), '', $taxonomy->labels->singular_name ) );

				$by_template_type['taxonomy'][ $taxonomy_slug ]                              =
				$by_post_type[ $post_type_slug . '_archive' ]['locations'][ $taxonomy_slug ] = array( // @codingStandardsIgnoreLine
					'id'    => $taxonomy_slug,
					/* translators: 1: post type label, 2: taxonomy label */
					'label' => sprintf( esc_html_x( '%1$s %2$s Archive', '%1$s is post type label. %2$s is taxonomy label.', 'bb-theme-builder' ), $post_type->labels->singular_name, $label ),
					'type'  => 'taxonomy',
					'count' => wp_count_terms( $taxonomy_slug ),
				);

				$by_template_type['post'][ $post_type_slug . ':taxonomy:' . $taxonomy_slug ]                     =
				$by_post_type[ $post_type_slug ]['locations'][ $post_type_slug . ':taxonomy:' . $taxonomy_slug ] = array( // @codingStandardsIgnoreLine
					'id'    => $post_type_slug . ':taxonomy:' . $taxonomy_slug,
					'label' => esc_html( $post_type->labels->singular_name . ' ' . $label ),
					'type'  => 'post',
					'count' => wp_count_terms( $taxonomy_slug ),
				);

				if ( is_taxonomy_hierarchical( $taxonomy_slug ) ) {
					$by_template_type['post'][ $post_type_slug . ':tax_parent:' . $taxonomy_slug ]                     =
					$by_post_type[ $post_type_slug ]['locations'][ $post_type_slug . ':tax_parent:' . $taxonomy_slug ] = array( // @codingStandardsIgnoreLine
						'id'    => $post_type_slug . ':tax_parent:' . $taxonomy_slug,
						/* translators: 1: post type label, 2: taxonomy label */
						'label' => sprintf( esc_html_x( '%1$s %2$s Parent', '%1$s is post type label. %2$s is taxonomy label.', 'bb-theme-builder' ), $post_type->labels->singular_name, $label ),
						'type'  => 'post',
						'count' => wp_count_terms( $taxonomy_slug ),
					);
				}
			}
		}

		// Cache the locations.
		self::$locations = array(
			'by_template_type' => $by_template_type,
			'by_post_type'     => $by_post_type,
		);

		return self::$locations;
	}

	/**
	 * Renders the meta box settings for location rules.
	 *
	 * @since 1.0
	 * @return void
	 */
	static public function render_admin_edit_settings() {
		global $post;

		$locations = self::get_all();
		$post_type = get_post_type_object( $post->post_type );

		include FL_THEME_BUILDER_DIR . 'includes/admin-edit-location-rules.php';
	}

	/**
	 * Returns the location config for the admin edit page.
	 *
	 * @since 1.0
	 * @return array
	 */
	static public function get_admin_edit_config() {
		global $post;

		$config = array(
			'saved'    => self::get_saved( $post->ID, true ),
			'allSaved' => self::get_all_saved(),
			'post'     => array(),
			'taxonomy' => array(),
		);

		foreach ( $config['saved'] as $location ) {

			$location = explode( ':', $location );

			if ( count( $location ) >= 4 ) {
				$location[0] = $location[2];
				$location[1] = $location[3];
			}

			if ( 'taxonomy' == $location[0] || 'tax_parent' == $location[0] ) {
				$config['taxonomy'][ $location[1] ] = self::get_taxonomy_terms( $location[1] );
			} elseif ( ( 'post' == $location[0] || 'ancestor' == $location[0] ) && ! isset( $config['posts'][ $location[1] ] ) ) {
				$config['post'][ $location[1] ] = self::get_post_type_posts( $location[1] );
			}
		}
		return $config;
	}

	/**
	 * Returns the exclusion config for the admin edit page.
	 *
	 * @since 1.0
	 * @return array
	 */
	static public function get_exclusions_admin_edit_config() {
		global $post;

		$config = array(
			'saved'    => self::get_saved_exclusions( $post->ID, true ),
			'post'     => array(),
			'taxonomy' => array(),
		);

		foreach ( $config['saved'] as $location ) {

			$location = explode( ':', $location );

			if ( count( $location ) >= 4 ) {
				$location[0] = $location[2];
				$location[1] = $location[3];
			}

			if ( 'taxonomy' == $location[0] ) {
				$config['taxonomy'][ $location[1] ] = self::get_taxonomy_terms( $location[1] );
			} elseif ( ( 'post' == $location[0] || 'ancestor' == $location[0] ) && ! isset( $config['posts'][ $location[1] ] ) ) {
				$config['post'][ $location[1] ] = self::get_post_type_posts( $location[1] );
			}
		}

		return $config;
	}

	/**
	 * Saves locations set on the admin edit screen.
	 *
	 * @since 1.0
	 * @return void
	 */
	static public function admin_edit_save() {
		global $post;

		if ( ! FLBuilderUserAccess::current_user_can( 'theme_builder_editing' ) ) {
			return;
		}
		if ( ! isset( $_POST['fl-theme-builder-nonce'] ) ) {
			return;
		}
		if ( ! wp_verify_nonce( $_POST['fl-theme-builder-nonce'], 'fl-theme-builder' ) ) {
			return;
		}
		if ( ! isset( $_POST['fl-theme-builder-location'] ) || ! is_array( $_POST['fl-theme-builder-location'] ) ) {
			return;
		}

		$post_id    = absint( $_POST['post_ID'] );
		$post_type  = sanitize_text_field( $_POST['post_type'] );
		$locations  = self::admin_edit_get_posted_locations();
		$exclusions = self::admin_edit_get_posted_locations( 'exclusion' );

		self::update_saved( $post_id, $locations );
		self::update_saved_exclusions( $post_id, $exclusions );
	}

	/**
	 * Get the location data that has been posted to the server.
	 * Can be used to get exclusion locations as well.
	 *
	 * @since 1.0
	 * @access private
	 * @param string $type
	 * @return array
	 */
	static private function admin_edit_get_posted_locations( $type = 'location' ) {

		$posted    = stripslashes_deep( $_POST[ 'fl-theme-builder-' . $type ] );
		$locations = array();

		foreach ( $posted as $i => $location ) {

			if ( empty( $location ) ) {
				continue;
			}

			$data     = json_decode( $location );
			$location = $data->type . ':' . $data->id;

			if ( isset( $_POST[ 'fl-theme-builder-' . $type . '-objects' ] ) ) {

				$object = stripslashes_deep( $_POST[ 'fl-theme-builder-' . $type . '-objects' ][ $i ] );

				if ( ! empty( $object ) && ( 'taxonomy' == $data->type || 'post' == $data->type ) ) {
					$object    = json_decode( $object );
					$location .= ':' . $object->id;
				}
			}

			if ( ! in_array( $location, $locations ) ) {
				$locations[] = $location;
			}
		}

		return $locations;
	}

	/**
	 * Get all of the terms for a taxonomy.
	 *
	 * @since 1.0
	 * @param int $tax_id
	 * @return array
	 */
	static public function get_taxonomy_terms( $taxonomy_name ) {
		$tax = get_taxonomy( $taxonomy_name );

		$data = array(
			'type'     => 'terms',
			'taxonomy' => $taxonomy_name,
			'label'    => $tax->label,
			'objects'  => array(),
		);

		$taxonomy_terms_walker = new FLTaxonomyTermsWalker();
		$terms_data            = wp_list_categories( array(
			'taxonomy'           => $taxonomy_name,
			'walker'             => $taxonomy_terms_walker,
			'style'              => '',
			'echo'               => false,
			'title_li'           => '',
			'use_desc_for_title' => '',
			'hide_empty'         => false,
			'hierarchical'       => true,
		));

		$terms_json      = '[' . rtrim( $terms_data, ',' ) . ']';
		$terms           = json_decode( $terms_json, true );
		$data['objects'] = $terms;

		return $data;
	}

	/**
	 * AJAX callback for getting taxonomy terms for the
	 * location object select.
	 *
	 * @since 1.0
	 * @return void
	 */
	static public function ajax_get_terms() {
		check_ajax_referer( 'fl-theme-builder', 'nonce' );

		if ( ! FLBuilderUserAccess::current_user_can( 'theme_builder_editing' ) ) {
			return;
		}
		if ( ! isset( $_POST['id'] ) ) {
			return;
		}

		$tax_id = sanitize_text_field( $_POST['id'] );

		echo json_encode( self::get_taxonomy_terms( $tax_id ) );

		die();
	}

	/**
	 * Get all of the posts for a post type.
	 *
	 * @since 1.0
	 * @param int $post_type
	 * @return array
	 */
	static public function get_post_type_posts( $post_type ) {

		global $wpdb;

		$post_status = array( 'publish', 'future', 'draft', 'pending', 'private' );

		$object = get_post_type_object( $post_type );

		$data = array(
			'type'     => 'posts',
			'postType' => $post_type,
			'label'    => $object->label,
			'objects'  => array(),
		);

		// If Post Type is hierarchical, add padding to the label to indicate
		// its level/depth of nesting from the top-most parent.
		if ( is_post_type_hierarchical( $post_type ) ) {
			$page_walker = new FLPageWalker();
			$pages_data  = wp_list_pages( array(
				'post_type'   => $post_type,
				'exclude'     => '',
				'title_li'    => '',
				'echo'        => false,
				'sort_column' => 'menu_order, post_title',
				'link_before' => '',
				'link_after'  => '',
				'post_status' => $post_status,
				'walker'      => $page_walker,
			) );

			$pages_json      = '[' . rtrim( $pages_data, ',' ) . ']';
			$pages           = json_decode( $pages_json, true );
			$data['objects'] = $pages;

			// Bailout early. Process non-hierachical Post Types below.
			return $data;
		}

		if ( 'attachment' === $post_type ) {
			$posts = $wpdb->get_results( $wpdb->prepare( "SELECT ID, post_title from $wpdb->posts where post_type = %s ORDER BY post_title", $post_type ) );

		} else {
			$format = implode( ', ', array_fill( 0, count( $post_status ), '%s' ) );
			$query  = sprintf( "SELECT ID, post_title, post_parent from $wpdb->posts where post_type = '%s' AND post_status IN(%s) ORDER BY post_title", $post_type, $format );
			// @codingStandardsIgnoreLine
			$posts = $wpdb->get_results( $wpdb->prepare( $query, $post_status ) );
		}

		foreach ( $posts as $post ) {
			$title = ( '' != $post->post_title ) ? self::prepare_title( $post->post_title ) : $post_type . '-' . $post->ID;

			if ( isset( $post->post_parent ) && $post->post_parent > 0 && $post->post_parent !== $post->ID ) {
				$parent       = get_post( $post->post_parent );
				$parent_label = ! empty( $parent->post_title ) ? self::prepare_title( $parent->post_title ) : $post_type . '-' . $parent->ID;
				$title        = $parent_label . ' > ' . $title;
			}

			$data['objects'][] = array(
				'id'   => $post->ID,
				'name' => $title,
			);
		}
		return $data;
	}

	static public function prepare_title( $string ) {
		return esc_attr( strip_tags( htmlspecialchars( $string, ENT_QUOTES ) ) );
	}

	/**
	 * AJAX callback for getting posts for the
	 * location object select.
	 *
	 * @since 1.0
	 * @return void
	 */
	static public function ajax_get_posts() {
		check_ajax_referer( 'fl-theme-builder', 'nonce' );

		if ( ! FLBuilderUserAccess::current_user_can( 'theme_builder_editing' ) ) {
			return;
		}
		if ( ! isset( $_POST['id'] ) ) {
			return;
		}

		$post_type = sanitize_text_field( $_POST['id'] );

		if ( strstr( $post_type, ':post:' ) ) {
			$parts     = explode( ':post:', $post_type );
			$post_type = $parts[1];
		} elseif ( strstr( $post_type, ':ancestor:' ) ) {
			$parts     = explode( ':ancestor:', $post_type );
			$post_type = $parts[1];
		}

		echo json_encode( self::get_post_type_posts( $post_type ) );

		die();
	}

	/**
	 * Returns an array of locations that can be used
	 * as previews for the current post.
	 *
	 * @since 1.0
	 * @param int $post_id
	 * @return array
	 */
	static public function get_preview_locations( $post_id ) {
		$layout_type = get_post_meta( $post_id, '_fl_theme_layout_type', true );
		$all         = self::get_all();
		$saved       = self::get_saved( $post_id );
		$preview     = array(
			'general'  => array(
				'none' => array(
					'id'    => 'none',
					'label' => __( 'None', 'bb-theme-builder' ),
					'type'  => 'general',
				),
			),
			'post'     => array(),
			'archive'  => array(),
			'taxonomy' => array(),
		);

		if ( empty( $layout_type ) ) {
			return;
		} elseif ( empty( $saved ) ) {

			if ( 'singular' == $layout_type ) {
				$saved = array( 'general:single' );
			} elseif ( 'archive' == $layout_type ) {
				$saved = array( 'general:archive' );
			} else {
				$saved = array( 'general:single', 'general:archive' );
			}
		} elseif ( in_array( 'general:site', $saved ) ) {
			$saved = array( 'general:single', 'general:archive' );
		}

		foreach ( $saved as $saved_location ) {

			$parts = explode( ':', $saved_location );

			if ( 'general' == $parts[0] ) {

				if ( 'single' == $parts[1] ) {
					foreach ( $all['by_template_type']['post'] as $post_type => $post_location ) {
						if ( strstr( $post_type, ':' ) ) {
							continue; // only include actual post types.
						}
						$preview['post'][ $post_type ]          = $post_location;
						$preview['post'][ $post_type ]['posts'] = array();
						$preview['post'][ $post_type ]['all']   = true;
					}
				} elseif ( in_array( $parts[1], array( 'archive', 'author', 'date', 'search' ) ) ) {

					if ( 'archive' == $parts[1] ) {
						foreach ( $all['by_template_type']['taxonomy'] as $taxonomy => $taxonomy_location ) {
							$preview['taxonomy'][ $taxonomy ]          = $taxonomy_location;
							$preview['taxonomy'][ $taxonomy ]['terms'] = array();
							$preview['taxonomy'][ $taxonomy ]['all']   = true;
						}
					}

					if ( 'archive' == $parts[1] || 'search' == $parts[1] ) {
						$preview['general']['search'] = array(
							'id'    => 'search',
							'label' => __( 'Search Results', 'bb-theme-builder' ),
							'type'  => 'general',
						);
					}

					if ( 'author' == $parts[1] ) {
						$preview['general']['author'] = array(
							'id'    => 'author',
							'label' => __( 'Author Archives', 'bb-theme-builder' ),
							'type'  => 'general',
						);
					}

					foreach ( $all['by_template_type']['archive'] as $post_type => $post_location ) {
						$preview['archive'][ $post_type ] = $post_location;
					}
				}
			} elseif ( 'post' == $parts[0] ) {

				if ( ! isset( $preview['post'][ $parts[1] ] ) && isset( $all['by_template_type']['post'][ $parts[1] ] ) ) {
					$preview['post'][ $parts[1] ]          = $all['by_template_type']['post'][ $parts[1] ];
					$preview['post'][ $parts[1] ]['posts'] = array();
					$preview['post'][ $parts[1] ]['all']   = false;
				}

				if ( isset( $parts[2] ) && is_numeric( $parts[2] ) && get_post( $parts[2] ) ) {
					$preview['post'][ $parts[1] ]['posts'][] = array(
						'id'    => $parts[2],
						'title' => get_the_title( $parts[2] ),
					);
				} else {
					$preview['post'][ $parts[1] ]['all'] = true;
				}
			} elseif ( 'archive' == $parts[0] && isset( $all['by_template_type']['archive'][ $parts[1] ] ) ) {
				$preview['archive'][ $parts[1] ] = $all['by_template_type']['archive'][ $parts[1] ];
			} elseif ( 'taxonomy' == $parts[0] ) {

				if ( ! isset( $preview['taxonomy'][ $parts[1] ] ) && isset( $all['by_template_type']['taxonomy'][ $parts[1] ] ) ) {
					$preview['taxonomy'][ $parts[1] ]          = $all['by_template_type']['taxonomy'][ $parts[1] ];
					$preview['taxonomy'][ $parts[1] ]['terms'] = array();
					$preview['taxonomy'][ $parts[1] ]['all']   = false;
				}

				if ( isset( $parts[2] ) ) {

					$term = get_term( $parts[2] );

					if ( ! is_wp_error( $term ) ) {
						$preview['taxonomy'][ $parts[1] ]['terms'][] = array(
							'id'    => $parts[2],
							'title' => $term->name,
						);
					}
				} else {
					$preview['taxonomy'][ $parts[1] ]['all'] = true;
				}
			}
		}

		return $preview;
	}

	/**
	 * Gets the default preview location for a post.
	 *
	 * @since 1.0
	 * @param int $post_id
	 * @return string|bool
	 */
	static public function get_default_preview_location( $post_id ) {
		$locations = self::get_preview_locations( $post_id );
		$location  = false;

		if ( ! empty( $locations['post'] ) ) {

			foreach ( $locations['post'] as $post_type => $data ) {

				$posts = get_posts( array(
					'post_type'      => $post_type,
					'posts_per_page' => 1,
				) );

				if ( ! empty( $posts ) ) {
					$location = 'post:' . $post_type . ':' . $posts[0]->ID;
					break;
				}
			}
		} elseif ( ! empty( $locations['archive'] ) ) {
			$post_types = array_keys( $locations['archive'] );
			$location   = 'archive:' . $post_types[0];
		} elseif ( ! empty( $locations['taxonomy'] ) ) {

			foreach ( $locations['taxonomy'] as $taxonomy => $data ) {

				$terms = get_terms( array(
					'taxonomy'   => $taxonomy,
					'hide_empty' => false,
				) );

				if ( ! is_wp_error( $terms ) && ! empty( $terms ) ) {
					$location = 'taxonomy:' . $taxonomy . ':' . $terms[0]->term_id;
					break;
				}
			}
		}

		if ( $location ) {
			self::update_preview_location( $post_id, $location );
		}

		return $location;
	}

	/**
	 * Gets the preview location string for a post.
	 *
	 * @since 1.0
	 * @param int $post_id
	 * @return string|bool
	 */
	static public function get_preview_location( $post_id ) {
		$saved = get_post_meta( $post_id, '_fl_theme_builder_preview_location', true );

		if ( empty( $saved ) ) {
			$saved = self::get_default_preview_location( $post_id );
		}

		return $saved;
	}

	/**
	 * Saves the preview location string for a post.
	 *
	 * @since 1.0
	 * @param int    $post_id
	 * @param string $location
	 * @return void
	 */
	static public function update_preview_location( $post_id, $location ) {
		update_post_meta( $post_id, '_fl_theme_builder_preview_location', $location );
	}

	/**
	 * Updates the preview location via frontend AJAX.
	 *
	 * @since 1.0
	 * @return void
	 */
	static public function ajax_update_preview_location() {
		$post_data = FLBuilderModel::get_post_data();

		self::update_preview_location( $post_data['post_id'], $post_data['location'] );
	}

	/**
	 * Sets up the preview query data and hooks if we are
	 * currently on a theme layout.
	 *
	 * @since 1.0
	 * @return void
	 */
	static public function init_preview_query() {
		global $post;

		// Make sure we're on a theme layout.
		if ( ! is_object( $post ) || 'fl-theme-layout' != $post->post_type ) {
			return;
		}

		// Make sure we have a preview location.
		$preview = self::get_preview_location( $post->ID );

		if ( ! $preview || 'general:none' === $preview ) {
			return;
		}

		// Get the preview query args.
		$preview = explode( ':', $preview );

		if ( 'post' == $preview[0] && post_type_exists( $preview[1] ) && get_post( $preview[2] ) ) {
			self::$preview_args = array(
				'post_type' => $preview[1],
				'p'         => $preview[2],
			);
		} elseif ( 'archive' == $preview[0] ) {
			self::$preview_args = array(
				'post_type' => $preview[1],
			);
		} elseif ( 'taxonomy' == $preview[0] ) {

			if ( isset( $preview[2] ) ) {
				self::$preview_args = array(
					'tax_query' => array(
						array(
							'taxonomy' => $preview[1],
							'field'    => 'term_id',
							'terms'    => array( $preview[2] ),
						),
					),
				);
			} else {
				self::$preview_args = array(
					'tax_query' => array(
						array(
							'taxonomy' => $preview[1],
						),
					),
				);
			}
		} elseif ( 'general' == $preview[0] && 'search' == $preview[1] ) {
			self::$preview_args = array(
				's' => '',
			);
		} elseif ( 'general' == $preview[0] && 'author' == $preview[1] ) {
			self::$preview_args = array(
				'author' => 1,
			);
		}

		// Setup the preview hooks.
		if ( self::$preview_args ) {
			add_action( 'wp_enqueue_scripts', __CLASS__ . '::set_preview_query', 1 );
			add_action( 'wp_enqueue_scripts', __CLASS__ . '::reset_preview_query', PHP_INT_MAX );
			add_action( 'fl_builder_render_content_start', __CLASS__ . '::set_preview_query' );
			add_action( 'fl_builder_render_content_complete', __CLASS__ . '::reset_preview_query' );
			add_action( 'fl_builder_before_render_ajax_layout_html', __CLASS__ . '::set_preview_query' );
			add_action( 'fl_builder_after_render_ajax_layout_html', __CLASS__ . '::reset_preview_query' );
		}
	}

	/**
	 * Overrides the main query based on the current theme
	 * layout that is being edited and the location preview
	 * that has been set for it.
	 *
	 * @since 1.0
	 * @return void
	 */
	static public function set_preview_query() {
		global $wp_query;
		global $post;

		// Make sure we have preview args.
		if ( ! self::$preview_args ) {
			return;
		}

		// Reset the current page location.
		self::$current_page_location = null;

		// Create the preview query.
		self::$preview_query = new WP_Query( self::$preview_args );

		// Make sure the preview query returns a post.
		if ( ! is_object( self::$preview_query->post ) ) {
			return;
		}

		// Override $wp_query and $post with the preview query.
		$wp_query = self::$preview_query;
		$post     = self::$preview_query->post;
		setup_postdata( $post );
	}

	/**
	 * Resets the preview query back to the main query.
	 *
	 * @since 1.0
	 * @return void
	 */
	static public function reset_preview_query() {
		// Make sure we have a preview query.
		if ( ! self::$preview_args || ! self::$preview_query ) {
			return;
		}

		// Reset the current page location.
		self::$current_page_location = null;

		// Rewind posts and reset the query.
		rewind_posts();
		wp_reset_query();

		// Reset the builder's post ID.
		if ( defined( 'DOING_AJAX' ) ) {
			FLBuilderModel::reset_post_id();
		}
	}

	/**
	 * Returns the original post object for a preview query.
	 *
	 * @since 1.0
	 * @return bool|object
	 */
	static public function get_preview_original_post() {
		global $wp_the_query;
		global $post;

		if ( ! self::$preview_args || ! self::$preview_query ) {
			return is_object( $post ) ? $post : false;
		}

		return is_object( $wp_the_query->post ) ? $wp_the_query->post : false;
	}

	/**
	 * Renders the preview selector button.
	 *
	 * @since 1.0
	 * @return void
	 */
	static public function render_ui_preview_selector() {
		global $post;

		if ( 'fl-theme-layout' != $post->post_type ) {
			return;
		}

		$locations = self::get_preview_locations( $post->ID );
		$saved     = self::get_preview_location( $post->ID );
		$label     = false;

		if ( $saved ) {
			$label = self::get_saved_label( $saved, true );
		}
		if ( ! $label ) {
			$label = __( 'None', 'bb-theme-builder' );
		}

		if ( empty( $locations['post'] ) && empty( $locations['archive'] ) && empty( $locations['taxonomy'] ) ) {
			return;
		}

		include FL_THEME_BUILDER_DIR . 'includes/frontend-edit-preview-locations.php';
	}

	/**
	 * AJAX callback for getting posts for the frontend
	 * preview location select.
	 *
	 * @since 1.0
	 * @return void
	 */
	static public function ajax_get_preview_posts() {
		$post_data = FLBuilderModel::get_post_data();

		echo json_encode( self::get_post_type_posts( $post_data['post_type'] ) );

		die();
	}

	/**
	 * AJAX callback for getting terms for the frontend
	 * preview location select.
	 *
	 * @since 1.0
	 * @return void
	 */
	static public function ajax_get_preview_terms() {
		$post_data = FLBuilderModel::get_post_data();

		echo json_encode( self::get_taxonomy_terms( $post_data['taxonomy'] ) );

		die();
	}
}

FLThemeBuilderRulesLocation::init();
