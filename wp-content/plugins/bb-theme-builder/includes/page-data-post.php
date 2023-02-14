<?php

/**
 * Post Title
 */
FLPageData::add_post_property( 'title', array(
	'label'       => __( 'Post Title', 'bb-theme-builder' ),
	'group'       => 'posts',
	'type'        => 'string',
	'getter'      => 'get_the_title',
	'placeholder' => 'Lorem Ipsum Dolor',
) );

/**
 * Post ID
 */
FLPageData::add_post_property( 'id', array(
	'label'  => __( 'Post ID', 'bb-theme-builder' ),
	'group'  => 'posts',
	'type'   => 'string',
	'getter' => 'FLPageDataPost::get_id',
) );

/**
 * Post Parent
 */
FLPageData::add_post_property( 'parent', array(
	'label'  => __( 'Post Parent', 'bb-theme-builder' ),
	'group'  => 'posts',
	'type'   => 'string',
	'getter' => 'FLPageDataPost::get_parent',
) );

FLPageData::add_post_property_settings_fields( 'parent', array(
	'display' => array(
		'type'    => 'select',
		'label'   => __( 'Display', 'bb-theme-builder' ),
		'default' => 'tag',
		'options' => array(
			'id'             => __( 'ID', 'bb-theme-builder' ),
			'url'            => __( 'URL', 'bb-theme-builder' ),
			'title'          => __( 'Title', 'bb-theme-builder' ),
			'content'        => __( 'Content', 'bb-theme-builder' ),
			'featured_image' => __( 'Featured Image', 'bb-theme-builder' ),
		),
		'toggle'  => array(
			'featured_image' => array(
				'fields' => array( 'size' ),
			),
		),
	),
	'size'    => array(
		'type'    => 'photo-sizes',
		'label'   => __( 'Size', 'bb-theme-builder' ),
		'default' => 'thumbnail',
	),
) );

/**
 * Post Excerpt
 */
FLPageData::add_post_property( 'excerpt', array(
	'label'       => __( 'Post Excerpt', 'bb-theme-builder' ),
	'group'       => 'posts',
	'type'        => 'string',
	'getter'      => 'FLPageDataPost::get_excerpt',
	'placeholder' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit...',
) );

FLPageData::add_post_property_settings_fields( 'excerpt', array(
	'length' => array(
		'type'        => 'text',
		'label'       => __( 'Length', 'bb-theme-builder' ),
		'default'     => '55',
		'size'        => '5',
		'description' => __( 'Words', 'bb-theme-builder' ),
		'placeholder' => '55',
	),
	'more'   => array(
		'type'        => 'text',
		'label'       => __( 'More Text', 'bb-theme-builder' ),
		'placeholder' => '...',
	),
) );

/**
 * Post Content
 */
FLPageData::add_post_property( 'content', array(
	'label'       => __( 'Post Content', 'bb-theme-builder' ),
	'group'       => 'posts',
	'type'        => 'string',
	'getter'      => 'FLPageDataPost::get_content',
	'placeholder' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas tempor arcu nisl. Sed ac tempus nulla.',
) );

/**
 * Post Link
 */
FLPageData::add_post_property( 'link', array(
	'label'  => __( 'Post Link', 'bb-theme-builder' ),
	'group'  => 'posts',
	'type'   => array( 'string' ),
	'getter' => 'FLPageDataPost::get_link',
) );

FLPageData::add_post_property_settings_fields( 'link', array(
	'text'        => array(
		'type'    => 'select',
		'label'   => __( 'Link Text', 'bb-theme-builder' ),
		'default' => 'title',
		'options' => array(
			'title'  => __( 'Post Title', 'bb-theme-builder' ),
			'custom' => __( 'Custom', 'bb-theme-builder' ),
		),
		'toggle'  => array(
			'custom' => array(
				'fields' => array( 'custom_text' ),
			),
		),
	),
	'custom_text' => array(
		'type'    => 'text',
		'label'   => __( 'Custom Text', 'bb-theme-builder' ),
		'default' => __( 'Read More...', 'bb-theme-builder' ),
	),
) );

/**
 * Post URL
 */
FLPageData::add_post_property( 'url', array(
	'label'  => __( 'Post URL', 'bb-theme-builder' ),
	'group'  => 'posts',
	'type'   => array( 'url' ),
	'getter' => 'get_permalink',
) );

/**
 * Post ID
 */
FLPageData::add_post_property( 'slug', array(
	'label'  => __( 'Post Slug', 'bb-theme-builder' ),
	'group'  => 'posts',
	'type'   => 'string',
	'getter' => 'FLPageDataPost::get_slug',
) );

/**
 * Post Date
 */
