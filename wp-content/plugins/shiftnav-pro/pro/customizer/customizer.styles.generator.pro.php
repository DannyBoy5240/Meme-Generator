<?php

/** PANELS **/

//General
function shiftnav_get_menu_style_panel_background( $field , $config_id , &$menu_styles ){
	$val = shiftnav_op( $field['name'] , $config_id );
	$selector = ".shiftnav.shiftnav-$config_id";
	if( $val ){
		$menu_styles[$selector]['background'] = $val;
	}
}
function shiftnav_get_menu_style_panel_font_color( $field , $config_id , &$menu_styles ){
	$val = shiftnav_op( $field['name'] , $config_id );
	$selector = ".shiftnav.shiftnav-$config_id";
	if( $val ){
		$menu_styles[$selector]['color'] = $val;
	}
}

//Site Title/Header
// .shiftnav-site-title{
// 	font-size:@header-font-size;
// 	text-align:@header-text-align;
// 	padding:@header-padding;
// 	font-weight: @header-font-weight;
// 	color: @header-color;
// }
function shiftnav_get_menu_style_panel_header_font_size( $field , $config_id , &$menu_styles ){
	$val = shiftnav_op( $field['name'] , $config_id );
	$selector = ".shiftnav.shiftnav-$config_id .shiftnav-site-title";
	if( $val ){
		if( is_numeric( $val ) ) $val.='px';
		$menu_styles[$selector]['font-size'] = $val;
	}
}
function shiftnav_get_menu_style_panel_header_font_color( $field , $config_id , &$menu_styles ){
	$val = shiftnav_op( $field['name'] , $config_id );
	$selector = ".shiftnav.shiftnav-$config_id .shiftnav-site-title";
	if( $val ){
		$menu_styles[$selector]['color'] = $val;
	}
}
function shiftnav_get_menu_style_panel_header_padding( $field , $config_id , &$menu_styles ){
	$val = shiftnav_op( $field['name'] , $config_id );
	$selector = ".shiftnav.shiftnav-$config_id .shiftnav-site-title";
	if( $val ){
		if( is_numeric( $val ) ) $val.='px';
		$menu_styles[$selector]['padding'] = $val;
	}
}
function shiftnav_get_menu_style_panel_header_text_align( $field , $config_id , &$menu_styles ){
	$val = shiftnav_op( $field['name'] , $config_id );
	$selector = ".shiftnav.shiftnav-$config_id .shiftnav-site-title";
	if( $val ){
		$menu_styles[$selector]['text-align'] = $val;
	}
}
function shiftnav_get_menu_style_panel_header_font_weight( $field , $config_id , &$menu_styles ){
	$val = shiftnav_op( $field['name'] , $config_id );
	$selector = ".shiftnav.shiftnav-$config_id .shiftnav-site-title";
	if( $val ){
		$menu_styles[$selector]['font-weight'] = $val;
	}
}


//Menu Items
// .shiftnav-target{
// 	color: @target-color;
// 	font-size: @font-size;
// 	font-weight: @target-font-weight;

// 	border-top: @target-border-top;
// 	border-bottom: @target-border-bottom;
// 	text-shadow: @target-text-shadow;

