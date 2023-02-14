<?php

require_once( 'backup.php' );

// this is the URL our updater / license checker pings. This should be the URL of the site with EDD installed
if( !defined( 'SHIFTNAV_UPDATES_URL' ) ) define( 'SHIFTNAV_UPDATES_URL', 'https://sevenspark.com' );
if( !defined( 'SHIFTNAV_UPDATES_VERIFY_SSL' ) ) define( 'SHIFTNAV_UPDATES_VERIFY_SSL' , true );

// the name of your product. This should match the download name in EDD exactly
define( 'SHIFTNAV_UPDATES_NAME', 'ShiftNav Pro' );

if( !class_exists( 'EDD_SL_Plugin_Updater' ) ) {
	// load our custom updater
	include( dirname( __FILE__ ) . '/EDD_SL_Plugin_Updater.php' );
}

function shiftnav_plugin_updater() {

	// retrieve our license key from the DB
	$license_key = trim( shiftnav_op( 'license_code' , 'updates' , '' ) );

	// setup the updater
	$edd_updater = new EDD_SL_Plugin_Updater( SHIFTNAV_UPDATES_URL, SHIFTNAV_FILE, array(
			'version' 	=> SHIFTNAV_VERSION, 				// current version number
			'license' 	=> $license_key, 		// license key (used get_option above to retrieve from DB)
			'item_name' => SHIFTNAV_UPDATES_NAME, 	// name of this plugin
			'author' 	=> 'Chris Mavricos, SevenSpark',  // author of this plugin
			'url'		=> home_url(),
		)
	);

}
add_action( 'admin_init', 'shiftnav_plugin_updater', 0 );





//UPDATES SETTINGS TAB

add_filter( 'shiftnav_settings_panel_sections' , 'shiftnav_updater_settings_panel' );
function shiftnav_updater_settings_panel( $sections = array() ){
	$sections[] = array(
		'id'	=> SHIFTNAV_PREFIX.'updates',
		'title'	=> __( 'Updates' , 'shiftnav' ),
	);

	return $sections;

}

