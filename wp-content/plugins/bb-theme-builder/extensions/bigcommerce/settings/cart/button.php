<?php
return array(
	'bc_button_typography'       => array(
		'type'       => 'typography',
		'label'      => __( 'Button Text', 'bb-theme-builder' ),
		'responsive' => true,
		'preview'    => array(
			'type'     => 'css',
			'selector' => '.fl-module-content .bc-btn--add_to_cart',
		),
	),
	'bc_button_text_color'       => array(
		'type'       => 'color',
		'label'      => __( 'Button Text Color', 'bb-theme-builder' ),
		'show_reset' => true,
		'show_alpha' => true,
		'preview'    => array(
			'type'      => 'css',
			'selector'  => '.fl-module-content .bc-btn--add_to_cart',
			'property'  => 'color',
			'important' => true,
		),
	),
	'bc_button_background_color' => array(
		'type'       => 'color',
		'label'      => __( 'Background Color', 'bb-theme-builder' ),
		'show_reset' => true,
		'show_alpha' => true,
		'preview'    => array(
			'type'      => 'css',
			'selector'  => '.fl-module-content .bc-btn--add_to_cart',
			'property'  => 'background-color',
			'important' => true,
		),
	),
	'bc_button_border'           => array(
		'type'       => 'border',
		'label'      => __( 'Button Border', 'bb-theme-builder' ),
		'responsive' => true,
		'preview'    => array(
			'type'     => 'css',
			'selector' => '.fl-module-content .bc-btn--add_to_cart',
		),
	),
);
