<?php

/**
 * Advanced Custom Field String
 */
FLPageData::add_archive_property( 'acf', array(
	'label'  => __( 'ACF Archive Field', 'bb-theme-builder' ),
	'group'  => 'acf',
	'type'   => array( 'string', 'custom_field' ),
	'getter' => 'FLPageDataACF::string_field',
) );

FLPageData::add_post_property( 'acf', array(
	'label'  => __( 'ACF Post Field', 'bb-theme-builder' ),
	'group'  => 'acf',
	'type'   => array( 'string', 'custom_field' ),
	'getter' => 'FLPageDataACF::string_field',
) );

FLPageData::add_post_property( 'acf_author', array(
	'label'  => __( 'ACF Post Author Field', 'bb-theme-builder' ),
	'group'  => 'acf',
	'type'   => array( 'string', 'custom_field' ),
	'getter' => 'FLPageDataACF::string_field',
) );

FLPageData::add_site_property( 'acf_user', array(
	'label'  => __( 'ACF User Field', 'bb-theme-builder' ),
	'group'  => 'acf',
	'type'   => array( 'string', 'custom_field' ),
	'getter' => 'FLPageDataACF::string_field',
) );

FLPageData::add_site_property( 'acf_option', array(
	'label'  => __( 'ACF Option Field', 'bb-theme-builder' ),
	'group'  => 'acf',
	'type'   => array( 'string', 'custom_field' ),
	'getter' => 'FLPageDataACF::string_field',
) );