if( is_admin() ) add_filter( 'shiftnav_settings_panel_fields' , 'shiftnav_updater_settings_panel_fields' );	//only run in admin so that we're not running extra checks and backups on the front end
function shiftnav_updater_settings_panel_fields( $fields = array() ){

	$updates = SHIFTNAV_PREFIX.'updates';

	$desc = __( 'Enter your license code to receive updates', 'shiftnav' );

	$msg = '';

	//Force license recheck for missing data
	if( isset( $_GET['force-license-check'] ) ){
		check_admin_referer( 'shiftnav-control-panel' , 'shiftnav_nonce' );
		$license_data = shiftnav_check_license(); //shiftnav_activate_license();
		if( is_wp_error( $license_data ) ){
			$msg.= '<p class="shiftnav-settings-notice">Connection Error: <br/><code>'.$license_data->get_error_message().'</code></br>Please check your host server settings.  To download updates manually, please visit your <a target="_blank" href="https://sevenspark.com/dash">SevenSpark.com Dashboard</a></p>';
		}
		else if( $license_data ){
			$msg.= '<p class="shiftnav-settings-notice"><i class="fa fa-info-circle shiftnav-settings-notice-icon"></i> Rechecked license.  Status: <strong>' . $license_data->license . '</strong> | Expiration: <strong>' . date_format( date_create( $license_data->expires ), 'Y.m.d' ).'</strong></p>';
		}
	}

	$license_data = get_option( 'shiftnav_license_data' );
	$recheck = false;

	if( $license_data ){

		$today = date("Y-m-d H:i:s");
		$expires = $license_data->expires;

		//If the license was valid last time, but expired before today, recheck
		if( $license_data->license == 'valid' && $expires != 'lifetime' && $expires < $today) {
			$license_data = shiftnav_check_license(); //shiftnav_activate_license();
			$recheck = true;
		}
		if( $recheck && is_wp_error( $license_data ) ){
			$msg.= '<p class="shiftnav-settings-notice">Connection Error: <br/><code>'.$license_data->get_error_message().'</code></br>Please check your host server settings.  To download updates manually, please visit your <a target="_blank" href="https://sevenspark.com/dash">SevenSpark.com Dashboard</a></p>';
		}
		else{

			//recheck
			if( isset( $_GET['license-check'] ) ){
				check_admin_referer( 'shiftnav-control-panel' , 'shiftnav_nonce' );
				$license_data = shiftnav_check_license(); //shiftnav_activate_license();
				$recheck = true;
				if( !is_wp_error( $license_data ) ){
					$msg.= '<p class="shiftnav-settings-notice"><i class="fa fa-info-circle shiftnav-settings-notice-icon"></i> Rechecked license.  Status: <strong>' . $license_data->license . '</strong> | Expiration: <strong>' . date_format( date_create( $license_data->expires ), 'Y.m.d' ).'</strong></p>';
				}
			}
			if( $recheck && is_wp_error( $license_data ) ){
				$msg.= '<p class="shiftnav-settings-notice">Connection Error: <br/><code>'.$license_data->get_error_message().'</code></br>Please check your host server settings.  To download updates manually, please visit your <a target="_blank" href="https://sevenspark.com/dash">SevenSpark.com Dashboard</a></p>';
			}
			else{

				//re-active
				if( isset( $_GET['license-activate'] ) ){
					check_admin_referer( 'shiftnav-control-panel' , 'shiftnav_nonce' );
					$license_data = shiftnav_activate_license(); //shiftnav_activate_license();
					$recheck = true;
					if( !is_wp_error( $license_data ) ){
						$msg.= '<p class="shiftnav-settings-notice"><i class="fa fa-info-circle shiftnav-settings-notice-icon"></i> License status: '.$license_data->license.' | Expiration: ' . date_format( date_create( $license_data->expires ), 'Y.m.d' ).'</p>';
					}
				}
				if( $recheck && is_wp_error( $license_data ) ){
					$msg.= '<p class="shiftnav-settings-notice">Connection Error: <br/><code>'.$license_data->get_error_message().'</code></br>Please check your host server settings.  To download updates manually, please visit your <a target="_blank" href="https://sevenspark.com/dash">SevenSpark.com Dashboard</a></p>';
				}
				else{


					//shiftp( $license_data );

					$license_status = $license_data->license;

					$renewal_link = '<a target="_blank" href="https://sevenspark.com/checkout?edd_license_key='.shiftnav_op( 'license_code' , 'updates' , '').'&download_id=15272">Renew License</a>';


					switch( $license_status ){
						case 'invalid':
							$desc = '<span class="shiftnav-license-invalid">'.__( 'License Invalid' , 'shiftnav' ).'</span>';
							$desc.= '<span class="shiftnav-license-error">'.$license_data->error;
							if( $license_data->error == 'expired' ){
								$desc.= ' '.date_format( date_create( $license_data->expires ), 'Y.m.d' );
							}
							$desc.= '</span>';
							break;

						case 'expired':
							$desc = '<span class="shiftnav-license-invalid">'.__( 'License Expired' , 'shiftnav' ).'</span>';
							$desc.= ' '.date_format( date_create( $license_data->expires ), 'Y.m.d' );
							$desc.= '<p>' . $renewal_link.' Your license is expired.  <a target="_blank" href="http://sevenspark.com/docs/terms">Review license terms</a></p>';
							break;
						case 'valid':
							$desc = __( 'License is valid' , 'shiftnav' );
							break;
					};

					$nonce = wp_create_nonce( 'shiftnav-control-panel' );
					$activate_url = admin_url('themes.php?page=shiftnav-settings&license-activate=1&shiftnav_nonce='.$nonce);
					$recheck_url = admin_url('themes.php?page=shiftnav-settings&license-check=1&shiftnav_nonce='.$nonce);

					$desc.= '<p><a href="'.$recheck_url.'">Re-check license</a> If your license status has changed, refresh it</p>';


					$license_url = get_option( 'shiftnav_license_url' ); 	//where this license was registered/activated
					if( $license_url ){

						$registration_match = ( $license_url == home_url() );

						$registration_status_icon = '';
						if( $registration_match ){
							$registration_status_icon = 'check';
						}
						else{
							$registration_status_icon = 'times';
						}

						$desc.= '<p><i class="fa fa-'.$registration_status_icon.'"></i> This license is registered to <strong>' . preg_replace( '(^https?://)' , '' , $license_url ).'</strong></p>';

						if( $license_data->license == 'valid' || $license_data->license == 'site_inactive' ){
							if( !$registration_match ){
								$desc.= '<p>License does not appear to be registered to this site.  Would you like to <a href="'.$activate_url.'">Activate on this site?</a></p>';
							}
						}
					}
					else{
						if( $license_data->license == 'valid' || $license_data->license == 'site_inactive' ){
							$desc.= '<p><a href="'.$activate_url.'">Re-activate license</a> If your license was originally activated on a different URL, activate it on this site</p>';
						}
					}
				}
			}
		}
		$desc.= $msg;
	}
	//When checking, setting the default '' is critical so we don't enter an infinite loop
	else if( shiftnav_op( 'license_code' , 'updates' , '' ) ){
		$nonce = wp_create_nonce( 'shiftnav-control-panel' );
		$recheck_url = admin_url('themes.php?page=shiftnav-settings&force-license-check=1&shiftnav_nonce='.$nonce);
		$desc.= '<p>License status unknown.  <a href="'.$recheck_url.'">Re-check license</a></p>';
		$desc.= $msg;
	}





	// $fields[$updates][] = array(
	// 		'name'	=> 'backups_header',
	// 		'label' => __( 'Custom Asset Backups' , 'shiftnav' ),
	// 		'desc'	=> __( 'ShiftNav will attempt to automatically backup and restore your custom.css and custom.js files when you update', 'shiftnav' ),
	// 		'type'	=> 'header',
	// 		'group'	=> 'backups',
	//	);

	$fields[$updates][] = array(
			'name'	=> 'backup_custom_assets',
			'label'	=> __( 'Backup custom assets' , 'shiftnav' ),
			'desc'	=> __( 'Automatically backup custom.css and custom.less so that they can be restored after updating the plugin', 'shiftnav' ),
			'type'	=> 'checkbox',
			'default'	=> 'on',
			'group'	=> 'backups',
		);

	$fields[$updates][] = array(
			'name'	=> 'backup_notice',
			'label' => __( 'Automatic backups status' , 'shiftnav' ),
			'desc'	=> shiftnav_field_backup_notice(),
			'type'	=> 'html',
			'group'	=> 'backups',
		);


	// $fields[$updates][] = array(
	// 		'name'	=> 'update_settings',
	// 		'label' => __( 'Update Notifications' , 'shiftnav' ), //__( 'Automatic Updates' , 'shiftnav' ),
	// 		'desc'	=> __( 'Enter your Envato info to receive update notifications', 'shiftnav' ),
	// 		'type'	=> 'header',
	// 		'group'	=> 'updates',
	// 	);


	$fields[$updates][] = array(
			'name'	=> 'license_code',
			'label'	=> __( 'License Code' , 'shiftnav' ),
			'desc'	=> $desc,
			'type'	=> 'text',
	);

	// $fields[$updates][] = array(
	// 		'name'	=> 'updates_verify_ssl',
	// 		'label'	=> __( 'Verify SSL' , 'shiftnav' ),
	// 		'desc'	=> __( 'You should leave this checked unless you are having connection trouble when verifying your license', 'shiftnav' ),
	// 		'type'	=> 'checkbox',
	// 		'default' => 'on',
	// );




	return $fields;
}





