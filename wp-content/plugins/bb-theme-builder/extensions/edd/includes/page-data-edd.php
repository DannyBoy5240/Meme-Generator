<?php

/**********************************************************************
 *
 * Post Properties
 *
 *********************************************************************/

/**
 * Product Title
 */
FLPageData::add_post_property( 'edd_product_title', array(
	'label'  => __( 'Product Title', 'bb-theme-builder' ),
	'group'  => 'edd',
	'type'   => 'string',
	'getter' => 'FLPageDataEDD::get_product_title',
) );

/**
 * Product Price
 */
FLPageData::add_post_property( 'edd_product_price', array(
	'label'  => __( 'Product Price', 'bb-theme-builder' ),
	'group'  => 'edd',
	'type'   => 'string',
	'getter' => 'FLPageDataEDD::get_product_price',
) );

/**
 * Product Content
 */
FLPageData::add_post_property( 'edd_product_content', array(
	'label'  => __( 'Product Content', 'bb-theme-builder' ),
	'group'  => 'edd',
	'type'   => 'string',
	'getter' => 'FLPageDataEDD::get_product_content',
) );

/**
 * Product Short Description
 */
FLPageData::add_post_property( 'edd_product_short_description', array(
	'label'  => __( 'Product Short Description', 'bb-theme-builder' ),
	'group'  => 'edd',
	'type'   => 'string',
	'getter' => 'FLPageDataEDD::get_product_short_description',
) );

/**
 * Add to Cart Button
 */
FLPageData::add_post_property( 'edd_add_to_cart_button', array(
	'label'  => __( 'Add to Cart Button', 'bb-theme-builder' ),
	'group'  => 'edd',
	'type'   => 'html',
	'getter' => 'FLPageDataEDD::get_add_to_cart_button',
) );
