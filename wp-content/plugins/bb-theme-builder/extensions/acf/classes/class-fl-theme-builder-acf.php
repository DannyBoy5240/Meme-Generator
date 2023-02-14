<?php

/**
 * ACF support for the theme builder.
 *
 * @since 1.1.1
 */
final class FLThemeBuilderACF {

	/**
	 * @since 1.1.1
	 * @return void
	 */
	static public function init() {

		// Actions
		add_action( 'fl_builder_loop_settings_after_form', __CLASS__ . '::loop_settings_acf_fields', 10 );

		// Filters
		add_filter( 'fl_builder_render_settings_field', __CLASS__ . '::render_settings_field', 10, 3 );
		add_filter( 'fl_builder_loop_query_args', __CLASS__ . '::loop_query_args' );
	}

	/**
	 * Adds the ACF relational as data source for posts module.
	 *
	 * @since 1.1.1
	 * @param array  $field
	 * @param string $name The field name.
	 * @param object $settings
	 * @return array
	 */
	static public function render_settings_field( $field, $name, $settings ) {
		if ( 'data_source' != $name ) {
			return $field;
		}

		$field['options']['acf_relationship'] = __( 'ACF Relationship', 'bb-theme-builder' );
		$field['toggle']['acf_relationship']  = array(
			'fields' => array( 'data_source_acf_relational_type', 'data_source_acf_relational_key', 'posts_per_page' ),
		);

		return $field;
	}

	/**
	 * Apply the ACF relational data into the loop query.
	 *
	 * @since 1.1.1
	 * @param array  $args
	 * @return array
	 */
	static public function loop_query_args( $args ) {
		$settings   = isset( $args['settings'] ) ? $args['settings'] : new stdClass();
		$object_ids = array();

		if ( ! isset( $settings->data_source ) || 'acf_relationship' != $settings->data_source ) {
			return $args;
		}

		if ( ! isset( $settings->data_source_acf_relational_key ) || empty( $settings->data_source_acf_relational_key ) ) {
			return $args;
		}

		$key      = false;
		$location = FLThemeBuilderRulesLocation::get_current_page_location();

		if ( $location['object'] ) {
			$parts = explode( ':', $location['object'] );
			if ( 3 === count( $parts ) && 'taxonomy' === $parts[0] ) {
				$key = $parts[1] . '_' . $parts[2];
			}
		}

		$object = get_field( trim( $settings->data_source_acf_relational_key ), $key );
		if ( is_int( $object ) && 'user' == $settings->data_source_acf_relational_type ) {
			$object = get_userdata( $object );
		}

		if ( $object ) {
			$rel_post_types = array();

			foreach ( $object as $obj ) {
				if ( is_object( $obj ) ) {
					if ( isset( $obj->ID ) ) {
						$object_ids[] = $obj->ID;
					}
					if ( isset( $obj->post_type ) ) {
						$rel_post_types[] = $obj->post_type;
					}
				} elseif ( is_array( $obj ) ) {
					if ( isset( $obj['ID'] ) ) {
						$object_ids[] = $obj['ID'];
					}
					if ( isset( $obj['post_type'] ) ) {
						$rel_post_types[] = $obj['post_type'];
					}
				} elseif ( is_int( $obj ) ) {
					$object_ids[]     = $obj;
					$rel_post_types[] = get_post_type( $obj );
				}
			}

			// Remove the unnecessary query args.
			unset( $args['tax_query'] );
			unset( $args['post__not_in'] );
			unset( $args['author__not_in'] );

			$args['post_type'] = array_unique( $rel_post_types );

			if ( 'relationship' == $settings->data_source_acf_relational_type ) {
				$args['post__in'] = $object_ids;

				if ( isset( $settings->data_source_acf_order_by ) ) {

					$args['orderby'] = $settings->data_source_acf_order_by;
					$args['order']   = $settings->data_source_acf_order;

					// Order by meta value arg.
					if ( strstr( $settings->data_source_acf_order_by, 'meta_value' ) ) {
						$args['meta_key'] = $settings->data_source_acf_order_by_meta_key;
					}

					// Order by author
					if ( 'author' === $settings->data_source_acf_order_by ) {
						$args['orderby'] = array(
							'author' => $args['order'],
							'date'   => $args['order'],
						);
					}
				} else {
					$args['orderby'] = 'post__in';
				}
			} elseif ( 'user' == $settings->data_source_acf_relational_type ) {
				$object_ids         = array_unique( $object_ids );
				$args['author__in'] = $object_ids;

				if ( isset( $settings->data_source_acf_post_type ) && is_array( $settings->data_source_acf_post_type ) ) {
					$args['post_type'] = $settings->data_source_acf_post_type;
				} else {
					$args['post_type'] = 'any';
				}
			}
		} else {
			// Reset query args so it doesn't display `post` post_type by default.
			$args = array();
		}

		return $args;
	}