/************************************
* this illustrates how to activate
* a license key
*************************************/

// add_action( 'shiftnav_settings_panel' , 'shiftnav_update_license_activation' );
// function shiftnav_update_license_activation(){

// 	shiftp( $_POST );

// 	if( isset( $_GET['settings-updated'] ) && $_GET['settings-updated'] == true ){
// 		if( 'valid' != get_option( 'shiftnav_license_status' , false ) ){
// 			$license = shiftnav_op( 'license_key' , 'updates' );
// 			if( $license ){
// 				//shiftnav_activate_license( $license );
// 			}
// 		}
// 	}
// }

//Only runs when license value changes, or when triggered explicitly
function shiftnav_activate_license() {

	// retrieve the license from the database
	$license = trim( shiftnav_op( 'license_code' , 'updates' , '' ) );

	//$license = $value['license_code'];

	if( $license == '' ){
		update_option( 'shiftnav_license_status' , '' );
		update_option( 'shiftnav_license_data' , '' );
		return;
	}

	// data to send in our API request
	$api_params = array(
		'edd_action'=> 'activate_license',
		'license' 	=> $license,
		'item_name' => urlencode( SHIFTNAV_UPDATES_NAME ), // the name of our product in EDD
		'url'       => home_url()
	);


	// Call the custom API.
	$remote_get_args = array( 'timeout' => 15 );
	if( !SHIFTNAV_UPDATES_VERIFY_SSL ){
		$remote_get_args['sslverify'] = false;
	}
	$response = wp_remote_get( add_query_arg( $api_params, SHIFTNAV_UPDATES_URL ), $remote_get_args );

	// make sure the response came back okay
	if ( is_wp_error( $response ) ){
		// shiftp( $response);
		// die();
		return $response;
	}

	// decode the license data
	$license_data = json_decode( wp_remote_retrieve_body( $response ) );

	$license_data->last_retrieved = date("Y-m-d H:i:s");

	update_option( 'shiftnav_license_data', $license_data );
	update_option( 'shiftnav_license_url' , home_url() );
		//->license (valid or invalid)
		//->error (expired)
		//->expires (2015-03-23 22:36:04)

	return $license_data;
}
add_action( 'update_option_'.SHIFTNAV_PREFIX.'updates' , 'shiftnav_activate_license' , 10 , 0 );
//add_action( 'admin_init', 'shiftnav_activate_license' , 10 , 1 );