// }
// Active, Transitioning, and Current Targets
// &.shiftnav-active > .shiftnav-target,
// &.shiftnav-in-transition > .shiftnav-target
function shiftnav_get_menu_style_menu_item_font_color( $field , $config_id , &$menu_styles ){
	$val = shiftnav_op( $field['name'] , $config_id );
	$selector = ".shiftnav.shiftnav-$config_id ul.shiftnav-menu li.menu-item > .shiftnav-target";
	if( $val ){
		$menu_styles[$selector]['color'] = $val;
	}
}
function shiftnav_get_menu_style_menu_item_font_color_active( $field , $config_id , &$menu_styles ){
	$val = shiftnav_op( $field['name'] , $config_id );
	$selector = ".shiftnav.shiftnav-$config_id ul.shiftnav-menu li.menu-item.shiftnav-active > .shiftnav-target, ".
				".shiftnav.shiftnav-$config_id ul.shiftnav-menu li.menu-item.shiftnav-in-transition > .shiftnav-target, ".
				".shiftnav.shiftnav-$config_id ul.shiftnav-menu.shiftnav-active-on-hover li.menu-item > .shiftnav-target:hover, ".
				".shiftnav.shiftnav-$config_id ul.shiftnav-menu.shiftnav-active-highlight li.menu-item > .shiftnav-target:active";
	if( $val ){
		$menu_styles[$selector]['color'] = $val;
	}
}
function shiftnav_get_menu_style_menu_item_background_color( $field , $config_id , &$menu_styles ){
	$val = shiftnav_op( $field['name'] , $config_id );
	$selector = ".shiftnav.shiftnav-$config_id ul.shiftnav-menu li.menu-item > .shiftnav-target";
	if( $val ){
		$menu_styles[$selector]['background'] = $val;
	}
}
function shiftnav_get_menu_style_menu_item_background_color_active( $field , $config_id , &$menu_styles ){
	$val = shiftnav_op( $field['name'] , $config_id );
	$selector = ".shiftnav.shiftnav-$config_id ul.shiftnav-menu li.menu-item.shiftnav-active > .shiftnav-target, ".
				".shiftnav.shiftnav-$config_id ul.shiftnav-menu li.menu-item.shiftnav-in-transition > .shiftnav-target, ".
				".shiftnav.shiftnav-$config_id ul.shiftnav-menu.shiftnav-active-on-hover li.menu-item > .shiftnav-target:hover, ".
				".shiftnav.shiftnav-$config_id ul.shiftnav-menu.shiftnav-active-highlight li.menu-item > .shiftnav-target:active";
	if( $val ){
		$menu_styles[$selector]['background'] = $val;
	}
}
function shiftnav_get_menu_style_menu_item_font_size( $field , $config_id , &$menu_styles ){
	$val = shiftnav_op( $field['name'] , $config_id );
	$selector = ".shiftnav.shiftnav-$config_id ul.shiftnav-menu li.menu-item > .shiftnav-target";
	if( $val ){
		if( is_numeric( $val ) ) $val.='px';
		$menu_styles[$selector]['font-size'] = $val;
	}
}

function shiftnav_get_menu_style_menu_item_font_weight( $field , $config_id , &$menu_styles ){
	$val = shiftnav_op( $field['name'] , $config_id );
	$selector = ".shiftnav.shiftnav-$config_id ul.shiftnav-menu li.menu-item > .shiftnav-target";
	if( $val ){
		$menu_styles[$selector]['font-weight'] = $val;
	}
}

function shiftnav_get_menu_style_menu_item_padding( $field , $config_id , &$menu_styles ){
	$val = shiftnav_op( $field['name'] , $config_id );
	$selector = ".shiftnav.shiftnav-$config_id ul.shiftnav-menu li.menu-item > .shiftnav-target";
	if( $val ){
		if( is_numeric( $val ) ) $val.='px';
		$menu_styles[$selector]['padding'] = $val;
	}
}

