<?php

/**
 * REST API methods to retrieve data for WordPress rules.
 *
 * @since 0.1
 */
final class BB_Logic_REST_WordPress {

	/**
	 * REST API namespace
	 *
	 * @since 0.1
	 * @var string $namespace
	 */
	static protected $namespace = 'bb-logic/v1/wordpress';

	/**
	 * Register routes.
	 *
	 * @since  0.1
	 * @return void
	 */
	static public function register_routes() {
		register_rest_route(
			self::$namespace, '/posts', array(
				array(
					'methods'             => WP_REST_Server::READABLE,
					'callback'            => __CLASS__ . '::posts',
					'permission_callback' => __CLASS__ . '::check_permission',
				),
			)
		);

		register_rest_route(
			self::$namespace, '/post-types', array(
				array(
					'methods'             => WP_REST_Server::READABLE,
					'callback'            => __CLASS__ . '::post_types',
					'permission_callback' => __CLASS__ . '::check_permission',
				),
			)
		);

		register_rest_route(
			self::$namespace, '/post-stati', array(
				array(
					'methods'             => WP_REST_Server::READABLE,
					'callback'            => __CLASS__ . '::post_stati',
					'permission_callback' => __CLASS__ . '::check_permission',
				),
			)
		);

		register_rest_route(
			self::$namespace, '/post-templates', array(
				array(
					'methods'             => WP_REST_Server::READABLE,
					'callback'            => __CLASS__ . '::post_templates',
					'permission_callback' => __CLASS__ . '::check_permission',
				),
			)
		);

		register_rest_route(
			self::$namespace, '/archives', array(
				array(
					'methods'             => WP_REST_Server::READABLE,
					'callback'            => __CLASS__ . '::archives',
					'permission_callback' => __CLASS__ . '::check_permission',
				),
			)
		);

		register_rest_route(
			self::$namespace, '/taxonomies', array(
				array(
					'methods'             => WP_REST_Server::READABLE,
					'callback'            => __CLASS__ . '::taxonomies',
					'permission_callback' => __CLASS__ . '::check_permission',
				),
			)
		);

		register_rest_route(
			self::$namespace, '/terms', array(
				array(
					'methods'             => WP_REST_Server::READABLE,
					'callback'            => __CLASS__ . '::terms',
					'permission_callback' => __CLASS__ . '::check_permission',
				),
			)
		);

		register_rest_route(
			self::$namespace, '/users', array(
				array(
					'methods'             => WP_REST_Server::READABLE,
					'callback'            => __CLASS__ . '::users',
					'permission_callback' => __CLASS__ . '::check_permission',
				),
			)
		);

		register_rest_route(
			self::$namespace, '/roles', array(
				array(
					'methods'             => WP_REST_Server::READABLE,
					'callback'            => __CLASS__ . '::roles',
					'permission_callback' => __CLASS__ . '::check_permission',
				),
			)
		);

		register_rest_route(
			self::$namespace, '/capabilities', array(
				array(
					'methods'             => WP_REST_Server::READABLE,
					'callback'            => __CLASS__ . '::capabilities',
					'permission_callback' => __CLASS__ . '::check_permission',
				),
			)
		);
	}

	/**
	 * Returns an array of posts with each item
	 * containing a label and value.
	 *
	 * @since  0.1
	 * @param object $request
	 * @return array
	 */
	static public function posts( $request ) {
		$response  = array();
		$post_type = $request->get_param( 'post_type' );

		$posts = get_posts( array(
			'post_type'   => $post_type ? $post_type : 'post',
			'numberposts' => -1,
			'orderby'     => 'title',
			'order'       => 'ASC',
		) );

		foreach ( $posts as $post ) {
			$response[] = array(
				'label' => ! empty( $post->post_title ) ? $post->post_title : $post->post_name,
				'value' => $post->ID,
			);
		}

		return rest_ensure_response( $response );
	}