function shiftnav_check_license() {

	// retrieve the license from the database
	$license = trim( shiftnav_op( 'license_code' , 'updates' , '' ) );

	//$license = $value['license_code'];

	if( $license == '' ){
		update_option( 'shiftnav_license_status' , '' );
		update_option( 'shiftnav_license_data' , '' );
		return;
	}

	// data to send in our API request
	$api_params = array(
		'edd_action'=> 'check_license',
		'license' 	=> $license,
		'item_name' => urlencode( SHIFTNAV_UPDATES_NAME ), // the name of our product in EDD
		'url'       => home_url()
	);

	//curl_setopt($handle, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1_1);
	// Call the custom API.
	$remote_get_args = array( 'timeout' => 15 );

	if( !SHIFTNAV_UPDATES_VERIFY_SSL ){
		$remote_get_args['sslverify'] = false;
	}
	$response = wp_remote_get( add_query_arg( $api_params, SHIFTNAV_UPDATES_URL ), $remote_get_args );
//shiftp( $response );
	// make sure the response came back okay
	if ( is_wp_error( $response ) )
		return $response;

	// decode the license data
	$license_data = json_decode( wp_remote_retrieve_body( $response ) );

	$license_data->last_retrieved = date("Y-m-d H:i:s");

	update_option( 'shiftnav_license_data', $license_data );
		//->license (valid or invalid)
		//->error (expired)
		//->expires (2015-03-23 22:36:04)

	return $license_data;
}









//////////BACKUPS

