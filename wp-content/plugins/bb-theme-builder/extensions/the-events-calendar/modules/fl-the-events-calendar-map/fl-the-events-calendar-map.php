<?php

/**
 * @since TBD
 * @class FLTheEventsCalendarMapModule
 */
class FLTheEventsCalendarMapModule extends FLBuilderModule {

	/**
	 * @since TBD
	 * @return void
	 */
	public function __construct() {
		parent::__construct(array(
			'name'            => __( 'Event Map', 'bb-theme-builder' ),
			'description'     => __( 'Displays the map for the current event.', 'bb-theme-builder' ),
			'group'           => __( 'Themer Modules', 'bb-theme-builder' ),
			'category'        => __( 'The Events Calendar', 'bb-theme-builder' ),
			'partial_refresh' => true,
			'dir'             => FL_THEME_BUILDER_THE_EVENTS_CALENDAR_DIR . 'modules/fl-the-events-calendar-map/',
			'url'             => FL_THEME_BUILDER_THE_EVENTS_CALENDAR_URL . 'modules/fl-the-events-calendar-map/',
			'enabled'         => FLThemeBuilderLayoutData::current_post_is( 'singular' ),
		));
	}

	/**
	 * Ensure backwards compatibility with old settings.
	 *
	 * @since TBD
	 * @param object $settings A module settings object.
	 * @param object $helper A settings compatibility helper.
	 * @return object
	 */
	public function filter_settings( $settings, $helper ) {

		// Convert Height (Text field) to Custom Height (Unit field).
		if ( ! empty( $settings->height ) && is_numeric( $settings->height ) ) {
			$settings->custom_height = $settings->height;
		}
		unset( $settings->height );

		return $settings;
	}
}

FLBuilder::register_module( 'FLTheEventsCalendarMapModule', array(
	'general' => array(
		'title'    => __( 'Style', 'bb-theme-builder' ),
		'sections' => array(
			'general' => array(
				'title'  => '',
				'fields' => array(
					'height_type'   => array(
						'type'    => 'select',
						'label'   => __( 'Height', 'bb-theme-builder' ),
						'default' => 'custom',
						'options' => array(
							'auto'   => __( 'Auto', 'bb-theme-builder' ),
							'custom' => __( 'Custom', 'bb-theme-builder' ),
						),
						'toggle'  => array(
							'custom' => array(
								'fields' => array( 'custom_height' ),
							),
						),
					),
					'custom_height' => array(
						'type'         => 'unit',
						'default'      => '350',
						'label'        => __( 'Custom Height', 'bb-theme-builder' ),
						'units'        => array( 'px' ),
						'default_unit' => 'px',
						'slider'       => array(
							'min'  => 0,
							'max'  => 2000,
							'step' => 10,
						),
					),
				),
			),
		),
	),
) );
