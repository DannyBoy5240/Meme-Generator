<?php

/**
 * Logic for the theme layouts admin list table screen.
 *
 * @since 1.0
 */
final class FLThemeBuilderLayoutAdminList {

	/**
	 * Initialize hooks.
	 *
	 * @since 1.0
	 * @return void
	 */
	static public function init() {
		// Actions
		add_action( 'pre_get_posts', __CLASS__ . '::order_by_type' );
		add_action( 'manage_fl-theme-layout_posts_custom_column', __CLASS__ . '::manage_column_content', 10, 2 );
		add_action( 'admin_enqueue_scripts', __CLASS__ . '::admin_enqueue_scripts' );
		add_action( 'wp_ajax_fl_template_switch', __CLASS__ . '::switch_status' );

		// Filters
		add_filter( 'manage_fl-theme-layout_posts_columns', __CLASS__ . '::manage_column_headings' );
		add_filter( 'manage_edit-fl-theme-layout_sortable_columns', __CLASS__ . '::manage_sortable_columns' );
	}

	/**
	 * Orders the admin columns by layout type.
	 *
	 * @since 1.0
	 * @param object $query
	 * @return void
	 */
	static public function order_by_type( $query ) {
		if ( ! isset( $_GET['post_type'] ) || 'fl-theme-layout' != $_GET['post_type'] ) {
			return;
		}

		$orderby = $query->get( 'orderby' );
		$order   = $query->get( 'order' );

		if ( $query->is_main_query() ) {
			if ( ! $orderby ) {
				$query->set( 'orderby', 'title' );
			} elseif ( 'fl_type' == $orderby ) {
				$query->set( 'meta_key', '_fl_theme_layout_type' );
				$query->set( 'orderby', 'meta_value' );
			}
			$query->set( 'order', ( $order ? $order : 'ASC' ) );
		}
	}

	static public function admin_enqueue_scripts() {
		global $pagenow;

		$screen = get_current_screen();

		if ( 'edit.php' === $pagenow && 'fl-theme-layout' == $screen->post_type ) {

			wp_enqueue_style( 'fl-pretty-checkbox', plugins_url( 'css/pretty-checkbox.css', FL_THEME_BUILDER_FILE ) );

			wp_enqueue_script( 'fl-theme-builder-lists', plugins_url( 'js/fl-theme-builder-template-list.js', FL_THEME_BUILDER_FILE ) );
			$args = array(
				'change_to_draft'   => __( 'Unpublish this layout', 'bb-theme-builder' ),
				'change_to_publish' => __( 'Publish this layout', 'bb-theme-builder' ),
				'nonce'             => wp_create_nonce( 'fl_builder_templates_status_nonce' ),
			);
			wp_localize_script( 'fl-theme-builder-lists', 'fl_builder_templates_status', $args );
		}
	}
	public static function switch_status() {

		check_admin_referer( 'fl_builder_templates_status_nonce' );

		$post_id = $_POST['id'];
		$status  = $_POST['status'];

		$old = get_post_status( $post_id );

		if ( $status !== $old ) {
			$args = array(
				'ID'          => $post_id,
				'post_status' => $status,
			);

			$result = wp_update_post( $args );
		}

		echo json_encode( $result );
		exit;
	}

	/**
	 * Adds or removes list table column headings.
	 *
	 * @since 1.0
	 * @param array $columns
	 * @return array
	 */
	static public function manage_column_headings( $columns ) {
		unset( $columns['date'] );

		$columns['fl_enabled']                            = __( 'Published', 'bb-theme-builder' );
		$columns['taxonomy-fl-builder-template-category'] = __( 'Categories', 'bb-theme-builder' );
		$columns['fl_type']                               = __( 'Type', 'bb-theme-builder' );
		$columns['fl_location']                           = __( 'Location', 'bb-theme-builder' );
		$columns['fl_user_rules']                         = __( 'Users', 'bb-theme-builder' );
		return $columns;
	}

	/**
	 * Adds layout type to the sortable columns.
	 *
	 * @since 1.0
	 * @param array $columns
	 * @return array
	 */
	static public function manage_sortable_columns( $columns ) {
		$columns['fl_type'] = 'fl_type';

		return $columns;
	}

	/**
	 * Adds the custom list table column content.
	 *
	 * @since 1.0
	 * @param array $columns
	 * @return array
	 */
	static public function manage_column_content( $column, $post_id ) {

		if ( 'fl_enabled' === $column ) {
			$status  = get_post_status( $post_id );
			$checked = 'publish' === $status ? ' checked' : '';
			printf( '<div class="pretty p-switch p-fill"><input type="checkbox"%s data-id=%s /><div class="state p-success"><label></label></div></div>', $checked, $post_id );
		}

		if ( 'fl_type' == $column ) {

			$type = get_post_meta( $post_id, '_fl_theme_layout_type', true );

			if ( is_string( $type ) ) {

				echo ucwords( $type );

				if ( ! FLThemeBuilderLayoutData::is_layout_supported( $post_id ) ) {
					echo ' <strong style="color:#a00;">(' . __( 'Unsupported', 'bb-theme-builder' ) . ')</strong>';
				}
			}
		}

		if ( 'fl_location' == $column ) {

			$saved_locations = FLThemeBuilderRulesLocation::get_ordered_saved( $post_id );

			foreach ( $saved_locations as $label => $saved_location ) {
				echo esc_html( $label ) . '<br />';
			}
		}

		if ( 'fl_user_rules' == $column ) {

			$user_rules = FLThemeBuilderRulesUser::get_ordered_saved( $post_id );

			if ( 0 === count( $user_rules ) ) {
				_e( 'All', 'bb-theme-builder' );
			} else {

				foreach ( $user_rules as $label => $user_rule ) {
					echo $label . '<br />';
				}
			}
		}
	}
}

FLThemeBuilderLayoutAdminList::init();
