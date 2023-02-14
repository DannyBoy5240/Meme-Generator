<?php

/**
 * @since TBD
 * @class FLTheEventsCalendarExportLinksModule
 */
class FLTheEventsCalendarExportLinksModule extends FLBuilderModule {

	/**
	 * @since TBD
	 * @return void
	 */
	public function __construct() {
		parent::__construct(array(
			'name'            => __( 'Event Export Links', 'bb-theme-builder' ),
			'description'     => __( 'Displays links to export the current event to your calendar.', 'bb-theme-builder' ),
			'group'           => __( 'Themer Modules', 'bb-theme-builder' ),
			'category'        => __( 'The Events Calendar', 'bb-theme-builder' ),
			'partial_refresh' => true,
			'dir'             => FL_THEME_BUILDER_THE_EVENTS_CALENDAR_DIR . 'modules/fl-the-events-calendar-export-links/',
			'url'             => FL_THEME_BUILDER_THE_EVENTS_CALENDAR_URL . 'modules/fl-the-events-calendar-export-links/',
			'enabled'         => FLThemeBuilderLayoutData::current_post_is( 'singular' ),
		));
	}
}

FLBuilder::register_module( 'FLTheEventsCalendarExportLinksModule', array(
	'general' => array(
		'title'    => __( 'Style', 'bb-theme-builder' ),
		'sections' => array(
			'general' => array(
				'title'  => '',
				'fields' => array(
					'align'            => array(
						'type'    => 'select',
						'label'   => __( 'Alignment', 'bb-theme-builder' ),
						'default' => 'left',
						'options' => array(
							'left'   => __( 'Left', 'bb-theme-builder' ),
							'center' => __( 'Center', 'bb-theme-builder' ),
							'right'  => __( 'Right', 'bb-theme-builder' ),
						),
						'preview' => array(
							'type'     => 'css',
							'selector' => '.fl-module-content .tribe-events-cal-links',
							'property' => 'text-align',
						),
					),
					'text_color'       => array(
						'type'       => 'color',
						'label'      => __( 'Text Color', 'bb-theme-builder' ),
						'show_reset' => true,
						'preview'    => array(
							'type'     => 'css',
							'selector' => 'a.tribe-events-button',
							'property' => 'color',
						),
					),
					'bg_color'         => array(
						'type'       => 'color',
						'label'      => __( 'Background Color', 'bb-theme-builder' ),
						'show_reset' => true,
						'preview'    => array(
							'type'     => 'css',
							'selector' => 'a.tribe-events-button',
							'property' => 'background-color',
						),
					),
					'hover_text_color' => array(
						'type'       => 'color',
						'label'      => __( 'Hover Text Color', 'bb-theme-builder' ),
						'show_reset' => true,
						'preview'    => array(
							'type' => 'none',
						),
					),
					'hover_bg_color'   => array(
						'type'       => 'color',
						'label'      => __( 'Hover Background Color', 'bb-theme-builder' ),
						'show_reset' => true,
						'preview'    => array(
							'type' => 'none',
						),
					),

					'padding'          => array(
						'type'       => 'dimension',
						'label'      => __( 'Padding', 'bb-theme-builder' ),
						'default'    => '0',
						'responsive' => true,
						'slider'     => true,
						'units'      => array( 'px' ),
						'preview'    => array(
							'type'     => 'css',
							'selector' => 'a.tribe-events-button',
							'property' => 'padding',
						),
					),
					'border_radius'    => array(
						'type'        => 'text',
						'label'       => __( 'Border Radius', 'bb-theme-builder' ),
						'default'     => '0',
						'size'        => '5',
						'description' => 'px',
						'placeholder' => '0',
					),
				),
			),
		),
	),
) );
