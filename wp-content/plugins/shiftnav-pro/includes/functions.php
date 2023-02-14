<?php
add_action( 'plugins_loaded' , 'shiftnav_load_textdomain' );
function shiftnav_load_textdomain(){
	$domain = 'shiftnav';
	load_plugin_textdomain( $domain , false , SHIFTNAV_BASEDIR.'/languages' );

	$locale = apply_filters( 'plugin_locale', get_locale(), $domain );
	load_textdomain( $domain, trailingslashit( WP_LANG_DIR ) . $domain . '/' . $domain . '-' . $locale . '.mo' );
}

function shiftnav_inject_css(){

	if( !_SHIFTNAV()->display_now() ) return;

	$css = '';

	/**
	 * MAIN TOGGLE
	 **/

	//Colors
	// $toggle_bg = shiftnav_op( 'background_color' , 'togglebar' );
	// $toggle_text = shiftnav_op( 'text_color' , 'togglebar' );

	// if( $toggle_bg != '' || $toggle_text != '' ){
	// 	$css.= "#shiftnav-toggle-main{";
	// 		if( $toggle_bg != '' ) $css.= " background: $toggle_bg;";
	// 		if( $toggle_text != '' ) $css.= " color: $toggle_text;";
	// 	$css.= " }\n";
	// }

	//Breakpoint & Menu Hiding
	$toggle_breakpoint = shiftnav_op( 'breakpoint' , 'togglebar' );
	if( $toggle_breakpoint != '' ){
		if( is_numeric( $toggle_breakpoint ) ) $toggle_breakpoint.='px';
		$css.= "\t@media only screen and (min-width:{$toggle_breakpoint}){ ";
			//Set the padding-top to 0 above the breakpoint, because it gets set to the toggle height below the breakpoint
			$css.= "#shiftnav-toggle-main, .shiftnav-toggle-mobile{ display:none; } .shiftnav-wrap { padding-top:0 !important; } ";
			//if( shiftnav_op( 'shift_body' , 'general' ) == 'off' ) $css.= "body.shiftnav-disable-shift-body{ padding-top:0 !important; } ";
		$css.= "}\n";

		$hide_theme_menu = shiftnav_op( 'hide_theme_menu', 'togglebar' );
		if( $hide_theme_menu != '' ){
			$toggle_breakpoint = ( (int) $toggle_breakpoint ) - 1;
			$css.= "\t@media only screen and (max-width:{$toggle_breakpoint}px){ ";
			$css.= "$hide_theme_menu{ display:none !important; } ";
			$css.= "}\n";
		}

		$hide_ubermenu = shiftnav_op( 'hide_ubermenu', 'togglebar' );
		if( $hide_ubermenu == 'on' ){
			$toggle_breakpoint = ( (int) $toggle_breakpoint ) - 1;
			$css.= "\t@media only screen and (max-width:{$toggle_breakpoint}px){ ";
			$css.= ".ubermenu, body .ubermenu, .ubermenu.ubermenu-responsive-default, .ubermenu-responsive-toggle, #megaMenu{ display:none !important; } ";
			$css.= "}\n";
		}
	}

	// $font_size = shiftnav_op( 'font_size' , 'togglebar' );
	// if( $font_size != '' ){
	// 	if( is_numeric( $font_size ) ) $font_size.= 'px';
	// 	$css.= "\t#shiftnav-toggle-main{ font-size: $font_size !important; }";
	// }

	// $tweaks = shiftnav_op( 'css_tweaks' , 'general' );
	// if( $tweaks != '' ){
	// 	$css.= "\n\n\t/* Custom CSS Tweaks */\n\t".$tweaks;
	// }


	$css.= shiftnav_get_custom_styles();


	/**
	 *
	 **/

	if( $css != '' ): ?>

	<!-- ShiftNav CSS
	================================================================ -->
	<style type="text/css" id="shiftnav-dynamic-css">

<?php echo $css; ?>

	</style>
	<!-- end ShiftNav CSS -->

	<?php endif;

}
add_action( 'wp_head' , 'shiftnav_inject_css' );