$form = array(
	'type'               => array(
		'type'    => 'select',
		'label'   => __( 'Field Type', 'bb-theme-builder' ),
		'default' => 'text',
		'options' => array(
			'text'             => __( 'Text', 'bb-theme-builder' ),
			'textarea'         => __( 'Textarea', 'bb-theme-builder' ),
			'number'           => __( 'Number', 'bb-theme-builder' ),
			'email'            => __( 'Email', 'bb-theme-builder' ),
			'url'              => __( 'URL', 'bb-theme-builder' ),
			'password'         => __( 'Password', 'bb-theme-builder' ),
			'wysiwyg'          => __( 'WYSIWYG', 'bb-theme-builder' ),
			'oembed'           => __( 'oEmbed', 'bb-theme-builder' ),
			'image'            => __( 'Image', 'bb-theme-builder' ),
			'file'             => __( 'File', 'bb-theme-builder' ),
			'select'           => __( 'Select', 'bb-theme-builder' ),
			'checkbox'         => __( 'Checkbox', 'bb-theme-builder' ),
			'radio'            => __( 'Radio', 'bb-theme-builder' ),
			'button_group'     => __( 'Button Group', 'bb-theme-builder' ),
			'link'             => __( 'Link', 'bb-theme-builder' ),
			'page_link'        => __( 'Page Link', 'bb-theme-builder' ),
			'google_map'       => __( 'Google Map', 'bb-theme-builder' ),
			'color_picker'     => __( 'Color Picker', 'bb-theme-builder' ),
			'date_picker'      => __( 'Date Picker', 'bb-theme-builder' ),
			'date_time_picker' => __( 'Date Time Picker', 'bb-theme-builder' ),
			'time_picker'      => __( 'Time Picker', 'bb-theme-builder' ),
			'true_false'       => __( 'True/False', 'bb-theme-builder' ),
		),
		'toggle'  => array(
			'image'            => array(
				'fields' => array( 'image_size', 'display' ),
			),
			'file'             => array(
				'fields' => array( 'file_display' ),
			),
			'checkbox'         => array(
				'fields' => array( 'checkbox_format' ),
			),
			'select'           => array(
				'fields' => array( 'select_format' ),
			),
			'color_picker'     => array(
				'fields' => array( 'prefix' ),
			),
			'date_picker'      => array(
				'fields' => array( 'format' ),
			),
			'date_time_picker' => array(
				'fields' => array( 'format' ),
			),
			'time_picker'      => array(
				'fields' => array( 'format' ),
			),
		),
	),
	'name'               => array(
		'type'  => 'text',
		'label' => __( 'Field Name', 'bb-theme-builder' ),
	),
	'format'             => array(
		'type'  => 'text',
		'label' => __( 'Format', 'bb-theme-builder' ),
		'help'  => __( 'Use standard WordPress Date and Time Formatting characters.', 'bb-theme-builder' ),
	),
	'image_size'         => array(
		'type'    => 'photo-sizes',
		'label'   => __( 'Image Size', 'bb-theme-builder' ),
		'default' => 'thumbnail',
	),
	'display'            => array(
		'type'    => 'select',
		'label'   => __( 'Display', 'bb-theme-builder' ),
		'default' => 'url',
		'options' => array(
			'url'         => __( 'URL', 'bb-theme-builder' ),
			'tag'         => __( 'Image Tag', 'bb-theme-builder' ),
			'title'       => __( 'Title', 'bb-theme-builder' ),
			'caption'     => __( 'Caption', 'bb-theme-builder' ),
			'description' => __( 'Description', 'bb-theme-builder' ),
			'alt'         => __( 'Alt Text', 'bb-theme-builder' ),
		),
		'toggle'  => array(
			'tag' => array(
				'fields' => array( 'linked', 'image_size' ),
			),
			'url' => array(
				'fields' => array( 'image_size' ),
			),
		),
	),
	'file_display'       => array(
		'type'    => 'select',
		'label'   => __( 'Display', 'bb-theme-builder' ),
		'default' => 'url',
		'options' => array(
			'url'      => __( 'URL', 'bb-theme-builder' ),
			'name'     => __( 'Name', 'bb-theme-builder' ),
			'basename' => __( 'Base Name', 'bb-theme-builder' ),
			'ext'      => __( 'Extension', 'bb-theme-builder' ),
		),
	),
	'linked'             => array(
		'type'    => 'select',
		'label'   => __( 'Linked', 'bb-theme-builder' ),
		'default' => 'yes',
		'options' => array(
			'yes' => __( 'Yes', 'bb-theme-builder' ),
			'no'  => __( 'No', 'bb-theme-builder' ),
		),
		'help'    => __( 'Link the image to the post.', 'bb-theme-builder' ),
	),
	'checkbox_format'    => array(
		'type'    => 'select',
		'label'   => __( 'Format', 'bb-theme-builder' ),
		'default' => 'text',
		'options' => array(
			'text' => __( 'Text Separator', 'bb-theme-builder' ),
			'ol'   => __( 'Ordered List', 'bb-theme-builder' ),
			'ul'   => __( 'Unordered List', 'bb-theme-builder' ),
		),
	),
	'checkbox_separator' => array(
		'type'    => 'text',
		'label'   => __( 'Checkbox Separator', 'bb-theme-builder' ),
		'default' => ', ',
	),
	'select_format'      => array(
		'type'    => 'select',
		'label'   => __( 'Format', 'bb-theme-builder' ),
		'default' => 'text',
		'options' => array(
			'text' => __( 'Text', 'bb-theme-builder' ),
			'ol'   => __( 'Ordered List', 'bb-theme-builder' ),
			'ul'   => __( 'Unordered List', 'bb-theme-builder' ),
		),
	),
	'prefix'             => array(
		'type'    => 'select',
		'label'   => __( 'Add Hex Color Prefix', 'bb-theme-builder' ),
		'default' => '0',
		'options' => array(
			'0' => __( 'No', 'bb-theme-builder' ),
			'1' => __( 'Yes', 'bb-theme-builder' ),
		),
	),
);

if ( class_exists( 'SmartSlider3' ) ) {
	$form['type']['options']['acf_smartslider3'] = __( 'Smart Slider 3', 'bb-theme-builder' );
}

$name_custom = FLPageDataACF::get_custom_fields_select( FLBuilderModel::get_post_id() );
if ( ! empty( $name_custom ) ) {
	$form['name_custom'] = $name_custom;
}