function shiftnav_get_menu_style_menu_item_top_border_color( $field , $config_id , &$menu_styles ){
	$val = shiftnav_op( $field['name'] , $config_id );
	$selector = ".shiftnav.shiftnav-$config_id ul.shiftnav-menu li.menu-item > .shiftnav-target, .shiftnav.shiftnav-$config_id ul.shiftnav-menu li.menu-item > .shiftnav-submenu-activation";
	if( $val ){
		$menu_styles[$selector]['border-top'] = "1px solid $val";
	}
}
function shiftnav_get_menu_style_menu_item_bottom_border_color( $field , $config_id , &$menu_styles ){
	$val = shiftnav_op( $field['name'] , $config_id );
	$selector = ".shiftnav.shiftnav-$config_id ul.shiftnav-menu li.menu-item > .shiftnav-target, .shiftnav.shiftnav-$config_id ul.shiftnav-menu li.menu-item > .shiftnav-submenu-activation";
	if( $val ){
		$menu_styles[$selector]['border-bottom'] = "1px solid $val";
	}
}
function shiftnav_get_menu_style_menu_item_disable_text_shadow( $field , $config_id , &$menu_styles ){
	$val = shiftnav_op( $field['name'] , $config_id );
	$selector = ".shiftnav.shiftnav-$config_id ul.shiftnav-menu li.menu-item > .shiftnav-target";
	if( $val == 'on' || $val === true ){
		$menu_styles[$selector]['text-shadow'] = 'none';
	}
}
function shiftnav_get_menu_style_menu_item_disable_item_borders( $field , $config_id , &$menu_styles ){
	$val = shiftnav_op( $field['name'] , $config_id );
	$selector = ".shiftnav.shiftnav-$config_id ul.shiftnav-menu li.menu-item > .shiftnav-target, " .
				".shiftnav.shiftnav-$config_id ul.shiftnav-menu li.menu-item > .shiftnav-submenu-activation";
	if( $val == 'on' || $val === true ){
		$menu_styles[$selector]['border'] = 'none';
	}
}



//Activators
// .shiftnav-submenu-activation{
// 	background: @activation-background;
// 	color: @activation-color;

// 	&:hover{
// 		background: @activation-background-hover;
// 		color: @activation-color-hover;
// 	}
// }
// &.shiftnav-active > .shiftnav-submenu-activation,
// &.shiftnav-in-transition > .shiftnav-submenu-activation{
function shiftnav_get_menu_style_menu_item_activator_background( $field , $config_id , &$menu_styles ){
	$val = shiftnav_op( $field['name'] , $config_id );
	$selector = ".shiftnav.shiftnav-$config_id ul.shiftnav-menu li.menu-item > .shiftnav-submenu-activation";
	if( $val ){
		$menu_styles[$selector]['background'] = $val;
	}
}
function shiftnav_get_menu_style_menu_item_activator_background_hover( $field , $config_id , &$menu_styles ){
	$val = shiftnav_op( $field['name'] , $config_id );
	$selector = ".shiftnav.shiftnav-$config_id ul.shiftnav-menu li.menu-item > .shiftnav-submenu-activation:hover, ".
				".shiftnav.shiftnav-$config_id ul.shiftnav-menu li.menu-item.shiftnav-active > .shiftnav-submenu-activation, ".
				".shiftnav.shiftnav-$config_id ul.shiftnav-menu li.menu-item.shiftnav-in-transition > .shiftnav-submenu-activation";
	if( $val ){
		$menu_styles[$selector]['background'] = $val;
	}
}
function shiftnav_get_menu_style_menu_item_activator_color( $field , $config_id , &$menu_styles ){
	$val = shiftnav_op( $field['name'] , $config_id );
	$selector = ".shiftnav.shiftnav-$config_id ul.shiftnav-menu li.menu-item > .shiftnav-submenu-activation";
	if( $val ){
		$menu_styles[$selector]['color'] = $val;
	}
}
function shiftnav_get_menu_style_menu_item_activator_color_hover( $field , $config_id , &$menu_styles ){
	$val = shiftnav_op( $field['name'] , $config_id );
	$selector = ".shiftnav.shiftnav-$config_id ul.shiftnav-menu li.menu-item > .shiftnav-submenu-activation:hover, ".
				".shiftnav.shiftnav-$config_id ul.shiftnav-menu li.menu-item.shiftnav-active > .shiftnav-submenu-activation, ".
				".shiftnav.shiftnav-$config_id ul.shiftnav-menu li.menu-item.shiftnav-in-transition > .shiftnav-submenu-activation";
	if( $val ){
		$menu_styles[$selector]['color'] = $val;
	}
}





