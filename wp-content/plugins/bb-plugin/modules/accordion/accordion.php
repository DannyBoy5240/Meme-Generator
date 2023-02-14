<?php

/**
 * @class FLAccordionModule
 */
class FLAccordionModule extends FLBuilderModule {

	/**
	 * @method __construct
	 */
	public function __construct() {
		parent::__construct(array(
			'name'            => __( 'Accordion', 'fl-builder' ),
			'description'     => __( 'Display a collapsible accordion of items.', 'fl-builder' ),
			'category'        => __( 'Layout', 'fl-builder' ),
			'partial_refresh' => true,
			'icon'            => 'layout.svg',
		));

		$this->add_css( 'font-awesome-5' );
	}

	/**
	 * Ensure backwards compatibility with old settings.
	 *
	 * @since 2.2
	 * @param object $settings A module settings object.
	 * @param object $helper A settings compatibility helper.
	 * @return object
	 */
	public function filter_settings( $settings, $helper ) {
		if ( isset( $settings->border_color ) ) {
			$settings->item_border          = array();
			$settings->item_border['style'] = 'solid';
			$settings->item_border['color'] = $settings->border_color;
			$settings->item_border['width'] = array(
				'top'    => '1',
				'right'  => '1',
				'bottom' => '1',
				'left'   => '1',
			);
			unset( $settings->border_color );
		}

		// exclude current post
		$settings->exclude_self = 'yes';

		return $settings;
	}

	/**
	 * @method render_content
	 */
	public function render_content( $post_id ) {
		if ( FLBuilderModel::is_builder_enabled( $post_id ) ) {

			// Enqueue styles and scripts for the post.
			FLBuilder::enqueue_layout_styles_scripts_by_id( $post_id );

			// Print the styles if we are outside of the head tag.
			if ( did_action( 'wp_enqueue_scripts' ) && ! doing_filter( 'wp_enqueue_scripts' ) ) {
				wp_print_styles();
			}

			// Render the builder content.
			FLBuilder::render_content_by_id( $post_id );
		} else {
			// Render the WP editor content if the builder isn't enabled.
			echo apply_filters( 'the_content', get_the_content( null, false, $post_id ) );
		}
	}
}

/**
 * Register the module and its form settings.
 */