FLPageData::add_post_property( 'date', array(
	'label'  => __( 'Post Date', 'bb-theme-builder' ),
	'group'  => 'posts',
	'type'   => 'string',
	'getter' => 'FLPageDataPost::get_date',
) );

FLPageData::add_post_property_settings_fields( 'date', array(
	'format' => array(
		'type'    => 'select',
		'label'   => __( 'Date Format', 'bb-theme-builder' ),
		'default' => '',
		'options' => array(
			''       => __( 'Default', 'bb-theme-builder' ),
			'M j, Y' => gmdate( 'M j, Y' ),
			'F j, Y' => gmdate( 'F j, Y' ),
			'm/d/Y'  => gmdate( 'm/d/Y' ),
			'm-d-Y'  => gmdate( 'm-d-Y' ),
			'd M Y'  => gmdate( 'd M Y' ),
			'd F Y'  => gmdate( 'd F Y' ),
			'Y-m-d'  => gmdate( 'Y-m-d' ),
			'Y/m/d'  => gmdate( 'Y/m/d' ),
		),
	),
) );

/**
 * Post Modified Date
 */
FLPageData::add_post_property( 'modified_date', array(
	'label'  => __( 'Post Modified Date', 'bb-theme-builder' ),
	'group'  => 'posts',
	'type'   => 'string',
	'getter' => 'FLPageDataPost::get_modified_date',
) );

FLPageData::add_post_property_settings_fields( 'modified_date', array(
	'format' => array(
		'type'    => 'select',
		'label'   => __( 'Modified Date Format', 'bb-theme-builder' ),
		'default' => '',
		'options' => array(
			''       => __( 'Default', 'bb-theme-builder' ),
			'M j, Y' => gmdate( 'M j, Y' ),
			'F j, Y' => gmdate( 'F j, Y' ),
			'm/d/Y'  => gmdate( 'm/d/Y' ),
			'm-d-Y'  => gmdate( 'm-d-Y' ),
			'd M Y'  => gmdate( 'd M Y' ),
			'd F Y'  => gmdate( 'd F Y' ),
			'Y-m-d'  => gmdate( 'Y-m-d' ),
			'Y/m/d'  => gmdate( 'Y/m/d' ),
			'human'  => __( '3 days ago', 'bb-theme-builder' ),
		),
	),
) );

/**
 * Post Featured Image
 */
FLPageData::add_post_property( 'featured_image', array(
	'label'  => __( 'Post Featured Image', 'bb-theme-builder' ),
	'group'  => 'posts',
	'type'   => 'string',
	'getter' => 'FLPageDataPost::get_featured_image',
) );

FLPageData::add_post_property_settings_fields( 'featured_image', array(
	'size'    => array(
		'type'    => 'photo-sizes',
		'label'   => __( 'Size', 'bb-theme-builder' ),
		'default' => 'thumbnail',
	),
	'display' => array(
		'type'    => 'select',
		'label'   => __( 'Display', 'bb-theme-builder' ),
		'default' => 'tag',
		'options' => array(
			'tag'         => __( 'Image Tag', 'bb-theme-builder' ),
			'url'         => __( 'URL', 'bb-theme-builder' ),
			'title'       => __( 'Title', 'bb-theme-builder' ),
			'caption'     => __( 'Caption', 'bb-theme-builder' ),
			'description' => __( 'Description', 'bb-theme-builder' ),
			'alt'         => __( 'Alt Text', 'bb-theme-builder' ),
		),
		'toggle'  => array(
			'tag' => array(
				'fields' => array( 'linked', 'align', 'size' ),
			),
			'url' => array(
				'fields' => array( 'size' ),
			),
		),
	),
	'align'   => array(
		'type'    => 'select',
		'label'   => __( 'Alignment', 'bb-theme-builder' ),
		'default' => 'default',
		'options' => array(
			'default' => __( 'Default', 'bb-theme-builder' ),
			'left'    => __( 'Left', 'bb-theme-builder' ),
			'center'  => __( 'Center', 'bb-theme-builder' ),
			'right'   => __( 'Right', 'bb-theme-builder' ),
		),
	),
	'linked'  => array(
		'type'    => 'select',
		'label'   => __( 'Linked', 'bb-theme-builder' ),
		'default' => 'yes',
		'options' => array(
			'yes' => __( 'Yes', 'bb-theme-builder' ),
			'no'  => __( 'No', 'bb-theme-builder' ),
		),
		'help'    => __( 'Link the image to the post.', 'bb-theme-builder' ),
	),
) );

/**
 * Post Featured Image URL
 */
FLPageData::add_post_property( 'featured_image_url', array(
	'label'  => __( 'Post Featured Image', 'bb-theme-builder' ),
	'group'  => 'posts',
	'type'   => 'photo',
	'getter' => 'FLPageDataPost::get_featured_image_url',
) );

