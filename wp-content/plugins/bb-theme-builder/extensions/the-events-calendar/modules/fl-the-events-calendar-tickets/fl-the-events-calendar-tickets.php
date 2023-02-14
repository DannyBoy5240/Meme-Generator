<?php

/**
 * @since TBD
 * @class FLTheEventsCalendarTicketsModule
 */
class FLTheEventsCalendarTicketsModule extends FLBuilderModule {

	/**
	 * @since TBD
	 * @return void
	 */
	public function __construct() {
		parent::__construct(array(
			'name'            => __( 'Event Tickets', 'bb-theme-builder' ),
			'description'     => __( 'Displays the ticket form and info for the current event.', 'bb-theme-builder' ),
			'group'           => __( 'Themer Modules', 'bb-theme-builder' ),
			'category'        => __( 'The Events Calendar', 'bb-theme-builder' ),
			'partial_refresh' => true,
			'dir'             => FL_THEME_BUILDER_THE_EVENTS_CALENDAR_DIR . 'modules/fl-the-events-calendar-tickets/',
			'url'             => FL_THEME_BUILDER_THE_EVENTS_CALENDAR_URL . 'modules/fl-the-events-calendar-tickets/',
			'enabled'         => FLThemeBuilderLayoutData::current_post_is( 'singular' ) && class_exists( 'Tribe__Tickets__RSVP' ),
		));
	}
}

FLBuilder::register_module( 'FLTheEventsCalendarTicketsModule', array(
	'style' => array(
		'title'    => __( 'Style', 'bb-theme-builder' ),
		'sections' => array(
			'general' => array(
				'title'  => '',
				'fields' => array(
					'bg_color'   => array(
						'type'       => 'color',
						'label'      => __( 'Background Color', 'bb-theme-builder' ),
						'show_reset' => true,
						'preview'    => array(
							'type'     => 'css',
							'property' => 'background-color',
							'selector' => '.tribe-common',
						),
					),
					'text_color' => array(
						'type'       => 'color',
						'label'      => __( 'Text Color', 'bb-theme-builder' ),
						'show_reset' => true,
					),
					'sep_color'  => array(
						'type'       => 'color',
						'label'      => __( 'Separator Color', 'bb-theme-builder' ),
						'show_reset' => true,
						'preview'    => array(
							'type'     => 'css',
							'property' => 'border-top-color',
							'selector' => '.tribe-common .tribe-tickets__item, .tribe-common .tribe-tickets__footer',
						),
					),
				),
			),
			'button'  => array(
				'title'  => __( 'Button', 'bb-theme-builder' ),
				'fields' => array(
					'btn_bg_color'            => array(
						'type'       => 'color',
						'label'      => __( 'Active Button Background Color', 'bb-theme-builder' ),
						'show_reset' => true,
					),
					'btn_text_color'          => array(
						'type'       => 'color',
						'label'      => __( 'Active Button Text Color', 'bb-theme-builder' ),
						'show_reset' => true,
					),
					'disabled_btn_bg_color'   => array(
						'type'       => 'color',
						'label'      => __( 'Disabled Button Background Color', 'bb-theme-builder' ),
						'show_reset' => true,
						'preview'    => array(
							'type'     => 'css',
							'property' => 'background-color',
							'selector' => '.tribe-common .tribe-tickets__footer button[disabled=disabled]',
						),
					),
					'disabled_btn_text_color' => array(
						'type'       => 'color',
						'label'      => __( 'Disabled Button Text Color', 'bb-theme-builder' ),
						'show_reset' => true,
						'preview'    => array(
							'type'     => 'css',
							'property' => 'color',
							'selector' => '.tribe-common .tribe-tickets__footer button[disabled=disabled]',
						),
					),
				),
			),
		),
	),
) );
