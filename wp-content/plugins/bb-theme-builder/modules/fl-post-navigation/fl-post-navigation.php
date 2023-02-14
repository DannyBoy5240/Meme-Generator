<?php

/**
 * @since 1.0
 * @class FLPostNavigationModule
 */
class FLPostNavigationModule extends FLBuilderModule {

	/**
	 * @method __construct
	 */
	public function __construct() {
		parent::__construct(array(
			'name'            => __( 'Post Navigation', 'bb-theme-builder' ),
			'description'     => __( 'Displays the next / previous post navigation links.', 'bb-theme-builder' ),
			'group'           => __( 'Themer Modules', 'bb-theme-builder' ),
			'category'        => __( 'Posts', 'bb-theme-builder' ),
			'partial_refresh' => true,
			'dir'             => FL_THEME_BUILDER_DIR . 'modules/fl-post-navigation/',
			'url'             => FL_THEME_BUILDER_URL . 'modules/fl-post-navigation/',
			'enabled'         => FLThemeBuilderLayoutData::current_post_is( 'singular' ),
		));
	}
}

FLBuilder::register_module( 'FLPostNavigationModule', array(
	'general'   => array(
		'title'    => __( 'Settings', 'bb-theme-builder' ),
		'sections' => array(
			'general'               => array(
				'title'  => '',
				'fields' => array(
					'navigation_link' => array(
						'type'    => 'select',
						'label'   => __( 'Navigation Links', 'bb-theme-builder' ),
						'default' => 'both',
						'toggle'  => array(
							'both' => array(
								'fields' => array( 'prev_text', 'next_text' ),
							),
							'prev' => array(
								'fields' => array( 'prev_text' ),
							),
							'next' => array(
								'fields' => array( 'next_text' ),
							),
						),
						'options' => array(
							'both' => __( 'Both Previous and Next Links', 'bb-theme-builder' ),
							'prev' => __( 'Previous Link', 'bb-theme-builder' ),
							'next' => __( 'Next Link', 'bb-theme-builder' ),
						),
						'help'    => __( 'Determine the navigation link to show.', 'bb-theme-builder' ),
					),
					'prev_text'       => array(
						'type'        => 'text',
						'label'       => __( 'Previous Link Text', 'bb-theme-builder' ),
						'default'     => '&larr; %title',
						'placeholder' => '&larr; %title',
					),
					'next_text'       => array(
						'type'        => 'text',
						'label'       => __( 'Next Link Text', 'bb-theme-builder' ),
						'default'     => '%title &rarr;',
						'placeholder' => '%title &rarr;',
					),
					'in_same_term'    => array(
						'type'    => 'select',
						'label'   => __( 'Navigate in same taxonomy', 'bb-theme-builder' ),
						'default' => '0',
						'help'    => __( 'Whether to navigate in the same taxonomy as the current post or not.', 'bb-theme-builder' ),
						'toggle'  => array(
							'1' => array(
								'fields' => array( 'tax_select' ),
							),
						),
						'options' => array(
							'1' => __( 'Enable', 'bb-theme-builder' ),
							'0' => __( 'Disable', 'bb-theme-builder' ),
						),
					),
					'tax_select'      => array(
						'type'    => 'text',
						'size'    => 16,
						'label'   => __( 'Taxonomy', 'bb-theme-builder' ),
						'default' => 'category',
						'help'    => __( 'The default taxonomy is category.', 'bb-theme-builder' ),
					),
				),
			),
			'accessibility_section' => array(
				'title'  => 'Accessibility',
				'fields' => array(
					'aria_label'         => array(
						'type'    => 'text',
						'label'   => __( 'ARIA Label', 'bb-theme-builder' ),
						'default' => 'Posts',
					),
					'screen_reader_text' => array(
						'type'    => 'text',
						'label'   => __( 'Screen Reader Text', 'bb-theme-builder' ),
						'default' => 'Posts navigation',
					),
				),
			),
		),
	),
	'style_tab' => array(
		'title'    => __( 'Style', 'bb-theme-builder' ),
		'sections' => array(
			'style_section'           => array(
				'title'  => 'Text Style',
				'fields' => array(
					'text_padding'    => array(
						'type'       => 'dimension',
						'label'      => __( 'Text Padding', 'bb-theme-builder' ),
						'responsive' => true,
						'slider'     => true,
						'units'      => array( 'px' ),
						'preview'    => array(
							'type'     => 'css',
							'property' => 'padding',
							'selector' => '{node} .nav-links a',
						),
					),
					'text_color'      => array(
						'type'       => 'color',
						'label'      => __( 'Text Color', 'bb-theme-builder' ),
						'show_reset' => true,
						'show_alpha' => true,
						'preview'    => array(
							'type'     => 'css',
							'property' => 'color',
							'selector' => '{node} .nav-links a',
						),
					),
					'text_bg_color'   => array(
						'type'       => 'color',
						'label'      => __( 'Text Background Color', 'bb-theme-builder' ),
						'show_reset' => true,
						'show_alpha' => true,
						'preview'    => array(
							'type'     => 'css',
							'property' => 'background-color',
							'selector' => '{node} .nav-links a',
						),
					),
					'text_typography' => array(
						'type'       => 'typography',
						'label'      => 'Text Typography',
						'responsive' => true,
						'disabled'   => array(
							'default'    => array( 'text_align' ),
							'medium'     => array( 'text_align' ),
							'responsive' => array( 'text_align' ),
						),
						'preview'    => array(
							'type'     => 'css',
							'selector' => '{node} .nav-links .nav-previous, {node} .nav-links .nav-next',
						),
					),
				),
			),
			'container_style_section' => array(
				'title'     => __( 'Container Style', 'bb-theme-builder' ),
				'collapsed' => true,
				'fields'    => array(
					'nav_padding' => array(
						'type'       => 'dimension',
						'label'      => __( 'Container Padding', 'bb-theme-builder' ),
						'responsive' => true,
						'slider'     => true,
						'units'      => array( 'px' ),
						'preview'    => array(
							'type'     => 'css',
							'property' => 'padding',
							'selector' => '{node} nav.post-navigation',
						),
					),
					'nav_margins' => array(
						'type'       => 'dimension',
						'label'      => __( 'Container Margins', 'bb-theme-builder' ),
						'responsive' => true,
						'slider'     => true,
						'units'      => array( 'px' ),
						'preview'    => array(
							'type'     => 'css',
							'property' => 'margin',
							'selector' => '{node} nav.post-navigation',
						),
					),
					'nav_border'  => array(
						'type'       => 'border',
						'label'      => 'Container Border',
						'responsive' => true,
						'preview'    => array(
							'type'     => 'css',
							'selector' => '{node} nav.post-navigation',
						),
					),
				),
			),
		),
	),
) );
