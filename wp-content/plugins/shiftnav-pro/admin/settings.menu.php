<?php

add_action( 'admin_print_styles-nav-menus.php' , 'shiftnav_admin_menu_load_assets' );

function shiftnav_admin_menu_load_assets() {
	$assets = SHIFTNAV_URL . 'admin/assets/';
	wp_enqueue_style( 'shiftnav-menu-admin', $assets.'admin.menu.css' );
	wp_enqueue_style( 'shiftnav-menu-admin-font-awesome', $assets.'fontawesome/css/font-awesome.min.css' );
	wp_enqueue_script( 'shiftnav-menu-admin', $assets.'admin.menu.js' , array( 'jquery' ) , SHIFTNAV_VERSION , true );
	//wp_enqueue_media();

	$shiftnav_menu_data = shiftnav_get_menu_items_data();

	wp_localize_script( 'shiftnav-menu-admin' , 'shiftnav_menu_item_data' , $shiftnav_menu_data );

	wp_localize_script( 'shiftnav-menu-admin' , 'shiftnav_meta' , array(
		'ajax_url' => admin_url( 'admin-ajax.php' ),
		'nonce'		=> shiftnav_menu_item_settings_nonce(),
	) );
}

function shiftnav_menu_item_settings_panel(){

	$panels = shiftnav_menu_item_settings_panels();
	$settings = shiftnav_menu_item_settings();

	?>
	<div class="shiftnav-js-check">
		<div class="shiftnav-js-check-peek"><i class="fa fa-truck"></i> ShiftNav is waiting to load...</div>
		<div class="shiftnav-js-check-details">
			<p>
			If this message does not disappear, it means that ShiftNav has not been able to load.
			This most commonly indicates that you have a javascript error on this page, which will need to be resolved in order to allow ShiftNav to run.
			</p>
		</div>
	</div>
	<div class="shiftnav-menu-item-settings-wrapper">

		<div class="shiftnav-menu-item-settings-topper">
			<i class="fa fa-cogs"></i> SHIFTNAV SETTINGS
			<?php if( !SHIFTNAV_PRO ): ?><a target="_blank" href="http://goo.gl/7jzDSQ" class="shiftnav-up-link"><i class="fa fa-rocket"></i> Go Pro</a><?php endif; ?>
		</div>

		<div class="shiftnav-menu-item-panel shiftnav-menu-item-panel-negative">

			<div class="shiftnav-menu-item-panel-info" >

				<div class="shiftnav-menu-item-stats shift-clearfix">
					<div class="shiftnav-menu-item-title">Menu Item [Unknown]</div>
					<div class="shiftnav-menu-item-id">#menu-item-X</div>
					<div class="shiftnav-menu-item-type">Custom</div>
				</div>
				<ul class="shiftnav-menu-item-tabs">
					<?php foreach( $panels as $panel_id => $panel ): ?>
					<li class="shiftnav-menu-item-tab" ><a href="#" data-shiftnav-tab="<?php echo $panel_id; ?>" ><?php echo $panel['title']; ?></a></li>
					<?php endforeach; ?>

					<?php /*
					<li class="shiftnav-menu-item-tab" data-shiftnav-tab="general" ><a href="#">General</a></li>
					<li class="shiftnav-menu-item-tab" data-shiftnav-tab="submenu" ><a href="#">Submenu</a></li>
					<li class="shiftnav-menu-item-tab" data-shiftnav-tab="customize" ><a href="#">Customize</a></li>
					*/ ?>
				</ul>

			</div>

			<div class="shiftnav-menu-item-panel-settings shift-clearfix" >
				<form class="shiftnav-menu-item-settings-form" action="" method="post" enctype="multipart/form-data" >

					<?php foreach( $panels as $panel_id => $panel ):
							$panel_settings = $settings[$panel_id];
							ksort( $panel_settings );
							//shiftp( $panel_settings );
						?>

						<div class="shiftnav-menu-item-tab-content" data-shiftnav-tab-content="<?php echo $panel_id; ?>">

							<?php foreach( $panel_settings as $setting_id => $setting ): ?>

								<div class="shiftnav-menu-item-setting shiftnav-menu-item-setting-<?php echo $setting['type']; ?>">
									<label class="shiftnav-menu-item-setting-label"><?php echo $setting['title']; ?></label>
									<div class="shiftnav-menu-item-setting-input-wrap">
										<?php shiftnav_show_menu_item_setting( $setting ); ?>
									</div>
								</div>

							<?php endforeach; ?>

						</div>


					<?php endforeach; ?>

					<?php /*

					<div class="shiftnav-menu-item-tab-content" data-shiftnav-tab-content="general">

						<div class="shiftnav-menu-item-setting">
							<label class="shiftnav-menu-item-setting-label">Disable Link</label>
							<div class="shiftnav-menu-item-setting-input">
								<input type="checkbox" name="disable_link" value="on" data-shiftnav-setting="disable_link" />
							</div>
						</div>

						<div class="shiftnav-menu-item-setting">
							<label class="shiftnav-menu-item-setting-label">Icon</label>
							<div class="shiftnav-menu-item-setting-input">
								<select name="icon" data-shiftnav-setting="icon">
									<option value="show">Show</option>
									<option value="slide">Slide</option>
									<option value="expand">Expand</option>
								</select>
							</div>
						</div>

						<div class="shiftnav-menu-item-setting">
							<label class="shiftnav-menu-item-setting-label">Scroll To</label>
							<div class="shiftnav-menu-item-setting-input">
								<input type="text" name="scrollto" data-shiftnav-setting="scrollto" />
							</div>
						</div>

					</div>



					<div class="shiftnav-menu-item-tab-content" data-shiftnav-tab-content="submenu">

						<div class="shiftnav-menu-item-setting">
							<label class="shiftnav-menu-item-setting-label">Submenu Type</label>
							<div class="shiftnav-menu-item-setting-input">
								<select name="submenu_type" data-shiftnav-setting="submenu_type">
									<option value="show">Show</option>
									<option value="slide">Slide</option>
									<option value="expand">Expand</option>
								</select>
							</div>
						</div>
					</div>

					*/ ?>

					<div class="shiftnav-menu-item-save-button-wrapper">

						<a class="shiftnav-menu-item-settings-close" href="#"><i class="fa fa-times"></i></a>

						<input class="shiftnav-menu-item-save-button" type="submit" value="Save Menu Item" />
						<div class="shiftnav-menu-item-status shiftnav-menu-item-status-save">
							<i class="shiftnav-status-save fa fa-floppy-o"></i>
							<i class="shiftnav-status-success fa fa-check"></i>
							<i class="shiftnav-status-working fa fa-cog" title="Working..."></i>
							<i class="shiftnav-status-warning fa fa-exclamation-triangle"></i>
							<i class="shiftnav-status-error fa fa-exclamation-circle"></i>

							<span class="shiftnav-status-message"></span>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
	<?php
}
add_action( 'admin_footer-nav-menus.php' , 'shiftnav_menu_item_settings_panel');


