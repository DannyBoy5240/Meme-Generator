<?php

/**
 * @class FLIconGroupModule
 */
class FLIconGroupModule extends FLBuilderModule {

	/**
	 * @method __construct
	 */
	public function __construct() {
		parent::__construct(array(
			'name'            => __( 'Icon Group', 'fl-builder' ),
			'description'     => __( 'Display a group of linked Font Awesome icons.', 'fl-builder' ),
			'category'        => __( 'Media', 'fl-builder' ),
			'editor_export'   => false,
			'partial_refresh' => true,
			'icon'            => 'star-filled.svg',
		));
	}

	/**
	 * Ensure backwards compatibility with old settings.
	 *
	 * @param object $settings A module settings object.
	 * @param object $helper A settings compatibility helper.
	 * @return object
	 */
	public function filter_settings( $settings, $helper ) {

		$icons_count = count( $settings->icons );
		for ( $i = 0; $i < $icons_count; $i++ ) {

			if ( ! is_object( $settings->icons[ $i ] ) ) {
				continue;
			}

			// Rename 'color' to 'item_icon_color'
			if ( empty( $icon->item_icon_color ) && ! empty( $settings->icons[ $i ]->color ) ) {
				$settings->icons[ $i ]->item_icon_color = $settings->icons[ $i ]->color;
				unset( $settings->icons[ $i ]->color );
			}

			// Rename 'bg_color' to 'item_icon_bg_color'
			if ( empty( $icon->item_icon_bg_color ) && ! empty( $settings->icons[ $i ]->bg_color ) ) {
				$settings->icons[ $i ]->item_icon_bg_color = $settings->icons[ $i ]->bg_color;
				unset( $settings->icons[ $i ]->bg_color );
			}
		}

		return $settings;
	}

}

/**
 * Register the module and its form settings.
 */
