<?php

/**
 * Server side processing for browser rules.
 *
 * @since 0.1
 */
final class BB_Logic_Rules_Browser {

	/**
	 * Sets up callbacks for conditional logic rules.
	 *
	 * @since  0.1
	 * @return void
	 */
	static public function init() {
		BB_Logic_Rules::register( array(
			'browser/cookie'       => __CLASS__ . '::cookie',
			'browser/referer'      => __CLASS__ . '::referer',
			'browser/url-variable' => __CLASS__ . '::url_variable',
		) );
	}

	/**
	 * Cookie rule.
	 *
	 * @since  0.1
	 * @param object $rule
	 * @return bool
	 */
	static public function cookie( $rule ) {
		return BB_Logic_Rules::evaluate_rule( array(
			'value'    => isset( $_COOKIE[ $rule->key ] ) ? $_COOKIE[ $rule->key ] : '',
			'operator' => $rule->operator,
			'compare'  => $rule->compare,
			'isset'    => isset( $_COOKIE[ $rule->key ] ),
		) );
	}

	/**
	 * Referer rule.
	 *
	 * @since  0.1
	 * @param object $rule
	 * @return bool
	 */
	static public function referer( $rule ) {
		return BB_Logic_Rules::evaluate_rule( array(
			'value'    => isset( $_SERVER['HTTP_REFERER'] ) ? $_SERVER['HTTP_REFERER'] : '',
			'operator' => $rule->operator,
			'compare'  => $rule->compare,
		) );
	}

	/**
	 * URL variable rule.
	 *
	 * @since  0.1
	 * @param object $rule
	 * @return bool
	 */
	static public function url_variable( $rule ) {
		return BB_Logic_Rules::evaluate_rule( array(
			'value'    => isset( $_GET[ $rule->key ] ) ? $_GET[ $rule->key ] : '',
			'operator' => $rule->operator,
			'compare'  => $rule->compare,
			'isset'    => isset( $_GET[ $rule->key ] ),
		) );
	}
}

BB_Logic_Rules_Browser::init();
