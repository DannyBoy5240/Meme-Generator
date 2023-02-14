<?php

function shiftnav_settings_pro_links(){
	echo '<a target="_blank" class="button" href="'.shiftnav_get_support_url().'"><i class="fa fa-user-md"></i> Support</a>';
}
if( ! SHIFTNAV_EXTENDED ) add_action( 'shiftnav_settings_before_title' , 'shiftnav_settings_pro_links' );


/**
 * CREATE INSTANCE MANAGER
 */

add_action( 'shiftnav_settings_before' , 'shiftnav_instance_manager');

function shiftnav_instance_manager(){
	//update_option( 'shiftnav_menus' , array() );
	//$m = get_option( 'shiftnav_menus' );
	//shiftp( $m );

	?>

	<div class="shiftnav_instance_manager">

		<a class="shiftnav_instance_toggle shiftnav_instance_button">+ Add ShiftNav Instance</a>

		<div class="shiftnav_instance_wrap shiftnav_instance_container_wrap">

			<div class="shiftnav_instance_container">

				<h3>Add ShiftNav Instance</h3>

				<form class="shiftnav_instance_form">
					<input class="shiftnav_instance_input" type="text" name="shiftnav_instance_id" placeholder="menu_id" />
					<?php wp_nonce_field( 'shiftnav-add-instance' ); ?>
					<a class="shiftnav_instance_button shiftnav_instance_create_button">Create Instance</a>
				</form>

				<p class="shiftnav_instance_form_desc">Enter an ID for your new menu.  This ID will be used when printing the menu,
					and must contain only letters, hyphens, and underscores.  <a class="shiftnav_instance_notice_close" href="#">close</a></p>

				<span class="shiftnav_instance_close">&times;</span>

			</div>

		</div>


		<div class="shiftnav_instance_wrap shiftnav_instance_notice_wrap shiftnav_instance_notice_success">
			<div class="shiftnav_instance_notice">
				New menu created. <a href="<?php echo admin_url('themes.php?page=shiftnav-settings'); ?>" class="shiftnav_instance_button">Refresh Page</a>
				<p>Note: Any setting changes you've made have not been saved yet.  <a class="shiftnav_instance_notice_close" href="#">close</a></p>
			</div>
		</div>

		<div class="shiftnav_instance_wrap shiftnav_instance_notice_wrap shiftnav_instance_notice_error">
			<div class="shiftnav_instance_notice">
				New menu creation failed.  <span class="shiftnav-error-message">You may have a PHP error on your site which prevents AJAX requests from completing.</span>  <a class="shiftnav_instance_notice_close" href="#">close</a>
			</div>
		</div>

		<div class="shiftnav_instance_wrap shiftnav_instance_notice_wrap shiftnav_instance_delete_notice_success">
			<div class="shiftnav_instance_notice">
				Instance Deleted.  <a class="shiftnav_instance_notice_close" href="#">close</a></p>
			</div>
		</div>

		<div class="shiftnav_instance_wrap shiftnav_instance_notice_wrap shiftnav_instance_delete_notice_error">
			<div class="shiftnav_instance_notice">
				Menu deletion failed.  <span class="shiftnav-delete-error-message">You may have a PHP error on your site which prevents AJAX requests from completing.</span>  <a class="shiftnav_instance_notice_close" href="#">close</a>
			</div>
		</div>


	</div>

	<?php
}

function shiftnav_add_instance_callback(){

	check_ajax_referer( 'shiftnav-add-instance' , 'shiftnav_nonce' );

	$response = array();

	$serialized_settings = $_POST['shiftnav_data'];
	$dirty_settings = array();
	parse_str( $serialized_settings, $dirty_settings );

	//ONLY ALLOW SETTINGS WE'VE DEFINED
	$data = wp_parse_args( $dirty_settings, array( 'shiftnav_instance_id' ) );

	$new_id = $data['shiftnav_instance_id'];

	if( $new_id == '' ){
		$response['error'] = 'Please enter an ID. ';
	}
	else{
		$new_id = sanitize_title( $new_id );

		//update
		$menus = get_option( 'shiftnav_menus' , array() );

		if( in_array( $new_id , $menus ) ){
			$response['error'] = 'That ID is already taken. ';
		}
		else{
			$menus[] = $new_id;
			update_option( 'shiftnav_menus' , $menus );
		}

		$response['id'] = $new_id;
	}

	$response['data'] = $data;

	echo json_encode( $response );

	die();
}
add_action( 'wp_ajax_shiftnav_add_instance', 'shiftnav_add_instance_callback' );


function shiftnav_delete_instance_callback(){

	check_ajax_referer( 'shiftnav-delete-instance' , 'shiftnav_nonce' );

	$response = array();
//echo json_encode( $_POST['shiftnav_data'] );
//die();
	//$serialized_settings = $_POST['shiftnav_data'];
	//$dirty_settings = array();
	//parse_str( $serialized_settings, $dirty_settings );

	$dirty_settings = $_POST['shiftnav_data'];

	//ONLY ALLOW SETTINGS WE'VE DEFINED
	$data = wp_parse_args( $dirty_settings, array( 'shiftnav_instance_id' ) );

	$id = $data['shiftnav_instance_id'];

	if( $id == '' ){
		$response['error'] = 'Missing ID';
	}
	else{

		$menus = get_option( 'shiftnav_menus' , array() );

		if( !in_array( $id , $menus ) ){
			$response['error'] = 'ID not in $menus ['.$id.']';
		}
		else{
			//unset( $menus[$id] );
			$i = array_search( $id , $menus );
			if( $i !== false ) unset( $menus[$i] );

			update_option( 'shiftnav_menus' , $menus );
			$response['menus'] = $menus;
		}

		$response['id'] = $id;
	}

	$response['data'] = $data;

	echo json_encode( $response );

	die();
}
add_action( 'wp_ajax_shiftnav_delete_instance', 'shiftnav_delete_instance_callback' );


/**
 * CREATE PRO SETTINGS
 */

add_filter( 'shiftnav_settings_panel_sections' , 'shiftnav_settings_panel_sections_pro' );
add_filter( 'shiftnav_settings_panel_fields' , 'shiftnav_settings_panel_fields_pro' );