function shiftnav_show_menu_item_setting( $setting ){

	if( isset( $setting['pro_only'] ) && $setting['pro_only'] ){
		echo '<a class="shiftnav-upgrade-link" target="_blank" href="http://goo.gl/9UuoWS">Upgrade to ShiftNav Pro</a> to use this feature.';
		return;
	}


	$id = $setting['id'];
	$type = $setting['type'];
	$default = $setting['default'];
	$desc = '<span class="shiftnav-menu-item-setting-description">'.$setting['desc'].'</span>';

	$name = 'name="'.$id.'"';
	$value = 'value="'.$default.'"';
	$data_setting = 'data-shiftnav-setting="'.$id.'"';

	$class = 'class="shiftnav-menu-item-setting-input"';

	$ops;
	if( isset( $setting['ops'] ) ){
		$ops = $setting['ops'];
		if( !is_array( $ops ) && function_exists( $op ) ){
			$ops = $ops();
		}
	}

	switch( $type ){
		case 'checkbox': ?>
			<input <?php echo $class; ?> type="checkbox" <?php echo "$name $data_setting"; checked( $default , 'on' ); ?> />
			<?php break;

		case 'text': ?>
			<input <?php echo $class; ?> type="text" <?php echo "$name $value $data_setting"; ?> />
			<?php break;

		case 'select': ?>
			<select <?php echo $class; ?> <?php echo "$name $data_setting"; ?> >
				<?php foreach( $ops as $_val => $_name ): ?>
				<option value="<?php echo $_val; ?>" <?php selected( $default , $_val ); ?> ><?php echo $_name; ?></option>
				<?php endforeach; ?>
			</select>
			<?php break;

		case 'icon': ?>
			<div class="shiftnav-icon-settings-wrap">
				<div class="shiftnav-icon-selected">
					<i class="<?php echo $default; ?>"></i>
					<span class="shiftnav-icon-set-icon">Set Icon</span>
				</div>
				<div class="shiftnav-icons shift-clearfix">
					<div class="shiftnav-icons-search-wrap">
						<input class="shiftnav-icons-search" placeholder="Type to search" />
					</div>

				<?php foreach( $ops as $_val => $data ): if( $_val == '' ) continue; ?>
					<span class="shiftnav-icon-wrap" title="<?php echo $data['title']; ?>" data-shiftnav-search-terms="<?php echo strtolower( $data['title'] ); ?>"><i class="shiftnav-icon <?php echo $_val; ?>" data-shiftnav-icon="<?php echo $_val; ?>" ></i></span>
				<?php endforeach; ?>
					<span class="shiftnav-icon-wrap shiftnav-remove-icon" title="Remove Icon"><i class="shiftnav-icon" data-shiftnav-icon="" >Remove Icon</i></span>
				</div>
				<select <?php echo $class; ?> <?php echo "$name $data_setting"; ?> >
					<?php foreach( $ops as $_val => $data ): ?>
					<option value="<?php echo $_val; ?>" <?php selected( $default , $_val ); ?> ><?php echo $data['title']; ?></option>
					<?php endforeach; ?>
				</select>
			</div>
			<?php break;

		default: ?>
			What's a "<?php echo $type; ?>"?
			<?php
	}

	echo $desc;

}


