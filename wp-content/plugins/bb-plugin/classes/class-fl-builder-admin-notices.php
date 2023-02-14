<?php

/**
 * Class that handles showing admin notices.
 *
 * @since 2.5
 */
final class FLBuilderAdminNotices {

	/**
	 * @since 2.5
	 * @var array $notices
	 */
	static private $notices = array();

	static public function init() {
		add_action( 'admin_enqueue_scripts', __CLASS__ . '::enqueue_scripts' );
		add_action( 'admin_notices', __CLASS__ . '::render_notices' );
		add_action( 'wp_ajax_dismiss_fl_notice', array( __CLASS__, 'dismiss_callback' ) );
	}

	/**
	 * Register a notice.
	 *
	 * @since 2.5
	 * @param array $notice
	 * @return void
	 */
	static public function register_notice( $args = array() ) {

		$defaults = array(
			'id'      => false,
			'cap'     => 'edit_posts',
			'content' => '',
			'class'   => 'notice-info',
			'only'    => 'options-general.php?page=fl-builder-settings',
		);

		$notice = wp_parse_args( $args, $defaults );

		if ( $notice['id'] ) {
			self::$notices[] = $notice;
		}
	}

	static public function enqueue_scripts() {

		$notices = array();

		foreach ( self::$notices as $notice ) {

			if ( ! current_user_can( $notice['cap'] ) || self::is_dismissed( $notice['id'] ) ) {
				continue;
			}
			unset( $notice['content'] );
			$notices[] = $notice;
		}

		if ( empty( $notices ) ) {
			return;
		}

		wp_enqueue_script(
			'fl-builder-admin-notices',
			FL_BUILDER_URL . '/js/fl-builder-admin-notices.js',
			array( 'jquery' ),
			FL_BUILDER_VERSION,
			true
		);

		wp_localize_script( 'fl-builder-admin-notices', 'FLBuilderAdminNoticesConfig', array(
			'notices'      => $notices,
			'notice_nonce' => wp_create_nonce( 'dismiss_fl_notice', 'notice_nonce' ),
			'ajaxurl'      => admin_url( 'admin-ajax.php' ),
		) );
	}

	static public function render_notices() {
		$notices = array();

		foreach ( self::$notices as $notice ) {

			if ( ! current_user_can( $notice['cap'] ) || self::is_dismissed( $notice['id'] ) ) {
				continue;
			}

			if ( $notice['only'] && basename( home_url( $_SERVER['REQUEST_URI'] ) ) !== $notice['only'] ) {
				continue;
			}
			printf( '<div class="notice %s is-dismissible fl-notice notice-id-%s"><p>%s</p></div>', $notice['class'], $notice['id'], $notice['content'] );
		}
	}

	static private function is_dismissed( $notice_id ) {
		$dismissed = (array) get_user_meta( get_current_user_id(), 'fl_dismissed_wp_notices', true );
		return in_array( $notice_id, $dismissed );
	}

	static public function dismiss_callback() {
		if ( ! isset( $_POST['notice_nonce'] ) || ! wp_verify_nonce( $_POST['notice_nonce'], 'dismiss_fl_notice' )
		) {
			print 'Sorry, your nonce did not verify.';
			exit;
		} else {
			$user_id     = get_current_user_id();
			$dismissed   = (array) get_user_meta( $user_id, 'fl_dismissed_wp_notices', true );
			$dismissed[] = $_POST['notice'];
			update_user_meta( $user_id, 'fl_dismissed_wp_notices', $dismissed );
			exit();
		}
	}
}

FLBuilderAdminNotices::init();
