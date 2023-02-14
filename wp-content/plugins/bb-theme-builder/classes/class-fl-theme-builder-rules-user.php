<?php

/**
 * Handles user rule logic for the theme builder.
 *
 * @since 1.0
 */
final class FLThemeBuilderRulesUser {

	/**
	 * Initialize hooks.
	 *
	 * @since 1.0
	 * @return void
	 */
	static public function init() {
		add_action( 'save_post', __CLASS__ . '::admin_edit_save' );
	}

	/**
	 * Returns an array of posts from a posts array that the current
	 * user can view based on the user rules that have been set.
	 *
	 * @since 1.0
	 * @param array $array
	 * @return array
	 */
	static public function get_posts_from_array( $array ) {
		$user  = wp_get_current_user();
		$found = array();
		$posts = array(
			'all'     => array(),
			'general' => array(),
			'role'    => array(),
		);

		foreach ( $array as $post ) {

			if ( isset( $post['users'] ) ) {
				$saved = $post['users'];
			} else {
				$saved = self::get_saved( $post['id'] );
			}

			if ( 0 === count( $saved ) || in_array( 'general:all', $saved ) ) {
				$posts['all'][] = $post;
			} else {

				foreach ( $saved as $rule ) {

					$parts = explode( ':', $rule );

					if ( ! isset( $posts[ $parts[0] ][ $parts[1] ] ) ) {
						$posts[ $parts[0] ][ $parts[1] ] = array();
					}

					$posts[ $parts[0] ][ $parts[1] ][] = $post;
				}
			}
		}

		// Bail early and return posts for all users if we're editing a themer layout.
		if ( 'fl-theme-layout' === get_post_type() ) {
			return $posts['all'];
		}

		// Find and merge any role based posts.
		foreach ( $posts['role'] as $rule => $rule_posts ) {
			if ( in_array( $rule, $user->roles ) ) {
				$found = array_merge( $found, $rule_posts );
			}
		}

		// Find and merge any logged in/out posts.
		foreach ( $posts['general'] as $rule => $rule_posts ) {
			if ( 'logged-in' == $rule && is_user_logged_in() ) {
				$found = array_merge( $found, $rule_posts );
			} elseif ( 'logged-out' == $rule && ! is_user_logged_in() ) {
				$found = array_merge( $found, $rule_posts );
			}
		}

		// Finally, merge any posts for all users.
		$found = array_merge( $found, $posts['all'] );

		return $found;
	}

	/**
	 * Returns the user rules for a post.
	 *
	 * @since 1.0
	 * @param int $post_id
	 * @return array
	 */
	static public function get_saved( $post_id ) {
		$rules = get_post_meta( $post_id, '_fl_theme_builder_user_rules', true );

		return ! $rules ? array() : $rules;
	}

	/**
	 * Returns ordered the user rules for a post.
	 *
	 * @since 1.0
	 * @param int $post_id
	 * @return array
	 */
	static public function get_ordered_saved( $post_id ) {
		$saved_rules = self::get_saved( $post_id );
		$ordered     = array();

		foreach ( $saved_rules as $saved_rule ) {

			$label = self::get_saved_label( $saved_rule );

			if ( $label ) {
				$ordered[ $label ] = $saved_rule;
			}
		}

		ksort( $ordered );

		return $ordered;
	}

	/**
	 * Returns the label for a saved user rule.
	 *
	 * @since 1.0
	 * @param string $saved_rule
	 * @return string|bool
	 */
	static public function get_saved_label( $saved_rule ) {
		$rules      = self::get_all();
		$saved_rule = explode( ':', $saved_rule );
		$label      = $rules[ $saved_rule[0] ]['rules'][ $saved_rule[1] ]['label'];

		return $label;
	}

	/**
	 * Updates the user rules for a post.
	 *
	 * @since 1.0
	 * @param int   $post_id
	 * @param array $rules
	 * @return void
	 */
	static public function update_saved( $post_id, $rules ) {
		return update_post_meta( $post_id, '_fl_theme_builder_user_rules', $rules );
	}

	/**
	 * Returns all possible user rules.
	 *
	 * @since 1.0
	 * @return array
	 */
	static public function get_all() {
		if ( ! function_exists( 'get_editable_roles' ) ) {
			require_once( ABSPATH . 'wp-admin/includes/user.php' );
		}

		$rules = array(
			'general' => array(
				'label' => __( 'General', 'bb-theme-builder' ),
				'rules' => array(
					'all'        => array(
						'id'    => 'all',
						'label' => __( 'All Users', 'bb-theme-builder' ),
						'type'  => 'general',
					),
					'logged-in'  => array(
						'id'    => 'logged-in',
						'label' => __( 'Logged In', 'bb-theme-builder' ),
						'type'  => 'general',
					),
					'logged-out' => array(
						'id'    => 'logged-out',
						'label' => __( 'Logged Out', 'bb-theme-builder' ),
						'type'  => 'general',
					),
				),
			),
			'role'    => array(
				'label' => __( 'Roles', 'bb-theme-builder' ),
				'rules' => array(),
			),
		);

		$roles = get_editable_roles();

		foreach ( $roles as $slug => $data ) {
			$rules['role']['rules'][ $slug ] = array(
				'id'    => $slug,
				'label' => $data['name'],
				'type'  => 'role',
			);
		}

		return $rules;
	}

	/**
	 * Renders the meta box settings for user rules.
	 *
	 * @since 1.0
	 * @return void
	 */
	static public function render_admin_edit_settings() {
		global $post;

		$rules     = self::get_all();
		$post_type = get_post_type_object( $post->post_type );

		include FL_THEME_BUILDER_DIR . 'includes/admin-edit-user-rules.php';
	}

	/**
	 * Saves user rules set on the admin edit screen.
	 *
	 * @since 1.0
	 * @return void
	 */
	static public function admin_edit_save() {
		if ( ! FLBuilderUserAccess::current_user_can( 'theme_builder_editing' ) ) {
			return;
		}
		if ( ! isset( $_POST['fl-theme-builder-nonce'] ) ) {
			return;
		}
		if ( ! wp_verify_nonce( $_POST['fl-theme-builder-nonce'], 'fl-theme-builder' ) ) {
			return;
		}
		if ( ! isset( $_POST['fl-theme-builder-user-rule'] ) || ! is_array( $_POST['fl-theme-builder-user-rule'] ) ) {
			return;
		}

		$post_id   = absint( $_POST['post_ID'] );
		$post_type = sanitize_text_field( $_POST['post_type'] );
		$posted    = stripslashes_deep( $_POST['fl-theme-builder-user-rule'] );
		$rules     = array();

		foreach ( $posted as $i => $rule ) {

			if ( empty( $rule ) ) {
				continue;
			}

			$data = json_decode( $rule );
			$rule = $data->type . ':' . $data->id;

			if ( ! in_array( $rule, $rules ) ) {
				$rules[] = $rule;
			}
		}

		self::update_saved( $post_id, $rules );
	}
}

FLThemeBuilderRulesUser::init();