function shiftnav_togglebar( $toggle_target = 'shiftnav-main', $content = '', $args = array() ){

	extract( shortcode_atts( array(
		'bar_id'			=> '',
		'toggle_align'	=> shiftnav_op( 'align' , 'togglebar' ),
		'toggle_style' => shiftnav_op( 'toggle_bar_style' , 'togglebar' ),
		'toggle_target_area' => shiftnav_op( 'toggle_target' , 'togglebar' ),
		'togglebar_gap' => shiftnav_op( 'togglebar_gap' , 'togglebar' ),
		'togglebar_transparent' => shiftnav_op( 'background_transparent' , 'togglebar' ),
	), $args ))


	?>

	<!-- ShiftNav Main Toggle -->
		<?php

		$disable_toggle = false; //true;

		$toggle_class = 'shiftnav-toggle-main-align-'.$toggle_align;
		$toggle_class.= ' shiftnav-toggle-style-'.$toggle_style;
		$toggle_class.= ' shiftnav-togglebar-gap-'.$togglebar_gap;

		if( $toggle_target_area == 'entire_bar' ){
			$toggle_class.= ' shiftnav-toggle-main-entire-bar';
		}
		else{
			$disable_toggle = true;
			add_action( 'shiftnav_toggle_before_content' , 'shiftnav_main_toggle_burger' , 10 , 3 );
		}

		if( $togglebar_transparent == 'on' ){
			$toggle_class.= ' shiftnav-togglebar-transparent';
		}


		/* 	<div id="shiftnav-toggle-main" class="<?php echo $main_toggle_class; ?>">
		 		<?php shiftnav_toggle( 'shiftnav-main' ); ?>
		 		<?php shiftnav_main_toggle_content(); ?>
		 	</div> */

		$toggle_target = apply_filters( 'shiftnav_main_toggle_target' , $toggle_target );

		if( $toggle_style === 'burger_only' ) $content = false;

		/*
		?>
		<div id="<?php echo $bar_id; ?>">

		</div>
		<?php
		*/

		// echo $content;

		shiftnav_toggle( $toggle_target , $content , array(
			'id' => $bar_id,
			'el' => 'div',
			'class' => $toggle_class,
			'disable_toggle' => $disable_toggle,
			'tabindex' => 1,
		));

		remove_action( 'shiftnav_toggle_before_content' , 'shiftnav_main_toggle_burger' , 10 , 3 );

		?>

	<!-- /#shiftnav-toggle-main -->

	<?php
}

function shiftnav_direct_injection(){

	if( !_SHIFTNAV()->display_now() ) return;

	if( shiftnav_op( 'display_toggle' , 'togglebar' ) == 'on' ){
		$content = '';
		$toggle_style = shiftnav_op( 'toggle_bar_style' , 'togglebar' );
		if( $toggle_style !== 'burger_only' ) $content = shiftnav_main_toggle_content();
		shiftnav_togglebar( 'shiftnav-main' , $content , array( 'bar_id' => 'shiftnav-toggle-main' ));
	}

	if( shiftnav_op( 'display_main' , 'shiftnav-main' ) == 'on' ){
		shiftnav( 'shiftnav-main' , array(
			'theme_location' 	=> 'shiftnav' ,
			'edge'				=> shiftnav_op( 'edge' , 'shiftnav-main' ),
			));
	}

	if( $footer_content = shiftnav_op( 'footer_content' , 'general' ) ){
		echo do_shortcode( $footer_content );
	}
}
add_action( 'wp_footer', 'shiftnav_direct_injection' );


function shiftnav_main_toggle_burger( $main_toggle , $target_id , $id ){
	if( $main_toggle ){
		$main_toggle_target = apply_filters( 'shiftnav_main_toggle_target' , 'shiftnav-main' );
		$main_toggle_icon_class = apply_filters( 'shiftnav_main_toggle_icon_class' , 'fa fa-bars' );
		$main_toggle_content = apply_filters( 'shiftnav_main_toggle_content' , '<i class="'.$main_toggle_icon_class.'"></i>' );

		shiftnav_toggle( $main_toggle_target , $main_toggle_content , array(
			'id' => 'shiftnav-toggle-main-button' ,
			'el' => 'button',
			'class' => 'shiftnav-toggle-burger',
			'tabindex' => 1,
			'aria_label' => shiftnav_op( 'aria_label' , 'togglebar' ),
			'actions' => false, //if we ran the actions, we'd enter into a weird fifth dimension and collapse the universe
		));
		//echo '<span class="shiftnav-toggle-burger"><i class="fa fa-bars"></i></span>';
	}
}

function shiftnav_main_toggle_content(){
	//echo '[_'.shiftnav_op( 'toggle_content' , 'togglebar' ).'_]';
	return '<div class="shiftnav-main-toggle-content shiftnav-toggle-main-block">' . do_shortcode( shiftnav_op( 'toggle_content' , 'togglebar' ) ) . '</div>';
	//return '<a href="'.get_home_url().'"><em>SHIFT</em>NAV</a>';
}



