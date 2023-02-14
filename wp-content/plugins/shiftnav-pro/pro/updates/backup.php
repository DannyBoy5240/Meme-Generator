<?php

if ( !defined( 'ABSPATH' ) ) exit;


/**
 * BACKUP ON ADMIN ACCESS
 */

/*
 * Run a backup when users with update plugin capabilities access the admin panel.
 * This ensures that a backup of the latest custom files will be made prior to
 * any updates being run.
 */
add_action( 'admin_init' , 'shiftnav_run_backups' );
function shiftnav_run_backups(){
	if( !defined( 'DOING_AJAX' ) && current_user_can( 'update_plugins' ) ){
		if( shiftnav_op( 'backup_custom_assets' , 'updates' ) != 'off' ){
			shiftnav_backup_custom_assets();
			//shiftnav_restore_custom_assets();	//Just for testing
		}
	}
}

/*
 * Run backups for the custom assets, custom.css and custom.js - if they exist
 */
function shiftnav_backup_custom_assets(){

	$custom_dir = trailingslashit( SHIFTNAV_DIR ).'custom/';

	$custom_css = $custom_dir.'custom.css';
	if( file_exists( $custom_css ) ){
		shiftnav_backup_file( $custom_css , 'custom.css' , 'css' );
	}

	$custom_less = $custom_dir.'custom.less';
	if( file_exists( $custom_less ) ){
		shiftnav_backup_file( $custom_less , 'custom.less' , 'less' );
	}

	$custom_js = $custom_dir.'custom.js';
	if( file_exists( $custom_js ) ){
		shiftnav_backup_file( $custom_js , 'custom.js' , 'js' );
	}

}

/*
 * Copies the source file to uploads/shiftnav_backups directory
 * Also creates a date-stamped backup in the daily folder (optional)
 */
function shiftnav_backup_file( $source_file , $dest_filename , $daily_folder = false ){

	//If the destination filename is empty, bail
	if( !$dest_filename ){
		error_log( 'ShiftNav: Cannot backup file (destination not set) :: '. $source_file . ' :: '.$dest_filename );
		return;
	}

	//If the source file doesn't exist, bail
	if( !file_exists( $source_file ) ){
		error_log( 'ShiftNav: Cannot backup file (source file does not exist) :: ' . $source_file );
		return;
	}

	//Find the path to the backups directory
	$uploads = wp_upload_dir();
	$uploads_dir = trailingslashit( $uploads['basedir'] );
	$dest_dir = $uploads_dir . 'shiftnav_backups/';

	//Create shiftnav_backups dir if it doesn't already exist
	if( !shiftnav_make_backup_dir( $dest_dir ) ){
		//Bail if making the backup directory fails
		return;
	}

	//Destination File Name
	$dest_file = $dest_dir . $dest_filename;

	//Make the latest copy
	if( is_writable( $dest_dir ) ){
		if( !copy( $source_file, $dest_file ) ){
			error_log( "ShiftNav: could not back up $source_file , couldn't copy to $dest_dir - likely need to adjust directory permissions" );
			//Warning should be printed automatically in this case
			//return; //copy failed
		}
	}
	//If the destination directory isn't writable, log the error
	else{
		error_log( "ShiftNav: could not back up $source_file , $dest_dir not writable" );
	}

	//Make a daily backup
	$daily_dir = $dest_dir.$daily_folder.'/';		//Daily backup folder inside /shiftnav_backups
	shiftnav_make_backup_dir( $daily_dir );		//Create the daily directory if it doesn't exist

	if( is_writable( $daily_dir ) ){

		$daily = $daily_dir . $dest_filename . '_' . current_time( 'Y-m-d' );	//Date-stamp the file

		copy( $source_file , $daily );				//Make the backup

		//Clear old backups - if there are more than 10 files, purge the oldest
		$max_files = 10;
		$files = glob( $daily_dir.'*.*' );
		if( count( $files ) > $max_files ){
			asort( $files );	//Make sure they are sorted alphabetically (which is chronologically, due to the date stamp)
			//shiftp( $files );
			$k = 0;
			while( count( $files ) > $max_files ){
				unlink( $files[$k] );	//Delete the file from the server
				unset( $files[$k] );		//This is critical, otherwise we loop infinitely
				$k++;
			}
		}
	}

}

/*
 * Creates a directory if it doesn't already exist
 */