	/**
	 * Returns an array of post types with each item
	 * containing a label and value.
	 *
	 * @since  0.1
	 * @param object $request
	 * @return array
	 */
	static public function post_types( $request ) {
		$response     = array();
		$hierarchical = $request->get_param( 'hierarchical' );
		$args         = array(
			'public' => true,
		);

		if ( null !== $hierarchical ) {
			$args['hierarchical'] = $hierarchical;
		}

		$post_types = get_post_types( $args, 'objects' );

		foreach ( $post_types as $slug => $type ) {
			$response[] = array(
				'label' => $type->labels->singular_name,
				'value' => $slug,
			);
		}

		return rest_ensure_response( $response );
	}

	/**
	 * Returns an array of post statuses with each item
	 * containing a label and value.
	 *
	 * @since  0.1
	 * @return array
	 */
	static public function post_stati() {
		$response = array();
		$statuses = get_post_stati( array(), 'objects' );

		foreach ( $statuses as $slug => $status ) {
			$response[] = array(
				'label' => $status->label,
				'value' => $slug,
			);
		}

		return rest_ensure_response( $response );
	}

	/**
	 * Returns an array of post templates grouped by post
	 * type with each item containing a label and value.
	 *
	 * @since  0.1
	 * @return array
	 */
	static public function post_templates() {
		$response           = array();
		$templates          = wp_get_theme()->get_post_templates();
		$post_type_objects  = get_post_types( array(
			'public' => true,
		), 'objects' );
		$templates_by_file  = array();
		$templates_by_name  = array();
		$templates_by_group = array();

		foreach ( $templates as $post_type => $files ) {
			foreach ( $files as $file => $name ) {
				if ( ! isset( $templates_by_file[ $file ] ) ) {
					$templates_by_file[ $file ] = array();
				}
				$templates_by_file[ $file ][] = $post_type_objects[ $post_type ]->labels->singular_name;
				$templates_by_name[ $file ]   = $name;
			}
		}

		foreach ( $templates_by_file as $file => $post_types ) {
			$group_label = implode( ', ', $post_types );
			if ( ! isset( $templates_by_group[ $group_label ] ) ) {
				$templates_by_group[ $group_label ] = array();
			}
			$templates_by_group[ $group_label ][] = $file;
		}

		foreach ( $templates_by_group as $label => $files ) {
			$group = array(
				'label'   => $label,
				'options' => array(),
			);
			foreach ( $files as $file ) {
				$group['options'][] = array(
					'label' => $templates_by_name[ $file ],
					'value' => $file,
				);
			}
			$response[] = $group;
		}

		return rest_ensure_response( $response );
	}

	/**
	 * Returns an array of archives grouped by type
	 * with each item containing a label and value.
	 *
	 * @since  0.1
	 * @return array
	 */
	static public function archives() {
		$response = array(
			array(
				'label'   => __( 'General', 'bb-theme-builder' ),
				'options' => array(
					array(
						'label' => __( 'Author Archives', 'bb-theme-builder' ),
						'value' => 'general/author',
					),
					array(
						'label' => __( 'Date Archives', 'bb-theme-builder' ),
						'value' => 'general/date',
					),
					array(
						'label' => __( 'Search Archives', 'bb-theme-builder' ),
						'value' => 'general/search',
					),
				),
			),
		);

		$post_types = get_post_types( array(
			'public' => true,
		), 'objects' );

		foreach ( $post_types as $slug => $type ) {
			$group = array(
				'label'   => $type->labels->singular_name,
				'options' => array(),
			);

			if ( 'post' == $slug || ! empty( $type->has_archive ) ) {
				$group['options'][] = array(
					/* translators: %s: post type singular name */
					'label' => sprintf( _x( '%s Archive', '%s post type singular name', 'bb-theme-builder' ), $type->labels->singular_name ),
					'value' => "post/$slug",
				);
			}

			$taxonomies = get_object_taxonomies( $slug, 'objects' );

			foreach ( $taxonomies as $taxonomy_slug => $taxonomy ) {
				if ( ! $taxonomy->public || ! $taxonomy->show_ui ) {
					continue;
				}

				$label = str_replace( array(
					$type->labels->name,
					$type->labels->singular_name,
				), '', $taxonomy->labels->singular_name );

				$group['options'][] = array(
					'label' => $type->labels->singular_name . ' ' . $label,
					'value' => "taxonomy/$taxonomy_slug",
				);
			}

			if ( ! empty( $group['options'] ) ) {
				$response[] = $group;
			}
		}

		return $response;
	}

