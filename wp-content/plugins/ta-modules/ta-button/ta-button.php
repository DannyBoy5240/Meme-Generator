<?php

/**
 * @class FLTAButtonModule
 */
class FLTAButtonModule extends FLBuilderModule {

	/**
	 * @method __construct
	 */
	public function __construct() {
		parent::__construct(array(
			'name'          	=> __( 'TA Button', 'fl-builder' ),
			'description'   	=> __( 'TA Custom Button', 'fl-builder' ),
			'category'      	=> __( 'TA Modules', 'fl-builder' ),
			'partial_refresh'	=> true,
			'icon'				=> 'button.svg',
		));
	}

}

/**
 * Register the module and its form settings.
 */
FLBuilder::register_module('FLTAButtonModule', array(
	'general'       => array(
		'title'         => __( 'General', 'fl-builder' ),
		'sections'      => array(
			'general'       => array(
				'title'         => '',
				'fields'        => array(
					'text'          => array(
						'type'          => 'text',
						'label'         => __( 'Text', 'fl-builder' ),
						'default'       => __( 'Click Here', 'fl-builder' ),
						'preview'         => array(
							'type'            => 'text',
							'selector'        => '.ta-button-text',
						),
						'connections'         => array( 'string' ),
					),
          'color'   => array(
            'type'          => 'select',
            'label'         => __('Button Color', 'fl-builder'),
            'default'       => 'pink',
            'options'       => array(
                'pink'        => __('Solid pink white text', 'fl-builder'),
                'blue'        => __('Solid blue white text', 'fl-builder'),
                'pink_border'        => __('Pink border blue text', 'fl-builder'),
                'blue_border'        => __('Blue border pink text', 'fl-builder'),
            ),
            'preview'       => array(
                'type'          => 'none'
            ),
          ),
          'align'        => array(
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
			'link'          => array(
				'title'         => __( 'Link', 'fl-builder' ),
				'fields'        => array(
					'link'          => array(
						'type'          => 'link',
						'label'         => __( 'Link', 'fl-builder' ),
						'placeholder'   => __( 'http://www.example.com', 'fl-builder' ),
						'preview'       => array(
							'type'          => 'none',
						),
						'connections'         => array( 'url' ),
					),
				),
			),

		),
	),
));
