<?php

/**
 * @since 1.0
 * @class FLAuthorBioModule
 */
class FLAuthorBioModule extends FLBuilderModule {

	/**
	 * @method __construct
	 */
	public function __construct() {
		parent::__construct(array(
			'name'            => __( 'Author Bio', 'bb-theme-builder' ),
			'description'     => __( 'Displays the author bio box for a post.', 'bb-theme-builder' ),
			'group'           => __( 'Themer Modules', 'bb-theme-builder' ),
			'category'        => __( 'Posts', 'bb-theme-builder' ),
			'partial_refresh' => true,
			'dir'             => FL_THEME_BUILDER_DIR . 'modules/fl-author-bio/',
			'url'             => FL_THEME_BUILDER_URL . 'modules/fl-author-bio/',
			'enabled'         => FLThemeBuilderLayoutData::current_post_is( 'singular' ),
		));
	}
}

FLBuilder::register_module( 'FLAuthorBioModule', array(
	'general' => array(
		'title'    => __( 'Style', 'bb-theme-builder' ),
		'sections' => array(
			'general' => array(
				'title'  => '',
				'fields' => array(
					'image_size' => array(
						'type'        => 'text',
						'label'       => __( 'Image Size', 'bb-theme-builder' ),
						'default'     => '100',
						'size'        => '5',
						'description' => 'px',
						'placeholder' => '512',
					),
					'bg_color'   => array(
						'type'       => 'color',
						'label'      => __( 'Background Color', 'bb-theme-builder' ),
						'default'    => 'F0F0F0',
						'show_reset' => true,
					),
					'text_color' => array(
						'type'       => 'color',
						'label'      => __( 'Text Color', 'bb-theme-builder' ),
						'show_reset' => true,
					),
				),
			),
		),
	),
) );
