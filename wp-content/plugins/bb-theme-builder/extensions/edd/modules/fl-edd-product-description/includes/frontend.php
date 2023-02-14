<?php

if ( 'short' == $settings->description_type ) {
	edd_get_template_part( 'shortcode', 'content-excerpt' );
} else {
	edd_get_template_part( 'shortcode', 'content-full' );
}

do_action( 'edd_download_after_content' );
