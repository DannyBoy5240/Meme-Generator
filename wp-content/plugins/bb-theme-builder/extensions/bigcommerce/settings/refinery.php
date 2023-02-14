<?php
return array(
	'bc_refinery'                          => array(
		'type'    => 'select',
		'label'   => __( 'Product Search &amp; Filter', 'bb-theme-builder' ),
		'help'    => __( 'Displays search, filter, and sort controls for products', 'bb-theme-builder' ),
		'default' => 'hide',
		'options' => array(
			'show' => __( 'Show', 'bb-theme-builder' ),
			'hide' => __( 'Hide', 'bb-theme-builder' ),
		),
		'toggle'  => array(
			'show' => array(
				'fields' => array(
					'bc_refinery_search_button_background',
					'bc_refinery_search_button_text_color',
					'bc_refinery_search_button_border',
				),
			),
		),
	),
	'bc_refinery_search_button_background' => array(
		'type'       => 'color',
		'label'      => __( 'Search Button Background', 'bb-theme-builder' ),
		'help'       => __( 'Customize text for Refinery search button', 'bb-theme-builder' ),
		'show_reset' => true,
		'preview'    => array(
			'type'     => 'css',
			'selector' => '.fl-module-content .bc-product-archive__search-submit',
			'property' => 'background-color',
		),
	),
	'bc_refinery_search_button_text_color' => array(
		'type'       => 'color',
		'label'      => __( 'Search Button Text Color', 'bb-theme-builder' ),
		'help'       => __( 'Customize text color for Refinery search button', 'bb-theme-builder' ),
		'show_reset' => true,
		'preview'    => array(
			'type'     => 'css',
			'selector' => '.fl-module-content .bc-product-archive__search-submit',
			'property' => 'color',
		),
	),
	'bc_refinery_search_button_border'     => array(
		'type'    => 'border',
		'label'   => __( 'Search Button Border', 'bb-theme-builder' ),
		'help'    => __( 'Customize border for Refinery search button', 'bb-theme-builder' ),
		'preview' => array(
			'type'     => 'css',
			'selector' => '.fl-module-content .bc-product-archive__search-submit',
			'property' => 'border',
		),
	),
);