FLPageData::add_post_property_settings_fields( 'featured_image_url', array(
	'size'        => array(
		'type'    => 'photo-sizes',
		'label'   => __( 'Size', 'bb-theme-builder' ),
		'default' => 'thumbnail',
	),
	'default_img' => array(
		'type'  => 'photo',
		'label' => __( 'Default Image', 'bb-theme-builder' ),
	),
) );

/**
 * Post Attached Images
 */
FLPageData::add_post_property( 'attached_images', array(
	'label'  => __( 'Post Attached Images', 'bb-theme-builder' ),
	'group'  => 'posts',
	'type'   => 'multiple-photos',
	'getter' => 'FLPageDataPost::get_attached_images',
) );

/**
 * Post Terms List
 */
FLPageData::add_post_property( 'terms_list', array(
	'label'  => __( 'Post Terms List', 'bb-theme-builder' ),
	'group'  => 'posts',
	'type'   => array( 'string' ),
	'getter' => 'FLPageDataPost::get_terms_list',
) );

FLPageData::add_post_property_settings_fields( 'terms_list', array(
	'taxonomy'  => array(
		'type'    => 'select',
		'label'   => __( 'Taxonomy', 'bb-theme-builder' ),
		'default' => 'category',
		'options' => FLPageDataPost::get_taxonomy_options(),
	),
	'html_list' => array(
		'type'    => 'select',
		'label'   => __( 'Layout', 'bb-theme-builder' ),
		'default' => 'no',
		'options' => array(
			'no'  => __( 'Use Separator', 'bb-theme-builder' ),
			'ol'  => __( 'Ordered List', 'bb-theme-builder' ),
			'ul'  => __( 'Unordered List', 'bb-theme-builder' ),
			'div' => __( 'Div / Spans', 'bb-theme-builder' ),
		),
		'toggle'  => array(
			'no' => array(
				'fields' => array( 'separator' ),
			),
		),
	),
	'display'   => array(
		'type'    => 'select',
		'label'   => __( 'Display', 'bb-theme-builder' ),
		'default' => 'name',
		'options' => array(
			'name' => __( 'Name', 'bb-theme-builder' ),
			'slug' => __( 'Slug', 'bb-theme-builder' ),
		),
	),
	'separator' => array(
		'type'    => 'text',
		'label'   => __( 'Separator', 'bb-theme-builder' ),
		'default' => __( ', ', 'bb-theme-builder' ),
	),
	'limit'     => array(
		'type'        => 'text',
		'placeholder' => '3',
		'label'       => __( 'Limit', 'bb-theme-builder' ),
		'default'     => '',
		'help'        => __( 'Limit number of terms returned.', 'bb-theme-builder' ),
	),
	'linked'    => array(
		'type'    => 'select',
		'label'   => __( 'Linked', 'bb-theme-builder' ),
		'default' => 'yes',
		'options' => array(
			'yes' => __( 'Yes', 'bb-theme-builder' ),
			'no'  => __( 'No', 'bb-theme-builder' ),
		),
		'help'    => __( 'Link terms to their archive page.', 'bb-theme-builder' ),
	),
) );

/**
 * Comments Number
 */
FLPageData::add_post_property( 'comments_number', array(
	'label'  => __( 'Comments Number', 'bb-theme-builder' ),
	'group'  => 'comments',
	'type'   => 'string',
	'getter' => 'FLPageDataPost::get_comments_number',
) );

FLPageData::add_post_property_settings_fields( 'comments_number', array(
	'link'      => array(
		'type'    => 'select',
		'label'   => __( 'Link', 'bb-theme-builder' ),
		'default' => 'yes',
		'options' => array(
			'yes' => __( 'Yes', 'bb-theme-builder' ),
			'no'  => __( 'No', 'bb-theme-builder' ),
		),
		'help'    => __( 'Link the comments text to the comments section for this post.', 'bb-theme-builder' ),
	),
	'none_text' => array(
		'type'    => 'text',
		'label'   => __( 'No Comments Text', 'bb-theme-builder' ),
		'default' => __( 'No Comments', 'bb-theme-builder' ),
	),
	'one_text'  => array(
		'type'    => 'text',
		'label'   => __( 'One Comment Text', 'bb-theme-builder' ),
		'default' => __( '1 Comment', 'bb-theme-builder' ),
	),
	'more_text' => array(
		'type'    => 'text',
		'label'   => __( 'Comments Text', 'bb-theme-builder' ),
		'default' => __( '% Comments', 'bb-theme-builder' ),
	),
) );

/**
 * Comments URL
 */
FLPageData::add_post_property( 'comments_url', array(
	'label'  => __( 'Comments URL', 'bb-theme-builder' ),
	'group'  => 'comments',
	'type'   => array( 'url' ),
	'getter' => 'FLPageDataPost::get_comments_url',
) );

