<?php

/**
 * Site Title
 */
FLPageData::add_site_property( 'title', array(
	'label'  => __( 'Site Title', 'bb-theme-builder' ),
	'group'  => 'site',
	'type'   => 'string',
	'getter' => 'FLPageDataSite::get_title',
) );

/**
 * Site Tagline
 */
FLPageData::add_site_property( 'tagline', array(
	'label'  => __( 'Site Tagline', 'bb-theme-builder' ),
	'group'  => 'site',
	'type'   => 'string',
	'getter' => 'FLPageDataSite::get_description',
) );

/**
 * Site URL
 */
FLPageData::add_site_property( 'url', array(
	'label'  => __( 'Site URL', 'bb-theme-builder' ),
	'group'  => 'site',
	'type'   => 'url',
	'getter' => 'FLPageDataSite::get_url',
) );

/**
 * User Name
 */
FLPageData::add_site_property( 'user_name', array(
	'label'  => __( 'User Name', 'bb-theme-builder' ),
	'group'  => 'user',
	'type'   => 'string',
	'getter' => 'FLPageDataSite::get_user_name',
) );

FLPageDataSite::add_user_settings_fields( 'user_name', array(
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
		'help'    => __( 'Link to the archive or website for this user.', 'bb-theme-builder' ),
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
 * User Bio
 */
FLPageData::add_site_property( 'user_bio', array(
	'label'  => __( 'User Bio', 'bb-theme-builder' ),
	'group'  => 'user',
	'type'   => 'string',
	'getter' => 'FLPageDataSite::get_user_bio',
) );

FLPageDataSite::add_user_settings_fields( 'user_bio' );

/**
 * User URL
 */
FLPageData::add_site_property( 'user_url', array(
	'label'  => __( 'User URL', 'bb-theme-builder' ),
	'group'  => 'user',
	'type'   => array( 'url' ),
	'getter' => 'FLPageDataSite::get_user_url',
) );

FLPageDataSite::add_user_settings_fields( 'user_url', array(
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
 * User Picture
 */
FLPageData::add_site_property( 'user_profile_picture', array(
	'label'  => __( 'User Picture', 'bb-theme-builder' ),
	'group'  => 'user',
	'type'   => array( 'string' ),
	'getter' => 'FLPageDataSite::get_user_profile_picture',
) );

FLPageDataSite::add_user_settings_fields( 'user_profile_picture', array(
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
		'help'    => __( 'Link to the archive or website for this user.', 'bb-theme-builder' ),
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
 * User Picture URL
 */
FLPageData::add_site_property( 'user_profile_picture_url', array(
	'label'  => __( 'User Picture URL', 'bb-theme-builder' ),
	'group'  => 'user',
	'type'   => array( 'photo', 'string' ),
	'getter' => 'FLPageDataSite::get_user_profile_picture_url',
) );

FLPageDataSite::add_user_settings_fields( 'user_profile_picture_url', array(
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
 * User Meta
 */
FLPageData::add_site_property( 'user_meta', array(
	'label'  => __( 'User Meta', 'bb-theme-builder' ),
	'group'  => 'user',
	'type'   => 'all',
	'getter' => 'FLPageDataSite::get_user_meta',
) );

FLPageDataSite::add_user_settings_fields( 'user_meta', array(
	'key' => array(
		'type'  => 'text',
		'label' => __( 'Key', 'bb-theme-builder' ),
	),
) );

/**
 * Is current user logged in
 * @since 1.1
 */
FLPageData::add_site_property( 'logged_in', array(
	'label'  => __( 'User Logged In', 'bb-theme-builder' ),
	'group'  => 'user',
	'type'   => 'string',
	'getter' => 'FLPageDataSite::is_user_logged_in',
) );

FLPageDataSite::add_user_settings_fields( 'logged_in', array(
	'role' => array(
		'type'  => 'text',
		'label' => __( 'Role/Roles', 'bb-theme-builder' ),
		'help'  => __( 'Comma separated list of WordPress roles, lowercase. This connection returns true or false, best used as a conditional shortcode.', 'bb-theme-builder' ),
	),
) );

/**
 * Site year
 * @since 1.1
 */
FLPageData::add_site_property( 'year', array(
	'label'  => __( 'Current Year', 'bb-theme-builder' ),
	'group'  => 'site',
	'type'   => 'string',
	'getter' => 'FLPageDataSite::get_year',
) );
FLPageData::add_site_property_settings_fields( 'year', array(
	'format' => array(
		'type'    => 'text',
		'label'   => __( 'Format', 'bb-theme-builder' ),
		'default' => 'Y',
	),
) );
