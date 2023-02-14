<?php
/**
 ********************************************************************
 *
 * Post Properties
 *********************************************************************/


/**
 * Product Title
 */
FLPageData::add_post_property( 'bigcommerce_product_title', array(
	'label'  => __( 'Product Title', 'bb-theme-builder' ),
	'group'  => 'bigcommerce',
	'type'   => 'string',
	'getter' => 'FLPageDataBigCommerce::get_product_title',
) );


/**
 * Product Description
 */
FLPageData::add_post_property( 'bigcommerce_product_description', array(
	'label'  => __( 'Product Description', 'bb-theme-builder' ),
	'group'  => 'bigcommerce',
	'type'   => 'html',
	'getter' => 'FlPageDataBigCommerce::get_product_description',
) );


/**
 * Product Price
 */
FLPageData::add_post_property( 'bigcommerce_product_price', array(
	'label'  => __( 'Product Pricing', 'bb-theme-builder' ),
	'group'  => 'bigcommerce',
	'type'   => 'html',
	'getter' => 'FLPageDataBigCommerce::get_product_price',
) );

FLPageData::add_post_property( 'bigcommerce_product_original_price', array(
	'label'  => __( 'Product Price - Original Price', 'bb-theme-builder' ),
	'group'  => 'bigcommerce',
	'type'   => 'string',
	'getter' => 'FLPageDataBigCommerce::get_product_original_price',
) );

FLPageData::add_post_property( 'bigcommerce_product_sale_price', array(
	'label'  => __( 'Product Price - Sale Price', 'bb-theme-builder' ),
	'group'  => 'bigcommerce',
	'type'   => 'string',
	'getter' => 'FLPageDataBigCommerce::get_product_sale_price',
) );

/**
 * Product Brand
 */
FLPageData::add_post_property( 'bigcommerce_product_brand', array(
	'label'  => __( 'Product Brand', 'bb-theme-builder' ),
	'group'  => 'bigcommerce',
	'type'   => 'string',
	'getter' => 'FLPageDataBigCommerce::get_product_brand',
) );

/**
 * Product Rating
 */
FLPageData::add_post_property( 'bigcommerce_product_rating_stars_html', array(
	'label'  => __( 'Product Rating - Stars HTML', 'bb-theme-builder' ),
	'group'  => 'bigcommerce',
	'type'   => 'html',
	'getter' => 'FlPageDataBigCommerce::get_product_rating_stars_html',
) );

FLPageData::add_post_property( 'bigcommerce_product_rating_stars', array(
	'label'  => __( 'Product Rating - Stars', 'bb-theme-builder' ),
	'group'  => 'bigcommerce',
	'type'   => 'string',
	'getter' => 'FlPageDataBigCommerce::get_product_rating_stars',
) );

FLPageData::add_post_property( 'bigcommerce_product_rating_percentage', array(
	'label'  => __( 'Product Rating - Percentage', 'bb-theme-builder' ),
	'group'  => 'bigcommerce',
	'type'   => 'string',
	'getter' => 'FlPageDataBigCommerce::get_product_rating_percentage',
) );

/**
 * Cart Form
 */

FLPageData::add_post_property( 'bigcommerce_cart_button', array(
	'label'  => __( 'Add To Cart Button', 'bb-theme-builder' ),
	'group'  => 'bigcommerce',
	'type'   => 'html',
	'getter' => 'FlPageDataBigCommerce::get_cart_form',
) );

/**
 * Product Images
 */
FLPageData::add_post_property( 'bigcommerce_product_images', array(
	'label'  => __( 'Product Images', 'bb-theme-builder' ),
	'group'  => 'bigcommerce',
	'type'   => 'multiple-photos',
	'getter' => 'FLPageDataBigCommerce::get_product_images',
) );
