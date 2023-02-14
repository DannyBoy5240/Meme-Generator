<?php
return array(
	'bc_form_typography' => array(
		'type'       => 'typography',
		'label'      => __( 'Cart Form Label Text', 'bb-theme-builder' ),
		'help'       => __( 'Labels for Cart Form, i.e. "Quantity"', 'bb-theme-builder' ),
		'responsive' => true,
		'preview'    => array(
			'type'     => 'css',
			'selector' => '.fl-module-content .bc-product-form__option-label, .fl-module-content .bc-product-form__quantity-label',
		),
	),
	'bc_form_text_color' => array(
		'type'       => 'color',
		'label'      => __( 'Cart Form Label Text Color', 'bb-theme-builder' ),
		'show_reset' => true,
		'preview'    => array(
			'type'     => 'css',
			'selector' => '.fl-module-content .bc-product-form__option-label, .fl-module-content .bc-product-form__quantity-label',
			'property' => 'color',
		),
	),
);
