<?php

/**
 * This is an example module with only the basic
 * setup necessary to get it working.
 *
 * @class FLTAGridItemtModule
 */
class FLTAGridItemModule extends FLBuilderModule {

    /** 
     * Constructor function for the module. You must pass the
     * name, description, dir and url in an array to the parent class.
     *
     * @method __construct
     */  
    public function __construct()
    {
        parent::__construct(array(
            'name'          => __('Grid item', 'fl-builder'),
            'description'   => __('Grid item module', 'fl-builder'),
            'category'		=> __('TA Modules', 'fl-builder'),
            'dir'           => TA_MODULES_DIR . 'grid-item/',
            'url'           => TA_MODULES_URL . 'grid-item/',
            'editor_export' => true, // Defaults to true and can be omitted.
            'enabled'       => true, // Defaults to true and can be omitted.
        ));
    }
    
}


/**
 * Register the module and its form settings.
 */
FLBuilder::register_module('FLTAGridItemModule', array(
    'general'       => array( // Tab
        'title'         => __('General', 'fl-builder'), // Tab title
        'sections'      => array( // Tab Sections
            'general'       => array( // Section
                'title'         => __('', 'fl-builder'), // Section Title
                'fields'        => array( // Section Fields
                    'item_header'         => array(
                      'type'          => 'form',
                      'label'         => __( 'Header line', 'fl-builder' ),
                      'description'   => 'Header is optional',
                      'form'          => 'header_form', // ID from registered form below
                      'preview_text'  => 'header', // Name of a field to use for the preview text
                      'multiple'      => true,
                    ),
                    'item_text'   => array(
                        'type'          => 'editor',
                        'label'         => 'Body',
                        'media_buttons' => false,
                        'rows'          => 5
                    ),
                    'item_button_text'     => array(
                      'type'          => 'text',
                      'label'         => __('Button Text', 'fl-builder'),
                      'default'       => '',
                      'placeholder'   => '',
                      'class'         => 'item-button-text',
                      'description'   => 'Button is optional',
                      'help'          => '',
                      'preview'         => array(
                          'type'             => 'text',
                          'selector'         => '.ta-button-text'
                      )
                    ),
                    'item_button_link'          => array(
                      'type'          => 'link',
                      'label'         => __( 'Link', 'fl-builder' ),
                      'placeholder'   => __( 'http://www.example.com', 'fl-builder' ),
                      'preview'       => array(
                        'type'          => 'none',
                      )
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
                    'item_style'        => array(
                      'type'          => 'select',
                      'label'         => __( 'Style', 'fl-builder' ),
                      'default'       => 'white',
                      'options'       => array(
                        'white'    => __( 'White', 'fl-builder' ),
                        'blue'      => __( 'Blue', 'fl-builder' ),
                        'pinkblue'      => __( 'Pink header blue button', 'fl-builder' ),
                      )
                    ),

                )
            )
        )
    )
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
              'class'         => 'item-header',
              'description'   => 'Use one line or break header into multiple lines by using add another',
            ),
					),
				),
			),
		),
	),
));