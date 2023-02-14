<?php

/**
 * BigCommerce singular support for the theme builder.
 */
final class FLThemeBuilderBigCommerceSingular {

	/**
	 * @return void
	 */
	static public function init() {
		add_filter( 'fl_render_content_by_id_attrs', __CLASS__ . '::content_attrs' );
	}

	/**
	 * @param array $attrs
	 * @return array
	 */
	static public function content_attrs( $attrs ) {
		if ( is_singular() && 'bigcommerce_product' === get_post_type() ) {
			$attrs['data-js'] = 'bc-product-data-wrapper';
			return $attrs;
		}
		return $attrs;
	}
}

FLThemeBuilderBigCommerceSingular::init();