FLPageData::add_archive_property_settings_fields( 'acf', $form );
FLPageData::add_post_property_settings_fields( 'acf', $form );
FLPageData::add_post_property_settings_fields( 'acf_author', $form );
FLPageData::add_site_property_settings_fields( 'acf_user', $form );
FLPageData::add_site_property_settings_fields( 'acf_option', $form );

/**
 * Advanced Custom Field URL
 */
FLPageData::add_archive_property( 'acf_url', array(
	'label'  => __( 'ACF Archive Field - URL', 'bb-theme-builder' ),
	'group'  => 'acf',
	'type'   => 'url',
	'getter' => 'FLPageDataACF::url_field',
) );

FLPageData::add_post_property( 'acf_url', array(
	'label'  => __( 'ACF Post Field - URL', 'bb-theme-builder' ),
	'group'  => 'acf',
	'type'   => 'url',
	'getter' => 'FLPageDataACF::url_field',
) );

FLPageData::add_post_property( 'acf_author_url', array(
	'label'  => __( 'ACF Post Author Field - URL', 'bb-theme-builder' ),
	'group'  => 'acf',
	'type'   => 'url',
	'getter' => 'FLPageDataACF::url_field',
) );

FLPageData::add_site_property( 'acf_user_url', array(
	'label'  => __( 'ACF User Field - URL', 'bb-theme-builder' ),
	'group'  => 'acf',
	'type'   => 'url',
	'getter' => 'FLPageDataACF::url_field',
) );

FLPageData::add_site_property( 'acf_option_url', array(
	'label'  => __( 'ACF Option Field - URL', 'bb-theme-builder' ),
	'group'  => 'acf',
	'type'   => 'url',
	'getter' => 'FLPageDataACF::url_field',
) );

$form = array(
	'type'       => array(
		'type'    => 'select',
		'label'   => __( 'Field Type', 'bb-theme-builder' ),
		'default' => 'text',
		'options' => array(
			'text'      => __( 'Text', 'bb-theme-builder' ),
			'url'       => __( 'URL', 'bb-theme-builder' ),
			'image'     => __( 'Image', 'bb-theme-builder' ),
			'file'      => __( 'File', 'bb-theme-builder' ),
			'select'    => __( 'Select', 'bb-theme-builder' ),
			'radio'     => __( 'Radio', 'bb-theme-builder' ),
			'link'      => __( 'Link', 'bb-theme-builder' ),
			'page_link' => __( 'Page Link', 'bb-theme-builder' ),
		),
		'toggle'  => array(
			'image' => array(
				'fields' => array( 'image_size' ),
			),
		),
	),
	'name'       => array(
		'type'  => 'text',
		'label' => __( 'Field Name', 'bb-theme-builder' ),
	),
	'image_size' => array(
		'type'    => 'photo-sizes',
		'label'   => __( 'Image Size', 'bb-theme-builder' ),
		'default' => 'thumbnail',
	),
);

if ( ! empty( $name_custom ) ) {
	$form['name_custom'] = $name_custom;
}

FLPageData::add_archive_property_settings_fields( 'acf_url', $form );
FLPageData::add_post_property_settings_fields( 'acf_url', $form );
FLPageData::add_post_property_settings_fields( 'acf_author_url', $form );
FLPageData::add_site_property_settings_fields( 'acf_user_url', $form );
FLPageData::add_site_property_settings_fields( 'acf_option_url', $form );

/**
 * Advanced Custom Field Photo
 */
FLPageData::add_archive_property( 'acf_photo', array(
	'label'  => __( 'ACF Archive Field - Photo', 'bb-theme-builder' ),
	'group'  => 'acf',
	'type'   => 'photo',
	'getter' => 'FLPageDataACF::photo_field',
) );

FLPageData::add_post_property( 'acf_photo', array(
	'label'  => __( 'ACF Post Field - Photo', 'bb-theme-builder' ),
	'group'  => 'acf',
	'type'   => 'photo',
	'getter' => 'FLPageDataACF::photo_field',
) );

