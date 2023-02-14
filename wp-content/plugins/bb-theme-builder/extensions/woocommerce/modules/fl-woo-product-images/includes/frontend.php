<?php

global $product;

if ( is_object( $product ) && $product->is_on_sale() && $settings->sale_flash ) {
	echo FLPageDataWooCommerce::get_sale_flash();
}

add_filter( 'woocommerce_gallery_thumbnail_size', array( $module, 'get_thumbnail_size' ) );

echo FLPageDataWooCommerce::get_product_images();

remove_filter( 'woocommerce_gallery_thumbnail_size', array( $module, 'get_thumbnail_size' ) );
