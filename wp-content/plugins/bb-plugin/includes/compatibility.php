<?php
/**
 * Misc functions that are not in classes.
 *
 * For 3rd party compatibility actions/filters see classes/class-fl-builder-compatibility.php
 */

/**
 * Siteground cache captures shutdown and breaks our dynamic js loading.
 * Siteground changed their plugin, this code has to run super early.
 * @since 2.0.4.2
 */
if ( isset( $_GET['fl_builder_load_settings_config'] ) ) {
	add_filter( 'option_siteground_optimizer_fix_insecure_content', '__return_false' );
}

/**
 * Try to unserialize data normally.
 * Uses a preg_callback to fix broken data caused by serialized data that has broken offsets.
 *
 * @since 1.10.6
 * @param string $data unserialized string
 * @return array
 */
function fl_maybe_fix_unserialize( $data ) {
	// @codingStandardsIgnoreStart
	$unserialized = @unserialize( $data );
	// @codingStandardsIgnoreEnd
	if ( ! $unserialized ) {
		$unserialized = unserialize( preg_replace_callback( '!s:(\d+):"(.*?)";!', 'fl_maybe_fix_unserialize_callback', $data ) );
	}
	return $unserialized;
}

/**
 * Callback function for fl_maybe_fix_unserialize()
 *
 * @since 1.10.6
 */
function fl_maybe_fix_unserialize_callback( $match ) {
	return ( strlen( $match[2] ) == $match[1] ) ? $match[0] : 's:' . strlen( $match[2] ) . ':"' . $match[2] . '";';
}

/**
 * Set sane settings for SSL
 * @since 2.2.1
 */
function fl_set_curl_safe_opts( $handle ) {
	curl_setopt( $handle, CURLOPT_SSL_VERIFYPEER, 1 );
	curl_setopt( $handle, CURLOPT_SSL_VERIFYHOST, 2 );
	curl_setopt( $handle, CURLOPT_CAINFO, ABSPATH . WPINC . '/certificates/ca-bundle.crt' );
	return $handle;
}

/**
 * Fix pagination on category archive layout.
 * @since 2.2.4
 */
function fl_theme_builder_archive_post_grid( $layouts ) {
	global $wp_the_query;

	if ( ! $layouts || $layouts['query']->post_count <= 0 ) {
		return;
	}

	$post_grid     = null;
	$exclusions    = array();
	$current_loop  = 0;
	$current_paged = 1;
	$nodes         = array();

	if ( $wp_the_query->get( 'flpaged' ) ) {
		global $wp;
		$current_url = home_url( $wp->request );
		$flpaged     = preg_match( '/paged-([0-9]{1,})\/?([0-9]{1,})/', $current_url, $matches );
		if ( $flpaged ) {
			$current_loop  = (int) $matches[1] > 1 ? (int) $matches[1] - 1 : 1;
			$current_paged = (int) $matches[2];
		}
	} elseif ( $wp_the_query->get( 'paged' ) ) {
		$current_paged = $wp_the_query->get( 'paged' );
	}

	foreach ( $layouts['query']->posts as $i => $post_id ) {
		$exclusions = FLThemeBuilderRulesLocation::get_saved_exclusions( $post_id );
		$exclude    = false;

		if ( $layouts['object'] && in_array( $layouts['object'], $exclusions ) ) {
			$exclude = true;
		} elseif ( in_array( $layouts['location'], $exclusions ) ) {
			$exclude = true;
		} elseif ( in_array( 'general:archive', $exclusions ) ) {
			$exclude = true;
		}

		if ( $exclude ) {
			continue;
		}

		$nodes      = FLBuilderModel::get_layout_data( 'published', $post_id );
		$post_grids = fl_ordered_post_grid( $nodes );

		if ( empty( $nodes ) || empty( $post_grids ) || ! isset( $post_grids[ $current_loop ] ) ) {
			continue;
		}

		FLBuilderLoop::$loop_counter = $current_loop;
		$get_node                    = $nodes[ $post_grids[ $current_loop ] ];
		$query_post_grid             = FLBuilderLoop::query( $get_node->settings );
		FLBuilderLoop::$loop_counter = 0;

		$post_grid['post_count']  = $query_post_grid->post_count;
		$post_grid['page_exists'] = $query_post_grid->max_num_pages >= $current_paged;
		break;
	}

	return $post_grid;
}

/**
 * Helper function that queries the themer layouts in archive pages.
 */
