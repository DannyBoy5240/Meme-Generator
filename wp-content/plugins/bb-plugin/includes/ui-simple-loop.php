<?php

// Default Settings
$defaults     = array(
	'post_type'      => 'post',
	'posts_per_page' => 5,
	'order_by'       => 'date',
	'order'          => 'DESC',
);
$tab_defaults = isset( $tab['defaults'] ) ? $tab['defaults'] : array();
$settings     = (object) array_merge( $defaults, $tab_defaults, (array) $settings );

?>

<div id="fl-builder-settings-section-post" class="fl-builder-settings-section">
	<div class="fl-builder-settings-section-header">
		<button class="fl-builder-settings-title">
			<svg class="fl-symbol">
				<use xlink:href="#fl-down-caret"></use>
			</svg>
			<?php _e( 'Post', 'fl-builder' ); ?>
		</button>
	</div>

	<div class="fl-builder-settings-section-content">
		<table class="fl-form-table">
			<tbody>
				<?php
				// Post type
				FLBuilder::render_settings_field('post_type', array(
					'type'      => 'post-type',
					'label'     => __( 'Post Type', 'fl-builder' ),
					'row_class' => 'fl-custom-query',
				), $settings);

				// Number of Posts
				FLBuilder::render_settings_field('posts_per_page', array(
					'type'   => 'unit',
					'label'  => __( 'Posts Per Page', 'fl-builder' ),
					'slider' => array(
						'min'  => 1,
						'max'  => 100,
						'step' => 1,
					),
				), $settings);

				// Order
				FLBuilder::render_settings_field('order', array(
					'type'    => 'select',
					'label'   => __( 'Order', 'fl-builder' ),
					'options' => array(
						'DESC' => __( 'Descending', 'fl-builder' ),
						'ASC'  => __( 'Ascending', 'fl-builder' ),
					),
				), $settings);

				// Order by
				FLBuilder::render_settings_field('order_by', array(
					'type'    => 'select',
					'label'   => __( 'Order By', 'fl-builder' ),
					'options' => array(
						'none'           => __( 'None', 'fl-builder' ),
						'ID'             => __( 'ID', 'fl-builder' ),
						'author'         => __( 'Author', 'fl-builder' ),
						'title'          => __( 'Title', 'fl-builder' ),
						'name'           => __( 'Name', 'fl-builder' ),
						'date'           => __( 'Date', 'fl-builder' ),
						'modified'       => __( 'Last Modified', 'fl-builder' ),
						'comment_count'  => __( 'Comment Count', 'fl-builder' ),
						'menu_order'     => __( 'Menu Order', 'fl-builder' ),
						'meta_value'     => __( 'Meta Value (Alphabetical)', 'fl-builder' ),
						'meta_value_num' => __( 'Meta Value (Numeric)', 'fl-builder' ),
						'rand'           => __( 'Random', 'fl-builder' ),
						'post__in'       => __( 'Selection Order', 'fl-builder' ),
					),
					'toggle'  => array(
						'meta_value'     => array(
							'fields' => array( 'order_by_meta_key' ),
						),
						'meta_value_num' => array(
							'fields' => array( 'order_by_meta_key' ),
						),
					),
				), $settings);

				// Meta Key
				FLBuilder::render_settings_field('order_by_meta_key', array(
					'type'  => 'text',
					'label' => __( 'Meta Key', 'fl-builder' ),
				), $settings);

				foreach ( FLBuilderLoop::post_types() as $slug => $type ) {
					// Posts
					FLBuilder::render_settings_field( 'posts_' . $slug, array(
						'type'      => 'suggest',
						'action'    => 'fl_as_posts',
						'data'      => $slug,
						/* translators: %s: type label */
						'label'     => sprintf( __( 'Filter by %1$s', 'fl-builder' ), $type->label ),
						/* translators: %s: type label */
						'help'      => sprintf( __( 'Enter a list of %1$s.', 'fl-builder' ), $type->label ),
						'matching'  => true,
						'row_class' => "fl-custom-query-filter fl-custom-query-{$slug}-filter",
					), $settings );

					// Taxonomies
					$taxonomies = FLBuilderLoop::taxonomies( $slug );

					$field_settings = new stdClass;
					foreach ( $settings as $k => $setting ) {
						if ( false !== strpos( $k, 'tax_' . $slug ) ) {
							$field_settings->$k = $setting;
						}
					}

					foreach ( $taxonomies as $tax_slug => $tax ) {
						$field_key = 'tax_' . $slug . '_' . $tax_slug;

						if ( isset( $settings->$field_key ) ) {
							$field_settings->$field_key = $settings->$field_key;
						}

						FLBuilder::render_settings_field( $field_key, array(
							'type'      => 'suggest',
							'action'    => 'fl_as_terms',
							'data'      => $tax_slug,
							/* translators: %s: tax label */
							'label'     => sprintf( __( 'Filter by %1$s', 'fl-builder' ), $tax->label ),
							/* translators: %s: tax label */
							'help'      => sprintf( __( 'Enter a list of %1$s.', 'fl-builder' ), $tax->label ),
							'matching'  => true,
							'row_class' => "fl-custom-query-filter fl-custom-query-{$slug}-filter",
						), $field_settings );
					}
				}
				?>
			</tbody>
		</table>
	</div>
</div>