/**
 * Author Name
 */
FLPageData::add_post_property( 'author_name', array(
	'label'  => __( 'Author Name', 'bb-theme-builder' ),
	'group'  => 'author',
	'type'   => 'string',
	'getter' => 'FLPageDataPost::get_author_name',
) );

FLPageData::add_post_property_settings_fields( 'author_name', array(
	'type'      => array(
		'type'    => 'select',
		'label'   => __( 'Type', 'bb-theme-builder' ),
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
	'link'      => array(
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
	'link_type' => array(
		'type'    => 'select',
		'label'   => __( 'Link Type', 'bb-theme-builder' ),
		'default' => 'archive',
		'options' => array(
			'archive' => __( 'Post Archive', 'bb-theme-builder' ),
			'website' => __( 'Website', 'bb-theme-builder' ),
		),
	),
) );

/**
 * Author Bio
 */
FLPageData::add_post_property( 'author_bio', array(
	'label'  => __( 'Author Bio', 'bb-theme-builder' ),
	'group'  => 'author',
	'type'   => 'string',
	'getter' => 'FLPageDataPost::get_author_bio',
) );

/**
 * Author URL
 */
FLPageData::add_post_property( 'author_url', array(
	'label'  => __( 'Author URL', 'bb-theme-builder' ),
	'group'  => 'author',
	'type'   => array( 'url' ),
	'getter' => 'FLPageDataPost::get_author_url',
) );

FLPageData::add_post_property_settings_fields( 'author_url', array(
	'type' => array(
		'type'    => 'select',
		'label'   => __( 'Type', 'bb-theme-builder' ),
		'default' => 'archive',
		'options' => array(
			'archive' => __( 'Post Archive', 'bb-theme-builder' ),
			'website' => __( 'Website', 'bb-theme-builder' ),
		),
	),
) );

/**
 * Author Picture
 */
FLPageData::add_post_property( 'author_profile_picture', array(
	'label'  => __( 'Author Picture', 'bb-theme-builder' ),
	'group'  => 'author',
	'type'   => array( 'string' ),
	'getter' => 'FLPageDataPost::get_author_profile_picture',
) );

FLPageData::add_post_property_settings_fields( 'author_profile_picture', array(
	'link'      => array(
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
	'link_type' => array(
		'type'    => 'select',
		'label'   => __( 'Link Type', 'bb-theme-builder' ),
		'default' => 'archive',
		'options' => array(
			'archive' => __( 'Post Archive', 'bb-theme-builder' ),
			'website' => __( 'Website', 'bb-theme-builder' ),
		),
	),
	'size'      => array(
		'type'        => 'text',
		'label'       => __( 'Size', 'bb-theme-builder' ),
		'default'     => '100',
		'size'        => '5',
		'description' => 'px',
		'placeholder' => '512',
	),
) );

/**
 * Author Picture URL
 */
FLPageData::add_post_property( 'author_profile_picture_url', array(
	'label'  => __( 'Author Picture URL', 'bb-theme-builder' ),
	'group'  => 'author',
	'type'   => array( 'photo', 'string' ),
	'getter' => 'FLPageDataPost::get_author_profile_picture_url',
) );

FLPageData::add_post_property_settings_fields( 'author_profile_picture_url', array(
	'size'        => array(
		'type'        => 'text',
		'label'       => __( 'Size', 'bb-theme-builder' ),
		'default'     => '100',
		'size'        => '5',
		'description' => 'px',
		'placeholder' => '512',
	),
	'default_img' => array(
		'type'  => 'photo',
		'label' => __( 'Default Image', 'bb-theme-builder' ),
	),
) );

/**
 * Author Meta
 */
FLPageData::add_post_property( 'author_meta', array(
	'label'  => __( 'Author Meta', 'bb-theme-builder' ),
	'group'  => 'author',
	'type'   => 'all',
	'getter' => 'FLPageDataPost::get_author_meta',
) );

FLPageData::add_post_property_settings_fields( 'author_meta', array(
	'key' => array(
		'type'  => 'text',
		'label' => __( 'Key', 'bb-theme-builder' ),
	),
) );

/**
 * Custom Field
 */
FLPageData::add_post_property( 'custom_field', array(
	'label'  => __( 'Post Custom Field', 'bb-theme-builder' ),
	'group'  => 'posts',
	'type'   => 'all',
	'getter' => 'FLPageDataPost::get_custom_field',
) );

FLPageData::add_post_property_settings_fields( 'custom_field', array(
	'key' => array(
		'type'  => 'text',
		'label' => __( 'Key', 'bb-theme-builder' ),
	),
) );
