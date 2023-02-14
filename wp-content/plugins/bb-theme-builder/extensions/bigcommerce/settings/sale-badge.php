<?php
return array(
	'bc_sale_background_color' => array(
		'type'       => 'color',
		'label'      => __( 'Background Color', 'bb-theme-builder' ),
		'help'       => __( 'Customize background color for "On Sale" badge', 'bb-theme-builder' ),
		'show_reset' => true,
		'preview'    => array(
			'type'     => 'css',
			'selector' => '.bc-product-flag--sale',
			'property' => 'background-color',
		),
	),
	'bc_sale_text_color'       => array(
		'type'       => 'color',
		'label'      => __( 'Text Color', 'bb-theme-builder' ),
		'help'       => __( 'Customize text color for "On Sale" badge', 'bb-theme-builder' ),
		'show_reset' => true,
		'preview'    => array(
			'type'     => 'css',
			'selector' => '.bc-product-flag--sale',
			'property' => 'color',
		),
	),
);
