<?php

/**
 * @class FLTATextModule
 */
class FLTATextModule extends FLBuilderModule {

	/**
	 * @method __construct
	 */
	public function __construct() {
		parent::__construct(array(
			'name'          	=> __( 'Text Editor', 'fl-builder' ),
			'description'   	=> __( 'A WYSIWYG text editor.', 'fl-builder' ),
			'category'      	=> __( 'TA Modules', 'fl-builder' ),
      'dir'           => TA_MODULES_DIR . 'text/',
      'url'           => TA_MODULES_URL . 'text/',
      'editor_export' => true, // Defaults to true and can be omitted.
      'enabled'       => true, // Defaults to true and can be omitted.
		));
	}
}

/**
 * Register the module and its form settings.
 */
FLBuilder::register_module('FLTATextModule', array(
	'general'       => array( // Tab
		'title'         => __( 'General', 'fl-builder' ), // Tab title
		'sections'      => array( // Tab Sections
			'general'       => array( // Section
				'title'         => '', // Section Title
				'fields'        => array( // Section Fields
					'text'          => array(
						'type'          => 'editor',
						'label'         => '',
						'rows'          => 13,
						'wpautop'		=> false,
						'preview'         => array(
							'type'             => 'text',
							'selector'         => '.ta-rich-text',
						),
						'connections'   => array( 'string' ),
					),
				),
			),
		),
  ),
  'style'        => array(
		'title'         => __( 'Style', 'fl-builder' ),
		'sections'      => array(
			'general'       => array(
				'title'         => '',
				'fields'        => array(
					'text_color'        => array(
						'type'          => 'select',
						'label'         => __( 'Text Color', 'fl-builder' ),
						'default'       => 'gray',
						'options'       => array(
              'gray'    => __( 'Gray', 'fl-builder' ),
							'pink'    => __( 'Pink', 'fl-builder' ),
              'blue'      => __( 'Blue', 'fl-builder' ),
              'white'      => __( 'White', 'fl-builder' ),
						),
          ),
          'text_style'        => array(
						'type'          => 'select',
						'label'         => __( 'Text Style', 'fl-builder' ),
						'default'       => 'regular',
						'options'       => array(
              'regular'    => __( 'Regular', 'fl-builder' ),
							'uppercase'    => __( 'Uppercase', 'fl-builder' ),
						),
          ),
          'text_size'        => array(
						'type'          => 'select',
						'label'         => __( 'Text Size', 'fl-builder' ),
						'default'       => 'medium',
						'options'       => array(
              'x-large'    => __( 'X-Large', 'fl-builder' ),
              'large'    => __( 'Large', 'fl-builder' ),
              'medium'    => __( 'Medium', 'fl-builder' ),
              'small'    => __( 'Small', 'fl-builder' ),
              'x-small'    => __( 'X-Small', 'fl-builder' ),
						),
          ),
          'text_align'        => array(
						'type'          => 'select',
						'label'         => __( 'Text Alignment', 'fl-builder' ),
						'default'       => 'left',
						'options'       => array(
              'left'    => __( 'Left', 'fl-builder' ),
              'right'    => __( 'Right', 'fl-builder' ),
              'center'    => __( 'Center', 'fl-builder' ),
						),
          ),
          'text_width'        => array(
						'type'          => 'select',
						'label'         => __( 'Text Width', 'fl-builder' ),
						'default'       => 'full',
						'options'       => array(
              'full'    => __( 'Full width of column', 'fl-builder' ),
              'twothirds'    => __( '2/3 of column', 'fl-builder' ),
              'half'    => __( 'Half of column', 'fl-builder' ),
              'floatright'    => __( 'Limited width, float right', 'fl-builder' ),
						),
					),
				),
			),
		),
	),
));
