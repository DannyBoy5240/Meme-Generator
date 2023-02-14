<?php

/**
 * This is an example module with only the basic
 * setup necessary to get it working.
 *
 * @class FLTAIHTGrouptModule
 */
class FLTAIHTGroupModule extends FLBuilderModule {

    /** 
     * Constructor function for the module. You must pass the
     * name, description, dir and url in an array to the parent class.
     *
     * @method __construct
     */  
    public function __construct()
    {
        parent::__construct(array(
            'name'          => __('IHT Group', 'fl-builder'),
            'description'   => __('Image, Header, Text group module', 'fl-builder'),
            'category'		=> __('TA Modules', 'fl-builder'),
            'dir'           => TA_MODULES_DIR . 'iht-group/',
            'url'           => TA_MODULES_URL . 'iht-group/',
            'editor_export' => true, // Defaults to true and can be omitted.
            'enabled'       => true, // Defaults to true and can be omitted.
        ));
    }
    


/**
	 * @method update
	 * @param $settings {object}
	 */
	public function update( $settings ) {
		// Cache the photo data.
		$settings->photo_data = FLBuilderPhoto::get_attachment_data( $settings->photo );

		return $settings;
  }

  	/**
	 * @method delete
	 */
	public function delete() {
		// Delete photo module cache.
		if ( ! empty( $this->settings->photo_src ) ) {
			$module_class = get_class( FLBuilderModel::$modules['photo'] );
			$photo_module = new $module_class();
			$photo_module->settings = new stdClass();
			$photo_module->settings->photo_source = 'library';
			$photo_module->settings->photo_src = $this->settings->photo_src;
			$photo_module->delete();
		}
  }
  /**
	 * @method render_image
	 */
	public function render_image() {
		

    if ( empty( $this->settings->photo ) ) {
      return;
    }

    $photo_data = FLBuilderPhoto::get_attachment_data( $this->settings->photo );

    if ( ! $photo_data && isset( $this->settings->photo_data ) ) {
      $photo_data = $this->settings->photo_data;
    } elseif ( ! $photo_data ) {
      $photo_data = -1;
    }

    $photo_settings = array(
      'align'         => 'center',
      'crop'          => $this->settings->photo_crop,
      'link_target'   => $this->settings->link_target,
      'link_type'     => 'url',
      'link_url'      => $this->settings->link,
      'photo'         => $photo_data,
      'photo_src'     => $this->settings->photo_src,
      'photo_source'  => 'library',
    );
    
    FLBuilder::render_module_html( 'photo', $photo_settings );
   
  }
  
  
}

/**
 * Register the module and its form settings.
 */
FLBuilder::register_module('FLTAIHTGroupModule', array(
    'headers'       => array( // Tab
        'title'         => __('Headers', 'fl-builder'), // Tab title
        'sections'      => array( // Tab Sections
            'general'       => array( // Section
                'title'         => __('', 'fl-builder'), // Section Title
                'fields'        => array( // Section Fields
                    'header'         => array(
                      'type'          => 'form',
                      'label'         => __( 'Header line', 'fl-builder' ),
                      'form'          => 'header_form', // ID from registered form below
                      'preview_text'  => 'header', // Name of a field to use for the preview text
                      'multiple'      => true,
                    ),
                    'subhead'     => array(
                      'type'          => 'text',
                      'label'         => __('Subhead', 'fl-builder'),
                      'default'       => '',
                      'placeholder'   => '',
                      'class'         => 'iht-subhead',
                      'description'   => '',
                      'help'          => '',
                      'preview'         => array(
                          'type'             => 'text',
                          'selector'         => '.ta-iht-subhead'
                      )
                    )                  
                )
            )
        ) 
    ),
    'text'       => array( // Tab
        'title'         => __('Text', 'fl-builder'), // Tab title
        'sections'      => array( // Tab Sections
            'general'       => array( // Section
                'title'         => __('', 'fl-builder'), // Section Title
                'fields'        => array( // Section Fields
                    'text'   => array(
                      'type'          => 'editor',
                      'label'         => 'Body',
                      'media_buttons' => false,
                      'rows'          => 5
                    ),                   
                )
            )
        ) 
    ),
    'photo'       => array( // Tab
        'title'         => __('Photo', 'fl-builder'), // Tab title
        'sections'      => array( // Tab Sections
            'general'       => array( // Section
                'title'         => __('', 'fl-builder'), // Section Title
                'fields'        => array( // Section Fields
                    'photo'         => array(
                      'type'          => 'photo',
                      'show_remove'   => true,
                      'label'         => __( 'Photo', 'fl-builder' ),
                      'connections'   => array( 'photo' ),
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
            'text_color'        => array(
              'type'          => 'select',
              'label'         => __( 'Text Color', 'fl-builder' ),
              'default'       => 'pink',
              'options'       => array(
                'pink'    => __( 'Pink', 'fl-builder' ),
                'blue'      => __( 'Blue', 'fl-builder' ),
                'white'      => __( 'White', 'fl-builder' ),
              ),
            ),
            'style'        => array(
              'type'          => 'select',
              'label'         => __( 'Style', 'fl-builder' ),
              'default'       => 'image_left',
              'options'       => array(
                'image_left'    => __( 'Image left, header and text right', 'fl-builder' ),
                'image_right'      => __( 'Image right, header and text left', 'fl-builder' ),
                'image_above'      => __( 'Image above, header and text below', 'fl-builder' ),
                'header_above'      => __( 'Header above, text left, image right', 'fl-builder' ),
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
              'class'         => 'group-header',
              'description'   => 'Use one line or break header into multiple lines by using add another',
            ),
					),
				),
			),
		),
	),
));