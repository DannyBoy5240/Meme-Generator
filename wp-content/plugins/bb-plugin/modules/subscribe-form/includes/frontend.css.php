<?php

// Input - gap
FLBuilderCSS::rule( array(
	'selector' => ".fl-node-$id .fl-form-field",
	'enabled'  => ! empty( $settings->input_gap ),
	'props'    => array(
		'margin-bottom' => "{$settings->input_gap}px",
	),
) );

// Input - padding
FLBuilderCSS::dimension_field_rule( array(
	'settings'     => $settings,
	'setting_name' => 'input_padding',
	'selector'     => ".fl-node-$id .fl-form-field input",
	'unit'         => 'px',
	'props'        => array(
		'padding-top'    => 'input_padding_top',
		'padding-right'  => 'input_padding_right',
		'padding-bottom' => 'input_padding_bottom',
		'padding-left'   => 'input_padding_left',
	),
) );

// Input - color
FLBuilderCSS::rule( array(
	'selector' => ".fl-node-$id .fl-form-field input",
	'props'    => array(
		'color' => $settings->input_text_color,
	),
) );

FLBuilderCSS::rule( array(
	'selector' => ".fl-node-$id .fl-form-field input:hover, .fl-node-$id .fl-form-field input:focus",
	'props'    => array(
		'color' => $settings->input_text_hover_color,
	),
) );

// Input - typography
FLBuilderCSS::typography_field_rule( array(
	'settings'     => $settings,
	'setting_name' => 'input_typography',
	'selector'     => ".fl-node-$id .fl-form-field input",
) );

// Input - background
FLBuilderCSS::rule( array(
	'selector' => ".fl-node-$id .fl-form-field input",
	'props'    => array(
		'background-color' => $settings->input_bg_color,
	),
) );

FLBuilderCSS::rule( array(
	'selector' => ".fl-node-$id .fl-form-field input:hover, .fl-node-$id .fl-form-field input:focus",
	'props'    => array(
		'background-color' => $settings->input_bg_hover_color,
	),
) );

// Input - border
FLBuilderCSS::border_field_rule( array(
	'settings'     => $settings,
	'setting_name' => 'input_border',
	'selector'     => ".fl-node-$id .fl-form-field input",
) );

FLBuilderCSS::rule( array(
	'selector' => ".fl-node-$id .fl-form-field input:hover, .fl-node-$id .fl-form-field input:focus",
	'props'    => array(
		'border-color' => $settings->input_border_hover_color,
	),
) );

// Button
FLBuilderCSS::rule( array(
	'selector' => ".fl-node-$id a.fl-button, .fl-node-$id a.fl-button:visited, .fl-node-$id a.fl-button *, .fl-node-$id a.fl-button:visited *",
	'enabled'  => ! empty( $settings->btn_text_color ),
	'props'    => array(
		'color' => $settings->btn_text_color,
	),
) );

FLBuilderCSS::rule( array(
	'selector' => ".fl-node-$id a.fl-button:hover, .fl-node-$id a.fl-button:hover *",
	'enabled'  => ! empty( $settings->btn_text_hover_color ),
	'props'    => array(
		'color' => $settings->btn_text_hover_color,
	),
) );

FLBuilder::render_module_css( 'button', $id, $module->get_button_settings() );

// Hide message
FLBuilderCSS::rule( array(
	'selector' => ".fl-node-$id .fl-form-success-message",
	'props'    => array(
		'display' => 'none',
	),
) );
