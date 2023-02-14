<?php

add_shortcode( 'shiftnav_login_link' , 'shiftnav_login_link_shortcode' );

function shiftnav_login_link_shortcode( $atts , $content ){

	extract( shortcode_atts( array(
		'icon_class' => 'fa fa-user',
		'login_url'	=> '',
		'redirect'	=> 'current'
	), $atts ) );

	//$redirect = $redirect == 'off' ? false : true;

	return shiftnav_login_link( $icon_class , $content , $login_url , $redirect );
}

function shiftnav_login_link( $icon_class = '' , $link_text = '' , $login_url = '' , $redirect = '' ){

	if( is_user_logged_in() ) return;

	$redirect_url = $redirect == 'current' ? get_permalink() : '';

	if( !$login_url ) $login_url = wp_login_url( $redirect_url );

	$link = '<a class="shiftnav-login-link shiftnav-toggle-main-block" href="'.$login_url.'">';
	if( $icon_class ) $link.= '<i class="'.$icon_class.'"></i>';
	if( $link_text ) $link.= $link_text;
	$link.= '</a>';

	return $link;
}





add_shortcode( 'shiftnav_logout_link' , 'shiftnav_logout_link_shortcode' );

function shiftnav_logout_link_shortcode( $atts , $content ){

	extract( shortcode_atts( array(
		'icon_class' => 'fa fa-sign-out',
		'redirect'	=> 'current'
	), $atts ) );

	return shiftnav_logout_link( $icon_class , $content , $redirect );
}

function shiftnav_logout_link( $icon_class = '' , $link_text = '' , $redirect = '' ){

	if( !is_user_logged_in() ) return;

	$redirect_url = $redirect == 'current' ? get_permalink() : '';

	$logout_url = wp_logout_url( $redirect_url );

	$link = '<a class="shiftnav-logout-link shiftnav-toggle-main-block" href="'.$logout_url.'">';
	if( $icon_class ) $link.= '<i class="'.$icon_class.'"></i>';
	if( $link_text ) $link.= $link_text;
	$link.= '</a>';

	return $link;
}