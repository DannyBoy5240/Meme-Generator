<?php
global $wp_the_query;
if ( 'fl-theme-layout' === $wp_the_query->query_vars['post_type'] ) {
	add_filter( 'fl_builder_insert_layout_render', '__return_false' );
}
echo FLPageDataWooCommerce::get_product_tabs();
remove_filter( 'fl_builder_insert_layout_render', '__return_false' );