FLBuilder::register_module('FLAccordionModule', array(
	'items' => array(
		'title'    => __( 'Items', 'fl-builder' ),
		'sections' => array(
			'general' => array(
				'title'  => '',
				'fields' => array(
					'source' => array(
						'type'    => 'select',
						'label'   => __( 'Content Source', 'fl-builder' ),
						'default' => 'content',
						'options' => array(
							'post'    => __( 'Post', 'fl-builder' ),
							'content' => __( 'Custom Content', 'fl-builder' ),
						),
						'toggle'  => array(
							'post'    => array(
								'sections' => array( 'post' ),
							),
							'content' => array(
								'sections' => array( 'content' ),
								'fields'   => array( 'content_text_color', 'content_typography' ),
							),
						),
					),
				),
			),
			'post'    => array(
				'title' => __( 'Post', 'fl-builder' ),
				'file'  => FL_BUILDER_DIR . 'includes/ui-simple-loop.php',
			),
			'content' => array(
				'title'  => __( 'Custom Content', 'fl-builder' ),
				'fields' => array(
					'items' => array(
						'type'         => 'form',
						'label'        => __( 'Item', 'fl-builder' ),
						'form'         => 'accordion_items_form',
						'preview_text' => 'label',
						'multiple'     => true,
					),
				),
			),
			'display' => array(
				'title'  => __( 'Display', 'fl-builder' ),
				'fields' => array(
					'collapse'   => array(
						'type'    => 'select',
						'label'   => __( 'Collapse Inactive', 'fl-builder' ),
						'default' => '1',
						'options' => array(
							'1' => __( 'Yes', 'fl-builder' ),
							'0' => __( 'No', 'fl-builder' ),
						),
						'help'    => __( 'Choosing yes will keep only one item open at a time. Choosing no will allow multiple items to be open at the same time.', 'fl-builder' ),
						'preview' => array(
							'type' => 'none',
						),
					),
					'open_first' => array(
						'type'    => 'select',
						'label'   => __( 'Expand First Item', 'fl-builder' ),
						'default' => '0',
						'options' => array(
							'0' => __( 'No', 'fl-builder' ),
							'1' => __( 'Yes', 'fl-builder' ),
						),
						'help'    => __( 'Choosing yes will expand the first item by default.', 'fl-builder' ),
					),
				),
			),
		),
	),
	'style' => array(
		'title'    => __( 'Style', 'fl-builder' ),
		'sections' => array(
			'general' => array(
				'title'  => '',
				'fields' => array(
					'label_size'   => array(
						'type'    => 'select',
						'label'   => __( 'Item Size', 'fl-builder' ),
						'default' => 'small',
						'options' => array(
							'small'  => _x( 'Small', 'Label size.', 'fl-builder' ),
							'medium' => _x( 'Medium', 'Label size.', 'fl-builder' ),
							'large'  => _x( 'Large', 'Label size.', 'fl-builder' ),
						),
						'preview' => array(
							'type' => 'none',
						),
					),
					'item_spacing' => array(
						'type'       => 'unit',
						'label'      => __( 'Item Spacing', 'fl-builder' ),
						'default'    => '10',
						'responsive' => true,
						'slider'     => true,
						'units'      => array( 'px' ),
						'preview'    => array(
							'type'     => 'css',
							'selector' => '.fl-accordion-item',
							'property' => 'margin-bottom',
							'unit'     => 'px',
						),
					),
					'item_border'  => array(
						'type'       => 'border',
						'label'      => __( 'Item Border', 'fl-builder' ),
						'responsive' => true,
						'default'    => array(
							'style' => 'solid',
							'color' => 'e5e5e5',
							'width' => array(
								'top'    => '1',
								'right'  => '1',
								'bottom' => '1',
								'left'   => '1',
							),
						),
						'preview'    => array(
							'type'     => 'css',
							'selector' => '.fl-accordion-item',
						),
					),
				),
			),
			'label'   => array(
				'title'  => __( 'Label', 'fl-builder' ),
				'fields' => array(
					'label_text_color' => array(
						'type'        => 'color',
						'connections' => array( 'color' ),
						'label'       => __( 'Text Color', 'fl-builder' ),
						'show_reset'  => true,
						'show_alpha'  => true,
						'preview'     => array(
							'type'     => 'css',
							'selector' => '.fl-accordion-button',
							'property' => 'color',
						),
					),
					'label_bg_color'   => array(
						'type'        => 'color',
						'connections' => array( 'color' ),
						'label'       => __( 'Background Color', 'fl-builder' ),
						'show_reset'  => true,
						'show_alpha'  => true,
						'preview'     => array(
							'type'     => 'css',
							'selector' => '.fl-accordion-button',
							'property' => 'background-color',
						),
					),
					'label_padding'    => array(
						'type'       => 'dimension',
						'label'      => __( 'Padding', 'fl-builder' ),
						'responsive' => true,
						'slider'     => true,
						'units'      => array(
							'px',
							'em',
							'%',
						),
						'preview'    => array(
							'type'     => 'css',
							'selector' => '.fl-accordion-button',
							'property' => 'padding',
						),
					),
					'label_typography' => array(
						'type'       => 'typography',
						'label'      => __( 'Typography', 'fl-builder' ),
						'responsive' => true,
						'preview'    => array(
							'type'      => 'css',
							'selector'  => '.fl-accordion-button, .fl-accordion-button-label',
							'important' => true,
						),
					),
				),
			),
			'icon'    => array(
				'title'  => __( 'Icon', 'fl-builder' ),
				'fields' => array(
					'label_icon_position' => array(
						'type'    => 'select',
						'label'   => __( 'Icon Position', 'fl-builder' ),
						'default' => 'right',
						'options' => array(
							'left'  => __( 'Left', 'fl-builder' ),
							'right' => __( 'Right', 'fl-builder' ),
						),
					),
					'label_icon'          => array(
						'type'    => 'icon',
						'label'   => __( 'Icon', 'fl-builder' ),
						'default' => 'fas fa-plus',
					),
					'label_active_icon'   => array(
						'type'    => 'icon',
						'label'   => __( 'Active Icon', 'fl-builder' ),
						'default' => 'fas fa-minus',
					),
					'duo_color1'          => array(
						'label'      => __( 'DuoTone Icon Primary Color', 'fl-builder' ),
						'type'       => 'color',
						'default'    => '',
						'show_reset' => true,
						'preview'    => array(
							'type'      => 'css',
							'selector'  => '.fl-accordion-button-icon i.fad:before',
							'property'  => 'color',
							'important' => true,
						),
					),
					'duo_color2'          => array(
						'label'      => __( 'DuoTone Icon Secondary Color', 'fl-builder' ),
						'type'       => 'color',
						'default'    => '',
						'show_reset' => true,
						'preview'    => array(
							'type'      => 'css',
							'selector'  => '.fl-accordion-button-icon i.fad:after',
							'property'  => 'color',
							'important' => true,
						),
					),
				),
			),
			'content' => array(
				'title'  => __( 'Content', 'fl-builder' ),
				'fields' => array(
					'content_text_color' => array(
						'type'        => 'color',
						'connections' => array( 'color' ),
						'label'       => __( 'Text Color', 'fl-builder' ),
						'show_reset'  => true,
						'show_alpha'  => true,
						'preview'     => array(
							'type'     => 'css',
							'selector' => '.fl-accordion-content',
							'property' => 'color',
						),
					),
					'content_bg_color'   => array(
						'type'        => 'color',
						'connections' => array( 'color' ),
						'label'       => __( 'Background Color', 'fl-builder' ),
						'show_reset'  => true,
						'show_alpha'  => true,
						'preview'     => array(
							'type'     => 'css',
							'selector' => '.fl-accordion-content',
							'property' => 'background-color',
						),
					),
					'content_padding'    => array(
						'type'       => 'dimension',
						'label'      => __( 'Padding', 'fl-builder' ),
						'responsive' => true,
						'slider'     => true,
						'units'      => array(
							'px',
							'em',
							'%',
						),
						'preview'    => array(
							'type'     => 'css',
							'selector' => '.fl-accordion-content',
							'property' => 'padding',
						),
					),
					'content_typography' => array(
						'type'       => 'typography',
						'label'      => __( 'Typography', 'fl-builder' ),
						'responsive' => true,
						'preview'    => array(
							'type'      => 'css',
							'selector'  => '.fl-accordion-content',
							'important' => true,
						),
					),
				),
			),
		),
	),
));