function shiftnav_field_backup_notice(){

	$note = $msg = '';

	$custom_dir = trailingslashit( SHIFTNAV_DIR ).'custom/';

	//Find the Backups directory
	$uploads = wp_upload_dir();

	$uploads_dir = trailingslashit( $uploads['basedir'] );
	$backups_dir = $uploads_dir . 'shiftnav_backups/';

	$uploads_url = trailingslashit( $uploads['baseurl'] );
	$backups_url = $uploads_url . 'shiftnav_backups/';


	if( !is_writable( $uploads_dir ) ){
		//TODO - readd this: <strong>These files will be lost when updating if not backed up first</strong></p>
		$note = '<p>The uploads directory is not writable by the server ( <code>'.$uploads_dir.'</code> ).  </p><p>ShiftNav will not automatically be able to back up your <strong><code>custom.css</code></strong> and <strong><code>custom.js</code></strong> if you create them.  Please make this directory writable if you wish to automatically back up these files, otherwise you can back them up and restore manually after plugin update. <p>(If you are not using <code>custom.css</code> or <code>custom.js</code>, you can safely ignore this message)</p>';

		$msg.= '<div id="setting-error-update-write" class="shiftnav-settings-notice shiftnav-settings-notice-large shiftnav-settings-error">' .
				'<i class="shiftnav-settings-notice-icon fa fa-warning"></i>'.
				'<strong>Automatic Backups Not Available</strong>'.
				'<p>'.$note.'</p></div>';
	}
	else{

		$backups_exist = false;

		$custom_css = $backups_dir . 'custom.css';
		$custom_css_url = $backups_url . 'custom.css';
		if( file_exists( $custom_css ) ){

			$backups_exist = true;

			$msg.= '<div class="shiftnav-settings-notice shiftnav-settings-success">' .
				'<i class="shiftnav-settings-notice-icon fa fa-check"></i>'.
				'<strong>custom.css backup available</strong>'.
				' <a href="'.$custom_css_url .'" target="_blank" download="custom.css"><i class="fa fa-download"></i></a>'.
				'</div>';
		}

		$custom_less = $backups_dir . 'custom.less';
		$custom_less_url = $backups_url . 'custom.less';
		if( file_exists( $custom_less ) ){

			$backups_exist = true;

			$msg.= '<div class="shiftnav-settings-notice shiftnav-settings-success">' .
				'<i class="shiftnav-settings-notice-icon fa fa-check"></i>'.
				'<strong>custom.less backup available</strong>'.
				' <a href="'.$custom_less_url .'" target="_blank" download="custom.less"><i class="fa fa-download"></i></a>'.
				'</div>';
		}

		$custom_js = $backups_dir . 'custom.js';
		$custom_js_url = $backups_url . 'custom.js';
		if( file_exists( $custom_js ) ){

			$backups_exist = true;

			$msg.= '<div class="shiftnav-settings-notice shiftnav-settings-success">' .
				'<i class="shiftnav-settings-notice-icon fa fa-check"></i>'.
				'<strong>custom.js backup available</strong>'.
				' <a href="'.$custom_js_url .'" download="custom.js" target="_blank"><i class="fa fa-download"></i></a>'.
				'</div>';
		}



		if( file_exists( $backups_dir ) ){

			if( file_exists( $custom_dir . 'custom.css' ) && !is_writable( $backups_dir . 'css' ) ){
				$msg.= '<div class="shiftnav-settings-notice shiftnav-settings-error">' .
					'<i class="shiftnav-settings-notice-icon fa fa-warning"></i>'.
					'<strong>Daily CSS backups not writable</strong>'.
					' <p>ShiftNav attempts to save daily backups, but this directory is not writable. <code>'.$backups_dir.'css/</code></p>'.
					'</div>';
			}

			if( file_exists( $custom_dir . 'custom.less' ) && !is_writable( $backups_dir . 'less' ) ){
				$msg.= '<div class="shiftnav-settings-notice shiftnav-settings-error">' .
					'<i class="shiftnav-settings-notice-icon fa fa-warning"></i>'.
					'<strong>Daily LESS backups not writable</strong>'.
					' <p>ShiftNav attempts to save daily backups, but this directory is not writable. <code>'.$backups_dir.'less/</code></p>'.
					'</div>';
			}

			if( file_exists( $custom_dir . 'custom.js' ) && !is_writable( $backups_dir . 'js' ) ){
				$msg.= '<div class="shiftnav-settings-notice shiftnav-settings-error">' .
					'<i class="shiftnav-settings-notice-icon fa fa-warning"></i>'.
					'<strong>Daily JS backups not writable</strong>'.
					' <p>ShiftNav attempts to save daily backups, but this directory is not writable. <code>'.$backups_dir.'js/</code></p>'.
					'</div>';
			}

		}



		if( !$backups_exist ){

			if( file_exists( $custom_dir.'custom.css' ) ||
				file_exists( $custom_dir.'custom.less' ) ||
				file_exists( $custom_dir.'custom.js' ) ){
				$msg.= '<div class="shiftnav-settings-notice shiftnav-settings-success"><i class="fa fa-info-circle shiftnav-settings-notice-icon"></i> No backups found.  If this message is present after refreshing, please check that your <code>/uploads</code> directory is writable.</div>';
			}
			else{
				$msg.= '<div class="shiftnav-settings-notice shiftnav-settings-success"><i class="fa fa-info-circle shiftnav-settings-notice-icon"></i> No custom assets in use.</div>';
			}
		}

	}









	return $msg;
}




// add_action( 'http_api_curl', 'shiftnav_api_curl', 10, 3 );
// function shiftnav_api_curl(&$handle, $args, $url){
//
// 	if( strpos($url, 'sevenspark.com') === false)
// 		return;
//
// 	curl_setopt($handle, CURLOPT_SSLVERSION, CURL_SSLVERSION_SSLv2);
// 	//curl_setopt($handle, CURLOPT_SSL_CIPHER_LIST, 'ecdhe_ecdsa_aes_256_sha');
// 	//curl_setopt($handle, CURLOPT_SSL_CIPHER_LIST, 'TLSv1'); // Another to try
// }
