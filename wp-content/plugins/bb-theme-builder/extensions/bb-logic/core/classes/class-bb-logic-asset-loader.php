<?php

/**
 * Handles enqueuing css and js assets for the UI.
 *
 * @since 0.1
 */
final class BB_Logic_Asset_Loader {

	/**
	 * The slugs of rules to enqueue in the order
	 * they should be enqueued.
	 *
	 * @since 0.1
	 * @var array $rules
	 */
	static private $rules = array(
		'wordpress',
		'acf',
		'woocommerce',
		'behavior',
		'browser',
		'geolocation',
		'datetime',
	);

	/**
	 * Required rule classes.
	 *
	 * @since 0.1
	 * @var array $classes
	 */
	static private $classes = array(
		'acf'         => 'acf',
		'woocommerce' => 'WooCommerce',
	);

	/**
	 * Enqueue the necessary assets.
	 *
	 * @since  0.1
	 * @param array $rules
	 * @return void
	 */
	static public function enqueue( $rules = null ) {
		// Core
		wp_enqueue_style(
			'bb-logic-core',
			BB_LOGIC_URL . 'core/build/style.css',
			array(),
			BB_LOGIC_VERSION
		);

		wp_enqueue_script(
			'bb-logic-core',
			BB_LOGIC_URL . 'core/build/index.js',
			array(),
			BB_LOGIC_VERSION,
			true
		);

		// Rules
		foreach ( self::$rules as $rule ) {

			$url = BB_LOGIC_URL . "rules/$rule/build/index.js";
			$dir = BB_LOGIC_DIR . "rules/$rule/build/index.js";

			if ( isset( self::$classes[ $rule ] ) && ! class_exists( self::$classes[ $rule ] ) ) {
				continue;
			} elseif ( $rules && ! in_array( $rule, $rules ) ) {
				continue;
			} elseif ( ! file_exists( $dir ) ) {
				continue;
			}

			wp_enqueue_script(
				"bb-logic-rules-$rule",
				$url,
				array( 'bb-logic-core' ),
				BB_LOGIC_VERSION,
				true
			);
		}

		do_action( 'bb_logic_enqueue_scripts' );
	}
}
