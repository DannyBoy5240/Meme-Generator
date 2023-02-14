<?php

/**
 * @since TBD
 * @class FLTheEventsCalendarCountdownModule
 */
class FLTheEventsCalendarCountdownModule extends FLBuilderModule {

	/**
	 * @since TBD
	 * @return void
	 */
	public function __construct() {
		parent::__construct(array(
			'name'            => __( 'Event Countdown', 'bb-theme-builder' ),
			'description'     => __( 'Displays a countdown timer for the current event.', 'bb-theme-builder' ),
			'group'           => __( 'Themer Modules', 'bb-theme-builder' ),
			'category'        => __( 'The Events Calendar', 'bb-theme-builder' ),
			'partial_refresh' => true,
			'dir'             => FL_THEME_BUILDER_THE_EVENTS_CALENDAR_DIR . 'modules/fl-the-events-calendar-countdown/',
			'url'             => FL_THEME_BUILDER_THE_EVENTS_CALENDAR_URL . 'modules/fl-the-events-calendar-countdown/',
			'enabled'         => FLThemeBuilderLayoutData::current_post_is( 'singular' ) && class_exists( 'Tribe__Events__Pro__Main' ),
		));
	}
}

FLBuilder::register_module( 'FLTheEventsCalendarCountdownModule', array(
	'general' => array(
		'title'    => __( 'Style', 'bb-theme-builder' ),
		'sections' => array(
			'general' => array(
				'title'  => '',
				'fields' => array(
					'align'        => array(
						'type'    => 'select',
						'label'   => __( 'Alignment', 'bb-theme-builder' ),
						'default' => 'left',
						'options' => array(
							'left'   => __( 'Left', 'bb-theme-builder' ),
							'center' => __( 'Center', 'bb-theme-builder' ),
							'right'  => __( 'Right', 'bb-theme-builder' ),
						),
					),
					'show_seconds' => array(
						'type'    => 'select',
						'label'   => __( 'Show Seconds', 'bb-theme-builder' ),
						'default' => '1',
						'options' => array(
							'1' => __( 'Yes', 'bb-theme-builder' ),
							'0' => __( 'No', 'bb-theme-builder' ),
						),
					),
				),
			),
		),
	),
) );
