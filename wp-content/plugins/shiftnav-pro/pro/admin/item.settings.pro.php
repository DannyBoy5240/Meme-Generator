<?php

function shiftnav_pro_menu_item_settings( $settings ){
	
	$settings['general'][5] = array(
		'id' 		=> 'anchor_class',
		'title'		=> 'Custom Anchor Class',
		'type'		=> 'text',
		'default' 	=> '',
		'desc'		=> 'Custom class to be applied to the anchor.',
	);

	$settings['general'][30] = array(
		'id' 		=> 'icon',
		'title'		=> __( 'Icon', 'shiftnav' ),
		'type'		=> 'icon',
		'default' 	=> '',
		'desc'		=> '',
		'ops'		=> shiftnav_get_icon_ops()
	);
	$settings['general'][31] = array(
		'id' 		=> 'icon_custom_class',
		'title'		=> __( 'Custom Icon Class', 'shiftnav' ),
		'type'		=> 'text',
		'default' 	=> '',
		'desc'		=> 'Add a custom class to the &lt;i&gt; tag. If an icon is set above, this class will be appended. If no icon is set above, an icon will appear with this class.',
	);

	$settings['general'][35] = array(
		'id' 		=> 'disable_text',
		'title'		=> 'Disable Text',
		'type'		=> 'checkbox',
		'default' 	=> 'off',
		'desc'		=> 'Disable the text of this menu item.  Useful for displaying only an icon',
	);

	
	$settings['general'][50] = array(
		'id' 		=> 'custom_url',
		'title'		=> __( 'Custom URL' , 'shiftnav' ),
		'type'		=> 'text',
		'default' 	=> '',
		'desc'		=> __( 'Customize your link URL - you can use shortcodes here.  Your setting will be escaped with the esc_url() function', 'shiftnav' ),
	);

	$settings['submenu'][20] = array(
		'id' 		=> 'submenu_type',
		'title'		=> __( 'Submenu Type', 'shiftnav' ),
		'type'		=> 'select',
		'default'	=> 'default',
		'desc'		=>  __( 'Overrides the default submenu type, which can be set in the Control Panel for each menu. ' , 'shiftnav' ),
		'ops'		=> array(
						'default'	=>  __( 'Menu Default', 'shiftnav' ),
						'always'	=>	__( 'Always visible', 'shiftnav' ),
						'accordion'	=>	__( 'Accordion', 'shiftnav' ),
						'shift'		=>	__( 'Shift', 'shiftnav' ),
					),
	);

	return $settings;
}
add_filter( 'shiftnav_menu_item_settings' , 'shiftnav_pro_menu_item_settings' );