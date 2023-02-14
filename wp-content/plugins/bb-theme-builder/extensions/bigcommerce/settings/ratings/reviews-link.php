<?php
return array(
	'title'  => __( 'Reviews Link', 'bb-theme-builder' ),
	'fields' => array(
		'bc_link_typography'  => array(
			'type'       => 'typography',
			'label'      => __( 'Link Style', 'bb-theme-builder' ),
			'responsive' => true,
			'preview'    => array(
				'type'     => 'css',
				'selector' => '.fl-module-content .bc-single-product__reviews-anchor',
			),
		),
		'bc_link_color'       => array(
			'type'       => 'color',
			'label'      => __( 'Link Text Color', 'bb-theme-builder' ),
			'show_reset' => true,
			'preview'    => array(
				'type'      => 'css',
				'selector'  => '.fl-module-content .bc-single-product__reviews-anchor',
				'property'  => 'color',
				'important' => true,
			),
		),
		'bc_link_hover_color' => array(
			'type'       => 'color',
			'label'      => __( 'Link Hover Color', 'bb-theme-builder' ),
			'show_reset' => true,
			'preview'    => array(
				'type'      => 'css',
				'selector'  => '.fl-module-content .bc-single-product__reviews-anchor::hover',
				'property'  => 'color',
				'important' => true,
			),
		),
	),
);