	/**
	 * Returns an array of taxonomies grouped by post type
	 * with each item containing a label and value.
	 *
	 * @since  0.1
	 * @return array
	 */
	static public function taxonomies() {
		$response = array();
		$types    = get_post_types( array(
			'public' => true,
		), 'objects' );

		foreach ( $types as $slug => $type ) {
			$taxonomies = get_object_taxonomies( $slug, 'objects' );

			if ( empty( $taxonomies ) ) {
				continue;
			}

			$group = array(
				'label'   => $type->labels->singular_name,
				'options' => array(),
			);

			foreach ( $taxonomies as $taxonomy_slug => $taxonomy ) {
				if ( ! $taxonomy->public || ! $taxonomy->show_ui ) {
					continue;
				}

				$label = str_replace( array(
					$type->labels->name,
					$type->labels->singular_name,
				), '', $taxonomy->labels->singular_name );

				$group['options'][] = array(
					'label' => $type->labels->singular_name . ' ' . $label,
					'value' => $taxonomy_slug,
				);
			}

			$response[] = $group;
		}

		return rest_ensure_response( $response );
	}

	/**
	 * Returns an array of terms with each item
	 * containing a label and value.
	 *
	 * @since  0.1
	 * @param object $request
	 * @return array
	 */
	static public function terms( $request ) {
		$response = array();
		$taxonomy = $request->get_param( 'taxonomy' );

		if ( $taxonomy ) {
			$terms = get_terms( array(
				'taxonomy'   => $taxonomy,
				'hide_empty' => false,
			) );
			foreach ( $terms as $term ) {
				$response[] = array(
					'label' => $term->name,
					'value' => $term->term_id,
				);
			}
		}

		return rest_ensure_response( $response );
	}

	/**
	 * Returns an array of users with each item being
	 * the user's username. Can be filtered using the
	 * suggest parameter.
	 *
	 * @since  0.1
	 * @param object $request
	 * @return array
	 */
	static public function users( $request ) {
		$response = array();
		$suggest  = $request->get_param( 'suggest' );

		if ( $suggest ) {
			$users = get_users( array(
				'search' => "$suggest*",
			) );
			foreach ( $users as $user ) {
				$response[] = array(
					'label' => $user->user_login,
					'value' => $user->user_login,
				);
			}
		}

		return rest_ensure_response( $response );
	}

	/**
	 * Returns an array of available user roles with
	 * each item containing a label and value.
	 *
	 * @since  0.1
	 * @return array
	 */
	static public function roles() {
		global $wp_roles;
		$response = array();

		foreach ( $wp_roles->role_names as $slug => $name ) {
			$response[] = array(
				'label' => $name,
				'value' => $slug,
			);
		}

		return rest_ensure_response( $response );
	}

	/**
	 * Returns an array of available user capabilities
	 * with each item containing a label and value.
	 *
	 * @since  0.1
	 * @return array
	 */
	static public function capabilities() {
		global $wp_roles;
		$response     = array();
		$capabilities = array();

		foreach ( $wp_roles->roles as $role ) {
			foreach ( $role['capabilities'] as $capability => $auth ) {
				if ( ! in_array( $capability, $capabilities ) ) {
					$capabilities[] = $capability;
				}
			}
		}

		natcasesort( $capabilities );

		foreach ( $capabilities as $capability ) {
			$response[] = array(
				'label' => $capability,
				'value' => $capability,
			);
		}

		return rest_ensure_response( $response );
	}

	/**
	 * Checks permission.
	 *
	 * @return boolean
	 */
	static public function check_permission() {
		return current_user_can( 'edit_posts' );
	}
}

BB_Logic_REST_WordPress::register_routes();