function shiftnav_settings_panel_sections_pro( $sections = array() ){
	//$menus = get_option( 'shiftnav_menus' , array() );
	$menus = shiftnav_get_menu_configurations();

	foreach( $menus as $menu ){
		$sections[] = array(
			'id'	=> SHIFTNAV_PREFIX.$menu,
			'title' => '+'.$menu,
		);
	}

	return $sections;
}

function shiftnav_settings_panel_fields_pro( $fields = array() ){


	/** ADD MAIN NAV PRO OPTIONS **/

	$main = SHIFTNAV_PREFIX.'shiftnav-main';

	$fields[$main][1010] = array(
		'name'		=> 'submenu_type_default',
		'label'		=> __( 'Submenu Type Default' , 'ubermenu' ),
		'desc'		=> __( 'This submenu type will be used by any Menu Item whose Submenu Type is set to "Menu Default"' , 'shiftnav' ),
		'type'		=> 'radio',
		'options'	=> array(
			'always'	=> __( 'Always visible' , 'shiftnav' ),
			'accordion'	=> __( 'Accordion' , 'shiftnav' ),
			'shift'		=> __( 'Shift', 'shiftnav' ),
		),
		'default'	=> 'always',
		'customizer'			=> true,
		'customizer_section' 	=> 'config',

	);

	$accordion_toggle_icon_open_icons = array(
		'chevron-down',
		'chevron-circle-down',
		'angle-down',
		'angle-double-down',
		'arrow-circle-down',
		'arrow-down',
		'caret-down',
		'toggle-down',
		'plus',
		'plus-circle',
		'plus-square',
		'plus-square-o',
	);
	$accordion_toggle_icon_open_ops = array();
	foreach( $accordion_toggle_icon_open_icons as $i ){
		$accordion_toggle_icon_open_ops[$i] = '<i class="fa fa-'.$i.'"></i>';
	}

	$fields[$main][1012] = array(
		'name'		=> 'accordion_toggle_icon_open',
		'label'		=> __( 'Accordion Toggle Open Icon' , 'ubermenu' ),
		'desc'		=> __( 'The icon that, when tapped, will open the accordion submenu' , 'shiftnav' ),
		'type'		=> 'radio',
		'options'	=> $accordion_toggle_icon_open_ops,
		'default'	=> 'chevron-down',
		'customizer'		=> true,
		'customizer_section' 	=> 'config',
		'customizer_control'	=> 'radio_html'
	);

	$accordion_toggle_icon_close_icons = array(
		'chevron-up',
		'chevron-circle-up',
		'angle-up',
		'angle-double-up',
		'arrow-circle-up',
		'arrow-up',
		'caret-up',
		'toggle-up',
		'minus',
		'minus-circle',
		'minus-square',
		'minus-square-o',
		'times',
		'times-circle',
		'times-circle-o',
	);
	$accordion_toggle_icon_close_ops = array();
	foreach( $accordion_toggle_icon_close_icons as $i ){
		$accordion_toggle_icon_close_ops[$i] = '<i class="fa fa-'.$i.'"></i>';
	}

	$fields[$main][1013] = array(
		'name'		=> 'accordion_toggle_icon_close',
		'label'		=> __( 'Accordion Toggle Close Icon' , 'ubermenu' ),
		'desc'		=> __( 'The icon that, when tapped, will close the accordion submenu' , 'shiftnav' ),
		'type'		=> 'radio',
		'options'	=> $accordion_toggle_icon_close_ops,
		'default'	=> 'chevron-up',
		'customizer'		=> true,
		'customizer_section' 	=> 'config',
		'customizer_control'	=> 'radio_html'
	);



	$fields[$main][1020] = array(
		'name'		=> 'disable_menu',
		'label'		=> __( 'Disable Menu' , 'shiftnav' ),
		'desc'		=> __( 'Check this to disable the menu entirely; the panel will still be displayed and can be used for custom content' , 'shiftnav' ),
		'type'		=> 'checkbox',
		'default'	=> 'off',
		'customizer'			=> true,
		'customizer_section' 	=> 'content',
	);

	$fields[$main][1030] = array(
		'name'	=>	'image',
		'label'	=>	__( 'Top Image' , 'shiftnav' ),
		'desc'	=> __( '' , 'shiftnav' ),
		'type'	=> 'image',
		'default' => '',
		'customizer'			=> true,
		'customizer_section' 	=> 'content',
	);

	$fields[$main][1040] = array(
		'name'	=>	'image_padded',
		'label'	=>	__( 'Pad Image' , 'shiftnav' ),
		'desc'	=> __( 'Add padding to align image with menu item text.  Uncheck to expand to the edges of the panel.' , 'shiftnav' ),
		'type'	=> 'checkbox',
		'default' => 'on',
		'customizer'			=> true,
		'customizer_section' 	=> 'content',
	);

	$fields[$main][1050] = array(
		'name'	=>	'image_link',
		'label'	=>	__( 'Image Link (URL)' , 'shiftnav' ),
		'desc'	=> __( 'Make the image a link to this URL.' , 'shiftnav' ),
		'type'	=> 'text',
		'default' => '',
		'customizer'			=> true,
		'customizer_section' 	=> 'content',
	);

	$fields[$main][1060] = array(
		'name'	=>	'content_before',
		'label'	=>	__( 'Custom Content Before Menu' , 'shiftnav' ),
		'desc'	=> __( '' , 'shiftnav' ),
		'type'	=> 'textarea',
		'default' => '',
		'sanitize_callback' => 'shiftnav_allow_html',
		'customizer'			=> true,
		'customizer_section' 	=> 'content',
	);

	$fields[$main][1070] = array(
		'name'	=>	'content_after',
		'label'	=>	__( 'Custom Content After Menu' , 'shiftnav' ),
		'desc'	=> __( '' , 'shiftnav' ),
		'type'	=> 'textarea',
		'default' => '',
		'sanitize_callback' => 'shiftnav_allow_html',
		'customizer'			=> true,
		'customizer_section' 	=> 'content',
	);




	/** ADD MAIN TOGGLE OPTIONS **/
	$toggle = SHIFTNAV_PREFIX.'togglebar';

	$fields[$toggle][45] = array(
		'name'	=> 'hide_bar_on_scroll',
		'label'	=> __( 'Hide Toggle Bar on Scroll Down' , 'shiftnav' ),
		'desc'	=> __( 'Move the toggle bar off-screen while the user scrolls down.' , 'shiftnav' ),
		'type'	=> 'checkbox',
		'default' => 'off', //get_bloginfo( 'title' )
		'customizer'			=> true,
	);

	//$fields[$toggle][1010] = array(
	$fields[$toggle][55] = array(
		'name'	=> 'toggle_content_left',
		'label'	=> __( 'Toggle Content Left Edge' , 'shiftnav' ),
		'desc'	=> __( 'For the Full Bar toggle style, this content will appear at the left edge of the toggle bar, to the right of the toggle icon.  To pad your custom content vertically, use the class <code>shiftnav-toggle-main-block</code>.' , 'shiftnav' ),
		'type'	=> 'textarea',
		'default' => '', //get_bloginfo( 'title' )
		'sanitize_callback' => 'shiftnav_allow_html',
		'customizer'	=> true,
		'customizer_section'	=> 'config'
	);

	//$fields[$toggle][1020] = array(
	$fields[$toggle][56] = array(
		'name'	=> 'toggle_content_right',
		'label'	=> __( 'Toggle Content Right Edge' , 'shiftnav' ),
		'desc'	=> __( 'For the Full Bar toggle style, this content will appear at the right edge of the toggle bar.  To pad your custom content vertically, use the class <code>shiftnav-toggle-main-block</code>.' , 'shiftnav' ),
		'type'	=> 'textarea',
		'default' => '', //get_bloginfo( 'title' )
		'sanitize_callback' => 'shiftnav_allow_html',
		'customizer'	=> true,
		'customizer_section'	=> 'config'
	);

	ksort( $fields[$toggle] );	//Maybe not optimal place to do this?


	/** ADD INSTANCES **/

	$menus = get_option( 'shiftnav_menus' , array() );

	foreach( $menus as $menu ){

		$integration_code = '
			<div class="shiftnav-desc-row">
				<span class="shiftnav-code-snippet-type">PHP</span> <code class="shiftnav-highlight-code">&lt;?php shiftnav_toggle( \''.$menu.'\' , \'Toggle Menu\' , array( \'icon\' => \'bars\' , \'class\' => \'shiftnav-toggle-button\') ); ?&gt;</code>
			</div>
			<div class="shiftnav-desc-row">
				<span class="shiftnav-code-snippet-type">Shortcode</span> <code class="shiftnav-highlight-code">[shiftnav_toggle target="'.$menu.'" class="shiftnav-toggle-button" icon="bars"]Toggle Menu[/shiftnav_toggle]</code>'.
			'</div>
			<div class="shiftnav-desc-row">
				<span class="shiftnav-code-snippet-type">HTML</span> <code class="shiftnav-highlight-code">&lt;a class="shiftnav-toggle shiftnav-toggle-button" data-shiftnav-target="'.$menu.'"&gt;&lt;i class="fa fa-bars"&gt;&lt;/i&gt; Toggle Menu &lt;/a&gt;</code>
			</div>
			<p class="shiftnav-sub-desc shiftnav-desc-mini" >'.
				sprintf(
					__( 'Click to select, then %s or %s to copy to clipboard', 'shiftnav' ),
					'<strong><em>&#8984;+c</em></strong>',
					'<strong><em>ctrl+c</em></strong>'
				).
			'</p>
			<p class="shiftnav-sub-desc shiftnav-desc-understated">'.
				__( 'Pick the appropriate code and add to your template or content where you want the toggle to appear.  The menu panel itself is loaded automatically.  You can add the toggle code as many times as you like.', 'shiftnav' ).
			'</p>';

		$fields[SHIFTNAV_PREFIX.$menu] = array(
			10 => array(
				'name'	=> 'php',
				'label'	=> __( 'Integration Code' , 'shiftnav' ),
				'desc'	=> $integration_code,
				'type'	=> 'html',
			),
			20 => array(
				'name'	=> 'instance_name',
				'label'	=> __( 'Instance Name' , 'shiftnav' ),
				'desc'	=> __( '' , 'shiftnav' ),
				'type'	=> 'text',
				'default' => $menu,
				'customizer'			=> true,
				'customizer_section' 	=> 'config',
			),
			25 => array(
				'name'	=> 'automatic_generation',
				'label'	=> __( 'Automatically Generate Panel' , 'shiftnav' ),
				'desc'	=> __( 'Automatically generate this ShiftNav instance.  It\'ll be added to each page of the site' , 'shiftnav' ),
				'type'	=> 'checkbox',
				'default' => 'on',
				//'customizer'			=> true,
				//'customizer_section' 	=> 'config',
			),
			30 => array(
				'name'	=> 'menu',
				'label'	=> __( 'Display Menu' , 'shiftnav' ),
				'desc'	=> 'Select the menu to display or <a href="'.admin_url( 'nav-menus.php' ).'">create a new menu</a>.  This setting will override the Theme Location setting.',
				'type'	=> 'select',
				'options' => shiftnav_get_nav_menu_ops(),
				//'options' => get_registered_nav_menus()
				'customizer'			=> true,
				'customizer_section' 	=> 'config',
			),
			40 => array(
				'name'	=> 'theme_location',
				'label'	=> __( 'Theme Location' , 'shiftnav' ),
				'desc'	=> __( 'Select the Theme Location to display.  The Menu setting will override this setting if a menu is selected.', 'shiftnav' ),
				'type'	=> 'select',
				//'options' => shiftnav_get_nav_menu_ops(),
				'options' => shiftnav_get_theme_location_ops(),
				'customizer'			=> true,
				'customizer_section' 	=> 'config',
			),
			50 => array(
				'name'	=> 'edge',
				'label'	=> __( 'Edge' , 'shiftnav' ),
				'desc'	=> __( 'Select which edge of your site to display the menu on' , 'shiftnav' ),
				'type'	=> 'radio',
				'options' => array(
					'left' => 'Left',
					'right'=> 'Right',
				),
				'default' => 'left',
				'customizer'			=> true,
				'customizer_section' 	=> 'config',
			),

			60 => array(
				'name'		=> 'disable_menu',
				'label'		=> __( 'Disable Menu' , 'shiftnav' ),
				'desc'		=> __( 'Check this to disable the menu entirely; the panel can be used for custom content' , 'shiftnav' ),
				'type'		=> 'checkbox',
				'default'	=> 'off',
				'customizer'			=> true,
				'customizer_section' 	=> 'config',
			),

			70 => array(
				'name'	=> 'skin',
				'label'	=> __( 'Skin' , 'shiftnav' ),
				'desc'	=> __( 'Select which skin to use for this instance' , 'shiftnav' ),
				'type'	=> 'select',
				'options' => shiftnav_get_skin_ops(),
				//'options' => get_registered_nav_menus()
				'customizer'			=> true,
				'customizer_section' 	=> SHIFTNAV_PRO ? 'styles_panel' : 'config',

			),

			80 => array(
				'name'		=> 'submenu_type_default',
				'label'		=> __( 'Submenu Type Default' , 'ubermenu' ),
				'desc'		=> __( 'This submenu type will be used by any Menu Item whose Submenu Type is set to "Menu Default"' , 'shiftnav' ),
				'type'		=> 'radio',
				'options'	=> array(
					'always'	=> __( 'Always visible' , 'shiftnav' ),
					'accordion'	=> __( 'Accordion' , 'shiftnav' ),
					'shift'		=> __( 'Shift', 'shiftnav' ),
				),
				'default'	=> 'always',
				'customizer'			=> true,
				'customizer_section' 	=> 'config',

			),

			82 => array(
				'name'		=> 'accordion_toggle_icon_open',
				'label'		=> __( 'Accordion Toggle Open Icon' , 'ubermenu' ),
				'desc'		=> __( 'The icon that, when tapped, will open the accordion submenu' , 'shiftnav' ),
				'type'		=> 'radio',
				'options'	=> $accordion_toggle_icon_open_ops,
				'default'	=> 'chevron-down',
				'customizer'		=> true,
				'customizer_section' 	=> 'config',

			),

			83 => array(
				'name'		=> 'accordion_toggle_icon_close',
				'label'		=> __( 'Accordion Toggle Close Icon' , 'ubermenu' ),
				'desc'		=> __( 'The icon that, when tapped, will close the accordion submenu' , 'shiftnav' ),
				'type'		=> 'radio',
				'options'	=> $accordion_toggle_icon_close_ops,
				'default'	=> 'chevron-up',
				'customizer'		=> true,
				'customizer_section' 	=> 'config',

			),


			90 => array(
				'name'		=> 'indent_submenus',
				'label'		=> __( 'Indent Always Visible Submenus' , 'shiftnav' ),
				'desc'		=> __( 'Check this to indent submenu items of always-visible submenus' , 'shiftnav' ),
				'type'		=> 'checkbox',
				'default'	=> 'off',
				'customizer'			=> true,
				'customizer_section' 	=> 'config',
			),

			100 => array(
				'name'	=> 'toggle_content',
				'label'	=> __( 'Toggle Content' , 'shiftnav' ),
				'desc'	=> __( 'Enter the content to be displayed in the toggle, which you will insert into your template with the integration code at the top of this tab.' , 'shiftnav' ),
				'type'	=> 'textarea',
				'default' => '<i class="fa fa-bars"></i> Toggle', // 'Toggle '.$menu,
				'sanitize_callback' => 'shiftnav_allow_html',
			),


			110 => array(
				'name' => 'display_site_title',
				'label' => __( 'Display Site Title', 'shiftnav' ),
				'desc' => __( 'Display the site title in the menu', 'shiftnav' ),
				'type' => 'checkbox',
				'default' => 'off',
				'customizer'			=> true,
				'customizer_section' 	=> 'content',
			),

			120 => array(
				'name' => 'display_instance_title',
				'label' => __( 'Display Instance Name', 'shiftnav' ),
				'desc' => __( 'Display the instance name in the menu', 'shiftnav' ),
				'type' => 'checkbox',
				'default' => 'on',
				'customizer'			=> true,
				'customizer_section' 	=> 'content',
			),

			125 => array(
				'name' => 'display_panel_close_button',
				'label' => __( 'Display Panel Close Button', 'shiftnav' ),
				'desc' => __( 'Display an &times; close button in the upper right of the ShiftNav panel', 'shiftnav' ),
				'type' => 'checkbox',
				'default' => 'off',
				'customizer'			=> true,
				'customizer_section' 	=> 'config',
			),

			130 => array(
				'name'	=>	'image',
				'label'	=>	__( 'Top Image' , 'shiftnav' ),
				'desc'	=> __( '' , 'shiftnav' ),
				'type'	=> 'image',
				'default' => '',
				'customizer'			=> true,
				'customizer_section' 	=> 'content',
			),

			140 => array(
				'name'	=>	'image_padded',
				'label'	=>	__( 'Pad Image' , 'shiftnav' ),
				'desc'	=> __( 'Add padding to align image with menu item text.  Uncheck to expand to the edges of the panel.' , 'shiftnav' ),
				'type'	=> 'checkbox',
				'default' => 'on',
				'customizer'			=> true,
				'customizer_section' 	=> 'content',
			),

			150 => array(
				'name'	=>	'image_link',
				'label'	=>	__( 'Image Link (URL)' , 'shiftnav' ),
				'desc'	=> __( 'Make the image a link to this URL.' , 'shiftnav' ),
				'type'	=> 'text',
				'default' => '',
				'customizer'			=> true,
				'customizer_section' 	=> 'content',
			),

			160 => array(
				'name'	=>	'content_before',
				'label'	=>	__( 'Custom Content Before Menu' , 'shiftnav' ),
				'desc'	=> __( '' , 'shiftnav' ),
				'type'	=> 'textarea',
				'default' => '',
				'sanitize_callback' => 'shiftnav_allow_html',
				'customizer'			=> true,
				'customizer_section' 	=> 'content',
			),

			170 => array(
				'name'	=>	'content_after',
				'label'	=>	__( 'Custom Content After Menu' , 'shiftnav' ),
				'desc'	=> __( '' , 'shiftnav' ),
				'type'	=> 'textarea',
				'default' => '',
				'sanitize_callback' => 'shiftnav_allow_html',
				'customizer'			=> true,
				'customizer_section' 	=> 'content',
			),

			/*
			array(
				'name' => 'display_condition',
				'label' => __( 'Display on', 'shiftnav' ),
				'desc' => __( '', 'shiftnav' ),
				'type' => 'multicheck',
				'options' => array(
					'all' 	=> 'All',
					'posts' => 'Posts',
					'pages' => 'Pages',
					'home' 	=> 'Home Page',
					'blog'	=> 'Blog Page',
				),
				'default' => array( 'all' => 'all' )
			),
			*/

			180 => array(
				'name'	=> 'delete',
				'label'	=> __( 'Delete Instance' , 'shiftnav' ),
				'desc'	=> '<a class="shiftnav_instance_button shiftnav_instance_button_delete" href="#" data-shiftnav-instance-id="'.$menu.'" data-shiftnav-nonce="'.wp_create_nonce( 'shiftnav-delete-instance' ).'">'.__( 'Permanently Delete Instance' , 'shiftnav' ).'</a>',
				'type'	=> 'html',
			),

		);
	}


	// $gen = SHIFTNAV_PREFIX.'general';
	// $fields[$gen][130] = array(
	// 	'name' 		=> 'scroll_top_boundary',
	// 	'label' 	=> __( 'Scroll Top Boundary', 'shiftnav' ),
	// 	'desc' 		=> __( '(Unrelated to ScrollTo or Scroll Offset).  Pixel distance from the top of the viewport at which the user is considered to have scrolled to the top.  Used for the Hide Toggle Bar on Scroll Down setting.', 'shiftnav' ),
	// 	'type' 		=> 'text',
	// 	'input_type' => 'number',
	// 	'default' 	=> 50,
	// );
	//
	// shiftp( $fields );

	return $fields;
}










add_filter( 'shiftnav_settings_panel_fields' , 'shiftnav_settings_panel_fields_pro_styles' );

function shiftnav_settings_panel_fields_pro_styles( $fields = array() ){


	/** ADD INSTANCES **/

	$menus = shiftnav_get_menu_configurations( true );

	foreach( $menus as $menu ){

		//PANEL GENERAL

		$fields[SHIFTNAV_PREFIX.$menu][2010] = array(
			'name'	=> 'panel_background_color',
			'label'	=> __( 'Panel Background Color' , 'shiftnav' ),
			'desc'	=> __( '' , 'shiftnav' ),
			'type'	=> 'color',
			//'default' => '#1D1D20',
			'custom_style'			=> 'panel_background',
			'customizer'			=> true,
			'customizer_section' 	=> 'styles_panel',
		);

		$fields[SHIFTNAV_PREFIX.$menu][2020] = array(
			'name'	=> 'panel_font_color',
			'label'	=> __( 'Panel Default Font Color' , 'shiftnav' ),
			'desc'	=> __( 'The default font color for custom content within the panel (menu-specific styles will override this for menu items)' , 'shiftnav' ),
			'type'	=> 'color',
			//'default' => '#1D1D20',
			'custom_style'			=> 'panel_font_color',
			'customizer'			=> true,
			'customizer_section' 	=> 'styles_panel',
		);




		//MENU TITLE / HEADER

		$fields[SHIFTNAV_PREFIX.$menu][2030] = array(
			'name'	=> 'panel_header_font_color',
			'label'	=> __( 'Panel Title Font Color' , 'shiftnav' ),
			'desc'	=> __( 'The font color for the header/title within the panel.' , 'shiftnav' ),
			'type'	=> 'color',
			//'default' => '#1D1D20',
			'custom_style'			=> 'panel_header_font_color',
			'customizer'			=> true,
			'customizer_section' 	=> 'styles_panel',
		);

		$fields[SHIFTNAV_PREFIX.$menu][2040] = array(
			'name'	=> 'panel_header_font_size',
			'label'	=> __( 'Panel Title Font Size' , 'shiftnav' ),
			'desc'	=> __( 'The font size for the header/title within the panel.' , 'shiftnav' ),
			'type'	=> 'text',
			//'default' => '#1D1D20',
			'custom_style'			=> 'panel_header_font_size',
			'customizer'			=> true,
			'customizer_section' 	=> 'styles_panel',
		);

		$fields[SHIFTNAV_PREFIX.$menu][2050] = array(
			'name'	=> 'panel_header_text_align',
			'label'	=> __( 'Panel Title Text Alignment' , 'shiftnav' ),
			'desc'	=> __( 'The alignment of the text in the header/title within the panel.' , 'shiftnav' ),
			'type'	=> 'radio',
			'options'=> array(
				''			=> __( 'Default' , 'shiftnav' ),
				'center' 	=> __( 'Center' , 'shiftnav' ),
				'left' 		=> __( 'Left' , 'shiftnav' ),
				'right' 	=> __( 'Right' , 'shiftnav' ),
			),
			//'default' => '#1D1D20',
			'custom_style'			=> 'panel_header_text_align',
			'customizer'			=> true,
			'customizer_section' 	=> 'styles_panel',
		);

		$fields[SHIFTNAV_PREFIX.$menu][2060] = array(
			'name'	=> 'panel_header_font_weight',
			'label'	=> __( 'Panel Title Font Weight' , 'shiftnav' ),
			'desc'	=> __( 'The font weight of the text in the header/title within the panel.' , 'shiftnav' ),
			'type'	=> 'radio',
			'options'=> array(
				''			=> __( 'Default' , 'shiftnav' ),
				'normal' 	=> __( 'Normal' , 'shiftnav' ),
				'bold' 		=> __( 'Bold' , 'shiftnav' ),
			),
			//'default' => '#1D1D20',
			'custom_style'			=> 'panel_header_font_weight',
			'customizer'			=> true,
			'customizer_section' 	=> 'styles_panel',
		);


		//MENU




		//MENU ITEMS
		$fields[SHIFTNAV_PREFIX.$menu][2070] = array(
			'name'	=> 'menu_item_background_color',
			'label'	=> __( 'Menu Item Background Color' , 'shiftnav' ),
			'desc'	=> __( 'The color of the menu item background.  Normally not necessary to set unless you want it to differ from the panel background' , 'shiftnav' ),
			'type'	=> 'color',
			'custom_style'			=> 'menu_item_background_color',
			'customizer'			=> true,
			'customizer_section' 	=> 'styles_menu_items',
		);
		$fields[SHIFTNAV_PREFIX.$menu][2080] = array(
			'name'	=> 'menu_item_font_color',
			'label'	=> __( 'Menu Item Font Color' , 'shiftnav' ),
			'desc'	=> __( 'The color of the menu item text.' , 'shiftnav' ),
			'type'	=> 'color',
			'custom_style'			=> 'menu_item_font_color',
			'customizer'			=> true,
			'customizer_section' 	=> 'styles_menu_items',
		);

		//ACTIVE
		$fields[SHIFTNAV_PREFIX.$menu][2090] = array(
			'name'	=> 'menu_item_background_color_active',
			'label'	=> __( 'Menu Item Background Color [Active]' , 'shiftnav' ),
			'desc'	=> __( 'The color of the menu item background when activated.' , 'shiftnav' ),
			'type'	=> 'color',
			'custom_style'			=> 'menu_item_background_color_active',
			'customizer'			=> true,
			'customizer_section' 	=> 'styles_menu_items',
		);
		$fields[SHIFTNAV_PREFIX.$menu][2100] = array(
			'name'	=> 'menu_item_font_color_active',
			'label'	=> __( 'Menu Item Font Color [Active]' , 'shiftnav' ),
			'desc'	=> __( 'The color of the menu item text when activated.' , 'shiftnav' ),
			'type'	=> 'color',
			'custom_style'			=> 'menu_item_font_color_active',
			'customizer'			=> true,
			'customizer_section' 	=> 'styles_menu_items',
		);

		//CURRENT
		$fields[SHIFTNAV_PREFIX.$menu][2110] = array(
			'name'	=> 'menu_item_background_current',
			'label'	=> __( 'Menu Item Background Color [Current]' , 'shiftnav' ),
			'desc'	=> __( 'The background color of current menu items.' , 'shiftnav' ),
			'type'	=> 'color',
			'custom_style'			=> 'menu_item_background_current',
			'customizer'			=> true,
			'customizer_section' 	=> 'styles_menu_items',
		);
		$fields[SHIFTNAV_PREFIX.$menu][2120] = array(
			'name'	=> 'menu_item_font_color_current',
			'label'	=> __( 'Menu Item Font Color [Current]' , 'shiftnav' ),
			'desc'	=> __( 'The font color of current menu items' , 'shiftnav' ),
			'type'	=> 'color',
			'custom_style'			=> 'menu_item_font_color_current',
			'customizer'			=> true,
			'customizer_section' 	=> 'styles_menu_items',
		);

		//HIGHLIGHTED TARGETS
		$fields[SHIFTNAV_PREFIX.$menu][2140] = array(
			'name'	=> 'menu_item_background_highlight',
			'label'	=> __( 'Menu Item Background Color [Highlight]' , 'shiftnav' ),
			'desc'	=> __( 'The background color of highlighted menu items.' , 'shiftnav' ),
			'type'	=> 'color',
			'custom_style'			=> 'menu_item_background_highlight',
			'customizer'			=> true,
			'customizer_section' 	=> 'styles_menu_items',
		);
		$fields[SHIFTNAV_PREFIX.$menu][2150] = array(
			'name'	=> 'menu_item_font_color_highlight',
			'label'	=> __( 'Menu Item Font Color [Highlight]' , 'shiftnav' ),
			'desc'	=> __( 'The color of highlighted menu items' , 'shiftnav' ),
			'type'	=> 'color',
			'custom_style'			=> 'menu_item_font_color_highlight',
			'customizer'			=> true,
			'customizer_section' 	=> 'styles_menu_items',
		);



		$fields[SHIFTNAV_PREFIX.$menu][2200] = array(
			'name'	=> 'menu_item_font_size',
			'label'	=> __( 'Menu Item Font Size' , 'shiftnav' ),
			'desc'	=> __( 'The size of the menu item text.' , 'shiftnav' ),
			'type'	=> 'text',
			'custom_style'			=> 'menu_item_font_size',
			'customizer'			=> true,
			'customizer_section' 	=> 'styles_menu_items',
		);
		$fields[SHIFTNAV_PREFIX.$menu][2210] = array(
			'name'	=> 'menu_item_font_weight',
			'label'	=> __( 'Menu Item Font Weight' , 'shiftnav' ),
			'desc'	=> __( 'The weight of the menu item text.' , 'shiftnav' ),
			'type'	=> 'radio',
			'options'=> array(
				''			=> __( 'Default' , 'shiftnav' ),
				'normal' 	=> __( 'Normal' , 'shiftnav' ),
				'bold' 		=> __( 'Bold' , 'shiftnav' ),
			),
			'custom_style'			=> 'menu_item_font_weight',
			'customizer'			=> true,
			'customizer_section' 	=> 'styles_menu_items',
		);
		$fields[SHIFTNAV_PREFIX.$menu][2215] = array(
			'name'	=> 'menu_item_padding',
			'label'	=> __( 'Menu Item Padding' , 'shiftnav' ),
			'desc'	=> __( 'The padding around the menu item text.' , 'shiftnav' ),
			'type'	=> 'text',
			'custom_style'			=> 'menu_item_padding',
			'customizer'			=> true,
			'customizer_section' 	=> 'styles_menu_items',
		);
		$fields[SHIFTNAV_PREFIX.$menu][2220] = array(
			'name'	=> 'menu_item_top_border_color',
			'label'	=> __( 'Menu Item Top Border Color' , 'shiftnav' ),
			'desc'	=> __( 'The color of the top border of the menu item.' , 'shiftnav' ),
			'type'	=> 'color',
			'custom_style'			=> 'menu_item_top_border_color',
			'customizer'			=> true,
			'customizer_section' 	=> 'styles_menu_items',
		);
		$fields[SHIFTNAV_PREFIX.$menu][2230] = array(
			'name'	=> 'menu_item_top_border_color_active',
			'label'	=> __( 'Menu Item Top Border Color [Active]' , 'shiftnav' ),
			'desc'	=> __( 'The color of the top border of an active menu item.' , 'shiftnav' ),
			'type'	=> 'color',
			'custom_style'			=> 'menu_item_top_border_color_active',
			'customizer'			=> true,
			'customizer_section' 	=> 'styles_menu_items',
		);
		$fields[SHIFTNAV_PREFIX.$menu][2240] = array(
			'name'	=> 'menu_item_bottom_border_color',
			'label'	=> __( 'Menu Item Bottom Border Color' , 'shiftnav' ),
			'desc'	=> __( 'The color of the bottom border of the menu item.' , 'shiftnav' ),
			'type'	=> 'color',
			'custom_style'			=> 'menu_item_bottom_border_color',
			'customizer'			=> true,
			'customizer_section' 	=> 'styles_menu_items',
		);

		$fields[SHIFTNAV_PREFIX.$menu][2250] = array(
			'name'	=> 'menu_item_bottom_border_color_active',
			'label'	=> __( 'Menu Item Bottom Border Color [Active]' , 'shiftnav' ),
			'desc'	=> __( 'The color of the bottom border of the active menu item.' , 'shiftnav' ),
			'type'	=> 'color',
			'custom_style'			=> 'menu_item_bottom_border_color_active',
			'customizer'			=> true,
			'customizer_section' 	=> 'styles_menu_items',
		);

		$fields[SHIFTNAV_PREFIX.$menu][2260] = array(
			'name'	=> 'menu_item_disable_item_borders',
			'label'	=> __( 'Disable Menu Item Borders' , 'shiftnav' ),
			'desc'	=> __( 'Remove the borders between menu items.' , 'shiftnav' ),
			'type'	=> 'checkbox',
			'default' => 'off',
			'custom_style'			=> 'menu_item_disable_item_borders',
			'customizer'			=> true,
			'customizer_section' 	=> 'styles_menu_items',
		);

		$fields[SHIFTNAV_PREFIX.$menu][2270] = array(
			'name'	=> 'menu_item_disable_text_shadow',
			'label'	=> __( 'Disable Menu Item Text Shadow' , 'shiftnav' ),
			'desc'	=> __( 'Remove the text shadow on the menu items.' , 'shiftnav' ),
			'type'	=> 'checkbox',
			'default' => 'off',
			'custom_style'			=> 'menu_item_disable_text_shadow',
			'customizer'			=> true,
			'customizer_section' 	=> 'styles_menu_items',
		);

		//TOP LEVEL TEXT TRANSFORMATION
		$fields[SHIFTNAV_PREFIX.$menu][2280] = array(
			'name'	=> 'menu_item_top_level_text_transform',
			'label'	=> __( 'Top Level Menu Item Text Transform' , 'shiftnav' ),
			'desc'	=> __( 'The font size for the header/title within the panel.' , 'shiftnav' ),
			'type'	=> 'radio',
			'options' => array(
				''			=> __( 'Default' , 'shiftnav' ),
				'none' 		=> __( 'None' , 'shiftnav' ),
				'uppercase' => __( 'Uppercase' , 'shiftnav' ),
			),
			'custom_style'			=> 'menu_item_top_level_text_transform',
			'customizer'			=> true,
			'customizer_section' 	=> 'styles_menu_items',
		);






		//ACTIVATORS (?)
		$fields[SHIFTNAV_PREFIX.$menu][2300] = array(
			'name'	=> 'menu_item_activator_background',
			'label'	=> __( 'Menu Item Activator Button Background' , 'shiftnav' ),
			'desc'	=> __( 'The background color of the button used to open and close the submenus' , 'shiftnav' ),
			'type'	=> 'color',
			'custom_style'			=> 'menu_item_activator_background',
			'customizer'			=> true,
			'customizer_section' 	=> 'styles_activators',
		);
		$fields[SHIFTNAV_PREFIX.$menu][2310] = array(
			'name'	=> 'menu_item_activator_background_hover',
			'label'	=> __( 'Menu Item Activator Button Background [Active]' , 'shiftnav' ),
			'desc'	=> __( 'The active background color of the button used to open and close the submenus' , 'shiftnav' ),
			'type'	=> 'color',
			'custom_style'			=> 'menu_item_activator_background_hover',
			'customizer'			=> true,
			'customizer_section' 	=> 'styles_activators',
		);
		$fields[SHIFTNAV_PREFIX.$menu][2320] = array(
			'name'	=> 'menu_item_activator_color',
			'label'	=> __( 'Menu Item Activator Arrow Color' , 'shiftnav' ),
			'desc'	=> __( 'The arrow color of the button used to open and close the submenus' , 'shiftnav' ),
			'type'	=> 'color',
			'custom_style'			=> 'menu_item_activator_color',
			'customizer'			=> true,
			'customizer_section' 	=> 'styles_activators',
		);
		$fields[SHIFTNAV_PREFIX.$menu][2330] = array(
			'name'	=> 'menu_item_activator_color_hover',
			'label'	=> __( 'Menu Item Activator Arrow Color [Active]' , 'shiftnav' ),
			'desc'	=> __( 'The active arrow color of the button used to open and close the submenus' , 'shiftnav' ),
			'type'	=> 'color',
			'custom_style'			=> 'menu_item_activator_color_hover',
			'customizer'			=> true,
			'customizer_section' 	=> 'styles_activators',
		);










		//RETRACTORS
		$fields[SHIFTNAV_PREFIX.$menu][2500] = array(
			'name'	=> 'menu_retractor_background',
			'label'	=> __( 'Submenu Retractor / Back Button Background' , 'shiftnav' ),
			'desc'	=> __( 'The background color of the submenu retractor button' , 'shiftnav' ),
			'type'	=> 'color',
			'custom_style'			=> 'menu_retractor_background',
			'customizer'			=> true,
			'customizer_section' 	=> 'styles_activators',
		);
		$fields[SHIFTNAV_PREFIX.$menu][2510] = array(
			'name'	=> 'menu_retractor_font_color',
			'label'	=> __( 'Submenu Retractor / Back Button Font Color' , 'shiftnav' ),
			'desc'	=> __( 'The font color of the submenu retractor button' , 'shiftnav' ),
			'type'	=> 'color',
			'custom_style'			=> 'menu_retractor_font_color',
			'customizer'			=> true,
			'customizer_section' 	=> 'styles_activators',
		);
		$fields[SHIFTNAV_PREFIX.$menu][2520] = array(
			'name'	=> 'menu_retractor_text_align',
			'label'	=> __( 'Submenu Retractor / Back Button Alignment' , 'shiftnav' ),
			'desc'	=> __( 'The alignment of the submenu retractor button text' , 'shiftnav' ),
			'type'	=> 'radio',
			'options'=> array(
				''			=> __( 'Default' , 'shiftnav' ),
				'center' 	=> __( 'Center' , 'shiftnav' ),
				'left' 		=> __( 'Left' , 'shiftnav' ),
				'right' 	=> __( 'Right' , 'shiftnav' ),
			),
			'custom_style'			=> 'menu_retractor_text_align',
			'customizer'			=> true,
			'customizer_section' 	=> 'styles_activators',
		);



		//SUBMENUS
		$fields[SHIFTNAV_PREFIX.$menu][2600] = array(
			'name'	=> 'submenu_background',
			'label'	=> __( 'Submenu Background Color' , 'shiftnav' ),
			'desc'	=> __( 'The background color of the submenu' , 'shiftnav' ),
			'type'	=> 'color',
			'custom_style'			=> 'submenu_background',
			'customizer'			=> true,
			'customizer_section' 	=> 'styles_submenus',
		);

		$fields[SHIFTNAV_PREFIX.$menu][2610] = array(
			'name'	=> 'submenu_item_background',
			'label'	=> __( 'Submenu Item Background Color' , 'shiftnav' ),
			'desc'	=> __( 'The background color of the individual submenu items' , 'shiftnav' ),
			'type'	=> 'color',
			'custom_style'			=> 'submenu_item_background',
			'customizer'			=> true,
			'customizer_section' 	=> 'styles_submenus',
		);

		$fields[SHIFTNAV_PREFIX.$menu][2620] = array(
			'name'	=> 'submenu_item_color',
			'label'	=> __( 'Submenu Item Font Color' , 'shiftnav' ),
			'desc'	=> __( 'The font color of the submenu items' , 'shiftnav' ),
			'type'	=> 'color',
			'custom_style'			=> 'submenu_item_font_color',
			'customizer'			=> true,
			'customizer_section' 	=> 'styles_submenus',
		);
		$fields[SHIFTNAV_PREFIX.$menu][2630] = array(
			'name'	=> 'submenu_item_border_top_color',
			'label'	=> __( 'Submenu Item Top Border Color' , 'shiftnav' ),
			'desc'	=> __( 'The color of the submenu item top border' , 'shiftnav' ),
			'type'	=> 'color',
			'custom_style'			=> 'submenu_item_border_top_color',
			'customizer'			=> true,
			'customizer_section' 	=> 'styles_submenus',
		);
		$fields[SHIFTNAV_PREFIX.$menu][2640] = array(
			'name'	=> 'submenu_item_border_bottom_color',
			'label'	=> __( 'Submenu Item Bottom Border Color' , 'shiftnav' ),
			'desc'	=> __( 'The color of the bottom border of the submenu items' , 'shiftnav' ),
			'type'	=> 'color',
			'custom_style'			=> 'submenu_item_border_bottom_color',
			'customizer'			=> true,
			'customizer_section' 	=> 'styles_submenus',
		);

		$fields[SHIFTNAV_PREFIX.$menu][2670] = array(
			'name'	=> 'menu_item_disable_item_borders',
			'label'	=> __( 'Disable Menu Item Borders' , 'shiftnav' ),
			'desc'	=> __( 'Remove the borders between menu items.' , 'shiftnav' ),
			'type'	=> 'checkbox',
			'default' => 'off',
			'custom_style'			=> 'menu_item_disable_item_borders',
			'customizer'			=> true,
			'customizer_section' 	=> 'styles_menu_items',
		);
		$fields[SHIFTNAV_PREFIX.$menu][2680] = array(
			'name'	=> 'submenu_item_font_size',
			'label'	=> __( 'Submenu Item Font Size' , 'shiftnav' ),
			'desc'	=> __( 'The font size of the submenu items' , 'shiftnav' ),
			'type'	=> 'text',
			'custom_style'			=> 'submenu_item_font_size',
			'customizer'			=> true,
			'customizer_section' 	=> 'styles_submenus',
		);
		$fields[SHIFTNAV_PREFIX.$menu][2690] = array(
			'name'	=> 'submenu_item_font_weight',
			'label'	=> __( 'Submenu Item Font Weight' , 'shiftnav' ),
			'desc'	=> __( 'The font weight of the submenu items' , 'shiftnav' ),
			'type'	=> 'radio',
			'options'=> array(
				''			=> __( 'Default' , 'shiftnav' ),
				'normal' 	=> __( 'Normal' , 'shiftnav' ),
				'bold' 		=> __( 'Bold' , 'shiftnav' ),
			),
			'custom_style'			=> 'submenu_item_font_weight',
			'customizer'			=> true,
			'customizer_section' 	=> 'styles_submenus',
		);



		$fields[SHIFTNAV_PREFIX.$menu][2800] = array(
			'name'	=> 'font_family',
			'label'	=> __( 'Font Family' , 'shiftnav' ),
			'desc'	=> __( 'The font family the panel.  This should be a system font or else the font assets should already be loaded on your site, via @font-face or Google Fonts for example.' , 'shiftnav' ),
			'type'	=> 'text',
			'custom_style'			=> 'font_family',
			'customizer'			=> true,
			'customizer_section' 	=> 'styles_font',
		);

	}

	return $fields;

}
