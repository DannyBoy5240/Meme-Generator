<?php

/**
 * @since TBD
 * @class FLTheEventsCalendarNoticesModule
 */
class FLTheEventsCalendarNoticesModule extends FLBuilderModule {

	/**
	 * @since TBD
	 * @return void
	 */
	public function __construct() {
		parent::__construct(array(
			'name'            => __( 'Event Notices', 'bb-theme-builder' ),
			'description'     => __( 'Displays any notices for the current event.', 'bb-theme-builder' ),
			'group'           => __( 'Themer Modules', 'bb-theme-builder' ),
			'category'        => __( 'The Events Calendar', 'bb-theme-builder' ),
			'partial_refresh' => true,
			'dir'             => FL_THEME_BUILDER_THE_EVENTS_CALENDAR_DIR . 'modules/fl-the-events-calendar-notices/',
			'url'             => FL_THEME_BUILDER_THE_EVENTS_CALENDAR_URL . 'modules/fl-the-events-calendar-notices/',
			'enabled'         => FLThemeBuilderLayoutData::current_post_is( 'singular' ),
		));
	}
}

FLBuilder::register_module( 'FLTheEventsCalendarNoticesModule', array(
	'general' => array(
		'title'    => __( 'Style', 'bb-theme-builder' ),
		'sections' => array(
			'general' => array(
				'title'  => '',
				'fields' => array(
					'text_color' => array(
						'type'       => 'color',
						'label'      => __( 'Text Color', 'bb-theme-builder' ),
						'show_reset' => true,
						'preview'    => array(
							'type'     => 'css',
							'selector' => '.fl-module-content .tribe-events-notices',
							'property' => 'color',
						),
					),
					'bg_color'   => array(
						'type'       => 'color',
						'label'      => __( 'Background Color', 'bb-theme-builder' ),
						'show_reset' => true,
						'preview'    => array(
							'type'     => 'css',
							'selector' => '.fl-module-content .tribe-events-notices',
							'property' => 'background-color',
						),
					),
				),
			),
		),
	),
) );
