<?php

/**
 * Handles logic for The Events Calendar page data properties.
 *
 * @since TBD
 */
final class FLPageDataTheEventsCalendar {

	/**
	 * @since TBD
	 * @return string
	 */
	static public function init() {
		FLPageData::add_group( 'the-events-calendar', array(
			'label' => __( 'The Events Calendar', 'bb-theme-builder' ),
		) );
	}

	/**
	 * @since TBD
	 * @return string
	 */
	static public function start_date( $settings, $property ) {

		$format = isset( $settings->format ) ? $settings->format : false;
		if ( $format ) {
			return tribe_get_start_date( null, false, $format );
		} else {
			return tribe_get_start_date( null, false );
		}

	}

	/**
	 * @since TBD
	 * @return string
	 */
	static public function start_time() {
		$time_format = get_option( 'time_format', Tribe__Date_Utils::TIMEFORMAT );
		$event_time  = tribe_get_start_date( null, false, $time_format );

		if ( tribe_get_option( 'tribe_events_timezones_show_zone' ) ) {
			$event_id   = Tribe__Events__Main::postIdHelper();
			$event_time = Tribe__Events__Timezones::append_timezone( $event_time, $event_id );
		}
		return $event_time;
	}

	/**
	 * @since TBD
	 * @return string
	 */
	static public function end_date( $settings, $property ) {

		$format = isset( $settings->format ) ? $settings->format : false;
		if ( $format ) {
			return tribe_get_display_end_date( null, false, $format );
		} else {
			return tribe_get_display_end_date( null, false );
		}
	}

	/**
	 * @since TBD
	 * @return string
	 */
	static public function end_time() {
		$time_format = get_option( 'time_format', Tribe__Date_Utils::TIMEFORMAT );
		$event_time  = tribe_get_end_date( null, false, $time_format );

		if ( tribe_get_option( 'tribe_events_timezones_show_zone' ) ) {
			$event_id   = Tribe__Events__Main::postIdHelper();
			$event_time = Tribe__Events__Timezones::append_timezone( $event_time, $event_id );
		}

		return $event_time;
	}

	/**
	 * @since TBD
	 * @return string
	 */
	static public function organizer_url() {
		return get_permalink( tribe_get_organizer_id() );
	}

	/**
	 * @since TBD
	 * @return string
	 */
	static public function venue_url() {
		return get_permalink( tribe_get_venue_id() );
	}

	/*
	 * @since 1.3.1
	 * @return string
	 */
	static public function organizer_content() {
		$id = tribe_get_organizer_id();
		if ( $id ) {
			return apply_filters( 'the_content', get_the_content( null, false, $id ) );
		}
		return '';
	}

	/*
	 * @since 1.3.1
	 * @return string
	 */
	static public function venue_content() {
		$id = tribe_get_venue_id();
		if ( $id ) {
				return apply_filters( 'the_content', get_the_content( null, false, $id ) );
		}
		return '';
	}

	/**
	 * @since TBD
	 * @return string
	 */
	static public function field( $settings ) {
		$value = '';

		if ( ! empty( $settings->name ) ) {
			$fields = tribe_get_option( 'custom-fields', false );
			if ( is_array( $fields ) ) {
				foreach ( $fields as $field ) {
					if ( $settings->name === $field['label'] ) {
						$post_id = Tribe__Events__Main::postIdHelper();
						$value   = str_replace( '|', ', ', get_post_meta( $post_id, $field['name'], true ) );
					}
				}
			}
		}

		return $value;
	}

	/**
	 * @since TBD
	 * @return string
	 */
	static public function back_link() {
		return '<a href="' . tribe_get_events_link() . '">' . __( '&laquo; All Events', 'bb-theme-builder' ) . '</a>';
	}

	/**
	 * @since TBD
	 * @return string
	 */
	static public function event_cost( $settings ) {
		$show_currency = empty( $settings->show_currency ) ? false : wp_validate_boolean( $settings->show_currency );

		return tribe_get_cost( null, $show_currency );
	}
}

FLPageDataTheEventsCalendar::init();
