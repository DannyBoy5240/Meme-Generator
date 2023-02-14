<?php

// Container Padding
FLBuilderCSS::dimension_field_rule( array(
	'settings'     => $settings,
	'setting_name' => 'nav_padding',
	'selector'     => ".fl-node-$id nav.post-navigation",
	'unit'         => 'px',
	'props'        => array(
		'padding-top'    => 'nav_padding_top',
		'padding-right'  => 'nav_padding_right',
		'padding-bottom' => 'nav_padding_bottom',
		'padding-left'   => 'nav_padding_left',
	),
) );

// Container Margins
FLBuilderCSS::dimension_field_rule( array(
	'settings'     => $settings,
	'setting_name' => 'nav_margins',
	'selector'     => ".fl-node-$id nav.post-navigation",
	'unit'         => 'px',
	'props'        => array(
		'margin-top'    => 'nav_margins_top',
		'margin-right'  => 'nav_margins_right',
		'margin-bottom' => 'nav_margins_bottom',
		'margin-left'   => 'nav_margins_left',
	),
) );

// Container Border
FLBuilderCSS::border_field_rule( array(
	'settings'     => $settings,
	'setting_name' => 'nav_border',
	'selector'     => ".fl-node-$id nav.post-navigation",
) );

// Text/Link Padding
FLBuilderCSS::dimension_field_rule( array(
	'settings'     => $settings,
	'setting_name' => 'text_padding',
	'selector'     => ".fl-node-$id .nav-links a",
	'unit'         => 'px',
	'props'        => array(
		'padding-top'    => 'text_padding_top',
		'padding-right'  => 'text_padding_right',
		'padding-bottom' => 'text_padding_bottom',
		'padding-left'   => 'text_padding_left',
	),
) );

// Text Color
FLBuilderCSS::rule( array(
	'selector' => ".fl-node-$id .nav-links a",
	'props'    => array(
		'color'            => $settings->text_color,
		'background-color' => $settings->text_bg_color,
	),
) );

// Text Typography
FLBuilderCSS::typography_field_rule( array(
	'settings'     => $settings,
	'setting_name' => 'text_typography',
	'selector'     => ".fl-node-$id .nav-links .nav-previous, .fl-node-$id .nav-links .nav-next",
) );

// Nav Link, Nav Previous and Nav Next display:block on responsivew.
FLBuilderCSS::rule( array(
	'media'    => 'responsive',
	'selector' => ".fl-node-$id .nav-links, .fl-node-$id .nav-links .nav-previous, .fl-node-$id .nav-links .nav-next",
	'props'    => array(
		'display' => 'block',
		'width'   => '100%',
	),
) );

?>
.fl-node-<?php echo $id; ?> .nav-links { 
	display: flex;
	flex-direction: row;
	width: 100%;
}
.fl-node-<?php echo $id; ?> .nav-links .nav-previous,
.fl-node-<?php echo $id; ?> .nav-links .nav-next { 
	display: block;
	width: 100%;
}
.fl-node-<?php echo $id; ?> .nav-links a { 
	display: inline-block;
}
.fl-node-<?php echo $id; ?> .nav-links .nav-previous { 
	text-align: left;
}
.fl-node-<?php echo $id; ?> .nav-links .nav-next { 
	text-align: right;
}
