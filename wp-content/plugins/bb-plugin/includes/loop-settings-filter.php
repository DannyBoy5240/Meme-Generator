<?php

FLBuilder::register_settings_form('custom_fields_form', array(
	'title' => __( 'Add Field', 'fl-builder' ),
	'tabs'  => array(
		'customfield' => array(
			'title'    => __( 'Field', 'fl-builder' ),
			'sections' => array(
				'general' => array(
					'title'  => '',
					'fields' => array(
						'filter_meta_label'   => array(
							'type'  => 'text',
							'help'  => __( 'To identify the custom field.', 'fl-builder' ),
							'label' => __( 'Label', 'fl-builder' ),
						),
						'filter_meta_key'     => array(
							'type'  => 'text',
							'help'  => __( 'Custom field key.', 'fl-builder' ),
							'label' => __( 'Meta Key', 'fl-builder' ),
						),
						'filter_meta_value'   => array(
							'type'  => 'text',
							'help'  => __( 'Custom field value.', 'fl-builder' ),
							'label' => __( 'Meta Value', 'fl-builder' ),
						),
						'filter_meta_type'    => array(
							'type'    => 'select',
							'help'    => __( 'Custom field type.', 'fl-builder' ),
							'label'   => __( 'Type', 'fl-builder' ),
							'default' => 'CHAR',
							'options' => array(
								'NUMERIC'  => __( 'Numeric', 'fl-builder' ),
								'BINARY'   => __( 'Binary', 'fl-builder' ),
								'CHAR'     => __( 'Text', 'fl-builder' ),
								'DATE'     => __( 'Date', 'fl-builder' ),
								'DATETIME' => __( 'Date Time', 'fl-builder' ),
								'DECIMAL'  => __( 'Decimal', 'fl-builder' ),
								'SIGNED'   => __( 'Signed', 'fl-builder' ),
								'TIME'     => __( 'Time', 'fl-builder' ),
								'UNSIGNED' => __( 'Unsigned', 'fl-builder' ),
							),
						),
						'filter_meta_compare' => array(
							'type'    => 'select',
							'help'    => __( 'Operator to test.', 'fl-builder' ),
							'label'   => __( 'Compare', 'fl-builder' ),
							'default' => '=',
							'options' => array(
								'='          => __( 'Equals', 'fl-builder' ),
								'!='         => __( 'Does not equal', 'fl-builder' ),
								'>'          => __( 'Greater than', 'fl-builder' ),
								'<'          => __( 'Less than', 'fl-builder' ),
								'>='         => __( 'Greater than or equal to', 'fl-builder' ),
								'<='         => __( 'Less than or equal to', 'fl-builder' ),
								'EXISTS'     => __( 'Exists', 'fl-builder' ),
								'NOT EXISTS' => __( 'Not Exists', 'fl-builder' ),
							),
							'toggle'  => array(
								'='  => array(
									'fields' => array( 'filter_meta_value' ),
								),
								'!=' => array(
									'fields' => array( 'filter_meta_value' ),
								),
								'>'  => array(
									'fields' => array( 'filter_meta_value' ),
								),
								'<'  => array(
									'fields' => array( 'filter_meta_value' ),
								),
								'>=' => array(
									'fields' => array( 'filter_meta_value' ),
								),
								'<=' => array(
									'fields' => array( 'filter_meta_value' ),
								),
							),
						),
					),
				),
			),
		),
	),
));
