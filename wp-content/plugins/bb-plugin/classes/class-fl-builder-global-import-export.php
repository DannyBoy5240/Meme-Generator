<?php
class FLBuilderGlobalImportExport {

	function __construct() {
		add_action( 'wp_ajax_export_global_settings', array( $this, 'export_data' ) );
		add_action( 'wp_ajax_import_global_settings', array( $this, 'import_data' ) );
		add_action( 'wp_ajax_reset_global_settings', array( $this, 'reset_data' ) );
		add_filter( 'wp_check_filetype_and_ext', array( $this, 'allow_import' ), 10, 4 );

		add_action( 'admin_enqueue_scripts', function() {
			wp_enqueue_script( 'fl-builder-global-import-export', FL_BUILDER_URL . 'js/fl-builder-global-import-export.js', array( 'jquery' ), FL_BUILDER_VERSION );
			wp_localize_script( 'fl-builder-global-import-export', 'FLBuilderAdminImportExportConfig', array(
				'select' => __( 'Import Settings', 'fl-builder' ),
			));
		});
	}

	/**
	 * @since 2.6
	 */
	static public function export_data() {

		check_admin_referer( 'fl_builder_import_export' );

		if ( current_user_can( 'manage_options' ) ) {

			$settings       = array();
			$admin_settings = array();

			$settings['builder_global_settings'] = FLBuilderModel::get_global_settings();

			foreach ( FLBuilderAdminSettings::registered_settings() as $setting ) {
				$admin_settings[ $setting ] = get_option( $setting );
			}

			$settings['admin_settings'] = $admin_settings;

			if ( ! $settings ) {
				wp_send_json_error( 'No settings found' );
			}
			wp_send_json_success( wp_json_encode( $settings ) );
		} else {
			wp_send_json_error();
		}
	}

	public function import_data() {

		check_admin_referer( 'fl_builder_import_export' );

		if ( current_user_can( 'manage_options' ) ) {

			$id   = $_POST['importid'];
			$path = get_attached_file( $id );

			if ( ! $path ) {
				wp_send_json_error( 'Could not find file!' );
			}

			$data = file_get_contents( $path );

			if ( ! is_object( json_decode( $data ) ) ) {
				wp_send_json_error( 'Could not parse file!' );
			}

			$data = json_decode( $data );

			update_option( '_fl_builder_settings', $data->builder_global_settings );

			// loop through admin settings
			$settings = $data->admin_settings;

			foreach ( $settings as $key => $setting ) {
				update_option( $key, $setting );
			}
			wp_send_json_success( $data );
		} else {
			wp_send_json_error();
		}
	}

	public function reset_data() {

		check_admin_referer( 'fl_builder_import_export' );

		if ( current_user_can( 'manage_options' ) ) {
			delete_option( '_fl_builder_settings' );
			foreach ( FLBuilderAdminSettings::registered_settings() as $setting ) {
				delete_option( $setting );
			}
			wp_send_json_success();
		} else {
			wp_send_json_error();
		}
	}

	public function allow_import( $data, $file, $filename, $mimes ) {
		if ( isset( $_POST['fl_global_import'] ) && current_user_can( 'manage_options' ) ) {
			$wp_filetype     = wp_check_filetype( $filename, $mimes );
			$ext             = $wp_filetype['ext'];
			$type            = $wp_filetype['type'];
			$proper_filename = $data['proper_filename'];
			return compact( 'ext', 'type', 'proper_filename' );
		}
		return $data;
	}
}
new FLBuilderGlobalImportExport;
