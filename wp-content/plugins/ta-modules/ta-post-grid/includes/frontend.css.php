<?php

$layout = $module->get_layout_slug();
$file   = $module->dir . 'includes/post-' . $layout;
$custom = isset( $settings->post_layout ) && 'custom' == $settings->post_layout;

if ( fl_builder_filesystem()->file_exists( $file . '-common.css.php' ) ) {
	include $file . '-common.css.php';
}
if ( ! $custom && fl_builder_filesystem()->file_exists( $file . '.css.php' ) ) {
	include $file . '.css.php';
}

if ( 'load_more' == $settings->pagination ) {
	FLBuilder::render_module_css('button', $id, array(
		'align'             => 'center',
		'bg_color'          => $settings->more_btn_bg_color,
		'bg_hover_color'    => $settings->more_btn_bg_hover_color,
		'border_radius'     => $settings->more_btn_border_radius,
		'font_size'         => $settings->more_btn_font_size,
		'icon'              => $settings->more_btn_icon,
		'icon_position'     => $settings->more_btn_icon_position,
		'icon_animation'    => $settings->more_btn_icon_animation,
		'link'              => '#',
		'link_target'       => '_self',
		'padding'           => $settings->more_btn_padding,
		'text'              => $settings->more_btn_text,
		'text_color'        => $settings->more_btn_text_color,
		'text_hover_color'  => $settings->more_btn_text_hover_color,
		'width'             => $settings->more_btn_width,
	));
}
