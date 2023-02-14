<?php

/**
 * The Events Calendar singular support for the theme builder.
 *
 * @since TBD
 */
final class FLThemeBuilderTheEventsCalendarSingular {

	/**
	 * The post type of the singular event layout being displayed.
	 *
	 * @since TBD
	 * @var string $post_type
	 */
	static public $post_type = null;

	/**
	 * @since TBD
	 * @return void
	 */
	static public function init() {
		add_action( 'wp', __CLASS__ . '::init_hooks' );
	}

	/**
	 * @since TBD
	 * @return void
	 */
	static public function init_hooks() {
		global $wp_the_query;

		if ( ! is_singular() ) {
			return;
		}

		$location             = FLThemeBuilderRulesLocation::get_preview_location( get_the_ID() );
		$post_type            = $wp_the_query->post->post_type;
		$is_theme_layout      = 'fl-theme-layout' === get_post_type();
		$is_event_preview     = stristr( $location, 'post:tribe_events' );
		$is_single_event      = 'tribe_events' === $post_type || ( $is_event_preview && $is_theme_layout );
		$is_organizer_preview = stristr( $location, 'post:tribe_organizer' );
		$is_single_organizer  = 'tribe_organizer' === $post_type || ( $is_organizer_preview && $is_theme_layout );
		$is_venue_preview     = stristr( $location, 'post:tribe_venue' );
		$is_single_venue      = 'tribe_venue' === $post_type || ( $is_venue_preview && $is_theme_layout );

		if ( $is_single_event || $is_single_organizer || $is_single_venue ) {
			/* Post Type */
			if ( $is_single_event ) {
				self::$post_type = 'tribe_events';
			} elseif ( $is_single_organizer ) {
				self::$post_type = 'tribe_organizer';
			} elseif ( $is_single_venue ) {
				self::$post_type = 'tribe_venue';
			}

			/* Actions */
			add_action( 'fl_theme_builder_before_render_content', __CLASS__ . '::before_render_content' );
			add_action( 'fl_theme_builder_after_render_content', __CLASS__ . '::after_render_content' );

			/* Filters */
			add_filter( 'fl_builder_render_css', __CLASS__ . '::render_css', 10, 4 );
			add_filter( 'body_class', __CLASS__ . '::body_class' );
			add_filter( 'fl_theme_builder_content_attrs', __CLASS__ . '::content_attrs' );
			add_filter( 'fl_builder_content_classes', __CLASS__ . '::content_classes', 10, 2 );

			if ( $is_single_event ) {
				add_filter( 'tribe_events_views_v2_assets_should_enqueue_frontend', '__return_true' );
			}
		} elseif ( 'general:none' === $location ) {
			tribe_asset_enqueue( 'tribe-events-views-v2-full' );
		}

		$themer_location = FLThemeBuilderLayoutData::get_current_page_layouts();

		if ( isset( $themer_location['singular'] ) ) {
			add_filter( 'tribe_events_views_v2_should_hijack_page_template', '__return_false' );
		}

		if ( $is_single_organizer || $is_single_venue ) {
			add_filter( 'fl_builder_loop_query', __CLASS__ . '::builder_loop_query', 10, 2 );
		}
	}

	/**
	 * Renders custom CSS for singular WooCommerce pages.
	 *
	 * @since 1.0
	 * @param string $css
	 * @param array  $nodes
	 * @param object $settings
	 * @param bool   $global
	 * @return string
	 */
	static public function render_css( $css, $nodes, $settings, $global ) {
		if ( $global ) {
			$css .= file_get_contents( FL_THEME_BUILDER_THE_EVENTS_CALENDAR_DIR . 'css/singular.css' );
		}

		return $css;
	}

	/**
	 * Adds the events body classes to theme layouts that are
	 * set to event locations.
	 *
	 * @since TBD
	 * @param array $classes
	 * @return array
	 */
	static public function body_class( $classes ) {
		$classes[] = 'single-' . self::$post_type;
		return $classes;
	}

	/**
	 * Adds event markup before the builder content.
	 *
	 * @since TBD
	 * @return void
	 */
	static public function before_render_content() {

		// For some reason the global $post is incorrect on event pages
		// even without Themer. This is a hack to fix that. Hopefully
		// it can be removed in future versions.
		global $wp_the_query;
		global $post;
		$post = $wp_the_query->post;

		do_action( 'tribe_events_before_view' );

		// Remove the AJAX loader on the Organizer page.
		if ( 'tribe_organizer' == self::$post_type || 'tribe_venue' == self::$post_type ) {
			return;
		}

		tribe_events_before_html();
	}

	/**
	 * Adds event markup after the builder content.
	 *
	 * @since TBD
	 * @return void
	 */
	static public function after_render_content() {
		tribe_events_after_html();
		do_action( 'tribe_events_after_view' );
	}

	/**
	 * Adds classes to the content wrapper for events.
	 *
	 * @since TBD
	 * @param string $classes
	 * @param string $layout_type
	 * @return string
	 */
	static public function content_classes( $classes, $layout_type = '' ) {

		if ( 'tribe_events' === self::$post_type && empty( $layout_type ) ) {
			$classes = join( ' ', get_post_class( $classes . ' tribe-events-single' ) );
		} elseif ( 'tribe_organizer' === self::$post_type ) {
			$classes .= ' tribe-events-organizer';
		} elseif ( 'tribe_venue' === self::$post_type ) {
			$classes .= ' tribe-events-venue';
		}

		return $classes;
	}

	/**
	 * Adds attributes to the content wrapper for events.
	 *
	 * @since TBD
	 * @param array $attrs
	 * @return array
	 */
	static public function content_attrs( $attrs ) {
		$attrs['id'] = 'tribe-events-content';
		return $attrs;
	}

	/**
	 * Sets the loop query for organizer and venue post modules
	 * to pull events for the current organizer or venue.
	 *
	 * @since TBD
	 * @param object $query
	 * @param object $settings
	 * @return object
	 */
	static public function builder_loop_query( $query, $settings ) {

		if ( isset( $settings->data_source ) && 'main_query' == $settings->data_source ) {

			$args = array(
				'eventDisplay'   => 'list',
				'posts_per_page' => $query->query_vars['posts_per_page'],
			);

			if ( 'tribe_organizer' === get_post_type() ) {
				$args['organizer'] = get_the_ID();
			} else {
				$args['venue'] = get_the_ID();
			}

			$query = Tribe__Events__Query::getEvents( $args, true );
		}

		return $query;
	}
}

FLThemeBuilderTheEventsCalendarSingular::init();
