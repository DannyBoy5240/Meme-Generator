<?php

// typography
FLBuilderCSS::typography_field_rule( array(
	'settings'     => $settings,
	'setting_name' => 'typography',
	'selector'     => ".fl-node-$id",
) );

// color
FLBuilderCSS::rule( array(
	'selector' => ".fl-node-$id, .fl-node-$id .fl-module-content.fl-node-content span[class^='fl-post-info'], .fl-node-$id .fl-node-content a",
	'enabled'  => ! empty( $settings->text_color ),
	'props'    => array(
		'color' => $settings->text_color,
	),
) );

// link color
FLBuilderCSS::rule( array(
	'selector' => ".fl-node-$id .fl-node-content a",
	'enabled'  => ! empty( $settings->link_color ),
	'props'    => array(
		'color' => $settings->link_color,
	),
) );

// link hover color
FLBuilderCSS::rule( array(
	'selector' => ".fl-node-$id .fl-node-content a:hover",
	'enabled'  => ! empty( $settings->link_hover_color ),
	'props'    => array(
		'color' => $settings->link_hover_color,
	),
) );
