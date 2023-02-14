<?php

/**
 * Handles registering and processing rules on the server side.
 *
 * @since 0.1
 */
final class BB_Logic_Rules {

	/**
	 * Registered callback functions for server side processing
	 * of individual rule types.
	 *
	 * @since 0.1
	 * @access private
	 * @var array $callbacks
	 */
	static private $callbacks = array();

	/**
	 * Registers a callback function for processing a rule type.
	 * An array of key/callback pairs can be passed instead for
	 * registering multiple rules at once.
	 *
	 * @since  0.1
	 * @param string|array $key
	 * @param string $callback
	 * @return void
	 */
	static public function register( $key, $callback = null ) {
		if ( is_array( $key ) ) {
			foreach ( $key as $type => $callback ) {
				self::$callbacks[ $type ] = $callback;
			}
		} else {
			self::$callbacks[ $key ] = $callback;
		}
	}

	/**
	 * Loops through the provided raw rule group data and returns
	 * true if a group has all of its rules returning true. Otherwise,
	 * this will return false.
	 *
	 * @since  0.1
	 * @param string|array $groups
	 * @return bool
	 */
	static public function process_groups( $groups ) {

		// Decode the groups if we have a string.
		if ( is_string( $groups ) ) {
			$groups = json_decode( $groups );
		}

		// Return true if we don't have any rules.
		if ( empty( $groups ) ) {
			return true;
		}

		// Loop through the groups and return true if we has conditions that are met.
		foreach ( $groups as $group ) {
			$result = true;
			foreach ( $group as $rule ) {
				if ( ! self::process_rule( $rule ) ) {
					$result = false;
					break;
				}
			}
			if ( $result ) {
				return true;
			}
		}

		// If we made it here return false as not all conditions were met.
		return false;
	}

	/**
	 * Processes raw rule data and returns true if the rule
	 * matches the provided conditions.
	 *
	 * Defaults to true in case some rules have been disabled.
	 * This way content will still show even if the core is
	 * installed but the rules are not.
	 *
	 * @since  0.1
	 * @param object|array $rule
	 * @return bool
	 */
	static public function process_rule( $rule ) {
		$rule   = is_array( $rule ) ? (object) $rule : $rule;
		$key    = $rule->type;
		$result = true;

		if ( isset( self::$callbacks[ $key ] ) && is_callable( self::$callbacks[ $key ] ) ) {
			$result = call_user_func( self::$callbacks[ $key ], $rule );
		}

		return $result;
	}

	/**
	 * Evaluates a rule that has been processed with a registered
	 * callback function. The $value and $operator args are the only
	 * ones that are required, however many operators require at least
	 * $compare to be specified. See the arg comments below for more info.
	 *
	 * @since  0.1
	 * @param array $data {
	 *      @type mixed $value
	 *      @type string $operator
	 *      @type string $compare - Optional. To compare against the value.
	 *      @type bool $isset - Optional. An isset check for set or not_set operators.
	 *      @type number $start - Optional. A start number for within operators.
	 *      @type number $end - Optional. An end number for within operators.
	 * }
	 * @return bool
	 */
	static public function evaluate_rule( $data ) {
		$result   = false;
		$value    = $data['value'];
		$operator = $data['operator'];
		$compare  = isset( $data['compare'] ) ? do_shortcode( $data['compare'] ) : '';
		$isset    = isset( $data['isset'] ) ? $data['isset'] : false;
		$start    = isset( $data['start'] ) ? $data['start'] : 0;
		$end      = isset( $data['end'] ) ? $data['end'] : 0;

		switch ( $operator ) {
			case 'equals':
			case 'on':
			case 'is_on':
				$result = $value === $compare;
				break;
			case 'does_not_equal':
			case 'not_on':
			case 'is_not_on':
				$result = $value !== $compare;
				break;
			case 'is_less_than':
			case 'before':
			case 'is_before':
				$result = $value < floatval( $compare );
				break;
			case 'is_less_than_or_equal_to':
			case 'on_or_before':
			case 'is_on_or_before':
			case 'over':
				$result = $value <= floatval( $compare );
				break;
			case 'is_greater_than':
			case 'after':
			case 'is_after':
				$result = $value > floatval( $compare );
				break;
			case 'is_greater_than_or_equal_to':
			case 'on_or_after':
			case 'is_on_or_after':
			case 'in_the_past':
				$result = $value >= floatval( $compare );
				break;
			case 'starts_with':
				$length = strlen( $compare );
				$result = substr( $value, 0, $length ) === $compare;
				break;
			case 'ends_with':
				$length = strlen( $compare );
				$result = 0 === $length || substr( $value, -$length ) === $compare;
				break;
			case 'contains':
			case 'include':
			case 'includes':
				if ( is_string( $value ) ) {
					$result = strstr( $value, $compare );
				}
				if ( is_array( $value ) ) {
					$result = in_array( $compare, $value );
				}
				break;
			case 'does_not_contain':
			case 'do_not_include':
			case 'does_not_include':
				if ( is_string( $value ) ) {
					$result = ! strstr( $value, $compare );
				}
				if ( is_array( $value ) ) {
					$result = ! in_array( $compare, $value );
				}
				break;
			case 'is_set':
				$result = $isset;
				break;
			case 'is_not_set':
				$result = ! $isset;
				break;
			case 'is_empty':
				$result = empty( $value );
				break;
			case 'is_not_empty':
				$result = ! empty( $value );
				break;
			case 'within':
			case 'is_within':
			case 'between':
			case 'is_between':
				$result = $value >= $start && $value <= $end;
				break;
			case 'not_within':
			case 'is_not_within':
			case 'not_between':
			case 'is_not_between':
				$result = $value < $start || $value > $end;
				break;
		}

		return $result;
	}

	/**
	 * Helper for evaluating common complex date rules.
	 * See the User Signup Date rule for an example.
	 *
	 * @since  0.1
	 * @param object $rule {
	 *      @type string $operator The operator for this rule.
	 *      @type number $duration The duration for within and not within rules.
	 *      @type string $period The period for within and not within rules.
	 *      @type string $start A start date for all other operators that aren't within.
	 *      @type string $end An end date for all other operators that aren't within.
	 * }
	 * @param string $date A date string that includes hours, minutes, and seconds (e.g. m/d/Y h:i:s).
	 * @return bool
	 */
	static public function evaluate_date_rule( $rule, $date ) {
		$now = (int) function_exists( 'current_time' ) ? current_time( 'timestamp' ) : time(); //phpcs:ignore WordPress.DateTime.CurrentTimeTimestamp.Requested

		if ( in_array( $rule->operator, array( 'in_the_past', 'over' ) ) ) {
			$compare = strtotime( "-{$rule->duration} {$rule->period}", $now );
			$start   = null;
			$end     = null;
		} else {
			$parts   = explode( ' ', $date );
			$date    = array_shift( $parts );
			$compare = strtotime( $rule->start, $now );
			$start   = strtotime( $rule->start, $now );
			$end     = strtotime( $rule->end, $now );
		}

		return BB_Logic_Rules::evaluate_rule( array(
			'value'    => strtotime( $date, $now ),
			'operator' => $rule->operator,
			'compare'  => $compare,
			'start'    => $start,
			'end'      => $end,
		) );
	}
}