function _shiftnav_toggle( $target_id , $content = '', $args = array() ){

	extract( wp_parse_args( $args , array(
		'id'	=>	'',
		'el'	=>	'a',
		'class'	=> 	'',
		'disable_toggle' => false,
		'actions' => true,
		'icon'	=> '',
		'tabindex' => 0,
		'aria_label' => false,
	) ) );

	$content = do_shortcode( $content );

	$main_toggle = false;
	if( $id && $id == 'shiftnav-toggle-main' ) $main_toggle = true;

	if( $main_toggle ){
		$class.= ' shiftnav-toggle-edge-'.shiftnav_op( 'edge' , 'shiftnav-main' );
		$class.= ' shiftnav-toggle-icon-'.shiftnav_op( 'toggle_close_icon' , 'togglebar' );

		if( shiftnav_op( 'toggle_position' , 'togglebar' ) == 'absolute' ){
			$class.= ' shiftnav-toggle-position-absolute';
		}

		if( shiftnav_op( 'hide_bar_on_scroll', 'togglebar', 'off' ) === 'on' ){
			$class.= ' shiftnav--hide-scroll-down';
		}

		// $class.= ' ' . $class;
	}

	$target_att = '';
	$tabindex_att = '';
	if( !$disable_toggle ){
		$tabindex_att = 'tabindex="'.esc_attr($tabindex).'"';
		$target_att = 'data-shiftnav-target="'.esc_attr($target_id).'"';
		$class = 'shiftnav-toggle shiftnav-toggle-'.esc_attr($target_id).' '.$class;
	}

	if( $aria_label ) $aria_label = 'aria-label="'.esc_attr($aria_label).'"';


	// Escape for security
	$el = esc_html($el);
	$id = esc_attr($id);
	$class = esc_attr($class);
	$icon = esc_attr($icon);


	echo "<$el ";
		if( $id ): ?>id="<?php echo $id; ?>"<?php endif;
		?> class="<?php echo $class; ?>" <?php echo $tabindex_att; ?> <?php echo $target_att; ?> <?php echo $aria_label; ?>><?php
		if( $actions ) do_action( 'shiftnav_toggle_before_content' , $main_toggle , $target_id , $id );
		if( $icon ) echo '<i class="fa fa-'.$icon.'"></i> ';
		echo apply_filters( 'shiftnav_toggle_content' , $content , $target_id , $id );
		if( $actions ) do_action( 'shiftnav_toggle_after_content' , $main_toggle , $target_id , $id );
	echo "</$el>"; ?>
	<?php
}



function shiftnav_toggle_shortcode( $atts, $content ){

	extract( shortcode_atts( array(
		'target' 	=> 'shiftnav-main',
		'toggle_id' => '',
		'el'		=> 'a',
		'class'		=> '',
		'icon'		=> '',
		'disable_content' => '',
		'aria_label' => false,
	), $atts, 'shiftnav_toggle' ) );

	if( $disable_content == 'true' ) $content = false;

	ob_start();

	shiftnav_toggle( $target , $content , array( 'id' => $toggle_id , 'el' => $el , 'class' => $class , 'icon' => $icon, 'aria_label' => $aria_label ) );

	$toggle = ob_get_contents();

	ob_end_clean();

	return $toggle;
}
add_shortcode( 'shiftnav_toggle' , 'shiftnav_toggle_shortcode' );

/* The fallback function if no menu is assigned */
function shiftnav_fallback(){
	shiftnav_show_tip( 'No menu to display' );
}

function shiftnav_register_theme_locations() {
	register_nav_menu( 'shiftnav', __( 'ShiftNav [Main]' ) );
}
add_action( 'init', 'shiftnav_register_theme_locations' );

