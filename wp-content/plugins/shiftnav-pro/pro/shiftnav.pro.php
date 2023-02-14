<?php

require_once SHIFTNAV_DIR . 'pro/admin/admin.pro.php';
require_once SHIFTNAV_DIR . 'pro/customizer/customizer.styles.generator.pro.php';
require_once SHIFTNAV_DIR . 'pro/icons.php';
require_once SHIFTNAV_DIR . 'pro/login.php';
require_once SHIFTNAV_DIR . 'pro/updates/updater.php';

function shiftnav_pro_init(){
	add_action( 'shiftnav_register_icons' , 'shiftnav_register_default_icons' );
	do_action( 'shiftnav_register_icons' );

	//require_once( 'search.php' );
	require_once( SHIFTNAV_DIR . 'pro/search.php' );
}
add_action( 'init' , 'shiftnav_pro_init' );


add_action( 'wp_footer' , 'shiftnav_pro_generate_menus' );

function shiftnav_pro_generate_menus(){

	if( !_SHIFTNAV()->display_now() ) return;

	$menus = get_option( 'shiftnav_menus' , array() );
	foreach( $menus as $menu ){
		if( shiftnav_op( 'automatic_generation' , $menu ) != 'off' ){
			shiftnav( $menu );
			//within shiftnav(), if nothing else is passed, grab settings and print properly
		}
	}

}

function shiftnav_pro_load_assets(){

	if( !_SHIFTNAV()->display_now() ) return;

	$assets = SHIFTNAV_URL . 'pro/assets/';
	if( SCRIPT_DEBUG ){
		wp_enqueue_style( 'shiftnav' , $assets.'css/shiftnav.css' , false , SHIFTNAV_VERSION );
	}
	else{
		wp_enqueue_style( 'shiftnav' , $assets.'css/shiftnav.min.css' , false , SHIFTNAV_VERSION );
	}

	$menus = get_option( 'shiftnav_menus' , array() );

	foreach( $menus as $m ){
		$skin = shiftnav_op( 'skin' , $m );
		if( $skin != 'none' ) shiftnav_enqueue_skin( $skin );
		//wp_enqueue_style( 'shiftnav-skin-standard-dark' , $assets.'css/skins/standard-dark.css' );
	}
}
add_action( 'wp_enqueue_scripts' , 'shiftnav_pro_load_assets' , 20 );	//load before free so we get pro shiftnav.css



add_action( 'init' , 'shiftnav_pro_register_skins' );
function shiftnav_pro_register_skins(){
	$main = SHIFTNAV_URL . 'pro/assets/css/skins/';

	shiftnav_register_skin( 'slate' , 		'Slate' , 			$main.'slate.css' );
	shiftnav_register_skin( 'slate-red' , 	'Slate [Red]' , 	$main.'slate-red.css' );
	shiftnav_register_skin( 'dark-blue' , 	'Dark [Blue]' , 	$main.'dark-blue.css' );
	shiftnav_register_skin( 'dark-red' , 	'Dark [Red]' , 		$main.'dark-red.css' );
	shiftnav_register_skin( 'dark-yellow' , 'Dark [Yellow]' , 	$main.'dark-yellow.css' );
	shiftnav_register_skin( 'dark-tomato' , 'Dark [Tomato]' , 	$main.'dark-tomato.css' );
	shiftnav_register_skin( 'dark-purple' , 'Dark [Purple]' , 	$main.'dark-purple.css' );
	shiftnav_register_skin( 'dark-sea' , 	'Dark [Sea]' , 		$main.'dark-sea.css' );
	shiftnav_register_skin( 'dark-berry' , 	'Dark [Berry]' , 	$main.'dark-berry.css' );


//	shiftnav_register_skin( 'light' , 'Light' , $main.'light.css' );


	shiftnav_register_skin( 'flat-green' , 'Green' , $main.'green.css' );
	shiftnav_register_skin( 'flat-blue' , 'Blue' , $main.'blue.css' );
	shiftnav_register_skin( 'flat-red' , 'Red' , $main.'red.css' );
	shiftnav_register_skin( 'flat-aqua' , 'Aqua' , $main.'aqua.css' );

	shiftnav_register_skin( 'app' , 'App' , $main.'app.css' );
}