function shiftnav_menu_item_settings_panels(){
	$panels = array();
	$panels['general'] = array(
		'title'	=> 'General',
	);
	$panels['submenu'] = array(
		'title'	=> 'Submenu',
	);

	return $panels;
}

function shiftnav_menu_item_settings(){

	$settings = array();
	$panels = shiftnav_menu_item_settings_panels();
	foreach( $panels as $id => $panel ){
		$settings[$id] = array();
	}

	/*
		'general' => array(),
		'submenu' => array(),
	);
	*/

	$settings['general'][10] = array(
		'id' 		=> 'disable_link',
		'title'		=> __( 'Disable Link', 'shiftnav' ),
		'type'		=> 'checkbox',
		'default' 	=> 'off',
		'desc'		=> __( 'Check this box to remove the link from this item; clicking a disabled link will not result in any URL being followed.  Instead, this item will act as a toggle for its submenu, if one exists.' , 'shiftnav' ),
	);

	$settings['general'][20] = array(
		'id' 		=> 'highlight',
		'title'		=> __( 'Highlight Link', 'shiftnav' ),
		'type'		=> 'checkbox',
		'default' 	=> 'off',
		'desc'		=> __( 'Highlight this menu item' , 'shiftnav' ),
	);


	$settings['general'][30] = array(
		'id' 		=> 'icon',
		'title'		=> 'Icon',
		'type'		=> 'icon',
		'default' 	=> '',
		'desc'		=> '',
		'ops'		=> null,
		'pro_only'	=> true,
	);

	$settings['general'][40] = array(
		'id' 		=> 'scrollto',
		'title'		=> __( 'Scroll To' , 'shiftnav' ),
		'type'		=> 'text',
		'default' 	=> '',
		'desc'		=> __( 'The selector for an item to scroll to when clicked, if present.  Example: <code>#section-1</code>', 'shiftnav' )
	);

	$settings['general'][42] = array(
		'id' 		=> 'disable_current',
		'title'		=> __( 'Disable Current' , 'shiftnav' ),
		'type'		=> 'checkbox',
		'default' 	=> 'off',
		'desc'		=> __( 'Disable the current menu item classes for this item', 'shiftnav' )
	);

	$settings['general'][80] = array(
		'id' 		=> 'disable_item',
		'title'		=> __( 'Disable Item', 'shiftnav' ),
		'type'		=> 'checkbox',
		'default' 	=> 'off',
		'desc'		=> __( 'Hide this item.  Useful if this menu is being reused in multiple locations, but item should not be displayed in ShiftNav', 'shiftnav' ),
	);

	/*
	$settings['submenu'][10] = array(
		'id' 		=> 'submenu_indent',
		'title'		=> 'Indent Submenu',
		'type'		=> 'checkbox',
		'default'	=> 'on',
		'desc'		=> '',
	);
	*/

	$settings['submenu'][20] = array(
		'id' 		=> 'submenu_type',
		'title'		=> __( 'Submenu Type', 'shiftnav' ),
		'type'		=> 'select',
		'default'	=> 'default',
		'desc'		=> __( '[Requires Pro Version] Overrides the default submenu type.  For the Lite version, only "Always visible" is available.  Can be changed to "Accordion" or "Shift" with the Pro version.' , 'shiftnav' ),
		'ops'		=> array(
						'default'	=>  __( 'Menu Default', 'shiftnav' ),
						'always'	=>	__( 'Always visible', 'shiftnav' ),
					),
	);

  $settings['submenu'][40] = array(
		'id' 		=> 'disable_submenu',
		'title'		=> __( 'Disable Submenu', 'shiftnav' ),
		'type'		=> 'checkbox',
		'default'	=> 'off',
		'desc'		=> __( 'Disable the submenu for this menu item within ShiftNav.' , 'shiftnav' ),

	);

	return apply_filters( 'shiftnav_menu_item_settings' , $settings );

}

