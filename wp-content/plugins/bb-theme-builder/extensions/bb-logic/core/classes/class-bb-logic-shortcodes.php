<?php

/**
 * Handles processing of rule shortcodes.
 *
 * @since 0.1
 */
final class BB_Logic_Shortcodes {

	/**
	 * Init rule shortcodes.
	 *
	 * @since 0.1
	 * @return void
	 */
	static public function init() {
		add_shortcode( 'bb_logic', __CLASS__ . '::process' );
	}

	/**
	 * Processes a rule shortcode.
	 *
	 * @since 0.1
	 * @param array $attrs The shortcode attributes.
	 * @param string $content The content between the shortcode tags.
	 * @return string
	 */
	static public function process( $attrs, $content = '' ) {
		if ( isset( $attrs['type'] ) ) {
			return BB_Logic_Rules::process_rule( $attrs ) ? $content : '';
		}
		return $content;
	}
}

BB_Logic_Shortcodes::init();
