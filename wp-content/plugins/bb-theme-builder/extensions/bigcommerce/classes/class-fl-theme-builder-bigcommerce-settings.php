<?php

/**
 * Class FLThemeBuilderBigCommerceSettings
 */
final class FLThemeBuilderBigCommerceSettings {

	/**
	 * Get settings array from php file
	 *
	 * @param $file_name_without_extension
	 * @param array $prepend
	 * @param array $append
	 *
	 * @return array
	 */
	static public function get( $file_name_without_extension, $prepend = array(), $append = array() ) {
		// construct a full path
		$file_path = sprintf( '%s/settings/%s.php', FL_THEME_BUILDER_BIGCOMMERCE_DIR, $file_name_without_extension );

		if ( file_exists( $file_path ) ) {
			$settings = include( $file_path );
			return array_merge( $prepend, $settings, $append );
		} else {
			return array_merge( $prepend, $append );
		}
	}
}