// Highlighted Targets
// &.shiftnav-highlight > .shiftnav-target,
// ul.sub-menu .shiftnav-highlight > .shiftnav-target{
// 		color:@highlight-color;
// 		background:@highlight-background;
// }
function shiftnav_get_menu_style_menu_item_background_highlight( $field , $config_id , &$menu_styles ){
	$val = shiftnav_op( $field['name'] , $config_id );
	$selector = ".shiftnav.shiftnav-$config_id ul.shiftnav-menu li.menu-item.shiftnav-highlight > .shiftnav-target, ".
				".shiftnav.shiftnav-$config_id ul.shiftnav-menu li.menu-item ul.sub-menu .shiftnav-highlight > .shiftnav-target";
	if( $val ){
		$menu_styles[$selector]['background'] = $val;
	}
}
function shiftnav_get_menu_style_menu_item_font_color_highlight( $field , $config_id , &$menu_styles ){
	$val = shiftnav_op( $field['name'] , $config_id );
	$selector = ".shiftnav.shiftnav-$config_id ul.shiftnav-menu li.menu-item.shiftnav-highlight > .shiftnav-target, ".
				".shiftnav.shiftnav-$config_id ul.shiftnav-menu li.menu-item ul.sub-menu .shiftnav-highlight > .shiftnav-target";
	
	if( $val ){
		$menu_styles[$selector]['color'] = $val;
	}
}



// Active, Transitioning, and Current Targets
// &.shiftnav-active > .shiftnav-target,
// &.shiftnav-in-transition > .shiftnav-target{
// 	color:@target-active-color;
// 	background:@target-active-background;
// 	border-top-color: @target-active-border-top-color;
// 	border-bottom-color: @target-active-border-bottom-color;
// }
function shiftnav_get_menu_style_menu_item_top_border_color_active( $field , $config_id , &$menu_styles ){
	$val = shiftnav_op( $field['name'] , $config_id );
	// $selector = ".shiftnav.shiftnav-$config_id ul.shiftnav-menu li.menu-item.shiftnav-active > .shiftnav-target, .shiftnav.shiftnav-$config_id ul.shiftnav-menu li.menu-item.shiftnav-in-transition > .shiftnav-target";
	$selector = ".shiftnav.shiftnav-$config_id ul.shiftnav-menu li.menu-item.shiftnav-active > .shiftnav-target, ".
				".shiftnav.shiftnav-$config_id ul.shiftnav-menu li.menu-item.shiftnav-in-transition > .shiftnav-target, ".
				".shiftnav.shiftnav-$config_id ul.shiftnav-menu.shiftnav-active-on-hover li.menu-item > .shiftnav-target:hover, ".
				".shiftnav.shiftnav-$config_id ul.shiftnav-menu.shiftnav-active-highlight li.menu-item > .shiftnav-target:active";
	if( $val ){
		$menu_styles[$selector]['border-top'] = "1px solid $val";
	}
}
function shiftnav_get_menu_style_menu_item_bottom_border_color_active( $field , $config_id , &$menu_styles ){
	$val = shiftnav_op( $field['name'] , $config_id );
	// $selector = ".shiftnav.shiftnav-$config_id ul.shiftnav-menu li.menu-item.shiftnav-active > .shiftnav-target, .shiftnav.shiftnav-$config_id ul.shiftnav-menu li.menu-item.shiftnav-in-transition > .shiftnav-target";
	$selector = ".shiftnav.shiftnav-$config_id ul.shiftnav-menu li.menu-item.shiftnav-active > .shiftnav-target, ".
				".shiftnav.shiftnav-$config_id ul.shiftnav-menu li.menu-item.shiftnav-in-transition > .shiftnav-target, ".
				".shiftnav.shiftnav-$config_id ul.shiftnav-menu.shiftnav-active-on-hover li.menu-item > .shiftnav-target:hover, ".
				".shiftnav.shiftnav-$config_id ul.shiftnav-menu.shiftnav-active-highlight li.menu-item > .shiftnav-target:active";
	if( $val ){
		$menu_styles[$selector]['border-bottom'] = "1px solid $val";
	}
}

