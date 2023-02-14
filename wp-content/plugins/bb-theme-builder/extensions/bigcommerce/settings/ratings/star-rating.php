<?php
return array(
	'title'  => __( 'Star Rating', 'bb-theme-builder' ),
	'fields' => array(
		'bc_star_foreground' => array(
			'type'       => 'color',
			'label'      => __( 'Star Rating Foreground Color', 'bb-theme-builder' ),
			'help'       => __( 'Controls the foreground color of the rating symbols', 'bb-theme-builder' ),
			'show_reset' => true,
			'preview'    => array(
				'type'     => 'css',
				'selector' => '.bc-single-product__rating--top',
				'property' => 'color',
			),
		),
		'bc_star_background' => array(
			'type'       => 'color',
			'label'      => __( 'Star Rating Background Color', 'bb-theme-builder' ),
			'help'       => __( 'Controls the background color of the rating symbols.', 'bb-theme-builder' ),
			'show_reset' => true,
			'preview'    => array(
				'type'     => 'css',
				'selector' => '.bc-single-product__rating--bottom',
				'property' => 'color',
			),

		),
	),
);