function shiftnav_basic_user_profile( $atts ) {
	extract( shortcode_atts( array(
		'id'	=> -1,
		'img_size' => 40,
	), $atts ) );

	$_user = '';

	if( $id == -1 ){
		$id = get_current_user_id();
		if( $id == 0 ) return '';

		global $current_user;
		//get_currentuserinfo();
		//$_user = $current_user;
		$_user = wp_get_current_user();

	}
	else{
		$_user = get_userdata( $id );
	}

	if( !$_user ) return '';

	$html = '<div class="shiftnav-basic-user-profile shiftnav-basic-user-profile-'.$id.'">';

	$default = '';
	$html.= get_avatar( $id, $img_size, $default, 'User Profile Image' );

	$html.= '<span class="shiftnav-basic-user-profile-name">'.$_user->display_name.'</span>';

	$html.= '</div>';

	return $html;
}
add_shortcode( 'shiftnav-basic-user-profile' , 'shiftnav_basic_user_profile' );



/** CONTENT **/
function shiftnav_content_before( $instance_id ){
	echo do_shortcode( shiftnav_op( 'content_before' , $instance_id ) );
}
add_action( 'shiftnav_before' , 'shiftnav_content_before' , 30 );

function shiftnav_content_after( $instance_id ){
	echo do_shortcode( shiftnav_op( 'content_after' , $instance_id ) );
}
add_action( 'shiftnav_after' , 'shiftnav_content_after' , 30 );

function shiftnav_content_top_image( $instance_id ){
	$image_id = shiftnav_op( 'image' , $instance_id );

	if( $image_id ):
		$class = 'shiftnav-menu-image';
		if( shiftnav_op( 'image_padded' , $instance_id ) == 'on' ) $class.= ' shiftnav-menu-image-padded';
		$image_link = do_shortcode( shiftnav_op( 'image_link' , $instance_id ) );
	?>
	<div class="<?php echo $class; ?>" id="shiftnav-menu-image-<?php echo $instance_id; ?>">
		<?php if( $image_link ): ?><a href="<?php echo $image_link; ?>"><?php endif; ?>
			<?php if( is_numeric( $image_id ) ): ?>
				<?php echo wp_get_attachment_image( $image_id , 'full' ); ?>
			<?php else: ?>
				<img src="<?php echo $image_id; ?>" />
			<?php endif; ?>
		<?php if( $image_link ): ?></a><?php endif; ?>
	</div>
	<?php
	endif;
}
add_action( 'shiftnav_before' , 'shiftnav_content_top_image' , 20 );


/** TOGGLE CONTENT **/
function shiftnav_main_toggle_left_edge( $main_toggle , $target_id , $id ){
	if( !$main_toggle ) return;

	$main_toggle_style = shiftnav_op( 'toggle_bar_style' , 'togglebar' );
	if( $main_toggle_style == 'burger_only' ) return;

	$toggle_content_left = shiftnav_op( 'toggle_content_left' , 'togglebar' );

	if( $toggle_content_left ): ?>
	<span class="shiftnav-main-toggle-content-before"><?php
		echo do_shortcode( $toggle_content_left );
	?></span>
	<?php endif;
}
function shiftnav_main_toggle_right_edge( $main_toggle , $target_id , $id ){
	if( !$main_toggle ) return;

	$main_toggle_style = shiftnav_op( 'toggle_bar_style' , 'togglebar' );
	if( $main_toggle_style == 'burger_only' ) return;

	$toggle_content_right = shiftnav_op( 'toggle_content_right' , 'togglebar' );

	if( $toggle_content_right ): ?>
	<div class="shiftnav-main-toggle-content-after"><?php
		echo do_shortcode( $toggle_content_right );
	?></div>
	<?php endif;
}
add_action( 'shiftnav_toggle_before_content' , 'shiftnav_main_toggle_left_edge' , 15 , 3 );
add_action( 'shiftnav_toggle_after_content' , 'shiftnav_main_toggle_right_edge' , 10 , 3 );




function shiftnav_get_support_url(){
	return _SHIFTNAV()->get_support_url();
}
