<?php

if ( FLBuilderModel::is_builder_active() ) {
	echo sprintf( '<div style="padding: 10px; text-align:center; opacity:0.5;">%s</div>', __( 'WooCommerce Notices', 'bb-theme-builder' ) );
} else {

	$woo_notices = '';

	if ( function_exists( 'wc_notice_count' ) && wc_notice_count() > 0 ) {
		$woo_notices .= '<div class="fl-woo-notices">';
		$woo_notices .= wc_print_notices( true );
		$woo_notices .= '</div>';
	}

	echo $woo_notices;

}