FLBuilder::register_module('FLIconGroupModule', array(
	'icons' => array(
		'title'    => __( 'Icons', 'fl-builder' ),
		'sections' => array(
			'general' => array(
				'title'  => '',
				'fields' => array(
					'icons' => array(
						'type'         => 'form',
						'label'        => __( 'Icon', 'fl-builder' ),
						'form'         => 'icon_group_form', // ID from registered form below
						'preview_text' => 'icon', // Name of a field to use for the preview text
						'multiple'     => true,
					),
				),
			),
		),
	),
	'style' => array( // Tab
		'title'    => __( 'Style', 'fl-builder' ), // Tab title
		'sections' => array( // Tab Sections
			'structure' => array( // Section
				'title'  => __( 'Icon', 'fl-builder' ), // Section Title
				'fields' => array( // Section Fields
					'size'    => array(
						'type'       => 'unit',
						'label'      => __( 'Size', 'fl-builder' ),
						'default'    => '30',
						'sanitize'   => 'floatval',
						'responsive' => true,
						'units'      => array( 'px', 'em', 'rem' ),
						'slider'     => true,
						'preview'    => array(
							'type' => 'refresh',
						),
					),
					'spacing' => array(
						'type'       => 'unit',
						'label'      => __( 'Spacing', 'fl-builder' ),
						'default'    => '10',
						'sanitize'   => 'absint',
						'units'      => array( 'px', 'pt', '%' ),
						'responsive' => true,
						'slider'     => true,
						'preview'    => array(
							'type'     => 'css',
							'selector' => '{node} .fl-icon + .fl-icon',
							'property' => 'margin-left',
						),
					),
					'align'   => array(
						'type'       => 'align',
						'label'      => __( 'Alignment', 'fl-builder' ),
						'default'    => 'center',
						'responsive' => true,
						'preview'    => array(
							'type'     => 'css',
							'selector' => '.fl-icon-group',
							'property' => 'text-align',
						),
					),
				),
			),
			'colors'    => array( // Section
				'title'  => __( 'Icon Colors', 'fl-builder' ), // Section Title
				'fields' => array( // Section Fields
					'color'          => array(
						'type'        => 'color',
						'connections' => array( 'color' ),
						'label'       => __( 'Color', 'fl-builder' ),
						'show_reset'  => true,
						'show_alpha'  => true,
						'preview'     => array(
							'type' => 'refresh',
						),
					),
					'hover_color'    => array(
						'type'        => 'color',
						'connections' => array( 'color' ),
						'label'       => __( 'Hover Color', 'fl-builder' ),
						'show_reset'  => true,
						'show_alpha'  => true,
						'preview'     => array(
							'type'      => 'css',
							'selector'  => '.fl-icon i:hover, .fl-icon i:hover::before',
							'property'  => 'color',
							'important' => true,
						),
					),
					'bg_color'       => array(
						'type'        => 'color',
						'connections' => array( 'color' ),
						'label'       => __( 'Background Color', 'fl-builder' ),
						'show_reset'  => true,
						'show_alpha'  => true,
					),
					'bg_hover_color' => array(
						'type'        => 'color',
						'connections' => array( 'color' ),
						'label'       => __( 'Background Hover Color', 'fl-builder' ),
						'show_reset'  => true,
						'show_alpha'  => true,
						'preview'     => array(
							'type' => 'none',
						),
					),
					'three_d'        => array(
						'type'    => 'select',
						'label'   => __( 'Gradient', 'fl-builder' ),
						'default' => '0',
						'options' => array(
							'0' => __( 'No', 'fl-builder' ),
							'1' => __( 'Yes', 'fl-builder' ),
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
FLBuilder::register_settings_form('icon_group_form', array(
	'title' => __( 'Add Icon', 'fl-builder' ),
	'tabs'  => array(
		'general' => array( // Tab
			'title'    => __( 'General', 'fl-builder' ), // Tab title
			'sections' => array( // Tab Sections
				'general' => array( // Section
					'title'  => '', // Section Title
					'fields' => array( // Section Fields
						'icon'    => array(
							'type'  => 'icon',
							'label' => __( 'Icon', 'fl-builder' ),
						),
						'link'    => array(
							'type'          => 'link',
							'label'         => __( 'Link', 'fl-builder' ),
							'show_target'   => true,
							'show_nofollow' => true,
						),
						'sr_text' => array(
							'type'    => 'text',
							'label'   => __( 'Screen Reader Text', 'fl-builder' ),
							'default' => '',
						),
					),
				),
			),
		),
		'style'   => array( // Tab
			'title'    => __( 'Style', 'fl-builder' ), // Tab title
			'sections' => array( // Tab Sections
				'colors' => array( // Section
					'title'  => __( 'Item Icon Colors', 'fl-builder' ), // Section Title
					'fields' => array( // Section Fields
						'duo_color1'         => array(
							'label'      => __( 'DuoTone Primary Color', 'fl-builder' ),
							'type'       => 'color',
							'default'    => '',
							'show_alpha' => true,
							'show_reset' => true,
							'preview'    => array(
								'type' => 'none',
							),
						),
						'duo_color2'         => array(
							'label'      => __( 'DuoTone Secondary Color', 'fl-builder' ),
							'type'       => 'color',
							'default'    => '',
							'show_alpha' => true,
							'show_reset' => true,
							'preview'    => array(
								'type' => 'none',
							),
						),
						'item_icon_color'    => array(
							'type'        => 'color',
							'connections' => array( 'color' ),
							'label'       => __( 'Item Icon Color', 'fl-builder' ),
							'show_reset'  => true,
							'show_alpha'  => true,
						),
						'hover_color'        => array(
							'type'        => 'color',
							'connections' => array( 'color' ),
							'label'       => __( 'Item Icon Hover Color', 'fl-builder' ),
							'show_reset'  => true,
							'show_alpha'  => true,
							'preview'     => array(
								'type' => 'none',
							),
						),
						'item_icon_bg_color' => array(
							'type'        => 'color',
							'connections' => array( 'color' ),
							'label'       => __( 'Item Icon Background Color', 'fl-builder' ),
							'show_reset'  => true,
							'show_alpha'  => true,
						),
						'bg_hover_color'     => array(
							'type'        => 'color',
							'connections' => array( 'color' ),
							'label'       => __( 'Item Icon Background Hover Color', 'fl-builder' ),
							'show_reset'  => true,
							'show_alpha'  => true,
							'preview'     => array(
								'type' => 'none',
							),
						),
					),
				),
			),
		),
	),
));