// &.current-menu-item > .shiftnav-target,
// ul.sub-menu .current-menu-item .shiftnav-target{
// 	color:@target-current-color;
// 	background:@target-current-background;
// }
function shiftnav_get_menu_style_menu_item_background_current( $field , $config_id , &$menu_styles ){
	$val = shiftnav_op( $field['name'] , $config_id );
	$selector = ".shiftnav.shiftnav-$config_id ul.shiftnav-menu li.menu-item.current-menu-item > .shiftnav-target, ".
				".shiftnav.shiftnav-$config_id ul.shiftnav-menu li.menu-item ul.sub-menu .current-menu-item > .shiftnav-target, ".
				".shiftnav.shiftnav-$config_id ul.shiftnav-menu > li.shiftnav-sub-accordion.current-menu-ancestor > .shiftnav-target, ".
				".shiftnav.shiftnav-$config_id ul.shiftnav-menu > li.shiftnav-sub-shift.current-menu-ancestor > .shiftnav-target";
	if( $val ){
		$menu_styles[$selector]['background'] = $val;
	}
}
function shiftnav_get_menu_style_menu_item_font_color_current( $field , $config_id , &$menu_styles ){
	$val = shiftnav_op( $field['name'] , $config_id );
	$selector = ".shiftnav.shiftnav-$config_id ul.shiftnav-menu li.menu-item.current-menu-item > .shiftnav-target, ".
				".shiftnav.shiftnav-$config_id ul.shiftnav-menu li.menu-item ul.sub-menu .current-menu-item > .shiftnav-target, ".
				".shiftnav.shiftnav-$config_id ul.shiftnav-menu > li.shiftnav-sub-accordion.current-menu-ancestor > .shiftnav-target, ".
				".shiftnav.shiftnav-$config_id ul.shiftnav-menu > li.shiftnav-sub-shift.current-menu-ancestor > .shiftnav-target";
	if( $val ){
		$menu_styles[$selector]['color'] = $val;
	}
}


// Top Level Targets
// > li.menu-item > .shiftnav-target{
// 	text-transform: @target-text-transform-l1;
// }
function shiftnav_get_menu_style_menu_item_top_level_text_transform( $field , $config_id , &$menu_styles ){
	$val = shiftnav_op( $field['name'] , $config_id );
	$selector = ".shiftnav.shiftnav-$config_id ul.shiftnav-menu > li.menu-item > .shiftnav-target";
	if( $val ){
		$menu_styles[$selector]['text-transform'] = $val;
	}
}




// Retractors
// li.shiftnav-retract .shiftnav-target{
// 	background: @retractor-background;
// 	color: @retractor-color;
// 	text-transform: @retractor-text-transform;
// 	font-size:@retractor-font-size;
// 	text-align:@retractor-text-align;
// }
function shiftnav_get_menu_style_menu_retractor_background( $field , $config_id , &$menu_styles ){
	$val = shiftnav_op( $field['name'] , $config_id );
	$selector = ".shiftnav.shiftnav-$config_id ul.shiftnav-menu li.shiftnav-retract .shiftnav-target";
	if( $val ){
		$menu_styles[$selector]['background'] = $val;
	}
}
function shiftnav_get_menu_style_menu_retractor_font_color( $field , $config_id , &$menu_styles ){
	$val = shiftnav_op( $field['name'] , $config_id );
	$selector = ".shiftnav.shiftnav-$config_id ul.shiftnav-menu li.shiftnav-retract .shiftnav-target";
	if( $val ){
		$menu_styles[$selector]['color'] = $val;
	}
}
function shiftnav_get_menu_style_menu_retractor_text_align( $field , $config_id , &$menu_styles ){
	$val = shiftnav_op( $field['name'] , $config_id );
	$selector = ".shiftnav.shiftnav-$config_id ul.shiftnav-menu li.shiftnav-retract .shiftnav-target";
	if( $val ){
		$menu_styles[$selector]['text-align'] = $val;
	}
}




