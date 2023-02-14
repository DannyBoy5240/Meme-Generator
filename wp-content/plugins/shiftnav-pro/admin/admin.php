<?php

require_once( 'settings-api.class.php' );
require_once( 'settings.config.php' );
require_once( 'settings.menu.php' );

/* Add Settings Link to Plugins Panel */
function shiftnav_plugin_settings_link( $links ) {
	$settings_link = '<a href="'.admin_url( 'themes.php?page=shiftnav-settings' ).'">Settings</a>';
	array_unshift( $links, $settings_link );
	return $links;
}
add_filter( 'plugin_action_links_'.SHIFTNAV_BASENAME, 'shiftnav_plugin_settings_link' );


function shiftnav_pro_link(){
	?>
	<div class="shiftnav_pro_button_container">
		<a target="_blank" href="http://goo.gl/rd12PP" class="shiftnav_pro_button"><i class="fa fa-rocket"></i> Go Pro</a>
	</div>
	<?php
}
if( !SHIFTNAV_PRO ) add_action( 'shiftnav_settings_before' , 'shiftnav_pro_link' );



//ADMIN NOTICE SYSTEM
if( is_admin() ){
	add_action( 'admin_notices' , 'shiftnav_display_admin_notices' );
}
function shiftnav_display_admin_notices(){
	if( $messages = get_option( 'shiftnav_admin_notices' ) ){
		$change = false;
		if( is_array( $messages ) ){
			foreach( $messages as $k => $m ){
				?>
				<div class="<?php echo $m['type']; ?>">
					<p><?php echo $m['text']; ?></p>
				</div>
				<?php
				if( $m['repeat'] > 0 ){
					$m['repeat']--;
					if( $m['repeat'] == 0 ){
						unset( $messages[$k] );
					}
					$change = true;
				}

				if( $change ){
					update_option( 'shiftnav_admin_notices' , $messages );
				}
			}
		}
	}
}

function shiftnav_set_admin_notice( $text , $type = 'updated' , $repeat = 1, $dismissable = false , $expiration = -1 ){
	$messages = get_option( 'shiftnav_admin_notices' , array() );
	if( is_array( $messages ) ){
		$messages[] = array(
			'text'			=> $text,
			'type'			=> $type,
			'repeat'		=> $repeat,
			'dismissable'	=> $dismissable,
			'expiration'	=> $expiration,		//TODO
		);
		update_option( 'shiftnav_admin_notices' , $messages );
	}
}