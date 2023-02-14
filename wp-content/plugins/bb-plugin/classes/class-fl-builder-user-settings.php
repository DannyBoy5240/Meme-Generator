<?php

/**
 * Handles logic for user specific settings.
 *
 * @since 2.0
 */
class FLBuilderUserSettings {

	/**
	 * @since 2.0
	 * @return void
	 */
	static public function init() {
		FLBuilderAJAX::add_action( 'save_ui_skin', __CLASS__ . '::save_ui_skin', array( 'skin_name' ) );
		FLBuilderAJAX::add_action( 'save_lightbox_position', __CLASS__ . '::save_lightbox_position', array( 'data' ) );
		FLBuilderAJAX::add_action( 'save_pinned_ui_position', __CLASS__ . '::save_pinned_ui_position', array( 'data' ) );
	}

	/**
	 * @since 2.0
	 * @return array
	 */
	static public function get() {
		$meta     = get_user_meta( get_current_user_id(), 'fl_builder_user_settings', true );
		$defaults = array(
			'skin'     => 'light',
			'lightbox' => null,
		);

		if ( ! $meta ) {
			$meta = array();
		}

		return array_merge( $defaults, $meta );
	}

	/**
	 * @since 2.0
	 * @param array $data
	 * @return mixed
	 */
	static public function update( $data ) {
		return update_user_meta( get_current_user_id(), 'fl_builder_user_settings', $data );
	}

	/**
	 * Handle ajax request for updating color scheme.
	 *
	 * @since 2.0
	 * @param string $name
	 * @return array
	 */
	static public function save_ui_skin( $name ) {
		return array(
			'saved' => self::save_color_scheme( $name ),
			'name'  => $name,
		);
	}

	/**
	 * Get the default value for color scheme.
	 * @since 2.6
	 * @return string
	 */
	static public function get_default_color_scheme() {
		return 'auto';
	}

	/**
	 * Get array of supported color scheme values.
	 * @since 2.6
	 * @return array
	 */
	static public function get_valid_color_scheme_values() {
		return array( 'auto', 'light', 'dark' );
	}

	/**
	 * Update UI color scheme value
	 *
	 * @parama string $name
	 * @return array
	 */
	static public function save_color_scheme( $name ) {
		$settings = self::get();
		$values   = self::get_valid_color_scheme_values();

		// Reject if not a valid value
		if ( ! in_array( $name, $values ) ) {
			return $settings;
		}

		$settings['skin'] = $name;
		return self::update( $settings );
	}

	/**
	 * Getting for UI color scheme
	 *
	 * @since 2.6
	 * @return string
	 */
	static public function get_color_scheme() {
		$settings = self::get();
		return isset( $settings['skin'] ) ? $settings['skin'] : self::get_default_color_scheme();
	}

	/**
	 * Handle saving the lightbox position.
	 *
	 * @since 2.0
	 * @param array $data
	 * @return array
	 */
	static public function save_lightbox_position( $data ) {
		$settings             = self::get();
		$settings['lightbox'] = $data;

		return self::update( $settings );
	}

	/**
	 * Handle saving the lightbox position.
	 *
	 * @since 2.0
	 * @param array $data
	 * @return array
	 */
	static public function save_pinned_ui_position( $data ) {
		$settings = self::get();
		$settings = array_merge( $settings, $data );

		return self::update( $settings );
	}
}

FLBuilderUserSettings::init();
