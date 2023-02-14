<?php
global $wp_query, $post;

// Get the post and query.
$original_post = $post;

if ( is_object( $original_post ) && 0 === $original_post->ID && isset( $wp_query->post ) ) {
	$post = $wp_query->post;
}

$args                       = array();
$args['prev_text']          = ( 'prev' === $settings->navigation_link || 'both' === $settings->navigation_link ) ? $settings->prev_text : '';
$args['next_text']          = ( 'next' === $settings->navigation_link || 'both' === $settings->navigation_link ) ? $settings->next_text : '';
$args['in_same_term']       = ( '1' === $settings->in_same_term );
$args['excluded_terms']     = '';
$args['screen_reader_text'] = $settings->screen_reader_text;
$args['aria_label']         = $settings->aria_label;
$args['taxonomy']           = 'category';

if ( $args['in_same_term'] && ! empty( $settings->tax_select ) ) {
	$args['taxonomy'] = $settings->tax_select;
}

$args = apply_filters( 'fl_theme_builder_post_nav', $args );

if ( ! empty( $args['prev_text'] ) && ! empty( $args['next_text'] ) ) {
	the_post_navigation( $args );
} else {

	$previous = '';
	if ( ! empty( $args['prev_text'] ) ) {
		$previous = get_previous_post_link(
			'<div class="nav-previous">%link</div>',
			$args['prev_text'],
			$args['in_same_term'],
			$args['excluded_terms'],
			$args['taxonomy']
		);
	}

	$next = '';
	if ( ! empty( $args['next_text'] ) ) {
		$next = get_next_post_link(
			'<div class="nav-next">%link</div>',
			$args['next_text'],
			$args['in_same_term'],
			$args['excluded_terms'],
			$args['taxonomy']
		);
	}

	if ( ! empty( $previous ) || ! empty( $next ) ) {
		$nav_html  = '';
		$nav_html .= '<nav class="navigation post-navigation post-navigation-' . $settings->navigation_link . '"' . ' role="navigation" aria-label="' . $args['aria_label'] . '">';
		$nav_html .= '<h2 class="screen-reader-text">' . $args['screen_reader_text'] . '</h2>';
		$nav_html .= '<div class="nav-links">' . $previous . $next . '</div>';
		$nav_html .= '</nav>';
		echo $nav_html;
	}
}

// Reset the global post variable.
$post = $original_post;
