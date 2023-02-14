<?php

/**
 * Handles loading REST API classes for retrieving
 * data used to populate rule fields.
 *
 * @since 0.1
 */
final class BB_Logic_REST {

	/**
	 * Only load the REST classes if the current user
	 * has the edit_posts capability. Some of this data
	 * may be sensitive, so we shouldn't allow unauthorized
	 * users to access it.
	 *
	 * @since  0.1
	 * @return void
	 */
	static public function init() {
		if ( ! current_user_can( 'edit_posts' ) ) {
			return;
		}

		include_once BB_LOGIC_DIR . 'rest/classes/class-bb-logic-rest-wordpress.php';
	}
}

add_action( 'rest_api_init', 'BB_Logic_REST::init' );
