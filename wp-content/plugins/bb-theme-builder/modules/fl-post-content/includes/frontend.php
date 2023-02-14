<?php

if ( 'fl-theme-layout' !== get_post_type() ) {
	echo FLPageDataPost::get_content();
} else {
	echo sprintf( '<div style="padding: 200px 100px; text-align:center; opacity:0.5;">%s</div>', __( 'Content Area', 'bb-theme-builder' ) );
}