// Submenus
// ul.sub-menu{
// 	color:@submenu-color;
// 	background:@submenu-background;

// 	li.menu-item > .shiftnav-target{
// 		color:@submenu-target-color;
// 		border-width:@target-submenu-target-border-width;
// 		border-top-color: @target-submenu-target-border-top-color;
// 		border-bottom-color: @target-submenu-target-border-bottom-color;
// 		font-weight:@submenu-target-font-weight;
// 		font-size:@submenu-target-font-size;
// 	}
// }
function shiftnav_get_menu_style_submenu_background( $field , $config_id , &$menu_styles ){
	$val = shiftnav_op( $field['name'] , $config_id );
	$selector = ".shiftnav.shiftnav-$config_id ul.shiftnav-menu ul.sub-menu";
	if( $val ){
		$menu_styles[$selector]['background'] = $val;
	}
}
function shiftnav_get_menu_style_submenu_item_background( $field , $config_id , &$menu_styles ){
	$val = shiftnav_op( $field['name'] , $config_id );
	$selector = ".shiftnav.shiftnav-$config_id ul.shiftnav-menu ul.sub-menu li.menu-item > .shiftnav-target";
	if( $val ){
		$menu_styles[$selector]['background'] = $val;
	}
}
function shiftnav_get_menu_style_submenu_item_font_color( $field , $config_id , &$menu_styles ){
	$val = shiftnav_op( $field['name'] , $config_id );
	$selector = ".shiftnav.shiftnav-$config_id ul.shiftnav-menu ul.sub-menu li.menu-item > .shiftnav-target";
	if( $val ){
		$menu_styles[$selector]['color'] = $val;
	}
}
function shiftnav_get_menu_style_submenu_item_border_top_color( $field , $config_id , &$menu_styles ){
	$val = shiftnav_op( $field['name'] , $config_id );
	$selector = ".shiftnav.shiftnav-$config_id ul.shiftnav-menu ul.sub-menu li.menu-item > .shiftnav-target";
	if( $val ){
		$menu_styles[$selector]['border-top'] = "1px solid $val";
	}
}
function shiftnav_get_menu_style_submenu_item_border_bottom_color( $field , $config_id , &$menu_styles ){
	$val = shiftnav_op( $field['name'] , $config_id );
	$selector = ".shiftnav.shiftnav-$config_id ul.shiftnav-menu ul.sub-menu li.menu-item > .shiftnav-target";
	if( $val ){
		$menu_styles[$selector]['border-bottom'] = "1px solid $val";
	}
}
// function shiftnav_get_menu_style_menu_item_disable_submenu_item_borders( $field , $config_id , &$menu_styles ){
// 	$val = shiftnav_op( $field['name'] , $config_id );
// 	$selector = ".shiftnav.shiftnav-$config_id ul.shiftnav-menu li.menu-item > .shiftnav-target";
// 	if( $val == 'on' || $val === true ){
// 		$menu_styles[$selector]['border'] = 'none';
// 	}
// }
function shiftnav_get_menu_style_submenu_item_font_size( $field , $config_id , &$menu_styles ){
	$val = shiftnav_op( $field['name'] , $config_id );
	$selector = ".shiftnav.shiftnav-$config_id ul.shiftnav-menu ul.sub-menu li.menu-item > .shiftnav-target";
	if( $val ){
		if( is_numeric( $val ) ) $val.= 'px';
		$menu_styles[$selector]['font-size'] = $val;
	}
}
function shiftnav_get_menu_style_submenu_item_font_weight( $field , $config_id , &$menu_styles ){
	$val = shiftnav_op( $field['name'] , $config_id );
	$selector = ".shiftnav.shiftnav-$config_id ul.shiftnav-menu ul.sub-menu li.menu-item > .shiftnav-target";
	if( $val ){
		$menu_styles[$selector]['font-weight'] = $val;
	}
}









