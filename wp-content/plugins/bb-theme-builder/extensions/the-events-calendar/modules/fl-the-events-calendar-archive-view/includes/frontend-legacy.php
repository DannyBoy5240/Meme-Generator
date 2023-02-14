<?php

if ( is_post_type_archive( 'tribe_events' ) ) {

	tribe_events_before_html();

	$post = FLThemeBuilderRulesLocation::get_preview_original_post();

	if ( $post && 'fl-theme-layout' === $post->post_type ) {

		// When rendering via AJAX we need eventDate set or it throws an error.
		if ( defined( 'DOING_AJAX' ) ) {
			$_POST['eventDate'] = gmdate( 'Y-m' );
		}

		$view  = Tribe__Events__Main::instance()->default_view();
		$class = false;

		if ( 'list' === $view ) {
			$class = 'Tribe__Events__Template__List';
		} elseif ( 'month' === $view ) {
			$class = 'Tribe__Events__Template__Month';
		} elseif ( 'day' === $view ) {
			$class = 'Tribe__Events__Template__Day';
		} elseif ( defined( 'EVENTS_CALENDAR_PRO_FILE' ) ) {
			if ( 'week' === $view ) {
				$view  = 'pro/week/content';
				$class = 'Tribe__Events__Pro__Templates__Week';
			} elseif ( 'photo' === $view ) {
				$view  = 'pro/photo/content';
				$class = 'Tribe__Events__Pro__Templates__Week';
			} elseif ( 'map' === $view ) {
				$view  = 'pro/map/content';
				$class = 'Tribe__Events__Pro__Templates__Map';
			}
		}

		if ( ! $class ) {
			$view  = 'month';
			$class = 'Tribe__Events__Template__Month';
		}

		$template = new $class;
		$template->setup_view();
		tribe_get_template_part( $view );

	} else {
		tribe_get_view();
	}

	tribe_events_after_html();
}
