<?php

/**
 * Handles logic for adding theme layouts via the
 * user templates Add New form in the admin.
 *
 * @since 1.0
 */
final class FLThemeBuilderLayoutAdminAdd {

	/**
	 * Initializes actions and filters.
	 *
	 * @since 1.0
	 * @return void
	 */
	static public function init() {
		// Actions
		add_action( 'admin_enqueue_scripts', __CLASS__ . '::admin_enqueue_scripts' );
		add_action( 'fl_builder_user_templates_admin_add_form', __CLASS__ . '::render_fields' );
		add_action( 'fl_builder_user_templates_add_new_submit', __CLASS__ . '::submit', 10, 3 );

		// Filters
		add_filter( 'fl_builder_user_templates_add_new_config', __CLASS__ . '::filter_config' );
		add_filter( 'fl_builder_user_templates_add_new_types', __CLASS__ . '::filter_type_select' );
		add_filter( 'fl_builder_user_templates_add_new_post_type', __CLASS__ . '::filter_post_type', 10, 2 );
	}

	/**
	 * Renders additional css/js for the add new form.
	 *
	 * @since 1.0
	 * @return void
	 */
	static public function admin_enqueue_scripts() {
		$slug    = 'fl-theme-builder-layout-admin-add';
		$url     = FL_THEME_BUILDER_URL;
		$version = FL_THEME_BUILDER_VERSION;
		$page    = isset( $_GET['page'] ) ? $_GET['page'] : null;

		if ( 'fl-builder-add-new' == $page ) {
			wp_enqueue_script( $slug, $url . 'js/' . $slug . '.js', array(), $version, true );
		}
	}

	/**
	 * Renders additional fields for the add new form.
	 *
	 * @since 1.0
	 * @return void
	 */
	static public function render_fields() {
		$hooks   = FLThemeBuilderLayoutData::get_part_hooks();
		$headers = get_theme_support( 'fl-theme-builder-headers' );
		$footers = get_theme_support( 'fl-theme-builder-footers' );
		$parts   = get_theme_support( 'fl-theme-builder-parts' );

		include FL_THEME_BUILDER_DIR . 'includes/layout-admin-add-fields.php';
	}

	/**
	 * Additional logic for when the add new form is submitted.
	 *
	 * @since 1.0
	 * @param string $type
	 * @param string $title
	 * @param int    $post_id
	 * @return void
	 */
	static public function submit( $type, $title, $post_id ) {
		if ( 'theme-layout' == $type ) {

			$layout = sanitize_text_field( $_POST['fl-template']['theme-layout'] );

			update_post_meta( $post_id, '_fl_theme_layout_type', $layout );

			$file = FL_THEME_BUILDER_DIR . 'data/templates-' . $layout . '-default.dat';

			if ( file_exists( $file ) ) {

				$data = unserialize( file_get_contents( $file ) );

				if ( isset( $data[ $layout ] ) ) {
					$nodes = $data[ $layout ][0]->nodes;
				} else {
					$nodes = $data['layout'][0]->nodes;
				}

				$template = FLBuilderModel::generate_new_node_ids( $nodes );

				update_post_meta( $post_id, '_fl_builder_data', $template );
				update_post_meta( $post_id, '_fl_builder_draft', $template );
			}
		}
	}

	/**
	 * Adds theme layout data to the add new form JS config.
	 *
	 * @since 1.0
	 * @param array $config
	 * @return array
	 */
	static public function filter_config( $config ) {
		$action = __( 'Add', 'bb-theme-builder' );
		/* translators: %s: action like Add, Edit or View */
		$string = sprintf( _x( '%s Themer Layout', '%s is an action like Add, Edit or View.', 'bb-theme-builder' ), $action );

		$config['strings']['addButton']['theme-layout'] = $string;

		return $config;
	}

	/**
	 * Adds theme layouts to the type select.
	 *
	 * @since 1.0
	 * @param array $types
	 * @return array
	 */
	static public function filter_type_select( $types ) {
		$types[51] = array(
			'key'   => 'theme-layout',
			'label' => __( 'Themer Layout', 'bb-theme-builder' ),
		);

		ksort( $types );

		return $types;
	}

	/**
	 * Filters the post type for when the add new form creates
	 * the new post.
	 *
	 * @since 1.0
	 * @param string $post_type
	 * @return string
	 */
	static public function filter_post_type( $post_type, $template_type ) {
		if ( 'theme-layout' == $template_type ) {
			$post_type = 'fl-theme-layout';
		}

		return $post_type;
	}
}

FLThemeBuilderLayoutAdminAdd::init();