function shiftnav_make_backup_dir( $dir ){
	if( !file_exists( $dir ) ){
		if( !wp_mkdir_p( $dir ) ){
			return false; //Couldn't create directory
		}
	}
	return true;
}



/**
 * RESTORE ON PLUGIN ACTIVATION
 */

/*
 * When the plugin is activated, restore the custom assets
 * (Plugins are re-activated after update)
 */

//register_activation_hook( SHIFTNAV_FILE , 'shiftnav_restore_backups' );
add_action( 'shiftnav_update' , 'shiftnav_restore_backups' );
function shiftnav_restore_backups(){
	shiftnav_restore_custom_assets();
}

/*
 * Restores custom.css and custom.less and custom.js - if they exist
 */
function shiftnav_restore_custom_assets(){

	$custom_dir = trailingslashit( SHIFTNAV_DIR ).'custom/';	//ShiftNav's /custom directory

	//Find the Backups directory
	$uploads = wp_upload_dir();
	$uploads_dir = trailingslashit( $uploads['basedir'] );
	$backups_dir = $uploads_dir . 'shiftnav_backups/';

	//Restore CSS backup - if one exists and the custom.css does not exist in the plugin
	$custom_css = $custom_dir.'custom.css';
	$backup_css = $backups_dir.'custom.css';
	if( !file_exists( $custom_css ) && file_exists( $backup_css ) ){
		$result = shiftnav_restore_file( $backup_css , $custom_css , $custom_dir );

		if( is_wp_error( $result ) ){
			shiftnav_set_admin_notice( __( 'ShiftNav: Could not restore custom.css file, as the directory is not writable.  You can manually restore the file from the wp-content/uploads/shiftnav_backups directory' , 'shiftnav' ) , 'error' );
		}
		else{
			shiftnav_set_admin_notice( __( 'ShiftNav: Successfully restored custom.css file' , 'shiftnav' ) , 'updated' );
		}
	}

	//Restore LESS backup - if one exists and the custom.less does not exist in the plugin
	$custom_less = $custom_dir.'custom.less';
	$backup_less = $backups_dir.'custom.less';
	if( !file_exists( $custom_less ) && file_exists( $backup_less ) ){
		$result = shiftnav_restore_file( $backup_less , $custom_less , $custom_dir );

		if( is_wp_error( $result ) ){
			shiftnav_set_admin_notice( __( 'ShiftNav: Could not restore custom.less file, as the directory is not writable.  You can manually restore the file from the wp-content/uploads/shiftnav_backups directory' , 'shiftnav' ) , 'error' );
		}
		else{
			shiftnav_set_admin_notice( __( 'ShiftNav: Successfully restored custom.less file' , 'shiftnav' ) , 'updated' );
		}
	}

	//Restore JS backup - if one exists and the custom.js does not exist in the plugin
	$custom_js = $custom_dir.'custom.js';
	$backup_js = $backups_dir.'custom.js';
	if( !file_exists( $custom_js ) && file_exists( $backup_js ) ){
		$result = shiftnav_restore_file( $backup_js , $custom_js , $custom_dir );

		if( is_wp_error( $result ) ){
			shiftnav_set_admin_notice( __( 'ShiftNav: Could not restore custom.js file, as the directory is not writable.  You can manually restore the file from the wp-content/uploads/shiftnav_backups directory' , 'shiftnav' ) , 'error' );
		}
		else{
			shiftnav_set_admin_notice( __( 'ShiftNav: Successfully restored custom.js file' , 'shiftnav' ) , 'updated' );
		}
	}
}

/*
 * Copies the file from the source to the destination
 * $dest_file is a full path
 */
function shiftnav_restore_file( $source_file , $dest_file , $dest_dir ){
	//echo 'restore '.$source_file .' to ' .$dest_file;

	//If the directory is writable
	if( is_writable( $dest_dir ) ){
		copy( $source_file , $dest_file );
	}
	else{
		error_log( 'ShiftNav: could not restore (not writable) ' . $source_file . ' to ' . $dest_file );
		//Not really important, since the directory had to be writable in order to run the update
		//and delete the file in the first place
		return new WP_Error( 'shiftnav_restore_failed' , 'File not writable' );
	}
}

function shiftnav_restore_admin_notice( $notice , $type = 'updated' ) {
    ?>
    <div class="<?php echo $type; ?>">
        <p><?php echo $notice; ?></p>
    </div>
    <?php
}