FLPageData::add_post_property( 'acf_author_photo', array(
	'label'  => __( 'ACF Post Author Field - Photo', 'bb-theme-builder' ),
	'group'  => 'acf',
	'type'   => 'photo',
	'getter' => 'FLPageDataACF::photo_field',
) );

FLPageData::add_site_property( 'acf_user_photo', array(
	'label'  => __( 'ACF User Field - Photo', 'bb-theme-builder' ),
	'group'  => 'acf',
	'type'   => 'photo',
	'getter' => 'FLPageDataACF::photo_field',
) );

FLPageData::add_site_property( 'acf_option_photo', array(
	'label'  => __( 'ACF Option Field - Photo', 'bb-theme-builder' ),
	'group'  => 'acf',
	'type'   => 'photo',
	'getter' => 'FLPageDataACF::photo_field',
) );

$form = array(
	'type'           => array(
		'type'    => 'select',
		'label'   => __( 'Field Type', 'bb-theme-builder' ),
		'default' => 'text',
		'options' => array(
			'text'   => __( 'Text', 'bb-theme-builder' ),
			'url'    => __( 'URL', 'bb-theme-builder' ),
			'image'  => __( 'Image', 'bb-theme-builder' ),
			'select' => __( 'Select', 'bb-theme-builder' ),
			'radio'  => __( 'Radio', 'bb-theme-builder' ),
		),
		'toggle'  => array(
			'image' => array(
				'fields' => array( 'image_size', 'image_fallback' ),
			),
		),
	),
	'name'           => array(
		'type'  => 'text',
		'label' => __( 'Field Name', 'bb-theme-builder' ),
	),
	'image_fallback' => array(
		'type'        => 'photo',
		'label'       => __( 'Fallback Image', 'bb-theme-builder' ),
		'show_remove' => true,
	),
	'image_size'     => array(
		'type'    => 'photo-sizes',
		'label'   => __( 'Image Size', 'bb-theme-builder' ),
		'default' => 'thumbnail',
	),
);

if ( ! empty( $name_custom ) ) {
	$form['name_custom'] = $name_custom;
}

FLPageData::add_archive_property_settings_fields( 'acf_photo', $form );
FLPageData::add_post_property_settings_fields( 'acf_photo', $form );
FLPageData::add_post_property_settings_fields( 'acf_author_photo', $form );
FLPageData::add_site_property_settings_fields( 'acf_user_photo', $form );
FLPageData::add_site_property_settings_fields( 'acf_option_photo', $form );

/**
 * Advanced Custom Field Multiple Photos
 */
FLPageData::add_archive_property( 'acf_gallery', array(
	'label'  => __( 'ACF Archive Field - Gallery', 'bb-theme-builder' ),
	'group'  => 'acf',
	'type'   => 'multiple-photos',
	'getter' => 'FLPageDataACF::multiple_photos_field',
) );

FLPageData::add_post_property( 'acf_gallery', array(
	'label'  => __( 'ACF Post Field - Gallery', 'bb-theme-builder' ),
	'group'  => 'acf',
	'type'   => 'multiple-photos',
	'getter' => 'FLPageDataACF::multiple_photos_field',
) );

FLPageData::add_post_property( 'acf_author_gallery', array(
	'label'  => __( 'ACF Post Author Field - Gallery', 'bb-theme-builder' ),
	'group'  => 'acf',
	'type'   => 'multiple-photos',
	'getter' => 'FLPageDataACF::multiple_photos_field',
) );

FLPageData::add_site_property( 'acf_user_gallery', array(
	'label'  => __( 'ACF User Field - Gallery', 'bb-theme-builder' ),
	'group'  => 'acf',
	'type'   => 'multiple-photos',
	'getter' => 'FLPageDataACF::multiple_photos_field',
) );

FLPageData::add_site_property( 'acf_option_gallery', array(
	'label'  => __( 'ACF Option Field - Gallery', 'bb-theme-builder' ),
	'group'  => 'acf',
	'type'   => 'multiple-photos',
	'getter' => 'FLPageDataACF::multiple_photos_field',
) );

