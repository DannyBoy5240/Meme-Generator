<?php


/** TOGGLE BAR **/

function shiftnav_get_menu_style_togglebar_background( $field , $config_id , &$menu_styles ){
	$val = shiftnav_op( $field['name'] , $config_id );
	$selector = "#shiftnav-toggle-main";
	if( $val ){
		$menu_styles[$selector]['background'] = $val;
	}
}
function shiftnav_get_menu_style_togglebar_font_color( $field , $config_id , &$menu_styles ){
	$val = shiftnav_op( $field['name'] , $config_id );
	$selector = "#shiftnav-toggle-main";
	if( $val ){
		$menu_styles[$selector]['color'] = $val;
	}
}
function shiftnav_get_menu_style_togglebar_font_size( $field , $config_id , &$menu_styles ){
	$val = shiftnav_op( $field['name'] , $config_id );
	$selector = "#shiftnav-toggle-main";
	if( is_numeric( $val ) ) $val.= 'px';
	if( $val ){
		$menu_styles[$selector]['font-size'] = $val.' !important';
	}
}
function shiftnav_get_menu_style_togglebar_hamburger_size( $field , $config_id , &$menu_styles ){
	$val = shiftnav_op( $field['name'] , $config_id );
	$selector = "#shiftnav-toggle-main.shiftnav-toggle-main-entire-bar:before, ".
				"#shiftnav-toggle-main .shiftnav-toggle-burger";
	if( is_numeric( $val ) ) $val.= 'px';
	if( $val ){
		$menu_styles[$selector]['font-size'] = $val;
	}
}




//FONTS

function shiftnav_get_menu_style_font_family( $field , $config_id , &$menu_styles ){
	$val = shiftnav_op( $field['name'] , $config_id );
	$selector = ".shiftnav.shiftnav-$config_id, ".
				".shiftnav.shiftnav-$config_id .shiftnav-menu-item, ".
				".shiftnav.shiftnav-$config_id .shiftnav-menu-item .shiftnav-target";
	if( $val ){
		$menu_styles[$selector]['font-family'] = $val;
	}
}