function fl_theme_builder_archive_layouts( $query, $return = '' ) {
	if ( ! $query ) {
		return;
	}

	if ( ! class_exists( 'FLThemeBuilder' ) ) {
		return;
	}

	if ( is_admin() || ! $query->is_main_query() ) {
		return;
	}

	if ( ! $query->is_archive && ! $query->is_home && ! $query->is_search ) {
		return;
	}

	$queried_object = get_queried_object();
	$object         = null;
	$location       = null;
	$layouts_data   = array();

	if ( ! $queried_object && ! is_home() && ! is_search() && ! is_date() ) {
		return;
	}

	if ( is_home() ) {
		$location = 'archive:post';
	} elseif ( is_author() ) {
		$location = 'general:author';
	} elseif ( is_date() ) {
		$location = 'general:date';
	} elseif ( is_search() ) {
		$location = 'general:search';
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
	} elseif ( is_post_type_archive() && is_object( $queried_object ) ) {
		$location = 'archive:' . $queried_object->query_var;
	} else {
		return;
	}

	$args = array(
		'post_type'   => 'fl-theme-layout',
		'post_status' => 'publish',
		'fields'      => 'ids',
		'meta_query'  => array(
			'relation' => 'OR',
			array(
				'key'     => '_fl_theme_builder_locations',
				'value'   => '"general:site"',
				'compare' => 'LIKE',
			),
			array(
				'key'     => '_fl_theme_builder_locations',
				'value'   => '"' . $location . '"',
				'compare' => 'LIKE',
			),
		),
	);

	if ( is_archive() || is_home() || is_search() ) {
		$args['meta_query'][] = array(
			'key'     => '_fl_theme_builder_locations',
			'value'   => '"general:archive"',
			'compare' => 'LIKE',
		);
	}

	if ( $object ) {
		$args['meta_query'][] = array(
			'key'     => '_fl_theme_builder_locations',
			'value'   => '"' . $object . '"',
			'compare' => 'LIKE',
		);
	}

	$layouts_data = array(
		'location' => $location,
		'object'   => $object,
		'query'    => new WP_Query( $args ),
	);

	if ( ! empty( $return ) && isset( $layouts_data[ $return ] ) ) {
		return $layouts_data[ $return ];
	} else {
		return $layouts_data;
	}
}

/**
 * Get the ordered post-grid modules from the layout data.
 */
function fl_ordered_post_grid( $data ) {
	$parent_nodes  = array();
	$ordered_nodes = array();

	foreach ( $data as $node_id => $node ) {
		if ( 'module' != $node->type ) {
			continue;
		}

		if ( ! isset( $node->settings->data_source ) || ! isset( $node->settings->pagination ) ) {
			continue;
		}

		if ( ! in_array( $node->settings->data_source, array( 'main_query', 'custom_query' ) ) ) {
			continue;
		}

		$root_node = false;
		$grid_node = $node;

		// Traverse parent nodes.
		while ( ! $root_node ) {
			if ( ! empty( $grid_node->parent ) && isset( $data[ $grid_node->parent ] ) ) {
				$parent = $data[ $grid_node->parent ];

				if ( ! isset( $parent_nodes[ $parent->type ] ) || ! isset( $parent_nodes[ $parent->type ][ $parent->node ] ) ) {
					$parent_nodes[ $parent->type ][ $parent->node ] = array(
						'position' => $parent->position,
						'node'     => array(
							$node_id => array(
								'position' => $node->position,
							),
						),
					);
				} elseif ( isset( $parent_nodes[ $parent->type ][ $parent->node ] )
					&& ! isset( $parent_nodes[ $parent->type ][ $parent->node ]['node'][ $node_id ] ) ) {
						$parent_nodes[ $parent->type ][ $parent->node ]['node'][ $node_id ] = array(
							'position' => $node->position,
						);
				}

				// New node to crawl the tree.
				$grid_node = $parent;

			} elseif ( empty( $grid_node->parent ) && 'row' == $grid_node->type ) {
				$root_node = true;
			} else {
				break;
			}
		}
	}

	// Order nodes by position
	foreach ( $parent_nodes as $type => $parent_node ) {
		uasort($parent_node, function( $a, $b ) {
			return $a['position'] - $b['position'];
		});

		foreach ( $parent_node as $parent_id => $parent ) {
			if ( ! isset( $parent['node'] ) ) {
				continue;
			}

			// Order post grids
			uasort($parent['node'], function( $a, $b ) {
				return $a['position'] - $b['position'];
			});
			$parent_node[ $parent_id ] = $parent;

			// Priorize row ordering
			if ( 'row' == $type ) {
				foreach ( $parent['node'] as $node_id => $node ) {
					if ( ! in_array( $node_id, $ordered_nodes ) ) {
						$ordered_nodes[] = $node_id;
					}
				}
			}
		}
	}

	return $ordered_nodes;
}

/**
 * Fix canonical for singular layout with post-grid module pagination.
 * @since 2.4
 */
function fl_theme_builder_has_post_grid() {
	if ( ! class_exists( 'FLThemeBuilder' ) ) {
		return false;
	}

	if ( ! FLThemeBuilder::has_layout() ) {
		return false;
	}

	$layout_ids = array();

	// Checks themer layout
	$header = FLThemeBuilderLayoutData::get_current_page_layout_ids( 'header' );
	if ( ! empty( $header ) ) {
		$layout_ids[] = $header[0];
	}
	$single = FLThemeBuilderLayoutData::get_current_page_layout_ids( 'singular' );
	if ( ! empty( $single ) ) {
		$layout_ids[] = $single[0];
	}
	$footer = FLThemeBuilderLayoutData::get_current_page_layout_ids( 'footer' );
	if ( ! empty( $footer ) ) {
		$layout_ids[] = $footer[0];
	}
	$parts = FLThemeBuilderLayoutData::get_current_page_layout_ids( 'part' );
	if ( ! empty( $parts ) ) {
		$layout_ids = array_merge( $layout_ids, $parts );
	}

	if ( empty( $layout_ids ) ) {
		return false;
	}

	foreach ( $layout_ids as $layout_id ) {
		$data = FLBuilderModel::get_layout_data( 'published', $layout_id );

		foreach ( $data as $node_id => $node ) {
			if ( 'module' != $node->type ) {
				continue;
			}

			if ( isset( $node->settings->type ) && 'post-grid' == $node->settings->type ) {
				return true;
			}
		}
	}

	return false;
}
