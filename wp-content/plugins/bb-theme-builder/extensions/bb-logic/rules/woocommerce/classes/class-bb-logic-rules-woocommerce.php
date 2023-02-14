<?php

/**
 * Server side processing for WooCommerce rules.
 *
 * @since 0.1
 */
final class BB_Logic_Rules_WooCommerce {

	/**
	 * Sets up callbacks for conditional logic rules.
	 *
	 * @since  0.1
	 * @return void
	 */
	static public function init() {
		if ( ! class_exists( 'WooCommerce' ) ) {
			return;
		}

		BB_Logic_Rules::register( array(
			'woocommerce/cart'                        => __CLASS__ . '::cart',
			'woocommerce/cart-products'               => __CLASS__ . '::cart_products',
			'woocommerce/cart-total'                  => __CLASS__ . '::cart_total',
			'woocommerce/customer-billing-address'    => __CLASS__ . '::customer_billing_address',
			'woocommerce/customer-first-ordered'      => __CLASS__ . '::customer_first_ordered',
			'woocommerce/customer-last-ordered'       => __CLASS__ . '::customer_last_ordered',
			'woocommerce/customer-products-purchased' => __CLASS__ . '::customer_products_purchased',
			'woocommerce/customer-shipping-address'   => __CLASS__ . '::customer_shipping_address',
			'woocommerce/customer-total-orders'       => __CLASS__ . '::customer_total_orders',
			'woocommerce/customer-total-products'     => __CLASS__ . '::customer_total_products',
			'woocommerce/customer-total-spent'        => __CLASS__ . '::customer_total_spent',
		) );
	}

	/**
	 * Cart rule.
	 *
	 * @since  0.1
	 * @param object $rule
	 * @return bool
	 */
	static public function cart( $rule ) {
		$contents = WC()->cart ? WC()->cart->get_cart_contents() : array();
		return BB_Logic_Rules::evaluate_rule( array(
			'value'    => count( $contents ),
			'operator' => $rule->operator,
		) );
	}

	/**
	 * Cart products rule.
	 *
	 * @since  0.1
	 * @param object $rule
	 * @return bool
	 */
	static public function cart_products( $rule ) {
		$products = array();
		$contents = WC()->cart ? WC()->cart->get_cart_contents() : array();

		foreach ( $contents as $item ) {
			$products[] = $item['product_id'];
		}

		return BB_Logic_Rules::evaluate_rule( array(
			'value'    => $products,
			'operator' => $rule->operator,
			'compare'  => $rule->compare,
		) );
	}

	/**
	 * Cart total rule.
	 *
	 * @since  0.1
	 * @param object $rule
	 * @return bool
	 */
	static public function cart_total( $rule ) {
		$total = WC()->cart ? WC()->cart->get_total( false ) : 0;
		return BB_Logic_Rules::evaluate_rule( array(
			'value'    => $total,
			'operator' => $rule->operator,
			'compare'  => floatval( $rule->compare ),
		) );
	}

	/**
	 * Customer billing address rule.
	 *
	 * @since  0.1
	 * @param object $rule
	 * @return bool
	 */
	static public function customer_billing_address( $rule ) {
		$user     = wp_get_current_user();
		$customer = new WC_Customer( $user->ID );
		$address  = $customer->get_billing();

		return BB_Logic_Rules::evaluate_rule( array(
			'value'    => $address[ $rule->part ],
			'operator' => $rule->operator,
			'compare'  => $rule->compare,
		) );
	}

	/**
	 * Customer first order rule.
	 *
	 * @since  0.1
	 * @param object $rule
	 * @return bool
	 */
	static public function customer_first_ordered( $rule ) {
		$user   = wp_get_current_user();
		$date   = null;
		$orders = wc_get_orders( array(
			'customer_id' => $user->ID,
			'status'      => 'completed',
			'orderby'     => 'date',
			'order'       => 'ASC',
		) );

		foreach ( $orders as $order ) {
			$date = $order->get_date_completed();
			if ( $date ) {
				break;
			}
		}

		if ( ! $date ) {
			return false;
		}

		return BB_Logic_Rules::evaluate_date_rule(
			$rule,
			$date->date( 'm/d/Y h:i:s' )
		);
	}