	/**
	 * Adds ACF custom fields to loop settings for posts module.
	 *
	 * @since 1.1.1
	 * @param object $settings
	 * @return void
	 */
	static public function loop_settings_acf_fields( $settings ) {
		echo '<div class="fl-loop-data-source-acf fl-loop-data-source" data-source="acf_relationship">';
		echo '<table class="fl-form-table">';

			FLBuilder::render_settings_field('data_source_acf_relational_type', array(
				'type'    => 'select',
				'label'   => __( 'Type', 'bb-theme-builder' ),
				'default' => 'relationship',
				'options' => array(
					'relationship' => __( 'Relationship', 'bb-theme-builder' ),
					'user'         => __( 'User', 'bb-theme-builder' ),
				),
				'toggle'  => array(
					'relationship' => array(
						'fields' => array( 'data_source_acf_order', 'data_source_acf_order_by' ),
					),
					'user'         => array(
						'fields' => array( 'data_source_acf_post_type' ),
					),
				),
			), $settings);

			FLBuilder::render_settings_field('data_source_acf_relational_key', array(
				'type'  => 'text',
				'label' => __( 'Key', 'bb-theme-builder' ),
			), $settings);

			// Order
			FLBuilder::render_settings_field('data_source_acf_order', array(
				'type'    => 'select',
				'label'   => __( 'Order', 'bb-theme-builder' ),
				'options' => array(
					'DESC' => __( 'Descending', 'bb-theme-builder' ),
					'ASC'  => __( 'Ascending', 'bb-theme-builder' ),
				),
			), $settings);

			// Order by
			FLBuilder::render_settings_field('data_source_acf_order_by', array(
				'type'    => 'select',
				'label'   => __( 'Order By', 'bb-theme-builder' ),
				'default' => 'post__in',
				'options' => array(
					'author'         => __( 'Author', 'bb-theme-builder' ),
					'comment_count'  => __( 'Comment Count', 'bb-theme-builder' ),
					'date'           => __( 'Date', 'bb-theme-builder' ),
					'modified'       => __( 'Date Last Modified', 'bb-theme-builder' ),
					'ID'             => __( 'ID', 'bb-theme-builder' ),
					'menu_order'     => __( 'Menu Order', 'bb-theme-builder' ),
					'meta_value'     => __( 'Meta Value (Alphabetical)', 'bb-theme-builder' ),
					'meta_value_num' => __( 'Meta Value (Numeric)', 'bb-theme-builder' ),
					'rand'           => __( 'Random', 'bb-theme-builder' ),
					'title'          => __( 'Title', 'bb-theme-builder' ),
					'post__in'       => __( 'Selection Order', 'bb-theme-builder' ),
				),
				'toggle'  => array(
					'meta_value'     => array(
						'fields' => array( 'data_source_acf_order_by_meta_key' ),
					),
					'meta_value_num' => array(
						'fields' => array( 'data_source_acf_order_by_meta_key' ),
					),
				),
			), $settings);

			// Meta Key
			FLBuilder::render_settings_field('data_source_acf_order_by_meta_key', array(
				'type'  => 'text',
				'label' => __( 'Meta Key', 'bb-theme-builder' ),
			), $settings);

			// Post Type
			FLBuilder::render_settings_field('data_source_acf_post_type', array(
				'type'         => 'post-type',
				'multi-select' => true,
				'label'        => __( 'Post Type', 'bb-theme-builder' ),
				'help'         => __( 'By default all post types are included, If none of the options is selected.', 'bb-theme-builder' ),
			), $settings);

		echo '</table>';
		echo '</div>';
	}
}

FLThemeBuilderACF::init();
