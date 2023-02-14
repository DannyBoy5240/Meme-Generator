<?php

/**
 * Archive Title
 */
FLPageData::add_archive_property( 'title', array(
	'label'  => __( 'Archive Title', 'bb-theme-builder' ),
	'group'  => 'archives',
	'type'   => 'string',
	'getter' => 'FLPageDataArchive::get_title',
) );

/**
 * Archive Description
 */
FLPageData::add_archive_property( 'description', array(
	'label'  => __( 'Archive Description', 'bb-theme-builder' ),
	'group'  => 'archives',
	'type'   => 'string',
	'getter' => 'FLPageDataArchive::get_description',
) );

/**
 * Archive counts
 */
FLPageData::add_archive_property( 'show_count', array(
	'label'  => __( 'Archive Count (Showing 1-5 of 25.)', 'bb-theme-builder' ),
	'group'  => 'archives',
	'type'   => 'string',
	'getter' => 'FLPageDataArchive::get_count',
) );

FLPageData::add_archive_property( 'show_page_count', array(
	'label'  => __( 'Archive Page Count (Page 1 of 3.)', 'bb-theme-builder' ),
	'group'  => 'archives',
	'type'   => 'string',
	'getter' => 'FLPageDataArchive::get_page_count',
) );

/*
 * Archive Term Meta
 */
FLPageData::add_archive_property( 'term_meta', array(
	'label'  => __( 'Archive Term Meta', 'bb-theme-builder' ),
	'group'  => 'archives',
	'type'   => 'all',
	'getter' => 'FLPageDataArchive::get_term_meta',
) );

FLPageData::add_archive_property_settings_fields( 'term_meta', array(
	'key' => array(
		'type'  => 'text',
		'label' => __( 'Key', 'bb-theme-builder' ),
	),
) );
