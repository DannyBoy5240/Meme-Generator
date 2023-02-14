<?php

/**
 * Handles logic for page data archive properties.
 *
 * @since 1.0
 */
final class FLPageDataArchive {

	/**
	 * @since 1.0
	 * @return string
	 */
	static public function get_title() {
		// Category
		if ( is_category() ) {
			$title = single_cat_title( '', false );
		} elseif ( is_tag() ) {
			$title = single_tag_title( '', false );
		} elseif ( is_tax() ) { // Taxonomy
			$title = single_term_title( '', false );
		} elseif ( is_author() ) { // Author
			$title = get_the_author_meta( 'display_name', get_query_var( 'author' ) );
		} elseif ( is_search() ) { // Search
			/* translators: %s: Search results title */
			$title = sprintf( _x( 'Search Results: %s', 'Search results title.', 'bb-theme-builder' ), get_search_query() );
		} elseif ( is_post_type_archive() ) { // Post Type
			$title = post_type_archive_title( '', false );
		} elseif ( is_home() ) { // Posts Archive
			$title = __( 'Posts', 'bb-theme-builder' );
		} else { // Everything else...
			$title = get_the_archive_title();
		}
		/**
		 * Filter the archive page title.
		 * @since 1.2.1
		 * @see fl_theme_builder_page_archive_get_title
		 */
		return apply_filters( 'fl_theme_builder_page_archive_get_title', $title );
	}

	/**
	 * @since 1.0
	 * @return string
	 */
	static public function get_term_meta( $settings ) {

		if ( empty( $settings->key ) ) {
			return '';
		}

		$term_id        = 0;
		$queried_object = get_queried_object();

		if ( is_object( $queried_object ) && isset( $queried_object->term_id ) ) {
			$term_id = $queried_object->term_id;
		}

		return get_term_meta( $term_id, $settings->key, true );
	}

	/**
	 * Show posts count
	 * @since 1.2
	 */
	static public function get_count() {
		global $wp_query;

		$query = $wp_query;

		// If we made it here it means we have a WP_Query with posts
		$paged      = ! empty( $query->query_vars['paged'] ) ? $query->query_vars['paged'] : 1;
		$prev_posts = ( $paged - 1 ) * $query->query_vars['posts_per_page'];
		$from       = number_format_i18n( 1 + $prev_posts );
		$to         = number_format_i18n( count( $query->posts ) + $prev_posts );
		$of         = number_format_i18n( $query->found_posts );

		// Return the information
		$showing = _x( 'Showing', 'Showing 1-5 of 25', 'bb-theme-builder' );
		$oftxt   = _x( 'of', 'Showing 1-5 of 25', 'bb-theme-builder' );
		return sprintf( '%s %s-%s %s %s.', $showing, $from, $to, $oftxt, $of );
	}

	/**
	 * Show pages count
	 * @since 1.2
	 */
	static public function get_page_count() {
		global $wp_query;

		$query = $wp_query;

		// If we made it here it means we have a WP_Query with posts
		$paged = ! empty( $query->query_vars['paged'] ) ? $query->query_vars['paged'] : 1;

		$total_pages = ceil( $query->found_posts / $query->query_vars['posts_per_page'] );
		// Return the information
		$page = _x( 'Page', 'Page 1 of 5', 'bb-theme-builder' );
		$of   = _x( 'of', 'Page 1 of 5', 'bb-theme-builder' );
		return sprintf( '%s %s %s %s.', $page, $paged, $of, $total_pages );
	}

	/**
	 * @since 1.3.3
	 * @return string
	 */
	static public function get_description() {
		$description = '';

		if ( is_tax( 'tribe_events_cat' ) ) {
			$description = term_description( get_queried_object_id(), 'tribe_events_cat' );
		} else {
			$description = get_the_archive_description();
		}

		return $description;
	}

}