$form = array(
	'name' => array(
		'type'  => 'text',
		'label' => __( 'Gallery Field Name', 'bb-theme-builder' ),
	),
);

if ( ! empty( $name_custom ) ) {
	$form['name_custom'] = $name_custom;
}

FLPageData::add_archive_property_settings_fields( 'acf_gallery', $form );
FLPageData::add_post_property_settings_fields( 'acf_gallery', $form );
FLPageData::add_post_property_settings_fields( 'acf_author_gallery', $form );
FLPageData::add_site_property_settings_fields( 'acf_user_gallery', $form );
FLPageData::add_site_property_settings_fields( 'acf_option_gallery', $form );

/**
 * Advanced Custom Field Color
 */
FLPageData::add_archive_property( 'acf_color', array(
	'label'  => __( 'ACF Archive Field - Color', 'bb-theme-builder' ),
	'group'  => 'acf',
	'type'   => 'color',
	'getter' => 'FLPageDataACF::color_field',
) );

FLPageData::add_post_property( 'acf_color', array(
	'label'  => __( 'ACF Post Field - Color', 'bb-theme-builder' ),
	'group'  => 'acf',
	'type'   => 'color',
	'getter' => 'FLPageDataACF::color_field',
) );

FLPageData::add_post_property( 'acf_author_color', array(
	'label'  => __( 'ACF Post Author Field - Color', 'bb-theme-builder' ),
	'group'  => 'acf',
	'type'   => 'color',
	'getter' => 'FLPageDataACF::color_field',
) );

FLPageData::add_site_property( 'acf_user_color', array(
	'label'  => __( 'ACF User Field - Color', 'bb-theme-builder' ),
	'group'  => 'acf',
	'type'   => 'color',
	'getter' => 'FLPageDataACF::color_field',
) );

FLPageData::add_site_property( 'acf_option_color', array(
	'label'  => __( 'ACF Option Field - Color', 'bb-theme-builder' ),
	'group'  => 'acf',
	'type'   => 'color',
	'getter' => 'FLPageDataACF::color_field',
) );

$form = array(
	'name'   => array(
		'type'  => 'text',
		'label' => __( 'Field Name', 'bb-theme-builder' ),
	),
	'prefix' => array(
		'type'    => 'select',
		'label'   => __( 'Add Hex Color Prefix', 'bb-theme-builder' ),
		'default' => '0',
		'options' => array(
			'0' => __( 'No', 'bb-theme-builder' ),
			'1' => __( 'Yes', 'bb-theme-builder' ),
		),
	),
);

if ( ! empty( $name_custom ) ) {
	$form['name_custom'] = $name_custom;
}

FLPageData::add_archive_property_settings_fields( 'acf_color', $form );
FLPageData::add_post_property_settings_fields( 'acf_color', $form );
FLPageData::add_post_property_settings_fields( 'acf_author_color', $form );
FLPageData::add_site_property_settings_fields( 'acf_user_color', $form );
FLPageData::add_site_property_settings_fields( 'acf_option_color', $form );

/**
 * Advanced Custom Field Relational
 */
FLPageData::add_post_property( 'acf_relational', array(
	'label'  => __( 'ACF Relational', 'bb-theme-builder' ),
	'group'  => 'acf',
	'type'   => array( 'string', 'custom_field' ),
	'getter' => 'FLPageDataACF::relational_field',
) );