function shiftnav_load_assets(){

	if( !_SHIFTNAV()->display_now() ) return;

	$assets = SHIFTNAV_URL . 'assets/';
	if( SCRIPT_DEBUG ){
		wp_enqueue_style( 'shiftnav' , $assets.'css/shiftnav.css' , false , SHIFTNAV_VERSION );
	}
	else{
		wp_enqueue_style( 'shiftnav' , $assets.'css/shiftnav.min.css' , false , SHIFTNAV_VERSION );
	}

	if( shiftnav_op( 'load_fontawesome' , 'general' ) == 'on' ){
		wp_enqueue_style( 'shiftnav-font-awesome' , $assets.'css/fontawesome/css/font-awesome.min.css' , false , SHIFTNAV_VERSION );
	}

	//Load Required Skins
	$skin = shiftnav_op( 'skin' , 'shiftnav-main' );
	if( $skin != 'none' ) shiftnav_enqueue_skin( $skin );

	//Load custom.css
	//$load_custom_css = shiftnav_op( 'load_custom_css' , 'general' );
	//if( $load_custom_css == 'on' ) wp_enqueue_style( 'shiftnav-custom' , SHIFTNAV_URL . 'custom/custom.css' );


	wp_enqueue_script( 'jquery' );
	if( SCRIPT_DEBUG ){
		wp_enqueue_script( 'shiftnav' , $assets.'js/shiftnav.js' , array( 'jquery' ) , SHIFTNAV_VERSION , true );
	}
	else{
		wp_enqueue_script( 'shiftnav' , $assets.'js/shiftnav.min.js' , array( 'jquery' ) , SHIFTNAV_VERSION , true );
	}

	wp_localize_script( 'shiftnav' , 'shiftnav_data' , array(
		'shift_body'						=>	shiftnav_op( 'shift_body' , 'general' ),
		'shift_body_wrapper'		=>	shiftnav_op( 'shift_body_wrapper' , 'general' ),
		'lock_body'							=>	shiftnav_op( 'lock_body' , 'general' ),
		'lock_body_x'						=>	shiftnav_op( 'lock_body_x' , 'general' ),
		'open_current'					=>	shiftnav_op( 'open_current' , 'general' ),
		'collapse_accordions'		=> 	shiftnav_op( 'collapse_accordions' , 'general' ),
		'scroll_panel'					=>	shiftnav_op( 'scroll_panel' , 'general' ),
		'breakpoint'						=> 	shiftnav_op( 'breakpoint' , 'togglebar' ),
		'v'											=>	SHIFTNAV_VERSION,
		'pro'										=>  SHIFTNAV_PRO ? 1 : 0,

		'touch_off_close'				=>	shiftnav_op( 'touch_off_close' , 'general' ),
		'scroll_offset'					=>	shiftnav_op( 'scroll_offset' , 'general' ),
		'disable_transforms'		=>	shiftnav_op( 'disable_transforms' , 'general' ),
		'close_on_target_click' => 	shiftnav_op( 'close_on_target_click' , 'general' ),
		'scroll_top_boundary'		=> 	shiftnav_op( 'scroll_top_boundary', 'general', 50 ),
		'scroll_tolerance'		=>	shiftnav_op( 'scroll_tolerance', 'general', 10 ),
		'process_uber_segments'	=> 	shiftnav_op( 'process_uber_segments', 'general' ),
	) );
}
add_action( 'wp_enqueue_scripts' , 'shiftnav_load_assets' , 101 );


function shiftnav_get_skin_ops(){

	$registered_skins = _SHIFTNAV()->get_skins();
	if( !is_array( $registered_skins ) ) return array();
	$ops = array();
	foreach( $registered_skins as $id => $skin ){
		$ops[$id] = $skin['title'];
	}
	return $ops;

}
function shiftnav_register_skin( $id, $title, $path ){
	_SHIFTNAV()->register_skin( $id , $title , $path );
}

add_action( 'init' , 'shiftnav_register_skins' );
function shiftnav_register_skins(){
	$main = SHIFTNAV_URL . 'assets/css/skins/';
	shiftnav_register_skin( 'standard-dark' , 'Standard Dark' , $main.'standard-dark.css' );
	//shiftnav_register_skin( 'slate' , 'Slate' , $main.'slate.css' );
	shiftnav_register_skin( 'light' , 'Standard Light' , $main.'light.css' );
}
add_action( 'init' , 'shiftnav_pro_register_skin_none' , 20 );
function shiftnav_pro_register_skin_none(){
	shiftnav_register_skin( 'custom' , 'Custom (custom.css)' , SHIFTNAV_URL.'custom/custom.css' );
	shiftnav_register_skin( 'none' , 'None (Disable)' , '' );
}
function shiftnav_enqueue_skin( $skin ){
	wp_enqueue_style( 'shiftnav-'.$skin );
}



function shiftnav_bloginfo_shortcode( $atts ) {
   extract(shortcode_atts(array(
       'key' => '',
   ), $atts));
   return get_bloginfo($key);
}
add_shortcode('shift_bloginfo', 'shiftnav_bloginfo_shortcode');