	/**
	 * Customer last order rule.
	 *
	 * @since  0.1
	 * @param object $rule
	 * @return bool
	 */
	static public function customer_last_ordered( $rule ) {
		$user   = wp_get_current_user();
		$date   = null;
		$orders = wc_get_orders( array(
			'customer_id' => $user->ID,
			'status'      => 'completed',
			'orderby'     => 'date',
			'order'       => 'DESC',
		) );

		foreach ( $orders as $order ) {
			$date = $order->get_date_completed();
			if ( $date ) {
				break;
			}
		}

		if ( ! $date ) {
			return false;
		}

		return BB_Logic_Rules::evaluate_date_rule(
			$rule,
			$date->date( 'm/d/Y h:i:s' )
		);
	}

	/**
	 * Customer products purchased rule.
	 *
	 * @since  0.1
	 * @param object $rule
	 * @return bool
	 */
	static public function customer_products_purchased( $rule ) {
		$user     = wp_get_current_user();
		$products = array();
		$orders   = wc_get_orders( array(
			'customer_id' => $user->ID,
		) );

		foreach ( $orders as $order ) {
			foreach ( $order->get_items() as $item ) {
				$products[] = $item->get_product_id();
			}
		}

		return BB_Logic_Rules::evaluate_rule( array(
			'value'    => $products,
			'operator' => $rule->operator,
			'compare'  => $rule->compare,
		) );
	}

	/**
	 * Customer shipping address rule.
	 *
	 * @since  0.1
	 * @param object $rule
	 * @return bool
	 */
	static public function customer_shipping_address( $rule ) {
		$user     = wp_get_current_user();
		$customer = new WC_Customer( $user->ID );
		$address  = $customer->get_shipping();

		return BB_Logic_Rules::evaluate_rule( array(
			'value'    => $address[ $rule->part ],
			'operator' => $rule->operator,
			'compare'  => $rule->compare,
		) );
	}

	/**
	 * Customer total orders rule.
	 *
	 * @since  0.1
	 * @param object $rule
	 * @return bool
	 */
	static public function customer_total_orders( $rule ) {
		$user = wp_get_current_user();
		return BB_Logic_Rules::evaluate_rule( array(
			'value'    => $user->ID ? wc_get_customer_order_count( $user->ID ) : 0,
			'operator' => $rule->operator,
			'compare'  => absint( $rule->compare ),
		) );
	}

	/**
	 * Customer total products rule.
	 *
	 * @since  0.1
	 * @param object $rule
	 * @return bool
	 */
	static public function customer_total_products( $rule ) {
		$user   = wp_get_current_user();
		$count  = 0;
		$orders = wc_get_orders( array(
			'customer_id' => $user->ID,
			'status'      => 'completed',
		) );

		foreach ( $orders as $order ) {
			$count += count( $order->get_items() );
		}

		return BB_Logic_Rules::evaluate_rule( array(
			'value'    => $count,
			'operator' => $rule->operator,
			'compare'  => $rule->compare,
		) );
	}

	/**
	 * Customer total spent rule.
	 *
	 * @since  0.1
	 * @param object $rule
	 * @return bool
	 */
	static public function customer_total_spent( $rule ) {
		$user = wp_get_current_user();
		return BB_Logic_Rules::evaluate_rule( array(
			'value'    => $user->ID ? wc_get_customer_total_spent( $user->ID ) : 0,
			'operator' => $rule->operator,
			'compare'  => floatval( $rule->compare ),
		) );
	}
}

BB_Logic_Rules_WooCommerce::init();