$form        = array(
	'type'              => array(
		'type'    => 'select',
		'label'   => __( 'Field Type', 'bb-theme-builder' ),
		'default' => 'user',
		'options' => array(
			'user'         => __( 'User', 'bb-theme-builder' ),
			'post_object'  => __( 'Post Object', 'bb-theme-builder' ),
			'page_link'    => __( 'Page Link', 'bb-theme-builder' ),
			'relationship' => __( 'Relationship', 'bb-theme-builder' ),
			'taxonomy'     => __( 'Taxonomy', 'bb-theme-builder' ),
		),
		'toggle'  => array(
			'user'        => array(
				'fields' => array( 'display_type', 'link', 'link_type' ),
			),
			'post_object' => array(
				'fields' => array( 'list_type', 'post_title_link' ),
			),
			'taxonomy'    => array(
				'fields' => array( 'list_type', 'term_archive_link', 'term_post_count', 'hide_empty' ),
			),
		),
	),
	'name'              => array(
		'type'  => 'text',
		'label' => __( 'Field Name', 'bb-theme-builder' ),
	),
	'display_type'      => array(
		'type'    => 'select',
		'label'   => __( 'Display Type', 'bb-theme-builder' ),
		'default' => 'display',
		'options' => array(
			'display'   => __( 'Display Name', 'bb-theme-builder' ),
			'first'     => __( 'First Name', 'bb-theme-builder' ),
			'last'      => __( 'Last Name', 'bb-theme-builder' ),
			'firstlast' => __( 'First &amp; Last Name', 'bb-theme-builder' ),
			'lastfirst' => __( 'Last, First Name', 'bb-theme-builder' ),
			'nickname'  => __( 'Nickname', 'bb-theme-builder' ),
			'username'  => __( 'Username', 'bb-theme-builder' ),
		),
	),
	'link'              => array(
		'type'    => 'select',
		'label'   => __( 'Link', 'bb-theme-builder' ),
		'default' => 'no',
		'options' => array(
			'yes' => __( 'Yes', 'bb-theme-builder' ),
			'no'  => __( 'No', 'bb-theme-builder' ),
		),
		'toggle'  => array(
			'yes' => array(
				'fields' => array( 'link_type' ),
			),
		),
		'help'    => __( 'Link to the archive or website for this author.', 'bb-theme-builder' ),
	),
	'link_type'         => array(
		'type'    => 'select',
		'label'   => __( 'Link Type', 'bb-theme-builder' ),
		'default' => 'archive',
		'options' => array(
			'archive' => __( 'Post Archive', 'bb-theme-builder' ),
			'website' => __( 'Website', 'bb-theme-builder' ),
		),
	),
	'list_type'         => array(
		'type'    => 'select',
		'label'   => __( 'List Type', 'bb-theme-builder' ),
		'default' => 'ul',
		'options' => array(
			'ul'  => __( 'Unordered List', 'bb-theme-builder' ),
			'ol'  => __( 'Ordered List', 'bb-theme-builder' ),
			'div' => __( 'Regular (No bullets/numbering.)', 'bb-theme-builder' ),
		),
	),
	'post_title_link'   => array(
		'type'    => 'select',
		'label'   => __( 'Add Post Title Link', 'bb-theme-builder' ),
		'default' => 'yes',
		'options' => array(
			'yes' => __( 'Yes', 'bb-theme-builder' ),
			'no'  => __( 'No', 'bb-theme-builder' ),
		),
	),
	'term_archive_link' => array(
		'type'    => 'select',
		'label'   => __( 'Add Term Archive Link', 'bb-theme-builder' ),
		'default' => 'yes',
		'options' => array(
			'yes' => __( 'Yes', 'bb-theme-builder' ),
			'no'  => __( 'No', 'bb-theme-builder' ),
		),
	),
	'term_post_count'   => array(
		'type'    => 'select',
		'label'   => __( 'Show Post Counts', 'bb-theme-builder' ),
		'default' => 'no',
		'options' => array(
			'yes' => __( 'Yes', 'bb-theme-builder' ),
			'no'  => __( 'No', 'bb-theme-builder' ),
		),
	),
	'hide_empty'        => array(
		'type'    => 'select',
		'label'   => __( 'Hide Term if No Posts', 'bb-theme-builder' ),
		'default' => 'no',
		'options' => array(
			'yes' => __( 'Yes', 'bb-theme-builder' ),
			'no'  => __( 'No', 'bb-theme-builder' ),
		),
	),
);
$name_custom = FLPageDataACF::get_custom_fields_select( FLBuilderModel::get_post_id(), true );
if ( ! empty( $name_custom ) ) {
	$form['name_custom'] = $name_custom;
}
FLPageData::add_post_property_settings_fields( 'acf_relational', $form );