/**
 * Register a settings form to use in the "form" field type above.
 */
FLBuilder::register_settings_form('accordion_items_form', array(
	'title' => __( 'Add Item', 'fl-builder' ),
	'tabs'  => array(
		'general' => array(
			'title'    => __( 'General', 'fl-builder' ),
			'sections' => array(
				'general'      => array(
					'title'  => '',
					'fields' => array(
						'label' => array(
							'type'        => 'text',
							'label'       => __( 'Label', 'fl-builder' ),
							'connections' => array( 'string' ),
						),
					),
				),
				'content_type' => array(
					'title'  => __( 'Content Type', 'fl-builder' ),
					'fields' => array(
						'saved_layout'   => array(
							'type'    => 'select',
							'label'   => __( 'Type', 'fl-builder' ),
							'default' => 'none',
							'help'    => __( 'This setting allows you to show saved layout in the slide.', 'fl-builder' ),
							'options' => array(
								'row'      => __( 'Saved Row', 'fl-builder' ),
								'column'   => __( 'Saved Column', 'fl-builder' ),
								'module'   => __( 'Saved Module', 'fl-builder' ),
								'template' => __( 'Saved Template', 'fl-builder' ),
								'none'     => __( 'Custom Content', 'fl-builder' ),
							),
							'toggle'  => array(
								'none'     => array(
									'sections' => array( 'content' ),
								),
								'row'      => array(
									'fields' => array( 'saved_row' ),
								),
								'column'   => array(
									'fields' => array( 'saved_column' ),
								),
								'module'   => array(
									'fields' => array( 'saved_module' ),
								),
								'template' => array(
									'fields' => array( 'saved_template' ),
								),
							),
						),
						'saved_row'      => array(
							'type'       => 'select',
							'label'      => __( 'Select Row', 'fl-builder' ),
							'saved_data' => 'row',
						),
						'saved_column'   => array(
							'type'       => 'select',
							'label'      => __( 'Select Column', 'fl-builder' ),
							'saved_data' => 'column',
						),
						'saved_module'   => array(
							'type'       => 'select',
							'label'      => __( 'Select Modules', 'fl-builder' ),
							'saved_data' => 'module',
						),
						'saved_template' => array(
							'type'       => 'select',
							'label'      => __( 'Select Template', 'fl-builder' ),
							'saved_data' => 'layout',
						),
					),
				),
				'content'      => array(
					'title'  => __( 'Content', 'fl-builder' ),
					'fields' => array(
						'content' => array(
							'type'        => 'editor',
							'label'       => '',
							'wpautop'     => false,
							'connections' => array( 'string' ),
						),
					),
				),
			),
		),
	),
));
