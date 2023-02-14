<?php

/**
 * Server side processing for ACF rules.
 *
 * @since 0.1
 */
final class BB_Logic_Rules_ACF {

	/**
	 * Sets up callbacks for conditional logic rules.
	 *
	 * @since  0.1
	 * @return void
	 */
	static public function init() {
		if ( ! class_exists( 'acf' ) ) {
			return;
		}

		BB_Logic_Rules::register( array(
			'acf/archive-field'     => __CLASS__ . '::archive_field',
			'acf/option-field'      => __CLASS__ . '::option_field',
			'acf/post-field'        => __CLASS__ . '::post_field',
			'acf/post-author-field' => __CLASS__ . '::post_author_field',
			'acf/user-field'        => __CLASS__ . '::user_field',
		) );
	}

	/**
	 * Process an ACF rule based on the object ID of the
	 * field location such as archive, post or user.
	 *
	 * @since  0.1
	 * @param string $object_id
	 * @param object $rule
	 * @return bool
	 */
	static public function evaluate_rule( $object_id, $rule ) {

		if ( ! isset( $object_id ) ) {
			$object_id = false;
		}
		$value = get_field( $rule->key, $object_id );

		if ( is_array( $value ) ) {
			// normal array....
			if ( isset( $value['value'] ) ) {
				$value = $value['value'];
			} else {
				if ( ! empty( $value ) ) {
					// nested array...
					$val_arr = array();
					foreach ( $value as $val ) {
						if ( is_array( $val ) && isset( $val['value'] ) ) {
							$val_arr[] = $val['value'];
						} elseif ( is_object( $val ) && isset( $val->value ) ) {
							$val_arr[] = $val->value;
						} else {
							$val_arr[] = $val;
						}
					}
					$value = $val_arr;
				} else {
					$value = 0;
				}
			}
		}

		if ( is_object( $value ) ) {
			if ( isset( $value->value ) ) {
				$value = $value->value;
			} else {
				$value = 1;
			}
		}

		$operator = $rule->operator;
		$compare  = $rule->compare;
		if ( in_array( $operator, array( 'equals', 'on', 'is_on', 'does_not_equal', 'not_on', 'is_not_on' ) ) ) {
			if ( 'boolean' === gettype( $value ) ) {
				$value   = (string) $value;
				$compare = (string) $compare;
			}
		}

		return BB_Logic_Rules::evaluate_rule( array(
			'value'    => $value,
			'operator' => $operator,
			'compare'  => $compare,
			'isset'    => $value,
		) );
	}

	/**
	 * Archive field rule.
	 *
	 * @since  0.1
	 * @param object $rule
	 * @return bool
	 */
	static public function archive_field( $rule ) {
		$object = get_queried_object();

		if ( ! is_object( $object ) || ! isset( $object->taxonomy ) || ! isset( $object->term_id ) ) {
			$id = 'archive';
		} else {
			$id = $object->taxonomy . '_' . $object->term_id;
		}

		return self::evaluate_rule( $id, $rule );
	}

	/**
	 * Option field rule.
	 *
	 * @since  0.1
	 * @param object $rule
	 * @return bool
	 */
	static public function option_field( $rule ) {
		return self::evaluate_rule( 'option', $rule );
	}

	/**
	 * Post field rule.
	 *
	 * @since  0.1
	 * @param object $rule
	 * @return bool
	 */
	static public function post_field( $rule ) {
		global $post;
		$id = is_object( $post ) ? $post->ID : 0;
		return self::evaluate_rule( $id, $rule );
	}

	/**
	 * Post author field rule.
	 *
	 * @since  0.1
	 * @param object $rule
	 * @return bool
	 */
	static public function post_author_field( $rule ) {
		global $post;
		$id = is_object( $post ) ? $post->post_author : 0;
		return self::evaluate_rule( 'user_' . $id, $rule );
	}

	/**
	 * User field rule.
	 *
	 * @since  0.1
	 * @param object $rule
	 * @return bool
	 */
	static public function user_field( $rule ) {
		$user = wp_get_current_user();
		return self::evaluate_rule( 'user_' . $user->ID, $rule );
	}
}

BB_Logic_Rules_ACF::init();
