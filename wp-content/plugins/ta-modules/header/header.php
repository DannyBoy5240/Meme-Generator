<?php

/**
 * This is an example module with only the basic
 * setup necessary to get it working.
 *
 * @class FLTAHeaderModule
 */
class FLTAHeaderModule extends FLBuilderModule {

    /** 
     * Constructor function for the module. You must pass the
     * name, description, dir and url in an array to the parent class.
     *
     * @method __construct
     */  
    public function __construct()
    {
        parent::__construct(array(
            'name'          => __('Header', 'fl-builder'),
            'description'   => __('Header module', 'fl-builder'),
            'category'		=> __('TA Modules', 'fl-builder'),
            'dir'           => TA_MODULES_DIR . 'header/',
            'url'           => TA_MODULES_URL . 'header/',
            'editor_export' => true, // Defaults to true and can be omitted.
            'enabled'       => true, // Defaults to true and can be omitted.
        ));
    }
    
}



/**
 * Register the module and its form settings.
 */
FLBuilder::register_module('FLTAHeaderModule', array(
	'items'         => array(
		'title'         => __( 'Header', 'fl-builder' ),
		'sections'      => array(
			'multi'       => array(
				'title'         => 'Multi-line header',
				'fields'        => array(
					'item_header'         => array(
            'type'          => 'form',
            'label'         => __( 'Header line', 'fl-builder' ),
            'form'          => 'header_form', // ID from registered form below
            'preview_text'  => 'header', // Name of a field to use for the preview text
            'multiple'      => true,
          ),
				),
      ),
      'single'       => array(
				'title'         => 'Single line header',
				'fields'        => array(
          'item_header_single'         => array(
            'type'          => 'text',
            'label'         => __( 'Header', 'fl-builder' ),
            'preview_text'  => 'header_single', // Name of a field to use for the preview text
            'connections'     => array( 'string' ),
          ),
				),
			),
    ),
  ),
  'link'        => array(
		'title'         => __( 'Link', 'fl-builder' ),
		'sections'      => array(
      'link'          => array(
        'title'         => __( 'Link', 'fl-builder' ),
        'fields'        => array(
          'link'          => array(
            'type'          => 'link',
            'label'         => __( 'Link', 'fl-builder' ),
            'preview'         => array(
              'type'            => 'none',
            ),
            'connections'     => array( 'url' ),
          ),
          'link_target'   => array(
            'type'          => 'select',
            'label'         => __( 'Link Target', 'fl-builder' ),
            'default'       => '_self',
            'options'       => array(
              '_self'         => __( 'Same Window', 'fl-builder' ),
              '_blank'        => __( 'New Window', 'fl-builder' ),
            ),
            'preview'         => array(
              'type'            => 'none',
            ),
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
						'default'       => 'pink',
						'options'       => array(
							'pink'    => __( 'Pink', 'fl-builder' ),
              'blue'      => __( 'Blue', 'fl-builder' ),
              'white'      => __( 'White', 'fl-builder' ),
              'gray'      => __( 'Gray', 'fl-builder' ),
						),
          ),
          'text_size'        => array(
						'type'          => 'select',
						'label'         => __( 'Text Size', 'fl-builder' ),
						'default'       => 'large',
						'options'       => array(
              'xx-large'    => __( 'XX-Large', 'fl-builder' ),
              'x-large'    => __( 'X-Large', 'fl-builder' ),
              'large'    => __( 'Large', 'fl-builder' ),
              'medium-alt'    => __( 'Medium-Large', 'fl-builder' ),
              'medium'    => __( 'Medium', 'fl-builder' ),
              'small'    => __( 'Small', 'fl-builder' ),
              'x-small'    => __( 'X-Small', 'fl-builder' ),
						),
          ),
          'text_style'        => array(
						'type'          => 'select',
						'label'         => __( 'Text Style', 'fl-builder' ),
						'default'       => 'uppercase',
						'options'       => array(
              'regular'    => __( 'Regular', 'fl-builder' ),
							'uppercase'    => __( 'Uppercase', 'fl-builder' ),
						),
          ),
          'text_border'        => array(
						'type'          => 'select',
						'label'         => __( 'Underline', 'fl-builder' ),
						'default'       => 'no',
						'options'       => array(
              'no'    => __( 'No', 'fl-builder' ),
							'yes'    => __( 'Yes', 'fl-builder' ),
						),
          ),
          'text_align'        => array(
						'type'          => 'select',
						'label'         => __( 'Text Alignment', 'fl-builder' ),
						'default'       => 'left',
						'options'       => array(
              'left'    => __( 'Left', 'fl-builder' ),
              'center'    => __( 'Center', 'fl-builder' ),
						),
          ),
          'text_italic'        => array(
						'type'          => 'select',
						'label'         => __( 'Italics text' ),
						'default'       => 'italic',
						'options'       => array(
              'italic'    => __( 'Italics', 'fl-builder' ),
              'regular'    => __( 'Regular', 'fl-builder' ),
						),
          ),
          'text_weight'        => array(
						'type'          => 'select',
						'label'         => __( 'Font Weight', 'fl-builder' ),
						'default'       => 'medium',
						'options'       => array(
              'medium'    => __( 'Medium - 500', 'fl-builder' ),
              'regular'    => __( 'Regular - 400', 'fl-builder' ),
						),
          ),
          'text_width'        => array(
						'type'          => 'select',
						'label'         => __( 'Width - only use when using one line', 'fl-builder' ),
						'default'       => 'full',
						'options'       => array(
              'full'    => __( 'Full width of column', 'fl-builder' ),
              'twothirds'    => __( '2/3 of column', 'fl-builder' ),
              'half'    => __( 'Half of column', 'fl-builder' ),
						),
          ),
          'text_bkg'        => array(
						'type'          => 'select',
						'label'         => __( 'Background color' ),
						'default'       => 'none',
						'options'       => array(
              'none'    => __( 'None', 'fl-builder' ),
              'pink'    => __( 'Pink', 'fl-builder' ),
              'blue'    => __( 'Blue', 'fl-builder' ),
              'lightblue'    => __( 'Light Blue', 'fl-builder' ),
						),
          ),
          'text_header'        => array(
						'type'          => 'select',
						'label'         => __( 'Header Type', 'fl-builder' ),
						'default'       => 'none',
						'options'       => array(
							'div'    => __( 'None', 'fl-builder' ),
              'h1'      => __( 'H1', 'fl-builder' ),
              'h2'      => __( 'H2', 'fl-builder' ),
              'h3'      => __( 'H3', 'fl-builder' ),
              'h4'      => __( 'H4', 'fl-builder' ),
						),
          ),
				),
			),
		),
	),
));

/**
 * Register a settings form to use in the "form" field type above.
 */
FLBuilder::register_settings_form('header_form', array(
	'title' => __( 'Add new line', 'fl-builder' ),
	'tabs'  => array(
		'general'      => array(
			'title'         => __( 'General', 'fl-builder' ),
			'sections'      => array(
				'general'       => array(
					'title'         => '',
					'fields'        => array(
						'header'         => array(
							'type'          => 'text',
              'label'         => __('Heading', 'fl-builder'),
              'default'         => '',
              'class'         => 'item-header',
              'description'   => 'Use one line or break header into multiple lines by using add another',
            ),
					),
				),
			),
		),
	),
));
