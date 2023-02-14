<?php

function shiftnav_settings_links(){
	echo '<a target="_blank" class="button button-primary" href="http://sevenspark.com/docs/shiftnav"><i class="fa fa-book"></i> Knowledgebase</a> ';
}
add_action( 'shiftnav_settings_before_title' , 'shiftnav_settings_links' );

function shiftnav_get_settings_fields(){

	$prefix = SHIFTNAV_PREFIX;


	$main_assigned = '';
	if(!has_nav_menu('shiftnav')){
		$main_assigned = 'No Menu Assigned';
	}
	else{
    	$menus = get_nav_menu_locations();
    	$menu_title = wp_get_nav_menu_object($menus['shiftnav'])->name;
    	$main_assigned = $menu_title;
    }

    $main_assigned = '<span class="shiftnav-main-assigned">'.$main_assigned.'</span>  <p class="shiftnav-desc-understated">The menu assigned to the <strong>ShiftNav [Main]</strong> theme location will be displayed.  <a href="'.admin_url( 'nav-menus.php?action=locations' ).'">Assign a menu</a></p>';


    $menu = 'shiftnav-main';
    $integration_code = '
    		<p style="margin-bottom:14px;" class="shiftnav-notice">In most instances, you will not need this.  The main Toggle Bar is automatically loaded, and will toggle this Main ShiftNav instance.  If you want to create your own custom toggle, you can use the code below and optionally disable the main Toggle Bar.</p>
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



	$fields = array(


		$prefix.'shiftnav-main' => array(

			10 => array(
				'name'	=> 'menu_assignment',
				'label'	=> __( 'Assigned Menu' , 'shiftnav' ),
				'desc'	=> $main_assigned,
				'type'	=> 'html',

			),

			20 => array(
				'name' => 'display_main',
				'label' => __( 'Display Main ShiftNav Panel', 'shiftnav' ),
				'desc' => __( 'Do not uncheck this unless you want to disable the main ShiftNav panel entirely.', 'shiftnav' ),
				'type' => 'checkbox',
				'default' => 'on',
				'customizer'			=> true,
				'customizer_section' 	=> 'config',
			),




			30 => array(
				'name'		=> 'edge',
				'label'		=> __( 'Edge' , 'shiftnav' ),
				'type'		=> 'radio',
				'desc'		=> __( 'Which edge of the viewport should the ShiftNav panel appear on?', 'ubermenu' ),
				'options' 	=> array(
					'left' 	=> 'Left',
					'right'	=> 'Right',
				),
				'default' 	=> 'left',
				'customizer'			=> true,
				'customizer_section' 	=> 'config',

			),


			50 => array(
				'name'	=> 'skin',
				'label'	=> __( 'Skin' , 'shiftnav' ),
				'type'	=> 'select',
				'desc'	=> 'Select the base skin for your menu.  You can override styles in the Customizer settings.  Choose "custom.css" to write your own skin - see <a href="https://sevenspark.com/docs/shiftnav/customize/custom-stylesheet-custom-css">Custom Stylesheet (custom.css)</a>',
				'options' => shiftnav_get_skin_ops(),
				'default' => 'standard-dark',
				//'options' => get_registered_nav_menus()
				'customizer'			=> true,
				'customizer_section' 	=> SHIFTNAV_PRO ? 'styles_panel' : 'config',
			),

			60 => array(
				'name'		=> 'indent_submenus',
				'label'		=> __( 'Indent Always Visible Submenus' , 'shiftnav' ),
				'desc'		=> __( 'Check this to indent submenu items of always-visible submenus' , 'shiftnav' ),
				'type'		=> 'checkbox',
				'default'	=> 'off',
				'customizer'			=> true,
				'customizer_section' 	=> 'config',
			),

			70 => array(
				'name' => 'display_site_title',
				'label' => __( 'Display Site Title', 'shiftnav' ),
				'desc' => __( 'Display the site title in the menu panel', 'shiftnav' ),
				'type' => 'checkbox',
				'default' => 'on',
				'customizer'			=> true,
				'customizer_section' 	=> 'content',
			),

			80 => array(
				'name' => 'display_panel_close_button',
				'label' => __( 'Display Panel Close Button', 'shiftnav' ),
				'desc' => __( 'Display an &times; close button in the upper right of the ShiftNav panel', 'shiftnav' ),
				'type' => 'checkbox',
				'default' => 'off',
				'customizer'			=> true,
				'customizer_section' 	=> 'config',
			),

			//After pro settings, before customizer settings
			1100 => array(
				'name'	=> 'php',
				'label'	=> __( 'Custom Toggle Integration Code' , 'shiftnav' ),
				'desc'	=> $integration_code,
				'type'	=> 'html',
			),




			/*
			array(
				'name' => 'inherit_ubermenu_icons',
				'label' => __( 'Inherit UberMenu Icons', 'shiftnav' ),
				'desc' => __( 'Display the icon from the UberMenu icon setting if no icon is selected', 'shiftnav' ),
				'type' => 'checkbox',
				'default' => 'off'
			),
			*/

		),
			// array(
			// 	'name'	=> 'section_toggle',
			// 	'label'	=> '<h4 class="shiftnav-settings-section">'.__( 'Top Bar Toggle Settings' , 'shiftnav' ).'</h4>',
			// 	'desc'	=> '<span class="shiftnav-desc-understated">'.__( 'These settings control the main ShiftNav toggle' , 'shiftnav' ).'</span>',
			// 	'type'	=> 'html',
			// ),


		$prefix.'togglebar' => array(
			10 => array(
				'name' => 'display_toggle',
				'label' => __( 'Display Toggle Bar', 'shiftnav' ),
				'desc' => __( 'Uncheck this to disable the default toggle bar and add your own custom toggle', 'shiftnav' ),
				'type' => 'checkbox',
				'default' => 'on',
				'customizer'			=> true,
				'customizer_section' 	=> 'config',
			),
			15 => array(
				'name' => 'toggle_bar_style',
				'label' => __( 'Toggle Bar Style', 'shiftnav' ),
				'desc' => __( 'Choose whether to have a full width bar, which can include a title and other content, or just a hamburger button only which will appear in the upper corner of the site.', 'shiftnav' ),
				'type'	=> 'radio',
				'options' => array(
					'full_bar'		=> __( 'Full Bar' , 'shiftnav' ),
					'burger_only'	=> __( 'Hamburger button only' , 'shiftnav' ),
				),
				'default' => 'full_bar',
				'customizer'			=> true,
				'customizer_section' 	=> 'config',
			),
			20 => array(
				'name' => 'breakpoint',
				'label' => __( 'Toggle Breakpoint', 'shiftnav' ),
				'desc' => __( 'Show the toggle bar only below this pixel width. 960 is a good default for most sites.  Leave blank to show the toggle bar at all times.  No need to include "px"', 'shiftnav' ).'<p class="shiftnav-notice">'.__( 'Set this to use ShiftNav only at mobile sizes' , 'shiftnav' ).'</p>',
				'type' => 'text',
				'default' => '',
				'customizer'			=> true,
				'customizer_section' 	=> 'config',
			),
			30 => array(
				'name' => 'hide_theme_menu',
				'label' => __( 'Hide Theme Menu', 'shiftnav' ),
				'desc' => __( 'Enter the selector of the theme\'s menu if you wish to hide it below the breakpoint above.  For example, <code>#primary-nav</code> or <code>.topnav</code>. ', 'shiftnav' ). '<p class="shiftnav-notice">'.__( 'This setting requires you to set the <strong>Toggle Breakpoint</strong> setting for it to have an effect' , 'shiftnav' ).'</p>',
				'type' => 'text',
				'default' => '',
				'customizer'			=> true,
				'customizer_section' 	=> 'config',
			),
			40 => array(
				'name' => 'hide_ubermenu',
				'label' => __( 'Hide UberMenu 3', 'shiftnav' ),
				'desc' => __( 'Hide all UberMenu 3 instances when ShiftNav is displayed.  If you would like to only hide a specific UberMenu, use the setting above with a specific UberMenu ID.', 'shiftnav' ) . ' ( <a href="http://wpmegamenu.com">What is UberMenu?</a> )'.'<p class="shiftnav-notice">'.__( 'This setting requires you to set the <strong>Toggle Breakpoint</strong> setting for it to have an effect' , 'shiftnav' ).'</p>',
				'type' => 'checkbox',
				'default' => 'off',
				'customizer'			=> true,
				'customizer_section' 	=> 'config',
			),


			50 => array(
				'name'	=> 'toggle_content',
				'label'	=> __( 'Toggle Content' , 'shiftnav' ),
				'desc'	=> __( 'The content to display in the main toggle bar (only valid for Full Width toggle bar style).  Can contain shortcodes and HTML, including <img> tags.  Default: [shift_toggle_title] will print the site title' , 'shiftnav' ),
				'type'	=> 'textarea',
				'default' => '[shift_toggle_title]', //get_bloginfo( 'title' )
				'sanitize_callback' => 'shiftnav_allow_html',
				'customizer'			=> true,
				'customizer_section' 	=> 'config',
			),



			60 => array(
				'name'	=> 'toggle_target',
				'label'	=> __( 'Toggle Target' , 'shiftnav' ),
				'desc'	=> __( 'The area which will trigger the ShiftNav Panel to open.  (Not relevant for Full Bar toggle style)' ),
				'type'	=> 'radio',
				'options'	=> array(
					'burger_only'	=> __( 'Bars/Burger Icon Only' , 'shiftnav' ),
					'entire_bar'	=> __( 'Entire Bar' , 'shiftnav' ),
				),
				'default'	=> 'burger_only',
			),

			70 => array(
				'name'	=> 'toggle_close_icon',
				'label' => __( 'Close Icon' , 'shiftnav' ),
				'desc'	=> __( 'When the toggle is open, choose which icon to display.', 'shiftnav' ),
				'type'	=> 'radio',
				'options' => array(
					'bars'	=> '<i class="fa fa-bars"></i> Hamburger Bars',
					'x'		=> '<i class="fa fa-times"></i> Close button',
				),
				'default' => 'x',
				'customizer'			=> true,
				'customizer_section' 	=> 'config',
				'customizer_control'	=> 'radio_html'
			),
			80 => array(
				'name'	=> 'toggle_position',
				'label' => __( 'Toggle Bar Position' , 'shiftnav' ),
				'desc'	=> __( 'Choose Fixed if you\'d like the toggle bar to always be visible, or Absolute if you\'d like it only to be visible when scrolled to the very top of the page', 'shiftnav' ),
				'type'	=> 'radio',
				'options' => array(
					'fixed'		=> __( 'Fixed (always in viewport)', 'shiftnav' ),
					'absolute'	=> __( 'Absolute (scrolls out of viewport)' , 'shiftnav' ),
				),
				'default' => 'fixed',
				'customizer'			=> true,
				'customizer_section' 	=> 'config',
			),

			90 => array(
				'name'	=> 'align',
				'label' => __( 'Align Text' , 'shiftnav' ),
				'desc'	=> __( 'Align text left, right, or center.  Applies to inline elements only.', 'shiftnav' ),
				'type'	=> 'radio',
				'options' => array(
					'center'=> 'Center',
					'left'	=> 'Left',
					'right'	=> 'Right',
				),
				'default' => 'center',
				'customizer'			=> true,
				'customizer_section' 	=> 'config',
			),

			100 => array(
				'name'	=> 'background_color',
				'label'	=> __( 'Background Color' , 'shiftnav' ),
				'desc'	=> __( '' , 'shiftnav' ),
				'type'	=> 'color',
				//'default' => '#1D1D20',
				'custom_style'			=> 'togglebar_background',
				'customizer'			=> true,
				'customizer_section' 	=> 'styles',
			),

			105 => array(
				'name'	=> 'background_transparent',
				'label'	=> __( 'Transparent Background' , 'shiftnav' ),
				'desc'	=> __( 'Make the toggle bar transparent.  Note that this only make sense if you are using a hamburger-only Toggle Bar Style, or remove the Toggle Bar Gap' , 'shiftnav' ),
				'type'	=> 'checkbox',
				'default'	=> 'off',
				//'default' => '#1D1D20',
				//'custom_style'			=> 'togglebar_background',
				'customizer'			=> true,
				'customizer_section' 	=> 'styles',
			),

			110 => array(
				'name'	=> 'text_color',
				'label'	=> __( 'Text/Burger Color' , 'shiftnav' ),
				'desc'	=> __( '' , 'shiftnav' ),
				'type'	=> 'color',
				'custom_style'			=> 'togglebar_font_color',
				'customizer'			=> true,
				'customizer_section' 	=> 'styles',
			),

			120 => array(
				'name' => 'font_size',
				'label' => __( 'Font Size', 'shiftnav' ),
				'desc' => __( 'Override the default font size of the toggle bar by setting a value here.', 'shiftnav' ),
				'type' => 'text',
				'default' => '',
				'custom_style'			=> 'togglebar_font_size',
				'customizer'			=> true,
				'customizer_section' 	=> 'styles',
			),

			130 => array(
				'name' => 'togglebar_hamburger_size',
				'label' => __( 'Hamburger Size', 'shiftnav' ),
				'desc' => __( 'Size of the hamburger icon in pixels (font size).', 'shiftnav' ),
				'type' => 'text',
				'default' => '',
				'custom_style'			=> 'togglebar_hamburger_size',
				'customizer'			=> true,
				'customizer_section' 	=> 'styles',
			),


			140 => array(
				'name' => 'togglebar_gap',
				'label' => __( 'Toggle Bar Gap', 'shiftnav' ),
				'desc' => __( 'By default, ShiftNav will automatically determine if a gap is needed - in short, space is left for the full bar toggle, and is not left for a burger-only toggle.  If you wish to override this, you can do so here.', 'shiftnav' ),
				'type' => 'radio',
				'options'	=> array(
					'auto'	=> __( 'Automatic' , 'shiftnav' ),
					'off'	=> __( 'Disable Gap' , 'shiftnav' ),
					'on'	=> __( 'Enable Gap' , 'shiftnav' ),
				),
				'default' => 'auto',
				'customizer'			=> true,
				'customizer_section' 	=> 'styles',
			),

			150 => array(
				'name' => 'aria_label',
				'label' => __( 'Toggle Button ARIA Label', 'shiftnav' ),
				'desc' => __( 'The value for the aria-label attribute', 'shiftnav' ),
				'type' => 'text',
				'default' => 'Toggle Menu',
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

		),

	);

	$fields = apply_filters( 'shiftnav_settings_panel_fields' , $fields );

	$fields[$prefix.'general'] = array(

		10 => array(
			'name'	=> 'css_tweaks',
			'label'	=> __( 'CSS Tweaks' , 'shiftnav' ),
			'desc'	=> __( 'Add custom CSS here, which will be printed in the site head.' , 'shiftnav' ),
			'type'	=> 'textarea',
			'sanitize_callback' => 'shiftnav_allow_html',
		),

		20 => array(
			'name' 		=> 'shift_body',
			'label' 	=> __( 'Shift Body', 'shiftnav' ),
			'desc' 		=> __( 'Shift the body of the site when the menu is revealed.  For some themes, this may negatively affect the site content, so this can be disabled.', 'shiftnav' ),
			'type' 		=> 'checkbox',
			'default' 	=> 'off'
		),

		30 => array(
			'name' 		=> 'shift_body_wrapper',
			'label' 	=> __( 'Shift Body Wrapper', 'shiftnav' ),
			'desc' 		=> __( 'Leave this blank to automatically create a ShiftNav Wrapper via javascript (this may have side effects).  Set a selector here to turn a specific div (which must wrap all body contents) into the wrapper.  Please note that if the wrapper you select is also styled by the theme, this may cause a conflict.', 'shiftnav' ),
			'type' 		=> 'text',
			'default' 	=> ''
		),

		40 => array(
			'name'	=> 'footer_content',
			'label'	=> __( 'Footer Content' , 'shiftnav' ),
			'desc'	=> __( 'Add HTML or Shortcodes here and it will be injected at the wp_footer() hook.  Useful for fixed position elements' , 'shiftnav' ),
			'type'	=> 'textarea',
			'sanitize_callback' => 'shiftnav_allow_html',
		),

		50 => array(
			'name'	=> 'mobile_only',
			'label'	=> __( 'Mobile Only' , 'shiftnav' ),
			'desc'	=> __( 'Only display ShiftNav when a mobile device is detected via wp_is_mobile().  If you are using a caching plugin, make sure you have separate mobile and desktop caches.' , 'shiftnav' ).'<p class="shiftnav-notice">'.__( 'This is NOT the preferred way to make your menu appear on mobile devices.  For 99% of users, you will want to set a Toggle Breakpoint in the Toggle Bar Panel, rather than using this setting.' , 'shiftnav' ).'</p>',
			'type'	=> 'checkbox',
			'default'=> 'off',
		),

		60 => array(
			'name' => 'target_size',
			'label' => __( 'Button Size', 'shiftnav' ),
			'desc' => __( 'The size of the padding on the links in the menu.  The larger the setting, the easier to click; but fewer menu items will appear on the screen at a time.', 'shiftnav' ),
			'type' => 'radio',
			'options' => array(
				'default' 	=> 'Default',
				'medium' 	=> 'Medium',
				'large'		=> 'Large',
				'enormous' 	=> 'Enormous',
			),
			'default' => 'default',
		),

		70 => array(
			'name' => 'text_size',
			'label' => __( 'Text Size', 'shiftnav' ),
			'desc' => __( 'The size of the font on the links in the menu (will override all levels).', 'shiftnav' ),
			'type' => 'radio',
			'options' => array(
				'default' 	=> 'Default',
				'small'		=> 'Small',
				'medium' 	=> 'Medium',
				'large'		=> 'Large',
				'enormous' 	=> 'Enormous',
			),
			'default' => 'default',
		),

		80 => array(
			'name' => 'icon_size',
			'label' => __( 'Icon Size', 'shiftnav' ),
			'desc' => __( 'The size of the icons in the menu.', 'shiftnav' ),
			'type' => 'radio',
			'options' => array(
				'default' 	=> 'Default',
				'small'		=> 'Small',
				'medium' 	=> 'Medium',
				'large'		=> 'Large',
				'enormous' 	=> 'Enormous',
			),
			'default' => 'default',
		),



		90 => array(
			'name'		=> 'disable_transforms',
			'label'		=> __( 'Disable Transforms &amp; Transitions' , 'shiftnav' ),
			'desc'		=> __( 'Disable CSS3 transformations and transitions.  This will disable smooth animations, but may work better on browsers that don\'t properly implement CSS3 transforms, especially old non-standard Android browsers.  Note that ShiftNav attempts to detect these browsers and fall back automatically, but some browsers have incomplete implementations of CSS3 transforms, which produce false positives when testing.' , 'shiftnav' ),
			'type'		=> 'checkbox',
			'default'	=> 'off',
		),

		100 => array(
			'name' 		=> 'touch_off_close',
			'label' 	=> __( 'Touch-off close', 'shiftnav' ),
			'desc' 		=> __( 'Close the ShiftNav panel or search dropdown when touching any content not in the panel.', 'shiftnav' ),
			'type' 		=> 'checkbox',
			'default' 	=> 'on'
		),


		110 => array(
			'name'		=> 'close_on_target_click',
			'label'		=> __( 'Close panel on menu link click', 'shiftnav' ),
			'desc'		=> __( 'Immediately close the panel when a link in the menu is clicked (prior to redirect)' ),
			'type'		=> 'checkbox',
			'default'	=> 'off',
		),

		120 => array(
			'name' 		=> 'scroll_offset',
			'label' 	=> __( 'Scroll Offset', 'shiftnav' ),
			'desc' 		=> __( 'When using the ScrollTo functionality, this is the number of pixels to offset the scroll by, to account for the toggle bar and any spacing you want.', 'shiftnav' ),
			'type' 		=> 'text',
			'input_type' => 'number',
			'default' 	=> 100,
		),








		160 => array(
			'name' 		=> 'open_current',
			'label' 	=> __( 'Open Current Accordion Submenu', 'shiftnav' ),
			'desc' 		=> __( 'Open the submenu of the current menu item on page load (accordion submenus only).', 'shiftnav' ),
			'type' 		=> 'checkbox',
			'default' 	=> 'off'
		),

		170 => array(
			'name' 		=> 'collapse_accordions',
			'label' 	=> __( 'Collapse Accordions', 'shiftnav' ),
			'desc' 		=> __( 'When an accordion menu is opened, collapse any other accordions on that level.', 'shiftnav' ),
			'type' 		=> 'checkbox',
			'default' 	=> 'off'
		),

		180 => array(
			'name' 		=> 'scroll_panel',
			'label' 	=> __( 'Scroll Shift Submenus to Top', 'shiftnav' ),
			'desc' 		=> __( 'When a Shift submenu is activated, scroll that item to the top to maximize submenu visibility.', 'shiftnav' ),
			'type' 		=> 'checkbox',
			'default' 	=> 'on'
		),


		190 => array(
			'name' 		=> 'active_on_hover',
			'label' 	=> __( 'Highlight Targets on Hover', 'shiftnav' ),
			'desc' 		=> __( 'With this setting enabled, the links will be highlighted when hovered or touched.', 'shiftnav' ),
			'type' 		=> 'checkbox',
			'default' 	=> 'off'
		),

		200 => array(
			'name' 		=> 'active_highlight',
			'label' 	=> __( 'Highlight Targets on :active', 'shiftnav' ),
			'desc' 		=> __( 'With this setting enabled, the links will be highlighted while in the :active state.  May not be desirable for touch scrolling.', 'shiftnav' ),
			'type' 		=> 'checkbox',
			'default' 	=> 'off'
		),

		210 => array(
			'name' 		=> 'back_tag',
			'label' 	=> __( 'Back Button Tag', 'shiftnav' ),
			'desc' 		=> __( 'By default the tag is an anchor.  Some themes will try to add JS to the anchor and break the back button functionality, so you can also switch this to a span to avoid the issue.', 'shiftnav' ),
			'type' 		=> 'radio',
			'options'	=> array(
							'a'	=> '&lt;a&gt;',
							'span'	=> '&lt;span&gt;',
			),
			'default' 	=> 'a'
		),

		211 => array(
			'name' 		=> 'back_text',
			'label' 	=> __( 'Back Button Text', 'shiftnav' ),
			'desc' 		=> __( 'By default, the Back button text will read "Back".  You can change this here.  Note that if you set a value here, it will no longer be translatable.', 'shiftnav' ),
			'type' 		=> 'text',
			'default' 	=> ''
		),
		212 => array(
			'name' 		=> 'back_button_top',
			'label' 	=> __( 'Top Back Button', 'shiftnav' ),
			'desc' 		=> __( 'Display a back button at the top of shift submenus (below the parent item)', 'shiftnav' ),
			'type' 		=> 'checkbox',
			'default' 	=> 'off'
		),
		213 => array(
			'name' 		=> 'back_button_bottom',
			'label' 	=> __( 'Bottom Back Button', 'shiftnav' ),
			'desc' 		=> __( 'Display a back button at the bottom of shift submenus.  Note that you must leave at least one back button enabled for users to be able to move back up a level.', 'shiftnav' ),
			'type' 		=> 'checkbox',
			'default' 	=> 'on'
		),

		220 => array(
			'name' 		=> 'admin_tips',
			'label' 	=> __( 'Show Tips to Admins', 'shiftnav' ),
			'desc' 		=> __( 'Display tips to admin users', 'shiftnav' ),
			'type' 		=> 'checkbox',
			'default' 	=> 'on'
		),

		230 => array(
			'name' 		=> 'lock_body_x',
			'label' 	=> __( 'Lock Horizontal Scroll', 'shiftnav' ),
			'desc' 		=> __( 'Attempt to prevent the content from scrolling horizontally when the menu is active.  On some themes, may also prevent vertical scrolling.  May not prevent touch scrolling in Chrome.  No effect if <strong>Shift Body</strong> is disabled.', 'shiftnav' ),
			'type' 		=> 'checkbox',
			'default' 	=> 'off'
		),

		240 => array(
			'name' 		=> 'lock_body',
			'label' 	=> __( 'Lock Scroll', 'shiftnav' ),
			'desc' 		=> __( 'Lock both vertical and horizontal scrolling on site content when menu is active.  No effect if <strong>Shift Body</strong> is disabled.', 'shiftnav' ),
			'type' 		=> 'checkbox',
			'default' 	=> 'on'
		),

		250 => array(
			'name' 		=> 'load_fontawesome',
			'label' 	=> __( 'Load Font Awesome', 'shiftnav' ),
			'desc' 		=> __( 'If you are already loading Font Awesome 4 elsewhere in your setup, you can disable this.', 'shiftnav' ),
			'type' 		=> 'checkbox',
			'default' 	=> 'on'
		),

		260 => array(
			'name' => 'inherit_ubermenu_conditionals',
			'label' => __( 'Inherit UberMenu Conditionals', 'shiftnav' ),
			'desc' => __( 'Display menu items based on UberMenu Conditionals settings', 'shiftnav' ),
			'type' => 'checkbox',
			'default' => 'off'
		),

		261 => array(
			'name' => 'process_uber_segments',
			'label' => __( 'Process UberMenu Menu Segments', 'shiftnav' ),
			'desc' => __( 'Most UberMenu Advanced Items will be ignored by ShiftNav, as they are UberMenu-specific.  However, ShiftNav can process UberMenu Menu Segments with this setting enabled.', 'shiftnav' ),
			'type' => 'checkbox',
			'default' => 'on'
		),


		270 => array(
			'name' 		=> 'force_filter',
			'label' 	=> __( 'Force Filter Menu Args', 'shiftnav' ),
			'desc' 		=> __( 'Some themes will filter the menu arguments on all menus on the site, which can break things.  This will re-filter those arguments for ShiftNav menus only.', 'shiftnav' ),
			'type' 		=> 'checkbox',
			'default' 	=> 'off'
		),

		280 => array(
			'name' 		=> 'kill_class_filter',
			'label' 	=> __( 'Kill Menu Class Filter', 'shiftnav' ),
			'desc' 		=> __( 'Some themes filter the menu item classes and strip out core WordPress functionality.  This will change the structure of ShiftNav and prevent styles from being applies.  This will prevent any actions on the <code>nav_menu_css_class</code> filter.', 'shiftnav' ),
			'type' 		=> 'checkbox',
			'default' 	=> 'off'
		),



		/*
		array(
			'name' => 'multicheck',
			'label' => __( 'Multile checkbox', 'shiftnav' ),
			'desc' => __( 'Multi checkbox description', 'shiftnav' ),
			'type' => 'multicheck',
			'options' => array(
				'one' => 'One',
				'two' => 'Two',
				'three' => 'Three',
				'four' => 'Four'
			)
		),
		array(
			'name' => 'selectbox',
			'label' => __( 'A Dropdown', 'shiftnav' ),
			'desc' => __( 'Dropdown description', 'shiftnav' ),
			'type' => 'select',
			'default' => 'no',
			'options' => array(
				'yes' => 'Yes',
				'no' => 'No'
			)
		)
		*/

	);

	if( SHIFTNAV_PRO ){
		$gen = SHIFTNAV_PREFIX.'general';
		$fields[$gen][130] = array(
			'name' 		=> 'scroll_top_boundary',
			'label' 	=> __( 'Scroll Top Boundary', 'shiftnav' ),
			'desc' 		=> __( '(Unrelated to ScrollTo or Scroll Offset).  Pixel distance from the top of the viewport at which the user is considered to have scrolled to the top.  Used for the Hide Toggle Bar on Scroll Down setting.', 'shiftnav' ),
			'type' 		=> 'text',
			'input_type' => 'number',
			'default' 	=> 50,
		);
		$fields[$gen][131] = array(
			'name' 		=> 'scroll_tolerance',
			'label' 	=> __( 'Scroll Tolerance', 'shiftnav' ),
			'desc' 		=> __( '(Unrelated to ScrollTo or Scroll Offset).  Pixel distance the user must scroll to trigger an up/down direction change.  Used for the Hide Toggle Bar on Scroll Down setting.', 'shiftnav' ),
			'type' 		=> 'text',
			'input_type' => 'number',
			'default' 	=> 10,
		);
	}



	// $fields = apply_filters( 'shiftnav_settings_panel_fields' , $fields );

	// foreach( $fields as $section_id => $section_fields ){
	// 	ksort( $fields[$section_id] );
	// 	$fields[$section_id] = array_values( $fields[$section_id] );
	// }

	foreach( $fields as $section_id => $section_fields ){
	 	ksort( $fields[$section_id] );
	}

	$fields = apply_filters( 'shiftnav_settings_panel_fields_after' , $fields );

	return $fields;
}

function shiftnav_get_settings_sections(){

	$prefix = SHIFTNAV_PREFIX;

	$sections = array(
		/*array(
			'id' => $prefix.'basics',
			'title' => __( 'Basic Configuration', 'shiftnav' )
		),*/
		array(
			'id' => $prefix.'shiftnav-main',
			'title' => __( 'Main ShiftNav Settings', 'shiftnav' ),
		),
		array(
			'id' => $prefix.'togglebar',
			'title' => __( 'Toggle Bar', 'shiftnav' )
		)
	);

	$sections = apply_filters( 'shiftnav_settings_panel_sections' , $sections );

	$sections[] = array(
		'id'	=> $prefix.'general',
		'title'	=> __( 'General Settings' , 'shiftnav' ),
	);

	return $sections;

}



//RESET BUTTONS
add_filter( 'shiftnav_settings_panel_fields_after' , 'shiftnav_settings_panel_resets' , 100 );

function shiftnav_settings_panel_resets( $fields = array() ){


	$sections = shiftnav_get_menu_configurations( true );
	$sections[] = 'togglebar';
	$sections[] = 'general';

	foreach( $sections as $section ){

		//PANEL GENERAL

		$fields[SHIFTNAV_PREFIX.$section][10000] = array(
			'name'	=> 'reset',
			'label'	=> __( 'Reset Settings' , 'shiftnav' ),
			'desc'	=> '<a class="shiftnav_pro_button shiftnav_button_reset" href="'.admin_url('themes.php?page=shiftnav-settings&do=reset-section&section_id='.$section.'&shiftnav_nonce='.wp_create_nonce( 'shiftnav-control-panel' )).'" >'.__( 'Reset Settings for this tab ('.$section.')' , 'shiftnav' ).'</a>',
			'type'	=> 'html',
		);
	}

	return $fields;
}






/**
 * Registers settings section and fields
 */
function shiftnav_admin_init() {

	$prefix = SHIFTNAV_PREFIX;

 	$sections = shiftnav_get_settings_sections();
 	$fields = shiftnav_get_settings_fields();

 	//set up defaults so they are accessible
	_SHIFTNAV()->set_defaults( $fields );


	$settings_api = _SHIFTNAV()->settings_api();

	//set sections and fields
	$settings_api->set_sections( $sections );
	$settings_api->set_fields( $fields );

	//initialize them
	$settings_api->admin_init();

}
add_action( 'admin_init', 'shiftnav_admin_init' );

function shiftnav_init_frontend_defaults(){
	if( !is_admin() ){
		_SHIFTNAV()->set_defaults( shiftnav_get_settings_fields() );
	}
}
add_action( 'init', 'shiftnav_init_frontend_defaults' );

/**
 * Register the plugin page
 */
function shiftnav_admin_menu() {
	add_submenu_page(
		'themes.php',
		'ShiftNav Settings',
		'ShiftNav',
		'manage_options',
		'shiftnav-settings',
		'shiftnav_settings_panel'
	);
	//add_options_page( 'Settings API', 'Settings API', 'manage_options', 'settings_api_test', 'shiftnav_plugin_page' );
}

add_action( 'admin_menu', 'shiftnav_admin_menu' );


function shiftnav_get_nav_menu_ops(){
	$menus = wp_get_nav_menus( array('orderby' => 'name') );
	$m = array( '_none' => 'Choose Menu, or use Theme Location Setting' );
	foreach( $menus as $menu ){
		$m[$menu->slug] = $menu->name;
	}
	return $m;
}

function shiftnav_get_theme_location_ops(){
	$locs = get_registered_nav_menus();
	$default = array( '_none' => 'Select Theme Location or use Menu Setting' );
	//$locs = array_unshift( $default, $locs );
	$locs = $default + $locs;
	//shiftp( $locs );
	return $locs;
}

function shiftnav_admin_back_to_settings_button(){
	?>
	<a class="button" href="<?php echo admin_url('themes.php?page=shiftnav-settings'); ?>">&laquo; Back to ShiftNav Control Panel</a>
	<?php
}

function shiftnav_reset_settings( $section ){

	delete_option( SHIFTNAV_PREFIX.$section );

}

/**
 * Display the plugin settings options page
 */
function shiftnav_settings_panel() {

	if( isset( $_GET['do'] ) ){
		check_admin_referer( 'shiftnav-control-panel' , 'shiftnav_nonce' );

		switch( $_GET['do'] ){
			case 'reset-section':
				$section_id = sanitize_key( $_GET['section_id'] );
				shiftnav_reset_settings( $section_id );
				echo "<h3>Completed Settings Reset for Section [$section_id]</h3>";
				shiftnav_admin_back_to_settings_button();
				return;
				break;

		}

	}



	if( isset( $_GET['settings-updated'] ) && $_GET['settings-updated'] == 'true' ){
		do_action( 'shiftnav_settings_panel_updated' );
	}

	do_action( 'shiftnav_settings_panel' );

	$settings_api = _SHIFTNAV()->settings_api();

	?>

	<div class="wrap shiftnav-wrap">

	<?php settings_errors(); ?>

	<div class="shiftnav-settings-links">
		<?php do_action( 'shiftnav_settings_before_title' ); ?>
	</div>

	<h1>ShiftNav <?php if( SHIFTNAV_PRO ) echo 'Pro <i class="fa fa-rocket"></i>'; ?> <span class="shiftnav-version">v<?php echo SHIFTNAV_VERSION; ?></span> </h1>

	<?php

	do_action( 'shiftnav_settings_before' );

	$settings_api->show_navigation();
	$settings_api->show_forms();

	do_action( 'shiftnav_settings_after' );

	?>

	</div>

	<?php
}

function shiftnav_get_menu_configurations( $main = false ){
	$configs = get_option( SHIFTNAV_MENU_CONFIGURATIONS , array() );

	if( $main ){
		$configs[] = 'shiftnav-main';
	}

	return $configs;
}


/**
 * Get the value of a settings field
 *
 * @param string $option settings field name
 * @param string $section the section name this field belongs to
 * @param string $default default text if it's not found
 * @return mixed
 */
function shiftnav_op( $option, $section, $default = null ) {

	if( $section == '__current_instance__' ){
		$section = _SHIFTNAV()->get_current_instance();
	}

	$options = get_option( SHIFTNAV_PREFIX.$section );

	$value = '';
	$defaulted = false;

	//Option is set, use user-saved value
	if ( isset( $options[$option] ) ) {
		$value = $options[$option];
	}
	//Option is not set, no default value passed to function
	else if( $default === null ){
		$value = $default = _SHIFTNAV()->get_default( $option, SHIFTNAV_PREFIX.$section );
		$defaulted = true;
	}
	//Option is not set, default value passed to function
	else{
		$value = $default;
	}

	return apply_filters( 'shiftnav_op' , $value , $option , $section , $default , $defaulted );
}

function shiftnav_get_instance_options( $instance ){
	//echo SHIFTNAV_PREFIX.$instance;
	$defaults = _SHIFTNAV()->get_defaults( SHIFTNAV_PREFIX.$instance );
	$options = get_option( SHIFTNAV_PREFIX.$instance , $defaults );
	if( !is_array( $options ) || count( $options ) == 0 ) return $defaults;
	return $options;
}

function shiftnav_admin_panel_styles(){
	?>
<style>

</style>
	<?php
}
//add_action( 'admin_head-appearance_page_shiftnav-settings' , 'shiftnav_admin_panel_styles' );

function shiftnav_admin_panel_assets( $hook ){

	if( $hook == 'appearance_page_shiftnav-settings' ){
		wp_enqueue_script( 'shiftnav' , SHIFTNAV_URL . 'admin/assets/admin.settings.js' );
		wp_enqueue_style( 'shiftnav-settings-styles' , SHIFTNAV_URL.'admin/assets/admin.settings.css' );
		wp_enqueue_style( 'shiftnav-font-awesome' , SHIFTNAV_URL.'assets/css/fontawesome/css/font-awesome.min.css' );
	}
}
add_action( 'admin_enqueue_scripts' , 'shiftnav_admin_panel_assets' );



function shiftnav_check_menu_assignment(){
	$display = shiftnav_op(  'display_main' , 'shiftnav-main' );

	if( $display == 'on' ){
		if( !has_nav_menu( 'shiftnav' ) ){
			?>
			<div class="update-nag"><strong>Important!</strong> There is no menu assigned to the <strong>ShiftNav [Main]</strong> Menu Location.  <a href="<?php echo admin_url( 'nav-menus.php?action=locations' ); ?>">Assign a menu</a></div>
			<br/><br/>
			<?php
		}
	}
}
add_action( 'shiftnav_settings_before' , 'shiftnav_check_menu_assignment' );

function shiftnav_allow_html( $str ){
	return $str;
}
