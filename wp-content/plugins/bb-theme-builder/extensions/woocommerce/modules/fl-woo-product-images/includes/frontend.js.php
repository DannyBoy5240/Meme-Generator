<?php
if ( FLBuilderModel::is_builder_active() ) { ?>

	jQuery(function ($) {
		// wc_single_product_params is required to continue.
		if (typeof wc_single_product_params === 'undefined') {
			return false;
		}

		$('.woocommerce-product-gallery').each(function () {
			$(this).trigger('wc-product-gallery-before-init', [this, wc_single_product_params]);
			$(this).wc_product_gallery(wc_single_product_params);
			$(this).trigger('wc-product-gallery-after-init', [this, wc_single_product_params]);
		});
	});

	<?php
}
