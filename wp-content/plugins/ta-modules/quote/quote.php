<?php

/**
 * This is an example module with only the basic
 * setup necessary to get it working.
 *
 * @class FLTAQuotetModule
 */
class FLTAQuoteModule extends FLBuilderModule {

    /** 
     * Constructor function for the module. You must pass the
     * name, description, dir and url in an array to the parent class.
     *
     * @method __construct
     */  
    public function __construct()
    {
        parent::__construct(array(
            'name'          => __('Quote', 'fl-builder'),
            'description'   => __('Quote module', 'fl-builder'),
            'category'		=> __('TA Modules', 'fl-builder'),
            'dir'           => TA_MODULES_DIR . 'quote/',
            'url'           => TA_MODULES_URL . 'quote/',
            'editor_export' => true, // Defaults to true and can be omitted.
            'enabled'       => true, // Defaults to true and can be omitted.
        ));
    }
    
}


/**
 * Register the module and its form settings.
 */
FLBuilder::register_module('FLTAQuoteModule', array(
    'general'       => array( // Tab
        'title'         => __('General', 'fl-builder'), // Tab title
        'sections'      => array( // Tab Sections
            'general'       => array( // Section
                'title'         => __('', 'fl-builder'), // Section Title
                'fields'        => array( // Section Fields
                    'quote_text'   => array(
                        'type'          => 'editor',
                        'label'         => 'Body',
                        'media_buttons' => false,
                        'rows'          => 5
                    ),
                    'quote_name'     => array(
                      'type'          => 'text',
                      'label'         => __('Name', 'fl-builder'),
                      'default'       => '',
                      'placeholder'   => '',
                      'class'         => 'quote-name',
                      'description'   => '',
                      'help'          => '',
                      'preview'         => array(
                          'type'             => 'text',
                          'selector'         => '.fl-quote-name'
                      )
                    ),
                    'quote_org'     => array(
                      'type'          => 'text',
                      'label'         => __('Organization', 'fl-builder'),
                      'default'       => '',
                      'placeholder'   => '',
                      'class'         => 'quote-org',
                      'description'   => '',
                      'help'          => '',
                      'preview'         => array(
                          'type'             => 'text',
                          'selector'         => '.fl-quote-org'
                      )
                    ),
                                     
                )
            )
        )
    ),
    'style'        => array(
      'title'         => __( 'Style', 'fl-builder' ),
      'sections'      => array(
        'general'       => array(
          'title'         => '',
          'fields'        => array(
            'quote_color'        => array(
              'type'          => 'select',
              'label'         => __( 'Text Color', 'fl-builder' ),
              'default'       => 'pink',
              'options'       => array(
                'pink'    => __( 'Pink', 'fl-builder' ),
                'blue'      => __( 'Blue', 'fl-builder' ),
                'white'      => __( 'White', 'fl-builder' ),
              ),
            ),
            'quote_style'        => array(
              'type'          => 'select',
              'label'         => __( 'Font Style', 'fl-builder' ),
              'default'       => 'regular',
              'options'       => array(
                'regular'    => __( 'Regular', 'fl-builder' ),
                'uppercase'      => __( 'Uppercase', 'fl-builder' ),
              )
            ), 
            'quote_size'        => array(
              'type'          => 'select',
              'label'         => __( 'Font Style', 'fl-builder' ),
              'default'       => 'large',
              'options'       => array(
                'large'    => __( 'Large', 'fl-builder' ),
                'medium'      => __( 'Medium', 'fl-builder' ),
                'small'      => __( 'Small', 'fl-builder' ),
              )
            ), 
            'quote_align'        => array(
              'type'          => 'select',
              'label'         => __( 'Text Alignment', 'fl-builder' ),
              'default'       => 'left',
              'options'       => array(
                'left'    => __( 'Left', 'fl-builder' ),
                'center'    => __( 'Center', 'fl-builder' ),
              ),
            ),
          ),
        ),
      ),
    ),
));