function shiftnav_default_toggle_content( $atts ) {
	return '<a href="'.get_home_url().'">'.get_bloginfo( 'title' ).'</a>';
}
add_shortcode('shift_toggle_title', 'shiftnav_default_toggle_content');


function shiftnav_main_site_title( $instance_id ){
	if( shiftnav_op( 'display_site_title' , $instance_id ) == 'on' ):
	?>
	<h3 class="shiftnav-menu-title shiftnav-site-title"><a href="<?php bloginfo( 'url' ); ?>"><?php bloginfo(); ?></a></h3>
	<?php
	endif;

	if( shiftnav_op( 'display_instance_title' , $instance_id ) == 'on' ):
	?>
	<h3 class="shiftnav-menu-title shiftnav-instance-title"><?php echo shiftnav_op( 'instance_name' , $instance_id ); ?></h3>
	<?php
	endif;

}
add_action( 'shiftnav_before' , 'shiftnav_main_site_title' , 10 );



/* Stop Interference */
add_action( 'wp_head' , 'shiftnav_prevent_interference' );
function shiftnav_prevent_interference(){
	if( shiftnav_op( 'force_filter' , 'general' ) == 'on' ){
		add_filter( 'wp_nav_menu_args' , 'shiftnav_force_filter' , 1000 );
	}
	if( shiftnav_op( 'kill_class_filter' , 'general' ) == 'on' ){
		remove_all_filters( 'nav_menu_css_class' );
	}
}

/* Force Filter */
function shiftnav_force_filter( $args ){

	if( isset( $args['shiftnav'] ) ){
		$args = shiftnav_get_menu_args( $args );
		// $args['container_class'] 	= 'shiftnav-nav';
		// $args['container']			= 'nav';
		// $args['menu_class']			= 'shiftnav-menu';
		// $args['walker']				= new ShiftNavWalker;
		// $args['fallback_cb']		= 'shiftnav_fallback';
		// $args['depth']				= 0;
	}

	//Handle menu segments
	if( isset( $args['shiftnav_segment'] ) ){
		if( isset( $args['shiftnav_segment_args'] ) ) $args = array_merge( $args , $args['shiftnav_segment_args'] );
	}

	return $args;
}


function shiftnav_get_menu_args( $args , $id = 0 ){

	$args['container_class'] 	= 'shiftnav-nav';
	$args['container']			= 'nav';
	$args['menu_class']			= 'shiftnav-menu';
	$args['walker']				= new ShiftNavWalker;
	$args['fallback_cb']		= 'shiftnav_fallback';
	$args['depth']				= 0;
	$args['items_wrap']		= '<ul id="%1$s" class="%2$s">%3$s</ul>';

	if( $id === 0 ) $id = isset( $args['shiftnav'] ) ? $args['shiftnav'] : 'shiftnav-main';


	//Target size
	$args['menu_class'].= ' shiftnav-targets-'.shiftnav_op( 'target_size' , 'general' );

	//Text size
	$args['menu_class'].= ' shiftnav-targets-text-'.shiftnav_op( 'text_size' , 'general' );

	//Icon size
	$args['menu_class'].= ' shiftnav-targets-icon-'.shiftnav_op( 'icon_size' , 'general' );

	//Submenu indent
	if( shiftnav_op( 'indent_submenus' , $id ) == 'on' ) $args['menu_class'].= ' shiftnav-indent-subs';

	//Active on hover
	if( shiftnav_op( 'active_on_hover' , 'general' ) == 'on' ) $args['menu_class'].= ' shiftnav-active-on-hover';

	//Active Highlight
	if( shiftnav_op( 'active_highlight' , 'general' ) == 'on' ) $args['menu_class'].= '	shiftnav-active-highlight';


	return $args;

}




function shiftnav_user_is_admin(){
	return current_user_can( 'manage_options' );
}

function shiftnav_show_tip( $content ){
	$showtips = false;
	if( shiftnav_op( 'admin_tips' , 'general' ) == 'on' ){
		if( shiftnav_user_is_admin() ){
			echo '<div class="shiftnav-admin-tip">'.$content.'</div>';
		}
	}
}

function shiftnav_count_menus(){
	$menus = wp_get_nav_menus( array('orderby' => 'name') );
	if( count( $menus ) == 0 ){
		shiftnav_show_tip( 'Oh no!  You don\'t have any menus yet.  <a href="'.admin_url( 'nav-menus.php' ).'">Create a menu</a>' );
	}
}

function shiftp( $d ){
	echo '<pre>';
	print_r($d);
	echo '</pre>';

}