function shiftnav_menu_item_setting_defaults(){
	$defaults = array();
	$settings = shiftnav_menu_item_settings();
	foreach( $settings as $panel => $panel_settings ){
		foreach( $panel_settings as $setting ){
			$defaults[$setting['id']] = $setting['default'];
		}
	}
	return $defaults;
}


function shiftnav_get_menu_items_data( $menu_id = -1 ){

	if( $menu_id == -1 ){
		global $nav_menu_selected_id;
		$menu_id = $nav_menu_selected_id;
	}

	if( $menu_id == 0 ) return array();

	$shiftnav_menu_data = array();
	$menu_items = wp_get_nav_menu_items( $menu_id, array( 'post_status' => 'any' ) );

	foreach( $menu_items as $item ){
		$_item_settings = shiftnav_get_menu_item_data( $item->ID );
		if( $_item_settings != '' ){
			$shiftnav_menu_data[$item->ID] = $_item_settings;
		}
	}
	//shiftp( $shiftnav_menu_data );

	return $shiftnav_menu_data;
}

function shiftnav_get_menu_item_data( $item_id ){
	return get_post_meta( $item_id , SHIFTNAV_MENU_ITEM_META_KEY , true );
}



/** AJAXY! **/

function shiftnav_menu_item_settings_nonce(){
	return wp_create_nonce( 'shiftnav-menu-item-settings' );
}

add_action( 'wp_ajax_shiftnav_save_menu_item', 'shiftnav_save_menu_item_callback' );

function shiftnav_save_menu_item_callback() {
	global $wpdb; // this is how you get access to the database

	//CHECK NONCE
	check_ajax_referer( 'shiftnav-menu-item-settings' , 'shiftnav_nonce' );

	$menu_item_id = $_POST['menu_item_id'];
	$menu_item_id = substr( $menu_item_id , 10 );

	$serialized_settings = $_POST['settings'];
	$dirty_settings = array();
	parse_str( $serialized_settings, $dirty_settings );

	//CHECKBOXES
	//Since unchecked checkboxes won't be submitted, detect them and set the 'off' value
	$_defined_settings = shiftnav_menu_item_settings();
	foreach( $_defined_settings as $panel => $panel_settings ){
		foreach( $panel_settings as $_priority => $_setting ){
			if( $_setting['type'] == 'checkbox' ){
				$_id = $_setting['id'];
				if( !isset( $dirty_settings[$_id] ) ){
					$dirty_settings[$_id] = 'off';
				}
			}
		}
	}

	//ONLY ALLOW SETTINGS WE'VE DEFINED
	$settings = wp_parse_args( $dirty_settings, shiftnav_menu_item_setting_defaults() );

	//SAVE THE SETTINGS
	update_post_meta( $menu_item_id, SHIFTNAV_MENU_ITEM_META_KEY , $settings );


	$response = array();

	$response['settings'] = $settings;
	$response['menu_item_id'] = $menu_item_id;

	//send back nonce
	$response['nonce'] = shiftnav_menu_item_settings_nonce();

	//print_r( $response );
	echo json_encode( $response );

	//echo $data;

	die(); // this is required to return a proper result
}
