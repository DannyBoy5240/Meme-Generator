<?php
return array(
	'sale_price_typography' => array(
		'type'       => 'typography',
		'label'      => __( 'Sale Price Text', 'bb-theme-builder' ),
		'help'       => __( 'Customize text for product sale price', 'bb-theme-builder' ),
		'responsive' => true,
		'preview'    => array(
			'type'     => 'css',
			'selector' => '.fl-module-content .bc-product__price--sale',
		),
	),
	'sale_price_text_color' => array(
		'type'       => 'color',
		'label'      => __( 'Text Color', 'bb-theme-builder' ),
		'help'       => __( 'Customize text color for product sale price', 'bb-theme-builder' ),
		'show_reset' => true,
		'preview'    => array(
			'type'     => 'css',
			'selector' => '.fl-module-content .bc-product__price--sale',
			'property' => 'color',
		),
	),
);
