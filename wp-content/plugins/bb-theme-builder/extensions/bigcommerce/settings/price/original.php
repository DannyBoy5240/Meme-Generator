<?php
return array(
	'original_price_typography' => array(
		'type'       => 'typography',
		'label'      => __( 'Text', 'bb-theme-builder' ),
		'help'       => __( 'Customize text for product base price', 'bb-theme-builder' ),
		'responsive' => true,
		'preview'    => array(
			'type'     => 'css',
			'selector' => '.fl-module-content .bc-product__original-price',
		),
	),
	'original_price_text_color' => array(
		'type'       => 'color',
		'label'      => __( 'Text Color', 'bb-theme-builder' ),
		'help'       => __( 'Customize text color for product base price', 'bb-theme-builder' ),
		'show_reset' => true,
		'preview'    => array(
			'type'     => 'css',
			'selector' => '.fl-module-content .bc-product__original-price',
			'property' => 'color',
		),
	),
);
